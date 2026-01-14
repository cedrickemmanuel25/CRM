@php
    $mainLinks = [
        ['route' => 'dashboard', 'label' => 'Tableau de bord', 'icon' => 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z'],
        ['route' => 'contacts.index', 'label' => 'Contacts', 'icon' => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z'],
        ['route' => 'opportunities.index', 'label' => 'Opportunités', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],

        ['route' => 'tasks.index', 'label' => 'Tâches', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01'],
        ['route' => 'tickets.index', 'label' => 'Tickets', 'icon' => 'M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z'],
        ['route' => 'reports.export', 'label' => 'Rapports', 'icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z'],
    ];

    $adminLinks = [
        ['route' => 'admin.users.index', 'label' => 'Utilisateurs', 'icon' => 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z'],
        ['route' => 'admin.access-requests.index', 'label' => 'Demandes d\'accès', 'icon' => 'M19 7.5L12 11L5 7.5M12 11V19M4 7L12 3L20 7V17L12 21L4 17V7Z'],
        ['route' => 'admin.audit_logs.index', 'label' => 'Journal d\'audit', 'icon' => 'M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z'],
        ['route' => 'admin.settings', 'label' => 'Paramètres', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
    ];
@endphp

@foreach($mainLinks as $link)
    @php
        $showLink = true;
        if (auth()->user()->isSupport() && $link['route'] === 'opportunities.index') $showLink = false;
        if (auth()->user()->isCommercial() && $link['route'] === 'tickets.index') $showLink = false;
        if (auth()->user()->isAdmin() && in_array($link['route'], ['tickets.index', 'reports.export'])) $showLink = false;
    @endphp
    
    @if($showLink)
    <li>
        <a href="{{ route($link['route']) }}" 
           @click="if (window.innerWidth < 1024) sidebarOpen = false"
           class="group flex items-center gap-x-2.5 rounded-lg py-1.5 px-2.5 text-xs font-medium leading-6 transition-all duration-200 
           {{ request()->routeIs($link['route']) || request()->routeIs($link['route'].'*') 
                ? 'bg-gradient-to-r from-indigo-600 to-blue-600 text-white shadow-md shadow-indigo-500/20 translate-x-1' 
                : 'text-gray-600 hover:text-gray-900 hover:bg-gray-200' }}">
            <svg class="h-5 w-5 shrink-0 transition-transform duration-200 {{ request()->routeIs($link['route']) ? 'scale-110' : 'group-hover:scale-110' }}" 
                 fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $link['icon'] }}" />
            </svg>
            {{ $link['label'] }}
        </a>
    </li>
    @endif
@endforeach

@if(auth()->user()->isAdmin())
<li class="mt-6 mb-3 px-3">
    <span class="text-[10px] font-bold uppercase tracking-widest text-gray-500">Administration</span>
</li>

@foreach($adminLinks as $link)
<li>
    <a href="{{ route($link['route']) }}" 
       @click="if (window.innerWidth < 1024) sidebarOpen = false"
       class="group flex items-center justify-between rounded-lg py-1.5 px-2.5 text-xs font-medium leading-6 transition-all duration-200 
       {{ request()->routeIs($link['route']) || request()->routeIs($link['route'].'*') 
            ? 'bg-gradient-to-r from-indigo-600 to-blue-600 text-white shadow-md shadow-indigo-500/20 translate-x-1' 
            : 'text-gray-600 hover:text-gray-900 hover:bg-gray-200' }}">
        <div class="flex items-center gap-x-2.5">
            <svg class="h-5 w-5 shrink-0 transition-transform duration-200 {{ request()->routeIs($link['route']) ? 'scale-110' : 'group-hover:scale-110' }}" 
                 fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $link['icon'] }}" />
            </svg>
            {{ $link['label'] }}
        </div>
        
        @if($link['route'] === 'admin.access-requests.index')
            @if(isset($pendingAccessCount) && $pendingAccessCount > 0)
                <span class="inline-flex items-center justify-center h-5 w-5 rounded-full bg-rose-500 text-[10px] font-bold text-white ring-2 ring-white">
                    {{ $pendingAccessCount }}
                </span>
            @endif
        @endif
    </a>
</li>
@endforeach
@endif

