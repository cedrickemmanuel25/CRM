<div class="w-full">
    <nav aria-label="Progress">
        <ul class="flex w-full mt-2 rounded-lg overflow-hidden text-[10px] font-bold font-heading text-center shadow-sm cursor-pointer uppercase">
             @php
                $stages = [
                    'prospection' => 'Prospection',
                    'qualification' => 'Prospect Qualifié',
                    'proposition' => 'Proposition',
                    'negociation' => 'Négociation',
                    'gagne' => 'Gagné',
                    'perdu' => 'Perdu'
                ];
                $keys = array_keys($stages);
                $currentIndex = array_search($opportunity->stade, $keys);
            @endphp

             @foreach($stages as $key => $label)
                @php
                    $loopIndex = $loop->index;
                    $isCompleted = $loopIndex < $currentIndex && $opportunity->stade !== 'perdu';
                    $isCurrent = $opportunity->stade === $key;
                    
                    // Tailored classes
                    if ($key === 'perdu') {
                        if ($isCurrent) $val = 'bg-rose-600 text-white relative z-10 shadow-lg';
                        else $val = 'bg-gray-100 text-gray-500 hover:bg-rose-100 hover:text-rose-600';
                    } elseif ($key === 'gagne') {
                        if ($isCurrent) $val = 'bg-emerald-600 text-white relative z-10 shadow-lg';
                        else $val = 'bg-gray-100 text-gray-500 hover:bg-emerald-100 hover:text-emerald-600';
                    } else {
                        if ($isCompleted) {
                            $val = 'bg-emerald-600 text-white hover:bg-emerald-700';
                        } elseif ($isCurrent) {
                            $val = 'bg-indigo-600 text-white relative z-10 shadow-lg'; 
                        } else {
                            $val = 'bg-gray-100 text-gray-500 hover:bg-indigo-50 hover:text-indigo-600';
                        }
                    }
                @endphp
                
                <li @click.stop="$dispatch('change-stage-request', { 
                        id: {{ $opportunity->id }}, 
                        stage: '{{ $key }}', 
                        currentStage: '{{ $opportunity->stade }}',
                        budget: '{{ $opportunity->budget_estime }}',
                        prevent_deadline: '{{ $opportunity->delai_projet ? $opportunity->delai_projet->format('Y-m-d') : '' }}',
                         decisionnaire: {{ $opportunity->decisionnaire ? 'true' : 'false' }},
                        besoin: `{{ addslashes($opportunity->besoin) }}`
                    })" 
                    class="flex-1 min-w-[110px] py-4 border-r border-white/20 last:border-0 {{ $val }} relative flex items-center justify-center group transition-all"
                    role="button"
                    tabindex="0">
                    
                    <div class="flex items-center justify-center px-4 w-full">
                        @if($isCompleted) <svg class="w-3.5 h-3.5 mr-1.5 text-emerald-200 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg> @endif
                        @if($key === 'perdu' && $isCurrent) <svg class="w-3.5 h-3.5 mr-1.5 text-rose-200 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg> @endif
                        <span class="truncate whitespace-nowrap">{{ $label }}</span>
                    </div>

                    <!-- Chevron Point -->
                   @if(!$loop->last)
                    <div class="absolute top-0 -right-[10px] h-full w-[20px] z-20 pointer-events-none" style="
                        background: inherit; 
                        clip-path: polygon(0 0, 100% 50%, 0 100%, 30% 50%);
                        left: 100%;
                        transform: translateX(-30%);
                    "></div>
                   @endif
                </li>
            @endforeach
        </ul>
    </nav>
</div>
