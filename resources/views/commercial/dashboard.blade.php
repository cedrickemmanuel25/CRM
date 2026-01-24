@extends('layouts.app')

@section('title', 'Tableau de bord Commercial - Nexus CRM')

@section('content')
<div class="min-h-screen bg-[#F9FAFB] p-8">
    <div class="max-w-[1600px] mx-auto space-y-10">
        
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div>
                <h2 class="text-3xl font-bold tracking-tight text-slate-900 font-primary">
                    Tableau de bord
                </h2>
                <p class="mt-1.5 text-[15px] text-slate-500 font-medium">Bon retour, {{ Auth::user()->name }}. Voici vos indicateurs de vente.</p>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('opportunities.create') }}" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white rounded-lg shadow-sm text-sm font-semibold hover:bg-indigo-700 transition-all border border-indigo-700">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nouvelle opportunité
                </a>
            </div>
        </div>

        <!-- KPI Grid (Corporate Style) -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Forecast Revenue -->
            <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-[13px] font-bold text-slate-500 uppercase tracking-wider">Prévisionnel</p>
                </div>
                <div class="space-y-1">
                    <p class="text-3xl font-bold text-slate-900">{{ format_currency($data['kpis']['my_forecast_revenue']) }}</p>
                    <div class="flex items-center text-xs font-bold text-emerald-600">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        +12% <span class="text-slate-400 font-medium ml-1.5">vs mois dernier</span>
                    </div>
                </div>
            </div>

            <!-- Active Leads -->
            <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 bg-slate-50 rounded-lg text-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <p class="text-[13px] font-bold text-slate-500 uppercase tracking-wider">Leads Actifs</p>
                </div>
                <div class="space-y-1">
                    <p class="text-3xl font-bold text-slate-900">{{ $data['kpis']['my_leads_opps'] }}</p>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">En cours de traitement</p>
                </div>
            </div>

            <!-- Conversion Rate -->
            <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 bg-emerald-50 rounded-lg text-emerald-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-[13px] font-bold text-slate-500 uppercase tracking-wider">Taux de Conv.</p>
                </div>
                <div class="space-y-1">
                    <p class="text-3xl font-bold text-slate-900">{{ $data['kpis']['my_conversion_rate'] }}%</p>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Ratio opportunités gagnées</p>
                </div>
            </div>

            <!-- Tasks Overdue -->
            <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 {{ $data['kpis']['tasks_overdue'] > 0 ? 'bg-rose-50 text-rose-600' : 'bg-slate-50 text-slate-600' }} rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-[13px] font-bold text-slate-500 uppercase tracking-wider">Tâches en retard</p>
                </div>
                <div class="space-y-1">
                    <p class="text-3xl font-bold {{ $data['kpis']['tasks_overdue'] > 0 ? 'text-rose-600' : 'text-slate-900' }}">{{ $data['kpis']['tasks_overdue'] }}</p>
                    <p class="text-xs font-bold {{ $data['kpis']['tasks_overdue'] > 0 ? 'text-rose-400' : 'text-slate-400' }} uppercase tracking-widest">
                        {{ $data['kpis']['tasks_overdue'] > 0 ? 'Action prioritaire' : 'Pas de retard' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Main Content Group -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Center/Left Area (2 Cols) -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Status Distribution Chart (Professional Design) -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-8">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">Distribution par Étape</h3>
                            <p class="text-xs text-slate-400 font-medium uppercase tracking-widest mt-1">Nombre d'opportunités par stade de vente</p>
                        </div>
                    </div>
                    <div class="h-[350px] relative">
                        <canvas id="statusDistributionChart"></canvas>
                    </div>
                </div>

                <!-- Goal Progress (Sober Design) -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-8">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">Objectif mensuel</h3>
                            <p class="text-xs text-slate-400 font-medium mt-1">Avancement par rapport au quota de 50 000€</p>
                        </div>
                        <div class="text-right">
                            <span class="text-2xl font-black text-indigo-600">{{ $data['kpis']['goal_percentage'] }}%</span>
                        </div>
                    </div>
                    <div class="relative w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                        <div class="absolute inset-y-0 left-0 bg-indigo-600 rounded-full transition-all duration-1000 ease-out" style="width:{{ $data['kpis']['goal_percentage'] }}%"></div>
                    </div>
                    <div class="mt-4 flex justify-between text-xs font-bold text-slate-400 uppercase tracking-widest">
                        <span>0 €</span>
                        <span>50 000 €</span>
                    </div>
                </div>

                <!-- Hot Opportunities (Clean Table) -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <h3 class="text-md font-bold text-slate-900">Opportunités à forte priorité</h3>
                        <a href="{{ route('opportunities.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 uppercase tracking-widest px-3 py-1.5 bg-indigo-50 rounded-lg border border-indigo-100 transition-colors">
                            Voir tout le pipeline
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-slate-50/50">
                                    <th class="px-8 py-3.5 text-left font-bold text-slate-500 uppercase tracking-wider text-[11px]">Opportunité</th>
                                    <th class="px-8 py-3.5 text-left font-bold text-slate-500 uppercase tracking-wider text-[11px]">Client</th>
                                    <th class="px-8 py-3.5 text-right font-bold text-slate-500 uppercase tracking-wider text-[11px]">Valeur Estimée</th>
                                    <th class="px-8 py-3.5 text-right font-bold text-slate-500 uppercase tracking-wider text-[11px]">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($data['lists']['hot_opportunities'] as $opp)
                                <tr class="hover:bg-slate-50/30 transition-colors group">
                                    <td class="px-8 py-4">
                                        <a href="{{ route('opportunities.show', $opp) }}" class="font-bold text-slate-900 hover:text-indigo-600 truncate block">{{ $opp->titre }}</a>
                                    </td>
                                    <td class="px-8 py-4">
                                        @if($opp->contact)
                                        <a href="{{ route('contacts.show', $opp->contact) }}" class="text-slate-500 font-medium hover:text-indigo-600">{{ $opp->contact->nom_complet }}</a>
                                        @else
                                        <span class="text-slate-400 italic">N/A</span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-4 text-right">
                                        <span class="font-bold text-slate-900 border border-slate-100 bg-white px-2.5 py-1 rounded shadow-sm">{{ format_currency($opp->montant_estime) }}</span>
                                    </td>
                                    <td class="px-8 py-4 text-right whitespace-nowrap">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('opportunities.edit', $opp) }}" class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Modifier">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                            </a>
                                            <form action="{{ route('opportunities.destroy', $opp) }}" method="POST" onsubmit="return confirm('Supprimer cette opportunité ?');" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Supprimer">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-10 text-center text-slate-400 italic font-medium">Aucune opportunité prioritaire détectée.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sidebar Area (1 Col) -->
            <div class="space-y-8">
                
                <!-- Upcoming Meetings -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                        <h3 class="font-bold text-slate-900">Agenda Prochain</h3>
                        <span class="text-[10px] font-black bg-indigo-50 text-indigo-600 px-2 py-0.5 rounded-full border border-indigo-100 uppercase tracking-widest">Planifié</span>
                    </div>
                    <div class="space-y-1">
                        @forelse($data['lists']['next_meetings'] as $meeting)
                            <div class="flex flex-col p-4 rounded-lg hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100 group">
                                <span class="text-xs font-black text-indigo-600 uppercase tracking-widest mb-1">{{ $meeting->date_activite->translatedFormat('d M @ H:i') }}</span>
                                <span class="text-sm font-bold text-slate-900 group-hover:text-indigo-700 transition-colors leading-snug">{{ $meeting->description ?? 'Réunion client' }}</span>
                            </div>
                        @empty
                            <p class="text-sm text-slate-400 italic text-center py-4">Aucune réunion prévue.</p>
                        @endforelse
                    </div>
                </div>

                <!-- My Tasks -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                        <h3 class="font-bold text-slate-900">Mes Tâches</h3>
                        <span class="text-[10px] font-black bg-amber-50 text-amber-600 px-2 py-0.5 rounded-full border border-amber-100 uppercase tracking-widest">{{ $data['kpis']['tasks_due_today'] }} AUJ.</span>
                    </div>
                    <div class="space-y-2">
                        @forelse($data['lists']['tasks'] as $task)
                            <div class="flex items-start gap-3 p-2 rounded-lg hover:bg-slate-50 transition-colors transition-colors">
                                <div class="mt-1.5 w-1.5 h-1.5 rounded-full {{ $task->due_date < now() ? 'bg-rose-500' : 'bg-slate-300' }} flex-shrink-0"></div>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-slate-800 leading-snug truncate">{{ $task->titre }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">{{ $task->due_date->translatedFormat('d F Y') }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-slate-400 italic text-center py-4">Pas de tâches en attente.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Activity Feed -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                    <h3 class="font-bold text-slate-900 mb-6 pb-4 border-b border-slate-100">Dernières Activités</h3>
                    <div class="relative space-y-6 before:absolute before:inset-0 before:left-[11px] before:border-l before:border-slate-100">
                        @forelse($data['lists']['recent_activities'] as $activity)
                            <div class="relative pl-7 flex flex-col group">
                                <div class="absolute left-0 top-1 w-2.5 h-2.5 rounded-full bg-white border-2 border-slate-200 z-10 group-hover:border-indigo-500 transition-colors"></div>
                                <p class="text-[13px] font-medium text-slate-600 group-hover:text-slate-900 transition-colors">{{ $activity->description }}</p>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">{{ $activity->created_at->diffForHumans() }}</span>
                            </div>
                        @empty
                            <p class="text-sm text-slate-400 italic text-center py-4 bg-white relative z-10">Historique vide.</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const distributionCtx = document.getElementById('statusDistributionChart').getContext('2d');
        const rawData = @json($data['charts']['status_distribution']);
        
        const stagesConfig = [
            { key: 'prospection', label: 'Prospection', color: '#6366F1' },
            { key: 'qualification', label: 'Qualification', color: '#4F46E5' },
            { key: 'proposition', label: 'Proposition', color: '#4338CA' },
            { key: 'negociation', label: 'Négociation', color: '#3730A3' },
            { key: 'gagne', label: 'Gagné', color: '#10B981' },
            { key: 'perdu', label: 'Perdu', color: '#94A3B8' }
        ];

        const labels = stagesConfig.map(s => s.label);
        const dataValues = stagesConfig.map(s => Number(rawData[s.key] || 0));

        new Chart(distributionCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Opportunités',
                    data: dataValues,
                    backgroundColor: stagesConfig.map(s => s.color),
                    borderRadius: 4,
                    maxBarThickness: 50,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1E293B',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: { size: 12, family: "'Inter', sans-serif", weight: 'bold' },
                        bodyFont: { size: 12, family: "'Inter', sans-serif" },
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' Opportunité(s)';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#F1F5F9', borderDash: [2, 2] },
                        ticks: { font: { family: "'Inter', sans-serif", size: 11 }, color: '#94A3B8' },
                        border: { display: false }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: "'Inter', sans-serif", size: 11, weight: '600' }, color: '#64748B' },
                        border: { display: false }
                    }
                }
            }
        });
    });
</script>
@endpush
