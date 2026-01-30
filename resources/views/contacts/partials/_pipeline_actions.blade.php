@php
    $stages = \App\Models\Contact::getStages();
    $currentStage = $contact->statut;
    $stageData = $stages[$currentStage] ?? null;
    $nextStage = $contact->getNextStage();
@endphp

@if($stageData)
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-6">
    <div @class([
        'px-6 py-4 flex items-center justify-between border-b border-opacity-10',
        'bg-slate-50 border-slate-900' => $currentStage === 'nouveau',
        'bg-amber-50 border-amber-900' => $currentStage === 'qualifie',
        'bg-indigo-50 border-indigo-900' => $currentStage === 'proposition',
        'bg-blue-50 border-blue-900' => $currentStage === 'negociation',
        'bg-emerald-50 border-emerald-900' => $currentStage === 'client',
        'bg-rose-50 border-rose-900' => $currentStage === 'perdu',
    ])>
        <div class="flex items-center gap-3">
            <div @class([
                'h-10 w-10 rounded-lg flex items-center justify-center text-white shadow-sm',
                'bg-slate-500' => $currentStage === 'nouveau',
                'bg-amber-500' => $currentStage === 'qualifie',
                'bg-indigo-500' => $currentStage === 'proposition',
                'bg-blue-500' => $currentStage === 'negociation',
                'bg-emerald-500' => $currentStage === 'client',
                'bg-rose-500' => $currentStage === 'perdu',
            ])>
                @php
                    $icon = match($currentStage) {
                        'nouveau' => 'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z',
                        'qualifie' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                        'proposition' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                        'negociation' => 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z',
                        'client' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z',
                        'perdu' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z',
                        default => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
                    };
                @endphp
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"></path></svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-900">{{ $stageData['label'] }}</h3>
                <p class="text-[11px] text-slate-600">{{ $stageData['description'] }}</p>
            </div>
        </div>

        @if($nextStage)
            <div x-data="{}">
                <form id="next-stage-form" action="{{ route('contacts.updateStage', $contact) }}" method="POST" class="hidden">
                    @csrf @method('PATCH')
                    <input type="hidden" name="statut" value="{{ $nextStage }}">
                </form>
                <button type="button" 
                        @click="openQuickModal(
                            'Passer à l\'étape suivante ?', 
                            'Le contact passera en stage : {{ \App\Models\Contact::getStages()[$nextStage]['label'] }}', 
                            'check', 
                            'bg-indigo-100 text-indigo-600', 
                            () => { document.getElementById('next-stage-form').submit(); }
                        )"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-xs font-bold rounded-lg hover:bg-indigo-700 transition-all shadow-sm hover:shadow-md">
                    Passer en {{ \App\Models\Contact::getStages()[$nextStage]['label'] }}
                    <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </button>
            </div>
        @elseif($currentStage !== 'perdu')
             <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">
                <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                Pipeline complété
             </span>
        @endif
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @if($currentStage === 'nouveau')
                <!-- Stage 1 Buttons -->
                <button type="button" 
                        @click="openQuickModal(
                            'Appeler {{ $contact->prenom }} ?', 
                            'Démarrer un appel téléphonique vers {{ $contact->telephone }}', 
                            'phone', 
                            'bg-slate-100 text-slate-600', 
                            () => { window.location.href='tel:{{ $contact->telephone }}'; }
                        )"
                        class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 hover:border-indigo-500 hover:bg-indigo-50 transition-all group">
                    <div class="h-8 w-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center group-hover:bg-indigo-500 group-hover:text-white transition-colors">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    </div>
                    <span class="text-xs font-bold text-slate-700">Appeler</span>
                </button>
                <button type="button"
                        @click="openQuickModal(
                            'Envoyer un Email ?', 
                            'Ouvrir votre messagerie pour écrire à {{ $contact->email }}', 
                            'mail', 
                            'bg-slate-100 text-slate-600', 
                            () => { window.location.href='mailto:{{ $contact->email }}'; }
                        )"
                        class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 hover:border-indigo-500 hover:bg-indigo-50 transition-all group">
                    <div class="h-8 w-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center group-hover:bg-indigo-500 group-hover:text-white transition-colors">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <span class="text-xs font-bold text-slate-700">Envoyer un email</span>
                </button>
                <button type="button"
                        @click="openQuickModal(
                            'Ajouter une note ?', 
                            'Ouvrir le formulaire de rédaction de note pour ce contact', 
                            'note', 
                            'bg-slate-100 text-slate-600', 
                            () => { showActivityForm = true; activeTab = 'activities'; }
                        )"
                        class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 hover:border-indigo-500 hover:bg-indigo-50 transition-all group">
                    <div class="h-8 w-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center group-hover:bg-indigo-500 group-hover:text-white transition-colors">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <span class="text-xs font-bold text-slate-700">Ajouter une note</span>
                </button>
            @endif

            @if($currentStage === 'qualifie')
                <button type="button" 
                        @click="openQuickModal(
                            'Planifier un RDV ?', 
                            'Ouvrir le formulaire de création de tâche pour ce contact', 
                            'check', 
                            'bg-amber-100 text-amber-600', 
                            () => { showTaskForm = true; activeTab = 'tasks'; }
                        )"
                        class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 hover:border-amber-500 hover:bg-amber-50 transition-all group">
                    <div class="h-8 w-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-colors">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <span class="text-xs font-bold text-slate-700">Planifier RDV</span>
                </button>
                <button type="button"
                        @click="openQuickModal(
                            'Modifier la fiche ?', 
                            'Rediriger vers la page de modification complète du contact', 
                            'note', 
                            'bg-amber-100 text-amber-600', 
                            () => { window.location.href='{{ route('contacts.edit', $contact) }}'; }
                        )"
                        class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 hover:border-amber-500 hover:bg-amber-50 transition-all group">
                    <div class="h-8 w-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-colors">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    </div>
                    <span class="text-xs font-bold text-slate-700">Modifier la fiche</span>
                </button>
                <button type="button"
                        @click="openQuickModal(
                            'Qualifier le contact ?', 
                            'Ouvrir le formulaire de gestion des opportunités', 
                            'check', 
                            'bg-amber-100 text-amber-600', 
                            () => { showOppForm = true; activeTab = 'opportunites'; }
                        )"
                        class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 hover:border-amber-500 hover:bg-amber-50 transition-all group">
                    <div class="h-8 w-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-colors">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                    <span class="text-xs font-bold text-slate-700">Qualifier le contact</span>
                </button>
            @endif

            @if($currentStage === 'proposition')
                <button type="button" 
                        @click="openQuickModal(
                            'Créer un devis ?', 
                            'Accéder à la section des opportunités pour générer un devis', 
                            'note', 
                            'bg-indigo-100 text-indigo-600', 
                            () => { showOppForm = true; activeTab = 'opportunites'; }
                        )"
                        class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 hover:border-indigo-500 hover:bg-indigo-50 transition-all group">
                    <div class="h-8 w-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center group-hover:bg-indigo-500 group-hover:text-white transition-colors">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <span class="text-xs font-bold text-slate-700">Créer un devis</span>
                </button>
                <button type="button"
                        @click="openQuickModal(
                            'Envoyer la proposition ?', 
                            'Confirmer l\'envoi de la proposition commerciale par email', 
                            'mail', 
                            'bg-indigo-100 text-indigo-600', 
                            () => { /* Action symbolique */ }
                        )"
                        class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 hover:border-indigo-500 hover:bg-indigo-50 transition-all group">
                    <div class="h-8 w-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center group-hover:bg-indigo-500 group-hover:text-white transition-colors">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    </div>
                    <span class="text-xs font-bold text-slate-700">Envoyer prop.</span>
                </button>
            @endif

            @if($currentStage === 'negociation')
                <div class="col-span-1 md:col-span-2 flex gap-4" x-data="{}">
                    <form id="won-form" action="{{ route('contacts.updateStage', $contact) }}" method="POST" class="hidden">
                        @csrf @method('PATCH')
                        <input type="hidden" name="statut" value="client">
                    </form>
                    <button type="button" 
                            @click="openQuickModal(
                                'Confirmer la VENTE ?', 
                                'Félicitations ! Le contact va être converti en Client Actif.', 
                                'check', 
                                'bg-emerald-100 text-emerald-600', 
                                () => { document.getElementById('won-form').submit(); }
                            )"
                            class="flex-1 flex items-center justify-center gap-3 p-3 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 transition-all shadow-md active:scale-95">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span class="text-xs font-bold">Marquer comme GAGNÉ</span>
                    </button>

                    <form id="lost-form" action="{{ route('contacts.updateStage', $contact) }}" method="POST" class="hidden">
                        @csrf @method('PATCH')
                        <input type="hidden" name="statut" value="perdu">
                    </form>
                    <button type="button" 
                            @click="openQuickModal(
                                'Confirmer la PERTE ?', 
                                'Le contact sera marqué comme Perdu. Vous pourrez le réactiver plus tard si besoin.', 
                                'check', 
                                'bg-rose-100 text-rose-600', 
                                () => { document.getElementById('lost-form').submit(); }
                            )"
                            class="flex-1 flex items-center justify-center gap-3 p-3 rounded-xl border border-rose-200 text-rose-600 hover:bg-rose-50 transition-all active:scale-95">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        <span class="text-xs font-bold">Marquer comme PERDU</span>
                    </button>
                </div>
            @endif

            @if($currentStage === 'client')
                <button type="button" 
                        @click="openQuickModal(
                            'Générer une facture ?', 
                            'Démarrer le processus de facturation pour ce client', 
                            'note', 
                            'bg-emerald-100 text-emerald-600', 
                            () => { /* Action symbolique */ }
                        )"
                        class="flex items-center gap-3 p-3 rounded-xl border border-emerald-200 bg-emerald-50 hover:bg-emerald-100 transition-all group">
                    <div class="h-8 w-8 rounded-lg bg-emerald-500 text-white flex items-center justify-center">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                    <span class="text-xs font-bold text-emerald-800">Créer Facture</span>
                </button>
                <button type="button" 
                        @click="openQuickModal(
                            'Relance Fidélité ?', 
                            'Planifier une tâche de relance pour maintenir la relation client', 
                            'check', 
                            'bg-slate-100 text-slate-600', 
                            () => { showTaskForm = true; activeTab = 'tasks'; }
                        )"
                        class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 hover:border-emerald-500 hover:bg-emerald-50 transition-all group">
                    <div class="h-8 w-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    </div>
                    <span class="text-xs font-bold text-slate-700">Relance Fidélité</span>
                </button>
            @endif

            @if($currentStage === 'perdu')
                <div x-data="{}">
                    <form id="reactivate-form" action="{{ route('contacts.updateStage', $contact) }}" method="POST" class="hidden">
                        @csrf @method('PATCH')
                        <input type="hidden" name="statut" value="nouveau">
                    </form>
                    <button type="button" 
                            @click="openQuickModal(
                                'Réactiver ce contact ?', 
                                'Le contact sera remis au début du pipeline (Nouveau)', 
                                'check', 
                                'bg-indigo-100 text-indigo-600', 
                                () => { document.getElementById('reactivate-form').submit(); }
                            )"
                            class="w-full flex items-center gap-3 p-3 rounded-xl border border-slate-200 hover:border-indigo-500 hover:bg-indigo-50 transition-all group">
                        <div class="h-8 w-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center group-hover:bg-indigo-500 group-hover:text-white transition-colors">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-slate-700">Réactiver Contact</span>
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>
@endif
