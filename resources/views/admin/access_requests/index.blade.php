@extends('layouts.app')

@section('title', 'Demandes d\'accès')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div class="sm:flex-auto">
            <h1 class="text-4xl font-extrabold tracking-tighter uppercase">
                Demandes <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-500 to-cyan-300">d'accès</span>
            </h1>
            <p class="mt-2 text-sm text-slate-400 font-medium">Gestion des candidatures et demandes de création de compte.</p>
        </div>
    </div>

    <!-- Table Container -->
    <div class="mt-8 flex flex-col">
        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="relative overflow-hidden bg-slate-900/40 backdrop-blur-xl border border-white/10 md:rounded-3xl shadow-2xl group">
                    <!-- Bento Gradient -->
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-600/10 via-transparent to-cyan-500/5 pointer-events-none"></div>
                    
                    <table class="relative z-10 min-w-full divide-y divide-white/5">
                        <thead class="bg-white/[0.02]">
                            <tr>
                                <th scope="col" class="py-5 pl-4 pr-3 text-left text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] sm:pl-8">Candidat</th>
                                <th scope="col" class="px-3 py-5 text-left text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Email / Tel</th>
                                <th scope="col" class="px-3 py-5 text-left text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Rôle souhaité</th>
                                <th scope="col" class="px-3 py-5 text-left text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Date</th>
                                <th scope="col" class="relative py-5 pl-3 pr-4 sm:pr-8">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody x-data="{
                            pollingInterval: null,
                            startPolling() {
                                this.pollingInterval = setInterval(() => {
                                    fetch(window.location.href, {
                                        headers: { 
                                            'X-Requested-With': 'XMLHttpRequest',
                                            'Accept': 'text/html'
                                        },
                                        credentials: 'same-origin'
                                    })
                                    .then(response => {
                                        if (response.status === 419 || response.status === 401) {
                                            clearInterval(this.pollingInterval);
                                            return null;
                                        }
                                        if (response.ok) return response.text();
                                        throw new Error('Request failed');
                                    })
                                    .then(html => {
                                        if (!html) return;
                                        if (html.includes('<tr') && !html.includes('<html')) {
                                            this.$el.innerHTML = html;
                                        } else if (html.includes('Connexion')) {
                                            clearInterval(this.pollingInterval);
                                        }
                                    })
                                    .catch(error => console.warn('Polling error:', error));
                                }, 10000);
                            }
                        }" x-init="startPolling()" class="divide-y divide-white/5 bg-transparent" x-ref="tbody">
                            @include('admin.access_requests._table_rows')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
