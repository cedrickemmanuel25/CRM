@foreach($users as $user)
<tr x-show="!search || $el.innerText.toLowerCase().includes(search.toLowerCase())" class="hover:bg-gray-50 transition">
    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
        <div class="flex items-center">
            <div class="h-10 w-10 flex-shrink-0">
                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold">
                    {{ substr($user->name, 0, 1) }}
                </div>
            </div>
            <div class="ml-4">
                <div class="font-medium text-gray-900">{{ $user->name }}</div>
                <div class="text-gray-500">{{ $user->email }}</div>
            </div>
        </div>
    </td>
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
        <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 
            {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 
                ($user->role === 'commercial' ? 'bg-green-100 text-green-800' : 
                ($user->role === 'support' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800')) }}">
            {{ ucfirst($user->role) }}
        </span>
    </td>
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
        {{ format_phone($user->telephone) ?? '-' }}
    </td>
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
        {{ $user->created_at->format('d/m/Y') }}
    </td>
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
            Actif
        </span>
    </td>
    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
        <div class="flex justify-end space-x-2">
            
            <button type="button" @click="openEdit({{ $user }})" class="text-indigo-600 hover:text-indigo-900" title="Modifier">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            </button>

            <form action="{{ route('admin.users.reset-password', $user) }}" method="POST" onsubmit="return confirm('Réinitialiser le mot de passe ?');">
                @csrf
                <button type="submit" class="text-yellow-600 hover:text-yellow-900" title="Réinitialiser le mot de passe">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                </button>
            </form>

            @if($user->id !== auth()->id())
            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Vraiment supprimer cet utilisateur ?');">
                @csrf @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-900" title="Supprimer">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </form>
            @endif
        </div>
    </td>
</tr>
@endforeach
