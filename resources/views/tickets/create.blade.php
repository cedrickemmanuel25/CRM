@extends('layouts.app')

@section('title', 'Nouveau Ticket Support')

@section('content')
<div class="min-h-screen bg-gray-50/50">
    <!-- Header Decor -->
    <div class="absolute top-0 inset-x-0 h-80 bg-gradient-to-b from-indigo-600 to-indigo-800 -z-10">
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
