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

                    <button type="button" @click="activeTab = 'export'"
                        :class="activeTab === 'export' ? 'bg-white text-indigo-600 shadow-sm ring-1 ring-slate-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'"
                        class="w-full flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 group">
                        <svg :class="activeTab === 'export' ? 'text-indigo-500' : 'text-slate-400 group-hover:text-slate-500'" 
                             class="flex-shrink-0 -ml-1 mr-3 h-5 w-5 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span class="truncate">Export de données</span>
                    </button>
                    
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



                <!-- SECTION: NOTIFICATIONS -->
                <div x-show="activeTab === 'notifications'" style="display: none;" class="space-y-8 animate-fade-in">
                    
                    <!-- Single Unified Notifications Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
                        <div class="mb-8">
                            <h2 class="text-xl font-bold text-slate-900">Préférences de Notifications</h2>
                            <p class="text-sm text-slate-500 mt-2">Choisissez comment vous souhaitez être informé des événements importants.</p>
                        </div>

                        <!-- Notification Channels Info -->
                        <div class="mb-8 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex items-start gap-3 p-4 bg-blue-50 rounded-lg border border-blue-100">
                                <svg class="h-5 w-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                <div>
                                    <h4 class="text-sm font-semibold text-blue-900">Email</h4>
                                    <p class="text-xs text-blue-700 mt-1">Notifications détaillées envoyées à votre boîte mail</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 p-4 bg-purple-50 rounded-lg border border-purple-100">
                                <svg class="h-5 w-5 text-purple-600 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                                <div>
                                    <h4 class="text-sm font-semibold text-purple-900">Push (In-App)</h4>
                                    <p class="text-xs text-purple-700 mt-1">Alertes instantanées dans l'application</p>
                                </div>
                            </div>
                        </div>

                        <!-- Commercial Events -->
                        <div class="mb-10">
                            <h3 class="text-base font-bold text-slate-900 mb-6 flex items-center gap-2">
                                <svg class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                Contacts & Leads
                            </h3>
                            
                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-4 rounded-xl border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50/30 transition-all group">
                                    <div class="flex items-center gap-3">
                                        <div class="h-2.5 w-2.5 rounded-full bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.4)]"></div>
                                        <span class="text-sm font-bold text-slate-700">Contact créé</span>
                                    </div>
                                    <div class="flex gap-8">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="notif_contact_created_email" class="sr-only peer" {{ ($notificationPreferences['contact_created']->email_enabled ?? true) ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                            <span class="ml-3 text-xs font-bold text-slate-500 uppercase tracking-tighter">Email</span>
                                        </label>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="notif_contact_created_push" class="sr-only peer" {{ ($notificationPreferences['contact_created']->push_enabled ?? true) ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                                            <span class="ml-3 text-xs font-bold text-slate-500 uppercase tracking-tighter">Push</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between p-4 rounded-xl border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50/30 transition-all group">
                                    <div class="flex items-center gap-3">
                                        <div class="h-2.5 w-2.5 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.4)]"></div>
                                        <span class="text-sm font-bold text-slate-700">Contact modifié</span>
                                    </div>
                                    <div class="flex gap-8">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="notif_contact_updated_email" class="sr-only peer" {{ ($notificationPreferences['contact_updated']->email_enabled ?? false) ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                            <span class="ml-3 text-xs font-bold text-slate-500 uppercase tracking-tighter">Email</span>
                                        </label>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="notif_contact_updated_push" class="sr-only peer" {{ ($notificationPreferences['contact_updated']->push_enabled ?? true) ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                                            <span class="ml-3 text-xs font-bold text-slate-500 uppercase tracking-tighter">Push</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between p-4 rounded-xl border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50/30 transition-all group">
                                    <div class="flex items-center gap-3">
                                        <div class="h-2.5 w-2.5 rounded-full bg-red-500 shadow-[0_0_8px_rgba(239,68,68,0.4)]"></div>
                                        <span class="text-sm font-bold text-slate-700">Contact supprimé</span>
                                    </div>
                                    <div class="flex gap-8">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="notif_contact_deleted_email" class="sr-only peer" {{ ($notificationPreferences['contact_deleted']->email_enabled ?? false) ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                            <span class="ml-3 text-xs font-bold text-slate-500 uppercase tracking-tighter">Email</span>
                                        </label>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="notif_contact_deleted_push" class="sr-only peer" {{ ($notificationPreferences['contact_deleted']->push_enabled ?? false) ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                                            <span class="ml-3 text-xs font-bold text-slate-500 uppercase tracking-tighter">Push</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-10 border-slate-200">

                        <!-- Opportunities -->
                        <div class="mb-10">
                            <h3 class="text-base font-bold text-slate-900 mb-6 flex items-center gap-2">
                                <svg class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                                Opportunités
                            </h3>
                            
                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-4 rounded-xl border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50/30 transition-all group">
                                    <div class="flex items-center gap-3">
                                        <div class="h-2.5 w-2.5 rounded-full bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.4)]"></div>
                                        <span class="text-sm font-bold text-slate-700">Opportunité créée</span>
                                    </div>
                                    <div class="flex gap-8">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="notif_opportunity_created_email" class="sr-only peer" {{ ($notificationPreferences['opportunity_created']->email_enabled ?? true) ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                            <span class="ml-3 text-xs font-bold text-slate-500 uppercase tracking-tighter">Email</span>
                                        </label>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="notif_opportunity_created_push" class="sr-only peer" {{ ($notificationPreferences['opportunity_created']->push_enabled ?? true) ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                                            <span class="ml-3 text-xs font-bold text-slate-500 uppercase tracking-tighter">Push</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between p-4 rounded-xl border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50/30 transition-all group">
                                    <div class="flex items-center gap-3">
                                        <div class="h-2.5 w-2.5 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.4)]"></div>
                                        <span class="text-sm font-bold text-slate-700">Opportunité modifiée</span>
                                    </div>
                                    <div class="flex gap-8">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="notif_opportunity_updated_email" class="sr-only peer" {{ ($notificationPreferences['opportunity_updated']->email_enabled ?? false) ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                            <span class="ml-3 text-xs font-bold text-slate-500 uppercase tracking-tighter">Email</span>
                                        </label>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="notif_opportunity_updated_push" class="sr-only peer" {{ ($notificationPreferences['opportunity_updated']->push_enabled ?? true) ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                                            <span class="ml-3 text-xs font-bold text-slate-500 uppercase tracking-tighter">Push</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between p-4 rounded-xl border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50/30 transition-all group">
                                    <div class="flex items-center gap-3">
                                        <div class="h-2.5 w-2.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.4)]"></div>
                                        <span class="text-sm font-bold text-slate-700">Opportunité gagnée</span>
                                    </div>
                                    <div class="flex gap-8">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="notif_opportunity_won_email" class="sr-only peer" {{ ($notificationPreferences['opportunity_won']->email_enabled ?? true) ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                            <span class="ml-3 text-xs font-bold text-slate-500 uppercase tracking-tighter">Email</span>
                                        </label>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="notif_opportunity_won_push" class="sr-only peer" {{ ($notificationPreferences['opportunity_won']->push_enabled ?? true) ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                                            <span class="ml-3 text-xs font-bold text-slate-500 uppercase tracking-tighter">Push</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between p-4 rounded-xl border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50/30 transition-all group">
                                    <div class="flex items-center gap-3">
                                        <div class="h-2.5 w-2.5 rounded-full bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.4)]"></div>
                                        <span class="text-sm font-bold text-slate-700">Opportunité perdue</span>
                                    </div>
                                    <div class="flex gap-8">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="notif_opportunity_lost_email" class="sr-only peer" {{ ($notificationPreferences['opportunity_lost']->email_enabled ?? false) ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                            <span class="ml-3 text-xs font-bold text-slate-500 uppercase tracking-tighter">Email</span>
                                        </label>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="notif_opportunity_lost_push" class="sr-only peer" {{ ($notificationPreferences['opportunity_lost']->push_enabled ?? true) ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                                            <span class="ml-3 text-xs font-bold text-slate-500 uppercase tracking-tighter">Push</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-10 border-slate-200">

                        <!-- Tasks & Activities -->
                        <div class="mb-10">
                            <h3 class="text-base font-bold text-slate-900 mb-6 flex items-center gap-2">
                                <svg class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                                Tâches & Activités
                            </h3>
                            
                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-4 rounded-xl border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50/30 transition-all group">
                                    <div class="flex items-center gap-3">
                                        <div class="h-2.5 w-2.5 rounded-full bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.4)]"></div>
                                        <span class="text-sm font-bold text-slate-700">Tâche créée</span>
                                    </div>
                                    <div class="flex gap-8">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="notif_task_created_email" class="sr-only peer" {{ ($notificationPreferences['task_created']->email_enabled ?? true) ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                            <span class="ml-3 text-xs font-bold text-slate-500 uppercase tracking-tighter">Email</span>
                                        </label>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="notif_task_created_push" class="sr-only peer" {{ ($notificationPreferences['task_created']->push_enabled ?? true) ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                                            <span class="ml-3 text-xs font-bold text-slate-500 uppercase tracking-tighter">Push</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between p-4 rounded-xl border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50/30 transition-all group">
                                    <div class="flex items-center gap-3">
                                        <div class="h-2.5 w-2.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.4)]"></div>
                                        <span class="text-sm font-bold text-slate-700">Tâche complétée</span>
                                    </div>
                                    <div class="flex gap-8">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="notif_task_completed_email" class="sr-only peer" {{ ($notificationPreferences['task_completed']->email_enabled ?? false) ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                            <span class="ml-3 text-xs font-bold text-slate-500 uppercase tracking-tighter">Email</span>
                                        </label>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="notif_task_completed_push" class="sr-only peer" {{ ($notificationPreferences['task_completed']->push_enabled ?? true) ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                                            <span class="ml-3 text-xs font-bold text-slate-500 uppercase tracking-tighter">Push</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between p-4 rounded-xl border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50/30 transition-all group">
                                    <div class="flex items-center gap-3">
                                        <div class="h-2.5 w-2.5 rounded-full bg-orange-500 shadow-[0_0_8px_rgba(249,115,22,0.4)]"></div>
                                        <span class="text-sm font-bold text-slate-700">Tâche en retard</span>
                                    </div>
                                    <div class="flex gap-8">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="notif_task_overdue_email" class="sr-only peer" {{ ($notificationPreferences['task_overdue']->email_enabled ?? true) ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                            <span class="ml-3 text-xs font-bold text-slate-500 uppercase tracking-tighter">Email</span>
                                        </label>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="notif_task_overdue_push" class="sr-only peer" {{ ($notificationPreferences['task_overdue']->push_enabled ?? true) ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                                            <span class="ml-3 text-xs font-bold text-slate-500 uppercase tracking-tighter">Push</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-10 border-slate-200">

                        <!-- System Events -->
                        <div>
                            <h3 class="text-base font-bold text-slate-900 mb-6 flex items-center gap-2">
                                <svg class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                Événements Système
                            </h3>
                            
                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-4 rounded-xl border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50/30 transition-all group">
                                    <div class="flex items-center gap-3">
                                        <div class="h-2.5 w-2.5 rounded-full bg-orange-500 shadow-[0_0_8px_rgba(249,115,22,0.4)]"></div>
                                        <span class="text-sm font-bold text-slate-700">Nouvel utilisateur créé</span>
                                    </div>
                                    <div class="flex gap-8">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="notif_user_created_email" class="sr-only peer" {{ ($notificationPreferences['user_created']->email_enabled ?? true) ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                            <span class="ml-3 text-xs font-bold text-slate-500 uppercase tracking-tighter">Email</span>
                                        </label>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="notif_user_created_push" class="sr-only peer" {{ ($notificationPreferences['user_created']->push_enabled ?? false) ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                                            <span class="ml-3 text-xs font-bold text-slate-500 uppercase tracking-tighter">Push</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between p-4 rounded-xl border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50/30 transition-all group">
                                    <div class="flex items-center gap-3">
                                        <div class="h-2.5 w-2.5 rounded-full bg-yellow-500 shadow-[0_0_8px_rgba(234,179,8,0.4)]"></div>
                                        <span class="text-sm font-bold text-slate-700">Erreur système critique</span>
                                    </div>
                                    <div class="flex gap-8">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="notif_error_email" class="sr-only peer" {{ ($notificationPreferences['error']->email_enabled ?? true) ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                            <span class="ml-3 text-xs font-bold text-slate-500 uppercase tracking-tighter">Email</span>
                                        </label>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="notif_error_push" class="sr-only peer" {{ ($notificationPreferences['error']->push_enabled ?? true) ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                                            <span class="ml-3 text-xs font-bold text-slate-500 uppercase tracking-tighter">Push</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- SECTION: EXPORT (CENTRE DE DONNÉES) -->
                <div x-show="activeTab === 'export'" style="display: none;" class="space-y-8 animate-fade-in" x-data="{ exportLoading: false, exportType: 'opportunities' }">
                    
                    <!-- Header Stats & Info -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-indigo-600 rounded-2xl p-6 text-white shadow-lg shadow-indigo-100 relative overflow-hidden group">
                            <div class="relative z-10">
                                <p class="text-indigo-100 text-xs font-bold uppercase tracking-widest mb-1">Dernier Export</p>
                                <h3 class="text-2xl font-black">{{ now()->subDays(1)->format('d M Y') }}</h3>
                                <p class="text-indigo-200 text-[10px] mt-2 flex items-center">
                                    <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/></svg>
                                    Archive disponible
                                </p>
                            </div>
                            <svg class="absolute -right-4 -bottom-4 h-24 w-24 text-indigo-500/30 transform transition-transform group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21l-8-8h16l-8 8zM12 3l8 8H4l8-8z"/></svg>
                        </div>
                        <div class="md:col-span-2 bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex items-center gap-6">
                            <div class="h-14 w-14 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 flex-shrink-0">
                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-900 leading-none mb-2">Sécurité & Gouvernance</h3>
                                <p class="text-xs text-slate-500 leading-relaxed">Conformément au <strong>RGPD</strong>, chaque extraction de données est tracée de manière inaltérable. Assurez-vous d'avoir l'autorisation nécessaire avant tout partage externe.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Main Export Form (Advanced) -->
                    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-200 overflow-hidden">
                        <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-black text-slate-900 tracking-tight">Extracteur Global de Données</h3>
                                <p class="text-xs text-slate-500 font-medium mt-0.5">Configurez vos filtres pour une précision maximale</p>
                            </div>
                            <div class="flex gap-2">
                                <span class="px-3 py-1 bg-white border border-slate-200 rounded-full text-[10px] font-bold text-slate-600 shadow-sm">NOUVEAU MOTEUR</span>
                            </div>
                        </div>
                        
                        <div class="p-8">
                            <form action="{{ route('reports.export') }}" method="GET" class="space-y-10" id="advanced-export-form">
                                <!-- Step 1: Data Type -->
                                <div>
                                    <h4 class="text-xs font-black text-indigo-600 uppercase tracking-widest mb-6 flex items-center">
                                        <span class="flex h-5 w-5 rounded-full bg-indigo-100 text-indigo-600 items-center justify-center mr-2 text-[10px]">1</span>
                                        Source de données
                                    </h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        <label class="relative cursor-pointer group">
                                            <input type="radio" name="type" value="opportunities" x-model="exportType" class="sr-only peer" checked>
                                            <div class="p-5 rounded-2xl border-2 border-slate-100 bg-white hover:bg-slate-50 peer-checked:border-indigo-600 peer-checked:bg-indigo-50/30 transition-all">
                                                <div class="h-10 w-10 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                                                </div>
                                                <p class="text-sm font-bold text-slate-900">Opportunités</p>
                                                <p class="text-[10px] text-slate-500 mt-1 uppercase tracking-tighter">Ventes & Pipeline</p>
                                            </div>
                                        </label>
                                        <label class="relative cursor-pointer group">
                                            <input type="radio" name="type" value="contacts" x-model="exportType" class="sr-only peer">
                                            <div class="p-5 rounded-2xl border-2 border-slate-100 bg-white hover:bg-slate-50 peer-checked:border-indigo-600 peer-checked:bg-indigo-50/30 transition-all">
                                                <div class="h-10 w-10 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                                </div>
                                                <p class="text-sm font-bold text-slate-900">Base Contacts</p>
                                                <p class="text-[10px] text-slate-500 mt-1 uppercase tracking-tighter">CRM Interne</p>
                                            </div>
                                        </label>
                                        <label class="relative cursor-pointer group">
                                            <input type="radio" name="type" value="leads" x-model="exportType" class="sr-only peer">
                                            <div class="p-5 rounded-2xl border-2 border-slate-100 bg-white hover:bg-slate-50 peer-checked:border-indigo-600 peer-checked:bg-indigo-50/30 transition-all">
                                                <div class="h-10 w-10 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                                                </div>
                                                <p class="text-sm font-bold text-slate-900">Prospects (Leads)</p>
                                                <p class="text-[10px] text-slate-500 mt-1 uppercase tracking-tighter">Nouveaux entrants</p>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Step 2: Advanced Filters -->
                                <div>
                                    <h4 class="text-xs font-black text-indigo-600 uppercase tracking-widest mb-6 flex items-center">
                                        <span class="flex h-5 w-5 rounded-full bg-indigo-100 text-indigo-600 items-center justify-center mr-2 text-[10px]">2</span>
                                        Filtres de segmentation
                                    </h4>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                        <div>
                                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Période (Depuis le)</label>
                                            <input type="date" name="date_from" class="block w-full rounded-xl border-slate-200 bg-slate-50/30 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3 transition-colors">
                                        </div>
                                        <div x-show="exportType === 'contacts' || exportType === 'leads'">
                                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Source Préférentielle</label>
                                            <select name="source" class="block w-full rounded-xl border-slate-200 bg-slate-50/30 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3 transition-colors">
                                                <option value="">Toutes les sources</option>
                                                <option value="LinkedIn">LinkedIn</option>
                                                <option value="Site Web">Site Web</option>
                                                <option value="Événement">Événement</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Propriétaire / Assigné</label>
                                            <select name="owner_id" class="block w-full rounded-xl border-slate-200 bg-slate-50/30 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 text-sm py-3 transition-colors">
                                                <option value="">Tout le monde</option>
                                                @foreach($users as $u)
                                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 3: Format & Action -->
                                <div class="bg-indigo-900 rounded-3xl p-8 text-white relative overflow-hidden flex flex-col items-center sm:flex-row sm:justify-between gap-6">
                                    <svg class="absolute left-0 bottom-0 h-full w-auto text-indigo-800 opacity-50" fill="currentColor" viewBox="0 0 200 200"><circle cx="0" cy="200" r="100"/></svg>
                                    <div class="relative z-10">
                                        <h4 class="text-xl font-black mb-1">Prêt pour l'extraction ?</h4>
                                        <p class="text-indigo-300 text-sm">Votre export sera prêt en quelques secondes.</p>
                                    </div>
                                    <div class="relative z-10 flex gap-4 w-full sm:w-auto">
                                        <button type="submit" name="format" value="csv" @click="exportLoading = true; setTimeout(() => exportLoading = false, 3000)" :disabled="exportLoading"
                                                class="flex-1 sm:flex-initial inline-flex items-center justify-center px-8 py-4 bg-white text-indigo-900 font-black rounded-2xl hover:bg-slate-100 transition-all shadow-xl shadow-indigo-950/20 disabled:opacity-50">
                                            <svg x-show="!exportLoading" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                            <svg x-show="exportLoading" class="animate-spin h-5 w-5 mr-3 text-indigo-900" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/></svg>
                                            GÉNÉRER CSV
                                        </button>
                                        <button type="button" @click="const q = new URLSearchParams(new FormData($el.closest('form'))).toString(); window.location.href='{{ route('reports.pdf') }}?' + q"
                                                class="flex-1 sm:flex-initial inline-flex items-center justify-center px-8 py-4 bg-indigo-500 text-white font-black rounded-2xl hover:bg-indigo-400 transition-all border border-indigo-400">
                                            VERSION PDF
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Lower Section: Backups & History -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        
                        <!-- Side: Quick Actions & Utilities -->
                        <div class="space-y-6">
                            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm">
                                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-6 border-l-4 border-indigo-600 pl-4">Système de Secours</h3>
                                <div class="space-y-4">
                                    <form action="{{ route('admin.backup.run') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center justify-between p-4 bg-slate-50 rounded-2xl hover:bg-indigo-50 hover:text-indigo-700 group transition-all">
                                            <div class="flex items-center gap-3">
                                                <div class="h-8 w-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center group-hover:bg-indigo-100 group-hover:border-indigo-200 transition-colors">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/></svg>
                                                </div>
                                                <div class="text-left">
                                                    <p class="text-[13px] font-bold">Snapshot Système (JSON)</p>
                                                    <p class="text-[10px] text-slate-400">Tout l'espace CRM</p>
                                                </div>
                                            </div>
                                            <svg class="h-4 w-4 opacity-0 group-hover:opacity-100 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                        </button>
                                    </form>

                                    <div class="pt-4 border-t border-slate-100" x-data="{ showGdpr: false }">
                                        <button type="button" @click="showGdpr = !showGdpr" class="w-full flex items-center justify-between p-4 bg-white border border-slate-200 rounded-2xl hover:border-amber-400 hover:bg-amber-50 group transition-all">
                                            <div class="flex items-center gap-3 text-amber-600">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A10.003 10.003 0 0012 3c1.288 0 2.515.243 3.645.686"/></svg>
                                                <p class="text-[13px] font-black uppercase tracking-tighter">Portabilité RGPD</p>
                                            </div>
                                            <svg :class="showGdpr ? 'rotate-90' : ''" class="h-4 w-4 text-slate-400 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        </button>
                                        <div x-show="showGdpr" class="mt-4 p-4 bg-amber-50 rounded-2xl border border-amber-100 animate-fade-in-down" style="display: none;">
                                            <form action="{{ route('admin.gdpr.export') }}" method="POST" class="space-y-3">
                                                @csrf
                                                <select name="user_id" required class="block w-full rounded-xl border-amber-200 bg-white focus:ring-amber-500 focus:border-amber-500 text-xs py-2.5">
                                                    <option value="">Cibler un utilisateur...</option>
                                                    @foreach($users as $u)
                                                        <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->role }})</option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="w-full py-2.5 bg-amber-600 text-white text-[11px] font-black rounded-xl hover:bg-amber-700 shadow-md transform active:scale-95 transition-all">
                                                    GÉNÉRER L'ARCHIVE PORTABLE
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Main: Export History -->
                        <div class="lg:col-span-2 space-y-6">
                            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden h-full">
                                <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                                    <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest flex items-center">
                                        <span class="h-2 w-2 rounded-full bg-emerald-500 mr-3 animate-pulse"></span>
                                        Activité récente des exports
                                    </h3>
                                    <button type="button" class="text-[11px] font-bold text-indigo-600 hover:underline uppercase tracking-widest">Voir tout l'audit</button>
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left">
                                        <thead>
                                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Type / Fichier</th>
                                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Format</th>
                                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Date / Heure</th>
                                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Statut</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            @foreach($recentExports as $exp)
                                            <tr class="hover:bg-slate-50 transition-colors cursor-default">
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center gap-3">
                                                        <div class="h-8 w-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500">
                                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-bold text-slate-700">
                                                                {{ $exp->new_values['type'] ?? $exp->translated_action }}
                                                            </p>
                                                            <p class="text-[10px] text-slate-400 font-medium">Par {{ $exp->user->name ?? 'Système' }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    @php $format = str_contains($exp->action, 'pdf') ? 'PDF' : (str_contains($exp->action, 'csv') ? 'CSV' : 'JSON'); @endphp
                                                    <span class="px-2 py-1 rounded text-[10px] font-black {{ $format === 'CSV' ? 'bg-emerald-100 text-emerald-700' : ($format === 'PDF' ? 'bg-indigo-100 text-indigo-700' : 'bg-slate-100 text-slate-700') }}">
                                                        {{ $format }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-xs font-medium text-slate-500 tracking-tighter">
                                                    {{ $exp->created_at->format('d/m/Y H:i') }}
                                                </div>
                                                <td class="px-6 py-4 text-right">
                                                    <span class="text-[10px] font-black uppercase tracking-widest text-green-500">
                                                        Complété
                                                    </span>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if($recentExports->isEmpty())
                                    <div class="p-12 text-center">
                                        <div class="inline-flex h-16 w-16 bg-slate-50 rounded-full items-center justify-center text-slate-300 mb-4">
                                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                        </div>
                                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Aucune donnée historique</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

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
