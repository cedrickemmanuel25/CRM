@extends('layouts.app')

@section('title', 'Support - Nexus CRM')

@section('content')
<style>
    :root {
        --saas-bg: #0f172a;
        --saas-card: rgba(30, 41, 59, 0.4);
        --saas-border: rgba(255, 255, 255, 0.08);
    }

    .saas-card {
        background: var(--saas-card);
        backdrop-filter: blur(20px);
        border: 1px solid var(--saas-border);
        border-radius: 1rem;
        transition: all 0.3s ease;
    }

    .saas-card:hover { border-color: rgba(255, 255, 255, 0.12); transform: translateY(-2px); }

    .label-caps {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #64748b;
        margin-bottom: 0.75rem;
        display: block;
    }

    .metric-value {
        font-size: 2.25rem;
        font-weight: 700;
        color: #f1f5f9;
        letter-spacing: -0.025em;
    }

    .btn-action {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #94a3b8;
        font-size: 11px;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-action:hover { background: #fff; color: #0f172a; border-color: #fff; }

    .saas-scroll::-webkit-scrollbar { width: 4px; }
    .saas-scroll::-webkit-scrollbar-track { background: transparent; }
    .saas-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
</style>

<div class="max-w-[1400px] mx-auto space-y-10 pb-16" x-data="{ openTicketModal: false }">
    <!-- Support Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 pb-6 border-b border-white/5">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-white">Console Support</h1>
            <p class="text-slate-500 text-sm mt-1 font-medium">Gestion des tickets et assistance client en temps réel</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('support.reports.pdf', ['period' => 'day']) }}" class="btn-action px-6 py-2.5 rounded-lg flex items-center gap-2">Rapports PDF</a>
            <button @click="openTicketModal = true" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg text-xs font-bold hover:bg-blue-500 transition-all shadow-lg shadow-blue-600/20">Nouveau Ticket</button>
        </div>
    </div>

    <!-- Primary KPIs -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="saas-card p-6">
            <span class="label-caps">Nouveaux Tickets</span>
            <span class="metric-value">{{ $data['kpis']['tickets_new'] ?? 0 }}</span>
        </div>
        <div class="saas-card p-6 border-l-2 border-l-blue-500/50">
            <span class="label-caps font-bold">En Traitement</span>
            <span class="metric-value text-blue-400">{{ $data['kpis']['tickets_in_progress'] ?? 0 }}</span>
        </div>
        <div class="saas-card p-6 border-l-2 border-l-rose-500/50">
            <span class="label-caps text-rose-500/70">Urgences</span>
            <span class="metric-value text-rose-500">{{ $data['kpis']['tickets_urgent'] ?? 0 }}</span>
        </div>
        <div class="saas-card p-6">
            <span class="label-caps">Capacité Résolue</span>
            <span class="metric-value text-emerald-400">{{ $data['kpis']['resolved_today'] ?? 0 }}</span>
        </div>
    </div>

    <!-- Analytics & Breakdown -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Status Analysis -->
        <div class="lg:col-span-2 saas-card p-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-lg font-bold text-slate-200">Volume par Statut</h3>
                    <p class="text-xs text-slate-500 mt-1">État actuel de la file d'attente</p>
                </div>
            </div>
            <div id="supportStatusChart" class="h-80"></div>
        </div>

        <!-- Priority Matrix -->
        <div class="saas-card p-8 bg-slate-900/40">
            <h3 class="label-caps mb-8">Focus Priorités</h3>
            <div class="space-y-6">
                @php
                    $priorityData = $data['charts']['ticket_priority'] ?? [];
                    $totalPriority = array_sum($priorityData) ?: 1;
                @endphp
                @foreach(['urgent', 'high', 'medium', 'low'] as $priority)
                    @php
                        $count = $priorityData[$priority] ?? 0;
                        $percentage = round(($count / $totalPriority) * 100);
                        $colorClass = ['urgent' => 'bg-rose-500', 'high' => 'bg-blue-400', 'medium' => 'bg-blue-600/40', 'low' => 'bg-slate-700'][$priority];
                        $labelColor = ['urgent' => 'text-rose-500', 'high' => 'text-blue-400', 'medium' => 'text-slate-400', 'low' => 'text-slate-500'][$priority];
                    @endphp
                    <div>
                        <div class="flex justify-between text-[11px] font-bold mb-2">
                            <span class="{{ $labelColor }} uppercase tracking-widest">{{ $priority }}</span>
                            <span class="text-white">{{ $percentage }}%</span>
                        </div>
                        <div class="h-1.5 w-full bg-white/5 rounded-full overflow-hidden">
                            <div class="h-full {{ $colorClass }}" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Operational Queue -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Tickets Table -->
        <div class="lg:col-span-2 saas-card overflow-hidden">
            <div class="p-6 border-b border-white/5 flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-300 uppercase tracking-tight">File d'attente Récente</h3>
                <a href="{{ route('tickets.index') }}" class="text-[10px] font-bold text-blue-500 uppercase tracking-widest hover:underline">Voir Tout</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] font-bold text-slate-500 uppercase bg-white/[0.01]">
                            <th class="px-8 py-4">Sujet</th>
                            <th class="px-8 py-4">Client</th>
                            <th class="px-8 py-4 text-right">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($data['lists']['recent_tickets']->take(6) as $ticket)
                        <tr class="hover:bg-blue-500/[0.02] transition-colors group">
                            <td class="px-8 py-5">
                                <a href="{{ route('tickets.show', $ticket) }}" class="text-xs font-semibold text-slate-200 group-hover:text-blue-400 transition-colors">{{ Str::limit($ticket->subject, 35) }}</a>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[9px] font-bold text-slate-600 uppercase">#{{ $ticket->id }}</span>
                                    <span class="text-[9px] font-bold text-slate-600 uppercase">• {{ $ticket->category }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <span class="text-[11px] font-medium text-slate-400 uppercase tracking-tight">{{ $ticket->contact->nom_complet }}</span>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <span class="px-2 py-0.5 rounded text-[9px] font-bold uppercase {{ $ticket->status === 'new' ? 'bg-blue-500/10 text-blue-500' : 'bg-slate-500/10 text-slate-500' }} border border-white/5">
                                    {{ $ticket->status }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Support Ops Sidebar -->
        <div class="space-y-8">
            <!-- Urgent Block -->
            @if(count($data['lists']['urgent_tickets'] ?? []) > 0)
            <div class="saas-card p-6 border-t-2 border-t-rose-500/30">
                <h3 class="label-caps text-rose-500/70">Bloc Critique</h3>
                <div class="space-y-4 mt-4">
                    @foreach($data['lists']['urgent_tickets'] as $ticket)
                    <a href="{{ route('tickets.show', $ticket) }}" class="block p-4 border border-white/5 rounded-xl hover:bg-white/[0.03] transition-all">
                        <p class="text-[11px] font-bold text-white uppercase line-clamp-2 leading-snug">{{ $ticket->subject }}</p>
                        <div class="flex justify-between items-center mt-3">
                            <span class="text-[10px] font-bold text-slate-600">{{ $ticket->created_at->diffForHumans() }}</span>
                            <span class="text-[10px] font-bold text-rose-500 uppercase">Urgent</span>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Tasks for Support -->
            <div class="saas-card p-6">
                <h3 class="label-caps">Missions Support</h3>
                <div class="space-y-4 mt-4">
                    @forelse($data['lists']['tasks'] as $task)
                    <div class="flex items-center gap-3">
                        <div class="w-1 h-1 rounded-full {{ $task->due_date < now() ? 'bg-rose-500' : 'bg-blue-500' }} shrink-0"></div>
                        <p class="text-[11px] font-semibold text-slate-300 truncate uppercase">{{ $task->titre }}</p>
                    </div>
                    @empty
                    <p class="text-[10px] text-slate-600 font-bold text-center italic">Aucune mission</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Logic -->
<div x-show="openTicketModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-6 bg-black/80 backdrop-blur-sm">
    <div class="relative w-full max-w-xl saas-card bg-[#0f172a] shadow-2xl p-10">
        <div class="flex justify-between items-center mb-10">
            <h3 class="text-xl font-bold text-white tracking-tight">Nouveau Ticket</h3>
            <button @click="openTicketModal = false" class="text-slate-500 hover:text-white"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
        </div>
        @include('tickets.partials._form', ['isModal' => true])
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusData = @json($data['charts']['ticket_status'] ?? []);
        const categories = ['new', 'in_progress', 'resolved', 'waiting_client', 'closed'];
        
        new ApexCharts(document.querySelector("#supportStatusChart"), {
            chart: { type: 'bar', height: '100%', toolbar: { show: false }, fontFamily: 'Inter' },
            series: [{ name: 'Tickets', data: categories.map(c => Number(statusData[c] || 0)) }],
            colors: ['#3b82f6'],
            plotOptions: { bar: { borderRadius: 4, columnWidth: '30%', distributed: false } },
            grid: { borderColor: 'rgba(255,255,255,0.03)', strokeDashArray: 4 },
            xaxis: {
                categories: ['Nouveau', 'En Cours', 'Résolu', 'Attente', 'Fermé'],
                labels: { style: { colors: '#64748b', fontWeight: 600, fontSize: '10px' } },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: { labels: { style: { colors: '#64748b', fontSize: '10px' } } },
            tooltip: { theme: 'dark' }
        }).render();
    });
</script>
@endpush
