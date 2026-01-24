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
                <button type="submit" form="settings-form" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-bold rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                                <div class="h-32 w-32 rounded-full bg-slate-50 border-4 border-white shadow-md flex items-center justify-center overflow-hidden relative cursor-pointer">
                                    <!-- Placeholder Icon -->
                                    <svg x-show="!logoPreview" class="h-12 w-12 text-slate-300" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                    
                                    <!-- Image Preview -->
                                    <img x-show="logoPreview" :src="logoPreview" class="h-full w-full object-cover" alt="Logo Organization" style="display: none;">
                                    
                                    <!-- Overlay -->
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition-colors flex items-center justify-center">
                                        <input type="file" name="company_logo" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" 
                                               @change="const file = $event.target.files[0]; const reader = new FileReader(); reader.onload = (e) => { logoPreview = e.target.result }; reader.readAsDataURL(file)">
                                    </div>
                                </div>
                            </div>

                            <!-- Identity Fields -->
                            <div class="flex-1 w-full pt-2">
                                <div>
                                    <label class="block text-xs uppercase tracking-wider font-bold text-slate-500 mb-2">Nom de l'organisation</label>
                                    <input type="text" name="company_name" value="{{ $settings['company_name'] ?? 'CRM Enterprise' }}" class="block w-full rounded-lg border-0 bg-slate-50 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-200 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-lg sm:leading-8 font-semibold px-4 py-3">
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
                                        <input type="email" name="company_email" value="{{ $settings['company_email'] ?? '' }}" class="block w-full rounded-md border-0 py-2.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-200 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 px-3">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Site Internet</label>
                                        <div class="relative rounded-md shadow-sm">
                                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                                <span class="text-slate-500 sm:text-sm">https://</span>
                                            </div>
                                            <input type="text" name="company_website" value="{{ $settings['company_website'] ?? '' }}" class="block w-full rounded-md border-0 py-2.5 pl-16 text-slate-900 ring-1 ring-inset ring-slate-200 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Téléphone Standard</label>
                                        <input type="tel" name="company_phone" value="{{ $settings['company_phone'] ?? '' }}" class="block w-full rounded-md border-0 py-2.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-200 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 px-3">
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
                                        <input type="text" name="company_city" value="{{ $settings['company_city'] ?? 'Abidjan' }}" class="block w-full rounded-md border-0 py-2.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-200 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 px-3">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Quartier / Rue</label>
                                        <input type="text" name="company_address" value="{{ $settings['company_address'] ?? '' }}" class="block w-full rounded-md border-0 py-2.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-200 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 px-3">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Boîte Postale</label>
                                        <input type="text" name="company_zip" value="{{ $settings['company_zip'] ?? '' }}" class="block w-full rounded-md border-0 py-2.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-200 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 px-3">
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
                                <div class="flex items-center justify-between p-4 rounded-lg border border-slate-200 hover:bg-slate-50 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="h-2 w-2 rounded-full bg-green-500"></div>
                                        <span class="text-sm font-medium text-slate-700">Contact créé</span>
                                    </div>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="notif_contact_created_email" class="rounded text-blue-600 focus:ring-blue-500 border-slate-300" {{ ($notificationPreferences['contact_created']->email_enabled ?? true) ? 'checked' : '' }}>
                                            <span class="text-sm text-slate-600">Email</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="notif_contact_created_push" class="rounded text-purple-600 focus:ring-purple-500 border-slate-300" {{ ($notificationPreferences['contact_created']->push_enabled ?? true) ? 'checked' : '' }}>
                                            <span class="text-sm text-slate-600">Push</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between p-4 rounded-lg border border-slate-200 hover:bg-slate-50 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="h-2 w-2 rounded-full bg-blue-500"></div>
                                        <span class="text-sm font-medium text-slate-700">Contact modifié</span>
                                    </div>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="notif_contact_updated_email" class="rounded text-blue-600 focus:ring-blue-500 border-slate-300" {{ ($notificationPreferences['contact_updated']->email_enabled ?? false) ? 'checked' : '' }}>
                                            <span class="text-sm text-slate-600">Email</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="notif_contact_updated_push" class="rounded text-purple-600 focus:ring-purple-500 border-slate-300" {{ ($notificationPreferences['contact_updated']->push_enabled ?? true) ? 'checked' : '' }}>
                                            <span class="text-sm text-slate-600">Push</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between p-4 rounded-lg border border-slate-200 hover:bg-slate-50 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="h-2 w-2 rounded-full bg-red-500"></div>
                                        <span class="text-sm font-medium text-slate-700">Contact supprimé</span>
                                    </div>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="notif_contact_deleted_email" class="rounded text-blue-600 focus:ring-blue-500 border-slate-300" {{ ($notificationPreferences['contact_deleted']->email_enabled ?? false) ? 'checked' : '' }}>
                                            <span class="text-sm text-slate-600">Email</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="notif_contact_deleted_push" class="rounded text-purple-600 focus:ring-purple-500 border-slate-300" {{ ($notificationPreferences['contact_deleted']->push_enabled ?? false) ? 'checked' : '' }}>
                                            <span class="text-sm text-slate-600">Push</span>
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
                                <div class="flex items-center justify-between p-4 rounded-lg border border-slate-200 hover:bg-slate-50 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="h-2 w-2 rounded-full bg-green-500"></div>
                                        <span class="text-sm font-medium text-slate-700">Opportunité créée</span>
                                    </div>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="notif_opportunity_created_email" class="rounded text-blue-600 focus:ring-blue-500 border-slate-300" {{ ($notificationPreferences['opportunity_created']->email_enabled ?? true) ? 'checked' : '' }}>
                                            <span class="text-sm text-slate-600">Email</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="notif_opportunity_created_push" class="rounded text-purple-600 focus:ring-purple-500 border-slate-300" {{ ($notificationPreferences['opportunity_created']->push_enabled ?? true) ? 'checked' : '' }}>
                                            <span class="text-sm text-slate-600">Push</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between p-4 rounded-lg border border-slate-200 hover:bg-slate-50 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="h-2 w-2 rounded-full bg-blue-500"></div>
                                        <span class="text-sm font-medium text-slate-700">Opportunité modifiée</span>
                                    </div>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="notif_opportunity_updated_email" class="rounded text-blue-600 focus:ring-blue-500 border-slate-300" {{ ($notificationPreferences['opportunity_updated']->email_enabled ?? false) ? 'checked' : '' }}>
                                            <span class="text-sm text-slate-600">Email</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="notif_opportunity_updated_push" class="rounded text-purple-600 focus:ring-purple-500 border-slate-300" {{ ($notificationPreferences['opportunity_updated']->push_enabled ?? true) ? 'checked' : '' }}>
                                            <span class="text-sm text-slate-600">Push</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between p-4 rounded-lg border border-slate-200 hover:bg-slate-50 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="h-2 w-2 rounded-full bg-emerald-500"></div>
                                        <span class="text-sm font-medium text-slate-700">Opportunité gagnée</span>
                                    </div>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="notif_opportunity_won_email" class="rounded text-blue-600 focus:ring-blue-500 border-slate-300" {{ ($notificationPreferences['opportunity_won']->email_enabled ?? true) ? 'checked' : '' }}>
                                            <span class="text-sm text-slate-600">Email</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="notif_opportunity_won_push" class="rounded text-purple-600 focus:ring-purple-500 border-slate-300" {{ ($notificationPreferences['opportunity_won']->push_enabled ?? true) ? 'checked' : '' }}>
                                            <span class="text-sm text-slate-600">Push</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between p-4 rounded-lg border border-slate-200 hover:bg-slate-50 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="h-2 w-2 rounded-full bg-amber-500"></div>
                                        <span class="text-sm font-medium text-slate-700">Opportunité perdue</span>
                                    </div>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="notif_opportunity_lost_email" class="rounded text-blue-600 focus:ring-blue-500 border-slate-300" {{ ($notificationPreferences['opportunity_lost']->email_enabled ?? false) ? 'checked' : '' }}>
                                            <span class="text-sm text-slate-600">Email</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="notif_opportunity_lost_push" class="rounded text-purple-600 focus:ring-purple-500 border-slate-300" {{ ($notificationPreferences['opportunity_lost']->push_enabled ?? true) ? 'checked' : '' }}>
                                            <span class="text-sm text-slate-600">Push</span>
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
                                <div class="flex items-center justify-between p-4 rounded-lg border border-slate-200 hover:bg-slate-50 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="h-2 w-2 rounded-full bg-green-500"></div>
                                        <span class="text-sm font-medium text-slate-700">Tâche créée</span>
                                    </div>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="notif_task_created_email" class="rounded text-blue-600 focus:ring-blue-500 border-slate-300" {{ ($notificationPreferences['task_created']->email_enabled ?? true) ? 'checked' : '' }}>
                                            <span class="text-sm text-slate-600">Email</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="notif_task_created_push" class="rounded text-purple-600 focus:ring-purple-500 border-slate-300" {{ ($notificationPreferences['task_created']->push_enabled ?? true) ? 'checked' : '' }}>
                                            <span class="text-sm text-slate-600">Push</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between p-4 rounded-lg border border-slate-200 hover:bg-slate-50 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="h-2 w-2 rounded-full bg-emerald-500"></div>
                                        <span class="text-sm font-medium text-slate-700">Tâche complétée</span>
                                    </div>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="notif_task_completed_email" class="rounded text-blue-600 focus:ring-blue-500 border-slate-300" {{ ($notificationPreferences['task_completed']->email_enabled ?? false) ? 'checked' : '' }}>
                                            <span class="text-sm text-slate-600">Email</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="notif_task_completed_push" class="rounded text-purple-600 focus:ring-purple-500 border-slate-300" {{ ($notificationPreferences['task_completed']->push_enabled ?? true) ? 'checked' : '' }}>
                                            <span class="text-sm text-slate-600">Push</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between p-4 rounded-lg border border-slate-200 hover:bg-slate-50 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="h-2 w-2 rounded-full bg-orange-500"></div>
                                        <span class="text-sm font-medium text-slate-700">Tâche en retard</span>
                                    </div>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="notif_task_overdue_email" class="rounded text-blue-600 focus:ring-blue-500 border-slate-300" {{ ($notificationPreferences['task_overdue']->email_enabled ?? true) ? 'checked' : '' }}>
                                            <span class="text-sm text-slate-600">Email</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="notif_task_overdue_push" class="rounded text-purple-600 focus:ring-purple-500 border-slate-300" {{ ($notificationPreferences['task_overdue']->push_enabled ?? true) ? 'checked' : '' }}>
                                            <span class="text-sm text-slate-600">Push</span>
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
                                <div class="flex items-center justify-between p-4 rounded-lg border border-slate-200 hover:bg-slate-50 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="h-2 w-2 rounded-full bg-orange-500"></div>
                                        <span class="text-sm font-medium text-slate-700">Nouvel utilisateur créé</span>
                                    </div>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="notif_user_created_email" class="rounded text-blue-600 focus:ring-blue-500 border-slate-300" {{ ($notificationPreferences['user_created']->email_enabled ?? true) ? 'checked' : '' }}>
                                            <span class="text-sm text-slate-600">Email</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="notif_user_created_push" class="rounded text-purple-600 focus:ring-purple-500 border-slate-300" {{ ($notificationPreferences['user_created']->push_enabled ?? false) ? 'checked' : '' }}>
                                            <span class="text-sm text-slate-600">Push</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between p-4 rounded-lg border border-slate-200 hover:bg-slate-50 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="h-2 w-2 rounded-full bg-yellow-500"></div>
                                        <span class="text-sm font-medium text-slate-700">Erreur système critique</span>
                                    </div>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="notif_error_email" class="rounded text-blue-600 focus:ring-blue-500 border-slate-300" {{ ($notificationPreferences['error']->email_enabled ?? true) ? 'checked' : '' }}>
                                            <span class="text-sm text-slate-600">Email</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="notif_error_push" class="rounded text-purple-600 focus:ring-purple-500 border-slate-300" {{ ($notificationPreferences['error']->push_enabled ?? true) ? 'checked' : '' }}>
                                            <span class="text-sm text-slate-600">Push</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- SECTION: EXPORT -->
                <div x-show="activeTab === 'export'" style="display: none;" class="space-y-6 animate-fade-in">
                    <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-5 flex items-start">
                        <svg class="h-6 w-6 text-indigo-600 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="ml-3">
                            <h3 class="text-sm font-bold text-indigo-900">Export Sécurisé</h3>
                            <p class="text-sm text-indigo-700 mt-1">Les exports contiennent des données personnelles (RGPD). Un journal d'audit est créé pour chaque téléchargement.</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                            <h3 class="text-base font-semibold text-slate-900">Configurer l'export</h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-3">Données à exporter</label>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                    <label class="border p-4 rounded-lg flex items-center gap-3 cursor-pointer hover:bg-slate-50 hover:border-indigo-200 transition-colors">
                                        <input type="checkbox" name="export_contacts" class="rounded text-indigo-600 focus:ring-indigo-500 border-slate-300" checked>
                                        <span class="text-sm font-medium text-slate-700">Contacts</span>
                                    </label>
                                    <label class="border p-4 rounded-lg flex items-center gap-3 cursor-pointer hover:bg-slate-50 hover:border-indigo-200 transition-colors">
                                        <input type="checkbox" name="export_companies" class="rounded text-indigo-600 focus:ring-indigo-500 border-slate-300">
                                        <span class="text-sm font-medium text-slate-700">Entreprises</span>
                                    </label>
                                    <label class="border p-4 rounded-lg flex items-center gap-3 cursor-pointer hover:bg-slate-50 hover:border-indigo-200 transition-colors">
                                        <input type="checkbox" name="export_deals" class="rounded text-indigo-600 focus:ring-indigo-500 border-slate-300">
                                        <span class="text-sm font-medium text-slate-700">Opportunités</span>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-slate-100">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Période</label>
                                    <select class="block w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm sm:text-sm">
                                        <option>30 derniers jours</option>
                                        <option>Cette année</option>
                                        <option>Tout l'historique</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Format</label>
                                    <select class="block w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm sm:text-sm">
                                        <option>CSV (Excel)</option>
                                        <option>JSON</option>
                                    </select>
                                </div>
                            </div>

                            <div class="pt-4">
                                <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Générer le fichier
                                </button>
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
    .animate-fade-in {
        animation: fadeIn 0.3s ease-out forwards;
    }
    
    [x-cloak] { display: none !important; }
</style>
@endsection
