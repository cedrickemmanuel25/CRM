@extends('layouts.app')

@section('title', 'Mon Profil - Nexus Admin')

@section('content')
<div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 py-8 animate-fade-in-up" x-data="{ 
    activeTab: 'general',
    avatarPreview: '{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=6366f1&color=fff&size=256&bold=true' }}',
    previewAvatar(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => { 
                this.avatarPreview = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
}" x-init="
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
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tight uppercase">Profil Administrateur</h1>
            <p class="mt-2 text-slate-400 font-medium">Gérez votre profil et consultez les statistiques système</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-rose-500/10 text-rose-400 border border-rose-500/20 uppercase tracking-widest shadow-lg shadow-rose-900/20">
                <svg class="mr-2 h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                Administrateur
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left Sidebar - Profile Card & Stats -->
        <div class="lg:col-span-4 space-y-6">
            <!-- Profile Card -->
            <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 rounded-3xl overflow-hidden shadow-2xl relative group">
                <div class="h-32 bg-gradient-to-r from-indigo-600 to-purple-600 relative overflow-hidden">
                     <div class="absolute inset-0 bg-black/10"></div>
                     <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                </div>
                
                <div class="px-8 pb-8 relative">
                    <div class="relative -mt-16 mb-6 flex justify-center">
                        <div class="relative group cursor-pointer" onclick="document.getElementById('avatar-input').click()">
                            <div class="h-32 w-32 rounded-full border-4 border-slate-900 bg-slate-800 shadow-2xl overflow-hidden relative z-10">
                                <img :src="avatarPreview" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110" alt="{{ $user->name }}">
                            </div>
                            <div class="absolute inset-0 rounded-full bg-black/50 opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center z-20 backdrop-blur-sm">
                                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="absolute bottom-2 right-2 z-30 bg-indigo-500 text-white rounded-full p-1.5 border-2 border-slate-900 shadow-lg">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-black text-white tracking-tight">{{ $user->name }}</h2>
                        <p class="text-sm text-indigo-300 font-medium mt-1">{{ $user->email }}</p>
                        <div class="mt-4">
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 uppercase tracking-widest">
                                Administrateur Système
                            </span>
                        </div>
                    </div>

                    <div class="border-t border-white/5 pt-6 space-y-4">
                        <div class="flex items-center text-sm py-2">
                            <div class="h-8 w-8 rounded-lg bg-slate-800 flex items-center justify-center mr-3 border border-white/5">
                                <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span class="text-slate-400 font-medium">Membre depuis</span>
                            <span class="ml-auto font-bold text-white">{{ $user->created_at->format('M Y') }}</span>
                        </div>
                        <div class="flex items-center text-sm py-2">
                             <div class="h-8 w-8 rounded-lg bg-slate-800 flex items-center justify-center mr-3 border border-white/5">
                                <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                             </div>
                            <span class="text-slate-400 font-medium">Dernière mise à jour</span>
                            <span class="ml-auto font-bold text-white">{{ $user->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Stats -->
            <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 rounded-3xl overflow-hidden shadow-2xl p-6">
                <h3 class="text-xs font-black text-rose-500 uppercase tracking-widest mb-6 flex items-center gap-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                    Statistiques Système
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-slate-800/50 rounded-2xl p-4 border border-white/5">
                        <dt class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">Utilisateurs</dt>
                        <dd class="text-2xl font-black text-white">{{ $stats['total_users'] }}</dd>
                    </div>
                    <div class="bg-slate-800/50 rounded-2xl p-4 border border-white/5">
                        <dt class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">Contacts</dt>
                        <dd class="text-2xl font-black text-white">{{ $stats['total_contacts'] }}</dd>
                    </div>
                    <div class="bg-slate-800/50 rounded-2xl p-4 border border-white/5">
                        <dt class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">Opportunités</dt>
                        <dd class="text-2xl font-black text-white">{{ $stats['total_opportunities'] }}</dd>
                    </div>
                    <div class="bg-slate-800/50 rounded-2xl p-4 border border-white/5 relative overflow-hidden group">
                         <div class="absolute inset-0 bg-rose-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <dt class="text-xs text-rose-400 font-bold uppercase tracking-wider mb-1">En Attente</dt>
                        <dd class="text-2xl font-black text-rose-500">{{ $stats['pending_requests'] }}</dd>
                    </div>
                </div>
            </div>

            <!-- Quick Access -->
            <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 rounded-3xl overflow-hidden shadow-2xl p-6">
                <h3 class="text-xs font-black text-indigo-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                     <span class="h-1.5 w-1.5 rounded-full bg-indigo-500"></span>
                    Accès Rapides
                </h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 text-sm text-slate-300 rounded-xl bg-white/5 border border-white/5 hover:bg-white/10 hover:border-white/10 transition-all font-medium group">
                        <svg class="h-5 w-5 mr-3 text-indigo-400 group-hover:text-indigo-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Gestion des utilisateurs
                        <svg class="h-4 w-4 ml-auto text-slate-600 group-hover:text-slate-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                    <a href="{{ route('admin.access-requests.index') }}" class="flex items-center px-4 py-3 text-sm text-slate-300 rounded-xl bg-white/5 border border-white/5 hover:bg-white/10 hover:border-white/10 transition-all font-medium group">
                        <svg class="h-5 w-5 mr-3 text-rose-400 group-hover:text-rose-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Demandes d'accès
                        @if($stats['pending_requests'] > 0)
                            <span class="ml-auto inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-bold bg-rose-500 text-white shadow-lg shadow-rose-500/50">
                                {{ $stats['pending_requests'] }}
                            </span>
                        @else
                            <svg class="h-4 w-4 ml-auto text-slate-600 group-hover:text-slate-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        @endif
                    </a>
                    <a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-3 text-sm text-slate-300 rounded-xl bg-white/5 border border-white/5 hover:bg-white/10 hover:border-white/10 transition-all font-medium group">
                        <svg class="h-5 w-5 mr-3 text-emerald-400 group-hover:text-emerald-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Paramètres système
                        <svg class="h-4 w-4 ml-auto text-slate-600 group-hover:text-slate-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="lg:col-span-8 space-y-8">
            <!-- Tab Navigation -->
            <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 rounded-3xl p-2 flex gap-2 overflow-x-auto scrollbar-hide">
                <button @click="activeTab = 'general'" :class="activeTab === 'general' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-400 hover:text-white hover:bg-white/5'" class="whitespace-nowrap px-6 py-3 rounded-2xl font-bold text-sm transition-all duration-300 flex-1 lg:flex-none text-center">
                    Informations personnelles
                </button>
                <button @click="activeTab = 'security'" :class="activeTab === 'security' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-400 hover:text-white hover:bg-white/5'" class="whitespace-nowrap px-6 py-3 rounded-2xl font-bold text-sm transition-all duration-300 flex-1 lg:flex-none text-center">
                    Sécurité
                </button>
                <button @click="activeTab = 'activity'" :class="activeTab === 'activity' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-400 hover:text-white hover:bg-white/5'" class="whitespace-nowrap px-6 py-3 rounded-2xl font-bold text-sm transition-all duration-300 flex-1 lg:flex-none text-center">
                    Activité système
                </button>
            </div>

            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <input type="file" name="avatar" id="avatar-input" class="hidden" accept="image/*" @change="previewAvatar">

                <!-- General Information Tab -->
                <div x-show="activeTab === 'general'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="animate-fade-in-up">
                    <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 rounded-3xl overflow-hidden shadow-2xl">
                        <div class="px-8 py-6 border-b border-white/5 bg-white/[0.02]">
                            <h3 class="text-xl font-black text-white uppercase tracking-tight">Informations personnelles</h3>
                            <p class="mt-1 text-sm text-slate-400 font-medium">Mettez à jour vos informations de profil administrateur.</p>
                        </div>
                        
                        <div class="p-8 space-y-8">
                            <div class="grid grid-cols-1 gap-8">
                                <div>
                                    <label for="name" class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Nom complet <span class="text-rose-500">*</span></label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="block w-full rounded-xl border border-white/10 bg-slate-900/50 text-white placeholder-slate-500 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4 shadow-inner" placeholder="Entrez votre nom complet">
                                </div>

                                <div>
                                    <label for="email" class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Adresse e-mail <span class="text-rose-500">*</span></label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="block w-full rounded-xl border border-white/10 bg-slate-900/50 text-white placeholder-slate-500 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4 shadow-inner disabled:opacity-50" placeholder="votre.email@exemple.com">
                                </div>

                                <div>
                                    <label for="telephone" class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Numéro de téléphone</label>
                                    <input type="tel" name="telephone" id="telephone" value="{{ old('telephone', $user->telephone) }}" class="block w-full rounded-xl border border-white/10 bg-slate-900/50 text-white placeholder-slate-500 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4 shadow-inner" placeholder="+225 00 00 00 00">
                                </div>
                            </div>

                            <div class="bg-rose-500/10 border border-rose-500/20 rounded-2xl p-6 relative overflow-hidden">
                                <div class="absolute -right-4 -top-4 w-24 h-24 bg-rose-500/20 rounded-full blur-2xl"></div>
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-sm font-bold text-rose-400 uppercase tracking-wide">Compte Administrateur</h3>
                                        <div class="mt-2 text-sm text-rose-200/80 font-medium">
                                            <p>Vous disposez de tous les privilèges système. Votre rôle ne peut pas être modifié depuis cette page.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="px-8 py-6 bg-slate-900/50 border-t border-white/5 flex justify-end">
                            <button type="submit" class="inline-flex justify-center py-3 px-8 border border-transparent shadow-lg shadow-indigo-500/30 text-xs font-black uppercase tracking-wider rounded-xl text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:scale-105">
                                Enregistrer les modifications
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Security Tab -->
                <div x-show="activeTab === 'security'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="animate-fade-in-up">
                    <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 rounded-3xl overflow-hidden shadow-2xl">
                        <div class="px-8 py-6 border-b border-white/5 bg-white/[0.02]">
                            <h3 class="text-xl font-black text-white uppercase tracking-tight">Sécurité du compte</h3>
                            <p class="mt-1 text-sm text-slate-400 font-medium">Modifiez votre mot de passe administrateur.</p>
                        </div>
                        
                        <div class="p-8 space-y-8">
                            <div class="rounded-2xl bg-indigo-500/10 border border-indigo-500/20 p-6">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <h3 class="text-sm font-bold text-indigo-400 uppercase tracking-wide">Vérification requise</h3>
                                        <div class="mt-2 text-sm text-indigo-200/80 font-medium">
                                            <p>Pour des raisons de sécurité, vous devez saisir votre mot de passe actuel pour effectuer des modifications.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="current_password" class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Mot de passe actuel <span class="text-rose-500">*</span></label>
                                <input type="password" name="current_password" id="current_password" class="block w-full rounded-xl border border-white/10 bg-slate-900/50 text-white placeholder-slate-500 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4 shadow-inner" placeholder="Saisissez votre mot de passe actuel">
                            </div>

                            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2">
                                <div>
                                    <label for="new_password" class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Nouveau mot de passe</label>
                                    <input type="password" name="new_password" id="new_password" class="block w-full rounded-xl border border-white/10 bg-slate-900/50 text-white placeholder-slate-500 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4 shadow-inner" placeholder="Minimum 8 caractères">
                                </div>

                                <div>
                                    <label for="new_password_confirmation" class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Confirmer le mot de passe</label>
                                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="block w-full rounded-xl border border-white/10 bg-slate-900/50 text-white placeholder-slate-500 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4 shadow-inner" placeholder="Confirmez votre mot de passe">
                                </div>
                            </div>
                        </div>

                        <div class="px-8 py-6 bg-slate-900/50 border-t border-white/5 flex justify-end">
                            <button type="submit" class="inline-flex justify-center py-3 px-8 border border-transparent shadow-lg shadow-indigo-500/30 text-xs font-black uppercase tracking-wider rounded-xl text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:scale-105">
                                Mettre à jour le mot de passe
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Activity Tab -->
            <div x-show="activeTab === 'activity'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="animate-fade-in-up">
                <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 rounded-3xl overflow-hidden shadow-2xl">
                    <div class="px-8 py-6 border-b border-white/5 bg-white/[0.02]">
                        <h3 class="text-xl font-black text-white uppercase tracking-tight">Activité système récente</h3>
                        <p class="mt-1 text-sm text-slate-400 font-medium">Consultez les dernières actions effectuées dans le système.</p>
                    </div>
                    
                    <div class="px-8 py-6">
                        @forelse($stats['recent_activities'] as $activity)
                            <div class="flex items-start py-6 {{ !$loop->last ? 'border-b border-white/5' : '' }} hover:bg-white/[0.02] -mx-8 px-8 transition-colors">
                                <div class="flex-shrink-0 mt-1">
                                    <div class="h-10 w-10 rounded-full bg-slate-800 flex items-center justify-center border border-white/10 ring-4 ring-slate-900">
                                        <svg class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-5 flex-1">
                                    <p class="text-sm font-bold text-white">{{ $activity->description }}</p>
                                    <div class="mt-1.5 flex items-center gap-3 text-xs text-slate-500 font-medium">
                                        <span class="flex items-center gap-1.5">
                                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                            {{ $activity->user ? $activity->user->name : 'Système' }}
                                        </span>
                                        <span class="h-1 w-1 rounded-full bg-slate-600"></span>
                                        <span class="flex items-center gap-1.5">
                                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            {{ $activity->created_at->translatedFormat('d F Y à H:i') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-16">
                                <div class="h-20 w-20 rounded-full bg-slate-800/50 flex items-center justify-center mx-auto mb-4 border border-white/5">
                                    <svg class="h-10 w-10 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-white">Aucune activité</h3>
                                <p class="mt-2 text-sm text-slate-400 font-medium">Aucune activité système récente à afficher.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
    }
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
@endsection
