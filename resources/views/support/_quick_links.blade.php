<div class="space-y-6">
    <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Actions Rapides</h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('contacts.index') }}" class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <svg class="h-6 w-6 text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span class="text-xs font-medium text-gray-900">Voir Contacts</span>
                </a>
                <a href="{{ route('calendar') }}" class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <svg class="h-6 w-6 text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <span class="text-xs font-medium text-gray-900">Calendrier</span>
                </a>
            </div>
    </div>

    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Activité Récente</h3>
        </div>
        <div class="flow-root mt-6 px-4 pb-6">
            <ul class="-mb-8">
                @foreach($recent_activities as $activity)
                <li>
                    <div class="relative pb-8">
                        @if(!$loop->last)
                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                        @endif
                        <div class="relative flex space-x-3">
                            <div>
                                <span class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center ring-8 ring-white">
                                    <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </span>
                            </div>
                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                <div>
                                    <p class="text-xs text-gray-500">{{ $activity->description ?? 'Action système' }}</p>
                                </div>
                                <div class="text-right text-xs whitespace-nowrap text-gray-500">
                                    <time datetime="{{ $activity->created_at }}">{{ $activity->created_at->format('H:i') }}</time>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
