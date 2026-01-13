@extends('layouts.app')

@section('title', 'Tableau de bord Administrateur')

@section('content')
<div class="min-h-screen bg-gray-50/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        
        <!-- Header Section -->
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900">
                    Tableau de bord
                </h2>
                <p class="mt-2 text-sm text-gray-500">
                    Performance globale, alertes et tendances du système.
                </p>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
                <a href="{{ route('reports.print') }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-gray-200 shadow-sm text-sm font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-2 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Imprimer
                </a>
                <a href="{{ route('reports.export', ['type' => 'opportunities']) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export CSV
                </a>
            </div>
        </div>

        <!-- KPIs Grid -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <!-- KPIs from $data['kpis'] -->
            <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-900/5 transition-all hover:shadow-md">
                <dt>
                    <div class="absolute rounded-xl bg-indigo-50 p-3">
                        <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="ml-16 truncate text-sm font-medium text-gray-500">CA Prévisionnel Global</p>
                </dt>
                <dd class="ml-16 flex items-baseline">
                    <p class="text-2xl font-bold text-gray-900">{{ format_currency($data['kpis']['global_forecast_revenue']) }}</p>
                </dd>
            </div>

            <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-900/5 transition-all hover:shadow-md">
                <dt>
                    <div class="absolute rounded-xl bg-purple-50 p-3">
                        <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                    <p class="ml-16 truncate text-sm font-medium text-gray-500">Total Leads/Opps</p>
                </dt>
                <dd class="ml-16 flex items-baseline">
                    <p class="text-2xl font-bold text-gray-900">{{ $data['kpis']['total_leads_opps'] }}</p>
                </dd>
            </div>

            <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-900/5 transition-all hover:shadow-md">
                <dt>
                    <div class="absolute rounded-xl bg-blue-50 p-3">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <p class="ml-16 truncate text-sm font-medium text-gray-500">Utilisateurs Actifs</p>
                </dt>
                <dd class="ml-16 flex items-baseline">
                    <p class="text-2xl font-bold text-gray-900">{{ $data['kpis']['active_users_count'] }}</p>
                </dd>
            </div>

            <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-900/5 transition-all hover:shadow-md">
                <dt>
                    <div class="absolute rounded-xl bg-emerald-50 p-3">
                         <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <p class="ml-16 truncate text-sm font-medium text-gray-500">Taux Conversion Moy.</p>
                </dt>
                <dd class="ml-16 flex items-baseline">
                    <p class="text-2xl font-bold text-gray-900">{{ $data['kpis']['avg_conversion_rate'] }}%</p>
                </dd>
            </div>
        </div>

        <!-- Secondary KPIs -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
             <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-900/5 transition-all hover:shadow-md border-l-4 {{ $data['kpis']['overdue_tasks_all'] > 0 ? 'border-red-500' : 'border-emerald-500' }}">
                <dt>
                    <div class="absolute rounded-xl {{ $data['kpis']['overdue_tasks_all'] > 0 ? 'bg-red-50' : 'bg-emerald-50' }} p-3">
                         <svg class="h-6 w-6 {{ $data['kpis']['overdue_tasks_all'] > 0 ? 'text-red-600' : 'text-emerald-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="ml-16 truncate text-sm font-medium text-gray-500">Tâches en retard (Global)</p>
                </dt>
                <dd class="ml-16 flex items-baseline">
                    <p class="text-2xl font-bold {{ $data['kpis']['overdue_tasks_all'] > 0 ? 'text-red-600' : 'text-gray-900' }}">{{ $data['kpis']['overdue_tasks_all'] }}</p>
                </dd>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left & Center: Pipeline and Performance (2 Cols) -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Pipeline Visualization -->
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                    <h3 class="text-base font-semibold text-gray-900 mb-6">Pipeline Commercial Global</h3>
                    <div class="space-y-4">
                        @foreach($data['charts']['pipeline_by_stage'] as $stage)
                            @php
                                $totalOps = $data['kpis']['total_leads_opps'] ?: 1;
                                $percentage = round(($stage->count / $totalOps) * 100);
                                $colors = [
                                    'prospection' => 'bg-indigo-500',
                                    'qualification' => 'bg-purple-500',
                                    'proposition' => 'bg-pink-500',
                                    'negociation' => 'bg-amber-500',
                                    'gagne' => 'bg-emerald-500',
                                    'perdu' => 'bg-rose-500',
                                ];
                                $colorClass = $colors[$stage->stade] ?? 'bg-slate-500';
                            @endphp
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="font-medium text-slate-700 capitalize">{{ $stage->stade }}</span>
                                    <span class="text-slate-500">{{ $stage->count }} opportunités • {{ format_currency($stage->total_amount) }}</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-2">
                                    <div class="{{ $colorClass }} h-2 rounded-full transition-all duration-1000" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Revenue Trend -->
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                    <h3 class="text-base font-semibold text-gray-900 mb-6">Évolution Mensuelle du CA (Won)</h3>
                    <div class="flex items-end justify-between h-48 space-x-2">
                        @php
                            $maxRevenue = (float) $data['charts']['revenue_trend']->max('total') ?: 1;
                        @endphp
                        @foreach($data['charts']['revenue_trend'] as $trend)
                            @php
                                $height = round(($trend->total / $maxRevenue) * 100);
                            @endphp
                            <div class="flex-1 flex flex-col items-center group">
                                <div class="relative w-full bg-indigo-50 rounded-t-lg group-hover:bg-indigo-100 transition-colors" style="height: {{ $height }}%">
                                    <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10">
                                        {{ format_currency($trend->total) }}
                                    </div>
                                </div>
                                <span class="text-[10px] text-gray-400 mt-2 rotate-45 origin-left truncate w-12">{{ \Carbon\Carbon::parse($trend->month . '-01')->translatedFormat('M Y') }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Commercial Performance -->
                <div class="rounded-2xl bg-white shadow-sm ring-1 ring-gray-900/5 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-base font-semibold text-gray-900">Performance des Commerciaux</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commercial</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Ventes (Win)</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Pipeline Actif</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($data['lists']['commercial_performance'] as $perf)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs">
                                                {{ substr($perf->name, 0, 1) }}
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">{{ $perf->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-gray-900">
                                        {{ $perf->won_deals_count }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-indigo-600">
                                        {{ format_currency($perf->pipeline_value ?? 0) }}
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="px-6 py-4 text-center text-gray-500 italic text-sm">Pas de données.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Column: Sidebar Widgets -->
            <div class="space-y-8">
                <!-- Latest Users -->
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                    <h3 class="text-base font-semibold text-gray-900 mb-4">Derniers Utilisateurs</h3>
                    <div class="space-y-4">
                        @forelse($data['lists']['latest_users'] as $user)
                        <div class="flex items-center">
                            <div class="h-8 w-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-700 font-bold text-xs">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                <p class="text-[10px] text-gray-500 uppercase tracking-wider">{{ $user->role }}</p>
                            </div>
                        </div>
                        @empty
                        <p class="text-xs text-gray-500 italic">Aucun utilisateur récent.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                    <h3 class="text-base font-semibold text-gray-900 mb-6">Activités Récentes</h3>
                    <div class="flow-root">
                        <ul class="-mb-8">
                            @forelse($data['lists']['recent_activities'] as $activity)
                            <li>
                                <div class="relative pb-8">
                                    @if(!$loop->last)
                                    <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-gray-100" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div class="h-8 w-8 rounded-full bg-slate-50 flex items-center justify-center border border-gray-100 font-bold text-slate-400 text-xs italic font-serif">
                                            i
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-xs text-gray-500">
                                                    {{ $activity->description }}
                                                </p>
                                            </div>
                                            <div class="text-right text-[10px] whitespace-nowrap text-gray-400">
                                                {{ $activity->date_activite->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @empty
                            <li class="text-xs text-gray-500 italic">Aucune activité récente.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- Critical Tasks -->
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                    <h3 class="text-base font-semibold text-gray-900 mb-4">Tâches Critiques</h3>
                    <ul class="space-y-4">
                        @forelse($data['lists']['tasks'] as $task)
                        <li class="relative pl-4 border-l-2 {{ $task->due_date < now() ? 'border-red-500' : 'border-indigo-500' }}">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $task->titre }}</p>
                            <div class="flex items-center justify-between mt-1">
                                <span class="text-[10px] {{ $task->due_date < now() ? 'text-red-600 font-bold' : 'text-gray-500' }}">
                                    {{ \Carbon\Carbon::parse($task->due_date)->translatedFormat('d F Y') }}
                                </span>
                                <span class="text-[10px] text-gray-400">{{ $task->assignee->name ?? 'N/A' }}</span>
                            </div>
                        </li>
                        @empty
                        <li class="text-xs text-gray-500 italic">Aucune tâche critique.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
