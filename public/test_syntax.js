window.calendarApp = function () {
    return {
        currentView: 'month',
        currentDate: new Date(),
        showEventModal: false,
        showEventDetail: false,
        selectedEvent: null,

        events: [],

        newEvent: {
            title: '',
            startDate: '',
            startTime: '09:00',
            endDate: '',
            endTime: '10:00',
            type: 'meeting',
            description: ''
        },

        daysOfWeek: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
        hours: ['00:00', '01:00', '02:00', '03:00', '04:00', '05:00', '06:00', '07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00'],

        monthDays: [],
        weekDays: [],
        upcomingEvents: [],

        init() {
            this.generateMonthDays();
            this.generateWeekDays();
            this.updateUpcomingEvents();

            // Set default dates for new event
            const today = new Date();
            this.newEvent.startDate = this.formatDate(today);
            this.newEvent.endDate = this.formatDate(today);
        },

        get currentPeriodLabel() {
            if (this.currentView === 'month') {
                return this.currentDate.toLocaleDateString('fr-FR', { month: 'long', year: 'numeric' });
            } else if (this.currentView === 'week') {
                const weekStart = this.getWeekStart(this.currentDate);
                const weekEnd = new Date(weekStart);
                weekEnd.setDate(weekEnd.getDate() + 6);
                return `${weekStart.toLocaleDateString('fr-FR', { day: 'numeric', month: 'short' })} - ${weekEnd.toLocaleDateString('fr-FR', { day: 'numeric', month: 'short', year: 'numeric' })}`;
            } else {
                return this.currentDate.toLocaleDateString('fr-FR', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
            }
        },

        generateMonthDays() {
            const year = this.currentDate.getFullYear();
            const month = this.currentDate.getMonth();

            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);

            let startDay = firstDay.getDay();
            startDay = startDay === 0 ? 6 : startDay - 1;

            this.monthDays = [];

            // Previous month days
            const prevMonthLastDay = new Date(year, month, 0).getDate();
            for (let i = startDay - 1; i >= 0; i--) {
                const date = new Date(year, month - 1, prevMonthLastDay - i);
                this.monthDays.push({
                    dayNumber: date.getDate(),
                    date: this.formatDate(date),
                    isCurrentMonth: false
                });
            }

            // Current month days
            for (let i = 1; i <= lastDay.getDate(); i++) {
                const date = new Date(year, month, i);
                this.monthDays.push({
                    dayNumber: i,
                    date: this.formatDate(date),
                    isCurrentMonth: true
                });
            }

            // Next month days to complete grid
            const remainingDays = 42 - this.monthDays.length;
            for (let i = 1; i <= remainingDays; i++) {
                const date = new Date(year, month + 1, i);
                this.monthDays.push({
                    dayNumber: i,
                    date: this.formatDate(date),
                    isCurrentMonth: false
                });
            }
        },

        generateWeekDays() {
            const weekStart = this.getWeekStart(this.currentDate);
            this.weekDays = [];

            for (let i = 0; i < 7; i++) {
                const date = new Date(weekStart);
                date.setDate(date.getDate() + i);
                this.weekDays.push({
                    date: this.formatDate(date),
                    dayNumber: date.getDate(),
                    dayName: date.toLocaleDateString('fr-FR', { weekday: 'short' })
                });
            }
        },

        getWeekStart(date) {
            const d = new Date(date);
            const day = d.getDay();
            const diff = d.getDate() - day + (day === 0 ? -6 : 1);
            return new Date(d.setDate(diff));
        },

        formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        },

        formatDayName(dateStr) {
            return new Date(dateStr).toLocaleDateString('fr-FR', { weekday: 'long' });
        },

        formatTimeRange(start, end) {
            const startDate = new Date(start);
            const endDate = new Date(end);
            return `${startDate.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' })} - ${endDate.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' })}`;
        },

        isToday(dateStr) {
            return dateStr === this.formatDate(new Date());
        },

        getEventsForDate(dateStr) {
            return this.events.filter(event => {
                const eventDate = new Date(event.start);
                return this.formatDate(eventDate) === dateStr;
            });
        },

        updateUpcomingEvents() {
            const now = new Date();
            // Filter future events
            this.upcomingEvents = this.events
                .filter(e => new Date(e.start) >= now)
                .sort((a, b) => new Date(a.start) - new Date(b.start))
                .slice(0, 5);
        },

        formatDateShort(dateStr) {
            const date = new Date(dateStr);
            return date.toLocaleDateString('fr-FR', { day: 'numeric', month: 'short' });
        },

        formatTime(dateStr) {
            const d = new Date(dateStr);
            return d.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
        },

        getEventColor(type) {
            const colors = {
                task: 'bg-blue-100 text-blue-700 border-blue-200',
                call: 'bg-indigo-100 text-indigo-700 border-indigo-200',
                email: 'bg-purple-100 text-purple-700 border-purple-200',
                meeting: 'bg-amber-100 text-amber-700 border-amber-200',
                note: 'bg-gray-100 text-gray-700 border-gray-200'
            };
            return colors[type] || colors.note;
        },

        getEventTop(startTime) {
            const date = new Date(startTime);
            const hours = date.getHours();
            const minutes = date.getMinutes();
            return (hours * 64) + (minutes * 64 / 60); // 64px per hour (h-16 = 4rem = 64px)
        },

        getEventHeight(startTime, endTime) {
            const start = new Date(startTime);
            const end = new Date(endTime);
            const diffMinutes = (end - start) / 1000 / 60;
            return Math.max((diffMinutes * 64 / 60), 32); // Minimum 32px height
        },

        previousPeriod() {
            if (this.currentView === 'month') {
                this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() - 1, 1);
                this.generateMonthDays();
            } else if (this.currentView === 'week') {
                this.currentDate = new Date(this.currentDate.setDate(this.currentDate.getDate() - 7));
                this.generateWeekDays();
            } else {
                this.currentDate = new Date(this.currentDate.setDate(this.currentDate.getDate() - 1));
            }
        },

        nextPeriod() {
            if (this.currentView === 'month') {
                this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() + 1, 1);
                this.generateMonthDays();
            } else if (this.currentView === 'week') {
                this.currentDate = new Date(this.currentDate.setDate(this.currentDate.getDate() + 7));
                this.generateWeekDays();
            } else {
                this.currentDate = new Date(this.currentDate.setDate(this.currentDate.getDate() + 1));
            }
        },

        goToToday() {
            this.currentDate = new Date();
            if (this.currentView === 'month') {
                this.generateMonthDays();
            } else if (this.currentView === 'week') {
                this.generateWeekDays();
            }
        },

        openEventModal(date) {
            this.newEvent.startDate = date;
            this.newEvent.endDate = date;
            this.showEventModal = true;
        },

        openEventDetail(event) {
            this.selectedEvent = event;
            this.showEventDetail = true;
        },

        saveEvent() {
            const newEvent = {
                id: Date.now(),
                title: this.newEvent.title,
                start: `${this.newEvent.startDate}T${this.newEvent.startTime}`,
                end: `${this.newEvent.endDate}T${this.newEvent.endTime}`,
                type: this.newEvent.type,
                description: this.newEvent.description
            };

            this.events.push(newEvent);

            // Reset form
            this.newEvent = {
                title: '',
                startDate: this.formatDate(new Date()),
                startTime: '09:00',
                endDate: this.formatDate(new Date()),
                endTime: '10:00',
                type: 'meeting',
                description: ''
            };

            this.showEventModal = false;
        },

        deleteEvent(eventId) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cet événement ?')) {
                this.events = this.events.filter(e => e.id !== eventId);
                this.showEventDetail = false;
            }
        }
    }
}
