<div x-data="{ 
    open: false, 
    count: {{ auth()->user()->unreadNotifications->count() }},
    notifications: @js(auth()->user()->unreadNotifications->take(5)),
    init() {
        setInterval(() => {
            this.pollNotifications();
        }, 30000);
    },
    pollNotifications() {
        fetch('{{ route('notifications.fetch') }}', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                this.count = data.count;
                this.notifications = data.notifications;
            });
    },
    markAsRead(id) {
        fetch('/notifications/' + id + '/read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                'Content-Type': 'application/json'
            }
        }).then(() => {
            this.count--;
            this.notifications = this.notifications.filter(n => n.id !== id);
        });
    },
    deleteNotification(id) {
        if (!confirm('Supprimer cette notification ?')) return;
        fetch('/notifications/' + id, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                'Content-Type': 'application/json'
            }
        }).then(() => {
            const wasUnread = this.notifications.find(n => n.id === id)?.read_at === null;
            if (wasUnread) this.count--;
            this.notifications = this.notifications.filter(n => n.id !== id);
        });
    }
}" class="relative ml-4">
    <button @click="open = !open" class="bg-white p-1 rounded-full text-slate-400 hover:text-slate-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 relative">
        <span class="sr-only">Voir les notifications</span>
        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        <div x-show="count > 0" class="absolute top-0 right-0 -mr-1 -mt-1 w-4 h-4 bg-red-500 rounded-full flex items-center justify-center">
            <span class="text-[10px] font-bold text-white" x-text="count"></span>
        </div>
    </button>

    <div x-show="open" @click.away="open = false" 
         class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50 p-2"
         style="display: none;">
        <div class="px-4 py-2 border-b border-slate-100 flex justify-between items-center">
            <h3 class="text-sm font-semibold text-slate-900">Notifications</h3>
            <div class="flex gap-2">
                <a href="{{ route('notifications.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800">Voir tout</a>
            </div>
        </div>
        
        <template x-if="notifications.length === 0">
            <div class="px-4 py-6 text-center text-sm text-slate-500">
                Aucune nouvelle notification
            </div>
        </template>

        <template x-for="notification in notifications" :key="notification.id">
            <div class="px-4 py-3 hover:bg-slate-50 transition-colors border-b border-slate-50 last:border-0 relative group">
                <div class="flex items-start">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-900" x-text="notification.data.message"></p>
                        <p class="text-xs text-slate-500 mt-0.5" x-text="new Date(notification.created_at).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' })"></p>
                        <template x-if="notification.data && notification.data.action_url">
                            <a :href="notification.data.action_url" class="mt-2 inline-flex items-center text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                                Voir détails
                                <svg class="ml-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </template>
                    </div>
                    <div class="flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-all">
                        <button @click="markAsRead(notification.id)" class="bg-white rounded-full p-1 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50" title="Marquer comme lu">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                        <button @click="deleteNotification(notification.id)" class="bg-white rounded-full p-1 text-slate-400 hover:text-rose-600 hover:bg-rose-50" title="Supprimer">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>
