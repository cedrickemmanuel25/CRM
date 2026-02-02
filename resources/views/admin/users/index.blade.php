@extends('layouts.app')

@section('title', 'Gestion Utilisateurs')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" 
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
    <div class="md:flex md:items-center md:justify-between mb-8">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate tracking-tight">
                Gestion des Utilisateurs
            </h2>
            <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                <div class="mt-2 flex items-center text-sm text-gray-500">
                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    {{ $users->count() }} Comptes actifs
                </div>
            </div>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
            <button @click="openCreate()" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                Nouvel Utilisateur
            </button>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <div class="bg-white overflow-hidden shadow-sm border border-gray-100 rounded-xl p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-indigo-50 rounded-lg p-3">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Utilisateurs</dt>
                        <dd class="text-lg font-bold text-gray-900">{{ $users->count() }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm border border-gray-100 rounded-xl p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-50 rounded-lg p-3">
                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Administrateurs</dt>
                        <dd class="text-lg font-bold text-gray-900">{{ $users->where('role', 'admin')->count() }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm border border-gray-100 rounded-xl p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-50 rounded-lg p-3">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Commerciaux</dt>
                        <dd class="text-lg font-bold text-gray-900">{{ $users->where('role', 'commercial')->count() }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm border border-gray-100 rounded-xl p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-50 rounded-lg p-3">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 8.486L5.636 18.364m7.072-7.072a2 2 0 11-2.828-2.828 2 2 0 012.828 2.828z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Support Technique</dt>
                        <dd class="text-lg font-bold text-gray-900">{{ $users->where('role', 'support')->count() }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div class="relative max-w-sm w-full group">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                </svg>
            </div>
            <input type="text" x-model="search" placeholder="Rechercher un utilisateur..." 
                class="block w-full rounded-xl border-gray-200 pl-10 py-3 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 sm:text-sm placeholder:text-gray-400 transition-all">
        </div>
    </div>

    <div class="flex flex-col">
        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden shadow-sm border border-gray-200 md:rounded-xl bg-white">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th scope="col" class="py-4 pl-4 pr-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider sm:pl-6">Utilisateur</th>
                                <th scope="col" class="px-3 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Rôle & Accès</th>
                                <th scope="col" class="px-3 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Contact</th>
                                <th scope="col" class="px-3 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Date d'inscription</th>
                                <th scope="col" class="px-3 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Statut</th>
                                <th scope="col" class="relative py-4 pl-3 pr-4 sm:pr-6 text-right">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody x-data="{
                            startPolling() {
                                setInterval(() => {
                                    if (this.openUserModal) return; // Don't poll while modal is open to avoid losing state
                                    
                                    fetch(window.location.href, {
                                        headers: { 'X-Requested-With': 'XMLHttpRequest' },
                                        credentials: 'same-origin'
                                    })
                                    .then(response => {
                                        if (response.ok) return response.text();
                                        throw new Error('Request failed');
                                    })
                                    .then(html => {
                                        // Simple way to check if we got back valid HTML partial
                                        if (html.includes('<tr')) {
                                            this.$el.innerHTML = html;
                                        }
                                    })
                                    .catch(error => console.warn('Polling error:', error));
                                }, 10000); // Polling every 10s is enough for users list
                            }
                        }" x-init="startPolling()" class="divide-y divide-gray-100 bg-white">
                            @include('admin.users._table_rows')
                        </tbody>
                    </table>
                </div>
            </div>
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
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click="openUserModal = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div x-show="openUserModal"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                
                <div class="bg-white px-4 pt-5 pb-4 sm:p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl leading-6 font-bold text-gray-900" x-text="editMode ? 'Modifier l\'utilisateur' : 'Inviter un nouvel utilisateur'"></h3>
                        <button @click="openUserModal = false" class="text-gray-400 hover:text-gray-500 transition-colors">
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

