@extends('layouts.app')

@section('title', 'Modifier Opportunité')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-4">
            <li>
                <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-gray-500">
                    <svg class="flex-shrink-0 h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                    <a href="{{ route('opportunities.index') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Opportunités</a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                    <span class="ml-4 text-sm font-medium text-gray-500" aria-current="page">Modifier {{ $opportunity->titre }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Modifier l'opportunité
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Mise à jour des informations et du stade.
                </p>
            </div>
            <form action="{{ route('opportunities.destroy', $opportunity) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette opportunité ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Supprimer
                </button>
            </form>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('opportunities.update', $opportunity) }}" method="POST">
                @csrf
                @method('PUT')
                @include('opportunities._form', ['opportunity' => $opportunity])
            </form>
        </div>
    </div>
</div>
@endsection
