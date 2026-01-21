@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ tab: 'general' }">
    <!-- Profile Header -->
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden mb-8 border border-gray-100 transition-all hover:shadow-2xl">
        <div class="h-32 bg-gradient-to-r from-indigo-600 via-blue-600 to-indigo-700"></div>
        <div class="px-8 pb-8">
            <div class="relative flex flex-col sm:flex-row items-end -mt-12 gap-6">
                <div class="relative group">
                    <img class="h-32 w-32 rounded-2xl ring-4 ring-white object-cover bg-white shadow-lg transition-transform duration-300 group-hover:scale-105" 
                        src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=6366f1&color=fff&size=128&bold=true' }}" 
                        alt="{{ $user->name }}">
                    <div class="absolute inset-0 rounded-2xl bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center cursor-pointer" 
                        onclick="document.getElementById('avatar-input').click()">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </div>
                <div class="flex-1 text-center sm:text-left pt-4">
                    <h1 class="text-3xl font-black text-gray-900 tracking-tight">{{ $user->name }}</h1>
                    <div class="flex flex-wrap justify-center sm:justify-start items-center gap-3 mt-1.5">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold tracking-wider uppercase {{ $user->isAdmin() ? 'bg-red-100 text-red-700' : 'bg-indigo-100 text-indigo-700' }}">
                            {{ $user->role }}
                        </span>
                        <span class="text-gray-400 font-medium text-sm flex items-center gap-1">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            {{ $user->email }}
                        </span>
                    </div>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route($user->getDashboardRoute()) }}" class="inline-flex items-center px-5 py-2.5 border border-gray-200 shadow-sm text-sm font-bold rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-all">
                        Retour au Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Sidebar Navigation -->
        <div class="lg:col-span-1 space-y-4">
            <nav class="flex flex-col gap-2">
                <button @click="tab = 'general'" :class="tab === 'general' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-gray-600 hover:bg-gray-100'" class="flex items-center gap-3 px-5 py-3.5 rounded-2xl text-sm font-bold transition-all text-left">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    Informations Générales
                </button>
                <button @click="tab = 'security'" :class="tab === 'security' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-gray-600 hover:bg-gray-100'" class="flex items-center gap-3 px-5 py-3.5 rounded-2xl text-sm font-bold transition-all text-left">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    Sécurité & Accès
                </button>
                <button @click="tab = 'stats'" :class="tab === 'stats' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-gray-600 hover:bg-gray-100'" class="flex items-center gap-3 px-5 py-3.5 rounded-2xl text-sm font-bold transition-all text-left">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    Statistiques d'Activité
                </button>
            </nav>

            <!-- Quick Info Card -->
            <div class="bg-indigo-900 rounded-3xl p-6 text-white shadow-xl relative overflow-hidden group">
                <div class="absolute -right-10 -bottom-10 h-32 w-32 bg-indigo-500/20 rounded-full transition-transform group-hover:scale-150"></div>
                <h4 class="text-indigo-200 text-xs font-black uppercase tracking-widest mb-4">Statut Compte</h4>
                <div class="flex items-center gap-3 mb-6">
                    <div class="h-2 w-2 rounded-full bg-green-400 animate-pulse"></div>
                    <span class="font-bold">Actif & Vérifié</span>
                </div>
                <div class="space-y-4">
                    <div>
                        <p class="text-indigo-300 text-[10px] font-bold uppercase tracking-tighter">Membre depuis</p>
                        <p class="font-medium text-sm">{{ $user->created_at->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-indigo-300 text-[10px] font-bold uppercase tracking-tighter">Dernière Connexion</p>
                        <p class="font-medium text-sm">{{ now()->format('d/m H:i') }} (IP: {{ request()->ip() }})</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="lg:col-span-3">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <input type="file" name="avatar" id="avatar-input" class="hidden" accept="image/*" @change="tab = 'general'">

                <!-- Tab: General Info -->
                <div x-show="tab === 'general'" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8">
                    <div class="mb-8 border-b border-gray-100 pb-5">
                        <h3 class="text-xl font-black text-gray-900">Informations Générales</h3>
                        <p class="text-sm text-gray-500">Mettez à jour vos informations personnelles de contact.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nom Complet</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-3.5 rounded-xl border-gray-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-medium" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Adresse Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-3.5 rounded-xl border-gray-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-medium" required>
                        </div>

                         <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Numéro de Téléphone</label>
                            <input type="tel" name="telephone" value="{{ old('telephone', $user->telephone) }}" class="w-full px-4 py-3.5 rounded-xl border-gray-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-medium" placeholder="+225 .. .. .. ..">
                        </div>

                        <div class="md:col-span-2 bg-gray-50 rounded-2xl p-6 border border-gray-100">
                             <div class="flex items-center gap-4">
                                <div class="h-12 w-12 rounded-xl bg-white shadow-sm border border-gray-200 flex items-center justify-center">
                                    <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-black text-gray-400 uppercase tracking-widest">Rôle Utilisateur</p>
                                    <p class="font-bold text-gray-900">{{ ucfirst($user->role) }} - {{ company_name() }}</p>
                                </div>
                             </div>
                        </div>
                    </div>

                    <div class="mt-10 flex justify-end gap-4 pb-2">
                        <button type="submit" class="inline-flex items-center justify-center px-8 py-3.5 rounded-2xl bg-indigo-600 text-white font-black hover:bg-indigo-700 transition-all shadow-lg hover:shadow-indigo-200">
                            Enregistrer les modifications
                        </button>
                    </div>
                </div>

                <!-- Tab: Security -->
                <div x-show="tab === 'security'" style="display: none;" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8">
                    <div class="mb-8 border-b border-gray-100 pb-5">
                        <h3 class="text-xl font-black text-gray-900">Sécurité & Mot de passe</h3>
                        <p class="text-sm text-gray-500">Mettez à jour votre mot de passe pour sécuriser votre compte.</p>
                    </div>

                    <div class="space-y-6">
                        <div class="p-6 bg-amber-50 rounded-2xl border border-amber-100 flex gap-4">
                            <svg class="h-6 w-6 text-amber-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                            <div>
                                <h4 class="font-bold text-amber-900">Validation requise</h4>
                                <p class="text-sm text-amber-800 leading-relaxed">Pour toute modification sensible, vous devez saisir votre mot de passe actuel afin de confirmer votre identité.</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Mot de passe actuel <span class="text-red-500">*</span></label>
                            <input type="password" name="current_password" class="w-full px-4 py-3.5 rounded-xl border-gray-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-medium" placeholder="••••••••">
                        </div>

                         <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nouveau mot de passe</label>
                                <input type="password" name="new_password" class="w-full px-4 py-3.5 rounded-xl border-gray-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-medium" placeholder="Minimum 8 caractères">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Confirmer le mot de passe</label>
                                <input type="password" name="new_password_confirmation" class="w-full px-4 py-3.5 rounded-xl border-gray-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-medium" placeholder="••••••••">
                            </div>
                         </div>
                    </div>

                    <div class="mt-10 flex justify-end gap-4 pb-2">
                        <button type="submit" class="inline-flex items-center justify-center px-8 py-3.5 rounded-2xl bg-indigo-600 text-white font-black hover:bg-indigo-700 transition-all shadow-lg hover:shadow-indigo-200">
                            Mettre à jour le mot de passe
                        </button>
                    </div>
                </div>

                <!-- Tab: Stats (Mock) -->
                <div x-show="tab === 'stats'" style="display: none;" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 text-center transition-transform hover:-translate-y-2">
                            <div class="h-16 w-16 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-4 border-4 border-white shadow-sm">
                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                            </div>
                            <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-1">Contacts</p>
                            <p class="text-3xl font-black text-gray-900">{{ $user->contacts()->count() }}</p>
                            <p class="text-xs text-gray-400 mt-2 font-medium">Gérés dans le système</p>
                        </div>

                         <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 text-center transition-transform hover:-translate-y-2">
                             <div class="h-16 w-16 rounded-full bg-green-50 text-green-600 flex items-center justify-center mx-auto mb-4 border-4 border-white shadow-sm">
                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-1">Opportunités</p>
                            <p class="text-3xl font-black text-gray-900">{{ $user->opportunities()->count() }}</p>
                            <p class="text-xs text-gray-400 mt-2 font-medium">Dans le pipeline</p>
                        </div>

                         <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 text-center transition-transform hover:-translate-y-2">
                             <div class="h-16 w-16 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center mx-auto mb-4 border-4 border-white shadow-sm">
                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 002-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                            </div>
                            <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-1">Tâches</p>
                            <p class="text-3xl font-black text-gray-900">{{ $user->activities()->count() }}</p>
                            <p class="text-xs text-gray-400 mt-2 font-medium">Actions enregistrées</p>
                        </div>
                    </div>
                    
                    <div class="mt-8 bg-white rounded-3xl shadow-xl border border-gray-100 p-8">
                        <h4 class="font-black text-gray-900 mb-6 flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-indigo-600"></span>
                            Dernières Activités
                        </h4>
                        <div class="space-y-4">
                            @forelse($user->activities()->latest()->limit(5)->get() as $activity)
                                <div class="flex items-center gap-4 py-3 border-b border-gray-50 last:border-0">
                                    <div class="h-10 w-10 rounded-xl bg-gray-50 flex items-center justify-center shrink-0">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0y" /></svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-bold text-gray-900">{{ $activity->description }}</p>
                                        <p class="text-[10px] text-gray-400 font-medium tracking-tight">{{ $activity->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-10">
                                    <p class="text-gray-400 text-sm font-medium">Aucune activité récente à afficher.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
