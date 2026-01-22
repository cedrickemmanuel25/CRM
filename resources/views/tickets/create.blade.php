@extends('layouts.app')

@section('title', 'Nouveau Ticket')

@section('content')
<div class="min-h-full bg-gradient-to-br from-slate-50 via-white to-slate-50/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <!-- Header Section -->
        <div class="mb-6">
            <!-- Breadcrumbs -->
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-xs font-semibold text-slate-500">
                    <li class="hover:text-indigo-600 transition-colors">
                        <a href="{{ route('tickets.index') }}" class="flex items-center">
                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                            </svg>
                            Support
                        </a>
                    </li>
                    <li><svg class="h-4 w-4 text-slate-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                    <li class="text-indigo-600 font-bold">Nouveau ticket</li>
                </ol>
            </nav>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-black tracking-tight text-slate-900 mb-1">Nouveau ticket</h1>
                    <p class="text-sm text-slate-600 font-medium">Créez une demande d’assistance claire, complète et assignable en 30 secondes.</p>
                </div>
                <!-- Actions moved to sticky bar (below) -->
            </div>

            @if ($errors->any())
                <div class="mt-6 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3">
                    <div class="flex items-start gap-3">
                        <svg class="h-5 w-5 text-rose-600 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M10.29 3.86l-7.5 13A1.5 1.5 0 004.09 19h15.82a1.5 1.5 0 001.3-2.14l-7.5-13a1.5 1.5 0 00-2.42 0z" />
                        </svg>
                        <div>
                            <p class="text-sm font-bold text-rose-800">Certaines informations sont manquantes ou invalides.</p>
                            <p class="text-sm text-rose-700">Corrigez les champs surlignés puis réessayez.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sticky action bar -->
        <div class="sticky top-16 z-30 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 py-3 mb-6 bg-white/80 backdrop-blur border-y border-slate-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="h-9 w-9 rounded-xl bg-slate-900 text-white flex items-center justify-center shadow-sm">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-black text-slate-900 leading-tight">Création d’un ticket</p>
                        <p class="text-xs text-slate-600">Les champs marqués <span class="text-rose-600 font-bold">*</span> sont obligatoires.</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 justify-end">
                    <a href="{{ route('tickets.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-slate-700 hover:text-slate-900 rounded-lg hover:bg-slate-100 transition">
                        Annuler
                    </a>
                    <button type="submit" form="create-ticket-form"
                        class="inline-flex items-center justify-center px-6 py-2.5 bg-slate-900 border border-transparent shadow-md text-sm font-black rounded-lg text-white hover:bg-slate-800 focus:outline-none transition-all">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        Créer le ticket
                    </button>
                </div>
            </div>
        </div>

        <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data" id="create-ticket-form">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- MAIN CONTENT AREA -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="bg-gradient-to-br from-slate-50 to-slate-100/50 px-6 py-4 border-b border-slate-200">
                            <h3 class="text-sm font-semibold text-slate-900 uppercase tracking-wide">Détails de la demande</h3>
                            <p class="mt-1 text-xs font-medium text-slate-500">Décrivez le contexte, l’impact, et comment reproduire si possible.</p>
                        </div>

                        <div class="p-6 space-y-8">
                            <!-- Subject -->
                            <div class="space-y-2">
                                <label for="subject" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Sujet du ticket <span class="text-rose-600">*</span></label>
                                <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                                    class="block w-full px-4 py-3 border rounded-lg text-sm font-bold text-slate-900 focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all shadow-sm {{ $errors->has('subject') ? 'border-rose-300 bg-rose-50/30' : 'border-slate-300' }}"
                                    placeholder="Ex: Impossible de se connecter / Erreur 500 lors de l’export PDF">
                                <div class="flex items-center justify-between gap-4">
                                    <p class="text-xs text-slate-500 font-medium">Conseil: commencez par un verbe (“Impossible…”, “Erreur…”, “Demande…”).</p>
                                    <p class="text-xs text-slate-500 font-medium"><span id="subject-count">0</span> / 255</p>
                                </div>
                                @error('subject') <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <!-- Description -->
                            <div class="space-y-2">
                                <label for="description" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Description <span class="text-rose-600">*</span></label>
                                <textarea id="description" name="description" rows="12" required
                                    class="block w-full px-4 py-3 border rounded-lg text-sm font-medium text-slate-700 leading-relaxed focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all shadow-sm {{ $errors->has('description') ? 'border-rose-300 bg-rose-50/30' : 'border-slate-300' }}"
                                    placeholder="Contexte\n- Client / dossier concerné\n- Étapes pour reproduire\n- Résultat attendu / obtenu\n- Urgence et impact">{{ old('description') }}</textarea>
                                <div class="flex items-center justify-between gap-4">
                                    <p class="text-xs text-slate-500 font-medium">Astuce: ajoutez des étapes de reproduction et une capture si possible.</p>
                                    <p class="text-xs text-slate-500 font-medium"><span id="desc-count">0</span> caractères</p>
                                </div>
                                @error('description') <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <!-- Attachment -->
                            <div class="space-y-2">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Pièce jointe</label>
                                <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50/40 px-6 py-8 hover:bg-slate-50 transition-colors">
                                    <div class="flex items-start gap-4">
                                        <div class="h-10 w-10 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-500">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828L18 9.828a4 4 0 10-5.656-5.656L5.757 10.757a6 6 0 108.486 8.486L20.5 13" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2">
                                                <label for="attachment" class="inline-flex cursor-pointer items-center rounded-lg bg-white px-3 py-2 text-sm font-semibold text-slate-900 shadow-sm border border-slate-200 hover:bg-slate-50">
                                                    Choisir un fichier
                                                </label>
                                                <input id="attachment" name="attachment" type="file" class="sr-only">
                                                <span class="text-sm text-slate-600">ou glisser-déposer</span>
                                            </div>
                                            <p class="mt-2 text-xs text-slate-500">Formats: JPG/PNG/PDF/DOCX/ZIP — max 5 Mo.</p>
                                            <p id="file-name" class="mt-2 text-sm font-bold text-indigo-700 hidden"></p>
                                            @error('attachment') <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SIDEBAR AREA -->
                <div class="space-y-6">
                    <!-- Properties -->
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="bg-gradient-to-br from-slate-50 to-slate-100/50 px-5 py-4 border-b border-slate-200 flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-700 uppercase tracking-widest">Paramètres</span>
                            <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>

                        <div class="p-5 space-y-6">
                            <!-- Quick Summary -->
                            <div class="rounded-xl border border-slate-200 bg-slate-50/60 p-4">
                                <p class="text-[11px] font-black text-slate-600 uppercase tracking-widest">Aperçu</p>
                                <p id="summary-subject" class="mt-2 text-sm font-black text-slate-900 leading-snug">—</p>
                                <div class="mt-2 flex items-center gap-2 text-xs text-slate-600">
                                    <span class="inline-flex items-center gap-1 rounded-full bg-white border border-slate-200 px-2 py-1 font-semibold">
                                        <span class="h-2 w-2 rounded-full bg-indigo-500" id="summary-priority-dot"></span>
                                        <span id="summary-priority">Priorité</span>
                                    </span>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-white border border-slate-200 px-2 py-1 font-semibold">
                                        <span id="summary-category">Catégorie</span>
                                    </span>
                                </div>
                            </div>

                            <!-- Category -->
                            <div class="space-y-2">
                                <label for="category" class="block text-[11px] font-bold text-slate-500 uppercase tracking-tight">Catégorie <span class="text-rose-600">*</span></label>
                                <select id="category" name="category" required
                                    class="block w-full pl-3 pr-10 py-2.5 text-sm font-semibold border rounded-lg focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all bg-slate-50/50 {{ $errors->has('category') ? 'border-rose-300' : 'border-slate-300' }}">
                                    <option value="technical" {{ old('category') === 'technical' ? 'selected' : '' }}>🛠️ Support Technique</option>
                                    <option value="commercial" {{ old('category') === 'commercial' ? 'selected' : '' }}>💼 Administratif & Commercial</option>
                                    <option value="billing" {{ old('category') === 'billing' ? 'selected' : '' }}>💳 Facturation & Paiement</option>
                                    <option value="feature_request" {{ old('category') === 'feature_request' ? 'selected' : '' }}>💡 Demande d’évolution</option>
                                    <option value="other" {{ old('category') === 'other' ? 'selected' : '' }}>❓ Autre</option>
                                </select>
                                @error('category') <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <!-- Priority -->
                            <div class="space-y-3">
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-tight">Priorité <span class="text-rose-600">*</span></label>
                                <div class="grid grid-cols-1 gap-2">
                                    @php($priorityOld = old('priority', 'medium'))
                                    @foreach(['low' => 'Basse', 'medium' => 'Normale', 'high' => 'Haute', 'urgent' => 'Critique'] as $value => $label)
                                        <label class="relative flex items-center p-3 cursor-pointer rounded-xl border transition-all group {{ $priorityOld === $value ? 'border-indigo-400 bg-indigo-50/30' : 'border-slate-200 hover:bg-slate-50' }}">
                                            <input type="radio" name="priority" value="{{ $value }}" {{ $priorityOld === $value ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-slate-300">
                                            <div class="ml-3 flex flex-col">
                                                <span class="text-xs font-bold {{ $priorityOld === $value ? 'text-indigo-700' : 'text-slate-700' }}">{{ $label }}</span>
                                                <span class="text-[11px] text-slate-500">
                                                    @if($value === 'urgent') Incident bloquant / service indisponible
                                                    @elseif($value === 'high') Impact fort / workaround limité
                                                    @elseif($value === 'medium') Demande standard
                                                    @else Question / amélioration mineure
                                                    @endif
                                                </span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                @error('priority') <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <!-- Contact -->
                            <div class="space-y-2 pt-2" x-data="contactCombobox({
                                items: [
                                    @foreach($contacts as $c)
                                        { id: '{{ $c->id }}', label: @js($c->nom_complet) },
                                    @endforeach
                                ],
                                initialId: @js((string) old('contact_id')),
                                placeholder: 'Rechercher un client…'
                            })">
                                <label for="contact_id" class="block text-[11px] font-bold text-slate-500 uppercase tracking-tight">Client associé <span class="text-rose-600">*</span></label>

                                <!-- Hidden select to keep server-side validation unchanged -->
                                <select id="contact_id" name="contact_id" required class="hidden">
                                    <option value="">-- Sélectionner un client --</option>
                                    @foreach($contacts as $contact)
                                        <option value="{{ $contact->id }}" {{ (string) old('contact_id') === (string) $contact->id ? 'selected' : '' }}>{{ $contact->nom_complet }}</option>
                                    @endforeach
                                </select>

                                <!-- Combobox UI -->
                                <div class="relative">
                                    <div class="relative">
                                        <input type="text"
                                            x-model="query"
                                            @focus="open = true"
                                            @keydown.escape.window="open = false"
                                            @click.away="open = false"
                                            @keydown.arrow-down.prevent="highlightNext()"
                                            @keydown.arrow-up.prevent="highlightPrev()"
                                            @keydown.enter.prevent="commitHighlighted()"
                                            class="block w-full pl-10 pr-10 py-2.5 text-sm font-semibold border rounded-lg focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all bg-slate-50/50 {{ $errors->has('contact_id') ? 'border-rose-300' : 'border-slate-300' }}"
                                            :placeholder="placeholder"
                                        >
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                                            </svg>
                                        </div>
                                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-500" @click="toggle()">
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div x-show="open" x-transition.opacity class="absolute z-20 mt-2 w-full rounded-xl border border-slate-200 bg-white shadow-lg overflow-hidden" style="display:none;">
                                        <div class="max-h-64 overflow-auto">
                                            <template x-if="filtered.length === 0">
                                                <div class="px-4 py-3 text-sm text-slate-600">Aucun résultat.</div>
                                            </template>
                                            <template x-for="(item, idx) in filtered" :key="item.id">
                                                <button type="button"
                                                    class="w-full text-left px-4 py-2.5 text-sm font-semibold hover:bg-slate-50 flex items-center justify-between"
                                                    :class="idx === highlighted ? 'bg-slate-50' : ''"
                                                    @mouseenter="highlighted = idx"
                                                    @click="select(item)">
                                                    <span x-text="item.label"></span>
                                                    <svg x-show="item.id === selectedId" class="h-4 w-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display:none;">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </button>
                                            </template>
                                        </div>
                                    </div>
                                </div>

                                <p class="text-xs text-slate-500 font-medium">Permet d’historiser la demande dans le dossier client.</p>
                                @error('contact_id') <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <!-- Assign to -->
                            <div class="space-y-2" x-data="contactCombobox({
                                items: [
                                    @foreach($users as $u)
                                        { id: '{{ $u->id }}', label: @js($u->name) },
                                    @endforeach
                                ],
                                initialId: @js((string) old('assigned_to')),
                                placeholder: 'Rechercher un agent…',
                                allowEmpty: true
                            })">
                                <label for="assigned_to" class="block text-[11px] font-bold text-slate-500 uppercase tracking-tight">Assigné à</label>

                                <select id="assigned_to" name="assigned_to" class="hidden">
                                    <option value="">Non assigné</option>
                                    @foreach($users as $u)
                                        <option value="{{ $u->id }}" {{ (string) old('assigned_to') === (string) $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                                    @endforeach
                                </select>

                                <div class="relative">
                                    <div class="relative">
                                        <input type="text"
                                            x-model="query"
                                            @focus="open = true"
                                            @keydown.escape.window="open = false"
                                            @click.away="open = false"
                                            @keydown.arrow-down.prevent="highlightNext()"
                                            @keydown.arrow-up.prevent="highlightPrev()"
                                            @keydown.enter.prevent="commitHighlighted()"
                                            class="block w-full pl-10 pr-10 py-2.5 text-sm font-semibold border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all bg-slate-50/50"
                                            :placeholder="placeholder"
                                        >
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                                            </svg>
                                        </div>
                                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-500" @click="toggle()">
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div x-show="open" x-transition.opacity class="absolute z-20 mt-2 w-full rounded-xl border border-slate-200 bg-white shadow-lg overflow-hidden" style="display:none;">
                                        <div class="max-h-64 overflow-auto">
                                            <template x-if="allowEmpty">
                                                <button type="button" class="w-full text-left px-4 py-2.5 text-sm font-semibold hover:bg-slate-50" @click="clear()">
                                                    Non assigné
                                                </button>
                                            </template>
                                            <template x-if="filtered.length === 0">
                                                <div class="px-4 py-3 text-sm text-slate-600">Aucun résultat.</div>
                                            </template>
                                            <template x-for="(item, idx) in filtered" :key="item.id">
                                                <button type="button"
                                                    class="w-full text-left px-4 py-2.5 text-sm font-semibold hover:bg-slate-50 flex items-center justify-between"
                                                    :class="idx === highlighted ? 'bg-slate-50' : ''"
                                                    @mouseenter="highlighted = idx"
                                                    @click="select(item)">
                                                    <span x-text="item.label"></span>
                                                    <svg x-show="item.id === selectedId" class="h-4 w-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display:none;">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </button>
                                            </template>
                                        </div>
                                    </div>
                                </div>

                                @error('assigned_to') <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Help Card -->
                    <div class="bg-indigo-50 rounded-xl shadow-sm border border-indigo-100 overflow-hidden">
                        <div class="p-5">
                            <div class="flex items-start gap-3">
                                <div class="h-10 w-10 rounded-lg bg-white border border-indigo-200 flex items-center justify-center text-indigo-700">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 18a8 8 0 100-16 8 8 0 000 16z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-indigo-900">Bonnes pratiques</p>
                                    <ul class="mt-2 space-y-2 text-sm text-indigo-900/80">
                                        <li class="flex gap-2"><span class="font-bold">•</span><span>Indiquez l’<strong>impact</strong> (bloquant / partiel / mineur).</span></li>
                                        <li class="flex gap-2"><span class="font-bold">•</span><span>Ajoutez des <strong>étapes</strong> et un exemple si possible.</span></li>
                                        <li class="flex gap-2"><span class="font-bold">•</span><span>Joignez une <strong>capture</strong> ou un PDF si utile.</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    (function () {
        const attachment = document.getElementById('attachment');
        const fileNameEl = document.getElementById('file-name');
        const desc = document.getElementById('description');
        const descCount = document.getElementById('desc-count');
        const subject = document.getElementById('subject');
        const subjectCount = document.getElementById('subject-count');
        const category = document.getElementById('category');
        const summarySubject = document.getElementById('summary-subject');
        const summaryCategory = document.getElementById('summary-category');
        const summaryPriority = document.getElementById('summary-priority');
        const summaryPriorityDot = document.getElementById('summary-priority-dot');

        function formatBytes(bytes) {
            if (!bytes && bytes !== 0) return '';
            const units = ['B', 'KB', 'MB', 'GB'];
            let i = 0;
            let n = bytes;
            while (n >= 1024 && i < units.length - 1) { n /= 1024; i++; }
            return `${n.toFixed(i === 0 ? 0 : 1)} ${units[i]}`;
        }

        function updateAttachment() {
            const f = attachment?.files?.[0];
            if (!f) {
                fileNameEl?.classList.add('hidden');
                return;
            }
            fileNameEl.textContent = `Fichier sélectionné: ${f.name} (${formatBytes(f.size)})`;
            fileNameEl.classList.remove('hidden');
        }

        function updateCount() {
            if (!descCount || !desc) return;
            descCount.textContent = (desc.value || '').length.toString();
        }

        function updateSubjectCount() {
            if (!subject || !subjectCount) return;
            subjectCount.textContent = (subject.value || '').length.toString();
        }

        function getPriorityValue() {
            const el = document.querySelector('input[name="priority"]:checked');
            return el ? el.value : 'medium';
        }

        function updateSummary() {
            if (summarySubject && subject) {
                const val = (subject.value || '').trim();
                summarySubject.textContent = val.length ? val : '—';
            }
            if (summaryCategory && category) {
                const opt = category.options[category.selectedIndex];
                summaryCategory.textContent = opt ? opt.text.replace(/^[^A-Za-zÀ-ÿ0-9]+/g, '').trim() : 'Catégorie';
            }
            const p = getPriorityValue();
            if (summaryPriority) {
                summaryPriority.textContent =
                    p === 'urgent' ? 'Critique' :
                    p === 'high' ? 'Haute' :
                    p === 'low' ? 'Basse' : 'Normale';
            }
            if (summaryPriorityDot) {
                summaryPriorityDot.className = 'h-2 w-2 rounded-full ' + (
                    p === 'urgent' ? 'bg-rose-500' :
                    p === 'high' ? 'bg-amber-500' :
                    p === 'low' ? 'bg-emerald-500' : 'bg-indigo-500'
                );
            }
        }

        attachment?.addEventListener('change', updateAttachment);
        desc?.addEventListener('input', updateCount);
        subject?.addEventListener('input', updateSubjectCount);
        subject?.addEventListener('input', updateSummary);
        category?.addEventListener('change', updateSummary);
        document.querySelectorAll('input[name="priority"]').forEach((el) => el.addEventListener('change', updateSummary));
        updateAttachment();
        updateCount();
        updateSubjectCount();
        updateSummary();
    })();
</script>
<script>
    function contactCombobox({ items, initialId = '', placeholder = '', allowEmpty = false }) {
        return {
            items: items || [],
            placeholder,
            allowEmpty,
            open: false,
            query: '',
            selectedId: initialId || '',
            highlighted: 0,
            init() {
                const initial = this.items.find(i => String(i.id) === String(this.selectedId));
                this.query = initial ? initial.label : '';
                this.syncSelect();
            },
            get filtered() {
                const q = (this.query || '').toLowerCase().trim();
                if (!q) return this.items.slice(0, 50);
                return this.items
                    .filter(i => (i.label || '').toLowerCase().includes(q))
                    .slice(0, 50);
            },
            toggle() {
                this.open = !this.open;
                if (this.open) this.highlighted = 0;
            },
            select(item) {
                this.selectedId = item.id;
                this.query = item.label;
                this.open = false;
                this.syncSelect();
            },
            clear() {
                this.selectedId = '';
                this.query = '';
                this.open = false;
                this.syncSelect();
            },
            syncSelect() {
                // Find the hidden select in this component scope and set its value.
                const select = this.$root.querySelector('select');
                if (!select) return;
                select.value = this.selectedId;
                select.dispatchEvent(new Event('change', { bubbles: true }));
            },
            highlightNext() {
                if (!this.open) this.open = true;
                this.highlighted = Math.min(this.highlighted + 1, Math.max(this.filtered.length - 1, 0));
            },
            highlightPrev() {
                if (!this.open) this.open = true;
                this.highlighted = Math.max(this.highlighted - 1, 0);
            },
            commitHighlighted() {
                const item = this.filtered[this.highlighted];
                if (item) this.select(item);
            },
        };
    }
</script>
@endpush
@endsection
