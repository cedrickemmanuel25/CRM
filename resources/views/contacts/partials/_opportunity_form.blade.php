<form action="{{ route('opportunities.store') }}" method="POST">
    @csrf
    <input type="hidden" name="contact_id" value="{{ $contact->id }}">
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Titre de l'opportunité</label>
            <input type="text" name="titre" required class="block w-full border-gray-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500/20 sm:text-sm px-4 py-2.5" placeholder="Ex: Projet Refonte Web...">
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Montant Estimé (€)</label>
            <input type="number" name="montant_estime" required step="0.01" class="block w-full border-gray-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500/20 sm:text-sm px-4 py-2.5" placeholder="5000">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Stade actuel</label>
            <select name="stade" class="block w-full border-gray-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500/20 sm:text-sm px-4 py-2.5">
                <option value="prospection">Prospection</option>
                <option value="qualification">Qualification</option>
                <option value="proposition">Proposition</option>
                <option value="negociation">Négociation</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Probabilité (%)</label>
            <input type="number" name="probabilite" required min="0" max="100" class="block w-full border-gray-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500/20 sm:text-sm px-4 py-2.5" value="20">
        </div>
    </div>

    <div class="mb-6">
        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Date de clôture estimée</label>
        <input type="date" name="date_cloture_prev" required class="block w-full border-gray-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500/20 sm:text-sm px-4 py-2.5" value="{{ date('Y-m-d', strtotime('+1 month')) }}">
    </div>

    <div class="flex justify-end">
        <button type="submit" class="inline-flex items-center px-8 py-3 border border-transparent shadow-lg text-sm font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 transition-all">
            Créer l'opportunité
        </button>
    </div>
</form>
