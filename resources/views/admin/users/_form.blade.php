<div class="space-y-8">
    
    <!-- Identity Section -->
    <div class="grid grid-cols-1 gap-y-6 gap-x-6 sm:grid-cols-6">
        <!-- Nom -->
        <div class="sm:col-span-3">
            <label for="name" class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2 ml-1">Nom Complet</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-600 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <input type="text" name="name" id="name" x-model="formData.name" required 
                    class="block w-full pl-11 pr-4 py-3.5 bg-white/[0.03] border-white/5 rounded-2xl text-sm text-white focus:bg-white/[0.05] focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all placeholder:text-slate-700" 
                    placeholder="ex: Jean Dupont">
            </div>
        </div>

        <!-- Email -->
        <div class="sm:col-span-3">
            <label for="email" class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2 ml-1">Adresse Email</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-600 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                    </svg>
                </div>
                <input type="email" name="email" id="email" x-model="formData.email" required 
                    class="block w-full pl-11 pr-4 py-3.5 bg-white/[0.03] border-white/5 rounded-2xl text-sm text-white focus:bg-white/[0.05] focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all placeholder:text-slate-700" 
                    placeholder="jean.dupont@entreprise.com">
            </div>
        </div>

        <!-- Téléphone -->
        <div class="sm:col-span-3">
            <label for="telephone" class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2 ml-1">Téléphone</label>
            <div class="relative">
                <input type="tel" id="telephone" x-model="formData.telephone" x-init="
                    $nextTick(() => {
                        window.intlTelInput($el, {
                            initialCountry: 'ci',
                            onlyCountries: ['ci'],
                            countrySearch: false,
                            allowDropdown: false,
                            showSelectedDialCode: true,
                            separateDialCode: true,
                            utilsScript: 'https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.0/build/js/utils.js',
                        });
                    })
                " class="block w-full py-3.5 bg-white/[0.03] border-white/5 rounded-2xl text-sm text-white focus:bg-white/[0.05] focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all">
            </div>
        </div>

        <!-- Role -->
        <div class="sm:col-span-3">
            <label for="role" class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2 ml-1">Rôle Système</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-600 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <select id="role" name="role" x-model="formData.role" 
                    class="block w-full pl-11 pr-10 py-3.5 bg-white/[0.03] border-white/5 rounded-2xl text-sm text-white focus:bg-white/[0.05] focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all appearance-none cursor-pointer">
                    <option value="admin">Administrateur</option>
                    <option value="commercial">Commercial</option>
                    <option value="support">Support Technique</option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Permission Insights -->
    <div class="bg-blue-500/5 border border-blue-500/10 rounded-2xl p-6 mb-2">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="ml-4">
                <h4 class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-1">Résumé des permissions</h4>
                <div class="text-[11px] text-slate-400 leading-relaxed font-bold">
                    <p x-show="formData.role === 'admin'" x-cloak>Accès complet au système : configuration, gestion des utilisateurs, audits et rapports financiers.</p>
                    <p x-show="formData.role === 'commercial'" x-cloak>Focus commercial : gestion du pipeline, opportunités, contacts et synchronisation des tâches.</p>
                    <p x-show="formData.role === 'support'" x-cloak>Focus client : gestion du ticketing, historique client et fiches techniques.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Password Info (Create Mode) -->
    <div x-show="!editMode" x-transition class="bg-amber-500/5 border border-amber-500/10 rounded-2xl p-6 flex items-start space-x-4">
        <div class="flex-shrink-0 bg-amber-500/10 rounded-xl p-3 border border-amber-500/20">
            <svg class="h-6 w-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>
        <div>
            <h4 class="text-[10px] font-black text-amber-400 uppercase tracking-widest mb-1">Sécurité de compte</h4>
            <p class="text-[11px] text-slate-400 leading-relaxed font-bold">Le mot de passe par défaut est <span class="text-amber-500 bg-white/5 px-2 py-0.5 rounded shadow-sm border border-white/5">Bienvenue123!</span>. L'utilisateur devra le modifier dès sa première connexion.</p>
            <input type="hidden" name="password" value="Bienvenue123!">
        </div>
    </div>

    <!-- Actions -->
    <div class="pt-10 flex items-center justify-end gap-4 border-t border-white/5 mt-4">
        <button type="button" @click="openUserModal = false" 
            class="px-8 py-3.5 bg-white/5 border border-white/5 rounded-2xl text-xs font-black uppercase tracking-widest text-slate-400 hover:bg-white/10 hover:text-white transition-all duration-300">
            Annuler
        </button>
        <button type="submit" 
            class="px-10 py-3.5 rounded-2xl shadow-xl shadow-blue-500/10 text-xs font-black uppercase tracking-widest text-white bg-blue-600 hover:bg-blue-500 active:scale-95 focus:outline-none focus:ring-4 focus:ring-blue-500/20 transition-all duration-300">
            <span x-text="editMode ? 'Appliquer les modifications' : 'Confirmer l\'invitation'"></span>
        </button>
    </div>
</div>

