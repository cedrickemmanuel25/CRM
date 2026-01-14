<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ company_name() }} - @yield('title', 'Tableau de bord')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js for interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- intl-tel-input for phone numbers -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.0/build/css/intlTelInput.css">
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.0/build/js/intlTelInput.min.js"></script>
    <style>
        .iti { width: 100%; }
        .iti__flag-container { z-index: 10; }
        [x-cloak] { display: none !important; }
    </style>
</head>
@php
if (auth()->check()) {
    $user = auth()->user();
    $unreadCount = $user->unreadNotifications()->count();
    $notifData = $user->unreadNotifications()
        ->latest()
        ->limit(5)
        ->get()
        ->map(function($n) {
            return [
                'id' => $n->id,
                'read_at' => $n->read_at,
                'created_at_human' => $n->created_at->translatedFormat('d M H:i'),
                'data' => $n->data
            ];
        })->toArray();
    $pendingAccessCount = $user->isAdmin() ? \App\Models\AccessRequest::pending()->count() : 0;
} else {
    $notifData = [];
    $unreadCount = 0;
    $pendingAccessCount = 0;
}
@endphp
<body class="min-h-screen bg-gray-50" x-data="{ 
    sidebarOpen: false, 
    notifModal: { open: false, title: '', message: '', url: '', date: '', id: null },
    showNotif(notif) {
        this.notifModal = {
            open: true,
            title: notif.data.title || 'Notification',
            message: notif.data.message || '',
            url: notif.data.url || (notif.data.task_id ? '/tasks/' + notif.data.task_id : ''),
            date: notif.created_at_human,
            id: notif.id
        };
        if (!notif.read_at) {
            fetch('/notifications/read/' + notif.id, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            notif.read_at = new Date();
        }
    }
}" 
x-init="sidebarOpen = false"
@close-sidebar.window="sidebarOpen = false">
    @include('layouts.partials._notification_modal')

    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" x-cloak class="relative z-50 lg:hidden" role="dialog" aria-modal="true">
        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/80"></div>

        <div class="fixed inset-0 flex">
            <div x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="relative mr-16 flex w-full max-w-xs flex-1">
                
                <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                    <button type="button" @click="sidebarOpen = false" class="-m-2.5 p-2.5">
                        <span class="sr-only">Fermer la barre latérale</span>
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Sidebar Component (Mobile) -->
                <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-gray-900 px-6 pb-4 ring-1 ring-white/10">
                    <a href="{{ route('dashboard') }}" class="flex h-16 shrink-0 items-center gap-x-3 hover:opacity-80 transition-opacity">
                        <img src="{{ asset('images/logo.png') }}" alt="{{ company_name() }} Logo" class="h-10 w-auto">
                        <span class="text-white font-bold text-xl">{{ company_name() }}</span>
                    </a>
                    <nav class="flex flex-1 flex-col">
                        <ul role="list" class="flex flex-1 flex-col gap-y-7">
                            <li>
                                <ul role="list" class="-mx-2 space-y-1">
                                    @include('layouts.partials.admin_sidebar_links', ['pendingAccessCount' => $pendingAccessCount])
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Static Sidebar for Desktop -->
    <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-[18%] lg:flex-col">
        <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-gray-100 border-r border-gray-200 px-6 pb-4 custom-scrollbar">
            <a href="{{ route('dashboard') }}" class="flex h-16 shrink-0 items-center gap-x-3 mt-4 hover:opacity-80 transition-opacity">
                <img src="{{ asset('images/logo.png') }}" alt="{{ company_name() }} Logo" class="h-10 w-auto">
                <span class="text-gray-900 font-black text-xl tracking-tight">{{ company_name() }}</span>
            </a>

            <nav class="flex flex-1 flex-col mt-4">
                <ul role="list" class="flex flex-1 flex-col gap-y-7">
                     <li>
                        <ul role="list" class="-mx-2 space-y-2">
                            @include('layouts.partials.admin_sidebar_links', ['pendingAccessCount' => $pendingAccessCount])
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <!-- Main ContentArea -->
    <div class="lg:pl-[18%] min-h-screen flex flex-col">
        <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
            <button type="button" @click="sidebarOpen = true" class="-m-2.5 p-2.5 text-gray-700 lg:hidden">
                <span class="sr-only">Ouvrir la barre latérale</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>

            <!-- Topbar Separator -->
            <div class="h-6 w-px bg-gray-200 lg:hidden" aria-hidden="true"></div>

            <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
                <!-- Spacer -->
                <div class="flex-1"></div>
                
                <div class="flex items-center gap-x-4 lg:gap-x-6">
                    <!-- Date Display -->
                    <span class="text-sm font-medium text-gray-600 hidden sm:block bg-gray-100/50 px-3 py-1 rounded-full border border-gray-200 capitalize">
                        {{ now()->translatedFormat('d F Y') }}
                    </span>

                    <!-- Notifications Dropdown -->
                    @include('partials.navbar-notifications')

                    <div class="h-6 w-px bg-gray-200" aria-hidden="true"></div>

                    <!-- Profile dropdown -->
                    <div class="relative" x-data="{ userOpen: false }">
                        <button type="button" @click="userOpen = !userOpen" @click.away="userOpen = false" class="-m-1.5 flex items-center p-1.5" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                            <span class="sr-only">Open user menu</span>
                            <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-indigo-600 font-bold border border-indigo-200">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <span class="hidden lg:flex lg:items-center">
                                <span class="ml-4 text-sm font-semibold leading-6 text-gray-900" aria-hidden="true">{{ auth()->user()->name }}</span>
                                <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </button>
                        <div x-show="userOpen" style="display: none;" class="absolute right-0 z-10 mt-2.5 w-48 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                            <div class="px-3 py-2 border-b border-gray-100 text-center">
                                <p class="text-xs text-gray-500">Compte</p>
                            </div>
                            @if(!auth()->user()->isAdmin())
                            <a href="{{ route('profile.edit') }}" class="block px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-gray-50" role="menuitem" tabindex="-1">Mon Profil</a>
                            @endif
                            <a href="{{ route('notifications.settings') }}" class="block px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-gray-50" role="menuitem" tabindex="-1">Préférences Notifications</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-gray-50" role="menuitem" tabindex="-1">Déconnexion</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            @if(session('success'))
                <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-green-800 text-sm font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>

    @stack('scripts')
</body>
</html>
