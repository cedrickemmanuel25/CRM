@extends('layouts.app')

@section('title', 'Mon Tableau de Bord - Nexus CRM')

@section('content')
<div class="min-h-screen bg-gray-50/50 p-6">
    <div class="max-w-[1600px] mx-auto space-y-8">
        
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                    Espace Commercial
                </h2>
                <p class="mt-1 text-sm text-gray-500">Suivez vos performances et vos objectifs en temps réel.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('opportunities.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white hover:bg-indigo-700 transition-all">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nouvelle Opportunité
                </a>
            </div>
        </div>

        <!-- KPI Grid -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Forecast Revenue -->
            <div class="relative overflow-hidden rounded-xl bg-white p-6 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Mon Prévisionnel</p>
                    <div class="p-2 bg-indigo-50 rounded-lg group-hover:bg-indigo-100 transition-colors">
                        <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-bold text-gray-900">{{ format_currency($data['kpis']['my_forecast_revenue']) }}</p>
                </div>
            </div>

            <!-- Active Leads -->
            <div class="relative overflow-hidden rounded-xl bg-white p-6 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Leads en cours</p>
                    <div class="p-2 bg-blue-50 rounded-lg group-hover:bg-blue-100 transition-colors">
                        <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-bold text-gray-900">{{ $data['kpis']['my_leads_opps'] }}</p>
                </div>
            </div>

            <!-- Conversion Rate -->
            <div class="relative overflow-hidden rounded-xl bg-white p-6 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Taux de Conversion</p>
                    <div class="p-2 bg-emerald-50 rounded-lg group-hover:bg-emerald-100 transition-colors">
                        <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-bold text-gray-900">{{ $data['kpis']['my_conversion_rate'] }}%</p>
                </div>
            </div>

            <!-- Tasks Overdue -->
            <div class="relative overflow-hidden rounded-xl bg-white p-6 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Tâches en retard</p>
                    <div class="p-2 {{ $data['kpis']['tasks_overdue'] > 0 ? 'bg-rose-50' : 'bg-emerald-50' }} rounded-lg group-hover:bg-opacity-80 transition-colors">
                        <svg class="h-5 w-5 {{ $data['kpis']['tasks_overdue'] > 0 ? 'text-rose-600' : 'text-emerald-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-bold {{ $data['kpis']['tasks_overdue'] > 0 ? 'text-rose-600' : 'text-gray-900' }}">{{ $data['kpis']['tasks_overdue'] }}</p>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Side: Distribution and Pipeline (2 Cols) -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Status Distribution Chart -->
                <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 p-6 flex flex-col">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-lg font-bold text-gray-900">Répartition par Statut</h3>
                    </div>
                    
                    <div class="flex-1 mt-4 relative h-[300px]">
                        <canvas id="statusDistributionChart"></canvas>
                    </div>
                </div>

                <!-- Goal Achievement Card -->
                <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900">Objectif du Mois</h3>
                        <div class="flex items-center gap-2">
                             <span class="px-3 py-1 bg-indigo-50 text-indigo-700 text-xs font-bold rounded-full">
                                {{ $data['kpis']['goal_percentage'] }}% atteint
                             </span>
                        </div>
                    </div>
                    
                    <div class="relative w-full bg-gray-100 rounded-full h-4 overflow-hidden mb-4">
                        <div class="absolute top-0 left-0 h-full bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-full transition-all duration-1000 shadow-[0_0_15px_rgba(79,70,229,0.3)]" style="width:{{ $data['kpis']['goal_percentage'] }}%"></div>
                    </div>
                    <p class="text-xs text-gray-500 italic">Votre objectif de vente est basé sur un quota mensuel de 50 000€ pour les opportunités gagnées.</p>
                </div>

                <!-- Hot Opportunities Table -->
                <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900">Opportunités à Fort Potentiel</h3>
                        <a href="{{ route('opportunities.index') }}" class="px-4 py-2 bg-gray-50 hover:bg-gray-100 text-xs font-semibold text-gray-600 rounded-lg transition-colors">
                            Voir tout
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-white border-b border-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Opportunité</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Contact</th>
                                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Montant</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($data['lists']['hot_opportunities'] as $opp)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ $opp->titre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $opp->contact->nom_complet ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 text-right">{{ format_currency($opp->montant_estime) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-gray-500 italic">Aucune opportunité à fort potentiel.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Column: Sidebar -->
            <div class="space-y-6">
                <!-- Upcoming Meetings -->
                <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Prochains RDV</h3>
                    <div class="space-y-4">
                        @forelse($data['lists']['next_meetings'] as $meeting)
                            <div class="flex items-start gap-4 p-3 rounded-xl hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-100">
                                <div class="h-10 w-10 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600 flex-shrink-0">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-bold text-gray-900 truncate">{{ $meeting->description ?? 'Rendez-vous' }}</p>
                                    <p class="text-xs text-gray-500 font-medium mt-0.5 uppercase tracking-wider">{{ $meeting->date_activite->translatedFormat('d M à H:i') }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 italic text-center py-4">Aucun RDV prévu.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Upcoming Tasks -->
                <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900">Mes Tâches</h3>
                        <span class="px-2 py-1 bg-amber-50 text-amber-700 text-[10px] font-black uppercase tracking-widest rounded">{{ $data['kpis']['tasks_due_today'] }} AUJOURD'HUI</span>
                    </div>
                    <div class="space-y-4">
                        @forelse($data['lists']['tasks'] as $task)
                            <div class="flex items-center gap-4 group">
                                <div class="h-2 w-2 rounded-full {{ $task->due_date < now() ? 'bg-rose-500 shadow-[0_0_8px_rgba(244,63,94,0.4)]' : 'bg-gray-300' }}"></div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-semibold text-gray-900 truncate group-hover:text-indigo-600 transition-colors">{{ $task->titre }}</p>
                                    <p class="text-[11px] text-gray-400 font-medium">{{ $task->due_date->translatedFormat('d F Y') }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 italic text-center py-4">Aucune tâche prévue.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Actions (Timeline style) -->
                <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Mes Dernières Actions</h3>
                    <div class="space-y-6 relative before:absolute before:inset-0 before:left-[11px] before:border-l-2 before:border-gray-50">
                        @forelse($data['lists']['recent_activities'] as $activity)
                            <div class="relative flex gap-4 pl-2">
                                <div class="h-6 w-6 rounded-full bg-white border-4 border-gray-50 ring-2 ring-gray-100 z-10 flex-shrink-0"></div>
                                <div class="flex-1 min-w-0 -mt-1">
                                    <p class="text-[13px] font-semibold text-gray-800 leading-tight">{{ $activity->description }}</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase mt-1 tracking-wider">{{ $activity->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 italic text-center py-4 relative z-10 bg-white">Aucune action récente.</p>
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
        // Status Distribution Chart
        const distributionCtx = document.getElementById('statusDistributionChart').getContext('2d');
        const rawData = @json($data['charts']['status_distribution']);
        
        const stagesConfig = [
            { key: 'prospection', label: 'Prospection', color: '#3B82F6' },
            { key: 'qualification', label: 'Qualification', color: '#6366F1' },
            { key: 'proposition', label: 'Proposition', color: '#F97316' },
            { key: 'negociation', label: 'Négociation', color: '#10B981' },
            { key: 'gagne', label: 'Gagné', color: '#16A34A' },
            { key: 'perdu', label: 'Perdu', color: '#9CA3AF' }
        ];

        const labels = stagesConfig.map(s => s.label);
        const dataValues = stagesConfig.map(s => Number(rawData[s.key] || 0));
        const backgroundColors = stagesConfig.map(s => s.color);

        const statusChart = new Chart(distributionCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Opportunités',
                    data: dataValues,
                    backgroundColor: backgroundColors,
                    borderRadius: 6,
                    maxBarThickness: 50,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1F2937',
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' opp.';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#F3F4F6',
                            drawBorder: false,
                        },
                        ticks: {
                            font: { family: "'Inter', sans-serif", size: 11 },
                            color: '#9CA3AF',
                        },
                        border: { display: false }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { family: "'Inter', sans-serif", size: 11 },
                            color: '#9CA3AF'
                        },
                        border: { display: false }
                    }
                }
            }
        });
    });
</script>
@endpush
