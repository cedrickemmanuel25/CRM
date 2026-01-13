    <div class="relative max-w-[1800px] mx-auto px-4 sm:px-4 lg:px-4 pb-8">
        
        <!-- VUE PIPELINE -->
        <div x-show="viewMode === 'pipeline'" class="pb-6">
            <div class="flex gap-2 sm:gap-1.5 w-full items-start overflow-x-auto pb-4 snap-x snap-mandatory">
                <!-- Scroll hint for mobile -->
                <div class="block sm:hidden text-xs text-gray-500 text-center w-full mb-2">
                    <p class="flex items-center justify-center gap-1">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                        Faites glisser pour voir toutes les colonnes
                    </p>
                </div>
                @php
                    $stages = [
                        'prospection'   => ['label' => 'Prospection',   'color' => 'slate',    'icon' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'],
                        'qualification' => ['label' => 'Qualification', 'color' => 'blue',     'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                        'proposition'   => ['label' => 'Proposition',   'color' => 'purple',   'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                        'negociation'   => ['label' => 'Négociation',   'color' => 'amber',    'icon' => 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4'],
                        'gagne'         => ['label' => 'Gagné',         'color' => 'emerald',  'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                        'perdu'         => ['label' => 'Perdu',         'color' => 'rose',     'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ];
                @endphp

                @foreach($stages as $key => $config)
                <div class="flex-none w-[85vw] sm:w-auto sm:flex-1 sm:min-w-[240px] lg:min-w-[200px] flex flex-col snap-center">
                    <div class="bg-white rounded-lg border border-gray-200 flex flex-col">
                        <!-- En-tête de colonne -->
                        <div class="px-4 py-4 border-b border-gray-200 flex-shrink-0">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-2">
                                    <div class="p-2 bg-{{ $config['color'] }}-100 rounded-lg">
                                        <svg class="h-4 w-4 text-{{ $config['color'] }}-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-semibold text-gray-900">{{ $config['label'] }}</h3>
                                </div>
                                <span class="px-2.5 py-1 bg-{{ $config['color'] }}-100 text-{{ $config['color'] }}-700 text-xs font-bold rounded-full">
                                    {{ isset($pipeline[$key]) ? $pipeline[$key]->count() : 0 }}
                                </span>
                            </div>
                            <p class="text-lg font-bold text-gray-900">
                                {{ isset($pipeline[$key]) ? format_currency($pipeline[$key]->sum('montant_estime')) : format_currency(0) }}
                            </p>
                        </div>

                        <!-- Zone de cartes -->
                        <div class="p-3 space-y-3 kanban-list" data-stage="{{ $key }}">
                            @if(isset($pipeline[$key]))
                                @foreach($pipeline[$key] as $opp)
                                <div class="kanban-card bg-white border-2 border-gray-200 rounded-lg p-3 hover:border-{{ $config['color'] }}-400 hover:shadow-md transition-all cursor-grab active:cursor-grabbing group" data-id="{{ $opp->id }}">
                                    
                                    <a href="{{ route('opportunities.show', $opp) }}" class="block mb-2">
                                        <h4 class="text-xs font-bold text-gray-900 hover:text-indigo-600 line-clamp-2">{{ $opp->titre }}</h4>
                                    </a>

                                    <div class="flex items-center text-xs text-gray-500 mb-2">
                                        <svg class="h-3.5 w-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        <span class="truncate">{{ $opp->contact?->entreprise ?? 'Sans entreprise' }}</span>
                                    </div>

                                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg mb-2">
                                        <div>
                                            <p class="text-[10px] text-gray-500 mb-0.5">Montant</p>
                                            <p class="text-sm font-bold text-gray-900">{{ format_currency($opp->montant_estime) }}</p>
                                        </div>
                                        <div class="text-center">
                                            @php
                                                $probColor = $opp->probabilite >= 70 ? 'emerald' : ($opp->probabilite >= 30 ? 'amber' : 'rose');
                                            @endphp
                                            <div class="px-2.5 py-1 bg-{{ $probColor }}-100 text-{{ $probColor }}-700 rounded-md text-xs font-bold">
                                                {{ $opp->probabilite }}%
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between pt-2 border-t border-gray-100 text-xs">
                                        <div class="flex items-center gap-2">
                                            <img class="h-5 w-5 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($opp->commercial?->name ?? 'N A') }}&background=6366f1&color=fff&size=32" alt="">
                                            <span class="text-gray-600 truncate max-w-[120px]">{{ $opp->commercial?->name ?? 'Non assigné' }}</span>
                                        </div>
                                        @if($opp->date_cloture_prev)
                                            <span class="text-gray-500">{{ $opp->date_cloture_prev->format('d/m') }}</span>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- VUE LISTE -->
        <div x-show="viewMode === 'list'" x-transition>
            <!-- Mobile Card View -->
            <div class="block md:hidden space-y-3 p-4">
                @foreach($opportunities as $opp)
                <div class="bg-white rounded-lg border border-gray-200 p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-3">
                        <a href="{{ route('opportunities.show', $opp) }}" class="flex-1">
                            <h3 class="text-sm font-bold text-gray-900 hover:text-indigo-600 mb-1">{{ $opp->titre }}</h3>
                            <p class="text-xs text-gray-500">{{ $opp->contact?->entreprise ?? 'Particulier' }}</p>
                        </a>
                        @php
                            $stageColors = [
                                'prospection'   => 'slate',
                                'qualification' => 'blue',
                                'proposition'   => 'purple',
                                'negociation'   => 'amber',
                                'gagne'         => 'emerald',
                                'perdu'         => 'rose',
                            ];
                            $color = $stageColors[$opp->stade] ?? 'gray';
                        @endphp
                        <span class="inline-flex px-2 py-1 rounded-full text-[10px] font-bold uppercase bg-{{ $color }}-100 text-{{ $color }}-700">{{ $opp->stade }}</span>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Montant</p>
                            <p class="text-sm font-bold text-gray-900">{{ format_currency($opp->montant_estime) }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Probabilité</p>
                            @php
                                $probColor = $opp->probabilite >= 70 ? 'emerald' : ($opp->probabilite >= 30 ? 'amber' : 'rose');
                            @endphp
                            <span class="inline-flex px-2 py-1 rounded-full text-xs font-bold bg-{{ $probColor }}-100 text-{{ $probColor }}-700">{{ $opp->probabilite }}%</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                        <div class="flex items-center gap-2 text-xs text-gray-600">
                            <img class="h-5 w-5 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($opp->commercial?->name ?? 'N A') }}&background=6366f1&color=fff&size=32" alt="">
                            <span class="truncate max-w-[120px]">{{ $opp->commercial?->name ?? 'Non assigné' }}</span>
                        </div>
                        @if(!auth()->user()->isSupport())
                        <div class="flex gap-2">
                            <a href="{{ route('opportunities.show', $opp) }}" class="p-1.5 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                            <a href="{{ route('opportunities.edit', $opp) }}" class="p-1.5 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Desktop Table View -->
            <div class="hidden md:block bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Opportunité</th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Contact</th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Montant</th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Probabilité</th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Stade</th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Échéance</th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Commercial</th>
                                @if(!auth()->user()->isSupport())
                                <th class="px-3 py-3 text-right"><span class="sr-only">Actions</span></th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($opportunities as $opp)
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="px-3 py-4">
                                    <a href="{{ route('opportunities.show', $opp) }}" class="text-sm font-medium text-gray-900 hover:text-indigo-600 block" title="{{ $opp->titre }}">{{ $opp->titre }}</a>
                                    <p class="text-xs text-gray-500 mt-1">{{ $opp->updated_at->diffForHumans() }}</p>
                                </td>
                                <td class="px-3 py-4">
                                    <p class="text-xs font-medium text-gray-900" title="{{ $opp->contact?->entreprise ?? 'Particulier' }}">{{ $opp->contact?->entreprise ?? 'Particulier' }}</p>
                                    <p class="text-[10px] text-gray-500">{{ $opp->contact?->prenom }} {{ $opp->contact?->nom }}</p>
                                </td>
                                <td class="px-3 py-4">
                                    <p class="text-sm font-bold text-gray-900">{{ format_currency($opp->montant_estime) }}</p>
                                    <p class="text-xs text-emerald-600 font-medium">{{ format_currency($opp->weighted_value) }}</p>
                                </td>
                                <td class="px-3 py-4">
                                    @php
                                        $probColor = $opp->probabilite >= 70 ? 'emerald' : ($opp->probabilite >= 30 ? 'amber' : 'rose');
                                    @endphp
                                    <span class="inline-flex px-2 py-1 rounded-full text-xs font-bold bg-{{ $probColor }}-100 text-{{ $probColor }}-700">{{ $opp->probabilite }}%</span>
                                </td>
                                <td class="px-3 py-4">
                                    @php
                                        $stageColors = [
                                            'prospection'   => 'slate',
                                            'qualification' => 'blue',
                                            'proposition'   => 'purple',
                                            'negociation'   => 'amber',
                                            'gagne'         => 'emerald',
                                            'perdu'         => 'rose',
                                        ];
                                        $color = $stageColors[$opp->stade] ?? 'gray';
                                    @endphp
                                    <span class="inline-flex px-2 py-1 rounded-full text-[10px] font-bold uppercase bg-{{ $color }}-100 text-{{ $color }}-700">{{ $opp->stade }}</span>
                                </td>
                                <td class="px-3 py-4">
                                    @if($opp->date_cloture_prev)
                                        <p class="text-sm font-medium text-gray-700">{{ $opp->date_cloture_prev->format('d/m/Y') }}</p>
                                        <p class="text-[10px] text-gray-500">{{ $opp->time_in_stage }} jours</p>
                                    @else
                                        <span class="text-xs text-gray-400">Non définie</span>
                                    @endif
                                </td>
                                <td class="px-3 py-4">
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-medium text-gray-700" title="{{ $opp->commercial?->name ?? 'Non assigné' }}">{{ $opp->commercial?->name ?? 'Non assigné' }}</span>
                                    </div>
                                </td>
                                @if(!auth()->user()->isSupport())
                                <td class="px-3 py-4 text-right">
                                    <div class="flex justify-end items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('opportunities.show', $opp) }}" class="p-1.5 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                        <a href="{{ route('opportunities.edit', $opp) }}" class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex items-center justify-between flex-shrink-0">
                <div class="text-sm text-gray-600">
                    Affichage de <span class="font-medium">{{ $opportunities->firstItem() ?? 0 }}</span> à <span class="font-medium">{{ $opportunities->lastItem() ?? 0 }}</span> sur <span class="font-medium">{{ $opportunities->total() }}</span> opportunités
                </div>
                <div>{{ $opportunities->appends(request()->query())->links() }}</div>
            </div>
        </div>

    </div>
