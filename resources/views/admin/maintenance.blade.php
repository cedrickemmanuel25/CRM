@extends('layouts.app')

@section('title', 'Maintenance & RGPD')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-10">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Maintenance & RGPD</h1>
        <p class="mt-2 text-slate-500">Outils de sauvegarde, conformité RGPD et suppression de données.</p>
    </div>

    <!-- Sauvegarde Système -->
    <div class="bg-white shadow rounded-lg overflow-hidden mb-8">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Sauvegarde du Système</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Gérez les backups de votre base de données.</p>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <div class="sm:flex sm:items-start sm:justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-900">Sauvegarde Manuelle</h3>
                    <div class="mt-2 max-w-xl text-sm text-gray-500">
                        <p>Téléchargez une copie complète de la base de données (format JSON/SQL).</p>
                    </div>
                </div>
                <div class="mt-5 sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:flex sm:items-center">
                    <form action="{{ route('admin.backup.run') }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Lancer une sauvegarde
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Export RGPD -->
    <div class="bg-white shadow rounded-lg overflow-hidden mb-8">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Conformité RGPD</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Exportez toutes les données liées à un utilisateur spécifique.</p>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('admin.gdpr.export') }}" method="POST" class="sm:flex sm:items-center">
                @csrf
                <div class="w-full sm:max-w-xs">
                    <label for="user_id" class="sr-only">Utilisateur</label>
                    <select id="user_id" name="user_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Sélectionner un utilisateur</option>
                        @foreach(\App\Models\User::all() as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="mt-3 w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Exporter données (JSON)
                </button>
            </form>
        </div>
    </div>

    <!-- Suppression de données -->
    <div class="bg-red-50 shadow rounded-lg overflow-hidden border border-red-100">
         <div class="px-4 py-5 sm:px-6 border-b border-red-200 bg-red-50">
            <h3 class="text-lg leading-6 font-medium text-red-800">Zone de Danger</h3>
            <p class="mt-1 max-w-2xl text-sm text-red-600">Actions irréversibles sur les données.</p>
        </div>
        <div class="px-4 py-5 sm:p-6 bg-white">
             <div class="sm:flex sm:items-start sm:justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-900">Suppression définitive (Soft Deleted)</h3>
                    <div class="mt-2 max-w-xl text-sm text-gray-500">
                        <p>Supprimer définitivement tous les utilisateurs et éléments marqués comme "supprimés" (Corbeille).</p>
                    </div>
                </div>
                <div class="mt-5 sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:flex sm:items-center">
                    <form action="{{ route('admin.maintenance.cleanup') }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer DÉFINITIVEMENT toutes les données archivées ? Cette action est irréversible.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:text-sm">
                            Vidanger la corbeille
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
