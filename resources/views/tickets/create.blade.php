@extends('layouts.app')

@section('title', 'Nouveau Ticket - Nexus CRM')

@section('content')
<div class="min-h-screen bg-[#FDFDFD] p-6 relative overflow-hidden">
    <!-- Background Decor (Subtle & Premium) -->
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-[500px] h-[500px] bg-gradient-to-br from-indigo-50/50 to-purple-50/50 rounded-full blur-3xl opacity-60 -z-10 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[400px] h-[400px] bg-gradient-to-tr from-blue-50/50 to-indigo-50/50 rounded-full blur-3xl opacity-60 -z-10 pointer-events-none"></div>

    <div class="max-w-6xl mx-auto space-y-8 animate-fade-in-up">
        
        <!-- Header Utility -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <nav class="flex mb-1" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2">
                        <li>
                            <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-indigo-600 transition-colors">
                                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117.414 10.707l-7 7a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-5.293-5.293a1 1 0 010-1.414z" clip-rule="evenodd" transform="scale(-1, 1) translate(-20, 0)" />
                                </svg>
                            </a>
                        </li>
                        <li>
                            <span class="text-gray-300">/</span>
                        </li>
                        <li>
                            <a href="{{ route('tickets.index') }}" class="text-sm font-medium text-gray-500 hover:text-indigo-600 transition-colors">Tickets</a>
                        </li>
                        <li>
                            <span class="text-gray-300">/</span>
                        </li>
                        <li>
                            <span class="text-sm font-semibold text-gray-800">Nouveau</span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Nouvelle Demande</h1>
                <p class="text-sm text-gray-500 mt-1">Détaillez votre problème pour une assistance rapide.</p>
            </div>
            
            <div class="hidden sm:block">
               <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 ring-1 ring-inset ring-indigo-700/10">
                   Support 24/7
               </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Main Form Column (2/3) -->
            <div class="lg:col-span-2">
                <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="bg-white/80 backdrop-blur-xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 rounded-2xl overflow-hidden transition-shadow hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)]">
                        <div class="p-8 space-y-10">
                            
                            <!-- Information Section -->
                            <section>
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="h-8 w-8 rounded-lg bg-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-600/20">
                                        <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900">Informations Clés</h3>
                                </div>
                                
                                <div class="space-y-6">
                                    <!-- Sujet -->
                                    <div class="group">
                                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-indigo-600 transition-colors">Sujet de la demande <span class="text-red-500">*</span></label>
                                        <input type="text" name="subject" id="subject" required
                                            class="block w-full rounded-xl border-gray-200 bg-gray-50/50 p-3 text-gray-900 placeholder:text-gray-400 focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all shadow-sm"
                                            placeholder="Ex: Erreur lors de l'export PDF...">
                                    </div>

                                    <!-- Priorité (Visual Selector Premium) -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-3">Niveau d'urgence <span class="text-red-500">*</span></label>
                                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                            @foreach([
                                                'low' => ['label' => 'Faible', 'icon' => '🟢', 'desc' => 'Info', 'color' => 'peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-700'],
                                                'medium' => ['label' => 'Normal', 'icon' => '🔵', 'desc' => 'Standard', 'color' => 'peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700'],
                                                'high' => ['label' => 'Élevé', 'icon' => '🟠', 'desc' => 'Bloquant', 'color' => 'peer-checked:border-orange-500 peer-checked:bg-orange-50 peer-checked:text-orange-700'],
                                                'urgent' => ['label' => 'Critique', 'icon' => '🔴', 'desc' => 'H.S.', 'color' => 'peer-checked:border-rose-500 peer-checked:bg-rose-50 peer-checked:text-rose-700']
                                            ] as $val => $style)
                                            <label class="relative flex flex-col items-center justify-center gap-1 cursor-pointer rounded-xl border border-gray-200 bg-white p-4 shadow-sm hover:border-gray-300 hover:bg-gray-50 transition-all {{ $style['color'] }}">
                                                <input type="radio" name="priority" value="{{ $val }}" class="peer sr-only" {{ $val === 'medium' ? 'checked' : '' }}>
                                                <span class="text-xl filter drop-shadow-sm">{{ $style['icon'] }}</span>
                                                <span class="text-sm font-bold mt-1">{{ $style['label'] }}</span>
                                                <span class="text-[10px] uppercase tracking-wider font-semibold opacity-60">{{ $style['desc'] }}</span>
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Grid for Categories & Client -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Catégorie -->
                                        <div>
                                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
                                            <div class="relative">
                                                <select id="category" name="category" class="block w-full rounded-xl border-gray-200 bg-gray-50/50 p-3 pr-10 text-gray-900 focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all appearance-none shadow-sm cursor-pointer">
                                                    <option value="technical">🔧 Technique / Panne</option>
                                                    <option value="billing">💳 Facturation</option>
                                                    <option value="commercial">🤝 Commercial</option>
                                                    <option value="feature">💡 Suggestion</option>
                                                </select>
                                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                                </div>
                                            </div>
                                        </div>

                                        @if(auth()->user()->hasRole(['admin', 'commercial']))
                                        <div>
                                            <label for="contact_id" class="block text-sm font-medium text-gray-700 mb-2">Client concerné</label>
                                            <div class="relative">
                                                <select id="contact_id" name="contact_id" class="block w-full rounded-xl border-gray-200 bg-gray-50/50 p-3 pr-10 text-gray-900 focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all appearance-none shadow-sm cursor-pointer">
                                                    <option value="">Sélectionner un client...</option>
                                                    @foreach($contacts as $contact)
                                                        <option value="{{ $contact->id }}">{{ $contact->nom_complet }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </section>

                            <div class="w-full h-px bg-gray-100"></div>

                            <!-- Details Section -->
                            <section>
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="h-8 w-8 rounded-lg bg-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-600/20">
                                        <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900">Détails & Preuves</h3>
                                </div>

                                <div class="space-y-6">
                                    <!-- Description -->
                                    <div class="relative">
                                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description détaillée <span class="text-red-500">*</span></label>
                                        <textarea id="description" name="description" rows="6" required 
                                            class="block w-full rounded-xl border-gray-200 bg-gray-50/50 p-4 text-gray-900 placeholder:text-gray-400 focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all shadow-sm resize-y" 
                                            placeholder="1. Contexte du problème&#10;2. Étapes pour reproduire&#10;3. Résultat attendu"></textarea>
                                        <div class="absolute bottom-3 right-3 text-xs text-gray-400 font-medium">Markdown supporté</div>
                                    </div>

                                    <!-- Premium File Upload -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Pièce jointe</label>
                                        <label class="relative flex flex-col items-center justify-center w-full h-32 rounded-xl border-2 border-dashed border-gray-300 bg-gray-50/30 hover:bg-indigo-50/30 hover:border-indigo-400 transition-all cursor-pointer group overflow-hidden">
                                            <div class="absolute inset-0 bg-indigo-500/0 group-hover:bg-indigo-500/5 transition-colors"></div>
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6 relative z-10" id="upload_ui">
                                                <div class="p-2 mb-2 rounded-full bg-white shadow-sm ring-1 ring-gray-200 group-hover:ring-indigo-300 transition-all">
                                                    <svg class="w-6 h-6 text-gray-400 group-hover:text-indigo-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                                    </svg>
                                                </div>
                                                <p class="mb-1 text-sm text-gray-500 group-hover:text-gray-700 font-medium"><span class="font-bold text-indigo-600">Cliquez pour téléverser</span> ou glissez-déposez</p>
                                                <p class="text-xs text-gray-400">SVG, PNG, JPG ou PDF (MAX. 5MB)</p>
                                            </div>
                                            <div id="file_preview" class="hidden flex-col items-center z-20">
                                                <span class="text-3xl mb-2">📄</span>
                                                <p class="text-sm font-semibold text-indigo-700 truncate max-w-[200px]" id="preview_name"></p>
                                                <p class="text-xs text-indigo-500 mt-1">Fichier sélectionné</p>
                                            </div>
                                            <input id="attachment" name="attachment" type="file" class="hidden" />
                                        </label>
                                    </div>
                                </div>
                            </section>
                        </div>
                        
                        <!-- Footer Action Bar -->
                        <div class="bg-gray-50/80 px-8 py-6 flex items-center justify-between border-t border-gray-100 backdrop-blur-sm">
                            <a href="{{ route('tickets.index') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-800 transition-colors">
                                Annuler
                            </a>
                            <button type="submit" class="group inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-8 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-600/20 hover:bg-slate-800 hover:shadow-indigo-600/40 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-all hover:-translate-y-0.5">
                                <span>Créer le ticket</span>
                                <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Context Sidebar (1/3) -->
            <div class="space-y-6">
                
                <!-- Helper Widget - Glassmorphism -->
                <div class="rounded-2xl bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-amber-50 to-orange-50 rounded-bl-full -mr-4 -mt-4 -z-10"></div>
                    
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                        Conseils Pro
                    </h3>
                    <ul class="space-y-4">
                        <li class="flex gap-3 items-start group">
                            <div class="flex-shrink-0 w-6 h-6 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center text-xs font-bold mt-0.5 group-hover:bg-amber-100 transition-colors">1</div>
                            <p class="text-sm text-gray-600 leading-snug">Soyez <span class="font-semibold text-gray-900">le plus précis possible</span> dans le titre pour accélérer le tri.</p>
                        </li>
                        <li class="flex gap-3 items-start group">
                            <div class="flex-shrink-0 w-6 h-6 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center text-xs font-bold mt-0.5 group-hover:bg-amber-100 transition-colors">2</div>
                            <p class="text-sm text-gray-600 leading-snug">Une <span class="font-semibold text-gray-900">capture d'écran</span> vaut 1000 mots. N'hésitez pas à en joindre une.</p>
                        </li>
                        <li class="flex gap-3 items-start group">
                            <div class="flex-shrink-0 w-6 h-6 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center text-xs font-bold mt-0.5 group-hover:bg-amber-100 transition-colors">3</div>
                            <p class="text-sm text-gray-600 leading-snug">Utilisez le niveau <span class="font-bold text-rose-600">Critique</span> uniquement si toute activité est bloquée.</p>
                        </li>
                    </ul>
                </div>

                <!-- Contact Widget -->
                <div class="rounded-2xl bg-gradient-to-br from-indigo-600 to-violet-600 p-6 text-white shadow-xl shadow-indigo-600/20 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -mr-16 -mt-16 group-hover:bg-white/20 transition-all duration-500"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-black/10 rounded-full blur-xl -ml-12 -mb-12"></div>
                    
                    <h3 class="text-lg font-bold mb-2 relative z-10">Besoin d'aide urgente ?</h3>
                    <p class="text-indigo-100 text-sm mb-6 relative z-10 leading-relaxed">Notre équipe support est disponible par email pour les cas d'extrême urgence.</p>
                    
                    <a href="mailto:support@ya-consulting.com" class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 px-4 py-2 rounded-lg text-sm font-semibold transition-all backdrop-blur-sm relative z-10 border border-white/10">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        support@ya-consulting.com
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    const fileInput = document.getElementById('attachment');
    const uploadUi = document.getElementById('upload_ui');
    const filePreview = document.getElementById('file_preview');
    const previewName = document.getElementById('preview_name');

    fileInput.addEventListener('change', function(e) {
        if (e.target.files[0]) {
            uploadUi.classList.add('hidden');
            filePreview.classList.remove('hidden');
            filePreview.classList.add('flex');
            previewName.textContent = e.target.files[0].name;
        }
    });

    // Optional: Drag and drop visual feedback
    const dropZone = document.querySelector('label[for="attachment"]'); // Assuming the label wraps the input
    // Add dragover/dragleave event listeners here if desired for extra polish
</script>
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.4s ease-out forwards;
    }
</style>
@endsection
