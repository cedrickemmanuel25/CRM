@extends('layouts.app')

@section('title', 'Paramètres Généraux')

@section('content')
<div class="min-h-screen bg-slate-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Paramètres de l'espace</h1>
                <p class="mt-1 text-sm text-slate-500">Gérez la configuration globale de votre CRM, la sécurité et les préférences.</p>
            </div>
            <div>
                <button type="submit" form="settings-form" class="inline-flex items-center px-6 py-3 border border-transparent shadow-lg text-sm font-extrabold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-500/30 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                    <svg class="-ml-1 mr-2 h-5 w-5 animate-bounce-subtle" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Enregistrer les modifications
                </button>
            </div>
        </div>

        @if(session('success'))
        <div class="mb-6 rounded-lg bg-green-50 p-4 border border-green-200">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        <form id="settings-form" action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" 
              x-data="{ activeTab: 'general' }" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            @csrf

            <!-- Sidebar Navigation (3 cols) -->
            <aside class="lg:col-span-3">
                <nav class="space-y-1 sticky top-8">
                    <button type="button" @click="activeTab = 'general'"
                        :class="activeTab === 'general' ? 'bg-white text-indigo-600 shadow-sm ring-1 ring-slate-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'"
                        class="w-full flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 group">
                        <svg :class="activeTab === 'general' ? 'text-indigo-500' : 'text-slate-400 group-hover:text-slate-500'" 
                             class="flex-shrink-0 -ml-1 mr-3 h-5 w-5 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span class="truncate">Général</span>
                    </button>



                    <button type="button" @click="activeTab = 'notifications'"
                        :class="activeTab === 'notifications' ? 'bg-white text-indigo-600 shadow-sm ring-1 ring-slate-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'"
                        class="w-full flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 group">
                        <svg :class="activeTab === 'notifications' ? 'text-indigo-500' : 'text-slate-400 group-hover:text-slate-500'" 
                             class="flex-shrink-0 -ml-1 mr-3 h-5 w-5 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="truncate">Notifications</span>
                    </button>

                    <button type="button" @click="activeTab = 'exports'"
                        :class="activeTab === 'exports' ? 'bg-white text-indigo-600 shadow-sm ring-1 ring-slate-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'"
                        class="w-full flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 group">
                        <svg :class="activeTab === 'exports' ? 'text-indigo-500' : 'text-slate-400 group-hover:text-slate-500'" 
                             class="flex-shrink-0 -ml-1 mr-3 h-5 w-5 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span class="truncate">Exports & Rapports</span>
                    </button>

                    @if(auth()->user()->isAdmin())
                    <button type="button" @click="activeTab = 'maintenance'"
                        :class="activeTab === 'maintenance' ? 'bg-white text-indigo-600 shadow-sm ring-1 ring-slate-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'"
                        class="w-full flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 group">
                        <svg :class="activeTab === 'maintenance' ? 'text-indigo-500' : 'text-slate-400 group-hover:text-slate-500'" 
                             class="flex-shrink-0 -ml-1 mr-3 h-5 w-5 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46" />
                        </svg>
                        <span class="truncate">Maintenance</span>
                    </button>
                    @endif


                    
                    <!-- Save button moved to header -->
                </nav>
            </aside>

            <!-- Main Content Area (9 cols) -->
            <main class="lg:col-span-9 space-y-6">

                <!-- SECTION: GENERAL (Premium Profile Layout) -->
                <div x-show="activeTab === 'general'" class="space-y-8 animate-fade-in">
                    
                    <!-- Main Profile Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
                        <!-- Header: Logo & Identity -->
                        <div class="flex flex-col md:flex-row gap-8 items-center" x-data="{ logoPreview: '{{ ($settings['company_logo'] ?? null) ? asset('storage/'.($settings['company_logo'] ?? '')) : '' }}' }">
                            <!-- Logo Avatar (Uploadable) -->
                            <div class="flex-shrink-0 relative group">
                                <div class="h-32 w-32 rounded-3xl bg-slate-50 border-2 border-slate-200 shadow-sm flex items-center justify-center overflow-hidden relative cursor-pointer ring-offset-2 hover:ring-2 hover:ring-indigo-500 transition-all duration-300">
                                    <!-- Placeholder Icon -->
                                    <div x-show="!logoPreview" class="flex flex-col items-center">
                                        <svg class="h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="mt-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Logo</span>
                                    </div>
                                    
                                    <!-- Image Preview -->
                                    <img x-show="logoPreview" :src="logoPreview" class="h-full w-full object-contain p-2" alt="Logo Organization" style="display: none;">
                                    
                                    <!-- Overlay -->
                                    <div class="absolute inset-0 bg-indigo-600/0 group-hover:bg-indigo-600/10 transition-colors flex items-center justify-center">
                                        <input type="file" name="company_logo" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" 
                                               @change="const file = $event.target.files[0]; const reader = new FileReader(); reader.onload = (e) => { logoPreview = e.target.result }; reader.readAsDataURL(file)">
                                        <div class="opacity-0 group-hover:opacity-100 transition-opacity bg-white/90 p-1.5 rounded-full shadow-lg">
                                            <svg class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Identity Fields -->
                            <div class="flex-1 w-full pt-2">
                                <div>
                                    <label class="block text-xs uppercase tracking-wider font-bold text-slate-500 mb-2">Nom de l'organisation</label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors duration-200 group-focus-within:text-indigo-600 text-slate-400">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                        </div>
                                        <input type="text" name="company_name" value="{{ old('company_name', $settings['company_name'] ?? 'CRM Enterprise') }}" 
                                               class="block w-full rounded-xl border-0 bg-slate-50 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-200 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-lg sm:leading-8 font-extrabold pl-14 pr-4 py-4 transition-all duration-200">
                                    </div>
                                    @error('company_name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-10 border-slate-100">

                        <!-- Main Grid: Contact & Location -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-10">
                            
                            <!-- Column 1: Contact -->
                            <div class="space-y-6">
                                <h4 class="flex items-center text-sm font-bold text-indigo-600">
                                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                    COORDONNÉES DE CONTACT
                                </h4>
                                
                                <div class="space-y-5">
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Email officiel</label>
                                        <div class="relative group">
                                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                            </div>
                                            <input type="email" name="company_email" value="{{ old('company_email', $settings['company_email'] ?? '') }}" 
                                                   class="block w-full rounded-lg border-0 py-3 pl-11 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-200 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm transition-all bg-white hover:bg-slate-50 focus:bg-white px-3">
                                        </div>
                                        @error('company_email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Site Internet</label>
                                        <div class="relative group">
                                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" /></svg>
                                            </div>
                                            <div class="absolute inset-y-0 left-11 flex items-center pointer-events-none">
                                                <span class="text-slate-400 sm:text-sm">https://</span>
                                            </div>
                                            <input type="text" name="company_website" value="{{ old('company_website', $settings['company_website'] ?? '') }}" 
                                                   class="block w-full rounded-lg border-0 py-3 pl-24 text-slate-900 ring-1 ring-inset ring-slate-200 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm transition-all bg-white hover:bg-slate-50 focus:bg-white px-3">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Téléphone Standard</label>
                                        <div class="relative group">
                                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                            </div>
                                            <input type="tel" name="company_phone" value="{{ old('company_phone', $settings['company_phone'] ?? '') }}" 
                                                   class="block w-full rounded-lg border-0 py-3 pl-11 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-200 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm transition-all bg-white hover:bg-slate-50 focus:bg-white px-3">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Column 2: Location -->
                            <div class="space-y-6">
                                <h4 class="flex items-center text-sm font-bold text-indigo-600">
                                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    SIÈGE SOCIAL
                                </h4>
                                
                                <div class="space-y-5">
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Commune / Ville</label>
                                        <div class="relative group">
                                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                            </div>
                                            <input type="text" name="company_city" value="{{ old('company_city', $settings['company_city'] ?? 'Abidjan') }}" 
                                                   class="block w-full rounded-lg border-0 py-3 pl-11 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-200 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm transition-all bg-white hover:bg-slate-50 focus:bg-white px-3">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Quartier / Rue</label>
                                        <div class="relative group">
                                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                            </div>
                                            <input type="text" name="company_address" value="{{ old('company_address', $settings['company_address'] ?? '') }}" 
                                                   class="block w-full rounded-lg border-0 py-3 pl-11 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-200 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm transition-all bg-white hover:bg-slate-50 focus:bg-white px-3">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Boîte Postale</label>
                                        <div class="relative group">
                                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" /></svg>
                                            </div>
                                            <input type="text" name="company_zip" value="{{ old('company_zip', $settings['company_zip'] ?? '') }}" 
                                                   class="block w-full rounded-lg border-0 py-3 pl-11 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-200 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm transition-all bg-white hover:bg-slate-50 focus:bg-white px-3">
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
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50">
                            <h3 class="text-lg font-bold text-slate-900">Préférences Personnelles</h3>
                            <p class="text-sm text-slate-500 mt-1">Gérez la manière dont vous recevez vos notifications individuelles.</p>
                        </div>

                        <div class="divide-y divide-slate-100">
                            @php
                                $sections = [
                                    'CRM' => ['contact_created', 'contact_updated'],
                                    'Opportunités' => ['opportunity_created', 'opportunity_updated', 'opportunity_won', 'opportunity_lost'],
                                    'Tâches' => ['task_created', 'task_completed', 'task_overdue']
                                ];
                            @endphp

                            @foreach($sections as $sectionLabel => $events)
                            <div class="px-8 py-6 bg-slate-50/30">
                                <h4 class="text-xs font-bold text-indigo-600 uppercase tracking-widest mb-4">{{ $sectionLabel }}</h4>
                                <div class="space-y-4">
                                    @foreach($events as $event)
                                    <div class="flex items-center justify-between group">
                                        <div class="max-w-md">
                                            <p class="text-sm font-semibold text-slate-800">{{ $eventTypes[$event] ?? ucfirst(str_replace('_', ' ', $event)) }}</p>
                                            <p class="text-xs text-slate-500 mt-0.5">Recevoir une alerte lors de cet événement.</p>
                                        </div>
                                        <div class="flex items-center gap-8">
                                            <!-- Email Column -->
                                            <div class="flex flex-col items-center gap-1.5 w-16">
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" name="personal_notif_{{$event}}_email" class="sr-only peer" {{ ($personalPreferences[$event]->email_enabled ?? true) ? 'checked' : '' }}>
                                                    <div class="w-10 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-indigo-600"></div>
                                                </label>
                                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">Email</span>
                                            </div>
                                            <!-- Push Column -->
                                            <div class="flex flex-col items-center gap-1.5 w-16">
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" name="personal_notif_{{$event}}_push" class="sr-only peer" {{ ($personalPreferences[$event]->push_enabled ?? true) ? 'checked' : '' }}>
                                                    <div class="w-10 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-indigo-600"></div>
                                                </label>
                                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">Push</span>
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
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 leading-none">Configuration Globale Système</h3>
                                <p class="text-sm text-slate-500 mt-2">Définit les notifications système pour tous les administrateurs.</p>
                            </div>
                            <span class="px-3 py-1 bg-amber-50 border border-amber-200 rounded-full text-[10px] font-bold text-amber-700 uppercase tracking-widest">Admin Global</span>
                        </div>
                        
                        <div class="p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                @php
                                    $systemEvents = [
                                        ['key' => 'user_created', 'label' => 'Nouvel utilisateur', 'desc' => 'Alerte lors de la création d\'un compte.'],
                                        ['key' => 'error', 'label' => 'Erreurs Critiques', 'desc' => 'Notifications sur les défaillances système.'],
                                        ['key' => 'task_overdue', 'label' => 'Retards (Global)', 'desc' => 'Suivi des tâches non réalisées.'],
                                        ['key' => 'opportunity_won', 'label' => 'Ventes Majeures', 'desc' => 'Résumé des succès commerciaux.'],
                                    ];
                                @endphp

                                @foreach($systemEvents as $event)
                                <div class="flex items-center justify-between p-5 rounded-xl border border-slate-100 hover:border-slate-200 transition-colors">
                                    <div class="max-w-[70%]">
                                        <p class="text-sm font-bold text-slate-800">{{ $event['label'] }}</p>
                                        <p class="text-[11px] text-slate-500 mt-1">{{ $event['desc'] }}</p>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="notif_{{ $event['key'] }}_email" class="sr-only peer" {{ ($notificationPreferences[$event['key']]->email_enabled ?? true) ? 'checked' : '' }}>
                                            <div class="w-10 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-amber-500"></div>
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>

                <!-- SECTION: EXPORTS (Integrated Professional Dashboard) -->
                <div x-show="activeTab === 'exports'" style="display: none;" class="space-y-8 animate-fade-in" x-data="{ exportType: 'opportunities', loading: false }">
                    <div class="bg-indigo-900 rounded-2xl p-6 text-white relative overflow-hidden mb-6">
                        <div class="relative z-10">
                            <h2 class="text-xl font-bold mb-2">Centre d'Exports</h2>
                            <p class="text-indigo-200 text-sm">Générez des rapports et exportez vos données en toute sécurité.</p>
                        </div>
                        <svg class="absolute -right-6 -bottom-6 h-32 w-32 text-indigo-800 blur-sm opacity-50" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50">
                            <h3 class="text-lg font-bold text-slate-900">Configuration de l'Export</h3>
                        </div>
                        
                        <div class="p-8">
                            <!-- Use the route('reports.export') which handles the download -->
                            <div class="space-y-8">
                                <!-- 1. Type -->
                                <div>
                                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">1. Type de Données</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <label class="relative cursor-pointer group">
                                            <input type="radio" name="exportType" value="opportunities" x-model="exportType" class="sr-only peer" checked>
                                            <div class="p-4 rounded-xl border border-slate-200 bg-white hover:border-indigo-300 peer-checked:border-indigo-600 peer-checked:bg-indigo-50/50 transition-all shadow-sm">
                                                <span class="font-bold text-slate-900 block mb-1">Opportunités</span>
                                                <span class="text-xs text-slate-500">Pipeline & Ventes</span>
                                            </div>
                                        </label>
                                        <label class="relative cursor-pointer group">
                                            <input type="radio" name="exportType" value="contacts" x-model="exportType" class="sr-only peer">
                                            <div class="p-4 rounded-xl border border-slate-200 bg-white hover:border-indigo-300 peer-checked:border-indigo-600 peer-checked:bg-indigo-50/50 transition-all shadow-sm">
                                                <span class="font-bold text-slate-900 block mb-1">Contacts</span>
                                                <span class="text-xs text-slate-500">Clients & Prospects</span>
                                            </div>
                                        </label>
                                        <label class="relative cursor-pointer group">
                                            <input type="radio" name="exportType" value="leads" x-model="exportType" class="sr-only peer">
                                            <div class="p-4 rounded-xl border border-slate-200 bg-white hover:border-indigo-300 peer-checked:border-indigo-600 peer-checked:bg-indigo-50/50 transition-all shadow-sm">
                                                <span class="font-bold text-slate-900 block mb-1">Leads</span>
                                                <span class="text-xs text-slate-500">Nouveaux Entrants</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Filters & Actions contained in a real form now -->
                                <!-- We need a form tailored to the export type. To simplify, we use one form with hidden input updated by x-model but standard HTML forms don't bind x-model to name. 
                                     So we use Alpine to bind the hidden input value. -->
                                <div class="bg-slate-50 p-6 rounded-xl border border-slate-200">
                                    <div class="flex flex-col sm:flex-row items-end gap-4">
                                        <div class="flex-1 w-full grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-medium text-slate-700 mb-1">Période (Début)</label>
                                                <input type="date" name="date_from" form="export-form-real" class="block w-full rounded-lg border-slate-200 text-sm">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-slate-700 mb-1">Propriétaire</label>
                                                <select name="owner_id" form="export-form-real" class="block w-full rounded-lg border-slate-200 text-sm">
                                                    <option value="">Tous</option>
                                                    @foreach($users as $u)
                                                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="flex gap-2">
                                            <button type="submit" form="export-form-real" name="format" value="csv" class="px-6 py-2.5 bg-indigo-600 text-white font-bold text-sm rounded-lg hover:bg-indigo-700 shadow-sm">
                                                Export CSV
                                            </button>
                                            <button type="button" @click="const q = new URLSearchParams(new FormData(document.getElementById('export-form-real'))).toString(); window.location.href='{{ route('reports.pdf') }}?' + q" class="px-6 py-2.5 bg-white border border-slate-300 text-slate-700 font-bold text-sm rounded-lg hover:bg-slate-50 shadow-sm">
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
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide">Historique Récent</h3>
                        </div>
                        <ul class="divide-y divide-slate-100">
                            @forelse($recentExports as $exp)
                            <li class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                                <div>
                                    <p class="text-sm font-medium text-slate-800">Export {{ $exp->new_values['type'] ?? 'données' }} <span class="text-slate-400 text-xs">({{ str_contains($exp->action, 'pdf') ? 'PDF' : 'CSV' }})</span></p>
                                    <p class="text-xs text-slate-500">{{ $exp->created_at->diffForHumans() }} par {{ $exp->user->name ?? 'Système' }}</p>
                                </div>
                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                            </li>
                            @empty
                            <li class="px-6 py-4 text-center text-xs text-slate-400">Aucun historique.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- SECTION: MAINTENANCE (Integrated) -->
                @if(auth()->user()->isAdmin())
                <div x-show="activeTab === 'maintenance'" style="display: none;" class="space-y-8 animate-fade-in">
                    
                    <div class="bg-white shadow-sm border border-slate-200 rounded-2xl overflow-hidden">
                        <div class="px-6 py-5 border-b border-slate-200 bg-slate-50">
                            <h3 class="text-lg leading-6 font-medium text-slate-900">Sauvegarde du Système</h3>
                            <p class="mt-1 max-w-2xl text-sm text-slate-500">Téléchargez une copie complète de la base de données (JSON).</p>
                        </div>
                        <div class="px-6 py-5">
                            <form action="{{ route('admin.backup.run') }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Lancer une sauvegarde complète
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="bg-white shadow-sm border border-slate-200 rounded-2xl overflow-hidden">
                        <div class="px-6 py-5 border-b border-slate-200 bg-slate-50">
                            <h3 class="text-lg leading-6 font-medium text-slate-900">Portabilité RGPD</h3>
                            <p class="mt-1 max-w-2xl text-sm text-slate-500">Exportez toutes les données liées à un utilisateur spécifique.</p>
                        </div>
                        <div class="px-6 py-5">
                            <form action="{{ route('admin.gdpr.export') }}" method="POST" class="flex flex-col sm:flex-row gap-4 items-center">
                                @csrf
                                <select name="user_id" required class="block w-full sm:w-auto rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">Sélectionner un utilisateur</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                                    Exporter données (JSON)
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="bg-red-50 shadow-sm border border-red-100 rounded-2xl overflow-hidden">
                         <div class="px-6 py-5 border-b border-red-200 bg-red-100/50">
                            <h3 class="text-lg leading-6 font-medium text-red-800">Zone de Danger</h3>
                            <p class="mt-1 max-w-2xl text-sm text-red-600">Suppression définitive des éléments dans la corbeille (Soft Deleted).</p>
                        </div>
                        <div class="px-6 py-5">
                            <form action="{{ route('admin.maintenance.cleanup') }}" method="POST" onsubmit="return confirm('Êtes-vous sûr ? C\'est irréversible.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
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
