@extends('layouts.app')

@section('title', 'Détails de la tâche')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-4" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-xs font-semibold text-slate-500">
            <li class="hover:text-slate-700 transition-colors">CRM PRO</li>
            <li><svg class="h-4 w-4 text-slate-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
            <li><a href="{{ route('tasks.index') }}" class="hover:text-slate-700 transition-colors">Tâches</a></li>
            <li><svg class="h-4 w-4 text-slate-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
            <li class="text-indigo-600 font-bold">#{{ $task->id }}</li>
        </ol>
    </nav>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-start">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{ $task->titre }}
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Détails et informations de suivi.
                </p>
            </div>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                @if($task->statut === 'done') bg-green-100 text-green-800 
                @elseif($task->statut === 'in_progress') bg-blue-100 text-blue-800 
                @else bg-gray-100 text-gray-800 @endif">
                @if($task->statut === 'done') Terminé
                @elseif($task->statut === 'in_progress') En cours
                @else À faire @endif
            </span>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Assigné à</dt>
                    <dd class="mt-1 text-sm text-gray-900 flex items-center">
                        @if($task->assignee)
                            <div class="h-6 w-6 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 text-xs font-bold mr-2">
                                {{ substr($task->assignee->name, 0, 1) }}
                            </div>
                            {{ $task->assignee->name }}
                        @else
                            <span class="italic text-gray-400">Non assigné</span>
                        @endif
                    </dd>
                </div>

                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Priorité</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        @if($task->priority === 'high')
                            <span class="text-red-600 font-bold flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M18 3a1 1 0 00-1.447-.894L8.763 6H5a3 3 0 000 6h.28l1.771 5.316A1 1 0 008 18h1a1 1 0 001-1v-4.382l6.553 3.276A1 1 0 0018 15V3z"/></svg>
                                Haute
                            </span>
                        @elseif($task->priority === 'medium')
                            <span class="text-amber-600 font-medium">Moyenne</span>
                        @else
                            <span class="text-slate-500">Basse</span>
                        @endif
                    </dd>
                </div>

                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Date d'échéance</dt>
                    <dd class="mt-1 text-sm text-gray-900 {{ $task->due_date < now() && $task->statut !== 'done' ? 'text-red-600 font-bold' : '' }}">
                        {{ $task->due_date->format('d/m/Y H:i') }}
                        @if($task->due_date < now() && $task->statut !== 'done')
                            <span class="ml-2 text-xs bg-red-100 text-red-800 px-2 py-0.5 rounded-full">En retard</span>
                        @endif
                    </dd>
                </div>

                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Créé par</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ $task->creator->name ?? 'Système' }}
                    </dd>
                </div>

                @if($task->related)
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Contexte (Lié à)</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        <a href="#" class="inline-flex items-center px-3 py-1 rounded-md bg-slate-50 border border-slate-200 text-slate-700 hover:bg-slate-100">
                            {{ class_basename($task->related_type) }} #{{ $task->related_id }}
                            <svg class="ml-1.5 w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                        </a>
                    </dd>
                </div>
                @endif

                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                    <dd class="mt-1 text-sm text-gray-900 bg-gray-50 rounded-lg p-3">
                        {{ $task->description ?: 'Aucune description fournie.' }}
                    </dd>
                </div>

            </dl>
        </div>
        <div class="bg-gray-50 px-4 py-4 sm:px-6 flex justify-end gap-3">
             <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Supprimer cette tâche ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Supprimer
                </button>
            </form>
            <a href="{{ route('tasks.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Retour
            </a>
            <!-- Note: Edit would typically open a modal like in Index, keeping it simple here -->
        </div>
    </div>
</div>
@endsection
