<div class="min-w-[700px]">
    <nav aria-label="Progress">
        <ul class="flex w-full mt-2 rounded-lg overflow-hidden text-xs font-bold font-heading text-center shadow-sm cursor-pointer">
             @php
                $stages = [
                    'prospection' => 'Prospection',
                    'qualification' => 'Qualification',
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
                    class="flex-1 py-3 border-r border-white/20 last:border-0 {{ $val }} relative flex items-center justify-center group"
                    role="button"
                    tabindex="0">
                    
                    @if($isCompleted) <svg class="w-4 h-4 mr-1 text-emerald-200" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg> @endif
                    @if($key === 'perdu' && $isCurrent) <svg class="w-4 h-4 mr-1 text-rose-200" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg> @endif
                    {{ strtoupper($label) }}

                    <!-- Arrow Point CSS -->
                   @if(!$loop->last)
                    <div class="absolute top-0 -right-[12px] h-full w-[24px] z-20" style="
                        background: inherit; 
                        clip-path: polygon(100% 0, 100% 100%, 50% 100%, 0% 50%, 50% 0);
                        left: 100%;
                        transform: translateX(-50%);
                    "></div>
                   @endif
                   
                    <!-- Arrow Socket CSS (Indent) -->
                   @if(!$loop->first)
                    <div class="absolute top-0 -left-[12px] h-full w-[24px] z-0 bg-white" style="
                        clip-path: polygon(100% 0, 100% 100%, 50% 100%, 0% 50%, 50% 0);
                        left: 0;
                        transform: translateX(-50%);
                    "></div>
                   @endif
                </li>
            @endforeach
        </ul>
    </nav>
</div>
