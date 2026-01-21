@extends('layouts.admin')

@section('title', 'Mon Profil Administrateur')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ 
    activeTab: 'general',
    avatarPreview: '{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=DC2626&color=fff&size=256&bold=true' }}',
    previewAvatar(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => { 
                this.avatarPreview = e.target.result;
                // Update header avatar if it exists
                const headerAvatar = document.querySelector('.header-user-avatar');
                if (headerAvatar) {
                    headerAvatar.style.backgroundImage = 'url(' + e.target.result + ')';
                    headerAvatar.style.backgroundSize = 'cover';
                    headerAvatar.textContent = '';
                }
            };
            reader.readAsDataURL(file);
        }
    }
}" x-init="
    // Initialize intl-tel-input for phone field
    setTimeout(() => {
        const phoneInput = document.querySelector('#telephone');
        if (phoneInput && window.intlTelInput) {
            window.iti = intlTelInput(phoneInput, {
                initialCountry: 'ci',
                onlyCountries: ['ci'],
                countrySearch: false,
                allowDropdown: false,
                showSelectedDialCode: true,
                separateDialCode: true,
                utilsScript: 'https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.0/build/js/utils.js'
            });
        }
    }, 100);
">
    
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Profil Administrateur</h1>
                <p class="mt-1 text-sm text-gray-500">Gérez votre profil et consultez les statistiques système</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                    <svg class="mr-1.5 h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Administrateur
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left Sidebar - Profile Card & Stats -->
        <div class="lg:col-span-4 space-y-6">
            <!-- Profile Card -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="h-24 bg-gradient-to-r from-red-500 to-red-600"></div>
                
                <div class="px-6 pb-6">
                    <div class="relative -mt-12 mb-4">
                        <div class="inline-block relative group cursor-pointer" onclick="document.getElementById('avatar-input').click()">
                            <div class="h-24 w-24 rounded-full border-4 border-white bg-white shadow-lg overflow-hidden">
                                <img :src="avatarPreview" class="h-full w-full object-cover" alt="{{ $user->name }}">
                            </div>
                            <div class="absolute inset-0 rounded-full bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all flex items-center justify-center">
                                <svg class="h-6 w-6 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mb-6">
                        <h2 class="text-xl font-semibold text-gray-900">{{ $user->name }}</h2>
                        <p class="text-sm text-gray-500 mt-1">{{ $user->email }}</p>
                        <div class="mt-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Administrateur Système
                            </span>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6 space-y-3">
                        <div class="flex items-center text-sm">
                            <svg class="h-5 w-5 text-gray-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-gray-500">Membre depuis</span>
                            <span class="ml-auto font-medium text-gray-900">{{ $user->created_at->format('M Y') }}</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <svg class="h-5 w-5 text-gray-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-gray-500">Dernière mise à jour</span>
                            <span class="ml-auto font-medium text-gray-900">{{ $user->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Stats -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="h-5 w-5 text-red-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Statistiques Système
                </h3>
                <dl class="space-y-4">
                    <div class="flex items-center justify-between">
                        <dt class="text-sm text-gray-600">Utilisateurs</dt>
                        <dd class="text-lg font-semibold text-gray-900">{{ $stats['total_users'] }}</dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="text-sm text-gray-600">Demandes en attente</dt>
                        <dd class="text-lg font-semibold text-orange-600">{{ $stats['pending_requests'] }}</dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="text-sm text-gray-600">Contacts</dt>
                        <dd class="text-lg font-semibold text-gray-900">{{ $stats['total_contacts'] }}</dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="text-sm text-gray-600">Opportunités</dt>
                        <dd class="text-lg font-semibold text-gray-900">{{ $stats['total_opportunities'] }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Quick Access -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="h-5 w-5 text-red-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Accès Rapides
                </h3>
                <div class="space-y-2">
                    <a href="{{ route('admin.users.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 rounded-md hover:bg-gray-50 transition-colors">
                        <svg class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Gestion des utilisateurs
                    </a>
                    <a href="{{ route('admin.access-requests.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 rounded-md hover:bg-gray-50 transition-colors">
                        <svg class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Demandes d'accès
                        @if($stats['pending_requests'] > 0)
                            <span class="ml-auto inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                {{ $stats['pending_requests'] }}
                            </span>
                        @endif
                    </a>
                    <a href="{{ route('admin.settings') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 rounded-md hover:bg-gray-50 transition-colors">
                        <svg class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Paramètres système
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="lg:col-span-8">
            <!-- Tab Navigation -->
            <div class="bg-white rounded-lg shadow mb-6">
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px">
                        <button @click="activeTab = 'general'" :class="activeTab === 'general' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors">
                            Informations personnelles
                        </button>
                        <button @click="activeTab = 'security'" :class="activeTab === 'security' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors">
                            Sécurité
                        </button>
                        <button @click="activeTab = 'activity'" :class="activeTab === 'activity' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors">
                            Activité système
                        </button>
                    </nav>
                </div>
            </div>

            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <input type="file" name="avatar" id="avatar-input" class="hidden" accept="image/*" @change="previewAvatar">

                <!-- General Information Tab -->
                <div x-show="activeTab === 'general'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-5 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Informations personnelles</h3>
                            <p class="mt-1 text-sm text-gray-500">Mettez à jour vos informations de profil administrateur.</p>
                        </div>
                        
                        <div class="px-6 py-6 space-y-6">
                            <div class="space-y-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom complet <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors sm:text-sm" placeholder="Entrez votre nom complet">
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse e-mail <span class="text-red-500">*</span></label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors sm:text-sm" placeholder="votre.email@exemple.com">
                                </div>

                                <div>
                                    <label for="telephone" class="block text-sm font-medium text-gray-700 mb-1">Numéro de téléphone</label>
                                    <input type="tel" name="telephone" id="telephone" value="{{ old('telephone', $user->telephone) }}" class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors sm:text-sm" placeholder="+225 00 00 00 00">
                                    <p class="mt-1 text-xs text-gray-500">Format international recommandé</p>
                                </div>
                            </div>

                            <div class="bg-red-50 rounded-md p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">Compte Administrateur</h3>
                                        <div class="mt-2 text-sm text-red-700">
                                            <p>Vous disposez de tous les privilèges système. Votre rôle ne peut pas être modifié depuis cette page.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Enregistrer les modifications
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Security Tab -->
                <div x-show="activeTab === 'security'" style="display: none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-5 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Sécurité du compte</h3>
                            <p class="mt-1 text-sm text-gray-500">Modifiez votre mot de passe administrateur.</p>
                        </div>
                        
                        <div class="px-6 py-6 space-y-6">
                            <div class="rounded-md bg-blue-50 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <h3 class="text-sm font-medium text-blue-800">Vérification requise</h3>
                                        <div class="mt-2 text-sm text-blue-700">
                                            <p>Pour des raisons de sécurité, vous devez saisir votre mot de passe actuel pour effectuer des modifications.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe actuel <span class="text-red-500">*</span></label>
                                <input type="password" name="current_password" id="current_password" class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors sm:text-sm" placeholder="Saisissez votre mot de passe actuel">
                                <p class="mt-1 text-xs text-gray-500">Requis pour toute modification de sécurité</p>
                            </div>

                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div>
                                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe</label>
                                    <input type="password" name="new_password" id="new_password" class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors sm:text-sm" placeholder="Minimum 8 caractères">
                                    <p class="mt-1 text-xs text-gray-500">Au moins 8 caractères</p>
                                </div>

                                <div>
                                    <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe</label>
                                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors sm:text-sm" placeholder="Confirmez votre mot de passe">
                                    <p class="mt-1 text-xs text-gray-500">Doit correspondre au nouveau mot de passe</p>
                                </div>
                            </div>
                        </div>

                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Mettre à jour le mot de passe
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Activity Tab -->
            <div x-show="activeTab === 'activity'" style="display: none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Activité système récente</h3>
                        <p class="mt-1 text-sm text-gray-500">Consultez les dernières actions effectuées dans le système.</p>
                    </div>
                    
                    <div class="px-6 py-6">
                        @forelse($stats['recent_activities'] as $activity)
                            <div class="flex items-start py-4 {{ !$loop->last ? 'border-b border-gray-200' : '' }}">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-red-100 flex items-center justify-center">
                                        <svg class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <p class="text-sm font-medium text-gray-900">{{ $activity->description }}</p>
                                    <div class="mt-1 flex items-center gap-2 text-xs text-gray-500">
                                        <span>{{ $activity->user ? $activity->user->name : 'Système' }}</span>
                                        <span>•</span>
                                        <span>{{ $activity->created_at->translatedFormat('d F Y à H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune activité</h3>
                                <p class="mt-1 text-sm text-gray-500">Aucune activité système récente à afficher.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
