@extends('layouts.app')

@section('title', 'Mes Notifications')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Notifications</h1>
        <div class="flex items-center space-x-4">
            @if(auth()->user()->unreadNotifications->count() > 0)
            <a href="{{ route('notifications.read') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                Tout marquer comme lu
            </a>
            @endif
            @if(auth()->user()->notifications->count() > 0)
            <form action="{{ route('notifications.clear') }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer toutes vos notifications ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-sm text-rose-600 hover:text-rose-800 font-medium">
                    Tout supprimer
                </button>
            </form>
            @endif
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @forelse($notifications as $notification)
                @php
                    $jsonNotif = json_encode([
                        'id' => $notification->id,
                        'read_at' => $notification->read_at,
                        'created_at_human' => $notification->created_at->translatedFormat('d F Y à H:i'),
                        'data' => $notification->data
                    ]);
                @endphp
                <li @click="showNotif({{ $jsonNotif }})" 
                    class="{{ $notification->read_at ? 'bg-white' : 'bg-blue-50' }} hover:bg-gray-50 transition duration-150 ease-in-out relative cursor-pointer">
                    
                    <div class="px-4 py-4 sm:px-6 relative z-10">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    @if(isset($notification->data['type']) && $notification->data['type'] == 'reminder')
                                        <span class="h-8 w-8 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        </span>
                                    @elseif(isset($notification->data['type']) && ($notification->data['type'] == 'new_access_request' || $notification->data['type'] == 'access_request_approved'))
                                        <span class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                                        </span>
                                    @else
                                        <span class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                                        </span>
                                    @endif
                                </div>
                                <p class="text-sm font-bold text-gray-900">
                                    {{ $notification->data['title'] ?? 'Notification' }}
                                </p>
                            </div>
                            <div class="ml-2 flex-shrink-0 flex">
                                <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $notification->read_at ? 'bg-gray-100 text-gray-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $notification->read_at ? 'Lu' : 'Nouveau' }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-2 sm:flex sm:justify-between items-center">
                            <div class="sm:flex flex-col">
                                <p class="text-sm text-gray-600 font-medium">
                                    {{ $notification->data['message'] ?? '' }}
                                </p>
                                <div class="flex items-center space-x-4">
                                    <span class="text-xs text-indigo-600 mt-1 flex items-center">
                                        Voir les détails
                                        <svg class="h-3 w-3 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                    </span>
                                    <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" onsubmit="return confirm('Supprimer cette notification ?')" class="mt-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-rose-500 hover:text-rose-700 flex items-center">
                                            <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="mt-2 flex items-center text-xs text-gray-400 sm:mt-0">
                                <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p>
                                    {{ $notification->created_at->translatedFormat('d F Y à H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </li>
            @empty
            <li class="px-4 py-8 text-center text-gray-500">
                Vous n'avez aucune notification.
            </li>
            @endforelse
        </ul>
        <div class="bg-gray-50 px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $notifications->links() }}
        </div>
    </div>
</div>
@endsection
