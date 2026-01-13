@extends('layouts.app')

@section('title', 'Mon Tableau de Bord')

@section('content')
<div class="min-h-screen bg-gray-50/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Espace Commercial</h2>
                <p class="text-sm text-gray-500 mt-1">Boostez vos ventes et suivez vos objectifs.</p>
            </div>
            <div>
                <a href="{{ route('opportunities.create') }}" class="inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-xl shadow-lg shadow-indigo-500/30 text-white bg-indigo-600 hover:bg-indigo-700 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Nouvelle Opportunité
                </a>
            </div>
        </div>

        <!-- KPIs Grid -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-600 to-indigo-700 p-6 shadow-lg text-white">
                <dt>
                    <p class="text-indigo-100 text-sm font-medium uppercase tracking-wider">Mon Prévisionnel</p>
                </dt>
                <dd class="mt-2 flex items-baseline">
                    <p class="text-3xl font-bold text-white">{{ format_currency($data['kpis']['my_forecast_revenue']) }}</p>
                </dd>
            </div>

            <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-900/5 transition-all hover:shadow-md">
                <dt>
                    <div class="absolute rounded-xl bg-purple-50 p-3">
                        <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                    <p class="ml-16 truncate text-sm font-medium text-gray-500">Leads en cours</p>
                </dt>
                <dd class="ml-16 flex items-baseline">
                    <p class="text-2xl font-bold text-gray-900">{{ $data['kpis']['my_leads_opps'] }}</p>
                </dd>
            </div>

            <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-900/5 transition-all hover:shadow-md">
                <dt>
                    <div class="absolute rounded-xl bg-blue-50 p-3">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <p class="ml-16 truncate text-sm font-medium text-gray-500">Ma Conversion</p>
                </dt>
                <dd class="ml-16 flex items-baseline">
                    <p class="text-2xl font-bold text-gray-900">{{ $data['kpis']['my_conversion_rate'] }}%</p>
                </dd>
            </div>

            <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-900/5 transition-all hover:shadow-md border-l-4 {{ $data['kpis']['tasks_overdue'] > 0 ? 'border-red-500' : 'border-emerald-500' }}">
                <dt>
                    <div class="absolute rounded-xl {{ $data['kpis']['tasks_overdue'] > 0 ? 'bg-red-50' : 'bg-emerald-50' }} p-3">
                         <svg class="h-6 w-6 {{ $data['kpis']['tasks_overdue'] > 0 ? 'text-red-600' : 'text-emerald-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="ml-16 truncate text-sm font-medium text-gray-500">Tâches en retard</p>
                </dt>
                <dd class="ml-16 flex items-baseline">
                    <p class="text-2xl font-bold {{ $data['kpis']['tasks_overdue'] > 0 ? 'text-red-600' : 'text-gray-900' }}">{{ $data['kpis']['tasks_overdue'] }}</p>
                </dd>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Side: Progress and Pipeline (2 Cols) -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Goal Achievement -->
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-semibold text-gray-900">Objectif du Mois</h3>
                        <span class="text-sm font-bold text-indigo-600">{{ $data['kpis']['goal_percentage'] }}% atteint</span>
                    </div>
                    <div class="relative w-full bg-slate-100 rounded-full h-4 overflow-hidden">
                        <div class="absolute top-0 left-0 h-full bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full transition-all duration-1000" style="width:{{ $data['kpis']['goal_percentage'] }}%"></div>
                    </div>
                    <p class="mt-2 text-xs text-slate-500 italic">Objectif basé sur les opportunités gagnées ce mois-ci par rapport au quota de 50 000€.</p>
                </div>

                <!-- Personal Pipeline -->
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                    <h3 class="text-base font-semibold text-gray-900 mb-6">Mon Pipeline Personnel</h3>
                    <div class="space-y-4">
                        @foreach($data['charts']['pipeline_by_stage'] as $stage)
                            @php
                                $totalOps = $data['kpis']['my_leads_opps'] ?: 1;
                                $percentage = round(($stage->count / $totalOps) * 100);
                                $colorClass = match($stage->stade) {
                                    'prospection' => 'bg-indigo-500',
                                    'qualification' => 'bg-purple-500',
                                    'proposition' => 'bg-pink-500',
                                    'negociation' => 'bg-amber-500',
                                    'gagne' => 'bg-emerald-500',
                                    'perdu' => 'bg-rose-500',
                                    default => 'bg-slate-500'
                                };
                            @endphp
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="font-medium text-slate-700 capitalize">{{ $stage->stade }}</span>
                                    <span class="text-slate-500">{{ $stage->count }} • {{ format_currency($stage->total_amount) }}</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-2">
                                    <div class="{{ $colorClass }} h-2 rounded-full transition-all duration-1000" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Hot Opportunities -->
                <div class="rounded-2xl bg-white shadow-sm ring-1 ring-gray-900/5 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-base font-semibold text-gray-900">Opportunités à Fort Potentiel</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-widest">Opportunité</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-widest">Contact</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-widest">Montant</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @forelse($data['lists']['hot_opportunities'] as $opp)
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 font-medium">{{ $opp->titre }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $opp->contact->nom ?? 'Inconnu' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 font-bold text-right">{{ format_currency($opp->montant_estime) }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="px-6 py-8 text-center text-slate-500 italic text-sm">Aucune opportunité à fort potentiel.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Column: Sidebar -->
            <div class="space-y-6">
                <!-- Meetings List -->
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                    <h3 class="text-base font-semibold text-gray-900 mb-4">Prochains Rendez-vous</h3>
                    <ul class="space-y-4">
                        @forelse($data['lists']['next_meetings'] as $meeting)
                            <li class="flex items-start space-x-3">
                                <div class="flex-shrink-0 mt-1">
                                    <div class="h-2 w-2 rounded-full bg-indigo-500 mt-1.5"></div>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-slate-800 truncate">{{ $meeting->description }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase">{{ $meeting->date_activite->translatedFormat('d M à H:i') }}</p>
                                </div>
                            </li>
                        @empty
                            <li class="text-center text-slate-400 text-sm italic">Aucun RDV prévu.</li>
                        @endforelse
                    </ul>
                </div>

                <!-- Tasks List -->
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-semibold text-gray-900">Mes Tâches</h3>
                        <span class="px-2 py-0.5 rounded-full bg-amber-50 text-amber-600 text-[10px] font-black uppercase tracking-widest">{{ $data['kpis']['tasks_due_today'] }} aujourd'hui</span>
                    </div>
                    <ul class="space-y-4">
                        @forelse($data['lists']['tasks'] as $task)
                            <li class="flex items-start space-x-3">
                                <div class="flex-shrink-0 mt-1">
                                    <svg class="h-4 w-4 {{ $task->due_date < now() ? 'text-rose-500' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-slate-800 truncate">{{ $task->titre }}</p>
                                    <p class="text-xs text-slate-500">{{ $task->due_date->translatedFormat('d F Y à H:i') }}</p>
                                </div>
                            </li>
                        @empty
                            <li class="text-center text-slate-400 text-sm italic">Aucune tâche prévue.</li>
                        @endforelse
                    </ul>
                </div>

                <!-- Recent Activities -->
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                    <h3 class="text-base font-semibold text-gray-900 mb-4">Mes Dernières Actions</h3>
                    <div class="flow-root">
                        <ul class="-mb-8">
                            @forelse($data['lists']['recent_activities'] as $activity)
                                <li>
                                    <div class="relative pb-8">
                                        @if(!$loop->last)
                                            <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-gray-100" aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex space-x-3">
                                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-50 ring-4 ring-white">
                                                <svg class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 justify-between flex space-x-2">
                                                <p class="text-xs text-gray-500 truncate">{{ $activity->description }}</p>
                                                <div class="text-right text-[10px] whitespace-nowrap text-gray-400">
                                                    {{ $activity->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="text-xs text-gray-500 italic">Aucune action récente.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
