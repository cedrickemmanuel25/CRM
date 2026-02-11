@extends('layouts.app')

@section('title', 'Tableau de bord - Nexus CRM')

@section('content')
<div class="px-4 sm:px-8 py-2 space-y-8 bg-[#F4F7FC]/30 min-h-screen">
    <div class="space-y-8">
        <!-- KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- New Leads -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex items-start gap-4 hover:shadow-md transition-shadow">
                <div class="bg-blue-50 p-3 rounded-lg text-[#4C7CDF]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-slate-500">Nouveaux Leads</h3>
                    <p class="text-3xl font-bold text-slate-800 mt-1">{{ $data['kpis']['contacts_count'] }}</p>
                    <div class="flex items-center gap-1 text-[#4ED6A3] text-sm font-bold mt-2">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span>{{ $data['kpis']['leads_today'] }} Aujourd'hui</span>
                    </div>
                </div>
            </div>

            <!-- Active Opportunities -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex items-start gap-4 hover:shadow-md transition-shadow">
                <div class="bg-slate-50 p-3 rounded-lg text-slate-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-slate-500">Opportunités En Cours</h3>
                    <p class="text-3xl font-bold text-slate-800 mt-1">{{ $data['kpis']['total_leads_opps'] }}</p>
                    <div class="mt-2 bg-[#4C7CDF] text-white text-[10px] font-bold px-2 py-1 rounded-full inline-flex items-center gap-1">
                        {{ format_currency($data['kpis']['global_forecast_revenue']) }} <span class="opacity-60">= Volume Global</span>
                    </div>
                </div>
            </div>

            <!-- Sales This Month -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex items-start gap-4 hover:shadow-md transition-shadow">
                <div class="bg-blue-50 p-3 rounded-lg text-[#4C7CDF]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-slate-500">Ventes Ce Mois-ci</h3>
                    <p class="text-3xl font-bold text-slate-800 mt-1">{{ $data['kpis']['won_this_month_count'] }}</p>
                    <div class="flex items-center gap-1 text-slate-500 text-sm mt-2">
                        <svg class="w-4 h-4 text-[#4C7CDF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                        <span class="font-bold text-slate-800">CA: {{ format_currency($data['kpis']['won_this_month_revenue']) }}</span>
                    </div>
                </div>
            </div>

            <!-- Overdue Tasks -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex items-start gap-4 hover:shadow-md transition-shadow">
                <div class="bg-slate-50 p-3 rounded-lg text-slate-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-slate-500">Tâches En Retard</h3>
                    <p class="text-3xl font-bold text-slate-800 mt-1">{{ $data['lists']['overdue_tasks']->count() }}</p>
                    <div class="flex items-center gap-1 text-slate-500 text-sm mt-2 font-bold">
                        <svg class="w-4 h-4 text-[#4C7CDF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        <span class="text-slate-800">{{ $data['kpis']['pending_tasks_count'] }}</span> Tâches à faire
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Funnel Chart -->
            <div class="bg-white p-8 rounded-xl shadow-sm border border-slate-100">
                <h3 class="text-lg font-bold text-slate-700 mb-6 sm:mb-8 tracking-tight">Pipeline des Opportunités</h3>
                <div class="flex flex-col lg:flex-row items-center gap-8 lg:gap-12">
                    <!-- Dynamic Funnel Visualization -->
                    <div class="w-full flex-1 flex flex-col items-center order-2 lg:order-1">
                        @php
                            $stages = $data['charts']['pipeline_by_stage'];
                            $totalCount = $stages->sum('count') ?: 1;
                            $widths = ['100%', '80%', '60%', '25%'];
                            $opacities = ['70', '85', '100', '100'];
                        @endphp
                        @foreach($stages->take(4) as $index => $stage)
                            <div class="relative h-16 bg-[#4C7CDF] rounded-sm flex items-center justify-center text-white font-bold opacity-{{ $opacities[$index] }} transition-all" 
                                 style="width: {{ $widths[$index] }}; margin-bottom: 2px; border-bottom-left-radius: {{ $index == 3 ? '8px' : '0' }}; border-bottom-right-radius: {{ $index == 3 ? '8px' : '0' }}; border-top-left-radius: {{ $index == 0 ? '8px' : '0' }}; border-top-right-radius: {{ $index == 0 ? '8px' : '0' }};">
                                {{ $stage->count }}
                            </div>
                        @endforeach
                    </div>
                    <div class="w-full space-y-4 sm:space-y-6 flex-1 order-1 lg:order-2">
                        @foreach($stages->take(4) as $stage)
                            <div class="flex items-center justify-between gap-4 sm:gap-8 border-b border-slate-50 lg:border-none pb-2 lg:pb-0">
                                <div class="flex items-center gap-3 sm:gap-4">
                                    <span class="text-sm sm:text-base text-slate-800 font-bold">{{ $stage->count }}</span>
                                    <span class="text-[10px] sm:text-xs text-slate-800 font-bold uppercase tracking-tight">{{ $stage->stade }}</span>
                                </div>
                                <span class="text-xs sm:text-sm text-slate-800 font-bold">{{ format_currency($stage->total_amount) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Combo Chart -->
            <div class="bg-white p-8 rounded-xl shadow-sm border border-slate-100 relative overflow-hidden">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-lg font-bold text-slate-700 tracking-tight">CA Prévisionnel</h3>
                    <div class="bg-[#4C7CDF] text-white text-xs font-bold px-4 py-1.5 rounded-full flex items-center gap-2">
                        42% <span class="bg-white text-[#4C7CDF] px-1 rounded-sm text-[10px]">▼</span>
                    </div>
                </div>
                <div class="h-48 sm:h-64 mt-4">
                    <canvas id="comboChart"></canvas>
                </div>
            </div>
        </div>

        <!-- 4-Column Widgets -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Tasks -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="bg-slate-50/50 p-4 border-b border-slate-100 font-bold text-slate-700 text-sm">Tâches à Faire</div>
                <div class="p-4 space-y-4">
                    @forelse($data['lists']['tasks'] as $task)
                    <div class="flex gap-3">
                        <div class="bg-blue-100 p-2 rounded text-[#4C7CDF] h-fit">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-xs font-bold text-slate-800">{{ $task->titre }}</h4>
                            <p class="text-[10px] text-slate-500 mt-1">{{ $task->assignee->name ?? 'Non assigné' }} <span class="float-right">{{ $task->created_at->diffForHumans() }}</span></p>
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-slate-400 italic py-4">Aucune tâche en attente.</p>
                    @endforelse
                    
                    <div class="flex items-center justify-between mt-6 pt-4 border-t border-slate-50">
                        <div class="flex items-center gap-2 text-[10px] font-bold text-slate-600">
                            <svg class="w-4 h-4 opacity-40" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                            {{ $data['lists']['overdue_tasks']->count() }} Tâches en retard
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Opportunities -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="bg-slate-50/50 p-4 border-b border-slate-100 font-bold text-slate-700 text-sm">Opportunités Récentes</div>
                <div class="p-4 space-y-5">
                    @foreach($data['lists']['latest_opportunities'] as $opp)
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded bg-slate-100 overflow-hidden">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($opp->contact->nom_complet ?? 'NC') }}&background=E2E8F0&color=475569" alt="">
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between">
                                <span class="text-xs font-bold text-slate-800">{{ Str::limit($opp->titre, 15) }}</span>
                                <span class="text-xs font-bold text-slate-800">{{ format_currency($opp->montant_estime) }}</span>
                            </div>
                            <div class="flex justify-between items-center mt-1">
                                <span class="text-[10px] text-[#4C7CDF] font-bold">{{ $opp->contact->nom_complet ?? 'Inconnu' }}</span>
                                <span class="text-[10px] font-bold text-[#4ED6A3]">{{ $opp->probabilite }}%</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="bg-slate-50/50 p-4 border-b border-slate-100 font-bold text-slate-700 text-sm">Activités Récents</div>
                <div class="p-4 space-y-4">
                    @foreach($data['lists']['recent_activities'] as $activity)
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($activity->user->name ?? 'U') }}&background=F8FAFC&color=475569" class="w-8 h-8 rounded-full border border-slate-100" alt="">
                        <div class="flex-1 group">
                            <h4 class="text-xs font-bold text-slate-800">{{ $activity->user->name ?? 'Système' }} <span class="float-right text-blue-400">✓</span></h4>
                            <p class="text-[10px] text-slate-500 mt-0.5">{{ Str::limit($activity->description, 20) }} <span class="float-right">{{ $activity->created_at->diffForHumans() }}</span></p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Recent Users -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="bg-slate-50/50 p-4 border-b border-slate-100 font-bold text-slate-700 text-sm">Utilisateurs Récents</div>
                <div class="p-4 space-y-4">
                    @foreach($data['lists']['latest_users'] as $user)
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=F1F5F9&color=475569" class="w-8 h-8 rounded-full" alt="">
                        <div class="flex-1">
                            <h4 class="text-xs font-bold text-slate-800">{{ $user->name }} <span class="float-right text-[10px] text-slate-400 font-normal italic">{{ $user->created_at->diffForHumans() }}</span></h4>
                            <div class="flex items-center justify-between mt-0.5">
                                <span class="text-[10px] text-slate-500 capitalize">{{ $user->role }}</span>
                                <span class="text-[10px] bg-[#4ED6A3]/20 text-[#4ED6A3] font-bold px-1.5 rounded">Actif</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Summary Footer Bar -->
    <div class="bg-white border-t border-slate-100 p-8">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-lg font-bold text-slate-700 tracking-tight italic">Rapport de Ventes</h3>
            <a href="{{ route('reports.index') }}" class="text-[#4C7CDF] text-xs font-bold flex items-center gap-2">
                Voir Tous les Rapports 
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-8 sm:gap-12 items-center">
            <div class="space-y-1">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Leads Total</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-slate-800">{{ $data['lists']['total_leads_all_time'] }}</span>
                    <span class="text-[10px] text-[#4ED6A3] font-bold">▲ {{ $data['kpis']['leads_today'] }} <span class="text-slate-400 font-normal">Aujourd'hui</span></span>
                </div>
            </div>
            <div class="space-y-1">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Nouveaux Clients</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-slate-800">{{ $data['lists']['new_clients_this_week'] }}</span>
                    <span class="text-[10px] text-[#4ED6A3] font-bold">▲ {{ $data['lists']['new_clients_this_week'] }} <span class="text-slate-400 font-normal">Cette semaine</span></span>
                </div>
            </div>
            <div class="space-y-1">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">CA Mensuel</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-slate-800">{{ format_currency($data['kpis']['won_this_month_revenue']) }}</span>
                </div>
            </div>
            <div class="space-y-1">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Tâches en Retard</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-slate-800">{{ $data['lists']['overdue_tasks']->count() }}</span>
                    <span class="text-[10px] text-slate-400 font-normal">{{ $data['kpis']['pending_tasks_count'] }} en cours</span>
                </div>
            </div>
            <div class="space-y-4">
                 <a href="{{ route('reports.index') }}" class="w-full bg-[#4C7CDF] text-white py-3 rounded-lg flex items-center justify-center gap-2 text-sm font-bold shadow-md shadow-blue-200">
                    Générer Rapport
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                 </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.x/dist/chart.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Combo Chart for CA Previsionnel
        const ctx = document.getElementById('comboChart').getContext('2d');
        const comboData = @json($data['charts']['revenue_combo']);
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: comboData.labels,
                datasets: [
                    {
                        type: 'line',
                        label: 'Prévision',
                        data: comboData.forecast,
                        borderColor: '#4ED6A3',
                        borderWidth: 3,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#4ED6A3',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        tension: 0.4,
                        fill: false,
                        yAxisID: 'y'
                    },
                    {
                        type: 'bar',
                        label: 'Réel',
                        data: comboData.revenue,
                        backgroundColor: '#4C7CDF',
                        borderRadius: 4,
                        maxBarThickness: 30,
                        yAxisID: 'y'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#F8FAFC', drawBorder: false },
                        ticks: { display: false }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#94A3B8', font: { size: 12, weight: '500' } }
                    }
                }
            }
        });
    });
</script>
@endpush
