@extends('layouts.app')

@section('title', 'Nouveau Ticket')

@section('content')
<div class="min-h-screen bg-slate-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="min-w-0 flex-1">
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol role="list" class="flex items-center space-x-2">
                        <li><a href="{{ route('dashboard') }}" class="text-sm font-medium text-slate-500 hover:text-slate-700">Dashboard</a></li>
                        <li><span class="text-slate-400">/</span></li>
                        <li><a href="{{ route('tickets.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-700">Tickets</a></li>
                    </ol>
                </nav>
                <h2 class="text-2xl font-bold leading-7 text-slate-900 sm:truncate sm:text-3xl sm:tracking-tight">Nouveau Ticket</h2>
            </div>
            <div class="mt-4 flex md:ml-4 md:mt-0">
                <a href="{{ route('tickets.index') }}" class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50">
                    Annuler
                </a>
                <button type="submit" form="create-ticket-form" class="ml-3 inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Créer le ticket
                </button>
            </div>
        </div>

        <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data" id="create-ticket-form">
            @csrf
            
            <div class="grid grid-cols-1 gap-x-8 gap-y-8 lg:grid-cols-3">
                
                <!-- Main Content (Left Column) -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Ticket Details Card -->
                    <div class="bg-white shadow-sm ring-1 ring-slate-900/5 sm:rounded-xl">
                        <div class="px-4 py-6 sm:px-6 border-b border-slate-100">
                            <h3 class="text-base font-semibold leading-6 text-slate-900">Détails de la demande</h3>
                            <p class="mt-1 text-sm text-slate-500">Informations principales sur le problème rencontré.</p>
                        </div>
                        <div class="px-4 py-6 sm:p-6 space-y-6">
                            
                            <!-- Subject -->
                            <div>
                                <label for="subject" class="block text-sm font-medium leading-6 text-slate-900">Sujet <span class="text-red-500">*</span></label>
                                <div class="mt-2">
                                    <input type="text" name="subject" id="subject" class="block w-full rounded-md border-0 py-2.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Bref résumé du problème" required>
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium leading-6 text-slate-900">Description <span class="text-red-500">*</span></label>
                                <div class="mt-2">
                                    <textarea id="description" name="description" rows="12" class="block w-full rounded-md border-0 py-2.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 font-mono text-sm" placeholder="Détails complets..." required></textarea>
                                </div>
                                <p class="mt-2 text-sm text-slate-500">Le format Markdown est supporté.</p>
                            </div>

                            <!-- File Upload (Standard) -->
                            <div>
                                <label class="block text-sm font-medium leading-6 text-slate-900">Pièce jointe</label>
                                <div class="mt-2 flex justify-center rounded-lg border border-dashed border-slate-900/25 px-6 py-10 hover:bg-slate-50 transition-colors">
                                    <div class="text-center">
                                        <svg class="mx-auto h-12 w-12 text-slate-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                                        </svg>
                                        <div class="mt-4 flex text-sm leading-6 text-slate-600 justify-center">
                                            <label for="attachment" class="relative cursor-pointer rounded-md bg-transparent font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                                <span>Téléverser un fichier</span>
                                                <input id="attachment" name="attachment" type="file" class="sr-only">
                                            </label>
                                            <p class="pl-1">ou glisser-déposer</p>
                                        </div>
                                        <p class="text-xs leading-5 text-slate-600">PNG, JPG, PDF jusqu'à 5MB</p>
                                        <p id="file-name" class="mt-2 text-sm font-medium text-indigo-600 hidden"></p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Meta Information (Right Column) -->
                <div class="space-y-6">
                    
                    <!-- Properties Card -->
                    <div class="bg-white shadow-sm ring-1 ring-slate-900/5 sm:rounded-xl">
                        <div class="px-4 py-5 sm:p-6 space-y-6">
                            <h3 class="text-base font-semibold leading-6 text-slate-900">Propriétés</h3>

                            <!-- Priority -->
                            <div>
                                <label for="priority" class="block text-sm font-medium leading-6 text-slate-900">Priorité</label>
                                <select id="priority" name="priority" class="mt-2 block w-full rounded-md border-0 py-2.5 pl-3 pr-10 text-slate-900 ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    <option value="low">🟢 Faible</option>
                                    <option value="medium" selected>🔵 Normale</option>
                                    <option value="high">🟠 Élevée</option>
                                    <option value="urgent">🔴 Critique</option>
                                </select>
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category" class="block text-sm font-medium leading-6 text-slate-900">Catégorie</label>
                                <select id="category" name="category" class="mt-2 block w-full rounded-md border-0 py-2.5 pl-3 pr-10 text-slate-900 ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    <option value="technical">Technique</option>
                                    <option value="billing">Facturation</option>
                                    <option value="commercial">Commercial</option>
                                    <option value="feature">Demande de fonctionnalité</option>
                                </select>
                            </div>

                            <!-- Client (Admin/Commercial Only) -->
                            @if(auth()->user()->hasRole(['admin', 'commercial']))
                            <div class="pt-4 border-t border-slate-100">
                                <label for="contact_id" class="block text-sm font-medium leading-6 text-slate-900">Client associé</label>
                                <select id="contact_id" name="contact_id" class="mt-2 block w-full rounded-md border-0 py-2.5 pl-3 pr-10 text-slate-900 ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    <option value="">-- Sélectionner un client --</option>
                                    @foreach($contacts as $contact)
                                        <option value="{{ $contact->id }}">{{ $contact->nom_complet }}</option>
                                    @endforeach
                                </select>
                                <p class="mt-2 text-xs text-slate-500">Lier ce ticket à un dossier client existant.</p>
                            </div>
                            @endif

                        </div>
                    </div>

                    <!-- Info/Help Card -->
                    <div class="bg-indigo-50 shadow-sm ring-1 ring-indigo-900/5 sm:rounded-xl">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-sm font-semibold leading-6 text-indigo-900">Guide rapide</h3>
                            <ul class="mt-4 space-y-3 text-sm text-indigo-800">
                                <li class="flex gap-2">
                                    <span class="font-bold">•</span>
                                    <span>Vérifiez la <strong>Base de Connaissances</strong> avant de créer un ticket.</span>
                                </li>
                                <li class="flex gap-2">
                                    <span class="font-bold">•</span>
                                    <span>Utilisez la priorité <strong>Critique</strong> uniquement en cas d'arrêt total de service.</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('attachment').addEventListener('change', function(e) {
        if (e.target.files[0]) {
            const fileName = e.target.files[0].name;
            const el = document.getElementById('file-name');
            el.textContent = 'Fichier prêt: ' + fileName;
            el.classList.remove('hidden');
        }
    });
</script>
@endsection
