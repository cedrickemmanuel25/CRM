@extends('layouts.app')

@section('title', 'Ventes - Nexus CRM')

@section('content')
<style>
    :root {
        --saas-bg: #0f172a;
        --saas-card: rgba(30, 41, 59, 0.4);
        --saas-border: rgba(255, 255, 255, 0.08);
    }

    .saas-card {
        background: var(--saas-card);
        backdrop-filter: blur(20px);
        border: 1px solid var(--saas-border);
        border-radius: 1rem;
        transition: all 0.3s ease;
    }

    .saas-card:hover { border-color: rgba(255, 255, 255, 0.12); transform: translateY(-2px); }

    .label-caps {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #64748b;
        margin-bottom: 0.75rem;
        display: block;
    }

    .metric-value {
        font-size: 2rem;
        font-weight: 700;
        color: #f1f5f9;
        letter-spacing: -0.02em;
    }

    .btn-action {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #94a3b8;
        font-size: 11px;
        font-weight: 600;
    }

    .btn-action:hover { background: #fff; color: #020617; border-color: #fff; }

    .saas-scroll::-webkit-scrollbar { width: 4px; }
    .saas-scroll::-webkit-scrollbar-track { background: transparent; }
    .saas-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
</style>

<div class="max-w-[1400px] mx-auto space-y-10 pb-16">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 pb-6 border-b border-white/5">
        <div>
            <h1 class="page-title">Tableau de Bord <span class="accent">Commercial</span></h1>
            <p class="text-slate-500 text-sm mt-1 font-medium">Suivi de performance et pilotage du pipeline</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('activities.index') }}" class="btn-action px-6 py-2.5 rounded-lg flex items-center gap-2">Journal</a>
            <a href="{{ route('tasks.create') }}" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg text-xs font-bold hover:bg-blue-500 transition-all shadow-lg shadow-blue-600/20">Action Rapide</a>
        </div>
    </div>

    <!-- KPI Layer -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="saas-card p-6">
            <span class="label-caps">C.A. Prévisionnel</span>
            <div class="flex items-end justify-between">
                <span class="metric-value font-bold text-blue-500">{{ format_currency($data['kpis']['my_forecast_revenue']) }}</span>
                <span class="text-[10px] font-bold {{ $data['kpis']['my_forecast_change'] >= 0 ? 'text-emerald-500' : 'text-rose-500' }}">
                    {{ $data['kpis']['my_forecast_change'] >= 0 ? '↑' : '↓' }} {{ abs($data['kpis']['my_forecast_change']) }}%
                </span>
            </div>
        </div>
        <div class="saas-card p-6">
            <span class="label-caps">Opportunités</span>
            <span class="metric-value">{{ $data['kpis']['my_leads_opps'] }}</span>
        </div>
        <div class="saas-card p-6">
            <span class="label-caps">Indice de Conversion</span>
            <div class="flex items-end justify-between">
                <span class="metric-value">{{ $data['kpis']['my_conversion_rate'] }}%</span>
                <div class="w-16 h-1 bg-white/5 rounded-full mb-2">
                    <div class="h-full bg-emerald-500" style="width: {{ $data['kpis']['my_conversion_rate'] }}%"></div>
                </div>
            </div>
        </div>
        <div class="saas-card p-6 border-l-2 border-l-rose-500/50">
            <span class="label-caps text-rose-500/70">Retards</span>
            <div class="flex items-end justify-between">
                <span class="metric-value {{ $data['kpis']['tasks_overdue'] > 0 ? 'text-rose-500' : 'text-slate-400' }}">{{ $data['kpis']['tasks_overdue'] }}</span>
            </div>
        </div>
    </div>

    <!-- Mid Layer: Analytics & Goals -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Funnel Analysis -->
        <div class="saas-card p-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-lg font-bold text-slate-200 uppercase tracking-tight">Analyse du Pipeline</h3>
                    <p class="text-[11px] font-bold text-slate-500 uppercase mt-1">Répartition par étape</p>
                </div>
            </div>
            <div class="space-y-6">
                @php $stages = $data['charts']['pipeline_by_stage']; @endphp
                @foreach($stages as $index => $stage)
                <div class="group">
                    <div class="flex justify-between items-center text-xs font-bold mb-2">
                        <span class="text-slate-400 uppercase tracking-wider">{{ $stage->stade }}</span>
                        <span class="text-white">{{ format_currency($stage->total_amount) }}</span>
                    </div>
                    <div class="w-full bg-white/5 h-2 rounded-full overflow-hidden">
                        @php $percent = (($data['kpis']['my_forecast_revenue'] ?? 0) > 0) ? ($stage->total_amount / $data['kpis']['my_forecast_revenue']) * 100 : 20; @endphp
                        <div class="h-full bg-blue-600/80 group-hover:bg-blue-500 transition-all duration-500" style="width: {{ max(5, $percent) }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Quota Tracker -->
        <div class="saas-card p-8 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-slate-200 uppercase tracking-tight">Quota Mensuel</h3>
                    <p class="text-[11px] font-bold text-slate-500 uppercase mt-1">Progression vers l'objectif</p>
                </div>
                <span class="text-3xl font-bold text-blue-500">{{ $data['kpis']['goal_percentage'] }}%</span>
            </div>
            
            <div class="py-10">
                <div class="w-full bg-slate-800 h-4 rounded-full overflow-hidden mb-4">
                    <div class="h-full bg-blue-600 rounded-full transition-all duration-1000 shadow-[0_0_15px_rgba(37,99,235,0.2)]" style="width: {{ $data['kpis']['goal_percentage'] }}%"></div>
                </div>
                <div class="flex justify-between text-[11px] font-bold text-slate-500">
                    <span>{{ format_currency($data['kpis']['my_forecast_revenue']) }} réalisé</span>
                    <span>Objectif: {{ format_currency($data['kpis']['sales_quota']) }}</span>
                </div>
            </div>

            <div id="quotaSubChart" class="h-32 mt-4"></div>
        </div>
    </div>

    <!-- Bottom Layer: Operational Data -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Reminders -->
        <div class="saas-card overflow-hidden">
            <div class="px-6 py-4 border-b border-white/5 bg-white/[0.01]">
                <h3 class="label-caps mb-0">Rappels</h3>
            </div>
            <div class="p-6 space-y-4 saas-scroll max-h-[280px] overflow-y-auto">
                @forelse($data['lists']['tasks'] as $task)
                <div class="flex gap-4 group">
                    <div class="w-1 h-1 rounded-full {{ $task->due_date < now() ? 'bg-rose-500' : 'bg-blue-500' }} mt-2 shrink-0"></div>
                    <div class="min-w-0">
                        <p class="text-xs font-semibold text-slate-200 group-hover:text-blue-400 transition-colors truncate">{{ $task->titre }}</p>
                        <p class="text-[10px] text-slate-500 mt-1 font-bold italic">{{ $task->due_date->translatedFormat('d M') }}</p>
                    </div>
                </div>
                @empty
                <p class="text-[11px] text-slate-500 py-4 text-center">Aucun rappel</p>
                @endforelse
            </div>
        </div>

        <!-- Priorities -->
        <div class="saas-card overflow-hidden">
            <div class="px-6 py-4 border-b border-white/5 bg-white/[0.01]">
                <h3 class="label-caps mb-0">Priorités</h3>
            </div>
            <div class="p-6 space-y-4">
                @forelse($data['lists']['hot_opportunities'] as $opp)
                <div class="flex items-center gap-4">
                    <div class="w-7 h-7 rounded bg-blue-500/10 border border-blue-500/20 flex items-center justify-center font-bold text-blue-500 text-xs">
                        {{ substr($opp->titre, 0, 1) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-semibold text-slate-200 truncate">{{ $opp->titre }}</p>
                        <p class="text-[10px] font-bold text-emerald-500 mt-0.5">{{ format_currency($opp->montant_estime) }}</p>
                    </div>
                </div>
                @empty
                <p class="text-[11px] text-slate-500 py-4 text-center">Néant</p>
                @endforelse
            </div>
        </div>

        <!-- Meetings -->
        <div class="saas-card overflow-hidden">
            <div class="px-6 py-4 border-b border-white/5 bg-white/[0.01]">
                <h3 class="label-caps mb-0">Rendez-vous</h3>
            </div>
            <div class="p-6 space-y-4">
                @forelse($data['lists']['next_meetings'] as $meeting)
                <div class="border-l-2 border-blue-500/50 pl-4 py-1">
                    <p class="text-[10px] text-blue-400 font-bold uppercase tracking-wider">{{ $meeting->date_activite->translatedFormat('d M H:i') }}</p>
                    <p class="text-xs text-slate-300 font-semibold mt-1 line-clamp-2 leading-relaxed">{{ $meeting->description ?? 'Réunion Client' }}</p>
                </div>
                @empty
                <p class="text-[11px] text-slate-500 py-4 text-center">Agenda libre</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="saas-card overflow-hidden">
            <div class="px-6 py-4 border-b border-white/5 bg-white/[0.01]">
                <h3 class="label-caps mb-0">Activités</h3>
            </div>
            <div class="p-6 space-y-4">
                @forelse($data['lists']['recent_activities'] as $activity)
                <div class="flex gap-4">
                    <div class="w-1 h-1 rounded-full bg-slate-700 mt-2 shrink-0"></div>
                    <div class="min-w-0">
                        <p class="text-[11px] font-medium text-slate-300 line-clamp-2 leading-relaxed">{{ $activity->description }}</p>
                        <p class="text-[9px] font-bold text-slate-600 mt-1 uppercase">{{ $activity->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <p class="text-[11px] text-slate-500 py-4 text-center">Aucune activité</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const distributionData = @json($data['charts']['status_distribution']);
        const stages = ['prospection', 'qualification', 'proposition', 'negociation', 'gagne'];
        
        new ApexCharts(document.querySelector("#quotaSubChart"), {
            chart: { 
                type: 'area', 
                height: 128,
                sparkline: { enabled: true },
                toolbar: { show: false }
            },
            series: [{ name: 'Statut', data: stages.map(s => distributionData[s] || 0) }],
            stroke: { curve: 'smooth', width: 2 },
            fill: { 
                type: 'gradient', 
                gradient: { 
                    shadeIntensity: 1, 
                    opacityFrom: 0.3, 
                    opacityTo: 0.05 
                } 
            },
            colors: ['#3b82f6'],
            tooltip: { enabled: false }
        }).render();
    });
</script>
@endpush
