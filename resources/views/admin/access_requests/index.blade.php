@extends('layouts.admin')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-bold text-gray-900">Demandes d'accès</h1>
            <p class="mt-2 text-sm text-gray-700">Liste des personnes ayant demandé la création d'un compte.</p>
        </div>
    </div>

    <div class="mt-8 flex flex-col">
        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Candidat</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email / Tel</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Rôle souhaité</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Date</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody x-data="{
                            pollingInterval: null,
                            startPolling() {
                                this.pollingInterval = setInterval(() => {
                                    fetch(window.location.href, {
                                        headers: { 'X-Requested-With': 'XMLHttpRequest' },
                                        credentials: 'same-origin'
                                    })
                                    .then(response => {
                                        if (response.status === 401) {
                                            clearInterval(this.pollingInterval);
                                            return;
                                        }
                                        if (!response.ok) throw new Error('Network response was not ok');
                                        return response.text();
                                    })
                                    .then(html => {
                                        if (html) {
                                            this.$el.innerHTML = html;
                                        }
                                    })
                                    .catch(error => {
                                        console.warn('Polling error:', error);
                                    });
                                }, 10000);
                            }
                        }" x-init="startPolling()" class="divide-y divide-gray-200 bg-white" x-ref="tbody">
                            @include('admin.access_requests._table_rows')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
