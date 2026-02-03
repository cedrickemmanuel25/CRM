<!-- Modal 1: Prospection -> Qualification -->
<div x-show="showProspectionModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showProspectionModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-slate-200">
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

                <div class="bg-white px-8 py-8 border-b border-slate-100">
                    <!-- Objectif stratégique -->
                    <div class="mb-8 p-4 bg-indigo-50/50 rounded-2xl border border-indigo-100/50">
                        <div class="mb-2">
                             <p class="text-[10px] font-black text-indigo-600 uppercase tracking-widest mb-1">Description</p>
                             <p class="text-sm font-medium text-slate-700 leading-relaxed">Le contact vient d’être créé. Aucun échange concret n’a encore eu lieu.</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-indigo-600 uppercase tracking-widest mb-1">Objectif</p>
                            <p class="text-sm font-bold text-indigo-900 leading-relaxed">Entrer en relation</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- Ligne 1: Canal & Date -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wide mb-1">Action réalisée</label>
                                <select name="canal_contact" class="w-full h-[48px] px-4 rounded-lg border-2 border-slate-200 bg-white text-sm font-medium text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all cursor-pointer hover:border-slate-300">
                                    <option value="Appel">Appel téléphonique</option>
                                    <option value="Email">Email</option>
                                    <option value="Message">Message (WhatsApp / LinkedIn)</option>
                                    <option value="Note">Note interne</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Date du contact</label>
                                <input type="date" name="date_contact" value="{{ date('Y-m-d') }}" class="w-full h-[45px] px-4 rounded-xl border-slate-300 bg-white text-sm font-semibold text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all">
                            </div>
                        </div>

                        <!-- Ligne 2: Résumé -->
                        <div class="space-y-2">
                            <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Résumé de l'échange <span class="text-rose-500">*</span></label>
                            <textarea name="resume_echange" required class="w-full rounded-2xl border-slate-300 bg-white text-sm font-semibold text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all min-h-[120px] p-4" placeholder="Qu'avez-vous appris lors de cet échange ?"></textarea>
                        </div>

                        <!-- Ligne 3: Température -->
                        <div class="space-y-3 pt-2">
                            <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Température du prospect</label>
                            <div class="grid grid-cols-3 gap-3">
                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="temperature" value="Faible" class="peer sr-only">
                                    <div class="px-3 py-2 text-center rounded-xl border border-slate-200 bg-slate-50 text-xs font-bold text-slate-500 peer-checked:bg-white peer-checked:border-indigo-500 peer-checked:text-indigo-600 peer-checked:shadow-sm transition-all">Faible</div>
                                </label>
                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="temperature" value="Moyen" checked class="peer sr-only">
                                    <div class="px-3 py-2 text-center rounded-xl border border-slate-200 bg-slate-50 text-xs font-bold text-slate-500 peer-checked:bg-white peer-checked:border-indigo-500 peer-checked:text-indigo-600 peer-checked:shadow-sm transition-all">Moyen</div>
                                </label>
                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="temperature" value="Élevé" class="peer sr-only">
                                    <div class="px-3 py-2 text-center rounded-xl border border-slate-200 bg-slate-50 text-xs font-bold text-slate-500 peer-checked:bg-white peer-checked:border-indigo-500 peer-checked:text-indigo-600 peer-checked:shadow-sm transition-all">Élevé</div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 px-8 py-6 flex flex-col sm:flex-row-reverse gap-4">
                    <button type="submit" class="inline-flex items-center justify-center px-8 py-3 bg-indigo-600 text-sm font-bold text-white rounded-xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:scale-[1.02] active:scale-[0.98] transition-all uppercase tracking-wide">
                        Passer en Qualification <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                    <button type="submit" @click="$refs.stayInStageProspection.value = '1'" class="text-sm font-bold text-slate-500 hover:text-slate-700 bg-white border border-slate-200 px-6 py-3 rounded-xl transition-all shadow-sm hover:shadow">
                        Sauvegarder les notes
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

        <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-slate-200">
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

                <div class="bg-white px-8 py-8 border-b border-slate-100">
                     <!-- Desc & Obj -->
                    <div class="mb-8 p-4 bg-blue-50/50 rounded-2xl border border-blue-100/50">
                        <div class="mb-2">
                             <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-1">Description</p>
                             <p class="text-sm font-medium text-slate-700 leading-relaxed">Le besoin du client est analysé et validé.</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-1">Objectif</p>
                            <p class="text-sm font-bold text-blue-900 leading-relaxed">Vérifier la faisabilité de l’opportunité</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Identifier le besoin <span class="text-rose-500">*</span></label>
                            <textarea name="besoin" required x-model="activeOpportunity.besoin" class="w-full rounded-2xl border-slate-300 bg-white text-sm font-semibold text-slate-900 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all min-h-[100px] p-4" placeholder="Détaillez le besoin identifié..."></textarea>
                        </div>

                        <!-- Analyse BANT -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Vérifier le budget (FCFA)</label>
                                <input type="number" name="budget_estime" x-model="activeOpportunity.budget" class="w-full h-[45px] px-4 rounded-xl border-slate-300 bg-white text-sm font-semibold text-slate-900 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Confirmer le décideur</label>
                                <select name="autorite_decision" class="w-full h-[45px] px-4 rounded-xl border-slate-300 bg-white text-sm font-semibold text-slate-900 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all cursor-pointer">
                                    <option value="Décisionnaire">Directeur / Décisionnaire</option>
                                    <option value="Prescripteur">Prescripteur / Influenceur</option>
                                    <option value="Utilisateur">Utilisateur final</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Timeline du projet</label>
                                <select name="timeline_projet" class="w-full h-[45px] px-4 rounded-xl border-slate-300 bg-white text-sm font-semibold text-slate-900 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all cursor-pointer">
                                    <option value="Immédiat">Immédiat (< 1 mois)</option>
                                    <option value="Court terme">Court terme (1-3 mois)</option>
                                    <option value="Moyen terme">Moyen terme (3-6 mois)</option>
                                    <option value="Veille">Veille stratégique</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Priorité interne</label>
                                <select name="priorite" class="w-full h-[45px] px-4 rounded-xl border-slate-300 bg-white text-sm font-semibold text-slate-900 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all cursor-pointer">
                                    <option value="Haute">🔴 Haute</option>
                                    <option value="Moyenne" selected>🟡 Moyenne</option>
                                    <option value="Basse">🟢 Basse</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 px-8 py-6 flex flex-col gap-3">
                    <div class="flex flex-col sm:flex-row-reverse gap-3">
                        <button type="submit" class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-sm font-bold text-white rounded-xl shadow-lg shadow-blue-200 hover:bg-blue-700 hover:scale-[1.02] active:scale-[0.98] transition-all uppercase tracking-wide">
                            ➡️ Créer une opportunité
                        </button>
                        <button type="submit" @click="$refs.targetStage.value = 'prospection'" class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-white text-sm font-medium text-slate-500 rounded-xl border border-slate-200 hover:bg-slate-50 transition-all uppercase tracking-wide">
                            Retour en Prospection
                        </button>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="submit" @click="$refs.stayInStageQual.value = '1'; $refs.targetStage.value = 'qualification'" class="flex-1 text-xs font-bold text-slate-400 hover:text-slate-600 transition-colors uppercase tracking-widest py-2">
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

        <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-slate-200">
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

                <div class="bg-white px-8 py-8 border-b border-slate-100">
                    <!-- Desc & Obj -->
                    <div class="mb-6 p-5 bg-gradient-to-br from-purple-50 to-purple-100/30 rounded-xl border border-purple-200/50 shadow-sm">
                        <div class="mb-3">
                                <p class="text-xs font-bold text-purple-700 uppercase tracking-wide mb-1.5 flex items-center gap-2">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Description
                                </p>
                                <p class="text-sm font-medium text-slate-700 leading-relaxed">Une proposition commerciale a été transmise au client.</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-purple-700 uppercase tracking-wide mb-1.5 flex items-center gap-2">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Objectif
                            </p>
                            <p class="text-sm font-semibold text-purple-900 leading-relaxed">Convaincre le client</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Montant proposé (FCFA) <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <input type="number" name="montant_propose" required x-model="activeOpportunity.montant" class="w-full h-[45px] pl-12 pr-4 rounded-xl border-slate-300 bg-white text-sm font-semibold text-slate-900 shadow-sm focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 transition-all">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 font-bold text-xs border-r border-slate-200 mr-4">F</div>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Type de prestation</label>
                                <select name="type_proposition" class="w-full h-[45px] px-4 rounded-xl border-slate-300 bg-white text-sm font-semibold text-slate-900 shadow-sm focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 transition-all cursor-pointer">
                                    <option value="Standard">Offre Standard</option>
                                    <option value="Premium">Offre Premium</option>
                                    <option value="Sur-mesure">Sur-mesure / Projet</option>
                                    <option value="Accompagnement">Accompagnement annuel</option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Description de l'offre</label>
                            <textarea name="description_offre" class="w-full rounded-2xl border-slate-300 bg-white text-sm font-semibold text-slate-900 shadow-sm focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 transition-all min-h-[100px] p-4" placeholder="Détaillez les principaux points de votre proposition..."></textarea>
                        </div>

                        <div class="p-6 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-300 hover:border-purple-400 hover:bg-white transition-all group text-center cursor-pointer relative shadow-sm">
                            <input type="file" name="document_offre" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="flex flex-col items-center">
                                <div class="p-3 bg-white rounded-xl shadow-sm mb-3 group-hover:scale-110 transition-transform border border-slate-100">
                                    <svg class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                </div>
                                <span class="text-sm font-bold text-slate-700">Charger le document PDF</span>
                                <span class="text-[11px] text-slate-500 font-medium mt-1 uppercase tracking-tighter">Glissez-déposez ou cliquez (Max 5Mo)</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-purple-50 rounded-2xl border border-purple-100 shadow-sm">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-purple-100 rounded-lg">
                                    <svg class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-purple-900 uppercase">Envoi automatique</p>
                                    <p class="text-[10px] text-purple-600 font-medium">Envoyer l'offre par email au client</p>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="send_email" value="1" class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600 shadow-inner"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 px-8 py-6 flex flex-col sm:flex-row-reverse gap-4">
                    <button type="submit" class="inline-flex items-center justify-center px-8 py-3 bg-purple-600 text-sm font-bold text-white rounded-xl shadow-lg shadow-purple-200 hover:bg-purple-700 hover:scale-[1.02] active:scale-[0.98] transition-all uppercase tracking-wide">
                        ➡️ Passer en Négociation
                    </button>
                    <button type="button" @click="showPropositionModal = false" class="text-sm font-bold text-slate-500 hover:text-slate-700 transition-colors uppercase tracking-wide px-4">
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

        <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full border border-slate-200">
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

                <div class="bg-white px-8 py-8 border-b border-slate-100">
                     <!-- Desc & Obj -->
                     <div class="mb-6 p-5 bg-gradient-to-br from-amber-50 to-amber-100/30 rounded-xl border border-amber-200/50 shadow-sm">
                        <div class="mb-3">
                                <p class="text-xs font-bold text-amber-700 uppercase tracking-wide mb-1.5 flex items-center gap-2">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Description
                                </p>
                                <p class="text-sm font-medium text-slate-700 leading-relaxed">Les conditions commerciales sont en cours d'ajustement.</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-amber-700 uppercase tracking-wide mb-1.5 flex items-center gap-2">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Objectif
                            </p>
                            <p class="text-sm font-semibold text-amber-900 leading-relaxed">Trouver un accord</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Derniers retours client <span class="text-rose-500">*</span></label>
                            <textarea name="feedback_negociation" required class="w-full rounded-2xl border-slate-300 bg-white text-sm font-semibold text-slate-900 shadow-sm focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all min-h-[120px] p-4" placeholder="Quels sont les points de friction ou de blocage ?"></textarea>
                        </div>

                        <div class="space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div class="space-y-2">
                                    <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Obstacle majeur</label>
                                    <select name="obstacles_negoc" class="w-full h-[45px] px-4 rounded-xl border-slate-300 bg-white text-sm font-semibold text-slate-900 shadow-sm focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all cursor-pointer">
                                        <option value="Aucun">Aucun blocage</option>
                                        <option value="Budget">Budget trop élevé</option>
                                        <option value="Juridique">Attente service juridique</option>
                                        <option value="Concurrence">Concurrence agressive</option>
                                        <option value="Technique">Complexité technique</option>
                                    </select>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Confiance de signature</label>
                                    <div class="flex items-center gap-4 py-2">
                                        <input type="range" name="probabilite_finale" min="0" max="100" value="80" class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-amber-500 border-none shadow-inner">
                                        <span class="text-sm font-bold text-slate-800 min-w-[32px]">80%</span>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Date de décision prévue</label>
                                <input type="date" name="date_decision_prevue" value="{{ date('Y-m-d', strtotime('+7 days')) }}" class="w-full h-[45px] px-4 rounded-xl border-slate-300 bg-white text-sm font-semibold text-slate-900 shadow-sm focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 px-8 py-6 flex flex-col gap-3 text-label">
                    <div class="flex flex-col sm:flex-row-reverse gap-3">
                        <button type="submit" @click="$refs.targetStageNegoc.value = 'gagne'" class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-emerald-600 text-sm font-bold text-white rounded-xl shadow-lg shadow-emerald-200 hover:bg-emerald-700 hover:scale-[1.02] active:scale-[0.98] transition-all uppercase tracking-wide">
                            ✅ Marquer comme Gagné
                        </button>
                        <button type="submit" @click="$refs.targetStageNegoc.value = 'perdu'" class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-rose-600 text-sm font-bold text-white rounded-xl shadow-lg shadow-rose-200 hover:bg-rose-700 hover:scale-[1.02] active:scale-[0.98] transition-all uppercase tracking-wide">
                            ❌ Marquer comme Perdu
                        </button>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="submit" @click="$refs.stayInStageNegoc.value = '1'; $refs.targetStageNegoc.value = 'negociation'" class="flex-1 inline-flex items-center justify-center px-6 py-2 bg-white text-[11px] font-bold text-slate-500 rounded-xl border border-slate-200 hover:bg-slate-100 hover:text-slate-700 transition-all uppercase tracking-widest shadow-sm">
                            Enregistrer les notes de suivi
                        </button>
                        <button type="button" @click="showNegociationModal = false" class="flex-1 inline-flex items-center justify-center px-6 py-2 bg-transparent text-[11px] font-bold text-slate-400 hover:text-slate-600 transition-all uppercase tracking-widest">
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

        <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full border border-slate-200">
            <form :action="transitionUrl" method="POST">
                @csrf
                <input type="hidden" name="stade" value="gagne">

                <div class="bg-gradient-to-br from-emerald-500 via-emerald-600 to-teal-600 px-6 py-8 text-center relative overflow-hidden shadow-lg">
                    <!-- Decorative elements -->
                    <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
                        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none"><circle cx="10" cy="10" r="20" fill="white"/><circle cx="90" cy="80" r="30" fill="white"/></svg>
                    </div>
                    
                    <div class="relative z-10">
                        <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-white/20 backdrop-blur-md mb-4 shadow-inner">
                            <svg class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-black text-white tracking-tight uppercase">Opportunité Gagnée</h3>
                        <p class="text-emerald-50 text-base font-medium mt-2">Félicitations ! Le client a accepté l'offre</p>
                    </div>
                </div>

                <div class="bg-white px-8 py-8">
                    <div class="space-y-6">
                        <!-- Desc & Obj -->
                        <div class="mb-6 p-5 bg-gradient-to-br from-emerald-50 to-emerald-100/30 rounded-xl border border-emerald-200/50 shadow-sm">
                            <div class="mb-3">
                                <p class="text-xs font-bold text-emerald-700 uppercase tracking-wide mb-1.5 flex items-center gap-2">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Prochaines étapes
                                </p>
                                <p class="text-sm font-medium text-slate-700 leading-relaxed">Le client a accepté l'offre. Il est temps de démarrer la prestation.</p>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Nom officiel du client / Entreprise</label>
                            <input type="text" name="nom_client_final" x-model="activeOpportunity.client_name" class="w-full h-[45px] px-4 rounded-xl border-slate-300 bg-white text-sm font-semibold text-slate-900 shadow-sm focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all">
                        </div>

                        <div class="space-y-4">
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 pb-2">Actions de conversion automatique</p>
                            
                            <div class="grid grid-cols-1 gap-3">
                                @foreach([
                                    'create_project' => ['label' => 'Générer le contrat (Créer projet)', 'desc' => 'Initialise un espace projet pour l\'exécution', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                                    'create_invoice' => ['label' => 'Créer la facture', 'desc' => 'Crée un brouillon de facture à 30%', 'icon' => 'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z'],
                                    'launch_service' => ['label' => 'Lancer le service', 'desc' => 'Notifier les équipes', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z']
                                ] as $name => $info)
                                <label class="flex items-start p-4 rounded-2xl border border-slate-200 bg-white hover:border-emerald-200 hover:shadow-md cursor-pointer transition-all group shadow-sm">
                                    <div class="flex-shrink-0 mt-0.5">
                                        <input type="checkbox" name="{{ $name }}" value="1" class="h-5 w-5 text-emerald-600 focus:ring-emerald-500 border-slate-300 rounded-lg">
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center gap-2">
                                            <svg class="h-4 w-4 text-slate-400 group-hover:text-emerald-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $info['icon'] }}"></path></svg>
                                            <span class="text-xs font-bold text-slate-700 uppercase tracking-wide">{{ $info['label'] }}</span>
                                        </div>
                                        <p class="text-[11px] text-slate-500 font-medium mt-0.5">{{ $info['desc'] }}</p>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 px-8 py-6 flex flex-col sm:flex-row-reverse gap-4">
                    <button type="submit" class="inline-flex items-center justify-center px-10 py-4 bg-emerald-600 text-sm font-black text-white rounded-2xl shadow-xl shadow-emerald-200 hover:bg-emerald-700 hover:scale-[1.03] active:scale-[0.97] transition-all uppercase tracking-widest">
                        Confirmer la Vente
                    </button>
                    <button type="button" @click="showWonModal = false" class="text-sm font-bold text-slate-500 hover:text-slate-700 transition-colors uppercase tracking-wide px-6">
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

        <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full border border-slate-200">
            <form :action="transitionUrl" method="POST">
                @csrf
                <input type="hidden" name="stade" value="perdu">

                <div class="bg-white px-8 pt-8 pb-4">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="p-3 bg-gradient-to-br from-rose-100 to-rose-200 rounded-xl shadow-sm">
                            <svg class="h-7 w-7 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-slate-800 tracking-tight">Opportunité Perdue</h3>
                            <p class="text-slate-500 text-sm font-medium mt-0.5">Analyse et apprentissage</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- Desc & Obj -->
                        <div class="p-5 bg-gradient-to-br from-rose-50 to-rose-100/30 rounded-xl border border-rose-200/50 shadow-sm mb-4">
                            <div class="mb-3">
                                <p class="text-xs font-bold text-rose-700 uppercase tracking-wide mb-1.5 flex items-center gap-2">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Contexte
                                </p>
                                <p class="text-sm font-medium text-slate-700 leading-relaxed">Le client n'a pas donné suite.</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-rose-600 uppercase tracking-widest mb-1">Objectif</p>
                                <p class="text-sm font-bold text-rose-900 leading-relaxed">Capitaliser sur l’expérience</p>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Sélectionner la raison de perte <span class="text-rose-500">*</span></label>
                            <select name="motif_perte" required class="w-full h-[45px] px-4 rounded-xl border-slate-300 bg-white text-sm font-semibold text-slate-900 shadow-sm focus:border-rose-500 focus:ring-4 focus:ring-rose-500/10 transition-all cursor-pointer">
                                <option value="Prix">Prix trop élevé</option>
                                <option value="Concurrence">Perdu face à la concurrence</option>
                                <option value="Besoin">Le besoin a disparu</option>
                                <option value="Relationnel">Mauvais fit relationnel</option>
                                <option value="Projet annulé">Projet client annulé / reporté</option>
                                <option value="Autre">Autre motif</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Commentaire analytique</label>
                            <textarea name="commentaire_perte" class="w-full rounded-2xl border-slate-300 bg-white text-sm font-semibold text-slate-900 shadow-sm focus:border-rose-500 focus:ring-4 focus:ring-rose-500/10 transition-all min-h-[120px] p-4" placeholder="Pourquoi n'avons-nous pas réussi à conclure ?"></textarea>
                        </div>

                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 shadow-sm">
                            <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-2">Relancer plus tard ? (Optionnel)</label>
                            <input type="date" name="relancer_plus_tard_date" class="w-full h-[45px] px-4 rounded-xl border-slate-300 bg-white text-sm font-semibold text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all">
                            <p class="text-[10px] text-slate-500 font-medium mt-2 italic">Une tâche de rappel sera créée à cette date.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 px-8 py-6 flex flex-col sm:flex-row-reverse gap-4">
                    <button type="submit" class="inline-flex items-center justify-center px-10 py-4 bg-rose-600 text-sm font-bold text-white rounded-2xl shadow-xl shadow-rose-200 hover:bg-rose-700 hover:scale-[1.02] active:scale-[0.98] transition-all uppercase tracking-wide">
                        Archiver l’opportunité
                    </button>
                    <button type="button" @click="showLostModal = false" class="text-sm font-bold text-slate-500 hover:text-slate-700 transition-colors uppercase tracking-wide px-6">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
