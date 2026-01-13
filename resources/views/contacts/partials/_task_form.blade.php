<form action="{{ route('tasks.store') }}" method="POST">
    @csrf
    <input type="hidden" name="related_id" value="{{ $contact->id }}">
    <input type="hidden" name="related_type" value="App\Models\Contact">
    
    <div class="mb-6">
        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Sujet du rappel / Tâche</label>
        <input type="text" name="titre" required class="block w-full border-gray-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500/20 sm:text-sm px-4 py-2.5" placeholder="Ex: Rappeler pour valider le devis...">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Échéance</label>
            <input type="date" name="due_date" required class="block w-full border-gray-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500/20 sm:text-sm px-4 py-2.5" value="{{ date('Y-m-d', strtotime('+1 day')) }}">
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Priorité</label>
            <select name="priority" class="block w-full border-gray-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500/20 sm:text-sm px-4 py-2.5">
                <option value="low">Basse</option>
                <option value="medium" selected>Normale</option>
                <option value="high">Haute / Urgente</option>
            </select>
        </div>
    </div>

    <div class="mb-6">
        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Assigné à</label>
        @php
            $users = \App\Models\User::all();
        @endphp
        <select name="assigned_to" class="block w-full border-gray-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500/20 sm:text-sm px-4 py-2.5">
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ $user->id == auth()->id() ? 'selected' : '' }}>{{ $user->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-6">
        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Instructions supplémentaires</label>
        <textarea name="description" rows="3" class="block w-full border-gray-200 rounded-2xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500/20 sm:text-sm px-4 py-3" placeholder="Détails de la tâche..."></textarea>
    </div>

    <div class="flex justify-end">
        <button type="submit" class="inline-flex items-center px-8 py-3 border border-transparent shadow-lg text-sm font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 transition-all">
            Programmer le rappel
        </button>
    </div>
</form>
