<form action="{{ route('activities.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="parent_type" value="App\Models\Contact">
    <input type="hidden" name="parent_id" value="{{ $contact->id }}">
    
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-6">
        <div class="md:col-span-4">
            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Type d'activité</label>
            <select name="type" class="block w-full border-gray-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500/20 sm:text-sm transition-all px-4 py-2.5">
                <option value="appel">Appel Téléphonique</option>
                <option value="email">Email Envoyé/Reçu</option>
                <option value="reunion">Réunion Client</option>
                <option value="tache">Tâche effectuée</option>
                <option value="note">Note Interne</option>
            </select>
        </div>
        <div class="md:col-span-4">
            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Date</label>
            <input type="date" name="date_activite" value="{{ date('Y-m-d') }}" class="block w-full border-gray-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500/20 sm:text-sm transition-all px-4 py-2.5">
        </div>
        <div class="md:col-span-4">
            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Durée (min)</label>
            <input type="number" name="duree" placeholder="15" step="5" class="block w-full border-gray-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500/20 sm:text-sm transition-all px-4 py-2.5">
        </div>
    </div>
    
    <div class="mb-6">
        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Sujet / Description rapide</label>
        <input type="text" name="description" class="block w-full border-gray-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500/20 sm:text-sm transition-all px-4 py-2.5" placeholder="Ex: Appel exploratoire concernant le projet X...">
    </div>

    <div class="mb-6">
        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Détails (Contenu)</label>
        <textarea name="contenu" rows="4" class="block w-full border-gray-200 rounded-2xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500/20 sm:text-sm transition-all px-4 py-3" placeholder="Compte-rendu détaillé de l'échange..."></textarea>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-8 items-end">
        <div class="md:col-span-6">
            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Pièce Jointe</label>
            <div class="flex items-center justify-center w-full">
                <label class="flex flex-col items-center justify-center w-full h-12 border-2 border-gray-200 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-white transition-colors">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-tighter">Choisir un fichier</span>
                    </div>
                    <input type="file" name="piece_jointe" class="hidden" />
                </label>
            </div>
        </div>
        <div class="md:col-span-6 flex justify-end">
            <button type="submit" class="inline-flex items-center px-8 py-3 border border-transparent shadow-lg text-sm font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                Enregistrer l'activité
            </button>
        </div>
    </div>
</form>
