@extends('layouts.app')

@section('title', 'Modifier Contact (Standard Entreprise)')

@section('content')
<div class="min-h-screen flex flex-col bg-[#0f172a] text-slate-100 font-sans selection:bg-blue-500/30">
    <style>
        :root {
            --enterprise-bg: #0f172a;
            --enterprise-card: rgba(30, 41, 59, 0.4);
            --enterprise-border: rgba(255, 255, 255, 0.08);
            --enterprise-accent: #3b82f6;
        }

        .saas-card {
            background: var(--enterprise-card);
            backdrop-filter: blur(20px);
            border: 1px solid var(--enterprise-border);
            border-radius: 1.25rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .saas-card:hover {
            border-color: rgba(255, 255, 255, 0.15);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2);
        }

        .label-caps {
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
        }

        .btn-action {
            @apply flex items-center justify-center p-2 rounded-xl transition-all duration-200 border border-white/5;
            background: rgba(255, 255, 255, 0.03);
        }

        .btn-action:hover {
            background: rgba(255, 255, 255, 0.08);
            @apply border-white/10 scale-105;
        }
    </style>

    <!-- Enterprise Command Bar -->
    <div class="bg-slate-900/50 backdrop-blur-xl border-b border-white/5 sticky top-16 z-40">
        <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="min-h-[4rem] py-4 sm:py-0 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <!-- Left: Entity Context -->
                <div class="flex items-center gap-4">
                    <div class="h-9 w-9 sm:h-10 sm:w-10 rounded-xl bg-blue-600 flex-shrink-0 flex items-center justify-center text-white font-black text-lg sm:text-xl shadow-lg shadow-blue-900/40">
                        {{ strtoupper(substr($contact->prenom, 0, 1)) }}
                    </div>
                    <div class="flex flex-col min-w-0">
                        <nav aria-label="Breadcrumb" class="hidden xs:block">
                            <ol class="flex items-center space-x-2 label-caps text-[9px] sm:text-[10px]">
                                <li><a href="{{ route('contacts.index') }}" class="hover:text-blue-400 transition-colors">Répertoire</a></li>
                                <li><svg class="h-3 w-3 opacity-30" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                                <li class="text-slate-500 opacity-60 italic truncate">Modification</li>
                            </ol>
                        </nav>
                        <h1 class="text-base sm:text-lg font-black text-slate-100 tracking-tight leading-none mt-1 uppercase truncate">{{ $contact->prenom }} {{ $contact->nom }}</h1>
                    </div>
                </div>
                
                <!-- Right: Command Actions -->
                <div class="flex items-center justify-start sm:justify-end gap-2 sm:gap-3">
                    <a href="{{ route('contacts.show', $contact) }}" class="px-4 sm:px-5 py-2 sm:py-2.5 text-[10px] sm:text-[11px] font-black uppercase tracking-widest text-slate-400 hover:text-slate-100 hover:bg-white/5 border border-white/5 rounded-xl transition-all">
                        Abandonner
                    </a>
                    <button type="submit" form="edit-contact-form" class="px-5 sm:px-7 py-2 sm:py-2.5 text-[10px] sm:text-[11px] font-black uppercase tracking-widest text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-lg shadow-blue-900/20 transition-all active:scale-95">
                        <span class="sm:hidden">Mettre à jour</span>
                        <span class="hidden sm:inline">METTRE À JOUR LA FICHE</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Professional Workspace Layout -->
    <div class="max-w-[1600px] mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
        <form id="edit-contact-form" action="{{ route('contacts.update', $contact) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('contacts.partials._form')
        </form>
    </div>
</div>
@endsection
