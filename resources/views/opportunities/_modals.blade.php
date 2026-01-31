<!-- Modal 1: Prospection -> Qualification -->
<div x-show="showProspectionModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showProspectionModal = false">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form :action="transitionUrl" method="POST">
                @csrf
                <input type="hidden" name="stade" value="qualification">
                <input type="hidden" name="stay_in_stage" x-ref="stayInStageProspection" value="0">

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-bold text-gray-900">Démarrer la qualification du contact</h3>
                            <div class="mt-2 group-objective">
                                <p class="text-xs text-indigo-600 font-semibold uppercase tracking-wider">Objectif : S’assurer qu’un premier échange a bien eu lieu</p>
                            </div>
                            
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Type de premier contact</label>
                                    <select name="type_premier_contact" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="Appel">Appel</option>
                                        <option value="Email">Email</option>
                                        <option value="WhatsApp">WhatsApp</option>
                                        <option value="Autre">Autre</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Date du contact</label>
                                    <input type="date" name="date_premier_contact" value="{{ date('Y-m-d') }}" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Résumé de l’échange <span class="text-red-500">*</span></label>
                                    <textarea name="resume_premier_contact" required class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" rows="3" placeholder="Points clés discutés..."></textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Niveau d’intérêt</label>
                                    <select name="niveau_interet" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="Faible">Faible</option>
                                        <option value="Moyen" selected>Moyen</option>
                                        <option value="Élevé">Élevé</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 flex flex-col sm:flex-row-reverse gap-3">
                    <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-bold text-white hover:bg-indigo-700 focus:outline-none sm:w-auto sm:text-sm uppercase tracking-wide">
                        Passer en Qualification
                    </button>
                    <button type="submit" @click="$refs.stayInStageProspection.value = '1'" class="w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:w-auto sm:text-sm">
                        Enregistrer et rester en Prospection
                    </button>
                    <button type="button" @click="showProspectionModal = false" class="mt-3 sm:mt-0 w-full inline-flex justify-center rounded-xl border border-transparent px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-700 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 2: Qualification -> Proposition -->
<div x-show="showQualificationModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showQualificationModal = false">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form :action="transitionUrl" method="POST">
                @csrf
                <input type="hidden" name="stade" x-ref="targetStageQualif" value="proposition">

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-emerald-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-bold text-gray-900">Qualification du contact</h3>
                            <div class="mt-2 group-objective">
                                <p class="text-xs text-emerald-600 font-semibold uppercase tracking-wider">Objectif : Vérifier si le contact est une opportunité réelle</p>
                            </div>
                            
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Besoin identifié <span class="text-red-500">*</span></label>
                                    <textarea name="besoin" required class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" rows="2" x-model="activeOpportunity.besoin"></textarea>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Budget estimé (FCFA)</label>
                                        <input type="number" name="budget_estime" x-model="activeOpportunity.budget" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Priorité</label>
                                        <select name="priorite_qualification" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            <option value="Basse">Basse</option>
                                            <option value="Moyenne" selected>Moyenne</option>
                                            <option value="Haute">Haute</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Pouvoir de décision</label>
                                    <select name="pouvoir_decision" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="Décideur">Décideur</option>
                                        <option value="Influenceur">Influenceur</option>
                                        <option value="Non décideur">Non décideur</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Délai du projet</label>
                                    <select name="delai_projet_cat" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="Immédiat">Immédiat</option>
                                        <option value="< 3 mois">&lt; 3 mois</option>
                                        <option value="> 3 mois">&gt; 3 mois</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 flex flex-col sm:flex-row-reverse gap-3">
                    <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-emerald-600 text-base font-bold text-white hover:bg-emerald-700 focus:outline-none sm:w-auto sm:text-sm uppercase tracking-wide">
                        Passer en Proposition
                    </button>
                    <button type="submit" @click="$refs.targetStageQualif.value = 'prospection'" class="w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:w-auto sm:text-sm">
                        Revenir à Prospection
                    </button>
                    <button type="button" @click="showQualificationModal = false" class="mt-3 sm:mt-0 w-full inline-flex justify-center rounded-xl border border-transparent px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-700 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 3: Proposition -> Négociation -->
<div x-show="showPropositionModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showPropositionModal = false">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form :action="transitionUrl" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="stade" value="negociation">

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-bold text-gray-900">Créer et envoyer une proposition</h3>
                            <div class="mt-2 group-objective">
                                <p class="text-xs text-indigo-600 font-semibold uppercase tracking-wider">Objectif : Formaliser l’offre</p>
                            </div>
                            
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Type de proposition</label>
                                    <select name="type_proposition" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="Devis">Devis</option>
                                        <option value="Offre personnalisée">Offre personnalisée</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Montant proposé (FCFA)</label>
                                    <input type="number" name="montant_propose" x-model="activeOpportunity.montant" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Description de l’offre</label>
                                    <textarea name="description_offre" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" rows="2" placeholder="Détails du pack ou service..."></textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Document joint (PDF)</label>
                                    <input type="file" name="document_offre" accept=".pdf" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" name="send_email" id="send_email" value="1" checked class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="send_email" class="ml-2 block text-sm text-gray-900">Envoyer automatiquement par email</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 flex flex-col sm:flex-row-reverse gap-3">
                    <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-bold text-white hover:bg-indigo-700 focus:outline-none sm:w-auto sm:text-sm uppercase tracking-wide">
                        Passer en Négociation
                    </button>
                    <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:w-auto sm:text-sm">
                        Créer la proposition
                    </button>
                    <button type="button" @click="showPropositionModal = false" class="mt-3 sm:mt-0 w-full inline-flex justify-center rounded-xl border border-transparent px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-700 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 4: Négociation -> Gagné / Perdu -->
<div x-show="showNegociationModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showNegociationModal = false">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form :action="transitionUrl" method="POST">
                @csrf
                <input type="hidden" name="stade" x-ref="targetStageNegoc" value="negociation">
                <input type="hidden" name="stay_in_stage" x-ref="stayInStageNegoc" value="0">

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-amber-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-bold text-gray-900">Phase de négociation</h3>
                            <div class="mt-2 group-objective">
                                <p class="text-xs text-amber-600 font-semibold uppercase tracking-wider">Objectif : Finalisation des termes et conclusion</p>
                            </div>
                            
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Derniers retours client <span class="text-red-500">*</span></label>
                                    <textarea name="feedback_negociation" required class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" rows="3" placeholder="Quels sont les points de friction restants ?"></textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Obstacles éventuels</label>
                                    <select name="obstacles_negoc" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="Aucun">Aucun</option>
                                        <option value="Budget excessif">Budget excessif</option>
                                        <option value="Validation juridique">Validation juridique</option>
                                        <option value="Comparaison concurrence">Comparaison concurrence</option>
                                    </select>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Probabilité finale (%)</label>
                                        <input type="number" name="probabilite_finale" min="0" max="100" value="80" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Date de décision prévue</label>
                                        <input type="date" name="date_decision_prevue" value="{{ date('Y-m-d', strtotime('+7 days')) }}" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 flex flex-col sm:flex-row-reverse gap-3">
                    <button type="submit" @click="$refs.targetStageNegoc.value = 'gagne'" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-emerald-600 text-base font-bold text-white hover:bg-emerald-700 focus:outline-none sm:w-auto sm:text-sm uppercase tracking-wide">
                        Marquer Gagné
                    </button>
                    <button type="submit" @click="$refs.targetStageNegoc.value = 'perdu'" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-rose-600 text-base font-bold text-white hover:bg-rose-700 focus:outline-none sm:w-auto sm:text-sm uppercase tracking-wide">
                        Marquer Perdu
                    </button>
                    <button type="submit" @click="$refs.stayInStageNegoc.value = '1'; $refs.targetStageNegoc.value = 'negociation'" class="w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:w-auto sm:text-sm">
                        Enregistrer les notes
                    </button>
                    <button type="button" @click="showNegociationModal = false" class="mt-3 sm:mt-0 w-full inline-flex justify-center rounded-xl border border-transparent px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-700 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 5: Gagné (Conversion en client) -->
<div x-show="showWonModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showWonModal = false">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form :action="transitionUrl" method="POST">
                @csrf
                <input type="hidden" name="stade" value="gagne">

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-emerald-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-bold text-gray-900">Conversion en client</h3>
                            <div class="mt-2 group-objective">
                                <p class="text-xs text-emerald-600 font-semibold uppercase tracking-wider">Objectif : Passage commercial → opérationnel</p>
                            </div>
                            
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nom du client</label>
                                    <input type="text" name="nom_client_final" x-model="activeOpportunity.client_name" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Type de client</label>
                                    <select name="type_client" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="Particulier">Particulier</option>
                                        <option value="Entreprise" selected>Entreprise</option>
                                    </select>
                                </div>
                                <div class="space-y-2">
                                    <p class="text-sm font-medium text-gray-700">Créer automatiquement :</p>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="create_project" id="create_project" value="1" checked class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                                        <label for="create_project" class="ml-2 block text-sm text-gray-900">Projet</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="create_order" id="create_order" value="1" class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                                        <label for="create_order" class="ml-2 block text-sm text-gray-900">Commande</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="create_invoice" id="create_invoice" value="1" class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                                        <label for="create_invoice" class="ml-2 block text-sm text-gray-900">Facture</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 flex flex-col sm:flex-row-reverse gap-3">
                    <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-emerald-600 text-base font-bold text-white hover:bg-emerald-700 focus:outline-none sm:w-auto sm:text-sm uppercase tracking-wide">
                        Convertir en client
                    </button>
                    <button type="button" @click="showWonModal = false" class="mt-3 sm:mt-0 w-full inline-flex justify-center rounded-xl border border-transparent px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-700 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 6: Perdu -->
<div x-show="showLostModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showLostModal = false">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form :action="transitionUrl" method="POST">
                @csrf
                <input type="hidden" name="stade" value="perdu">

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-rose-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-bold text-gray-900">Marquer l’opportunité comme perdue</h3>
                            <div class="mt-2 group-objective">
                                <p class="text-xs text-rose-600 font-semibold uppercase tracking-wider">Objectif : Analyse et amélioration future</p>
                            </div>
                            
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Motif de perte</label>
                                    <select name="motif_perte" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="Prix">Prix</option>
                                        <option value="Concurrence">Concurrence</option>
                                        <option value="Abandon">Abandon</option>
                                        <option value="Autre">Autre</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Commentaire libre</label>
                                    <textarea name="commentaire_perte" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" rows="3" placeholder="Précisez les raisons..."></textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Relancer plus tard ? (date optionnelle)</label>
                                    <input type="date" name="relancer_plus_tard_date" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 flex flex-col sm:flex-row-reverse gap-3">
                    <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-rose-600 text-base font-bold text-white hover:bg-rose-700 focus:outline-none sm:w-auto sm:text-sm uppercase tracking-wide">
                        Confirmer la perte
                    </button>
                    <button type="button" @click="showLostModal = false" class="mt-3 sm:mt-0 w-full inline-flex justify-center rounded-xl border border-transparent px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-700 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
