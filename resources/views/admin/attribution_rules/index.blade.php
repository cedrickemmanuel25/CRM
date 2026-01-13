@extends('layouts.app')

@section('title', 'Règles d\'Attribution')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="md:flex md:items-center md:justify-between mb-8">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Règles d'Attribution Automatique
            </h2>
            <p class="mt-1 text-sm text-gray-500">Configurez comment les opportunités sont distribuées aux commerciaux.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Formulaire Création -->
        <div class="lg:col-span-1">
            <div class="bg-white shadow sm:rounded-lg overflow-hidden sticky top-8">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Nouvelle Règle</h3>
                    <form action="{{ route('admin.attribution-rules.store') }}" method="POST" class="mt-5 space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nom de la règle</label>
                            <input type="text" name="name" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Priorité (Plus haut = Premier)</label>
                            <input type="number" name="priority" value="10" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Critère</label>
                            <select name="criteria_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" x-data @change="$dispatch('criteria-change', $event.target.value)">
                                <option value="source">Source du Lead (ex: Web)</option>
                                <option value="amount_gt">Montant > X</option>
                                <option value="sector">Secteur (Entreprise contient)</option>
                                <option value="workload">Équilibrage de Charge (Défaut)</option>
                            </select>
                        </div>

                        <div x-data="{ show: true }" @criteria-change.window="show = $event.detail !== 'workload'">
                            <label class="block text-sm font-medium text-gray-700" x-show="show">Valeur du Critère</label>
                            <input type="text" name="criteria_value" x-show="show" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Ex: Web, 50000...">
                        </div>

                        <div x-data="{ show: true }" @criteria-change.window="show = $event.detail !== 'workload'">
                            <label class="block text-sm font-medium text-gray-700" x-show="show">Attribuer à</label>
                            <select name="target_user_id" x-show="show" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">-- Choisir un Commercial --</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <p x-show="!show" class="mt-2 text-sm text-gray-500 italic">L'équilibrage de charge assignera automatiquement au commercial le moins occupé.</p>
                        </div>

                        <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Ajouter la Règle
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Liste des Règles -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <ul class="divide-y divide-gray-200">
                    @forelse($rules as $rule)
                    <li>
                        <div class="px-4 py-4 sm:px-6 hover:bg-gray-50 flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-indigo-600 truncate">{{ $rule->name }}</p>
                                    <div class="ml-2 flex-shrink-0 flex">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Priorité: {{ $rule->priority }}
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-2 text-sm text-gray-500">
                                    @if($rule->criteria_type === 'source')
                                        Si Source = <strong>{{ $rule->criteria_value }}</strong>
                                    @elseif($rule->criteria_type === 'amount_gt')
                                        Si Montant > <strong>{{ $rule->criteria_value }} €</strong>
                                    @elseif($rule->criteria_type === 'sector')
                                        Si Secteur contient <strong>{{ $rule->criteria_value }}</strong>
                                    @elseif($rule->criteria_type === 'workload')
                                        <span class="italic">Équilibrage de charge automatique</span>
                                    @endif
                                    
                                    <span class="mx-1">→</span>
                                    
                                    @if($rule->target_user_id)
                                        Attribuer à <strong>{{ $rule->targetUser->name }}</strong>
                                    @else
                                        Assignation dynamique (Moins chargé)
                                    @endif
                                </div>
                            </div>
                            <div class="ml-4 flex-shrink-0">
                                <form action="{{ route('admin.attribution-rules.destroy', $rule) }}" method="POST" onsubmit="return confirm('Supprimer cette règle ?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    </li>
                    @empty
                    <li class="px-4 py-8 text-center text-sm text-gray-500">
                        Aucune règle définie. Toutes les opportunités seront traitées par l'équilibrage par défaut ou assignation manuelle.
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Alpine for dynamic form -->
<script src="//unpkg.com/alpinejs" defer></script>
@endsection
