@extends('layouts.app')

@section('title', 'Tableau de bord - Nexus CRM')

@section('content')
<div class="min-h-screen bg-gray-50/50 p-6">
    <div class="max-w-[1600px] mx-auto space-y-8">
        
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                    Tableau de bord
                </h2>
                <!-- Optional Subtitle if needed 
                <p class="mt-1 text-sm text-gray-500">Vue d'ensemble de vos performances</p>
                -->
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('reports.pdf') }}" class="inline-flex items-center px-4 py-2 border border-gray-200 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-all">
                    <svg class="mr-2 h-4 w-4 text-gray-500" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    Exporter au format PDF
                </a>
                <a href="{{ route('reports.export', ['type' => 'opportunities']) }}" class="inline-flex items-center px-4 py-2 border border-gray-200 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-all">
                    <svg class="mr-2 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Exporter au format CSV
                </a>
            </div>
        </div>

        <!-- KPIs Grid -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Revenu Total -->
            <div class="relative overflow-hidden rounded-xl bg-white p-6 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Revenu total</p>
                    <div class="p-2 bg-gray-50 rounded-lg group-hover:bg-indigo-50 transition-colors">
                        <svg class="h-5 w-5 text-gray-400 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-bold text-gray-900">{{ format_currency($data['kpis']['global_forecast_revenue']) }}</p>
                </div>
            </div>

            <!-- Opportunités actives -->
            <div class="relative overflow-hidden rounded-xl bg-white p-6 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Opportunités actives</p>
                    <div class="p-2 bg-gray-50 rounded-lg group-hover:bg-blue-50 transition-colors">
                        <svg class="h-5 w-5 text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
                 <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-bold text-gray-900">{{ $data['kpis']['total_leads_opps'] }}</p>
                </div>
            </div>

            <!-- Contacts -->
            <div class="relative overflow-hidden rounded-xl bg-white p-6 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Contacts</p>
                    <div class="p-2 bg-gray-50 rounded-lg group-hover:bg-emerald-50 transition-colors">
                         <svg class="h-5 w-5 text-gray-400 group-hover:text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-bold text-gray-900">{{ $data['kpis']['contacts_count'] }}</p>
                </div>
            </div>

            <!-- Tâches en attente -->
            <div class="relative overflow-hidden rounded-xl bg-white p-6 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Tâches en attente</p>
                    <div class="p-2 bg-gray-50 rounded-lg group-hover:bg-amber-50 transition-colors">
                         <svg class="h-5 w-5 text-gray-400 group-hover:text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-bold text-gray-900">{{ $data['kpis']['pending_tasks_count'] }}</p>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Revenue Evolution (Left - 2/3) -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 p-6 flex flex-col">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-lg font-bold text-gray-900">Évolution du Chiffre d'Affaires</h3>
                    <div class="flex space-x-2 text-xs font-medium">
                        <span class="px-2 py-1 bg-gray-100 text-gray-500 rounded cursor-pointer hover:bg-gray-200">Mois</span>
                        <span class="px-2 py-1 text-gray-400 cursor-pointer hover:text-gray-500">Année</span>
                    </div>
                </div>
                
                <div class="flex-1 mt-4 relative h-[300px]">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- Pipeline Funnel (Right - 1/3) -->
            <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-8">Par Étape</h3>
                <div class="space-y-6">
                     @foreach($data['charts']['pipeline_by_stage'] as $stage)
                        @php
                            $totalOps = $data['kpis']['total_leads_opps'] ?: 1;
                            $percentage = round(($stage->count / $totalOps) * 100);
                            $colors = [
                                'prospection' => 'bg-blue-500',
                                'qualification' => 'bg-indigo-500',
                                'proposition' => 'bg-orange-500', // Matches image style
                                'negociation' => 'bg-emerald-500',
                                'gagne' => 'bg-green-600',
                                'perdu' => 'bg-gray-400',
                            ];
                            $dotColor = match($stage->stade) {
                                'prospection' => 'text-blue-500',
                                'qualification' => 'text-indigo-500',
                                'proposition' => 'text-orange-500',
                                'negociation' => 'text-emerald-500',
                                'cloture' => 'text-purple-500',
                                default => 'text-gray-400'
                            };
                             $barColor = match($stage->stade) {
                                'prospection' => 'bg-blue-500',
                                'qualification' => 'bg-indigo-500',
                                'proposition' => 'bg-orange-500',
                                'negociation' => 'bg-emerald-500',
                                'cloture' => 'bg-purple-500',
                                default => 'bg-gray-400'
                            };
                        @endphp
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full {{ $barColor }}"></span>
                                    <span class="text-sm font-medium text-gray-600 capitalize">{{ $stage->stade }}</span>
                                </div>
                                <span class="text-sm font-bold text-gray-900">{{ $percentage }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                <div class="h-full {{ $barColor }} rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Last Opportunities Table -->
        <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100/50 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900">Dernières Opportunités</h3>
                <a href="{{ route('opportunities.index') }}" class="px-4 py-2 bg-gray-50 hover:bg-gray-100 text-xs font-semibold text-gray-600 rounded-lg transition-colors">
                    Voir tout
                </a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-white border-b border-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Opportunité</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Client</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Montant</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($data['lists']['latest_opportunities'] as $opp)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold text-gray-900">{{ $opp->titre }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs ring-2 ring-white">
                                        {{ substr($opp->contact->nom_complet ?? 'N', 0, 1) }}
                                    </div>
                                    <span class="text-sm font-medium text-gray-600">{{ $opp->contact->nom_complet ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-bold text-gray-900">{{ format_currency($opp->montant_estime) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusClasses = [
                                        'prospection' => 'bg-blue-50 text-blue-700 border-blue-100',
                                        'qualification' => 'bg-indigo-50 text-indigo-700 border-indigo-100',
                                        'proposition' => 'bg-orange-50 text-orange-700 border-orange-100',
                                        'negociation' => 'bg-amber-50 text-amber-700 border-amber-100',
                                        'gagne' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                        'perdu' => 'bg-gray-50 text-gray-600 border-gray-100',
                                    ];
                                    $class = $statusClasses[$opp->stade] ?? 'bg-gray-50 text-gray-600 border-gray-100';
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $class }} capitalize">
                                    {{ $opp->stade }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $opp->created_at->translatedFormat('d F') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500 italic">Aucune opportunité récente.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Revenue Chart (Stacked by Stage)
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueRawData = @json($data['charts']['revenue_trend']);
        
        // Extract Months (Keys)
        const labels = Object.keys(revenueRawData).map(month => {
             const date = new Date(month + '-01'); 
             return date.toLocaleDateString('fr-FR', { month: 'short' });
        });

        // Prepare Datasets for each stage
        const stagesConfig = [
            { key: 'prospection', label: 'Prospection', color: '#3B82F6' }, // Blue 500
            { key: 'qualification', label: 'Qualification', color: '#6366F1' }, // Indigo 500
            { key: 'proposition', label: 'Proposition', color: '#F97316' }, // Orange 500
            { key: 'negociation', label: 'Négociation', color: '#10B981' }, // Emerald 500
            { key: 'gagne', label: 'Gagné', color: '#16A34A' }, // Green 600
            { key: 'perdu', label: 'Perdu', color: '#9CA3AF' }  // Gray 400
        ];

        const datasets = stagesConfig.map(stage => {
            return {
                label: stage.label,
                data: Object.values(revenueRawData).map(monthData => Number(monthData[stage.key] || 0)),
                backgroundColor: stage.color,
                borderRadius: 2, // Slight rounding
                maxBarThickness: 32,
            };
        });
        
        const revenueChart = new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { 
                        display: true,
                        position: 'bottom',
                        labels: { 
                            usePointStyle: true,
                            boxWidth: 8,
                            padding: 20,
                            font: { size: 11, family: "'Inter', sans-serif" }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1F2937',
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        stacked: true, // Enable Stacking
                        beginAtZero: true,
                        grid: {
                            color: '#F3F4F6',
                            drawBorder: false,
                        },
                        ticks: {
                            font: { family: "'Inter', sans-serif", size: 11 },
                            color: '#9CA3AF',
                            callback: function(value) {
                                if (value >= 1000) return (value/1000) + 'k';
                                return value;
                            }
                        },
                        border: { display: false }
                    },
                    x: {
                        stacked: true, // Enable Stacking
                        grid: { display: false },
                        ticks: {
                            font: { family: "'Inter', sans-serif", size: 11 },
                            color: '#9CA3AF'
                        },
                        border: { display: false }
                    }
                }
            }
        });
    });
</script>
@endpush
