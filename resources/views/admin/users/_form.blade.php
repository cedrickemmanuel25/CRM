<div class="space-y-6">
    
    <!-- Identity Section -->
    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
        <!-- Nom -->
        <div class="sm:col-span-3">
            <label for="name" class="block text-sm font-semibold text-slate-700">Nom Complet</label>
            <div class="mt-1 relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input type="text" name="name" id="name" x-model="formData.name" required 
                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-lg py-2.5" 
                    placeholder="">
            </div>
        </div>

        <!-- Email -->
        <div class="sm:col-span-3">
            <label for="email" class="block text-sm font-semibold text-slate-700">Adresse Email</label>
            <div class="mt-1 relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                    </svg>
                </div>
                <input type="email" name="email" id="email" x-model="formData.email" required 
                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-lg py-2.5" 
                    placeholder="">
            </div>
        </div>

        <!-- Téléphone -->
        <div class="sm:col-span-3">
            <label for="telephone" class="block text-sm font-semibold text-slate-700">Téléphone</label>
            <div class="mt-1 relative rounded-md shadow-sm">
                <input type="tel" id="telephone" x-model="formData.telephone" x-init="
                    $nextTick(() => {
                        window.intlTelInput($el, {
                            initialCountry: 'ci',
                            onlyCountries: ['ci'],
                            countrySearch: false,
                            allowDropdown: false,
                            utilsScript: 'https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.0/build/js/utils.js',
                        });
                    })
                " class="focus:ring-indigo-500 focus:border-indigo-500 block w-full rounded-lg sm:text-sm border-gray-300 py-2.5 pl-3">
            </div>
        </div>

        <!-- Role -->
        <div class="sm:col-span-3">
            <label for="role" class="block text-sm font-semibold text-slate-700">Rôle & Permissions</label>
            <div class="mt-1 relative rounded-md shadow-sm">
                <select id="role" name="role" x-model="formData.role" 
                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-3 pr-10 py-2.5 text-base border-gray-300 sm:text-sm rounded-lg">
                    <option value="admin">Administrateur</option>
                    <option value="commercial">Commercial</option>
                    <option value="support">Support</option>
                </select>
            </div>
            <p class="mt-1.5 text-xs text-gray-500" x-show="formData.role === 'admin'">Accès total à la configuration et aux utilisateurs.</p>
            <p class="mt-1.5 text-xs text-gray-500" x-show="formData.role === 'commercial'">Gestion des prospects, opportunités et tâches.</p>
            <p class="mt-1.5 text-xs text-gray-500" x-show="formData.role === 'support'">Accès aux tickets et fiches clients.</p>
        </div>
    </div>

    <!-- Password Info (Create Mode) -->
    <div x-show="!editMode" class="bg-blue-50 border border-blue-100 rounded-lg p-4 flex items-start space-x-3">
        <svg class="h-6 w-6 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
        </svg>
        <div>
            <h4 class="text-sm font-medium text-blue-900">Mot de passe temporaire</h4>
            <p class="mt-1 text-sm text-blue-700">Le mot de passe par défaut est <span class="font-mono bg-blue-100 px-1 py-0.5 rounded font-bold">Bienvenue123!</span>. L'utilisateur sera invité à le changer.</p>
            <input type="hidden" name="password" value="Bienvenue123!">
        </div>
    </div>

    <!-- Actions -->
    <div class="pt-4 flex items-center justify-end space-x-3 border-t border-gray-100 mt-6">
        <button type="button" @click="openUserModal = false; editMode = false;" 
            class="inline-flex justify-center px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
            Annuler
        </button>
        <button type="submit" 
            class="inline-flex justify-center px-6 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
            <span x-text="editMode ? 'Mettre à jour' : 'Envoyer l\'invitation'"></span>
        </button>
    </div>
</div>
