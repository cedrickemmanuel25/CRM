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
                                    @php
                                        $type = $notification->data['type'] ?? 'default';
                                        $entity = $notification->data['entity'] ?? 'system';
                                        
                                        $bgColor = match($entity) {
                                            'opportunity' => 'bg-emerald-100 text-emerald-600',
                                            'task' => 'bg-amber-100 text-amber-600',
                                            'report' => 'bg-purple-100 text-purple-600',
                                            'security' => 'bg-rose-100 text-rose-600',
                                            default => 'bg-indigo-100 text-indigo-600'
                                        };
                                    @endphp
                                    <span class="h-10 w-10 rounded-xl flex items-center justify-center {{ $bgColor }}">
                                        @if($entity == 'opportunity')
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        @elseif($entity == 'task')
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                                        @elseif($entity == 'report')
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                                        @elseif($entity == 'security')
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                        @else
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                                        @endif
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900">
                                        {{ $notification->data['title'] ?? 'Notification' }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-0.5">
                                        {{ $notification->created_at->translatedFormat('d F Y à H:i') }}
                                    </p>
                                </div>
                            </div>
                            <div class="ml-2 flex-shrink-0 flex">
                                <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $notification->read_at ? 'bg-gray-100 text-gray-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $notification->read_at ? 'Lu' : 'Nouveau' }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-2 sm:flex sm:justify-between items-center pl-14">
                            <div class="sm:flex flex-col w-full">
                                <p class="text-sm text-gray-600 font-medium">
                                    {{ $notification->data['message'] ?? '' }}
                                </p>
                                
                                <div class="flex items-center space-x-4 mt-2">
                                    @if(isset($notification->data['link']))
                                    <a href="{{ url($notification->data['link']) }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center bg-indigo-50 px-3 py-1.5 rounded-lg transition-colors">
                                        Voir les détails
                                        <svg class="h-3 w-3 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                    </a>
                                    @endif

                                    <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" onsubmit="return confirm('Supprimer cette notification ?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-rose-500 hover:text-rose-700 font-medium flex items-center px-2 py-1.5">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
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
