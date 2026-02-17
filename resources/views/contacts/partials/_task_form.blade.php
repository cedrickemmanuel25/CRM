<form action="{{ route('tasks.store') }}" method="POST">
    @csrf
    <input type="hidden" name="related_id" value="{{ $contact->id }}">
    <input type="hidden" name="related_type" value="App\Models\Contact">
    
    <div class="mb-8">
        <label class="label-caps mb-2.5 block">Sujet du rappel / Tâche</label>
        <input type="text" name="titre" required class="block w-full bg-white/5 border border-white/10 rounded-xl text-sm text-slate-100 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-5 py-3.5 placeholder-slate-600" placeholder="Ex: Rappeler pour valider le devis...">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <div>
            <label class="label-caps mb-2.5 block">Échéance</label>
            <input type="date" name="due_date" required class="block w-full bg-white/5 border border-white/10 rounded-xl text-sm text-slate-100 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-5 py-3.5" value="{{ date('Y-m-d', strtotime('+1 day')) }}">
        </div>
        <div>
            <label class="label-caps mb-2.5 block">Priorité</label>
            <select name="priority" class="block w-full bg-white/5 border border-white/10 rounded-xl text-sm text-slate-100 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-5 py-3.5 appearance-none cursor-pointer">
                <option value="low" class="bg-[#1e293b]">Basse</option>
                <option value="medium" selected class="bg-[#1e293b]">Normale</option>
                <option value="high" class="bg-[#1e293b]">Haute / Urgente</option>
            </select>
        </div>
    </div>

    <div class="mb-8">
        <label class="label-caps mb-2.5 block">Assigné à</label>
        @php
            $users = \App\Models\User::all();
        @endphp
        <select name="assigned_to" class="block w-full bg-white/5 border border-white/10 rounded-xl text-sm text-slate-100 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-5 py-3.5 appearance-none cursor-pointer">
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ $user->id == auth()->id() ? 'selected' : '' }} class="bg-[#1e293b]">{{ $user->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-10">
        <label class="label-caps mb-2.5 block">Instructions supplémentaires</label>
        <textarea name="description" rows="3" class="block w-full bg-white/5 border border-white/10 rounded-2xl text-sm text-slate-100 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-5 py-4 placeholder-slate-600 custom-scrollbar" placeholder="Détails de la tâche..."></textarea>
    </div>

    <div class="flex justify-end">
        <button type="submit" class="inline-flex items-center px-10 py-3.5 bg-blue-600 text-white text-[11px] font-black uppercase tracking-widest rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-900/20 active:scale-95">
            Programmer le rappel
        </button>
    </div>
</form>
