@extends('layouts.app')

@section('title', 'Mon Tableau de Bord - Nexus CRM')

@section('content')
<div class="min-h-screen bg-gray-50/50 p-6">
    <div class="max-w-[1600px] mx-auto space-y-8">
        
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900">
                    Bonjour, {{ Auth::user()->name }} 👋
                </h2>
                <p class="mt-1 text-sm text-gray-500 font-medium">Voici l'état de vos performances pour aujourd'hui.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('opportunities.create') }}" class="group inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-xl shadow-lg shadow-indigo-200 text-sm font-bold text-white hover:bg-indigo-700 hover:shadow-indigo-300 transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0">
                    <svg class="mr-2 h-5 w-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    Nouvelle Opportunité
                </a>
            </div>
        </div>

        <!-- KPI Grid (Glassmorphism & Depth) -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Forecast Revenue -->
            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl blur opacity-10 group-hover:opacity-30 transition duration-1000 group-hover:duration-200"></div>
                <div class="relative overflow-hidden rounded-2xl bg-white/80 backdrop-blur-xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white/40 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-500 group">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-[11px] font-black text-indigo-400 uppercase tracking-[0.2em]">Mon Prévisionnel</p>
                        <div class="p-2.5 bg-indigo-50 rounded-xl group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <p class="text-3xl font-black text-gray-900 tracking-tight">{{ format_currency($data['kpis']['my_forecast_revenue']) }}</p>
                    </div>
                    <div class="mt-4 flex items-center text-[11px] font-bold text-gray-400">
                        <span class="flex items-center text-emerald-500 mr-2">
                             <svg class="w-3 h-3 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                             12%
                        </span>
                        vs mois dernier
                    </div>
                </div>
            </div>

            <!-- Active Leads -->
            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-2xl blur opacity-10 group-hover:opacity-30 transition duration-1000 group-hover:duration-200"></div>
                <div class="relative overflow-hidden rounded-2xl bg-white/80 backdrop-blur-xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white/40 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-500 group">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-[11px] font-black text-blue-400 uppercase tracking-[0.2em]">Leads en cours</p>
                        <div class="p-2.5 bg-blue-50 rounded-xl group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <p class="text-3xl font-black text-gray-900 tracking-tight">{{ $data['kpis']['my_leads_opps'] }}</p>
                    </div>
                    <div class="mt-4 h-1 w-full bg-blue-100 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-500 rounded-full" style="width: 65%"></div>
                    </div>
                </div>
            </div>

            <!-- Conversion Rate -->
            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-2xl blur opacity-10 group-hover:opacity-30 transition duration-1000 group-hover:duration-200"></div>
                <div class="relative overflow-hidden rounded-2xl bg-white/80 backdrop-blur-xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white/40 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-500 group">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-[11px] font-black text-emerald-400 uppercase tracking-[0.2em]">Taux de Conversion</p>
                        <div class="p-2.5 bg-emerald-50 rounded-xl group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <p class="text-3xl font-black text-gray-900 tracking-tight">{{ $data['kpis']['my_conversion_rate'] }}%</p>
                    </div>
                    <p class="mt-4 text-[11px] font-bold text-gray-400 uppercase tracking-widest">+5% depuis hier</p>
                </div>
            </div>

            <!-- Tasks Overdue (Alert Logic) -->
            <div class="relative group">
                <div class="absolute -inset-0.5 {{ $data['kpis']['tasks_overdue'] > 0 ? 'bg-gradient-to-r from-rose-500 to-orange-500 opacity-20' : 'bg-gradient-to-r from-emerald-500 to-teal-500 opacity-10' }} rounded-2xl blur group-hover:opacity-40 transition duration-1000 group-hover:duration-200"></div>
                <div class="relative overflow-hidden rounded-2xl bg-white/80 backdrop-blur-xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white/40 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-500 group">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-[11px] font-black {{ $data['kpis']['tasks_overdue'] > 0 ? 'text-rose-400' : 'text-emerald-400' }} uppercase tracking-[0.2em]">Tâches en retard</p>
                        <div class="p-2.5 {{ $data['kpis']['tasks_overdue'] > 0 ? 'bg-rose-50 text-rose-600 group-hover:bg-rose-600' : 'bg-emerald-50 text-emerald-600 group-hover:bg-emerald-600' }} rounded-xl group-hover:text-white transition-all duration-300">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <p class="text-3xl font-black {{ $data['kpis']['tasks_overdue'] > 0 ? 'text-rose-600' : 'text-gray-900' }} tracking-tight">{{ $data['kpis']['tasks_overdue'] }}</p>
                    </div>
                    <p class="mt-4 text-[11px] font-bold text-gray-400">
                        {{ $data['kpis']['tasks_overdue'] > 0 ? 'Action requise immédiatement' : 'Tout est à jour' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Side: Distribution and Pipeline (2 Cols) -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Status Distribution Chart (Refined) -->
                <div class="relative group">
                    <div class="absolute -inset-0.5 bg-white rounded-3xl blur opacity-5"></div>
                    <div class="relative bg-white/90 backdrop-blur-xl rounded-2xl shadow-[0_15px_50px_-15px_rgba(0,0,0,0.05)] border border-gray-100/50 p-8 flex flex-col">
                        <div class="flex items-center justify-between mb-10">
                            <div>
                                <h3 class="text-xl font-black text-gray-900 tracking-tight">Répartition par Statut</h3>
                                <p class="text-xs font-semibold text-gray-400 mt-1 uppercase tracking-widest">Volume global du pipeline</p>
                            </div>
                            <div class="flex gap-2">
                                <div class="px-3 py-1 bg-gray-50 rounded-full text-[10px] font-bold text-gray-400 uppercase tracking-widest border border-gray-100">Live</div>
                            </div>
                        </div>
                        
                        <div class="flex-1 mt-4 relative h-[320px]">
                            <canvas id="statusDistributionChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Goal Achievement Card (Premium Feature Card) -->
                <div class="relative overflow-hidden rounded-3xl bg-indigo-900 p-8 text-white shadow-2xl shadow-indigo-200">
                    <!-- Background Decoration -->
                    <div class="absolute top-0 right-0 -mr-20 -mt-20 h-64 w-64 rounded-full bg-indigo-500/20 blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 h-48 w-48 rounded-full bg-purple-500/10 blur-3xl"></div>
                    
                    <div class="relative flex flex-col md:flex-row items-center justify-between gap-8">
                        <div class="space-y-4 text-center md:text-left">
                            <h3 class="text-2xl font-black tracking-tight">Objectif du Mois</h3>
                            <p class="text-indigo-200 text-sm max-w-sm font-medium leading-relaxed">
                                Vous êtes sur la bonne voie ! <span class="text-white font-bold">{{ $data['kpis']['goal_percentage'] }}%</span> de votre quota de <span class="text-white font-bold">50 000€</span> est déjà sécurisé.
                            </p>
                        </div>
                        
                        <div class="relative flex-shrink-0">
                            <!-- Circular Progress for extra "Wow" -->
                            <div class="relative h-32 w-32 flex items-center justify-center">
                                <svg class="h-full w-full transform -rotate-90">
                                    <circle cx="64" cy="64" r="58" stroke="currentColor" stroke-width="12" fill="transparent" class="text-indigo-800" />
                                    <circle cx="64" cy="64" r="58" stroke="currentColor" stroke-width="12" fill="transparent" class="text-indigo-400 transition-all duration-1000 ease-out" 
                                            stroke-dasharray="364.4" 
                                            stroke-dashoffset="{{ 364.4 - (364.4 * ($data['kpis']['goal_percentage'] / 100)) }}" />
                                </svg>
                                <span class="absolute text-xl font-black">{{ $data['kpis']['goal_percentage'] }}%</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-8 relative w-full bg-indigo-800/50 rounded-full h-3 overflow-hidden">
                        <div class="absolute top-0 left-0 h-full bg-gradient-to-r from-indigo-300 to-white rounded-full transition-all duration-1000 shadow-[0_0_20px_rgba(255,255,255,0.4)]" style="width:{{ $data['kpis']['goal_percentage'] }}%"></div>
                    </div>
                </div>

                <!-- Hot Opportunities Table (Modernized) -->
                <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100/50 overflow-hidden">
                    <div class="p-8 border-b border-gray-50 flex items-center justify-between bg-white">
                        <div>
                            <h3 class="text-xl font-black text-gray-900 tracking-tight">Opportunités à Fort Potentiel</h3>
                            <p class="text-xs font-semibold text-indigo-500 mt-1 uppercase tracking-widest font-black">Top 5 prioritize</p>
                        </div>
                        <a href="{{ route('opportunities.index') }}" class="px-5 py-2.5 bg-indigo-50 hover:bg-indigo-100 text-[11px] font-black text-indigo-600 rounded-xl transition-all uppercase tracking-widest shadow-sm">
                            Voir tout le pipeline
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50/50">
                                <tr>
                                    <th class="px-8 py-4 text-left text-[11px] font-black text-gray-400 uppercase tracking-widest">Opportunité</th>
                                    <th class="px-8 py-4 text-left text-[11px] font-black text-gray-400 uppercase tracking-widest">Contact</th>
                                    <th class="px-8 py-4 text-right text-[11px] font-black text-gray-400 uppercase tracking-widest">Valeur Estimée</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($data['lists']['hot_opportunities'] as $opp)
                                <tr class="hover:bg-indigo-50/30 transition-all group duration-300">
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-2 h-2 rounded-full bg-indigo-500 mr-4 shadow-[0_0_10px_rgba(79,70,229,0.5)]"></div>
                                            <span class="text-sm font-bold text-gray-900 group-hover:text-indigo-700 transition-colors">{{ $opp->titre }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="h-8 w-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-600 text-xs font-bold border border-gray-200">
                                                {{ substr($opp->contact->nom ?? 'C', 0, 1) }}
                                            </div>
                                            <span class="text-sm font-medium text-gray-600">{{ $opp->contact->nom_complet ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap text-right">
                                        <span class="text-sm font-black text-gray-900 bg-gray-50 px-3 py-1 rounded-lg border border-gray-100">{{ format_currency($opp->montant_estime) }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-8 py-12 text-center text-gray-400 italic font-medium">Aucune opportunité à fort potentiel identifiée.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Column: Sidebar Widgets -->
            <div class="space-y-8">
                <!-- Upcoming Meetings -->
                <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100/50 p-8">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-xl font-black text-gray-900 tracking-tight">Prochains RDV</h3>
                        <div class="h-8 w-8 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                            <span class="text-xs font-black">{{ count($data['lists']['next_meetings']) }}</span>
                        </div>
                    </div>
                    <div class="space-y-4">
                        @forelse($data['lists']['next_meetings'] as $meeting)
                            <div class="group relative flex items-start gap-4 p-4 rounded-2xl hover:bg-gray-50 transition-all duration-300 border border-transparent hover:border-gray-100">
                                <div class="h-12 w-12 rounded-xl bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white flex items-center justify-center text-indigo-600 transition-all duration-300 flex-shrink-0 shadow-sm">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-bold text-gray-900 truncate group-hover:text-indigo-600 transition-colors">{{ $meeting->description ?? 'Rendez-vous' }}</p>
                                    <p class="text-[10px] text-gray-400 font-extrabold mt-1 uppercase tracking-widest">{{ $meeting->date_activite->translatedFormat('d M à H:i') }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <div class="h-12 w-12 bg-gray-50 rounded-2xl flex items-center justify-center text-gray-300 mx-auto mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                </div>
                                <p class="text-sm text-gray-400 font-medium italic">Aucun RDV prévu.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Upcoming Tasks -->
                <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100/50 p-8">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-xl font-black text-gray-900 tracking-tight">Mes Tâches</h3>
                        <span class="px-3 py-1 bg-amber-50 text-amber-600 text-[10px] font-black uppercase tracking-widest rounded-lg border border-amber-100">{{ $data['kpis']['tasks_due_today'] }} AUJOURD'HUI</span>
                    </div>
                    <div class="space-y-4">
                        @forelse($data['lists']['tasks'] as $task)
                            <div class="flex items-center gap-4 group p-3 rounded-xl hover:bg-gray-50 transition-colors">
                                <div class="h-3 w-3 rounded-full {{ $task->due_date < now() ? 'bg-rose-500 shadow-[0_0_10px_rgba(244,63,94,0.4)]' : 'bg-gray-200' }} group-hover:scale-125 transition-transform"></div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-bold text-gray-800 truncate group-hover:text-amber-600 transition-colors">{{ $task->titre }}</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">{{ $task->due_date->translatedFormat('d F Y') }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400 italic text-center py-4 font-medium">Tout est accompli !</p>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Activities (Premium Timeline) -->
                <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100/50 p-8">
                    <h3 class="text-xl font-black text-gray-900 tracking-tight mb-8">Journal d'Activité</h3>
                    <div class="space-y-8 relative before:absolute before:inset-0 before:left-[11px] before:border-l-2 before:border-gray-50">
                        @forelse($data['lists']['recent_activities'] as $activity)
                            <div class="relative flex gap-5 pl-2 group">
                                <div class="h-6 w-6 rounded-full bg-white border-4 border-white ring-2 ring-gray-100 z-10 flex-shrink-0 group-hover:ring-indigo-100 transition-all"></div>
                                <div class="flex-1 min-w-0 -mt-1">
                                    <p class="text-[13px] font-bold text-gray-700 leading-snug group-hover:text-gray-900 transition-colors">{{ $activity->description }}</p>
                                    <div class="flex items-center mt-1.5 gap-2">
                                        <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <p class="text-[10px] text-gray-400 font-extrabold uppercase tracking-widest">{{ $activity->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400 italic text-center py-4 relative z-10 bg-white font-medium">Aucun journal récent.</p>
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
        // Status Distribution Chart (Refined Styles)
        const distributionCtx = document.getElementById('statusDistributionChart').getContext('2d');
        const rawData = @json($data['charts']['status_distribution']);
        
        const stagesConfig = [
            { key: 'prospection', label: 'Prospection', color: '#6366F1', gradient: ['#6366F1', '#818CF8'] },
            { key: 'qualification', label: 'Qualification', color: '#8B5CF6', gradient: ['#8B5CF6', '#A78BFA'] },
            { key: 'proposition', label: 'Proposition', color: '#EC4899', gradient: ['#EC4899', '#F472B6'] },
            { key: 'negociation', label: 'Négociation', color: '#F59E0B', gradient: ['#F59E0B', '#FBBF24'] },
            { key: 'gagne', label: 'Gagné', color: '#10B981', gradient: ['#10B981', '#34D399'] },
            { key: 'perdu', label: 'Perdu', color: '#94A3B8', gradient: ['#94A3B8', '#CBD5E1'] }
        ];

        const labels = stagesConfig.map(s => s.label);
        const dataValues = stagesConfig.map(s => Number(rawData[s.key] || 0));

        // Create Gradients
        const backgroundGradients = stagesConfig.map(s => {
            const grad = distributionCtx.createLinearGradient(0, 0, 0, 400);
            grad.addColorStop(0, s.gradient[0]);
            grad.addColorStop(1, s.gradient[1]);
            return grad;
        });

        const statusChart = new Chart(distributionCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Opportunités',
                    data: dataValues,
                    backgroundColor: backgroundGradients,
                    hoverBackgroundColor: stagesConfig.map(s => s.color),
                    borderRadius: 12,
                    borderSkipped: false,
                    maxBarThickness: 45,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: { bottom: 20 }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#111827',
                        titleFont: { family: "'Inter', sans-serif", size: 12, weight: '900' },
                        bodyFont: { family: "'Inter', sans-serif", size: 12, weight: '700' },
                        padding: 16,
                        cornerRadius: 16,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' OPPORTUNITÉS';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#F1F5F9',
                            drawBorder: false,
                        },
                        ticks: {
                            font: { family: "'Inter', sans-serif", size: 11, weight: '700' },
                            color: '#94A3B8',
                            padding: 10,
                            callback: value => value % 1 === 0 ? value : null
                        },
                        border: { display: false }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { family: "'Inter', sans-serif", size: 11, weight: '700' },
                            color: '#94A3B8',
                            padding: 15
                        },
                        border: { display: false }
                    }
                }
            }
        });
    });
</script>
@endpush
