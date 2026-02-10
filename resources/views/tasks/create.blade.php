@extends('layouts.app')

@section('title', 'Créer une tâche - Nexus CRM')

@section('content')
<div class="px-8 py-8 bg-[#F4F7FC]/30 min-h-screen">
    <div class="max-w-2xl mx-auto">
        <!-- Breadcrumbs -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 text-xs font-bold uppercase tracking-widest">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-slate-400 hover:text-[#4C7CDF]">Dashboard</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 11 7.293 7.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="{{ route('calendar') }}" class="text-slate-400 hover:text-[#4C7CDF]">Agenda</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 11 7.293 7.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="text-slate-600">Nouvelle tâche</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-50 bg-slate-50/50 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-slate-800 tracking-tight">Nouvelle Tâche</h2>
                    <p class="text-sm text-slate-500 mt-1">Planifiez une action ou un rappel</p>
                </div>
                <div class="bg-indigo-100 p-3 rounded-xl text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>

            <div class="p-8">
                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf
                    @include('tasks._form', ['users' => $users, 'contacts' => $contacts, 'opportunities' => $opportunities])
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
