@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')
<div class="min-h-[80vh] bg-gray-50/50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            Mon Profil
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Gérez vos informations personnelles et votre sécurité.
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-4xl">
        <div class="bg-white py-8 px-4 shadow-xl rounded-2xl sm:px-10 border border-gray-100">
            <form class="space-y-8" action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Section: Identité -->
                <div>
                    <div class="flex items-center gap-x-3 pb-4 border-b border-gray-100">
                        <div class="p-2 bg-indigo-50 rounded-lg">
                            <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Informations Personnelles</h3>
                            <p class="mt-1 text-sm text-gray-500">Vos coordonnées visibles sur la plateforme.</p>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                        <!-- Avatar Display (Visual only) -->
                        <div class="sm:col-span-2 flex items-center justify-center py-4">
                            <div class="relative">
                                <div class="h-24 w-24 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-3xl font-bold border-4 border-white shadow-md">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <span class="absolute bottom-0 right-0 block h-6 w-6 rounded-full ring-2 ring-white bg-green-400" title="En ligne"></span>
                            </div>
                        </div>

                        <div class="sm:col-span-1">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nom complet</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required 
                                    class="block w-full pr-10 border-gray-300 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg py-3">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="sm:col-span-1">
                            <label for="email" class="block text-sm font-medium text-gray-700">Adresse Email</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required 
                                    class="block w-full pr-10 border-gray-300 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg py-3">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Rôle (Lecture seule)</label>
                            <div class="mt-1">
                                <input type="text" disabled value="{{ ucfirst($user->role) }}" 
                                    class="block w-full border-gray-300 bg-gray-50 text-gray-500 sm:text-sm rounded-lg py-3 cursor-not-allowed">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Sécurité -->
                <div>
                     <div class="flex items-center gap-x-3 pb-4 border-b border-gray-100 mt-8">
                        <div class="p-2 bg-amber-50 rounded-lg">
                            <svg class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Sécurité</h3>
                            <p class="mt-1 text-sm text-gray-500">Mise à jour du mot de passe.</p>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                             <div class="rounded-md bg-amber-50 p-4 border border-amber-100">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-amber-800">Validation requise</h3>
                                        <div class="mt-2 text-sm text-amber-700">
                                            <p>Pour modifier vos informations ou votre mot de passe, vous devez saisir votre mot de passe actuel.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="current_password" class="block text-sm font-medium text-gray-700">Mot de passe actuel <span class="text-red-500">*</span></label>
                            <input type="password" name="current_password" id="current_password" 
                                class="mt-1 block w-full border-gray-300 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg py-3"
                                placeholder="••••••••">
                        </div>

                        <div class="sm:col-span-1">
                            <label for="new_password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                            <input type="password" name="new_password" id="new_password" 
                                class="mt-1 block w-full border-gray-300 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg py-3"
                                placeholder="•••••••• (Optionnel)">
                        </div>

                        <div class="sm:col-span-1">
                            <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer nouveau mot de passe</label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" 
                                class="mt-1 block w-full border-gray-300 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg py-3"
                                placeholder="••••••••">
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-200 flex items-center justify-end gap-3">
                    <button type="button" onclick="history.back()" class="bg-white py-2 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Annuler
                    </button>
                    <button type="submit" class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
