<!-- Modal 1: Prospection -> Qualification -->
<div x-show="showProspectionModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showProspectionModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-slate-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-white/10">
            <form :action="transitionUrl" method="POST">
                @csrf
                <input type="hidden" name="stade" value="qualification">
                <input type="hidden" name="stay_in_stage" x-ref="stayInStageProspection" value="0">

                <!-- Header visual -->
                <div class="bg-gradient-to-br from-indigo-600 via-indigo-700 to-blue-700 px-6 py-5 flex items-center justify-between shadow-lg">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-white/20 rounded-xl backdrop-blur-md shadow-inner">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white tracking-tight">Prospection</h3>
                            <p class="text-indigo-100 text-sm font-medium">Nouveau contact</p>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-800 px-6 py-6 border-b border-white/5">
                    <!-- Objectif stratégique -->
                    <div class="mb-6 p-4 bg-indigo-900/20 rounded-lg border border-indigo-500/30">
                        <div class="mb-3">
                             <p class="text-xs font-semibold text-indigo-400 uppercase tracking-wide mb-1">Description</p>
                             <p class="text-sm text-slate-400 leading-relaxed">Le contact vient d’être créé. Aucun échange concret n’a encore eu lieu.</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-indigo-400 uppercase tracking-wide mb-1">Objectif</p>
                            <p class="text-sm font-semibold text-indigo-300 leading-relaxed">Entrer en relation</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <!-- Ligne 1: Canal & Date -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-2">Action réalisée</label>
                                <select name="canal_contact" class="w-full h-12 px-4 rounded-lg border-2 border-white/10 bg-slate-900/50 text-sm text-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all cursor-pointer">
                                    <option value="Appel">Appel téléphonique</option>
                                    <option value="Email">Email</option>
                                    <option value="Message">Message (WhatsApp / LinkedIn)</option>
                                    <option value="Note">Note interne</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-2">Date du contact</label>
                                <input type="date" name="date_contact" value="{{ date('Y-m-d') }}" class="w-full h-12 px-4 rounded-lg border-2 border-white/10 bg-slate-900/50 text-sm text-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all">
                            </div>
                        </div>

                        <!-- Ligne 2: Résumé -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-2">Résumé de l'échange <span class="text-rose-500">*</span></label>
                            <textarea name="resume_echange" required class="w-full rounded-lg border-2 border-white/10 bg-slate-900/50 text-sm text-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all min-h-[100px] p-3" placeholder="Qu'avez-vous appris lors de cet échange ?"></textarea>
                        </div>

                        <!-- Ligne 3: Température -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-2">Température du prospect</label>
                            <div class="grid grid-cols-3 gap-3">
                                <label class="cursor-pointer">
                                    <input type="radio" name="temperature" value="Faible" class="peer sr-only">
                                    <div class="px-3 py-2.5 text-center rounded-lg border-2 border-white/10 bg-slate-900/50 text-xs font-semibold text-slate-400 peer-checked:border-indigo-500 peer-checked:text-indigo-400 peer-checked:bg-indigo-900/20 transition-all">Faible</div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="temperature" value="Moyen" checked class="peer sr-only">
                                    <div class="px-3 py-2.5 text-center rounded-lg border-2 border-white/10 bg-slate-900/50 text-xs font-semibold text-slate-400 peer-checked:border-indigo-500 peer-checked:text-indigo-400 peer-checked:bg-indigo-900/20 transition-all">Moyen</div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="temperature" value="Élevé" class="peer sr-only">
                                    <div class="px-3 py-2.5 text-center rounded-lg border-2 border-white/10 bg-slate-900/50 text-xs font-semibold text-slate-400 peer-checked:border-indigo-500 peer-checked:text-indigo-400 peer-checked:bg-indigo-900/20 transition-all">Élevé</div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-800/50 px-6 py-4 flex flex-col sm:flex-row-reverse gap-3 border-t border-white/5">
                    <button type="submit" class="h-12 px-6 bg-indigo-600 text-sm font-semibold text-white rounded-lg hover:bg-indigo-700 transition-all">
                        Passer en Qualification
                    </button>
                    <button type="submit" @click="$refs.stayInStageProspection.value = '1'" class="h-12 px-6 text-sm font-semibold text-slate-300 bg-slate-700 border-2 border-transparent rounded-lg hover:bg-slate-600 transition-all">
                        Sauvegarder
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 2: Qualification -> Proposition -->
<div x-show="showQualificationModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showQualificationModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-slate-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-white/10">
            <form :action="transitionUrl" method="POST">
                @csrf
                <input type="hidden" name="stade" x-ref="targetStage" value="proposition">
                <input type="hidden" name="stay_in_stage" x-ref="stayInStageQual" value="0">

                <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-cyan-700 px-6 py-5 flex items-center justify-between shadow-lg">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-white/20 rounded-xl backdrop-blur-md shadow-inner">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white tracking-tight">Qualification</h3>
                            <p class="text-blue-100 text-sm font-medium">Contact qualifié</p>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-800 px-6 py-6 border-b border-white/5">
                     <!-- Desc & Obj -->
                    <div class="mb-6 p-4 bg-blue-900/20 rounded-lg border border-blue-500/30">
                        <div class="mb-3">
                             <p class="text-xs font-semibold text-blue-400 uppercase tracking-wide mb-1">Description</p>
                             <p class="text-sm text-slate-400 leading-relaxed">Le besoin du client est analysé et validé.</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-blue-400 uppercase tracking-wide mb-1">Objectif</p>
                            <p class="text-sm font-semibold text-blue-300 leading-relaxed">Vérifier la faisabilité de l’opportunité</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-2">Identifier le besoin <span class="text-rose-500">*</span></label>
                            <textarea name="besoin" required x-model="activeOpportunity.besoin" class="w-full rounded-lg border-2 border-white/10 bg-slate-900/50 text-sm text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all min-h-[100px] p-3" placeholder="Détaillez le besoin identifié..."></textarea>
                        </div>

                        <!-- Analyse BANT -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-2">Vérifier le budget (FCFA)</label>
                                <input type="number" name="budget_estime" x-model="activeOpportunity.budget" class="w-full h-12 px-4 rounded-lg border-2 border-white/10 bg-slate-900/50 text-sm text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-2">Confirmer le décideur</label>
                                <select name="autorite_decision" class="w-full h-12 px-4 rounded-lg border-2 border-white/10 bg-slate-900/50 text-sm text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all cursor-pointer">
                                    <option value="Décisionnaire">Directeur / Décisionnaire</option>
                                    <option value="Prescripteur">Prescripteur / Influenceur</option>
                                    <option value="Utilisateur">Utilisateur final</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-2">Timeline du projet</label>
                                <select name="timeline_projet" class="w-full h-12 px-4 rounded-lg border-2 border-white/10 bg-slate-900/50 text-sm text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all cursor-pointer">
                                    <option value="Immédiat">Immédiat (< 1 mois)</option>
                                    <option value="Court terme">Court terme (1-3 mois)</option>
                                    <option value="Moyen terme">Moyen terme (3-6 mois)</option>
                                    <option value="Veille">Veille stratégique</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-2">Priorité interne</label>
                                <select name="priorite" class="w-full h-12 px-4 rounded-lg border-2 border-white/10 bg-slate-900/50 text-sm text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all cursor-pointer">
                                    <option value="Haute">🔴 Haute</option>
                                    <option value="Moyenne" selected>🟡 Moyenne</option>
                                    <option value="Basse">🟢 Basse</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-800/50 px-6 py-4 flex flex-col gap-3 border-t border-white/5">
                    <div class="flex flex-col sm:flex-row-reverse gap-3">
                        <button type="submit" class="flex-1 h-12 bg-blue-600 text-sm font-semibold text-white rounded-lg hover:bg-blue-700 transition-all">
                            Créer une opportunité
                        </button>
                        <button type="submit" @click="$refs.targetStage.value = 'prospection'" class="flex-1 h-12 text-sm font-semibold text-slate-300 bg-slate-700 border-2 border-transparent rounded-lg hover:bg-slate-600 transition-all">
                            Retour en Prospection
                        </button>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="submit" @click="$refs.stayInStageQual.value = '1'; $refs.targetStage.value = 'qualification'" class="flex-1 text-xs font-semibold text-slate-400 hover:text-slate-600 transition-colors uppercase tracking-wide py-2">
                            Sauvegarder sans changer de stade
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 3: Proposition -> Négociation -->
<div x-show="showPropositionModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showPropositionModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-slate-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-white/10">
            <form :action="transitionUrl" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="stade" value="negociation">

                <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-white/20 rounded-xl backdrop-blur-md shadow-inner">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                             <h3 class="text-xl font-bold text-white tracking-tight">Proposition</h3>
                             <p class="text-purple-100 text-sm font-medium">Offre envoyée</p>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-800 px-6 py-6 border-b border-white/5">
                    <!-- Desc & Obj -->
                    <div class="mb-6 p-4 bg-purple-900/20 rounded-lg border border-purple-500/30">
                        <div class="mb-3">
                                <p class="text-xs font-semibold text-purple-400 uppercase tracking-wide mb-1 flex items-center gap-2">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Description
                                </p>
                                <p class="text-sm text-slate-400 leading-relaxed">Une proposition commerciale a été transmise au client.</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-purple-400 uppercase tracking-wide mb-1 flex items-center gap-2">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Objectif
                            </p>
                            <p class="text-sm font-semibold text-purple-300 leading-relaxed">Convaincre le client</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-2">Montant proposé (FCFA) <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <input type="number" name="montant_propose" required x-model="activeOpportunity.montant" class="w-full h-12 pl-12 pr-4 rounded-lg border-2 border-white/10 bg-slate-900/50 text-sm text-white focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 font-bold text-xs border-r border-white/10 mr-4">F</div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-2">Type de prestation</label>
                                <select name="type_proposition" class="w-full h-12 px-4 rounded-lg border-2 border-white/10 bg-slate-900/50 text-sm text-white focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all cursor-pointer">
                                    <option value="Standard">Offre Standard</option>
                                    <option value="Premium">Offre Premium</option>
                                    <option value="Sur-mesure">Sur-mesure / Projet</option>
                                    <option value="Accompagnement">Accompagnement annuel</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-2">Description de l'offre</label>
                            <textarea name="description_offre" class="w-full rounded-lg border-2 border-white/10 bg-slate-900/50 text-sm text-white focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all min-h-[100px] p-3" placeholder="Détaillez les principaux points de votre proposition..."></textarea>
                        </div>

                        <div class="p-6 bg-slate-800/50 rounded-lg border-2 border-dashed border-white/10 hover:border-purple-400 hover:bg-slate-800 transition-all group text-center cursor-pointer relative">
                            <input type="file" name="document_offre" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="flex flex-col items-center">
                                <div class="p-3 bg-slate-700 rounded-lg shadow-sm mb-3 group-hover:scale-110 transition-transform border border-white/5">
                                    <svg class="h-6 w-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                </div>
                                <span class="text-sm font-semibold text-slate-300">Charger le document PDF</span>
                                <span class="text-xs text-slate-500 mt-1">Glissez-déposez ou cliquez (Max 5Mo)</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-purple-900/20 rounded-lg border border-purple-500/30">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-purple-900/50 rounded-md">
                                    <svg class="h-5 w-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-purple-300 uppercase">Envoi automatique</p>
                                    <p class="text-xs text-purple-400">Envoyer l'offre par email au client</p>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="send_email" value="1" class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-800/50 px-6 py-4 flex flex-col sm:flex-row-reverse gap-3 border-t border-white/5">
                    <button type="submit" class="h-12 px-6 bg-purple-600 text-sm font-semibold text-white rounded-lg hover:bg-purple-700 transition-all">
                        Passer en Négociation
                    </button>
                    <button type="button" @click="showPropositionModal = false" class="h-12 px-6 text-sm font-semibold text-slate-400 hover:text-slate-300 transition-colors">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 4: Négociation -> Gagné / Perdu -->
<div x-show="showNegociationModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showNegociationModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-slate-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full border border-white/10">
            <form :action="transitionUrl" method="POST">
                @csrf
                <input type="hidden" name="stade" x-ref="targetStageNegoc" value="negociation">
                <input type="hidden" name="stay_in_stage" x-ref="stayInStageNegoc" value="0">

                <div class="bg-gradient-to-r from-amber-500 to-orange-600 px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-white/20 rounded-xl backdrop-blur-md shadow-inner">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white tracking-tight">Négociation</h3>
                            <p class="text-amber-100 text-sm font-medium">En discussion</p>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-800 px-6 py-6 border-b border-white/5">
                     <!-- Desc & Obj -->
                     <div class="mb-6 p-4 bg-amber-900/20 rounded-lg border border-amber-500/30">
                        <div class="mb-3">
                                <p class="text-xs font-semibold text-amber-400 uppercase tracking-wide mb-1 flex items-center gap-2">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Description
                                </p>
                                <p class="text-sm text-slate-400 leading-relaxed">Les conditions commerciales sont en cours d'ajustement.</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-amber-400 uppercase tracking-wide mb-1 flex items-center gap-2">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Objectif
                            </p>
                            <p class="text-sm font-semibold text-amber-300 leading-relaxed">Trouver un accord</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-2">Derniers retours client <span class="text-rose-500">*</span></label>
                            <textarea name="feedback_negociation" required class="w-full rounded-lg border-2 border-white/10 bg-slate-900/50 text-sm text-white focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all min-h-[100px] p-3" placeholder="Quels sont les points de friction ou de blocage ?"></textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-2">Obstacle majeur</label>
                                <select name="obstacles_negoc" class="w-full h-12 px-4 rounded-lg border-2 border-white/10 bg-slate-900/50 text-sm text-white focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all cursor-pointer">
                                    <option value="Aucun">Aucun blocage</option>
                                    <option value="Budget">Budget trop élevé</option>
                                    <option value="Juridique">Attente service juridique</option>
                                    <option value="Concurrence">Concurrence agressive</option>
                                    <option value="Technique">Complexité technique</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 mb-2">Confiance de signature</label>
                                <div class="flex items-center gap-4 py-2 h-12">
                                    <input type="range" name="probabilite_finale" min="0" max="100" value="80" class="w-full h-2 bg-slate-700 rounded-lg appearance-none cursor-pointer accent-amber-500 border-none">
                                    <span class="text-sm font-bold text-white min-w-[32px]">80%</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-2">Date de décision prévue</label>
                            <input type="date" name="date_decision_prevue" value="{{ date('Y-m-d', strtotime('+7 days')) }}" class="w-full h-12 px-4 rounded-lg border-2 border-white/10 bg-slate-900/50 text-sm text-white focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all">
                        </div>
                    </div>
                </div>

                <div class="bg-slate-800/50 px-6 py-4 flex flex-col gap-3 text-label border-t border-white/5">
                    <div class="flex flex-col sm:flex-row-reverse gap-3">
                        <button type="submit" @click="$refs.targetStageNegoc.value = 'gagne'" class="flex-1 h-12 bg-emerald-600 text-sm font-semibold text-white rounded-lg hover:bg-emerald-700 transition-all">
                            Marquer comme Gagné
                        </button>
                        <button type="submit" @click="$refs.targetStageNegoc.value = 'perdu'" class="flex-1 h-12 bg-rose-600 text-sm font-semibold text-white rounded-lg hover:bg-rose-700 transition-all">
                            Marquer comme Perdu
                        </button>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="submit" @click="$refs.stayInStageNegoc.value = '1'; $refs.targetStageNegoc.value = 'negociation'" class="flex-1 h-10 bg-slate-700 text-xs font-semibold text-slate-300 rounded-lg border-2 border-transparent hover:bg-slate-600 transition-all uppercase tracking-wide">
                            Enregistrer les notes
                        </button>
                        <button type="button" @click="showNegociationModal = false" class="flex-1 h-10 bg-transparent text-xs font-semibold text-slate-500 hover:text-slate-300 transition-all uppercase tracking-wide">
                            Annuler
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 5: Gagné (Conversion en client) -->
<div x-show="showWonModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showWonModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-slate-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full border border-white/10">
            <form :action="transitionUrl" method="POST">
                @csrf
                <input type="hidden" name="stade" value="gagne">

                <div class="bg-gradient-to-br from-emerald-500 via-emerald-600 to-teal-600 px-6 py-8 text-center relative overflow-hidden shadow-lg">
                    <!-- Decorative elements -->
                    <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
                        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none"><circle cx="10" cy="10" r="20" fill="white"/><circle cx="90" cy="80" r="30" fill="white"/></svg>
                    </div>
                    
                    <div class="relative z-10">
                        <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-slate-800/20 backdrop-blur-md mb-4 shadow-inner">
                            <svg class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-black text-white tracking-tight uppercase">Opportunité Gagnée</h3>
                        <p class="text-emerald-50 text-base font-medium mt-2">Félicitations ! Le client a accepté l'offre</p>
                    </div>
                </div>

                <div class="bg-slate-800 px-6 py-6 border-b border-white/5">
                    <div class="space-y-4">
                        <!-- Desc & Obj -->
                        <div class="mb-6 p-4 bg-emerald-900/20 rounded-lg border border-emerald-500/30">
                            <div class="mb-3">
                                <p class="text-xs font-semibold text-emerald-400 uppercase tracking-wide mb-1 flex items-center gap-2">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Prochaines étapes
                                </p>
                                <p class="text-sm text-slate-400 leading-relaxed">Le client a accepté l'offre. Il est temps de démarrer la prestation.</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-2">Nom officiel du client / Entreprise</label>
                            <input type="text" name="nom_client_final" x-model="activeOpportunity.client_name" class="w-full h-12 px-4 rounded-lg border-2 border-white/10 bg-slate-900/50 text-sm text-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all">
                        </div>

                        <div class="space-y-4">
                            <p class="text-[11px] font-bold text-slate-500 uppercase tracking-widest border-b border-white/5 pb-2">Actions de conversion automatique</p>
                            
                            <div class="grid grid-cols-1 gap-3">
                                @foreach([
                                    'create_project' => ['label' => 'Générer le contrat (Créer projet)', 'desc' => 'Initialise un espace projet pour l\'exécution', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                                    'create_invoice' => ['label' => 'Créer la facture', 'desc' => 'Crée un brouillon de facture à 30%', 'icon' => 'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z'],
                                    'launch_service' => ['label' => 'Lancer le service', 'desc' => 'Notifier les équipes', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z']
                                ] as $name => $info)
                                <label class="flex items-start p-4 rounded-2xl border border-white/10 bg-slate-800 hover:border-emerald-500/50 hover:bg-slate-700/50 cursor-pointer transition-all group shadow-sm">
                                    <div class="flex-shrink-0 mt-0.5">
                                        <input type="checkbox" name="{{ $name }}" value="1" class="h-5 w-5 text-emerald-600 focus:ring-emerald-500 border-slate-600 bg-slate-900 rounded-lg">
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center gap-2">
                                            <svg class="h-4 w-4 text-slate-500 group-hover:text-emerald-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $info['icon'] }}"></path></svg>
                                            <span class="text-xs font-bold text-slate-300 uppercase tracking-wide">{{ $info['label'] }}</span>
                                        </div>
                                        <p class="text-[11px] text-slate-500 font-medium mt-0.5">{{ $info['desc'] }}</p>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-800/50 px-6 py-4 flex flex-col sm:flex-row-reverse gap-3 border-t border-white/5">
                    <button type="submit" class="h-12 px-8 bg-emerald-600 text-sm font-bold text-white rounded-lg shadow-lg shadow-emerald-500/20 hover:bg-emerald-700 hover:scale-[1.02] active:scale-[0.98] transition-all uppercase tracking-wide">
                        Confirmer la Vente
                    </button>
                    <button type="button" @click="showWonModal = false" class="h-12 px-6 text-sm font-semibold text-slate-400 hover:text-slate-300 transition-colors uppercase tracking-wide">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 6: Perdu -->
<div x-show="showLostModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showLostModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-slate-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full border border-white/10">
            <form :action="transitionUrl" method="POST">
                @csrf
                <input type="hidden" name="stade" value="perdu">

                <div class="bg-slate-800 px-6 py-6 border-b border-white/5">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="p-3 bg-rose-900/20 rounded-xl shadow-sm border border-rose-500/30">
                            <svg class="h-7 w-7 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white tracking-tight">Opportunité Perdue</h3>
                            <p class="text-slate-400 text-sm font-medium mt-0.5">Analyse et apprentissage</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <!-- Desc & Obj -->
                        <div class="p-4 bg-rose-900/20 rounded-lg border border-rose-500/30 mb-4">
                            <div class="mb-3">
                                <p class="text-xs font-semibold text-rose-400 uppercase tracking-wide mb-1 flex items-center gap-2">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Contexte
                                </p>
                                <p class="text-sm text-slate-400 leading-relaxed">Le client n'a pas donné suite.</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-rose-400 uppercase tracking-wide mb-1">Objectif</p>
                                <p class="text-sm font-semibold text-rose-300 leading-relaxed">Capitaliser sur l’expérience</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-2">Sélectionner la raison de perte <span class="text-rose-500">*</span></label>
                            <select name="motif_perte" required class="w-full h-12 px-4 rounded-lg border-2 border-white/10 bg-slate-900/50 text-sm text-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-all cursor-pointer">
                                <option value="Prix">Prix trop élevé</option>
                                <option value="Concurrence">Perdu face à la concurrence</option>
                                <option value="Besoin">Le besoin a disparu</option>
                                <option value="Relationnel">Mauvais fit relationnel</option>
                                <option value="Projet annulé">Projet client annulé / reporté</option>
                                <option value="Autre">Autre motif</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-2">Commentaire analytique</label>
                            <textarea name="commentaire_perte" class="w-full rounded-lg border-2 border-white/10 bg-slate-900/50 text-sm text-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-all min-h-[100px] p-3" placeholder="Pourquoi n'avons-nous pas réussi à conclure ?"></textarea>
                        </div>

                        <div class="p-4 bg-slate-800/50 rounded-lg border border-white/10 shadow-sm">
                            <label class="block text-xs font-semibold text-slate-400 mb-2">Relancer plus tard ? (Optionnel)</label>
                            <input type="date" name="relancer_plus_tard_date" class="w-full h-12 px-4 rounded-lg border-2 border-white/10 bg-slate-900/50 text-sm text-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all">
                            <p class="text-xs text-slate-500 mt-2 italic">Une tâche de rappel sera créée à cette date.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-800/50 px-6 py-4 flex flex-col sm:flex-row-reverse gap-3 border-t border-white/5">
                    <button type="submit" class="h-12 px-8 bg-rose-600 text-sm font-bold text-white rounded-lg shadow-lg shadow-rose-500/20 hover:bg-rose-700 hover:scale-[1.02] active:scale-[0.98] transition-all uppercase tracking-wide">
                        Archiver l’opportunité
                    </button>
                    <button type="button" @click="showLostModal = false" class="h-12 px-6 text-sm font-semibold text-slate-400 hover:text-slate-300 transition-colors uppercase tracking-wide">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
