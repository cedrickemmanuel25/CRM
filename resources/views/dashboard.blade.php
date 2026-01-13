@extends('layouts.app')

@section('title', 'Tableau de Bord')

@section('content')
<div class="mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    <!-- Header & Welcome -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">
                Bonjour, {{ auth()->user()->prenom ?? auth()->user()->name }} 👋
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Performance et activités du jour.
            </p>
        </div>
        <div class="mt-4 sm:mt-0 flex space-x-3">
             <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                {{ now()->translatedFormat('l d F Y') }}
             </span>
        </div>
    </div>

    <!-- KPI Grid -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        
        <!-- KPI 1: Leads/Opps -->
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-slate-200">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="p-3 rounded-lg bg-indigo-50 text-indigo-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-slate-500 truncate">
                                @if(auth()->user()->isCommercial()) Mes Opportunités @else Total Opportunités @endif
                            </dt>
                            <dd>
                                <div class="text-2xl font-bold text-slate-900">
                                    {{ $data['kpis']['my_leads_opps'] ?? $data['kpis']['total_leads_opps'] ?? $data['kpis']['total_opportunities'] ?? 0 }}
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPI 2: Revenue -->
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-slate-200">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="p-3 rounded-lg bg-emerald-50 text-emerald-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-slate-500 truncate">CA Prévisionnel</dt>
                            <dd>
                                <div class="text-2xl font-bold text-slate-900">
                                    {{ format_currency($data['kpis']['my_forecast_revenue'] ?? $data['kpis']['global_forecast_revenue'] ?? $data['kpis']['forecast_revenue'] ?? 0) }}
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPI 3: Conversion Rate -->
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-slate-200">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="p-3 rounded-lg bg-purple-50 text-purple-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-slate-500 truncate">Taux de conversion</dt>
                            <dd>
                                <div class="text-2xl font-bold text-slate-900">
                                    {{ $data['kpis']['my_conversion_rate'] ?? $data['kpis']['avg_conversion_rate'] ?? $data['kpis']['conversion_rate'] ?? 0 }}%
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPI 4: Overdue Tasks Alert -->
        @php
            $overdueCount = count($data['lists']['overdue_tasks'] ?? []);
        @endphp
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border {{ $overdueCount > 0 ? 'border-rose-200 ring-2 ring-rose-50' : 'border-slate-200' }}">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="p-3 rounded-lg {{ $overdueCount > 0 ? 'bg-rose-100 text-rose-600' : 'bg-slate-50 text-slate-400' }}">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium {{ $overdueCount > 0 ? 'text-rose-600' : 'text-slate-500' }} truncate">Tâches en retard</dt>
                            <dd>
                                <div class="text-2xl font-bold {{ $overdueCount > 0 ? 'text-rose-700' : 'text-slate-900' }}">
                                    {{ $overdueCount }}
                                </div>
                                @if($overdueCount > 0)
                                    <p class="text-xs text-rose-500 mt-1 font-semibold">Action requise !</p>
                                @endif
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column (2/3): Charts & Pipeline -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Pipeline Chart -->
            <div class="bg-white shadow-sm rounded-xl border border-slate-200 p-6">
                <h3 class="text-base font-bold text-slate-900 mb-6 flex items-center">
                    <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Pipeline Commercial
                </h3>
                <div class="space-y-5">
                    @forelse($data['charts']['pipeline_by_stage'] ?? [] as $stageData)
                        @php
                            $colors = [
                                'prospection' => 'bg-indigo-300',
                                'qualification' => 'bg-indigo-400',
                                'proposition' => 'bg-indigo-500',
                                'negociation' => 'bg-indigo-600',
                                'gagne' => 'bg-emerald-500',
                                'perdu' => 'bg-rose-400',
                            ];
                            $colorClass = $colors[$stageData->stade] ?? 'bg-slate-300';
                            $totalOps = ($data['kpis']['total_opportunities'] ?? $data['kpis']['my_leads_opps'] ?? 1) ?: 1;
                            $percentage = round(($stageData->count / $totalOps) * 100);
                        @endphp
                        <div>
                            <div class="flex justify-between items-center text-sm mb-2">
                                <span class="font-medium text-slate-700 capitalize">{{ $stageData->stade }}</span>
                                <div class="text-right">
                                    <span class="font-bold text-slate-900">{{ $stageData->count }}</span>
                                    <span class="text-slate-400 text-xs mx-1">•</span>
                                    <span class="text-slate-600 font-mono text-xs">{{ format_currency($stageData->total_amount) }}</span>
                                </div>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                                <div class="{{ $colorClass }} h-3 rounded-full transition-all duration-1000 ease-out" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-slate-400 italic">Aucune donnée de pipeline disponible</div>
                    @endforelse
                </div>
            </div>

            <!-- Overdue Tasks List -->
            @if(count($data['lists']['overdue_tasks'] ?? []) > 0)
                <div class="bg-white shadow-sm rounded-xl border border-rose-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-rose-100 bg-rose-50/50 flex items-center justify-between">
                        <h3 class="text-base font-bold text-rose-800 flex items-center">
                            <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            Actions en retard
                        </h3>
                    </div>
                    <ul class="divide-y divide-rose-100">
                        @foreach($data['lists']['overdue_tasks'] as $task)
                            <li class="px-6 py-4 hover:bg-rose-50/30 transition-colors">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <input type="checkbox" class="h-4 w-4 text-rose-600 focus:ring-rose-500 border-gray-300 rounded">
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-slate-900">{{ $task->titre }}</p>
                                            <p class="text-xs text-rose-600 font-semibold">
                                                En retard de {{ $task->due_date->diffInDays() }} jours
                                                @if($task->related)
                                                    <span class="text-slate-400 font-normal">• {{ class_basename($task->related_type) }} #{{ $task->related_id }}</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <a href="{{ route('tasks.show', $task) }}" class="text-xs font-semibold text-rose-700 hover:text-rose-900">Voir -></a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>

        <!-- Right Column (1/3): Activities & Lists -->
        <div class="space-y-8">
            
            <!-- Activity Data -->
            <div class="bg-white shadow-sm rounded-xl border border-slate-200">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-900">Activité Récente</h3>
                </div>
                <div class="flow-root p-6">
                    <ul class="-mb-8">
                         @forelse($data['lists']['recent_activities'] ?? [] as $activity)
                            <li>
                                <div class="relative pb-8">
                                    @if(!$loop->last)
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-slate-100" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div class="h-8 w-8 rounded-full bg-slate-50 flex items-center justify-center border border-slate-100 ring-4 ring-white">
                                            <!-- Simple icon based on type (simplified) -->
                                             <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-slate-700">{{ $activity->description }}</p>
                                            </div>
                                            <div class="text-right text-xs whitespace-nowrap text-slate-400">
                                                {{ $activity->date_activite->diffForHumans(null, true, true) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="text-sm text-slate-500 italic text-center">Aucune activité récente.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
