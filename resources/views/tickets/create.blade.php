@extends('layouts.app')

@section('title', 'Nouveau Ticket - Nexus CRM')

@section('content')
<div class="min-h-screen bg-gray-50/50 p-6">
    <div class="max-w-5xl mx-auto space-y-6">
        
        <!-- Header Utility -->
        <div class="flex items-center justify-between">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li>
                        <div>
                            <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-gray-500">
                                <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117.414 10.707l-7 7a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-5.293-5.293a1 1 0 010-1.414z" clip-rule="evenodd" transform="scale(-1, 1) translate(-20, 0)" />
                                </svg>
                                <span class="sr-only">Dashboard</span>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="h-5 w-5 flex-shrink-0 text-gray-300" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                            </svg>
                            <a href="{{ route('tickets.index') }}" class="ml-2 text-sm font-medium text-gray-500 hover:text-gray-700">Tickets</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="h-5 w-5 flex-shrink-0 text-gray-300" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                            </svg>
                            <span class="ml-2 text-sm font-medium text-gray-700 font-bold" aria-current="page">Nouveau</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-xl font-bold text-gray-900 tracking-tight">Ouvrir un ticket</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Main Form Column (2/3) -->
            <div class="lg:col-span-2 space-y-6">
                <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
                        <div class="px-4 py-5 sm:p-6 space-y-8">
                            
                            <!-- Information Section -->
                            <div>
                                <h3 class="text-base font-semibold leading-6 text-gray-900 mb-4 flex items-center gap-2">
                                    <span class="h-6 w-6 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs font-bold ring-1 ring-indigo-500/10">1</span>
                                    Informations Générales
                                </h3>
                                
                                <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
                                    <!-- Sujet -->
                                    <div class="sm:col-span-6">
                                        <label for="subject" class="block text-sm font-medium leading-6 text-gray-900">Sujet de la demande <span class="text-red-500">*</span></label>
                                        <div class="mt-2">
                                            <input type="text" name="subject" id="subject" required
                                                class="block w-full rounded-md border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 bg-white"
                                                placeholder="Résumez le problème...">
                                        </div>
                                    </div>

                                    <!-- Priorité (Visual Selector) -->
                                    <div class="sm:col-span-6">
                                        <label class="block text-sm font-medium leading-6 text-gray-900 mb-3">Niveau d'urgence <span class="text-red-500">*</span></label>
                                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                            @foreach([
                                                'low' => ['label' => 'Faible', 'color' => 'bg-emerald-50 border-emerald-200 text-emerald-700', 'hover' => 'peer-checked:ring-emerald-500'],
                                                'medium' => ['label' => 'Normal', 'color' => 'bg-blue-50 border-blue-200 text-blue-700', 'hover' => 'peer-checked:ring-blue-500'],
                                                'high' => ['label' => 'Élevé', 'color' => 'bg-orange-50 border-orange-200 text-orange-700', 'hover' => 'peer-checked:ring-orange-500'],
                                                'urgent' => ['label' => 'Critique', 'color' => 'bg-rose-50 border-rose-200 text-rose-700', 'hover' => 'peer-checked:ring-rose-500']
                                            ] as $val => $style)
                                            <label class="relative flex cursor-pointer rounded-lg border bg-white p-3 shadow-sm focus:outline-none ring-offset-2 transition-all hover:bg-gray-50">
                                                <input type="radio" name="priority" value="{{ $val }}" class="peer sr-only" {{ $val === 'medium' ? 'checked' : '' }}>
                                                <span class="absolute inset-0 rounded-lg ring-2 ring-transparent transition-all peer-checked:ring-2 {{ $style['hover'] }}"></span>
                                                <span class="flex flex-1">
                                                    <span class="flex flex-col">
                                                        <span class="block text-sm font-medium text-gray-900 text-center">{{ $style['label'] }}</span>
                                                    </span>
                                                </span>
                                                <span class="pointer-events-none absolute -inset-px rounded-lg border {{ $style['color'] }} opacity-0 peer-checked:opacity-20"></span>
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Catégorie (Optionelle si Commercial/Admin) -->
                                    <div class="sm:col-span-3">
                                        <label for="category" class="block text-sm font-medium leading-6 text-gray-900">Catégorie</label>
                                        <select id="category" name="category" class="mt-2 block w-full rounded-md border-0 py-2.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="technical">Technique / Panne</option>
                                            <option value="billing">Facturation</option>
                                            <option value="commercial">Commercial</option>
                                            <option value="feature">Suggestion</option>
                                        </select>
                                    </div>

                                    @if(auth()->user()->hasRole(['admin', 'commercial']))
                                    <div class="sm:col-span-3">
                                        <label for="contact_id" class="block text-sm font-medium leading-6 text-gray-900">Client concerné</label>
                                        <select id="contact_id" name="contact_id" class="mt-2 block w-full rounded-md border-0 py-2.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Sélectionner un client...</option>
                                            @foreach($contacts as $contact)
                                                <option value="{{ $contact->id }}">{{ $contact->nom_complet }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="border-t border-gray-100 pt-8">
                                <h3 class="text-base font-semibold leading-6 text-gray-900 mb-4 flex items-center gap-2">
                                    <span class="h-6 w-6 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs font-bold ring-1 ring-indigo-500/10">2</span>
                                    Détails & Pièces jointes
                                </h3>

                                <div class="space-y-6">
                                    <!-- Description -->
                                    <div>
                                        <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Description détaillée <span class="text-red-500">*</span></label>
                                        <div class="mt-2">
                                            <textarea id="description" name="description" rows="8" required class="block w-full rounded-md border-0 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Décrivez les étapes pour reproduire le problème..."></textarea>
                                        </div>
                                    </div>

                                    <!-- File Upload (Compact) -->
                                    <div>
                                        <label class="block text-sm font-medium leading-6 text-gray-900">Pièce jointe (Optionnel)</label>
                                        <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-6 hover:bg-gray-50 transition-colors cursor-pointer relative">
                                            <div class="text-center">
                                                <svg class="mx-auto h-8 w-8 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                                                </svg>
                                                <div class="mt-2 flex text-sm leading-6 text-gray-600 justify-center">
                                                    <label for="attachment" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                                        <span>Téléverser un fichier</span>
                                                        <input id="attachment" name="attachment" type="file" class="sr-only">
                                                    </label>
                                                </div>
                                                <p class="text-xs leading-5 text-gray-600" id="file_name">PNG, JPG, PDF jusqu'à 5MB</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 bg-gray-50 flex items-center justify-end gap-x-6 border-t border-gray-100">
                            <a href="{{ route('tickets.index') }}" class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-700">Annuler</a>
                            <button type="submit" class="rounded-md bg-indigo-600 px-8 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-all">Créer le ticket</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Context Sidebar (1/3) -->
            <div class="space-y-6">
                
                <!-- Tips Widget -->
                <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5 p-6">
                    <h3 class="text-base font-semibold leading-6 text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="h-5 w-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Conseils de rédaction
                    </h3>
                    <ul class="space-y-4 text-sm leading-6 text-gray-600">
                        <li class="flex gap-x-3">
                            <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                            <span>Soyez précis dans le sujet pour faciliter le tri.</span>
                        </li>
                        <li class="flex gap-x-3">
                            <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                            <span>Ajoutez des captures d'écran si possible.</span>
                        </li>
                        <li class="flex gap-x-3">
                            <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                            <span>Indiquez si le problème est bloquant ou non.</span>
                        </li>
                    </ul>
                </div>

                <!-- Emergency Contact -->
                <div class="rounded-xl bg-indigo-50 p-6 border border-indigo-100">
                    <h3 class="text-sm font-semibold leading-6 text-indigo-900 mb-2">Besoin d'aide immédiate ?</h3>
                    <p class="text-xs text-indigo-700 mb-4">Pour les urgences critiques (Panne totale), contactez directement le support.</p>
                    <a href="mailto:support@ya-consulting.com" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">support@ya-consulting.com &rarr;</a>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('attachment').addEventListener('change', function(e) {
        if (e.target.files[0]) {
            document.getElementById('file_name').innerHTML = '<span class="text-indigo-600 font-semibold">' + e.target.files[0].name + '</span> pret à l\'envoi';
        }
    });
</script>
@endsection
        <div class="absolute inset-0 bg-[url('/images/grid.svg')] opacity-10"></div>
        <div class="absolute bottom-0 inset-x-0 h-32 bg-gradient-to-t from-gray-50/50 to-transparent"></div>
    </div>

    <!-- Main Content -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Breadcrumb & Title -->
        <div class="mb-10 text-center sm:text-left">
            <nav class="flex justify-center sm:justify-start items-center space-x-2 text-indigo-100 text-sm mb-4">
                <a href="{{ route('dashboard') }}" class="hover:text-white transition-colors">Dashboard</a>
                <span class="opacity-50">/</span>
                <a href="{{ route('tickets.index') }}" class="hover:text-white transition-colors">Tickets</a>
                <span class="opacity-50">/</span>
                <span class="text-white font-medium">Nouveau</span>
            </nav>
            <h1 class="text-3xl sm:text-4xl font-bold text-white tracking-tight">Créer un nouveau ticket</h1>
            <p class="mt-2 text-indigo-100/80 text-lg max-w-2xl">Notre équipe de support est là pour vous aider. Décrivez votre problème ci-dessous.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data" class="divide-y divide-gray-100">
                @csrf
                
                <!-- Section 1: Informations principales -->
                <div class="p-8 sm:p-10 space-y-8">
                    <div class="flex flex-col sm:flex-row gap-8">
                        <!-- Sujet -->
                        <div class="flex-1 space-y-2">
                            <label for="subject" class="text-sm font-semibold text-gray-700">Sujet de la demande <span class="text-red-500">*</span></label>
                            <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder-gray-400 font-medium"
                                placeholder="Ex: Problème d'accès au module CRM...">
                            @error('subject') <p class="text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Priorité -->
                        <div class="w-full sm:w-1/3 space-y-2">
                            <label for="priority" class="text-sm font-semibold text-gray-700">Niveau d'urgence <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="priority" id="priority" class="w-full pl-4 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all appearance-none cursor-pointer font-medium">
                                    <option value="low">Faible - Information</option>
                                    <option value="medium" selected>Moyenne - Normal</option>
                                    <option value="high">Élevée - Bloquant</option>
                                    <option value="urgent">Critique - Panne</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" /></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Client (Admin/Commercial only) -->
                    @if(auth()->user()->hasRole(['admin', 'commercial']))
                    <div class="space-y-2">
                        <label for="contact_id" class="text-sm font-semibold text-gray-700">Client concerné</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <select name="contact_id" id="contact_id" class="w-full pl-12 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all appearance-none cursor-pointer font-medium">
                                <option value="">Sélectionner un client (Optionnel)</option>
                                @foreach($contacts as $contact)
                                    <option value="{{ $contact->id }}" {{ (request('contact_id') == $contact->id) ? 'selected' : '' }}>
                                        {{ $contact->nom_complet }} ({{ $contact->entreprise ?? 'Particulier' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif

                    <!-- Description -->
                    <div class="space-y-2">
                        <label for="description" class="text-sm font-semibold text-gray-700">Description détaillée <span class="text-red-500">*</span></label>
                        <textarea name="description" id="description" rows="6" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder-gray-400 font-medium resize-none"
                            placeholder="Veuillez décrire le problème rencontré, les étapes pour le reproduire et tout autre détail pertinent..."></textarea>
                        @error('description') <p class="text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Section 2: Pièces jointes & Métadonnées -->
                <div class="p-8 sm:p-10 bg-gray-50/50 space-y-8">
                    <div class="flex flex-col sm:flex-row gap-8">
                        <!-- Catégorie -->
                        <div class="w-full sm:w-1/2 space-y-2">
                            <label class="text-sm font-semibold text-gray-700">Catégorie</label>
                            <div class="grid grid-cols-2 gap-3">
                                @foreach(['technical' => 'Technique', 'billing' => 'Facturation', 'commercial' => 'Commercial', 'feature' => 'Suggestion'] as $val => $label)
                                <label class="cursor-pointer">
                                    <input type="radio" name="category" value="{{ $val }}" class="peer sr-only" {{ $val === 'technical' ? 'checked' : '' }}>
                                    <div class="px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm font-medium text-gray-600 text-center hover:bg-gray-50 peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 transition-all shadow-sm">
                                        {{ $label }}
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Upload File -->
                        <div class="w-full sm:w-1/2 space-y-2">
                            <label class="text-sm font-semibold text-gray-700">Pièce jointe</label>
                            <div class="relative group">
                                <input type="file" name="attachment" id="attachment" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                <div class="w-full px-6 py-8 bg-white border-2 border-dashed border-gray-200 rounded-xl text-center group-hover:border-indigo-400 group-hover:bg-indigo-50/10 transition-all">
                                    <div class="text-indigo-500 mb-2">
                                        <svg class="mx-auto h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-gray-700" id="file_label">
                                        Cliquez ou glissez un fichier ici
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">PNG, JPG, PDF (Max 5Mo)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="px-8 py-6 bg-gray-50 flex items-center justify-between sm:px-10">
                    <a href="{{ route('tickets.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                        Annuler
                    </a>
                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-xl font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:scale-[1.02]">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        Envoyer le ticket
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('attachment').addEventListener('change', function(e) {
        if (e.target.files[0]) {
            document.getElementById('file_label').innerHTML = '<span class="text-indigo-600 font-semibold">' + e.target.files[0].name + '</span> sélectionné';
        }
    });
</script>
@endsection
