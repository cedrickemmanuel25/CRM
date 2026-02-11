@extends('layouts.app')

@section('title', 'Logs d\'Audit')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-bold text-gray-900">Logs d'Audit</h1>
            <p class="mt-2 text-sm text-gray-700">Historique des actions sensibles et des événements système.</p>
        </div>
    </div>

    <div class="mt-8">
        <!-- Desktop/Tablet View (Table) -->
        <div class="hidden lg:block">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 sm:pl-6">Date</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium uppercase tracking-wide text-gray-500">Utilisateur</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium uppercase tracking-wide text-gray-500">Action</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium uppercase tracking-wide text-gray-500">Cible</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium uppercase tracking-wide text-gray-500">Détails</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium uppercase tracking-wide text-gray-500">IP</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse($logs as $log)
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-900 sm:pl-6">
                                        {{ $log->created_at->format('d/m/Y H:i:s') }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <div class="flex items-center">
                                            @if($log->user)
                                                <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold mr-2">
                                                    {{ substr($log->user->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="font-medium text-gray-900">{{ $log->user->name }}</div>
                                                    <div class="text-xs text-gray-400">{{ $log->user->email }}</div>
                                                </div>
                                            @else
                                                <span class="italic text-gray-400">Système / Inconnu</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $log->translated_action }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        @if($log->model_type)
                                            <div class="flex flex-col">
                                                <span class="font-medium text-gray-900">{{ $log->translated_model_type }}</span>
                                                <span class="text-xs text-gray-400">ID: {{ $log->model_id }}</span>
                                            </div>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-500 max-w-xs truncate" title="Cliquez pour voir les détails">
                                        <div x-data="{ open: false }">
                                            <button @click="open = true" class="text-indigo-600 hover:text-indigo-900 text-xs">Voir changements</button>
                                            
                                            <!-- Professional Modal/Details -->
                                            @include('admin.audit_logs._details_modal')
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        {{ $log->ip_address }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-3 py-4 text-sm text-gray-500 text-center italic">
                                        Aucun log d'audit trouvé.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile View (Cards) -->
        <div class="lg:hidden space-y-4">
            @forelse($logs as $log)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 space-y-4 transition-all active:scale-[0.98]">
                <!-- Card Header -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        @if($log->user)
                            <div class="h-10 w-10 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 font-bold shadow-sm">
                                {{ substr($log->user->name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-900 leading-tight">{{ $log->user->name }}</h4>
                                <p class="text-[11px] font-medium text-gray-400 truncate max-w-[150px]">{{ $log->user->email }}</p>
                            </div>
                        @else
                            <div class="h-10 w-10 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-900 italic">Système</h4>
                                <p class="text-[11px] font-medium text-gray-400">Action auto</p>
                            </div>
                        @endif
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-gray-100 text-gray-700 border border-gray-200 uppercase tracking-tighter">
                        {{ $log->translated_action }}
                    </span>
                </div>

                <!-- Card Body -->
                <div class="py-3 border-y border-gray-50 space-y-3">
                    <!-- Target Row -->
                    <div class="space-y-1">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Cible</p>
                        <div class="flex items-center gap-1.5 flex-wrap">
                            <span class="text-xs font-semibold text-gray-700">{{ $log->translated_model_type ?? '-' }}</span>
                            @if($log->model_id)
                                <span class="px-1.5 py-0.5 bg-gray-50 text-[10px] text-gray-500 rounded border border-gray-100 font-mono">ID: #{{ $log->model_id }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- IP Row -->
                    <div class="space-y-1">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Adresse IP</p>
                        <div class="bg-gray-50/50 rounded-lg border border-gray-100 p-2">
                            <p class="text-[11px] text-gray-600 font-medium font-mono tracking-tight break-all leading-relaxed">
                                {{ $log->ip_address }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Card Footer/Action -->
                <div class="flex flex-wrap items-center justify-between gap-3 pt-1">
                    <div class="flex flex-col">
                        <div class="flex items-center gap-1.5 text-[11px] text-gray-900 font-medium whitespace-nowrap">
                            <svg class="h-3.5 w-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            {{ $log->created_at->format('d/m/Y') }}
                        </div>
                        <p class="text-[10px] text-gray-400 ml-5">{{ $log->created_at->format('H:i') }} ({{ $log->created_at->diffForHumans() }})</p>
                    </div>
                    
                    <div x-data="{ open: false }" class="flex-shrink-0">
                        <button @click="open = true" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white text-[11px] font-bold rounded-xl shadow-sm shadow-indigo-200 hover:bg-indigo-700 transition-all active:scale-95 whitespace-nowrap">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-width="2"/></svg>
                            Détails
                        </button>
                        
                        <!-- Professional Modal/Details (Shared Partial) -->
                        @include('admin.audit_logs._details_modal')
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 p-12 text-center">
                <p class="text-sm text-gray-500 italic">Aucun log d'audit trouvé.</p>
            </div>
            @endforelse
        </div>
        
        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection
