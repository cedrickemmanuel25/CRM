@extends('layouts.app')

@section('title', 'Créer une tâche - Nexus CRM')

@section('content')
<style>
    :root {
        --enterprise-bg: #0f172a;
        --enterprise-card: rgba(30, 41, 59, 0.4);
        --enterprise-border: rgba(255, 255, 255, 0.08);
    }

    .saas-card {
        background: var(--enterprise-card);
        backdrop-filter: blur(20px);
        border: 1px solid var(--enterprise-border);
        border-radius: 1.5rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>

<div class="w-full flex flex-col bg-[#0f172a] min-h-screen text-slate-100">
    <div class="px-4 sm:px-6 lg:px-8 py-8 max-w-3xl mx-auto w-full">
        <!-- Breadcrumbs -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-3 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="hover:text-blue-400 transition-colors uppercase">Dashboard</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-slate-800 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 11 7.293 7.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="{{ route('calendar') }}" class="hover:text-blue-400 transition-colors uppercase">Agenda</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-slate-800 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 11 7.293 7.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="text-blue-500 uppercase">Nouvelle tâche</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="saas-card overflow-hidden shadow-2xl">
            <div class="px-8 py-8 border-b border-white/[0.05] bg-white/[0.02] flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white tracking-tight">Nouvelle Tâche</h2>
                    <p class="text-sm text-slate-500 mt-1">Planifiez une action ou un rappel stratégique.</p>
                </div>
                <div class="bg-blue-500/10 p-4 rounded-2xl text-blue-500 border border-blue-500/20 shadow-lg">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>

            <div class="p-8 lg:p-10">
                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf
                    @include('tasks._form', ['users' => $users, 'contacts' => $contacts, 'opportunities' => $opportunities])
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
