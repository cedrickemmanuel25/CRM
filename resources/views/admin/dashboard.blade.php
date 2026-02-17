@extends('layouts.app')

@section('title', 'Administration - Nexus CRM')

@section('content')
<style>
    :root {
        --enterprise-bg: #0f172a;
        --enterprise-card: rgba(30, 41, 59, 0.4);
        --enterprise-border: rgba(255, 255, 255, 0.08);
        --enterprise-accent: #3b82f6;
    }

    .saas-card {
        background: var(--enterprise-card);
        backdrop-filter: blur(20px);
        border: 1px solid var(--enterprise-border);
        border-radius: 1.25rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .saas-card:hover {
        border-color: rgba(255, 255, 255, 0.15);
        transform: translateY(-2px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .label-caps {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #94a3b8;
    }

    .metric-value {
        font-size: 2.5rem;
        font-weight: 700;
        letter-spacing: -0.02em;
        color: #f8fafc;
    }

    .delta-badge {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 6px;
    }

    .btn-action {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #f8fafc;
        transition: all 0.2s ease;
    }

    .btn-action:hover {
        background: #f8fafc;
        color: #0f172a;
        border-color: #f8fafc;
    }

    /* Custom Scrollbar for the Dashboard */
    .saas-scroll::-webkit-scrollbar { width: 4px; }
    .saas-scroll::-webkit-scrollbar-track { background: transparent; }
    .saas-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
</style>

<div class="max-w-[1400px] mx-auto space-y-10 pb-16">
    <!-- Header: Enterprise Standard -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 border-b border-white/5 pb-8">
        <div>
            <h1 class="text-4xl font-bold tracking-tight text-slate-100">Tableau de Bord</h1>
            <p class="text-slate-500 mt-1 text-sm font-medium">Vue d'ensemble des opérations et performance commerciale</p>
        </div>
        
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="btn-action px-5 py-2.5 rounded-lg text-xs font-semibold flex items-center gap-2">
                <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                Export PDF
            </button>
            <a href="#" class="btn-action px-5 py-2.5 rounded-lg text-xs font-semibold flex items-center gap-2">
                <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                Export CSV
            </a>
        </div>
    </div>

    <!-- Tier-1 KPI Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Leads Status -->
        <div class="saas-card p-6 flex flex-col justify-between min-h-[160px]">
            <div class="flex justify-between items-start">
                <span class="label-caps">Total Leads</span>
                <span class="delta-badge bg-emerald-500/10 text-emerald-400">+{{ $data['kpis']['leads_today'] }} aujourd'hui</span>
            </div>
            <div class="mt-4 flex items-end justify-between">
                <span class="metric-value">{{ $data['kpis']['contacts_count'] }}</span>
                <div id="leadsSparkline" class="w-32 h-12"></div>
            </div>
        </div>

        <!-- Revenue Status -->
        <div class="saas-card p-6 flex flex-col justify-between min-h-[160px]">
            <div class="flex justify-between items-start">
                <span class="label-caps">C.A. Prévisionnel</span>
                <div class="flex items-center gap-1 text-slate-500">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" /></svg>
                    <span class="text-[10px] font-bold">Temps réel</span>
                </div>
            </div>
            <div class="mt-4">
                <span class="metric-value text-blue-500">{{ format_currency($data['kpis']['global_forecast_revenue']) }}</span>
            </div>
        </div>

        <!-- Tasks Status -->
        <div class="saas-card p-6 flex flex-col justify-between min-h-[160px]">
            <div class="flex justify-between items-start">
                <span class="label-caps">Actions en Attente</span>
                @if($data['kpis']['pending_tasks_count'] > 0)
                    <span class="delta-badge bg-rose-500/10 text-rose-400">Attention requise</span>
                @else
                    <span class="delta-badge bg-slate-500/10 text-slate-400">À jour</span>
                @endif
            </div>
            <div class="mt-4 flex items-end justify-between">
                <span class="metric-value @if($data['kpis']['pending_tasks_count'] > 0) text-rose-500 @endif">{{ $data['kpis']['pending_tasks_count'] }}</span>
                <svg class="w-12 h-12 text-slate-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
            </div>
        </div>
    </div>

    <!-- Main Analytics Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Pipeline Distribution -->
        <div class="lg:col-span-2 saas-card p-8">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h3 class="text-lg font-bold text-slate-200">Répartition par Stade</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Volume d'opportunités actives dans le pipeline</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-blue-500"></div> <span class="text-[10px] font-bold text-slate-400">ACTIF</span></div>
                </div>
            </div>
            
            <div id="mainPipelineChart" class="min-h-[380px]"></div>
        </div>

        <!-- Quantitative Breakdown -->
        <div class="saas-card p-8 bg-slate-900/40">
            <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-8">Détails du Pipeline</h3>
            <div class="space-y-6 saas-scroll max-h-[400px] pr-2 overflow-y-auto">
                @foreach($data['charts']['pipeline_by_stage'] as $stage)
                <div class="group">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs font-semibold text-slate-300">{{ $stage->stade }}</span>
                        <span class="text-xs font-bold text-slate-500">{{ format_currency($stage->total_amount) }}</span>
                    </div>
                    <div class="w-full bg-white/5 h-1.5 rounded-full overflow-hidden">
                        @php $percent = ($data['kpis']['global_forecast_revenue'] > 0) ? ($stage->total_amount / $data['kpis']['global_forecast_revenue']) * 100 : 0; @endphp
                        <div class="h-full bg-slate-700 group-hover:bg-blue-600 transition-all duration-500" style="width: {{ max(5, $percent) }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-10 pt-6 border-t border-white/5">
                <div class="flex justify-between items-center">
                    <span class="text-xs font-bold text-slate-500 uppercase">Capacité Totale</span>
                    <span class="text-sm font-bold text-white">{{ count($data['charts']['pipeline_by_stage']) }} segments</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Insights -->
    <div class="saas-card p-8">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-lg font-bold text-slate-200">Tendances d'acquisition</h3>
            <select class="bg-slate-800 border-none text-xs font-bold text-slate-400 rounded-lg px-3 py-1.5 focus:ring-0">
                <option>15 derniers jours</option>
                <option>30 derniers jours</option>
            </select>
        </div>
        <div id="acquisitionTrendLine" class="h-64"></div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pipelineData = @json($data['charts']['pipeline_by_stage']);
        
        // Enterprise Main Bar Chart
        new ApexCharts(document.querySelector("#mainPipelineChart"), {
            chart: { 
                type: 'bar', 
                height: 380, 
                toolbar: { show: false }, 
                fontFamily: 'Inter, sans-serif'
            },
            series: [{ name: 'Opportunités', data: pipelineData.map(d => d.count) }],
            colors: ['#3b82f6'],
            plotOptions: { bar: { borderRadius: 4, columnWidth: '25%', distributed: false } },
            dataLabels: { enabled: false },
            grid: { borderColor: 'rgba(255,255,255,0.03)', strokeDashArray: 4, xaxis: { lines: { show: false } }, yaxis: { lines: { show: true } } },
            xaxis: {
                categories: pipelineData.map(d => d.stade),
                labels: { style: { colors: '#64748b', fontWeight: 600, fontSize: '11px' } },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: { style: { colors: '#64748b', fontWeight: 600, fontSize: '11px' } }
            },
            tooltip: { theme: 'dark' }
        }).render();

        // Acquisition Trend Chart (Pro Overhaul)
        const trendData = @json($data['charts']['leads_trend']);
        
        new ApexCharts(document.querySelector("#acquisitionTrendLine"), {
            chart: { 
                type: 'area', 
                height: 300, 
                toolbar: { show: false }, 
                fontFamily: 'Inter, sans-serif'
            },
            series: [
                { name: 'Nouveaux Leads', data: trendData.leads },
                { name: 'Opps Créées', data: trendData.opps }
            ],
            stroke: { curve: 'smooth', width: [3, 2], dashArray: [0, 4] },
            fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.2, opacityTo: 0 } },
            colors: ['#3b82f6', '#94a3b8'],
            xaxis: { 
                categories: trendData.labels,
                labels: { style: { colors: '#64748b', fontSize: '10px', fontWeight: 600 } },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                show: true,
                labels: { style: { colors: '#64748b', fontSize: '10px' } }
            },
            grid: { borderColor: 'rgba(255,255,255,0.03)', strokeDashArray: 4 },
            legend: { show: true, position: 'top', horizontalAlign: 'right', labels: { colors: '#94a3b8' } },
            tooltip: { theme: 'dark' }
        }).render();

        // Mini Leads Sparkline
        new ApexCharts(document.querySelector("#leadsSparkline"), {
            chart: { type: 'line', height: '100%', sparkline: { enabled: true } },
            series: [{ data: [10, 15, 12, 20, 18, 25, 22] }],
            stroke: { curve: 'smooth', width: 2 },
            colors: ['#10b981']
        }).render();
    });
</script>
@endpush
