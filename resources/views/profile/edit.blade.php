@extends('layouts.app')

@section('title', 'Mon Profil - Executive CRM')

@section('content')
<div class="max-w-[1600px] mx-auto" x-data="{ 
    tab: 'general', 
    avatarPreview: '{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=6366f1&color=fff&size=256&bold=true' }}',
    handleAvatarChange(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => { this.avatarPreview = e.target.result; };
            reader.readAsDataURL(file);
        }
    }
}">
    <!-- Header Page Title -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter">Profil Utilisateur</h1>
            <p class="text-slate-500 font-medium mt-1">Paramètres du compte et indicateurs de performance.</p>
        </div>
        <div class="flex items-center gap-2 text-sm">
            <span class="text-slate-400">Dernière mise à jour :</span>
            <span class="text-slate-900 font-bold bg-white px-3 py-1 rounded-full shadow-sm border border-slate-100">{{ $user->updated_at->format('d/m/Y H:i') }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        <!-- SIDEBAR : IDENTITY & STATS (4/12) -->
        <div class="lg:col-span-4 space-y-8">
            <!-- Main Info Card -->
            <div class="bg-white rounded-[2rem] shadow-2xl shadow-indigo-100/50 border border-slate-100 overflow-hidden relative">
                <div class="h-32 bg-slate-900 absolute w-full top-0 left-0"></div>
                <div class="relative px-8 pt-16 pb-12 flex flex-col items-center text-center">
                    <!-- Avatar with Hover Effect -->
                    <div class="relative group cursor-pointer" onclick="document.getElementById('avatar-input').click()">
                        <div class="h-40 w-40 rounded-[2.5rem] bg-indigo-50 border-8 border-white shadow-2xl overflow-hidden transition-all duration-500 group-hover:rotate-3 group-hover:scale-105">
                            <img :src="avatarPreview" class="h-full w-full object-cover" alt="{{ $user->name }}">
                        </div>
                        <div class="absolute inset-0 rounded-[2.5rem] bg-indigo-600/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <svg class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div class="absolute -bottom-2 -right-2 bg-green-500 h-8 w-8 rounded-full border-4 border-white shadow-lg" title="Statut : Opérationnel"></div>
                    </div>

                    <h2 class="mt-8 text-3xl font-black text-slate-900 tracking-tight">{{ $user->name }}</h2>
                    <div class="mt-2 inline-flex items-center px-4 py-1.5 rounded-2xl text-[10px] font-black uppercase tracking-widest {{ $user->isAdmin() ? 'bg-rose-100 text-rose-700' : 'bg-indigo-100 text-indigo-700' }}">
                        {{ $user->role }}
                    </div>

                    <p class="mt-4 text-slate-400 font-medium text-sm max-w-xs">Responsable des opérations CRM chez {{ company_name() }}</p>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="p-2.5 bg-blue-50 text-blue-600 rounded-xl">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </div>
                        <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Base Clients</span>
                    </div>
                    <p class="text-3xl font-black text-slate-900">{{ $user->contacts()->count() }}</p>
                </div>

                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                        </div>
                        <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Pipeline</span>
                    </div>
                    <p class="text-3xl font-black text-slate-900">{{ $user->opportunities()->count() }}</p>
                </div>
            </div>

            <!-- Experience Badge -->
            <div class="bg-indigo-600 rounded-[2rem] p-8 text-white relative overflow-hidden shadow-xl shadow-indigo-600/30 group">
                <div class="relative z-10">
                    <h4 class="text-indigo-200 text-xs font-black uppercase tracking-widest mb-4">Performance Score</h4>
                    <div class="flex items-end gap-2 mb-2">
                        <span class="text-5xl font-black italic">A+</span>
                        <span class="text-indigo-200 font-bold mb-1.5 uppercase text-[10px]">Utilisateur Élite</span>
                    </div>
                    <div class="h-1.5 w-full bg-white/20 rounded-full mt-4 overflow-hidden">
                        <div class="h-full bg-white w-[92%] transition-all duration-1000 group-hover:w-full"></div>
                    </div>
                    <p class="text-[10px] text-indigo-100 mt-3 font-medium opacity-80 italic">Score basé sur l'activité des 30 derniers jours.</p>
                </div>
                <!-- Abstract Design Elements -->
                <div class="absolute top-0 right-0 -mr-16 -mt-16 h-48 w-48 bg-white/10 rounded-full group-hover:scale-125 transition-transform duration-700"></div>
                <div class="absolute bottom-0 right-0 mr-8 mb-8 opacity-20">
                    <svg class="h-24 w-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
                </div>
            </div>
        </div>

        <!-- MAIN CONTENT : FORM & CONFIG (8/12) -->
        <div class="lg:col-span-8 space-y-8">
            <!-- Professional Navigation Tabs -->
            <div class="bg-white p-2.5 rounded-[1.5rem] border border-slate-100 shadow-sm flex flex-wrap gap-2">
                <button @click="tab = 'general'" :class="tab === 'general' ? 'bg-slate-900 text-white shadow-lg' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50'" class="flex-1 min-w-[150px] flex items-center justify-center gap-3 px-6 py-4 rounded-xl text-sm font-black transition-all">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    Informations Générales
                </button>
                <button @click="tab = 'security'" :class="tab === 'security' ? 'bg-slate-900 text-white shadow-lg' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50'" class="flex-1 min-w-[150px] flex items-center justify-center gap-3 px-6 py-4 rounded-xl text-sm font-black transition-all">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    Sécurité & Accès
                </button>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <input type="file" name="avatar" id="avatar-input" class="hidden" accept="image/*" @change="handleAvatarChange">

                <!-- TAB CONTENT : GENERAL -->
                <div x-show="tab === 'general'" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="bg-white rounded-[2rem] shadow-xl border border-slate-100 p-10">
                    <div class="mb-10 pb-6 border-b border-slate-50 flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-black text-slate-900 tracking-tight">Coordonnées</h3>
                            <p class="text-slate-400 font-medium text-sm">Gestion des informations d'identité et de contact.</p>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-[1.2rem]">
                            <svg class="h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Nom complet sur la plateforme</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-5 py-4 rounded-2xl border-slate-100 bg-slate-50 focus:bg-white focus:ring-4 focus:ring-indigo-600/10 focus:border-indigo-600 transition-all font-bold text-slate-900" required>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Email Professionnel</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-5 py-4 rounded-2xl border-slate-100 bg-slate-50 focus:bg-white focus:ring-4 focus:ring-indigo-600/10 focus:border-indigo-600 transition-all font-bold text-slate-900" required>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Numéro Mobile</label>
                            <input type="tel" name="telephone" value="{{ old('telephone', $user->telephone) }}" class="w-full px-5 py-4 rounded-2xl border-slate-100 bg-slate-50 focus:bg-white focus:ring-4 focus:ring-indigo-600/10 focus:border-indigo-600 transition-all font-bold text-slate-900" placeholder="+225 00 00 00 00">
                        </div>
                    </div>

                    <div class="mt-12 p-8 bg-slate-900 rounded-[2rem] text-white flex items-center justify-between">
                        <div class="flex items-center gap-5">
                            <div class="h-14 w-14 rounded-2xl bg-white/10 flex items-center justify-center">
                                <svg class="h-7 w-7 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-black uppercase text-indigo-300 tracking-[0.2em] mb-1">Privilèges d'accès</p>
                                <p class="text-xl font-black tracking-tight">Autorisations de Niveau {{ $user->isAdmin() ? 'Expert (Admin)' : 'Standard (' . ucfirst($user->role) . ')' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-12 flex justify-end">
                        <button type="submit" class="inline-flex items-center justify-center px-10 py-5 rounded-2xl bg-indigo-600 text-white font-black hover:bg-indigo-700 transition-all shadow-2xl shadow-indigo-600/40 hover:-translate-y-1">
                            Sauvegarder les modifications
                        </button>
                    </div>
                </div>

                <!-- TAB CONTENT : SECURITY -->
                <div x-show="tab === 'security'" style="display: none;" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="bg-white rounded-[2rem] shadow-xl border border-slate-100 p-10">
                    <div class="mb-10 pb-6 border-b border-slate-50 flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-black text-slate-900 tracking-tight">Authentification</h3>
                            <p class="text-slate-400 font-medium text-sm">Renforcement de la sécurité de votre session.</p>
                        </div>
                        <div class="p-4 bg-rose-50 rounded-[1.2rem]">
                            <svg class="h-6 w-6 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </div>
                    </div>

                    <div class="space-y-8">
                        <div class="p-8 bg-slate-50 rounded-[2rem] border border-slate-100">
                             <div class="flex gap-4">
                                <div class="h-10 w-10 bg-indigo-600 rounded-xl flex items-center justify-center shrink-0">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                <div>
                                    <h4 class="font-black text-slate-900 text-lg">Vérification d'identité requise</h4>
                                    <p class="text-slate-500 text-sm mt-1 leading-relaxed">Conformément à nos politiques de sécurité, toute mise à jour du mot de passe nécessite la validation de votre code d'accès actuel.</p>
                                </div>
                             </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                             <div class="md:col-span-2">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Mot de passe actuel</label>
                                <input type="password" name="current_password" class="w-full px-5 py-4 rounded-2xl border-slate-100 bg-slate-50 focus:bg-white focus:ring-4 focus:ring-indigo-600/10 focus:border-indigo-600 transition-all font-bold text-slate-900" placeholder="••••••••">
                            </div>

                            <div>
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Nouveau code d'accès</label>
                                <input type="password" name="new_password" class="w-full px-5 py-4 rounded-2xl border-slate-100 bg-slate-50 focus:bg-white focus:ring-4 focus:ring-indigo-600/10 focus:border-indigo-600 transition-all font-bold text-slate-900" placeholder="Minimum 8 caractères">
                            </div>

                            <div>
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Confirmation du nouveau code</label>
                                <input type="password" name="new_password_confirmation" class="w-full px-5 py-4 rounded-2xl border-slate-100 bg-slate-50 focus:bg-white focus:ring-4 focus:ring-indigo-600/10 focus:border-indigo-600 transition-all font-bold text-slate-900" placeholder="••••••••">
                            </div>
                        </div>
                    </div>

                    <div class="mt-12 flex justify-end">
                        <button type="submit" class="inline-flex items-center justify-center px-10 py-5 rounded-2xl bg-slate-900 text-white font-black hover:bg-black transition-all shadow-2xl shadow-slate-900/40 hover:-translate-y-1">
                            Mettre à jour la sécurité
                        </button>
                    </div>
                </div>
            </form>

            <!-- Activity Logs Section -->
            <div class="bg-white rounded-[2rem] shadow-xl border border-slate-100 p-10 mt-10">
                <div class="mb-10 pb-6 border-b border-slate-50">
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight">Journal d'Inactivité</h3>
                    <p class="text-slate-400 font-medium text-sm">Vos 5 dernières interactions enregistrées dans le CRM.</p>
                </div>

                <div class="space-y-6">
                    @forelse($user->activities()->latest()->limit(5)->get() as $activity)
                        <div class="flex items-center gap-6 p-4 rounded-2xl hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100">
                            <div class="h-14 w-14 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 shadow-inner">
                                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-slate-900 font-black tracking-tight">{{ $activity->description }}</p>
                                <div class="flex items-center gap-3 mt-1">
                                    <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest">{{ $activity->created_at->translatedFormat('d F Y') }}</span>
                                    <span class="h-1 w-1 rounded-full bg-slate-200"></span>
                                    <span class="text-[10px] font-bold text-slate-500">{{ $activity->created_at->format('H:i') }}</span>
                                </div>
                            </div>
                            <span class="px-4 py-1.5 rounded-xl bg-slate-100 text-slate-500 font-black text-[10px] uppercase tracking-tighter">Enregistré</span>
                        </div>
                    @empty
                        <div class="text-center py-20 bg-slate-50 rounded-[2rem] border-2 border-dashed border-slate-200">
                            <svg class="h-16 w-16 text-slate-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                            <p class="text-slate-400 font-bold">Aucune activité récente détectée.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
