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
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold text-gray-900">Utilisateurs</h1>
            <p class="mt-2 text-sm text-gray-700">Liste de tous les comtpes utilisateurs du CRM incluant leurs rôles.</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <button @click="openCreate()" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none sm:w-auto">
                Inviter utilisateur
            </button>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="relative max-w-sm w-full">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                </svg>
            </div>
            <input type="text" x-model="search" placeholder="Rechercher par nom, email ou rôle..." 
                class="block w-full rounded-xl border-gray-300 pl-10 py-2.5 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 sm:text-sm placeholder:text-gray-400">
        </div>
    </div>

    <div class="mt-8 flex flex-col">
        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Nom / Email</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Rôle</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Infos</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Créé le</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Statut</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody x-data="{
                            startPolling() {
                                setInterval(() => {
                                    fetch(window.location.href, {
                                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                                    })
                                    .then(response => response.text())
                                    .then(html => {
                                        this.$el.innerHTML = html;
                                    });
                                }, 5000);
                            }
                        }" x-init="startPolling()" class="divide-y divide-gray-200 bg-white">
                            @include('admin.users._table_rows')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create/Edit User -->
    <div x-show="openUserModal" class="fixed z-10 inset-0 overflow-y-auto" style="display: none;">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="openUserModal = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full sm:p-6">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 text-center mb-4" x-text="editMode ? 'Modifier Utilisateur' : 'Inviter Utilisateur'"></h3>
                    <form :action="editMode ? '/admin/users/' + editingId : '{{ route('admin.users.store') }}'" method="POST">
                        @csrf
                        <input type="hidden" name="_method" :value="editMode ? 'PUT' : 'POST'">
                        @include('admin.users._form')
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
