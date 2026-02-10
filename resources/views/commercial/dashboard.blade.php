@extends('layouts.app')

@section('title', 'Tableau de Bord Commercial - Nexus CRM')

@section('content')
<div class="px-8 py-2 space-y-8 bg-[#F4F7FC]/30 min-h-screen">
    <div class="space-y-8">
        <!-- Header with Quick Actions -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Tableau de Bord Commercial</h1>
                <p class="text-slate-500 text-sm mt-1">Gérez votre pipeline et vos activités quotidiennes.</p>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('activities.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-700 text-sm font-bold rounded-xl hover:bg-slate-50 hover:border-slate-300 transition-all shadow-sm">
                    <div class="bg-amber-100 p-1.5 rounded-lg text-amber-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    Journal
                </a>
                
                <a href="{{ route('tasks.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#4C7CDF] text-white text-sm font-bold rounded-xl hover:bg-[#3b66bd] transition-all shadow-md shadow-blue-100 group">
                    <div class="bg-white/20 p-1.5 rounded-lg group-hover:bg-white/30 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    Rappel
                </a>
            </div>
        </div>

        <!-- KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Forecast Revenue -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex items-start gap-4 hover:shadow-md transition-shadow">
                <div class="bg-blue-50 p-3 rounded-lg text-[#4C7CDF]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Volume Prévisionnel</h3>
                    <p class="text-3xl font-bold text-slate-800 mt-1">{{ format_currency($data['kpis']['my_forecast_revenue']) }}</p>
                    <div class="flex items-center gap-1 {{ $data['kpis']['my_forecast_change'] >= 0 ? 'text-[#4ED6A3]' : 'text-rose-500' }} text-sm font-bold mt-2">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="{{ $data['kpis']['my_forecast_change'] >= 0 ? 'M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z' : 'M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z' }}" clip-rule="evenodd"></path></svg>
                        <span>{{ abs($data['kpis']['my_forecast_change']) }}% <span class="text-slate-400 font-normal">vs mois dernier</span></span>
                    </div>
                </div>
            </div>

            <!-- Active Leads -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex items-start gap-4 hover:shadow-md transition-shadow">
                <div class="bg-slate-50 p-3 rounded-lg text-slate-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Leads Actifs</h3>
                    <p class="text-3xl font-bold text-slate-800 mt-1">{{ $data['kpis']['my_leads_opps'] }}</p>
                    <div class="mt-2 bg-[#4C7CDF] text-white text-[10px] font-bold px-2 py-1 rounded-full inline-flex items-center gap-1">
                        Opportunités en cours
                    </div>
                </div>
            </div>

            <!-- Conversion Rate -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex items-start gap-4 hover:shadow-md transition-shadow">
                <div class="bg-blue-50 p-3 rounded-lg text-[#4C7CDF]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Taux de Conversion</h3>
                    <p class="text-3xl font-bold text-slate-800 mt-1">{{ $data['kpis']['my_conversion_rate'] }}%</p>
                    <p class="text-[10px] font-bold text-[#4ED6A3] mt-2 uppercase tracking-widest italic">Performance Gagnée</p>
                </div>
            </div>

            <!-- Tasks Overdue -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex items-start gap-4 hover:shadow-md transition-shadow">
                <div class="bg-slate-50 p-3 rounded-lg text-slate-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Tâches en Retard</h3>
                    <p class="text-3xl font-bold {{ $data['kpis']['tasks_overdue'] > 0 ? 'text-rose-500' : 'text-slate-800' }} mt-1">{{ $data['kpis']['tasks_overdue'] }}</p>
                    <div class="flex items-center gap-1 text-slate-500 text-sm mt-2 font-bold uppercase tracking-tighter">
                        <svg class="w-4 h-4 text-[#4C7CDF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        <span class="text-slate-800">Action Prioritaire</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Funnel Chart (Sales Pipeline) -->
            <div class="bg-white p-8 rounded-xl shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-lg font-bold text-slate-700 tracking-tight">Mon Pipeline de Ventes</h3>
                    <span class="text-[10px] font-black text-[#4C7CDF] bg-blue-50 px-3 py-1 rounded-full uppercase tracking-[0.2em]">Live Data</span>
                </div>
                <div class="flex flex-col sm:flex-row items-center gap-12">
                    <div class="flex-1 w-full sm:w-auto flex flex-col items-center">
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
                    <div class="space-y-6 flex-1 w-full sm:w-auto">
                        @foreach($stages->take(4) as $stage)
                            <div class="flex items-center justify-between gap-8 border-b border-slate-50 pb-2">
                                <div class="flex items-center gap-4">
                                    <span class="text-slate-800 font-bold">{{ $stage->count }}</span>
                                    <span class="text-slate-400 font-bold uppercase tracking-tight text-[11px]">{{ $stage->stade }}</span>
                                </div>
                                <span class="text-slate-800 font-bold text-sm">{{ format_currency($stage->total_amount) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Goal Progress & Status Distribution -->
            <div class="bg-white p-8 rounded-xl shadow-sm border border-slate-100 relative overflow-hidden flex flex-col">
                <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-50">
                    <div>
                        <h3 class="text-lg font-bold text-slate-700 tracking-tight">Objectif du Mois</h3>
                        <p class="text-xs text-slate-400 mt-1">Avancement par rapport au quota</p>
                    </div>
                    <div class="text-right">
                        <span class="text-3xl font-black text-[#4C7CDF]">{{ $data['kpis']['goal_percentage'] }}%</span>
                    </div>
                </div>
                
                <div class="space-y-10 flex-1 flex flex-col justify-center">
                    <div class="space-y-4">
                        <div class="relative w-full bg-slate-100 rounded-full h-4 overflow-hidden shadow-inner">
                            <div class="absolute inset-y-0 left-0 bg-gradient-to-r from-[#4C7CDF] to-[#6366F1] rounded-full transition-all duration-1000 ease-out" style="width:{{ $data['kpis']['goal_percentage'] }}%"></div>
                        </div>
                        <div class="flex justify-between text-[11px] font-bold text-slate-400 uppercase tracking-[0.2em]">
                            <span>0 €</span>
                            <span>Cible: {{ format_currency($data['kpis']['sales_quota']) }}</span>
                        </div>
                    </div>

                    <div class="h-40">
                        <canvas id="statusDistributionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4-Column Widgets -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Tasks -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden group">
                <div class="bg-slate-50/50 p-4 border-b border-slate-100 font-bold text-slate-700 text-sm flex justify-between items-center">
                    <span>Mes Tâches</span>
                    <span class="text-[10px] bg-amber-100 text-amber-600 px-2 py-0.5 rounded">{{ $data['kpis']['tasks_due_today'] }} AUJ.</span>
                </div>
                <div class="p-4 space-y-4">
                    @forelse($data['lists']['tasks'] as $task)
                    <div class="flex gap-3 hover:translate-x-1 transition-transform cursor-pointer">
                        <div class="{{ $task->due_date < now() ? 'bg-rose-100 text-rose-500' : 'bg-blue-100 text-[#4C7CDF]' }} p-2 rounded h-fit shrink-0">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-xs font-bold text-slate-800 truncate">{{ $task->titre }}</h4>
                            <p class="text-[10px] text-slate-500 mt-1 uppercase tracking-tighter">{{ $task->due_date->translatedFormat('d F') }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-[11px] text-slate-400 italic py-6 text-center">Aucune tâche en attente.</p>
                    @endforelse
                </div>
            </div>

            <!-- Hot Opportunities -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="bg-slate-50/50 p-4 border-b border-slate-100 font-bold text-slate-700 text-sm">Priorités Hautes</div>
                <div class="p-4 space-y-5 text-xs">
                    @forelse($data['lists']['hot_opportunities'] as $opp)
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-500 font-black shrink-0">
                            {{ substr($opp->titre, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-slate-800 truncate">{{ $opp->titre }}</span>
                                <span class="font-black text-[#4C7CDF] ml-2">{{ format_currency($opp->montant_estime) }}</span>
                            </div>
                            <div class="text-[10px] text-slate-400 mt-0.5 truncate uppercase">{{ $opp->contact->nom_complet ?? 'NC' }}</div>
                        </div>
                    </div>
                    @empty
                    <p class="text-[11px] text-slate-400 italic py-6 text-center">Aucun focus haute priorité.</p>
                    @endforelse
                </div>
            </div>

            <!-- Next Meetings -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="bg-slate-50/50 p-4 border-b border-slate-100 font-bold text-slate-700 text-sm">Prochains Rendez-vous</div>
                <div class="p-4 space-y-4 text-xs font-bold">
                    @forelse($data['lists']['next_meetings'] as $meeting)
                    <div class="flex flex-col border-l-2 border-[#4C7CDF] pl-3 py-1 bg-slate-50/50 rounded-r-md">
                        <span class="text-[10px] text-[#4C7CDF] uppercase tracking-widest">{{ $meeting->date_activite->translatedFormat('d M H:i') }}</span>
                        <span class="text-slate-800 mt-1 leading-snug line-clamp-2">{{ $meeting->description ?? 'Réunion Client' }}</span>
                    </div>
                    @empty
                    <p class="text-[11px] text-slate-400 italic py-6 text-center">Aucune réunion prévue.</p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="bg-slate-50/50 p-4 border-b border-slate-100 font-bold text-slate-700 text-sm">Dernières Activités</div>
                <div class="p-4 space-y-4">
                    @forelse($data['lists']['recent_activities'] as $activity)
                    <div class="flex gap-3">
                        <div class="w-2 h-2 rounded-full bg-[#4ED6A3] mt-1.5 shrink-0 opacity-40"></div>
                        <div class="flex-1">
                            <p class="text-[11px] text-slate-600 line-clamp-2 leading-relaxed">{{ $activity->description }}</p>
                            <p class="text-[9px] font-bold text-slate-400 mt-1 uppercase tracking-widest">{{ $activity->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-[11px] text-slate-400 italic py-6 text-center">Aucun log récent.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Footer Bar (Commercial Stats) -->
    <div class="bg-white border-t border-slate-100 p-8 mt-12 mb-8 rounded-xl shadow-lg border border-slate-50">
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-50">
            <h3 class="text-lg font-black text-slate-800 tracking-tighter uppercase italic">Synthèse de Ventes</h3>
            <a href="{{ route('opportunities.index') }}" class="text-[#4C7CDF] text-[11px] font-black flex items-center gap-2 uppercase tracking-widest">
                Mon Pipeline Complet
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 items-center">
            <div class="space-y-1 group">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-l-2 border-indigo-200 pl-3">Opportunités en cours</p>
                <div class="flex items-baseline gap-2 pl-3 mt-2">
                    <span class="text-4xl font-black text-slate-900 tracking-tighter">{{ $data['kpis']['my_leads_opps'] }}</span>
                    <span class="text-[11px] text-[#4C7CDF] font-black">Actives</span>
                </div>
            </div>
            <div class="space-y-1">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-l-2 border-indigo-200 pl-3">Volume de Pipe</p>
                <div class="flex items-baseline gap-2 pl-3 mt-2">
                    <span class="text-3xl font-black text-slate-900 tracking-tighter">{{ format_currency($data['kpis']['my_forecast_revenue']) }}</span>
                </div>
            </div>
            <div class="space-y-1">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-l-2 border-indigo-200 pl-3">Performance Conv.</p>
                <div class="flex items-baseline gap-2 pl-3 mt-2">
                    <span class="text-4xl font-black text-slate-900 tracking-tighter">{{ $data['kpis']['my_conversion_rate'] }}%</span>
                </div>
            </div>
            <div class="space-y-1">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-l-2 border-indigo-200 pl-3">Objectif Restant</p>
                <div class="flex items-baseline gap-2 pl-3 mt-2">
                    @php
                        $remaining = $data['kpis']['sales_quota'] - $data['kpis']['my_forecast_revenue'];
                    @endphp
                    <span class="text-3xl font-black {{ $remaining > 0 ? 'text-slate-900' : 'text-[#4ED6A3]' }} tracking-tighter">
                        {{ format_currency(max(0, $remaining)) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.x/dist/chart.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Status Distribution Chart (Mini version for Goal Section)
        const distributionCtx = document.getElementById('statusDistributionChart').getContext('2d');
        const distributionData = @json($data['charts']['status_distribution']);
        
        const stagesConfig = [
            { key: 'prospection', label: 'PROS.', color: '#E2E8F0' },
            { key: 'qualification', label: 'QUAL.', color: '#CBD5E1' },
            { key: 'proposition', label: 'PROP.', color: '#94A3B8' },
            { key: 'negociation', label: 'NEGOC.', color: '#64748B' },
            { key: 'gagne', label: 'GAGNÉ', color: '#4ED6A3' }
        ];

        const labels = stagesConfig.map(s => s.label);
        const values = stagesConfig.map(s => distributionData[s.key] || 0);

        new Chart(distributionCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: stagesConfig.map(s => s.color),
                    borderRadius: 4,
                    maxBarThickness: 25,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        enabled: true,
                        backgroundColor: '#1E293B',
                        cornerRadius: 4,
                        callbacks: {
                            label: (ctx) => ` ${ctx.parsed.y} Opportunités`
                        }
                    }
                },
                scales: {
                    y: { display: false },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 9, weight: '700', family: "'Inter', sans-serif" }, color: '#94A3B8' }
                    }
                }
            }
        });
    });
</script>
@endpush
