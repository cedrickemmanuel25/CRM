<form action="{{ route('activities.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="parent_type" value="App\Models\Contact">
    <input type="hidden" name="parent_id" value="{{ $contact->id }}">
    
<form action="{{ route('activities.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="parent_type" value="App\Models\Contact">
    <input type="hidden" name="parent_id" value="{{ $contact->id }}">
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div>
            <label class="label-caps mb-2.5 block">Type d'activité</label>
            <select name="type" class="block w-full bg-white/5 border border-white/10 rounded-xl text-sm text-slate-100 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-3 appearance-none cursor-pointer">
                <option value="appel" class="bg-[#1e293b]">Appel Téléphonique</option>
                <option value="email" class="bg-[#1e293b]">Email Envoyé/Reçu</option>
                <option value="reunion" class="bg-[#1e293b]">Réunion Client</option>
                <option value="tache" class="bg-[#1e293b]">Tâche effectuée</option>
                <option value="note" class="bg-[#1e293b]">Note Interne</option>
            </select>
        </div>
        <div>
            <label class="label-caps mb-2.5 block">Date</label>
            <input type="date" name="date_activite" value="{{ date('Y-m-d') }}" class="block w-full bg-white/5 border border-white/10 rounded-xl text-sm text-slate-100 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-3">
        </div>
        <div>
            <label class="label-caps mb-2.5 block">Durée (min)</label>
            <input type="number" name="duree" placeholder="15" step="5" class="block w-full bg-white/5 border border-white/10 rounded-xl text-sm text-slate-100 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-3 placeholder-slate-600">
        </div>
    </div>
    
    <div class="mb-8">
        <label class="label-caps mb-2.5 block">Sujet / Description rapide</label>
        <input type="text" name="description" class="block w-full bg-white/5 border border-white/10 rounded-xl text-sm text-slate-100 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-3 placeholder-slate-600" placeholder="Ex: Appel exploratoire concernant le projet X...">
    </div>

    <div class="mb-8">
        <label class="label-caps mb-2.5 block">Détails (Contenu)</label>
        <textarea name="contenu" rows="4" class="block w-full bg-white/5 border border-white/10 rounded-2xl text-sm text-slate-100 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-4 placeholder-slate-600 custom-scrollbar" placeholder="Compte-rendu détaillé de l'échange..."></textarea>
    </div>

    <div class="flex flex-col sm:flex-row gap-6 mb-2 items-stretch sm:items-end">
        <div class="flex-1">
            <label class="label-caps mb-2.5 block">Pièce Jointe</label>
            <div class="flex items-center justify-center w-full">
                <label class="flex flex-col items-center justify-center w-full h-14 border-2 border-white/10 border-dashed rounded-xl cursor-pointer bg-white/5 hover:bg-white/10 transition-all group">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-slate-500 group-hover:text-blue-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest group-hover:text-slate-300 transition-colors">Choisir un fichier</span>
                    </div>
                    <input type="file" name="piece_jointe" class="hidden" />
                </label>
            </div>
        </div>
        <div class="flex justify-end sm:justify-start">
            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-10 py-4 bg-blue-600 text-white text-[11px] font-black uppercase tracking-widest rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-900/20 active:scale-95">
                Enregistrer l'activité
            </button>
        </div>
    </div>
</form>
</form>
