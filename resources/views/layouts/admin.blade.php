<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-50 overflow-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - {{ company_name() }}</title>
    <link rel="icon" type="image/png" href="{{ company_logo() }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}?v=3">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <!-- intl-tel-input for phone numbers -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.0/build/css/intlTelInput.css">
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.0/build/js/intlTelInput.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .iti { 
            width: 100% !important; 
            direction: ltr !important;
        }
        .iti__flag-container { 
            left: 0 !important; 
            right: auto !important;
            z-index: 10; 
        }
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
                'created_at_human' => $n->created_at->format('d/m H:i'),
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
<body class="h-full overflow-hidden" x-data="{ 
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
}">
    @include('layouts.partials._notification_modal')

    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" class="relative z-50 lg:hidden" role="dialog" aria-modal="true">
        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/80"></div>

        <div class="fixed inset-0 flex">
            <div x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="relative mr-16 flex w-full max-w-xs flex-1">
                
                <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                    <button type="button" @click="sidebarOpen = false" class="-m-2.5 p-2.5 bg-white/20 backdrop-blur-md rounded-full text-white hover:text-gray-200 transition-colors">
                        <span class="sr-only">Fermer la barre latérale</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Sidebar Component (Mobile) -->
                <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-4 ring-1 ring-gray-900/5 shadow-2xl">
                    <div class="flex h-16 shrink-0 items-center gap-x-3 border-b border-gray-50">
                        <img src="{{ company_logo() }}" alt="{{ company_name() }} Logo" class="h-10 w-auto">
                        <span class="text-gray-900 font-black text-xl tracking-tight truncate">{{ company_name() }}</span>
                    </div>

                    <!-- PWA Install Button Mobile -->
                    <button id="pwa-install-btn-mobile" onclick="installPWA()" style="display: none;" class="mt-2 mb-4 flex items-center justify-center gap-2 gradient-primary text-white px-3 py-3 rounded-xl text-sm font-bold transition-all shadow-lg shadow-blue-200/50 transform active:scale-95">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Installer l'App
                    </button>
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
            <a href="{{ route('admin.dashboard') }}" class="flex h-16 shrink-0 items-center gap-x-3 mt-4 hover:opacity-80 transition-opacity whitespace-nowrap overflow-hidden">
                <img src="{{ company_logo() }}" alt="{{ company_name() }} Logo" class="h-10 w-auto shrink-0">
                <span class="text-gray-900 font-black text-xl tracking-tight truncate">{{ company_name() ?: 'CRM Pro' }}</span>
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

    <!-- Main Content -->
    <div class="lg:fixed lg:inset-y-0 lg:right-0 lg:w-[82%] h-full flex flex-col">
        <div class="flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
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
                    <span class="text-sm font-medium text-gray-600 hidden sm:block bg-gray-100/50 px-3 py-1 rounded-full border border-gray-200">
                        {{ now()->format('d/m/Y') }}
                    </span>

                    <!-- Notifications Dropdown -->
                    <!-- Notifications Dropdown -->
                    @include('partials.navbar-notifications')

                    <div class="h-6 w-px bg-gray-200" aria-hidden="true"></div>

                    <!-- Profile dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button type="button" @click="open = !open" @click.away="open = false" class="-m-1.5 flex items-center p-1.5" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                            <span class="sr-only">Open user menu</span>
                            @if(auth()->user()->avatar)
                                <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}">
                            @else
                                <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-indigo-600 font-bold border border-indigo-200">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            @endif
                            <span class="hidden lg:flex lg:items-center">
                                <span class="ml-4 text-sm font-semibold leading-6 text-gray-900" aria-hidden="true">{{ auth()->user()->name }}</span>
                                <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </button>
                        <div x-show="open" style="display: none;" class="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                            <div class="px-3 py-2 border-b border-gray-100">
                                <p class="text-xs text-gray-500">Compte</p>
                            </div>
                            <a href="{{ auth()->user()->isAdmin() ? route('admin.profile.edit') : route('profile.edit') }}" class="block px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-gray-50" role="menuitem" tabindex="-1">Mon Profil</a>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.settings') }}" class="block px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-gray-50 font-bold border-t border-gray-100" role="menuitem" tabindex="-1">Paramètres Système</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-gray-50" role="menuitem" tabindex="-1" id="user-menu-item-1">Déconnexion</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="@yield('wrapper_class', 'flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 custom-scrollbar')">
        @if (session('success'))
            <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-green-800 text-sm font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-red-800 text-sm font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="text-red-800 text-sm font-medium mb-1">Veuillez corriger les erreurs suivantes :</p>
                        <ul class="list-disc list-inside text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')
    </div>
    </div>
    <!-- iOS Install Guide Modal -->
    <div id="ios-install-modal" class="fixed inset-0 z-[60] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900/75 transition-opacity"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
                    <div>
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100">
                            <img src="{{ company_logo() }}" alt="App Icon" class="h-8 w-8 rounded-lg">
                        </div>
                        <div class="mt-3 text-center sm:mt-5">
                            <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Installer {{ company_name() }} sur iPhone</h3>
                            <div class="mt-2 text-left">
                                <p class="text-sm text-gray-500 mb-4">Suivez ces étapes simples :</p>
                                <ol class="text-sm text-gray-600 list-decimal pl-5 space-y-3">
                                    <li>Appuyez sur le bouton <strong>Partager</strong> <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/Apple_Share_Icon.png/1200px-Apple_Share_Icon.png" class="inline h-5 w-5 mx-1 align-baseline" alt="Share"> en bas de votre écran.</li>
                                    <li>Faites défiler vers le bas et appuyez sur <strong>"Sur l'écran d'accueil"</strong> <svg class="inline h-5 w-5 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>.</li>
                                    <li>Appuyez sur <strong>Ajouter</strong> en haut à droite.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-6">
                        <button type="button" onclick="document.getElementById('ios-install-modal').classList.add('hidden')" class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Compris</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Android/Generic Install Guide Modal -->
    <div id="android-install-modal" class="fixed inset-0 z-[60] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900/75 transition-opacity"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
                    <div>
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100">
                            <img src="{{ company_logo() }}" alt="App Icon" class="h-8 w-8 rounded-lg">
                        </div>
                        <div class="mt-3 text-center sm:mt-5">
                            <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Installer {{ company_name() }}</h3>
                            <div class="mt-2 text-left">
                                <p class="text-sm text-gray-500 mb-4">Si l'installation automatique ne démarre pas :</p>
                                <ol class="text-sm text-gray-600 list-decimal pl-5 space-y-3">
                                    <li>Appuyez sur le menu du navigateur (<strong>⋮</strong> ou <strong>☰</strong>).</li>
                                    <li>Cherchez l'option <strong>"Installer l'application"</strong> ou <strong>"Ajouter à l'écran d'accueil"</strong>.</li>
                                    <li>Suivez les instructions à l'écran.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-6">
                        <button type="button" onclick="document.getElementById('android-install-modal').classList.add('hidden')" class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Compris</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @stack('scripts')
    <script>
        // Service Worker Registration
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register("{{ asset('service-worker.js') }}");
            });
        }

        // PWA Robust Install Logic
        let deferredPrompt;
        const installBtnMobile = document.getElementById('pwa-install-btn-mobile');
        const iosModal = document.getElementById('ios-install-modal');
        const androidModal = document.getElementById('android-install-modal');

        const isIos = () => /iphone|ipad|ipod/.test(window.navigator.userAgent.toLowerCase());
        const isMobile = () => /android|iphone|ipad|ipod/.test(window.navigator.userAgent.toLowerCase());
        const isInStandaloneMode = () => ('standalone' in window.navigator && window.navigator.standalone) || (window.matchMedia('(display-mode: standalone)').matches);

        // Always show button on mobile if not standalone
        if (isMobile() && !isInStandaloneMode() && installBtnMobile) {
            installBtnMobile.style.display = 'flex';
            
            // Default Click Handler (Fallback)
            installBtnMobile.onclick = function() {
                if (isIos()) {
                    iosModal.classList.remove('hidden');
                } else {
                    if (deferredPrompt) {
                        deferredPrompt.prompt();
                        deferredPrompt.userChoice.then((choiceResult) => {
                            deferredPrompt = null;
                        });
                    } else {
                        androidModal.classList.remove('hidden');
                    }
                }
            };
        }

        // Capture event
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            // Update click handler to use the prompt
            if (installBtnMobile) {
                installBtnMobile.onclick = function() {
                    deferredPrompt.prompt();
                    deferredPrompt.userChoice.then((choiceResult) => {
                        deferredPrompt = null;
                    });
                };
            }
        });
    </script>
</body>
</html>
