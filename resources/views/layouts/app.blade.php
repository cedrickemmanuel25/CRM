<html lang="fr" class="h-full bg-[#030712]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ company_name() }} - @yield('title', 'Tableau de bord')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ company_logo() }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}?v=4">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;500;800&display=swap" rel="stylesheet">
    
    <!-- intl-tel-input for phone numbers -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.0/build/css/intlTelInput.css">
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.0/build/js/intlTelInput.min.js"></script>

    <style>
        :root { --accent: #3b82f6; --neon: #00f2ff; --bg: #030712; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: var(--bg); color: white; }

        .iti { width: 100% !important; direction: ltr !important; }
        .iti__flag-container { left: 0 !important; right: auto !important; z-index: 10; }
        .iti__selected-flag { background: rgba(255, 255, 255, 0.05) !important; border-radius: 0.5rem 0 0 0.5rem !important; }
        .iti__country-list { background-color: #0a0f1d !important; border: 1px solid rgba(255, 255, 255, 0.1) !important; color: white !important; }
        .iti__country:hover { background-color: rgba(255, 255, 255, 0.05) !important; }

        .glass-sidebar {
            background: rgba(255, 255, 255, 0.01);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }

        .glass-topbar {
            background: rgba(3, 7, 18, 0.7);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 10px; }

        [x-cloak] { display: none !important; }

        /* Utilities */
        .text-gradient {
            background: linear-gradient(to r, #3b82f6, #00f2ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
@php
if (auth()->check()) {
    $user = auth()->user();
    $unreadCount = $user->unreadNotifications()->count();
    $notifData = $user->unreadNotifications()->latest()->limit(5)->get()->map(function($n) {
        return [
            'id' => $n->id,
            'read_at' => $n->read_at,
            'created_at_human' => $n->created_at->translatedFormat('d M à H:i'),
            'data' => $n->data
        ];
    })->toArray();
    $pendingAccessCount = $user->isAdmin() ? \App\Models\AccessRequest::pending()->count() : 0;
} else {
    $notifData = []; $unreadCount = 0; $pendingAccessCount = 0;
}
@endphp
<body class="h-full overflow-y-auto selection:bg-cyan-500 selection:text-white" x-data="{ 
    sidebarOpen: false, 
    notifModal: { open: false, title: '', message: '', url: '', date: '', id: null },
    unreadCount: {{ $unreadCount }},
    pendingAccessCount: {{ $pendingAccessCount }},
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
            this.unreadCount = Math.max(0, this.unreadCount - 1);
        }
    },
    pollStats() {
        fetch('{{ route('notifications.fetch') }}', { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
            .then(response => response.json()).then(data => { this.unreadCount = data.count; });
        @if(auth()->check() && auth()->user()->isAdmin())
        fetch('{{ route('admin.access-requests.stats') }}', { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
            .then(response => response.json()).then(data => { this.pendingAccessCount = data.count; });
        @endif
    }
}" x-init="setInterval(() => pollStats(), 30000)">
    @include('layouts.partials._notification_modal')

    <!-- Mobile Sidebar -->
    <div x-show="sidebarOpen" x-cloak class="relative z-[100] lg:hidden">
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity"></div>
        <div class="fixed inset-0 flex">
            <div x-show="sidebarOpen" class="relative flex w-full max-w-xs flex-1">
                <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-[#030712] border-r border-white/10 px-6 pb-4">
                    <div class="flex h-16 shrink-0 items-center justify-between">
                        <div class="flex items-center gap-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-cyan-400 rounded-lg flex items-center justify-center rotate-3">
                                <img src="{{ company_logo() }}" class="h-6 w-auto brightness-0 invert">
                            </div>
                            <span class="text-white font-black text-xl tracking-tighter uppercase">{{ company_name() }}</span>
                        </div>
                        <button @click="sidebarOpen = false" class="text-slate-400 hover:text-white">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>
                    <nav class="flex flex-1 flex-col">
                        <ul role="list" class="flex flex-1 flex-col gap-y-7">
                            <li><ul role="list" class="-mx-2 space-y-1">
                                @include('layouts.partials.admin_sidebar_links', ['pendingAccessCount' => $pendingAccessCount, 'isMobile' => true])
                            </ul></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Desktop Sidebar -->
    <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:flex-col lg:w-[18%] transition-all duration-300">
        <div class="flex grow flex-col gap-y-5 overflow-y-auto glass-sidebar px-4 pb-4 custom-scrollbar">
            <a href="{{ route('dashboard') }}" class="flex h-20 shrink-0 items-center mt-4 gap-x-3 px-2">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-cyan-400 rounded-xl flex items-center justify-center rotate-3 shadow-lg shadow-blue-500/20">
                    <img src="{{ company_logo() }}" class="h-8 w-auto brightness-0 invert">
                </div>
                <span class="text-white font-black text-xl tracking-tighter uppercase leading-none">{{ company_name() ?: 'CRM Pro' }}</span>
            </a>
            <nav class="flex flex-1 flex-col mt-4">
                <ul role="list" class="flex flex-1 flex-col gap-y-7">
                    <li><ul role="list" class="space-y-2 -mx-2">
                        @include('layouts.partials.admin_sidebar_links', ['pendingAccessCount' => $pendingAccessCount, 'isMobile' => false])
                    </ul></li>
                </ul>
            </nav>
        </div>
    </div>

    <!-- Main Wrapper -->
    <div class="flex flex-col transition-all duration-300 min-h-full lg:pl-[18%]">
        <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 glass-topbar px-4 sm:gap-x-6 sm:px-6 lg:px-8">
            <button type="button" @click="sidebarOpen = true" class="-m-2.5 p-2.5 text-slate-400 lg:hidden">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7" /></svg>
            </button>
            <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
                <div class="flex-1"></div>
                <div class="flex items-center gap-x-4 lg:gap-x-6">
                    <span class="text-[10px] font-black tracking-widest text-slate-500 uppercase hidden sm:block">
                        {{ now()->translatedFormat('l d F Y') }}
                    </span>
                    @include('partials.navbar-notifications')
                    <div class="h-6 w-px bg-white/5"></div>
                    <div class="flex items-center gap-3">
                        <div class="h-9 w-9 rounded-xl bg-gradient-to-br from-blue-600/20 to-cyan-400/20 border border-white/10 flex items-center justify-center text-cyan-400 font-black shadow-inner" style="{{ auth()->user()->avatar ? 'background-image: url(' . asset('storage/' . auth()->user()->avatar) . '); background-size: cover;' : '' }}">
                            {{ auth()->user()->avatar ? '' : substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <span class="hidden lg:block text-xs font-bold text-slate-300 uppercase tracking-wider">{{ auth()->user()->name }}</span>
                    </div>
                </div>
            </div>
        </div>

        <main class="flex-1 p-6 lg:p-10">
            @if(session('success'))
                <div class="mb-6 bg-emerald-500/10 border border-emerald-500/20 p-4 rounded-2xl flex items-center gap-4">
                    <div class="w-8 h-8 bg-emerald-500/20 rounded-lg flex items-center justify-center text-emerald-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="text-emerald-400 text-xs font-bold uppercase tracking-wide">{{ session('success') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-rose-500/10 border border-rose-500/20 p-4 rounded-2xl">
                    <div class="flex items-center gap-4 mb-3">
                        <div class="w-8 h-8 bg-rose-500/20 rounded-lg flex items-center justify-center text-rose-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <p class="text-rose-400 text-xs font-bold uppercase tracking-wide">Erreur de validation</p>
                    </div>
                    <ul class="list-disc list-inside text-rose-300/80 text-xs space-y-1 ml-12">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>
