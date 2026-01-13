@extends('layouts.app')

@section('title', 'Préférences de notifications')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="md:flex md:items-center md:justify-between mb-8">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Préférences de notifications
            </h2>
            <p class="mt-1 text-sm text-gray-500">Choisissez comment vous souhaitez être informé.</p>
        </div>
    </div>

    <form action="{{ route('notifications.settings.update') }}" method="POST">
        @csrf
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Canaux de communication</h3>
            </div>
            
            <ul class="divide-y divide-gray-200">
                @foreach($eventTypes as $key => $label)
                @php
                    $pref = $preferences[$key] ?? null;
                    $mail = $pref ? $pref->mail : true; // Default true
                    $db = $pref ? $pref->database : true; // Default true
                @endphp
                <li class="px-4 py-4 sm:px-6">
                    <div class="flex items-center justify-between">
                        <div class="flex flex-col">
                            <p class="text-sm font-medium text-gray-900">{{ $label }}</p>
                            <p class="text-xs text-gray-500">
                                @if($key === 'task_assigned') Lors de l'attribution d'une nouvelle tâche.
                                @elseif($key === 'task_reminder') Rappel avant l'échéance de la tâche.
                                @endif
                            </p>
                        </div>
                        <div class="flex space-x-4">
                            <!-- Email Toggle -->
                            <div class="flex items-center">
                                <input id="pref_{{$key}}_mail" name="preferences[{{$key}}][mail]" type="checkbox" value="1" {{ $mail ? 'checked' : '' }}
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="pref_{{$key}}_mail" class="ml-2 block text-sm text-gray-700">Email</label>
                            </div>
                            
                            <!-- App Toggle -->
                            <div class="flex items-center">
                                <input id="pref_{{$key}}_db" name="preferences[{{$key}}][database]" type="checkbox" value="1" {{ $db ? 'checked' : '' }}
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="pref_{{$key}}_db" class="ml-2 block text-sm text-gray-700">Interne</label>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Enregistrer les préférences
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
