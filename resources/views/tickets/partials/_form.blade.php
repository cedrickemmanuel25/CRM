@php
    $isModal = $isModal ?? false;
@endphp

<form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data" id="create-ticket-form">
    @csrf

    @if ($errors->any() && $isModal)
        <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3">
            <div class="flex items-start gap-3">
                <svg class="h-5 w-5 text-rose-600 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M10.29 3.86l-7.5 13A1.5 1.5 0 004.09 19h15.82a1.5 1.5 0 001.3-2.14l-7.5-13a1.5 1.5 0 00-2.42 0z" />
                </svg>
                <div>
                    <p class="text-sm font-bold text-rose-800">Certaines informations sont manquantes ou invalides.</p>
                    <p class="text-sm text-rose-700">Corrigez les champs surlignés puis réessayez.</p>
                </div>
            </div>
        </div>
    @endif

    <div class="space-y-6">
        <!-- Subject -->
        <div class="space-y-2">
            <label for="subject" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Sujet de la demande <span class="text-rose-600">*</span></label>
            <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                class="block w-full px-4 py-3 border rounded-lg text-sm font-bold text-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all shadow-sm {{ $errors->has('subject') ? 'border-rose-300 bg-rose-50/30' : 'border-slate-300' }}"
                placeholder="Ex: Erreur lors de l'export PDF">
            @error('subject') <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
        </div>

        <!-- Client -->
        <div class="space-y-2" x-data="contactCombobox({
            items: [
                @foreach(($contacts ?? []) as $c)
                    { id: '{{ $c->id }}', label: @js($c->nom_complet) },
                @endforeach
            ],
            initialId: @js((string) old('contact_id')),
            placeholder: 'Rechercher un client...'
        })">
            <label for="contact_id" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Client concerné <span class="text-rose-600">*</span></label>
            <select id="contact_id" name="contact_id" required class="hidden">
                <option value="">-- Sélectionner un client --</option>
                @foreach(($contacts ?? []) as $contact)
                    <option value="{{ $contact->id }}" {{ (string) old('contact_id') === (string) $contact->id ? 'selected' : '' }}>{{ $contact->nom_complet }}</option>
                @endforeach
            </select>
            <div class="relative">
                <div class="relative">
                    <input type="text"
                        x-model="query"
                        @focus="open = true"
                        @keydown.escape.window="open = false"
                        @click.away="open = false"
                        @keydown.arrow-down.prevent="highlightNext()"
                        @keydown.arrow-up.prevent="highlightPrev()"
                        @keydown.enter.prevent="commitHighlighted()"
                        class="block w-full pl-10 pr-10 py-2.5 text-sm font-semibold border rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all bg-slate-50/50 {{ $errors->has('contact_id') ? 'border-rose-300' : 'border-slate-300' }}"
                        :placeholder="placeholder"
                    >
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                        </svg>
                    </div>
                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-500" @click="toggle()">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <div x-show="open" x-transition.opacity class="absolute z-20 mt-2 w-full rounded-xl border border-slate-200 bg-white shadow-lg overflow-hidden" style="display:none;">
                    <div class="max-h-64 overflow-auto">
                        <template x-if="filtered.length === 0">
                            <div class="px-4 py-3 text-sm text-slate-600">Aucun résultat.</div>
                        </template>
                        <template x-for="(item, idx) in filtered" :key="item.id">
                            <button type="button"
                                class="w-full text-left px-4 py-2.5 text-sm font-semibold hover:bg-slate-50 flex items-center justify-between"
                                :class="idx === highlighted ? 'bg-slate-50' : ''"
                                @mouseenter="highlighted = idx"
                                @click="select(item)">
                                <span x-text="item.label"></span>
                                <svg x-show="item.id === selectedId" class="h-4 w-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display:none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                            </button>
                        </template>
                    </div>
                </div>
            </div>
            @error('contact_id') <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
        </div>

        <!-- Category -->
        <div class="space-y-2">
            <label for="category" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Catégorie <span class="text-rose-600">*</span></label>
            <select id="category" name="category" required
                class="block w-full pl-3 pr-10 py-2.5 text-sm font-semibold border rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all bg-slate-50/50 {{ $errors->has('category') ? 'border-rose-300' : 'border-slate-300' }}">
                <option value="">Sélectionner...</option>
                <option value="technical" {{ old('category') === 'technical' ? 'selected' : '' }}>🛠️ Support Technique</option>
                <option value="commercial" {{ old('category') === 'commercial' ? 'selected' : '' }}>💼 Administratif & Commercial</option>
                <option value="billing" {{ old('category') === 'billing' ? 'selected' : '' }}>💳 Facturation & Paiement</option>
                <option value="feature_request" {{ old('category') === 'feature_request' ? 'selected' : '' }}>💡 Demande d'évolution</option>
                <option value="other" {{ old('category') === 'other' ? 'selected' : '' }}>❓ Autre</option>
            </select>
            @error('category') <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
        </div>

        <!-- Priority -->
        <div class="space-y-2">
            <label for="priority" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Niveau d'urgence <span class="text-rose-600">*</span></label>
            <select id="priority" name="priority" required
                class="block w-full pl-3 pr-10 py-2.5 text-sm font-semibold border rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all bg-slate-50/50 {{ $errors->has('priority') ? 'border-rose-300' : 'border-slate-300' }}">
                <option value="low" {{ old('priority', 'medium') === 'low' ? 'selected' : '' }}>Basse</option>
                <option value="medium" {{ old('priority', 'medium') === 'medium' ? 'selected' : '' }}>Moyenne</option>
                <option value="high" {{ old('priority', 'medium') === 'high' ? 'selected' : '' }}>Haute</option>
                <option value="urgent" {{ old('priority', 'medium') === 'urgent' ? 'selected' : '' }}>Urgente</option>
            </select>
            @error('priority') <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
        </div>

        <!-- Description -->
        <div class="space-y-2">
            <label for="description" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Description détaillée <span class="text-rose-600">*</span></label>
            <textarea id="description" name="description" rows="8" required
                class="block w-full px-4 py-3 border rounded-lg text-sm font-medium text-slate-700 leading-relaxed focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all shadow-sm {{ $errors->has('description') ? 'border-rose-300 bg-rose-50/30' : 'border-slate-300' }}"
                placeholder="Décrivez le problème rencontré...">{{ old('description') }}</textarea>
            @error('description') <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
        </div>

        <!-- Attachment -->
        <div class="space-y-2">
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Pièces jointes</label>
            <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50/40 px-6 py-8 hover:bg-slate-50 transition-colors">
                <div class="flex flex-col items-center justify-center text-center">
                    <svg class="h-12 w-12 text-slate-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    <label for="attachment" class="cursor-pointer">
                        <span class="text-sm font-semibold text-slate-900">Cliquez pour ajouter un fichier</span>
                    </label>
                    <input id="attachment" name="attachment" type="file" class="sr-only">
                    <p class="mt-2 text-xs text-slate-500">ou glissez-déposez ici (Max 10Mo)</p>
                    <p id="file-name" class="mt-2 text-sm font-bold text-indigo-700 hidden"></p>
                </div>
            </div>
            @error('attachment') <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
        </div>
    </div>
</form>

@push('scripts')
<script>
    (function () {
        const attachment = document.getElementById('attachment');
        const fileNameEl = document.getElementById('file-name');
        
        function formatBytes(bytes) {
            if (!bytes && bytes !== 0) return '';
            const units = ['B', 'KB', 'MB', 'GB'];
            let i = 0;
            let n = bytes;
            while (n >= 1024 && i < units.length - 1) { n /= 1024; i++; }
            return `${n.toFixed(i === 0 ? 0 : 1)} ${units[i]}`;
        }

        function updateAttachment() {
            const f = attachment?.files?.[0];
            if (!f) {
                fileNameEl?.classList.add('hidden');
                return;
            }
            fileNameEl.textContent = `${f.name} (${formatBytes(f.size)})`;
            fileNameEl.classList.remove('hidden');
        }

        attachment?.addEventListener('change', updateAttachment);
        updateAttachment();
    })();
</script>
<script>
    function contactCombobox({ items, initialId = '', placeholder = '', allowEmpty = false }) {
        return {
            items: items || [],
            placeholder,
            allowEmpty,
            open: false,
            query: '',
            selectedId: initialId || '',
            highlighted: 0,
            init() {
                const initial = this.items.find(i => String(i.id) === String(this.selectedId));
                this.query = initial ? initial.label : '';
                this.syncSelect();
            },
            get filtered() {
                const q = (this.query || '').toLowerCase().trim();
                if (!q) return this.items.slice(0, 50);
                return this.items
                    .filter(i => (i.label || '').toLowerCase().includes(q))
                    .slice(0, 50);
            },
            toggle() {
                this.open = !this.open;
                if (this.open) this.highlighted = 0;
            },
            select(item) {
                this.selectedId = item.id;
                this.query = item.label;
                this.open = false;
                this.syncSelect();
            },
            clear() {
                this.selectedId = '';
                this.query = '';
                this.open = false;
                this.syncSelect();
            },
            syncSelect() {
                const select = this.$root.querySelector('select');
                if (!select) return;
                select.value = this.selectedId;
                select.dispatchEvent(new Event('change', { bubbles: true }));
            },
            highlightNext() {
                if (!this.open) this.open = true;
                this.highlighted = Math.min(this.highlighted + 1, Math.max(this.filtered.length - 1, 0));
            },
            highlightPrev() {
                if (!this.open) this.open = true;
                this.highlighted = Math.max(this.highlighted - 1, 0);
            },
            commitHighlighted() {
                const item = this.filtered[this.highlighted];
                if (item) this.select(item);
            },
        };
    }
</script>
@endpush
