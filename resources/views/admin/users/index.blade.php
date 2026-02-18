@extends('layouts.app')

@section('title', 'Gestion Utilisateurs')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-10 pb-16" 
    x-data="{ 
        openUserModal: false, 
        editMode: false, 
        search: '',
        formData: { name: '', email: '', role: 'commercial', telephone: '' },
        editingId: null,
        
        openCreate() {
            this.editMode = false;
            this.formData = { name: '', email: '', role: 'commercial', telephone: '' };
            this.openUserModal = true;
        },
        
        openEdit(user) {
            this.editMode = true;
            this.editingId = user.id;
            this.formData = { 
                name: user.name, 
                email: user.email, 
                role: user.role, 
                telephone: user.telephone 
            };
            this.openUserModal = true;
        }
    }">
    
    <!-- Hero Section / Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 border-b border-white/5 pb-8">
        <div>
            <h1 class="page-title">Gestion <span class="accent">Utilisateurs</span></h1>
            <p class="text-slate-500 mt-1 text-xs md:text-sm font-medium uppercase tracking-wider">{{ $users->count() }} Comptes enregistrés</p>
        </div>
        <div class="flex items-center gap-3">
            <button @click="openCreate()" class="flex-1 md:flex-none inline-flex items-center justify-center px-6 py-3.5 border border-blue-500/20 rounded-2xl shadow-lg shadow-blue-500/10 text-[10px] font-black uppercase tracking-widest text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300 active:scale-95">
                <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                </svg>
                Nouveau
            </button>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 rounded-[2rem] p-4 md:p-6 shadow-2xl group hover:border-white/10 transition-all duration-300">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 bg-blue-500/10 rounded-xl p-3 md:p-4 border border-blue-500/20 group-hover:scale-110 transition-transform duration-500">
                    <svg class="h-5 w-5 md:h-6 md:w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[8px] md:text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] truncate">Total</p>
                    <p class="text-xl md:text-3xl font-bold text-slate-100 tracking-tight">{{ $users->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 rounded-[2rem] p-4 md:p-6 shadow-2xl group hover:border-white/10 transition-all duration-300">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 bg-indigo-500/10 rounded-xl p-3 md:p-4 border border-indigo-500/20 group-hover:scale-110 transition-transform duration-500">
                    <svg class="h-5 w-5 md:h-6 md:w-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[8px] md:text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] truncate">Admins</p>
                    <p class="text-xl md:text-3xl font-bold text-slate-100 tracking-tight">{{ $users->where('role', 'admin')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 rounded-[2rem] p-4 md:p-6 shadow-2xl group hover:border-white/10 transition-all duration-300">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 bg-emerald-500/10 rounded-xl p-3 md:p-4 border border-emerald-500/20 group-hover:scale-110 transition-transform duration-500">
                    <svg class="h-5 w-5 md:h-6 md:w-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[8px] md:text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] truncate">Ventes</p>
                    <p class="text-xl md:text-3xl font-bold text-slate-100 tracking-tight">{{ $users->where('role', 'commercial')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 rounded-[2rem] p-4 md:p-6 shadow-2xl group hover:border-white/10 transition-all duration-300">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 bg-amber-500/10 rounded-xl p-3 md:p-4 border border-amber-500/20 group-hover:scale-110 transition-transform duration-500">
                    <svg class="h-5 w-5 md:h-6 md:w-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 8.486L5.636 18.364m7.072-7.072a2 2 0 11-2.828-2.828 2 2 0 012.828 2.828z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[8px] md:text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] truncate">Support</p>
                    <p class="text-xl md:text-3xl font-bold text-slate-100 tracking-tight">{{ $users->where('role', 'support')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
        <div class="relative max-w-full md:max-w-md w-full group">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                <svg class="h-5 w-5 text-slate-500 group-focus-within:text-blue-500 transition-colors" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                </svg>
            </div>
            <input type="text" x-model="search" placeholder="Rechercher par nom, email ou rôle..." 
                class="block w-full rounded-2xl border-white/5 bg-slate-900/50 pl-11 py-3.5 text-sm text-slate-200 shadow-inner focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 placeholder:text-slate-600 transition-all backdrop-blur-md">
        </div>
    </div>

    <div class="flex flex-col">
        <!-- Desktop Table View -->
        <div class="hidden md:block -my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden bg-slate-900/40 backdrop-blur-xl border border-white/5 md:rounded-3xl shadow-2xl">
                    <table class="min-w-full divide-y divide-white/5">
                        <thead class="bg-white/[0.02]">
                            <tr>
                                <th scope="col" class="py-5 pl-4 pr-3 text-left text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] sm:pl-8">Utilisateur</th>
                                <th scope="col" class="px-3 py-5 text-left text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Rôle & Accès</th>
                                <th scope="col" class="px-3 py-5 text-left text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Contact</th>
                                <th scope="col" class="px-3 py-5 text-left text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Adhésion</th>
                                <th scope="col" class="px-3 py-5 text-left text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-center">Statut</th>
                                <th scope="col" class="relative py-5 pl-3 pr-4 sm:pr-8 text-right">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody x-data="{
                            startPolling() {
                                this.pollingInterval = setInterval(() => {
                                    if (this.openUserModal) return; 
                                    
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
                        }" x-init="startPolling()" class="divide-y divide-white/5 bg-transparent">
                            @include('admin.users._table_rows')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Mobile Card View -->
        <div class="md:hidden space-y-4">
            @include('admin.users._user_cards')
        </div>
    </div>

    <!-- Modal Create/Edit User -->
    <div x-show="openUserModal" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed z-50 inset-0 overflow-y-auto" style="display: none;">
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-xl transition-opacity" @click="openUserModal = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div x-show="openUserModal"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block align-bottom bg-[#020617] rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-white/10">
                
                <div class="px-4 pt-5 pb-4 sm:p-10">
                    <div class="flex items-center justify-between mb-10">
                        <h3 class="text-2xl font-black text-white tracking-tight uppercase" x-text="editMode ? 'Éditer l\'accès' : 'Nouvel accès'"></h3>
                        <button @click="openUserModal = false" class="p-2 text-slate-500 hover:text-white bg-white/5 rounded-xl transition-all">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <form :action="editMode ? '/admin/users/' + editingId : '{{ route('admin.users.store') }}'" method="POST">
                        @csrf
                        <template x-if="editMode">
                            <input type="hidden" name="_method" value="PUT">
                        </template>
                        @include('admin.users._form')
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

