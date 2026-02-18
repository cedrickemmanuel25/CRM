@extends('layouts.app')

@section('title', 'Dashboard - Nexus CRM')

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
        margin-bottom: 1rem;
        display: block;
    }

    .metric-value {
        font-size: 2.25rem;
        font-weight: 700;
        color: #f1f5f9;
        letter-spacing: -0.025em;
    }

    .btn-export {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #94a3b8;
        transition: all 0.2s ease;
    }
    .btn-export:hover { background: #fff; color: #0f172a; border-color: #fff; }
</style>

<div class="max-w-[1400px] mx-auto space-y-8 pb-12">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 pb-6">
        <div>
            <h1 class="page-title">Tableau <span class="accent">de Bord</span></h1>
            <p class="text-slate-500 text-sm mt-1">Résumé consolidé de votre activité</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="btn-export px-4 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wider flex items-center gap-2">
                <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                PDF
            </button>
            <a href="#" class="btn-export px-4 py-2 rounded-lg text-[11px] font-bold uppercase tracking-wider flex items-center gap-2">
                <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                CSV
            </a>
        </div>
    </div>

    <!-- Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="saas-card p-6">
            <span class="label-caps">Prospects Actifs</span>
            <div class="flex items-end justify-between">
                <span class="metric-value">{{ $data['kpis']['contacts_count'] }}</span>
                <span class="text-[10px] font-bold text-emerald-500 bg-emerald-500/10 px-2 py-1 rounded">Actifs</span>
            </div>
        </div>
        <div class="saas-card p-6">
            <span class="label-caps">Performance Pipeline</span>
            <div id="miniPipelineChart" class="h-10 mb-2"></div>
            <div class="flex justify-between items-center mt-2">
                <span class="text-[11px] font-bold text-slate-400">{{ count($data['charts']['pipeline_by_stage'] ?? []) }} segments</span>
            </div>
        </div>
        <div class="saas-card p-6 border-l-2 border-l-blue-500">
            <span class="label-caps">Potentiel C.A.</span>
            <span class="metric-value text-blue-500">{{ format_currency($data['kpis']['global_forecast_revenue']) }}</span>
        </div>
        <div class="saas-card p-6 border-l-2 border-l-rose-500">
            <span class="label-caps">Missions en Retard</span>
            <div class="flex items-end justify-between">
                <span class="metric-value @if($data['kpis']['pending_tasks_count'] > 0) text-rose-500 @endif">{{ $data['kpis']['pending_tasks_count'] }}</span>
                @if($data['kpis']['pending_tasks_count'] > 0)
                    <span class="text-[10px] font-bold text-rose-500 bg-rose-500/10 px-2 py-1 rounded">Critique</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 saas-card p-8">
            <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-8">Flux du Pipeline</h3>
            <div id="pipelineBarChart" class="h-80"></div>
        </div>
        <div class="saas-card p-8 bg-slate-900/40">
            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-[0.2em] mb-8">Statut des Stades</h3>
            <div class="space-y-6">
                @foreach($data['charts']['pipeline_by_stage'] ?? [] as $stage)
                <div>
                    <div class="flex justify-between text-[11px] font-bold mb-2">
                        <span class="text-slate-400">{{ $stage->stade }}</span>
                        <span class="text-white">{{ format_currency($stage->total_amount) }}</span>
                    </div>
                    <div class="h-1 w-full bg-white/5 rounded-full overflow-hidden">
                        @php $percent = (($data['kpis']['global_forecast_revenue'] ?? 0) > 0) ? ($stage->total_amount / $data['kpis']['global_forecast_revenue']) * 100 : 0; @endphp
                        <div class="h-full bg-blue-600/60" style="width: {{ $percent }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Trend -->
    <div class="saas-card p-8">
        <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-8">Dynamique d'Acquisition</h3>
        <div id="leadsTrendChart" class="h-64"></div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pipelineData = @json($data['charts']['pipeline_by_stage'] ?? []);
        
        new ApexCharts(document.querySelector("#pipelineBarChart"), {
            chart: { type: 'bar', height: 320, toolbar: { show: false }, fontFamily: 'Inter' },
            series: [{ name: 'Valeur', data: pipelineData.map(d => d.total_amount) }],
            colors: ['#3b82f6'],
            plotOptions: { bar: { borderRadius: 4, horizontal: true, barHeight: '25%' } },
            dataLabels: { enabled: false },
            grid: { borderColor: 'rgba(255,255,255,0.02)', strokeDashArray: 4 },
            xaxis: {
                categories: pipelineData.map(d => d.stade),
                labels: { style: { colors: '#64748b', fontSize: '10px' } },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: { labels: { style: { colors: '#64748b', fontSize: '10px' } } },
            tooltip: { theme: 'dark' }
        }).render();

        const trendData = @json($data['charts']['leads_trend'] ?? []);
        new ApexCharts(document.querySelector("#leadsTrendChart"), {
            chart: { 
                type: 'area', 
                height: 300, 
                toolbar: { show: false }, 
                fontFamily: 'Inter'
            },
            series: [
                { name: 'Nouveaux Leads', data: trendData.leads || [] },
                { name: 'Opps Créées', data: trendData.opps || [] }
            ],
            stroke: { curve: 'smooth', width: [3, 2], dashArray: [0, 4] },
            fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.2, opacityTo: 0 } },
            colors: ['#3b82f6', '#94a3b8'],
            xaxis: { 
                categories: trendData.labels || [],
                labels: { style: { colors: '#64748b', fontSize: '10px' } } 
            },
            yaxis: { show: true, labels: { style: { colors: '#64748b', fontSize: '10px' } } },
            grid: { borderColor: 'rgba(255,255,255,0.03)', strokeDashArray: 4 },
            legend: { show: true, position: 'top', horizontalAlign: 'right', labels: { colors: '#94a3b8' } },
            tooltip: { theme: 'dark' }
        }).render();

        new ApexCharts(document.querySelector("#miniPipelineChart"), {
            chart: { type: 'line', height: '100%', sparkline: { enabled: true } },
            series: [{ data: [10, 15, 8, 12, 18, 14, 20] }],
            stroke: { curve: 'smooth', width: 2 },
            colors: ['#3b82f6']
        }).render();
    });
</script>
@endpush
