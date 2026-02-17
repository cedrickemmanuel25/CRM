@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ 
    activeTab: 'general',
    avatarPreview: '{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=4F46E5&color=fff&size=256&bold=true' }}',
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
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Paramètres du profil</h1>
            <p class="mt-1 text-sm text-slate-400">Gérez vos informations personnelles et vos préférences de compte</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left Sidebar - Profile Card -->
        <div class="lg:col-span-4">
            <div class="bg-slate-800/20 backdrop-blur-xl rounded-2xl border border-white/10 shadow-2xl overflow-hidden transition-all duration-300 hover:border-white/20">
                <!-- Profile Header -->
                <div class="h-24 bg-gradient-to-r from-blue-600 to-cyan-500 opacity-80"></div>
                
                <!-- Profile Content -->
                <div class="px-6 pb-6 text-center">
                    <div class="relative -mt-12 mb-6 flex justify-center">
                        <div class="inline-block relative group cursor-pointer" onclick="document.getElementById('avatar-input').click()">
                            <div class="h-28 w-28 rounded-2xl border-4 border-[#030712] bg-[#030712] shadow-2xl overflow-hidden transition-transform duration-300 group-hover:scale-105">
                                <img :src="avatarPreview" class="h-full w-full object-cover" alt="{{ $user->name }}">
                            </div>
                            <div class="absolute inset-0 rounded-2xl bg-black/60 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center backdrop-blur-sm">
                                <svg class="h-8 w-8 text-white scale-75 group-hover:scale-100 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <span class="absolute -bottom-1 -right-1 block h-5 w-5 rounded-full bg-emerald-500 border-4 border-[#030712] shadow-lg animate-pulse"></span>
                        </div>
                    </div>
                    
                    <div class="mb-8">
                        <h2 class="text-xl font-black text-white tracking-tight uppercase">{{ $user->name }}</h2>
                        <p class="text-sm text-slate-400 mt-1 font-medium">{{ $user->email }}</p>
                        <div class="mt-4">
                            <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest {{ $user->isAdmin() ? 'bg-rose-500/10 text-rose-400 border border-rose-500/20' : 'bg-blue-500/10 text-blue-400 border border-blue-500/20' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    </div>

                    <!-- Stats Grid -->
                    <div class="border-t border-white/5 pt-8 mb-8">
                        <dl class="grid grid-cols-2 gap-4">
                            <div class="p-4 bg-white/5 rounded-2xl border border-white/5 hover:bg-white/10 transition-colors">
                                <dt class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Contacts</dt>
                                <dd class="text-2xl font-black text-white tracking-tighter">{{ $user->contacts()->count() }}</dd>
                            </div>
                            <div class="p-4 bg-white/5 rounded-2xl border border-white/5 hover:bg-white/10 transition-colors">
                                <dt class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Opportunités</dt>
                                <dd class="text-2xl font-black text-white tracking-tighter">{{ $user->opportunities()->count() }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Account Info -->
                    <div class="border-t border-white/5 pt-8 space-y-4">
                        <div class="flex items-center text-xs font-bold text-slate-400">
                            <svg class="h-4 w-4 mr-3 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="uppercase tracking-widest text-[9px]">Membre depuis</span>
                            <span class="ml-auto text-white">{{ $user->created_at->format('M Y') }}</span>
                        </div>
                        <div class="flex items-center text-xs font-bold text-slate-400">
                            <svg class="h-4 w-4 mr-3 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="uppercase tracking-widest text-[9px]">Dernière MAJ</span>
                            <span class="ml-auto text-white">{{ $user->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="lg:col-span-8">
            <!-- Tab Navigation -->
            <div class="bg-slate-800/20 backdrop-blur-xl rounded-2xl border border-white/10 shadow-2xl mb-8 overflow-hidden">
                <nav class="flex p-2 gap-2">
                    <button @click="activeTab = 'general'" :class="activeTab === 'general' ? 'bg-gradient-to-r from-blue-600 to-cyan-400 text-white shadow-lg' : 'text-slate-500 hover:text-slate-300 hover:bg-white/5'" class="flex-1 py-3 px-6 rounded-xl font-bold text-[11px] uppercase tracking-widest transition-all duration-300">
                        Informations générales
                    </button>
                    <button @click="activeTab = 'security'" :class="activeTab === 'security' ? 'bg-gradient-to-r from-blue-600 to-cyan-400 text-white shadow-lg' : 'text-slate-500 hover:text-slate-300 hover:bg-white/5'" class="flex-1 py-3 px-6 rounded-xl font-bold text-[11px] uppercase tracking-widest transition-all duration-300">
                        Sécurité
                    </button>
                    <button @click="activeTab = 'activity'" :class="activeTab === 'activity' ? 'bg-gradient-to-r from-blue-600 to-cyan-400 text-white shadow-lg' : 'text-slate-500 hover:text-slate-300 hover:bg-white/5'" class="flex-1 py-3 px-6 rounded-xl font-bold text-[11px] uppercase tracking-widest transition-all duration-300">
                        Activité récente
                    </button>
                </nav>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <input type="file" name="avatar" id="avatar-input" class="hidden" accept="image/*" @change="previewAvatar">

                <!-- General Information Tab -->
                <div x-show="activeTab === 'general'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="bg-slate-800/20 backdrop-blur-xl rounded-2xl border border-white/10 shadow-2xl overflow-hidden">
                        <div class="px-8 py-6 border-b border-white/10 bg-white/5">
                            <h3 class="text-sm font-black text-white uppercase tracking-widest">Informations personnelles</h3>
                            <p class="mt-1 text-xs text-slate-400 font-medium">Mettez à jour vos informations de profil et votre adresse e-mail.</p>
                        </div>
                        
                        <div class="p-8 space-y-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-2">
                                    <label for="name" class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">Nom complet <span class="text-rose-500">*</span></label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required 
                                        class="block w-full h-12 px-5 rounded-xl border-2 border-white/10 bg-slate-900/40 text-sm font-bold text-white placeholder-slate-600 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none" 
                                        placeholder="Entrez votre nom complet">
                                </div>

                                <div class="space-y-2">
                                    <label for="email" class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">Adresse e-mail <span class="text-rose-500">*</span></label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required 
                                        class="block w-full h-12 px-5 rounded-xl border-2 border-white/10 bg-slate-900/40 text-sm font-bold text-white placeholder-slate-600 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none" 
                                        placeholder="votre.email@exemple.com">
                                </div>

                                <div class="col-span-1 md:col-span-2 space-y-2">
                                    <label for="telephone" class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">Numéro de téléphone</label>
                                    <div class="iti-container">
                                        <input type="tel" name="telephone" id="telephone" value="{{ old('telephone', $user->telephone) }}" 
                                            class="block w-full h-12 px-5 rounded-xl border-2 border-white/10 bg-slate-900/40 text-sm font-bold text-white placeholder-slate-600 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none" 
                                            placeholder="+225 00 00 00 00">
                                    </div>
                                    <p class="mt-2 text-[10px] text-slate-500 font-bold italic uppercase tracking-tighter">Format international recommandé</p>
                                </div>
                            </div>

                            <div class="bg-blue-600/5 rounded-2xl border border-blue-500/10 p-6 flex gap-5">
                                <div class="flex-shrink-0 self-center">
                                    <div class="p-3 bg-blue-500/10 rounded-xl text-blue-400">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xs font-black text-slate-200 uppercase tracking-widest">Rôle utilisateur</h3>
                                    <p class="mt-1 text-xs text-slate-400 font-medium leading-relaxed">
                                        Votre rôle actuel est <span class="text-blue-400 font-black uppercase text-[10px] tracking-widest">{{ ucfirst($user->role) }}</span>. 
                                        Contactez un administrateur pour modifier vos permissions ou votre accès système.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="px-8 py-5 bg-white/5 border-t border-white/10 flex justify-end">
                            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-cyan-400 text-white rounded-xl font-black text-[11px] uppercase tracking-widest shadow-lg shadow-blue-500/20 hover:shadow-cyan-500/30 transition-all active:scale-95">
                                Enregistrer les modifications
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Security Tab -->
                <div x-show="activeTab === 'security'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="bg-slate-800/20 backdrop-blur-xl rounded-2xl border border-white/10 shadow-2xl overflow-hidden">
                        <div class="px-8 py-6 border-b border-white/10 bg-white/5">
                            <h3 class="text-sm font-black text-white uppercase tracking-widest">Sécurité du compte</h3>
                            <p class="mt-1 text-xs text-slate-400 font-medium">Modifiez votre mot de passe pour sécuriser votre compte.</p>
                        </div>
                        
                        <div class="p-8 space-y-8">
                            <div class="bg-rose-500/5 rounded-2xl border border-rose-500/10 p-6 flex gap-5">
                                <div class="flex-shrink-0 self-center">
                                    <div class="p-3 bg-rose-500/10 rounded-xl text-rose-400 animate-pulse">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1 text-left">
                                    <h3 class="text-xs font-black text-slate-200 uppercase tracking-widest">Vérification requise</h3>
                                    <p class="mt-1 text-xs text-slate-400 font-medium leading-relaxed">
                                        Pour des raisons de sécurité, vous devez saisir votre mot de passe actuel pour effectuer des modifications sur les paramètres de sécurité.
                                    </p>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label for="current_password" class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">Mot de passe actuel <span class="text-rose-500">*</span></label>
                                <input type="password" name="current_password" id="current_password" 
                                    class="block w-full h-12 px-5 rounded-xl border-2 border-white/10 bg-slate-900/40 text-sm font-bold text-white placeholder-slate-600 focus:border-rose-500 focus:ring-4 focus:ring-rose-500/10 transition-all outline-none" 
                                    placeholder="Saisissez votre mot de passe actuel">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-2">
                                    <label for="new_password" class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">Nouveau mot de passe</label>
                                    <input type="password" name="new_password" id="new_password" 
                                        class="block w-full h-12 px-5 rounded-xl border-2 border-white/10 bg-slate-900/40 text-sm font-bold text-white placeholder-slate-600 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none" 
                                        placeholder="Minimum 8 caractères">
                                </div>

                                <div class="space-y-2">
                                    <label for="new_password_confirmation" class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">Confirmer le mot de passe</label>
                                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" 
                                        class="block w-full h-12 px-5 rounded-xl border-2 border-white/10 bg-slate-900/40 text-sm font-bold text-white placeholder-slate-600 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none" 
                                        placeholder="Confirmez votre nouveau mot de passe">
                                </div>
                            </div>
                        </div>

                        <div class="px-8 py-5 bg-white/5 border-t border-white/10 flex justify-end">
                            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-cyan-400 text-white rounded-xl font-black text-[11px] uppercase tracking-widest shadow-lg shadow-blue-500/20 hover:shadow-cyan-500/30 transition-all active:scale-95">
                                Mettre à jour le mot de passe
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Activity Tab -->
            <div x-show="activeTab === 'activity'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="bg-slate-800/20 backdrop-blur-xl rounded-2xl border border-white/10 shadow-2xl overflow-hidden">
                    <div class="px-8 py-6 border-b border-white/10 bg-white/5">
                        <h3 class="text-sm font-black text-white uppercase tracking-widest">Activité récente</h3>
                        <p class="mt-1 text-xs text-slate-400 font-medium">Consultez vos dernières actions dans le système.</p>
                    </div>
                    
                    <div class="p-0">
                        @forelse($user->activities()->latest()->limit(10)->get() as $activity)
                            <div class="flex items-start p-6 hover:bg-white/5 transition-colors {{ !$loop->last ? 'border-b border-white/5' : '' }}">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-5 flex-1 self-center">
                                    <p class="text-[11px] font-black text-white uppercase tracking-wider">{{ $activity->description }}</p>
                                    <p class="mt-1 text-[10px] text-slate-500 font-bold uppercase tracking-tighter">{{ $activity->created_at->translatedFormat('d F Y à H:i') }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-20">
                                <div class="inline-flex items-center justify-center h-16 w-16 rounded-3xl bg-white/5 border border-white/10 mb-6 group hover:border-blue-500/30 transition-all duration-500">
                                    <svg class="h-8 w-8 text-slate-600 transition-colors duration-500 group-hover:text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest leading-none">Aucune activité</h3>
                                <p class="mt-2 text-xs text-slate-600 font-medium">Votre historique d'actions est vide pour le moment.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</style>
@endsection
