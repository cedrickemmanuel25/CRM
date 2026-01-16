<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Contact;
use App\Models\Opportunity;
use App\Models\Activity;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        $data = [
            'role' => $user->role,
            'kpis' => [],
            'charts' => [],
            'lists' => [],
        ];

        if ($user->isAdmin()) {
            $data = $this->getAdminStats($data);
            $viewName = 'admin.dashboard';
        } elseif ($user->isCommercial()) {
            $data = $this->getCommercialStats($user, $data);
            $viewName = 'commercial.dashboard';
        } elseif ($user->isSupport()) {
            $data = $this->getSupportStats($user, $data);
            $viewName = 'support.dashboard';
        } else {
            $viewName = 'dashboard';
            // Default safe data to avoid crashes if role unknown
            if (empty($data['kpis'])) {
                $data = $this->getAdminStats($data);
            }
        }

        if ($request->wantsJson()) {
            return response()->json($data);
        }

        return view($viewName, ['data' => $data]);
    }

    private function getAdminStats(array $data)
    {
        // KPIs
        $data['kpis'] = [
            'total_leads_opps' => Opportunity::inProgress()->count(),
            'global_forecast_revenue' => Opportunity::inProgress()->sum('montant_estime'),
            'contacts_count' => Contact::count(),
            'pending_tasks_count' => \App\Models\Task::where('statut', '!=', 'done')->count(),
            'avg_conversion_rate' => $this->calculateConversionRate(),
        ];

        // 1. Pipeline by Stage (Ensure all stages exist)
        $rawPipeline = Opportunity::select('stade', DB::raw('count(*) as count'), DB::raw('sum(montant_estime) as total_amount'))
            ->groupBy('stade')
            ->get()
            ->keyBy('stade');

        $stages = ['prospection', 'qualification', 'proposition', 'negociation', 'gagne', 'perdu'];
        $data['charts']['pipeline_by_stage'] = collect($stages)->map(function ($stage) use ($rawPipeline) {
            $record = $rawPipeline->get($stage);
            return (object) [
                'stade' => $stage,
                'count' => $record ? $record->count : 0,
                'total_amount' => $record ? $record->total_amount : 0,
            ];
        });

        // 2. Distribution by Status (Totals)
        $rawTrend = Opportunity::select(
                'stade',
                DB::raw('count(*) as total')
            )
            ->groupBy('stade')
            ->get()
            ->keyBy('stade');

        $stages = ['prospection', 'qualification', 'proposition', 'negociation', 'gagne', 'perdu'];
        
        $structuredTrend = [];
        foreach ($stages as $stage) {
            $structuredTrend[$stage] = (int) ($rawTrend->get($stage)->total ?? 0);
        }

        $data['charts']['revenue_trend'] = $structuredTrend;

        $data['lists'] = [
            'recent_activities' => Activity::with(['user', 'parent'])->latest()->take(10)->get(),
            'commercial_performance' => $this->getCommercialPerformance(),
            'latest_opportunities' => Opportunity::with('contact')->latest()->take(6)->get(),
            'tasks' => \App\Models\Task::where('statut', '!=', 'done')->latest()->take(5)->get(),
            'overdue_tasks' => \App\Models\Task::with(['related', 'assignee'])
                ->where('statut', '!=', 'done')
                ->where('due_date', '<', now())
                ->orderBy('due_date', 'asc')
                ->take(5)
                ->get(),
            'latest_users' => User::latest()->take(5)->get(),
        ];

        return $data;
    }

    private function getCommercialStats(User $user, array $data)
    {
        // KPIs
        $data['kpis'] = [
            'my_leads_opps' => Opportunity::byCommercial($user->id)->inProgress()->count(),
            'my_forecast_revenue' => Opportunity::byCommercial($user->id)->inProgress()->sum('montant_estime'),
            'my_conversion_rate' => $this->calculateConversionRate($user->id),
            'tasks_due_today' => \App\Models\Task::where('assigned_to', $user->id)
                ->where('statut', '!=', 'done')
                ->whereDate('due_date', today())
                ->count(),
            'tasks_overdue' => \App\Models\Task::where('assigned_to', $user->id)
                ->where('statut', '!=', 'done')
                ->where('due_date', '<', now())
                ->count(),
        ];
        $data['kpis']['goal_percentage'] = $this->calculateGoalPercentage($user->id);

        // My Pipeline by Stage
        $data['charts']['pipeline_by_stage'] = Opportunity::byCommercial($user->id)
            ->select('stade', DB::raw('count(*) as count'), DB::raw('sum(montant_estime) as total_amount'))
            ->groupBy('stade')
            ->orderByRaw("FIELD(stade, 'prospection', 'qualification', 'proposition', 'negociation', 'gagne', 'perdu')")
            ->get();

        $data['lists'] = [
            'recent_activities' => Activity::with('parent')->where('user_id', $user->id)->latest()->take(5)->get(),
            'hot_opportunities' => Opportunity::byCommercial($user->id)->whereIn('stade', ['proposition', 'negociation'])->latest()->take(5)->get(),
            'tasks' => \App\Models\Task::where('assigned_to', $user->id)->where('statut', '!=', 'done')->latest()->take(5)->get(),
            'overdue_tasks' => \App\Models\Task::with(['related', 'assignee'])
                ->where('assigned_to', $user->id)
                ->where('statut', '!=', 'done')
                ->where('due_date', '<', now())
                ->orderBy('due_date', 'asc')
                ->take(5)
                ->get(),
            'next_meetings' => Activity::where('user_id', $user->id)
                ->where('type', 'meeting')
                ->where('date_activite', '>', now())
                ->orderBy('date_activite', 'asc')
                ->take(5)
                ->get(),
        ];

        return $data;
    }

    private function getSupportStats(User $user, array $data)
    {
        $data['kpis'] = [
            'tickets_in_progress' => \App\Models\Ticket::where('status', '!=', 'resolved')->count(),
            'interactions_in_progress' => Activity::where('type', 'interaction')->where('statut', '!=', 'termine')->count(),
            'resolved_today' => \App\Models\Ticket::where('status', 'resolved')->whereDate('updated_at', today())->count(),
        ];

        $data['lists'] = [
            'recent_tickets' => \App\Models\Ticket::with(['contact', 'assignee'])->latest()->take(10)->get(),
            'active_contacts' => Contact::whereHas('activities', function($q) {
                $q->where('date_activite', '>=', now()->subDays(7));
            })->orWhereHas('tickets', function($q) {
                $q->where('created_at', '>=', now()->subDays(7));
            })->latest()->take(10)->get(),
            'tasks' => \App\Models\Task::where('assigned_to', $user->id)->where('statut', '!=', 'done')->latest()->take(5)->get(),
            'overdue_tasks' => \App\Models\Task::with(['related', 'assignee'])
                ->where('assigned_to', $user->id)
                ->where('statut', '!=', 'done')
                ->where('due_date', '<', now())
                ->orderBy('due_date', 'asc')
                ->take(5)
                ->get(),
            'recent_activities' => Activity::with(['user', 'parent'])->whereDate('date_activite', today())->latest()->get(),
        ];
        
        $data['contacts'] = Contact::orderBy('nom')->get();

        return $data;
    }

    private function calculateConversionRate($userId = null)
    {
        $query = Opportunity::query();
        if ($userId) {
            $query->where('commercial_id', $userId);
        }

        $won = (clone $query)->where('stade', 'gagne')->count();
        $lost = (clone $query)->where('stade', 'perdu')->count();
        $totalClosed = $won + $lost;

        return $totalClosed > 0 ? round(($won / $totalClosed) * 100, 1) : 0;
    }



    private function calculateGoalPercentage($userId)
    {
        $target = 50_000;
        $actual = Opportunity::byCommercial($userId)
            ->where('stade', 'gagne')
            ->whereMonth('created_at', now()->month)
            ->sum('montant_estime');
        
        return $target > 0 ? min(100, round(($actual / $target) * 100)) : 0;
    }

    private function getCommercialPerformance()
    {
        return User::where('role', 'commercial')
            ->withCount(['opportunities as won_deals_count' => function($q) {
                $q->where('stade', 'gagne');
            }])
            ->withSum(['opportunities as pipeline_value' => function($q) {
                 $q->whereNotIn('stade', ['gagne', 'perdu']);
            }], 'montant_estime')
            ->get();
    }
}
