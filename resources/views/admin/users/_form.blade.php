<div class="space-y-8">
    
    <!-- Identity Section -->
    <div class="grid grid-cols-1 gap-y-6 gap-x-6 sm:grid-cols-6">
        <!-- Nom -->
        <div class="sm:col-span-3">
            <label for="name" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Nom Complet</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-300 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <input type="text" name="name" id="name" x-model="formData.name" required 
                    class="block w-full pl-11 pr-4 py-3 bg-gray-50 border-gray-100 rounded-xl text-sm focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all placeholder:text-gray-300" 
                    placeholder="ex: Jean Dupont">
            </div>
        </div>

        <!-- Email -->
        <div class="sm:col-span-3">
            <label for="email" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Adresse Email</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-300 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                    </svg>
                </div>
                <input type="email" name="email" id="email" x-model="formData.email" required 
                    class="block w-full pl-11 pr-4 py-3 bg-gray-50 border-gray-100 rounded-xl text-sm focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all placeholder:text-gray-300" 
                    placeholder="jean.dupont@entreprise.com">
            </div>
        </div>

        <!-- Téléphone -->
        <div class="sm:col-span-3">
            <label for="telephone" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Téléphone</label>
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
                " class="block w-full py-3 bg-gray-50 border-gray-100 rounded-xl text-sm focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
            </div>
        </div>

        <!-- Role -->
        <div class="sm:col-span-3">
            <label for="role" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Rôle Système</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-300 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <select id="role" name="role" x-model="formData.role" 
                    class="block w-full pl-11 pr-10 py-3 bg-gray-50 border-gray-100 rounded-xl text-sm focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all appearance-none cursor-pointer">
                    <option value="admin">Administrateur</option>
                    <option value="commercial">Commercial</option>
                    <option value="support">Support Technique</option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Permission Insights -->
    <div class="bg-indigo-50/50 border border-indigo-100/50 rounded-2xl p-5 mb-2">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-6 w-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="ml-4">
                <h4 class="text-sm font-bold text-indigo-900 mb-1">Résumé des permissions</h4>
                <div class="text-xs text-indigo-700 leading-relaxed font-medium">
                    <p x-show="formData.role === 'admin'" x-cloak>Accès complet au système : configuration, gestion des utilisateurs, audits et rapports financiers.</p>
                    <p x-show="formData.role === 'commercial'" x-cloak>Focus commercial : gestion du pipeline, opportunités, contacts et synchronisation des tâches.</p>
                    <p x-show="formData.role === 'support'" x-cloak>Focus client : gestion du ticketing, historique client et fiches techniques.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Password Info (Create Mode) -->
    <div x-show="!editMode" x-transition class="bg-amber-50 border border-amber-100/50 rounded-2xl p-5 flex items-start space-x-4">
        <div class="flex-shrink-0 bg-amber-100 rounded-xl p-2.5">
            <svg class="h-6 w-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>
        <div>
            <h4 class="text-sm font-bold text-amber-900 mb-1">Sécurité de compte</h4>
            <p class="text-xs text-amber-800 leading-relaxed font-medium">Le mot de passe par défaut est <span class="font-bold bg-white px-2 py-0.5 rounded shadow-sm">Bienvenue123!</span>. L'utilisateur devra le modifier dès sa première connexion.</p>
            <input type="hidden" name="password" value="Bienvenue123!">
        </div>
    </div>

    <!-- Actions -->
    <div class="pt-6 flex items-center justify-end space-x-3 border-t border-gray-100 mt-8">
        <button type="button" @click="openUserModal = false" 
            class="px-6 py-3 bg-white border border-gray-200 rounded-xl text-sm font-bold text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition-all duration-200">
            Annuler
        </button>
        <button type="submit" 
            class="px-8 py-3 rounded-xl shadow-lg shadow-indigo-200 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 active:scale-95 focus:outline-none focus:ring-4 focus:ring-indigo-500/20 transition-all duration-200">
            <span x-text="editMode ? 'Appliquer les modifications' : 'Confirmer l\'invitation'"></span>
        </button>
    </div>
</div>

