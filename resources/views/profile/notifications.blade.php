@extends('layouts.app')

@section('title', 'Préférences de notifications')

@section('content')
<div class="min-h-screen bg-slate-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-10 text-center">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Centrale de Notifications</h1>
            <p class="mt-3 text-lg text-slate-500 max-w-2xl mx-auto">Personnalisez votre expérience en choisissant précisément ce qui mérite votre attention.</p>
        </div>

        <form action="{{ route('notifications.settings.update') }}" method="POST">
            @csrf
            
            <div class="space-y-8">
                
                @php
                    $groups = [
                        'Activités Commerciales' => [
                            'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                            'color' => 'text-emerald-500',
                            'bg' => 'bg-emerald-50',
                            'items' => ['opportunity_created', 'opportunity_updated', 'opportunity_won', 'opportunity_lost']
                        ],
                        'Gestion des Contacts' => [
                            'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
                            'color' => 'text-blue-500',
                            'bg' => 'bg-blue-50',
                            'items' => ['contact_created', 'contact_updated', 'contact_deleted']
                        ],
                        'Tâches & Rappels' => [
                            'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
                            'color' => 'text-amber-500',
                            'bg' => 'bg-amber-50',
                            'items' => ['task_created', 'task_completed', 'task_overdue']
                        ]
                    ];

                    if(auth()->user()->isAdmin()) {
                         $groups['Administration'] = [
                            'icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z',
                            'color' => 'text-rose-500',
                            'bg' => 'bg-rose-50',
                            'items' => ['performance_report', 'user_activity']
                        ];
                    }
                @endphp

                @foreach($groups as $groupName => $group)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden transform transition-all hover:shadow-md">
                    <div class="px-6 py-5 border-b border-slate-100 {{ $group['bg'] }} bg-opacity-50 flex items-center gap-4">
                        <div class="h-10 w-10 rounded-xl {{ $group['bg'] }} flex items-center justify-center shadow-sm">
                            <svg class="h-6 w-6 {{ $group['color'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $group['icon'] }}" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800">{{ $groupName }}</h3>
                    </div>
                    
                    <div class="divide-y divide-slate-50">
                        @foreach($group['items'] as $key)
                            @if(isset($eventTypes[$key]))
                                @php
                                    $pref = $preferences[$key] ?? null;
                                    $mail = $pref ? $pref->email_enabled : true; 
                                    $push = $pref ? $pref->push_enabled : true;
                                @endphp
                                <div class="px-6 py-5 flex items-center justify-between hover:bg-slate-50/50 transition-colors">
                                    <div class="flex-1 pr-8">
                                        <p class="text-sm font-semibold text-slate-900">{{ $eventTypes[$key] }}</p>
                                        <p class="text-xs text-slate-500 mt-1">
                                            @if(str_contains($key, 'created')) Alerte lors de la création.
                                            @elseif(str_contains($key, 'updated')) Alerte lors d'une modification.
                                            @elseif(str_contains($key, 'won')) Célébration d'un succès.
                                            @elseif(str_contains($key, 'overdue')) Rappel critique de retard.
                                            @else Notification standard pour cet événement.
                                            @endif
                                        </p>
                                    </div>
                                    
                                    <div class="flex items-center gap-6">
                                        <!-- Email Switch -->
                                        <div class="flex flex-col items-center gap-2">
                                            <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Email</span>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" name="preferences[{{$key}}][email]" value="1" class="sr-only peer" {{ $mail ? 'checked' : '' }}>
                                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                            </label>
                                        </div>

                                        <!-- Push Switch -->
                                        <div class="flex flex-col items-center gap-2">
                                            <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Interne</span>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" name="preferences[{{$key}}][push]" value="1" class="sr-only peer" {{ $push ? 'checked' : '' }}>
                                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endforeach

            </div>

            <!-- Sticky Footer Action -->
            <div class="fixed bottom-0 left-0 right-0 bg-white/80 backdrop-blur-md border-t border-slate-200 p-4 flex justify-center z-50">
                <button type="submit" class="inline-flex items-center px-8 py-3 border border-transparent shadow-lg text-sm font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-transform transform hover:scale-105">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Enregistrer mes préférences
                </button>
            </div>
            <div class="h-20"></div> <!-- Spacer for fixed footer -->
        </form>
    </div>
</div>
@endsection
