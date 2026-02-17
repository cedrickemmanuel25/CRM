@extends('layouts.app')

@section('title', 'Paramètres Généraux')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div>
                <h1 class="text-3xl font-black text-white tracking-tight uppercase">Paramètres de l'espace</h1>
                <p class="mt-2 text-sm text-slate-400 font-medium">Gérez la configuration globale de votre CRM, la sécurité et les préférences.</p>
            </div>
            <div>
                <button type="submit" form="settings-form" class="inline-flex items-center px-6 py-3 border border-transparent shadow-lg shadow-indigo-500/20 text-sm font-black uppercase tracking-wider rounded-xl text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-4 focus:ring-indigo-500/30 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                    <svg class="-ml-1 mr-2 h-5 w-5 animate-bounce-subtle" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Enregistrer les modifications
                </button>
            </div>
        </div>

        @if(session('success'))
        <div class="mb-6 rounded-2xl bg-emerald-500/10 p-4 border border-emerald-500/20 backdrop-blur-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-bold text-emerald-400">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        <form id="settings-form" action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" 
              x-data="{ activeTab: 'general' }" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            @csrf

            <!-- Sidebar Navigation (3 cols) -->
<!-- Sidebar Navigation (3 cols) -->
            <aside class="lg:col-span-3">
                <nav class="space-y-2 sticky top-8">
                    <button type="button" @click="activeTab = 'general'"
                        :class="activeTab === 'general' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'text-slate-400 hover:bg-white/5 hover:text-white'"
                        class="w-full flex items-center px-4 py-3 text-xs font-black uppercase tracking-widest rounded-xl transition-all duration-200 group">
                        <svg :class="activeTab === 'general' ? 'text-white' : 'text-slate-500 group-hover:text-slate-300'" 
                             class="flex-shrink-0 -ml-1 mr-3 h-5 w-5 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span class="truncate">Général</span>
                    </button>

                    <button type="button" @click="activeTab = 'notifications'"
                        :class="activeTab === 'notifications' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'text-slate-400 hover:bg-white/5 hover:text-white'"
                        class="w-full flex items-center px-4 py-3 text-xs font-black uppercase tracking-widest rounded-xl transition-all duration-200 group">
                        <svg :class="activeTab === 'notifications' ? 'text-white' : 'text-slate-500 group-hover:text-slate-300'" 
                             class="flex-shrink-0 -ml-1 mr-3 h-5 w-5 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="truncate">Notifications</span>
                    </button>

                    <button type="button" @click="activeTab = 'exports'"
                        :class="activeTab === 'exports' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'text-slate-400 hover:bg-white/5 hover:text-white'"
                        class="w-full flex items-center px-4 py-3 text-xs font-black uppercase tracking-widest rounded-xl transition-all duration-200 group">
                        <svg :class="activeTab === 'exports' ? 'text-white' : 'text-slate-500 group-hover:text-slate-300'" 
                             class="flex-shrink-0 -ml-1 mr-3 h-5 w-5 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span class="truncate">Exports & Rapports</span>
                    </button>

                    @if(auth()->user()->isAdmin())
                    <button type="button" @click="activeTab = 'maintenance'"
                        :class="activeTab === 'maintenance' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'text-slate-400 hover:bg-white/5 hover:text-white'"
                        class="w-full flex items-center px-4 py-3 text-xs font-black uppercase tracking-widest rounded-xl transition-all duration-200 group">
                        <svg :class="activeTab === 'maintenance' ? 'text-white' : 'text-slate-500 group-hover:text-slate-300'" 
                             class="flex-shrink-0 -ml-1 mr-3 h-5 w-5 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46" />
                        </svg>
                        <span class="truncate">Maintenance</span>
                    </button>
                    @endif
                </nav>
            </aside>

            <!-- Main Content Area (9 cols) -->
            <main class="lg:col-span-9 space-y-6">

                <!-- SECTION: GENERAL (Premium Profile Layout) -->
<!-- SECTION: GENERAL (Premium Profile Layout) -->
                <div x-show="activeTab === 'general'" class="space-y-8 animate-fade-in">
                    
                    <!-- Main Profile Card -->
                    <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 rounded-3xl p-8 shadow-2xl">
                        <!-- Header: Logo & Identity -->
                        <div class="flex flex-col md:flex-row gap-8 items-center" x-data="{ logoPreview: '{{ ($settings['company_logo'] ?? null) ? asset('storage/'.($settings['company_logo'] ?? '')) : '' }}' }">
                            <!-- Logo Avatar (Uploadable) -->
                            <div class="flex-shrink-0 relative group">
                                <div class="h-32 w-32 rounded-3xl bg-slate-800/50 border border-white/10 shadow-inner flex items-center justify-center overflow-hidden relative cursor-pointer ring-offset-2 hover:ring-2 hover:ring-indigo-500 transition-all duration-300">
                                    <!-- Placeholder Icon -->
                                    <div x-show="!logoPreview" class="flex flex-col items-center">
                                        <svg class="h-10 w-10 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="mt-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Logo</span>
                                    </div>
                                    
                                    <!-- Image Preview -->
                                    <img x-show="logoPreview" :src="logoPreview" class="h-full w-full object-contain p-2" alt="Logo Organization" style="display: none;">
                                    
                                    <!-- Overlay -->
                                    <div class="absolute inset-0 bg-indigo-600/0 group-hover:bg-indigo-600/20 transition-colors flex items-center justify-center">
                                        <input type="file" name="company_logo" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" 
                                               @change="const file = $event.target.files[0]; const reader = new FileReader(); reader.onload = (e) => { logoPreview = e.target.result }; reader.readAsDataURL(file)">
                                        <div class="opacity-0 group-hover:opacity-100 transition-opacity bg-slate-900/90 p-2 rounded-full shadow-lg border border-white/10">
                                            <svg class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Identity Fields -->
                            <div class="flex-1 w-full pt-2">
                                <div>
                                    <label class="block text-[10px] uppercase tracking-widest font-black text-slate-500 mb-2">Nom de l'organisation</label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors duration-200 group-focus-within:text-indigo-400 text-slate-600">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                        </div>
                                        <input type="text" name="company_name" value="{{ old('company_name', $settings['company_name'] ?? 'CRM Enterprise') }}" 
                                               class="block w-full rounded-2xl border border-white/10 bg-slate-900/50 text-white shadow-sm focus:border-indigo-500 focus:bg-slate-900 focus:ring-1 focus:ring-indigo-500 sm:text-lg sm:leading-8 font-black pl-14 pr-4 py-4 transition-all duration-200 placeholder-slate-600">
                                    </div>
                                    @error('company_name')<p class="mt-2 text-sm text-rose-500 font-bold">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-10 border-white/5">

                        <!-- Main Grid: Contact & Location -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-10">
                            
                            <!-- Column 1: Contact -->
                            <div class="space-y-6">
                                <h4 class="flex items-center text-xs font-black text-indigo-400 uppercase tracking-widest">
                                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                    COORDONNÉES DE CONTACT
                                </h4>
                                
                                <div class="space-y-5">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Email officiel</label>
                                        <div class="relative group">
                                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-600 group-focus-within:text-indigo-400 transition-colors">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                            </div>
                                            <input type="email" name="company_email" value="{{ old('company_email', $settings['company_email'] ?? '') }}" 
                                                   class="block w-full rounded-xl border border-white/10 bg-slate-900/50 py-3 pl-11 text-slate-200 shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 sm:text-sm transition-all focus:bg-slate-900 px-3 placeholder-slate-600">
                                        </div>
                                        @error('company_email')<p class="mt-1 text-xs text-rose-500 font-bold">{{ $message }}</p>@enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Site Internet</label>
                                        <div class="relative group">
                                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-600 group-focus-within:text-indigo-400 transition-colors">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" /></svg>
                                            </div>
                                            <div class="absolute inset-y-0 left-11 flex items-center pointer-events-none">
                                                <span class="text-slate-600 sm:text-sm font-medium">https://</span>
                                            </div>
                                            <input type="text" name="company_website" value="{{ old('company_website', $settings['company_website'] ?? '') }}" 
                                                   class="block w-full rounded-xl border border-white/10 bg-slate-900/50 py-3 pl-24 text-slate-200 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 sm:text-sm transition-all focus:bg-slate-900 px-3 placeholder-slate-600">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Téléphone Standard</label>
                                        <div class="relative group">
                                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-600 group-focus-within:text-indigo-400 transition-colors">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                            </div>
                                            <input type="tel" name="company_phone" value="{{ old('company_phone', $settings['company_phone'] ?? '') }}" 
                                                   class="block w-full rounded-xl border border-white/10 bg-slate-900/50 py-3 pl-11 text-slate-200 shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 sm:text-sm transition-all focus:bg-slate-900 px-3 placeholder-slate-600">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Column 2: Location -->
                            <div class="space-y-6">
                                <h4 class="flex items-center text-xs font-black text-indigo-400 uppercase tracking-widest">
                                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    SIÈGE SOCIAL
                                </h4>
                                
                                <div class="space-y-5">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Commune / Ville</label>
                                        <div class="relative group">
                                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-600 group-focus-within:text-indigo-400 transition-colors">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                            </div>
                                            <input type="text" name="company_city" value="{{ old('company_city', $settings['company_city'] ?? 'Abidjan') }}" 
                                                   class="block w-full rounded-xl border border-white/10 bg-slate-900/50 py-3 pl-11 text-slate-200 shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 sm:text-sm transition-all focus:bg-slate-900 px-3 placeholder-slate-600">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Quartier / Rue</label>
                                        <div class="relative group">
                                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-600 group-focus-within:text-indigo-400 transition-colors">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                            </div>
                                            <input type="text" name="company_address" value="{{ old('company_address', $settings['company_address'] ?? '') }}" 
                                                   class="block w-full rounded-xl border border-white/10 bg-slate-900/50 py-3 pl-11 text-slate-200 shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 sm:text-sm transition-all focus:bg-slate-900 px-3 placeholder-slate-600">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Boîte Postale</label>
                                        <div class="relative group">
                                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-600 group-focus-within:text-indigo-400 transition-colors">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" /></svg>
                                            </div>
                                            <input type="text" name="company_zip" value="{{ old('company_zip', $settings['company_zip'] ?? '') }}" 
                                                   class="block w-full rounded-xl border border-white/10 bg-slate-900/50 py-3 pl-11 text-slate-200 shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 sm:text-sm transition-all focus:bg-slate-900 px-3 placeholder-slate-600">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden System Settings -->
                    <input type="hidden" name="company_country" value="ci">
                    <input type="hidden" name="currency" value="XOF">
                    <input type="hidden" name="timezone" value="Africa/Abidjan">
                    <input type="hidden" name="default_locale" value="fr">
                    <input type="hidden" name="date_format" value="d/m/Y">
                </div>



<!-- SECTION: NOTIFICATIONS (CLEAN ENTERPRISE) -->
                <div x-show="activeTab === 'notifications'" style="display: none;" class="space-y-8 animate-fade-in">
                    
                    <!-- 1. PERSONAL PREFERENCES -->
                    <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 rounded-3xl overflow-hidden shadow-2xl">
                        <div class="px-8 py-6 border-b border-white/5 bg-white/[0.02]">
                            <h3 class="text-xl font-black text-white uppercase tracking-tight">Préférences Personnelles</h3>
                            <p class="text-sm text-slate-400 font-medium mt-1">Gérez la manière dont vous recevez vos notifications individuelles.</p>
                        </div>

                        <div class="divide-y divide-white/5">
                            @php
                                $sections = [
                                    'CRM' => [
                                        'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
                                        'color' => 'text-blue-400',
                                        'bg' => 'bg-blue-500/10 border-blue-500/20',
                                        'items' => ['contact_created', 'contact_updated']
                                    ],
                                    'Opportunités' => [
                                        'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                                        'color' => 'text-emerald-400',
                                        'bg' => 'bg-emerald-500/10 border-emerald-500/20',
                                        'items' => ['opportunity_created', 'opportunity_updated', 'opportunity_won', 'opportunity_lost']
                                    ],
                                    'Tâches' => [
                                        'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
                                        'color' => 'text-amber-400',
                                        'bg' => 'bg-amber-500/10 border-amber-500/20',
                                        'items' => ['task_created', 'task_completed', 'task_overdue']
                                    ],
                                    'Admin' => [
                                        'icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z',
                                        'color' => 'text-rose-400',
                                        'bg' => 'bg-rose-500/10 border-rose-500/20',
                                        'items' => ['performance_report', 'user_activity']
                                    ]
                                ];
                            @endphp

                            @foreach($sections as $sectionLabel => $data)
                            <div class="px-8 py-6 hover:bg-white/[0.02] transition-colors">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="h-8 w-8 rounded-lg {{ $data['bg'] }} border flex items-center justify-center">
                                        <svg class="h-5 w-5 {{ $data['color'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $data['icon'] }}" />
                                        </svg>
                                    </div>
                                    <h4 class="text-sm font-black text-white uppercase tracking-widest">{{ $sectionLabel }}</h4>
                                </div>
                                
                                <div class="space-y-4 ml-11">
                                    @foreach($data['items'] as $event)
                                    <div class="flex items-center justify-between group">
                                        <div class="max-w-md">
                                            <p class="text-sm font-bold text-slate-200">{{ $eventTypes[$event] ?? ucfirst(str_replace('_', ' ', $event)) }}</p>
                                            <p class="text-xs text-slate-500 mt-0.5 font-medium">Recevoir une alerte lors de cet événement.</p>
                                        </div>
                                        <div class="flex items-center gap-8">
                                            <!-- Email Column -->
                                            <div class="flex flex-col items-center gap-2 w-16">
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" name="personal_notif_{{$event}}_email" class="sr-only peer" {{ ($personalPreferences[$event]->email_enabled ?? true) ? 'checked' : '' }}>
                                                    <div class="w-11 h-6 bg-slate-800 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-500 border border-white/10"></div>
                                                </label>
                                                <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Email</span>
                                            </div>
                                            <!-- Push Column -->
                                            <div class="flex flex-col items-center gap-2 w-16">
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" name="personal_notif_{{$event}}_push" class="sr-only peer" {{ ($personalPreferences[$event]->push_enabled ?? true) ? 'checked' : '' }}>
                                                    <div class="w-11 h-6 bg-slate-800 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500 border border-white/10"></div>
                                                </label>
                                                <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Interne</span>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- 2. GLOBAL SYSTEM EVENTS -->
                    <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 rounded-3xl overflow-hidden shadow-2xl">
                        <div class="px-8 py-6 border-b border-white/5 bg-white/[0.02] flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="h-10 w-10 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center">
                                    <svg class="h-6 w-6 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-black text-white uppercase tracking-tight leading-none">Configuration Globale Système</h3>
                                    <p class="text-sm text-slate-400 font-medium mt-2">Définit les notifications système pour tous les administrateurs.</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 bg-amber-500/10 border border-amber-500/20 rounded-full text-[10px] font-black text-amber-500 uppercase tracking-widest">Admin Global</span>
                        </div>
                        
                        <div class="p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @php
                                    $systemEvents = [
                                        ['key' => 'user_created', 'label' => 'Nouvel utilisateur', 'desc' => 'Alerte lors de la création d\'un compte.'],
                                        ['key' => 'error', 'label' => 'Erreurs Critiques', 'desc' => 'Notifications sur les défaillances système.'],
                                        ['key' => 'task_overdue', 'label' => 'Retards (Global)', 'desc' => 'Suivi des tâches non réalisées.'],
                                        ['key' => 'opportunity_won', 'label' => 'Ventes Majeures', 'desc' => 'Résumé des succès commerciaux.'],
                                        ['key' => 'performance_report', 'label' => 'Rapport de Performance', 'desc' => 'Résumé périodique de l\'activité commerciale.'],
                                        ['key' => 'user_activity', 'label' => 'Sécurité / Activité', 'desc' => 'Alertes sur les actions sensibles.'],
                                    ];
                                @endphp

                                @foreach($systemEvents as $event)
                                <div class="flex items-center justify-between p-5 rounded-2xl border border-white/5 bg-slate-900/50 hover:bg-white/5 hover:border-white/10 transition-colors">
                                    <div class="max-w-[70%]">
                                        <p class="text-sm font-bold text-slate-200">{{ $event['label'] }}</p>
                                        <p class="text-[11px] text-slate-500 mt-1 font-medium">{{ $event['desc'] }}</p>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="notif_{{ $event['key'] }}_email" class="sr-only peer" {{ ($notificationPreferences[$event['key']]->email_enabled ?? true) ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-slate-800 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-amber-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500 border border-white/10"></div>
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>

                <!-- SECTION: EXPORTS (Integrated Professional Dashboard) -->
<!-- SECTION: EXPORTS (Integrated Professional Dashboard) -->
                <div x-show="activeTab === 'exports'" style="display: none;" class="space-y-8 animate-fade-in" x-data="{ exportType: 'opportunities', loading: false }">
                    <div class="bg-indigo-600 rounded-3xl p-8 text-white relative overflow-hidden mb-6 shadow-2xl shadow-indigo-900/20">
                        <div class="relative z-10">
                            <h2 class="text-2xl font-black uppercase tracking-tight mb-2">Centre d'Exports</h2>
                            <p class="text-indigo-100 text-sm font-medium">Générez des rapports et exportez vos données en toute sécurité.</p>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-600/50 to-purple-600/50 mix-blend-overlay"></div>
                        <svg class="absolute -right-6 -bottom-6 h-48 w-48 text-white/10 blur-2xl" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                    </div>

                    <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 rounded-3xl overflow-hidden shadow-2xl">
                        <div class="px-8 py-6 border-b border-white/5 bg-white/[0.02]">
                            <h3 class="text-lg font-black text-white uppercase tracking-tight">Configuration de l'Export</h3>
                        </div>
                        
                        <div class="p-8">
                            <!-- Use the route('reports.export') which handles the download -->
                            <div class="space-y-8">
                                <!-- 1. Type -->
                                <div>
                                    <h4 class="text-xs font-black text-slate-500 uppercase tracking-widest mb-4">1. Type de Données</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <label class="relative cursor-pointer group">
                                            <input type="radio" name="exportType" value="opportunities" x-model="exportType" class="sr-only peer" checked>
                                            <div class="p-5 rounded-2xl border border-white/10 bg-slate-900/50 hover:bg-white/5 hover:border-indigo-500/50 peer-checked:border-indigo-500 peer-checked:bg-indigo-500/10 transition-all shadow-sm group-hover:shadow-md">
                                                <span class="font-bold text-white block mb-1">Opportunités</span>
                                                <span class="text-xs text-slate-500 font-medium">Pipeline & Ventes</span>
                                            </div>
                                        </label>
                                        <label class="relative cursor-pointer group">
                                            <input type="radio" name="exportType" value="contacts" x-model="exportType" class="sr-only peer">
                                            <div class="p-5 rounded-2xl border border-white/10 bg-slate-900/50 hover:bg-white/5 hover:border-indigo-500/50 peer-checked:border-indigo-500 peer-checked:bg-indigo-500/10 transition-all shadow-sm group-hover:shadow-md">
                                                <span class="font-bold text-white block mb-1">Contacts</span>
                                                <span class="text-xs text-slate-500 font-medium">Clients & Prospects</span>
                                            </div>
                                        </label>
                                        <label class="relative cursor-pointer group">
                                            <input type="radio" name="exportType" value="leads" x-model="exportType" class="sr-only peer">
                                            <div class="p-5 rounded-2xl border border-white/10 bg-slate-900/50 hover:bg-white/5 hover:border-indigo-500/50 peer-checked:border-indigo-500 peer-checked:bg-indigo-500/10 transition-all shadow-sm group-hover:shadow-md">
                                                <span class="font-bold text-white block mb-1">Leads</span>
                                                <span class="text-xs text-slate-500 font-medium">Nouveaux Entrants</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Filters & Actions contained in a real form now -->
                                <!-- We need a form tailored to the export type. To simplify, we use one form with hidden input updated by x-model but standard HTML forms don't bind x-model to name. 
                                     So we use Alpine to bind the hidden input value. -->
                                <div class="bg-white/[0.02] p-6 rounded-2xl border border-white/5">
                                    <div class="flex flex-col sm:flex-row items-end gap-4">
                                        <div class="flex-1 w-full grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Période (Début)</label>
                                                <input type="date" name="date_from" form="export-form-real" class="block w-full rounded-xl border border-white/10 bg-slate-900/50 text-white text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Propriétaire</label>
                                                <select name="owner_id" form="export-form-real" class="block w-full rounded-xl border border-white/10 bg-slate-900/50 text-white text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                    <option value="" class="bg-slate-900">Tous</option>
                                                    @foreach($users as $u)
                                                    <option value="{{ $u->id }}" class="bg-slate-900">{{ $u->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="flex gap-3">
                                            <button type="submit" form="export-form-real" name="format" value="csv" class="px-6 py-2.5 bg-indigo-600 text-white font-bold text-xs uppercase tracking-wider rounded-xl hover:bg-indigo-500 shadow-lg shadow-indigo-500/20 active:scale-95 transition-all">
                                                Export CSV
                                            </button>
                                            <button type="button" @click="const q = new URLSearchParams(new FormData(document.getElementById('export-form-real'))).toString(); window.location.href='{{ route('reports.pdf') }}?' + q" class="px-6 py-2.5 bg-white/5 border border-white/10 text-white font-bold text-xs uppercase tracking-wider rounded-xl hover:bg-white/10 active:scale-95 transition-all">
                                                PDF
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- The Actual Form (Hidden logic) -->
                                <form id="export-form-real" action="{{ route('reports.export') }}" method="GET">
                                    <input type="hidden" name="type" :value="exportType">
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- History -->
                    <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 rounded-3xl overflow-hidden shadow-2xl">
                        <div class="px-8 py-6 border-b border-white/5 bg-white/[0.02]">
                            <h3 class="text-sm font-black text-white uppercase tracking-widest">Historique Récent</h3>
                        </div>
                        <ul class="divide-y divide-white/5">
                            @forelse($recentExports as $exp)
                            <li class="px-8 py-4 flex items-center justify-between hover:bg-white/[0.02] transition-colors">
                                <div>
                                    <p class="text-sm font-bold text-slate-200">Export {{ $exp->new_values['type'] ?? 'données' }} <span class="text-slate-500 text-xs font-medium ml-1">({{ str_contains($exp->action, 'pdf') ? 'PDF' : 'CSV' }})</span></p>
                                    <p class="text-[10px] text-slate-500 mt-0.5 uppercase tracking-wide font-bold">{{ $exp->created_at->diffForHumans() }} par {{ $exp->user->name ?? 'Système' }}</p>
                                </div>
                                <span class="h-2 w-2 rounded-full bg-emerald-500 shadow-lg shadow-emerald-500/50"></span>
                            </li>
                            @empty
                            <li class="px-8 py-4 text-center text-xs text-slate-500 font-medium">Aucun historique.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- SECTION: MAINTENANCE (Integrated) -->
                @if(auth()->user()->isAdmin())
                <div x-show="activeTab === 'maintenance'" style="display: none;" class="space-y-8 animate-fade-in">
                    
                    <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 rounded-3xl overflow-hidden shadow-2xl">
                        <div class="px-8 py-6 border-b border-white/5 bg-white/[0.02]">
                            <h3 class="text-lg font-black text-white uppercase tracking-tight">Sauvegarde du Système</h3>
                            <p class="mt-1 max-w-2xl text-sm text-slate-400 font-medium">Téléchargez une copie complète de la base de données (JSON).</p>
                        </div>
                        <div class="px-8 py-6">
                            <form action="{{ route('admin.backup.run') }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-6 py-3 border border-indigo-500/30 text-xs font-black uppercase tracking-wider rounded-xl text-indigo-300 bg-indigo-500/10 hover:bg-indigo-500/20 hover:text-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Lancer une sauvegarde complète
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 rounded-3xl overflow-hidden shadow-2xl">
                        <div class="px-8 py-6 border-b border-white/5 bg-white/[0.02]">
                            <h3 class="text-lg font-black text-white uppercase tracking-tight">Portabilité RGPD</h3>
                            <p class="mt-1 max-w-2xl text-sm text-slate-400 font-medium">Exportez toutes les données liées à un utilisateur spécifique.</p>
                        </div>
                        <div class="px-8 py-6">
                            <form action="{{ route('admin.gdpr.export') }}" method="POST" class="flex flex-col sm:flex-row gap-4 items-center">
                                @csrf
                                <select name="user_id" required class="block w-full sm:w-auto rounded-xl border-white/10 bg-slate-900/50 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-white">
                                    <option value="" class="bg-slate-900">Sélectionner un utilisateur</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" class="bg-slate-900">{{ $user->name }} ({{ $user->email }})</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="inline-flex items-center px-6 py-3 border border-white/10 text-xs font-black uppercase tracking-wider rounded-xl text-white bg-white/5 hover:bg-white/10 focus:outline-none transition-all">
                                    Exporter données (JSON)
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="bg-rose-900/10 backdrop-blur-xl border border-rose-500/10 rounded-3xl overflow-hidden shadow-2xl">
                         <div class="px-8 py-6 border-b border-rose-500/10 bg-rose-500/5">
                            <h3 class="text-lg font-black text-rose-500 uppercase tracking-tight">Zone de Danger</h3>
                            <p class="mt-1 max-w-2xl text-sm text-rose-400 font-medium">Suppression définitive des éléments dans la corbeille (Soft Deleted).</p>
                        </div>
                        <div class="px-8 py-6">
                            <form action="{{ route('admin.maintenance.cleanup') }}" method="POST" onsubmit="return confirm('Êtes-vous sûr ? C\'est irréversible.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent shadow-lg text-xs font-black uppercase tracking-wider rounded-xl text-white bg-rose-600 hover:bg-rose-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 transition-all">
                                    Vidanger la corbeille
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif


            </main>
        </form>
    </div>
</div>

<style>
    /* Custom Scrollbar for consistent premium feel if needed, otherwise browser default */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes bounce-subtle {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-2px); }
    }
    .animate-bounce-subtle {
        animation: bounce-subtle 2s infinite ease-in-out;
    }
    
    [x-cloak] { display: none !important; }
</style>
@endsection
