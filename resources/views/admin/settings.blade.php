@extends('layouts.app')

@section('title', 'Paramètres')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ activeTab: 'general' }">
    <div class="mb-10">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Paramètres Système</h1>
        <p class="mt-2 text-slate-500">Gérez les configurations globales de votre instance CRM.</p>
    </div>

    <div class="bg-white shadow-xl shadow-slate-200/50 rounded-2xl overflow-hidden border border-slate-100">
        <!-- Tabs Header -->
        <div class="border-b border-slate-200 bg-slate-50/50 px-2">
            <nav class="-mb-px flex space-x-1" aria-label="Tabs">
                <button @click="activeTab = 'general'" 
                    :class="activeTab === 'general' ? 'bg-white text-indigo-600 border-indigo-500 shadow-sm' : 'border-transparent text-slate-500 hover:text-slate-700 hover:bg-slate-100/50'" 
                    class="w-1/4 py-4 px-1 text-center border-b-2 font-semibold text-sm transition-all duration-200 rounded-t-lg">
                    Général
                </button>
                <button @click="activeTab = 'email'" 
                    :class="activeTab === 'email' ? 'bg-white text-indigo-600 border-indigo-500 shadow-sm' : 'border-transparent text-slate-500 hover:text-slate-700 hover:bg-slate-100/50'" 
                    class="w-1/4 py-4 px-1 text-center border-b-2 font-semibold text-sm transition-all duration-200 rounded-t-lg">
                    Email
                </button>
                <button @click="activeTab = 'security'" 
                    :class="activeTab === 'security' ? 'bg-white text-indigo-600 border-indigo-500 shadow-sm' : 'border-transparent text-slate-500 hover:text-slate-700 hover:bg-slate-100/50'" 
                    class="w-1/4 py-4 px-1 text-center border-b-2 font-semibold text-sm transition-all duration-200 rounded-t-lg">
                    Sécurité
                </button>
                <button @click="activeTab = 'notifications'" 
                    :class="activeTab === 'notifications' ? 'bg-white text-indigo-600 border-indigo-500 shadow-sm' : 'border-transparent text-slate-500 hover:text-slate-700 hover:bg-slate-100/50'" 
                    class="w-1/4 py-4 px-1 text-center border-b-2 font-semibold text-sm transition-all duration-200 rounded-t-lg">
                    Notifications
                </button>
                <button @click="activeTab = 'sales'" 
                    :class="activeTab === 'sales' ? 'bg-white text-indigo-600 border-indigo-500 shadow-sm' : 'border-transparent text-slate-500 hover:text-slate-700 hover:bg-slate-100/50'" 
                    class="w-1/4 py-4 px-1 text-center border-b-2 font-semibold text-sm transition-all duration-200 rounded-t-lg">
                    Ventes & Pipeline
                </button>
            </nav>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.settings.update') }}" method="POST" class="p-8">
            @csrf
            
            <!-- General Tab -->
            <div x-show="activeTab === 'general'" class="space-y-8 animate-in fade-in slide-in-from-bottom-2 duration-300">
                <div class="pb-5 border-b border-slate-100">
                    <h3 class="text-xl font-bold text-slate-900">Information Entreprise</h3>
                    <p class="mt-1 text-sm text-slate-500">Ces informations seront visibles sur les exports et communications.</p>
                </div>
                
                <div class="grid grid-cols-1 gap-y-8 gap-x-6 sm:grid-cols-6">
                    <div class="sm:col-span-4">
                        <label for="company_name" class="block text-sm font-semibold text-slate-700 mb-1.5">Nom de l'entreprise</label>
                        <input type="text" name="company_name" id="company_name" value="{{ $settings['company_name'] ?? '' }}" 
                            class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 block w-full p-2.5 transition-all duration-200 hover:border-slate-400 shadow-sm"
                            placeholder="Ex: Mon CRM Pro">
                    </div>

                    <div class="sm:col-span-3">
                        <label for="currency" class="block text-sm font-semibold text-slate-700 mb-1.5">Devise</label>
                        <select id="currency" name="currency" 
                            class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 block w-full p-2.5 transition-all duration-200 hover:border-slate-400 shadow-sm">
                            <option value="EUR" {{ ($settings['currency'] ?? '') == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                            <option value="USD" {{ ($settings['currency'] ?? '') == 'USD' ? 'selected' : '' }}>USD ($)</option>
                            <option value="XOF" {{ ($settings['currency'] ?? '') == 'XOF' ? 'selected' : '' }}>Franc CFA (FCFA)</option>
                        </select>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="timezone" class="block text-sm font-semibold text-slate-700 mb-1.5">Fuseau Horaire</label>
                        <input type="text" name="timezone" id="timezone" value="{{ $settings['timezone'] ?? 'Europe/Paris' }}" 
                            class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 block w-full p-2.5 transition-all duration-200 hover:border-slate-400 shadow-sm"
                            placeholder="Ex: Europe/Paris">
                    </div>
                </div>
            </div>

            <!-- Email Tab -->
            <div x-show="activeTab === 'email'" class="space-y-8 animate-in fade-in slide-in-from-bottom-2 duration-300" style="display: none;">
                <div class="pb-5 border-b border-slate-100">
                    <h3 class="text-xl font-bold text-slate-900">Configuration Email (SMTP)</h3>
                    <p class="mt-1 text-sm text-slate-500">Configurez le serveur d'envoi pour les notifications et les emails transactionnels.</p>
                </div>

                <div class="grid grid-cols-1 gap-y-6 gap-x-6 sm:grid-cols-6">
                    <div class="sm:col-span-4">
                        <label for="smtp_host" class="block text-sm font-semibold text-slate-700 mb-1.5">Serveur SMTP</label>
                        <input type="text" name="mail_host" id="smtp_host" value="{{ $settings['mail_host'] ?? '' }}" 
                            class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 block w-full p-2.5 shadow-sm" placeholder="smtp.example.com">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="smtp_port" class="block text-sm font-semibold text-slate-700 mb-1.5">Port</label>
                        <input type="text" name="mail_port" id="smtp_port" value="{{ $settings['mail_port'] ?? '587' }}" 
                            class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 block w-full p-2.5 shadow-sm">
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-y-6 gap-x-6 sm:grid-cols-6 border-t border-slate-100 pt-6">
                     <div class="sm:col-span-3">
                        <label for="smtp_username" class="block text-sm font-semibold text-slate-700 mb-1.5">Nom d'utilisateur</label>
                        <input type="text" name="mail_username" id="smtp_username" value="{{ $settings['mail_username'] ?? '' }}" 
                            class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 block w-full p-2.5 shadow-sm">
                    </div>
                    <div class="sm:col-span-3">
                        <label for="smtp_password" class="block text-sm font-semibold text-slate-700 mb-1.5">Mot de passe</label>
                        <input type="password" name="mail_password" id="smtp_password" value="{{ $settings['mail_password'] ?? '' }}" 
                            class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 block w-full p-2.5 shadow-sm" placeholder="••••••••">
                    </div>
                    <div class="sm:col-span-3">
                        <label for="mail_encryption" class="block text-sm font-semibold text-slate-700 mb-1.5">Chiffrement</label>
                        <select name="mail_encryption" id="mail_encryption" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 block w-full p-2.5 shadow-sm">
                            <option value="tls" {{ ($settings['mail_encryption'] ?? '') == 'tls' ? 'selected' : '' }}>TLS</option>
                            <option value="ssl" {{ ($settings['mail_encryption'] ?? '') == 'ssl' ? 'selected' : '' }}>SSL</option>
                            <option value="null" {{ ($settings['mail_encryption'] ?? '') == 'null' ? 'selected' : '' }}>Aucun</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-y-6 gap-x-6 sm:grid-cols-6 border-t border-slate-100 pt-6">
                     <div class="sm:col-span-3">
                        <label for="mail_from_address" class="block text-sm font-semibold text-slate-700 mb-1.5">Adresse d'expédition</label>
                        <input type="email" name="mail_from_address" id="mail_from_address" value="{{ $settings['mail_from_address'] ?? '' }}" 
                            class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 block w-full p-2.5 shadow-sm" placeholder="notifications@moncrm.com">
                    </div>
                    <div class="sm:col-span-3">
                        <label for="mail_from_name" class="block text-sm font-semibold text-slate-700 mb-1.5">Nom de l'expéditeur</label>
                        <input type="text" name="mail_from_name" id="mail_from_name" value="{{ $settings['mail_from_name'] ?? '' }}" 
                            class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 block w-full p-2.5 shadow-sm" placeholder="Support CRM">
                    </div>
                </div>
            </div>

            <!-- Security Tab -->
            <div x-show="activeTab === 'security'" class="space-y-8 animate-in fade-in slide-in-from-bottom-2 duration-300" style="display: none;">
                <div class="pb-5 border-b border-slate-100">
                    <h3 class="text-xl font-bold text-slate-900">Politiques de Sécurité</h3>
                    <p class="mt-1 text-sm text-slate-500">Définissez les règles d'accès et d'authentification.</p>
                </div>

                <div class="bg-slate-50 p-6 rounded-xl border border-slate-200 space-y-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="font-bold text-slate-900 block">Autoriser l'inscription publique</span>
                            <span class="text-sm text-slate-500">Permet aux visiteurs de créer un compte librement.</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="enable_registration" value="false">
                            <input type="checkbox" name="enable_registration" value="true" class="sr-only peer" {{ ($settings['enable_registration'] ?? '') == 'true' ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>
                     <div class="flex items-center justify-between pt-6 border-t border-slate-200">
                        <div>
                            <span class="font-bold text-slate-900 block">Authentification à deux facteurs (2FA)</span>
                            <span class="text-sm text-slate-500">Forcer le 2FA pour tous les administrateurs.</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="force_2fa" value="false">
                            <input type="checkbox" name="force_2fa" value="true" class="sr-only peer" {{ ($settings['force_2fa'] ?? '') == 'true' ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                         <label class="block text-sm font-semibold text-slate-700 mb-1.5">Longueur min. mot de passe</label>
                        <div class="relative rounded-md shadow-sm">
                            <input type="number" name="min_password_length" value="{{ $settings['min_password_length'] ?? '8' }}" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 block w-full p-2.5 pr-12" placeholder="8">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                              <span class="text-gray-500 sm:text-sm">caractères</span>
                            </div>
                        </div>
                    </div>
                     <div>
                         <label class="block text-sm font-semibold text-slate-700 mb-1.5">Expiration de session</label>
                        <div class="relative rounded-md shadow-sm">
                            <input type="number" name="session_lifetime" value="{{ $settings['session_lifetime'] ?? '120' }}" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 block w-full p-2.5 pr-12" placeholder="120">
                             <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                              <span class="text-gray-500 sm:text-sm">minutes</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

             <!-- Notifications Tab -->
             <div x-show="activeTab === 'notifications'" class="space-y-8 animate-in fade-in slide-in-from-bottom-2 duration-300" style="display: none;">
                <div class="pb-5 border-b border-slate-100">
                    <h3 class="text-xl font-bold text-slate-900">Préférences de Notification</h3>
                    <p class="mt-1 text-sm text-slate-500">Configurez les alertes système par défaut.</p>
                </div>

                <div class="space-y-4">
                     <div class="flex items-center justify-between p-4 bg-white border border-slate-200 rounded-xl hover:border-indigo-300 transition-colors">
                        <div>
                            <span class="font-bold text-slate-900 block">Nouveau Lead Assigné</span>
                            <span class="text-sm text-slate-500">Notifier le commercial lorsqu'un lead lui est attribué.</span>
                        </div>
                         <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="notify_new_lead" value="false">
                            <input type="checkbox" name="notify_new_lead" value="true" class="sr-only peer" {{ ($settings['notify_new_lead'] ?? 'true') == 'true' ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-white border border-slate-200 rounded-xl hover:border-indigo-300 transition-colors">
                        <div>
                            <span class="font-bold text-slate-900 block">Ticket Support Créé</span>
                            <span class="text-sm text-slate-500">Alerter l'équipe support à chaque nouveau ticket.</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="notify_ticket_created" value="false">
                            <input type="checkbox" name="notify_ticket_created" value="true" class="sr-only peer" {{ ($settings['notify_ticket_created'] ?? 'true') == 'true' ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-white border border-slate-200 rounded-xl hover:border-indigo-300 transition-colors">
                        <div>
                            <span class="font-bold text-slate-900 block">Rappel de Tâche (Email)</span>
                            <span class="text-sm text-slate-500">Envoyer un email le matin pour les tâches du jour.</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="notify_task_reminder" value="false">
                            <input type="checkbox" name="notify_task_reminder" value="true" class="sr-only peer" {{ ($settings['notify_task_reminder'] ?? 'true') == 'true' ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Ventes Tab -->
            <div x-show="activeTab === 'sales'" class="space-y-8 animate-in fade-in slide-in-from-bottom-2 duration-300" style="display: none;">
                <div class="pb-5 border-b border-slate-100">
                    <h3 class="text-xl font-bold text-slate-900">Configuration Commerciale</h3>
                    <p class="mt-1 text-sm text-slate-500">Gérez les étapes du pipeline et les sources de prospects.</p>
                </div>

                <!-- Pipeline Stages -->
                <div x-data="{
                    stages: {{ json_encode(json_decode($settings['pipeline_stages'] ?? '[\"Nouveau\", \"Qualification\", \"Proposition\", \"Négociation\", \"Gagné\", \"Perdu\"]')) }},
                    addStage() { if(this.newStage) { this.stages.push(this.newStage); this.newStage = ''; } },
                    removeStage(index) { this.stages.splice(index, 1); },
                    newStage: ''
                }">
                    <label class="block text-sm font-semibold text-slate-700 mb-3">Étapes du Pipeline</label>
                    <input type="hidden" name="pipeline_stages" :value="JSON.stringify(stages)">
                    
                    <div class="space-y-2 mb-4">
                        <template x-for="(stage, index) in stages" :key="index">
                            <div class="flex items-center gap-2 bg-slate-50 p-2 rounded-lg border border-slate-200">
                                <span x-text="index + 1" class="text-xs font-mono text-slate-400 w-6"></span>
                                <input type="text" x-model="stages[index]" class="flex-1 bg-transparent border-0 p-0 text-sm focus:ring-0">
                                <button type="button" @click="removeStage(index)" class="text-red-400 hover:text-red-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </template>
                    </div>
                    
                    <div class="flex gap-2">
                        <input type="text" x-model="newStage" @keydown.enter.prevent="addStage()" placeholder="Nouvelle étape..." 
                            class="flex-1 bg-white border border-slate-300 text-sm rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 p-2.5">
                        <button type="button" @click="addStage()" class="px-3 py-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 font-medium text-sm">Ajouter</button>
                    </div>
                </div>

                <!-- Lead Sources -->
                <div x-data="{
                    sources: {{ json_encode(json_decode($settings['lead_sources'] ?? '[\"Web\", \"Téléphone\", \"Email\", \"LinkedIn\", \"Recommandation\", \"Autre\"]')) }},
                    addSource() { if(this.newSource) { this.sources.push(this.newSource); this.newSource = ''; } },
                    removeSource(index) { this.sources.splice(index, 1); },
                    newSource: ''
                }">
                    <label class="block text-sm font-semibold text-slate-700 mb-3 mt-8">Sources de Prospects</label>
                    <input type="hidden" name="lead_sources" :value="JSON.stringify(sources)">
                    
                    <div class="flex flex-wrap gap-2 mb-4">
                        <template x-for="(source, index) in sources" :key="index">
                            <div class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                <span x-text="source"></span>
                                <button type="button" @click="removeSource(index)" class="hover:text-blue-900 ml-1">
                                    &times;
                                </button>
                            </div>
                        </template>
                    </div>
                    
                    <div class="flex gap-2 max-w-md">
                        <input type="text" x-model="newSource" @keydown.enter.prevent="addSource()" placeholder="Nouvelle source..." 
                            class="flex-1 bg-white border border-slate-300 text-sm rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 p-2.5">
                        <button type="button" @click="addSource()" class="px-3 py-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 font-medium text-sm">Ajouter</button>
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="pt-8 mt-10 border-t border-slate-200">
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex justify-center items-center py-3 px-6 border border-transparent shadow-lg text-sm font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 active:transform active:scale-95">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Sauvegarder les modifications
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
