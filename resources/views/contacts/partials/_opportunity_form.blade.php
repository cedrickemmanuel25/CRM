<form action="{{ route('opportunities.store') }}" method="POST">
    @csrf
    <input type="hidden" name="contact_id" value="{{ $contact->id }}">
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <div>
            <label class="label-caps mb-2.5 block">Titre de l'opportunité</label>
            <input type="text" name="titre" required class="block w-full bg-white/5 border border-white/10 rounded-xl text-sm text-slate-100 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-5 py-3.5 placeholder-slate-600" placeholder="Ex: Projet Refonte Web...">
        </div>
        <div>
            <label class="label-caps mb-2.5 block">Montant Estimé (€)</label>
            <input type="number" name="montant_estime" required step="0.01" class="block w-full bg-white/5 border border-white/10 rounded-xl text-sm text-slate-100 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-5 py-3.5 placeholder-slate-600" placeholder="5000">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <div>
            <label class="label-caps mb-2.5 block">Stade actuel</label>
            <select name="stade" class="block w-full bg-white/5 border border-white/10 rounded-xl text-sm text-slate-100 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-5 py-3.5 appearance-none cursor-pointer">
                <option value="prospection" class="bg-[#1e293b]">Prospection</option>
                <option value="qualification" class="bg-[#1e293b]">Qualification</option>
                <option value="proposition" class="bg-[#1e293b]">Proposition</option>
                <option value="negociation" class="bg-[#1e293b]">Négociation</option>
            </select>
        </div>
        <div>
            <label class="label-caps mb-2.5 block">Probabilité (%)</label>
            <input type="number" name="probabilite" required min="0" max="100" class="block w-full bg-white/5 border border-white/10 rounded-xl text-sm text-slate-100 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-5 py-3.5" value="20">
        </div>
    </div>

    <div class="mb-10">
        <label class="label-caps mb-2.5 block">Date de clôture estimée</label>
        <input type="date" name="date_cloture_prev" required class="block w-full bg-white/5 border border-white/10 rounded-xl text-sm text-slate-100 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-5 py-3.5" value="{{ date('Y-m-d', strtotime('+1 month')) }}">
    </div>

    <div class="flex justify-end">
        <button type="submit" class="inline-flex items-center px-10 py-3.5 bg-blue-600 text-white text-[11px] font-black uppercase tracking-widest rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-900/20 active:scale-95">
            Créer l'opportunité
        </button>
    </div>
</form>
