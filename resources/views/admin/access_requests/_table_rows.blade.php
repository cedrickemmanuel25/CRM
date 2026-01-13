@forelse($requests as $request)
    <tr>
        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
            <div class="flex items-center">
                <div class="h-10 w-10 flex-shrink-0">
                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                        <span class="text-indigo-700 font-bold">{{ strtoupper(substr($request->prenom, 0, 1) . substr($request->nom, 0, 1)) }}</span>
                    </div>
                </div>
                <div class="ml-4">
                    <div class="font-medium text-gray-900">{{ $request->prenom }} {{ $request->nom }}</div>
                </div>
            </div>
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
            <div class="text-sm text-gray-900">{{ $request->email }}</div>
            <div class="text-sm text-gray-500">{{ format_phone($request->telephone) }}</div>
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 capitalize">
                {{ $request->role }}
            </span>
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
            {{ $request->created_at->format('d/m/Y H:i') }}
        </td>
        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
            <div class="flex justify-end space-x-3">
                <form action="{{ route('admin.access-requests.approve', $request->id) }}" method="POST" onsubmit="return confirm('Créer cet utilisateur ?')">
                    @csrf
                    <button type="submit" class="text-green-600 hover:text-green-900 bg-green-50 px-3 py-1 rounded-md transition">Approuver</button>
                </form>
                <form action="{{ route('admin.access-requests.reject', $request->id) }}" method="POST" onsubmit="return confirm('Rejeter cette demande ?')">
                    @csrf
                    <button type="submit" class="text-rose-600 hover:text-rose-900 bg-rose-50 px-3 py-1 rounded-md transition">Rejeter</button>
                </form>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-500 italic">
            Aucune demande d'accès en attente.
        </td>
    </tr>
@endforelse
