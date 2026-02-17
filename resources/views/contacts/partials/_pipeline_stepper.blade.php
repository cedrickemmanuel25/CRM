@php
    $stages = \App\Models\Contact::getStages();
    $currentStage = $contact->statut;
    $stageKeys = array_keys($stages);
    $currentIndex = array_search($currentStage, $stageKeys);
    if ($currentIndex === false) $currentIndex = 0;
@endphp

<div class="relative mb-12 px-2">
    <!-- Progress Line -->
    <div class="absolute top-1/2 left-0 w-full h-1 bg-white/5 -translate-y-1/2 rounded-full overflow-hidden" aria-hidden="true">
        <div class="h-full bg-blue-600 rounded-full transition-all duration-700 ease-out shadow-[0_0_10px_rgba(59,130,246,0.5)]" 
             style="width: {{ ($currentIndex / (count($stages) - 1)) * 100 }}%"></div>
    </div>

    <!-- Steps -->
    <div class="relative flex justify-between items-center w-full">
        @foreach($stages as $key => $stage)
            @php
                $index = array_search($key, $stageKeys);
                $isCompleted = $index < $currentIndex;
                $isCurrent = $index === $currentIndex;
                $isFuture = $index > $currentIndex;

                $colorClass = match($stage['color']) {
                    'slate' => 'bg-slate-500',
                    'amber' => 'bg-amber-500',
                    'indigo' => 'bg-indigo-500',
                    'blue' => 'bg-blue-500',
                    'emerald' => 'bg-emerald-500',
                    'rose' => 'bg-rose-500',
                    default => 'bg-slate-500'
                };
            @endphp

            <div class="flex flex-col items-center group">
                <!-- Node -->
                <div @class([
                    'relative flex items-center justify-center w-12 h-12 rounded-2xl border-2 transition-all duration-500 z-10',
                    'bg-blue-600 border-blue-400 text-white scale-110 shadow-[0_0_20px_rgba(59,130,246,0.4)]' => $isCurrent,
                    'bg-slate-800 border-blue-600/50 text-blue-400' => $isCompleted,
                    'bg-[#0f172a] border-white/10 text-slate-600 group-hover:border-white/20' => $isFuture,
                ])>
                    @if($isCompleted)
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    @else
                        <span class="text-xs font-bold">{{ $index + 1 }}</span>
                    @endif

                    <!-- Tooltip/Label (Glass) -->
                    <div class="absolute -top-14 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-2 group-hover:translate-y-0 bg-[#1e293b]/90 backdrop-blur-md text-slate-100 text-[9px] font-black uppercase tracking-widest px-3 py-1.5 rounded-lg whitespace-nowrap pointer-events-none shadow-2xl border border-white/10">
                        {{ $stage['label'] }}
                    </div>
                </div>

                <!-- Labels -->
                <div class="mt-4 text-center">
                    <span @class([
                        'text-[10px] font-black uppercase tracking-widest block transition-colors duration-300',
                        'text-blue-400' => $isCurrent,
                        'text-slate-300' => $isCompleted,
                        'text-slate-600' => $isFuture,
                    ])>
                        {{ $stage['label'] }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>
</div>
