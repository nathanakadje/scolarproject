<div>
    <!-- Page Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Mon Calendrier</h1>
                <p class="text-gray-600 mt-2">Planifiez et gérez toutes vos activités pédagogiques</p>
            </div>
            <div class="flex items-center space-x-3">
                <button 
                    wire:click="exportCalendar('ics')"
                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Exporter</span>
                </button>
                <button 
                    wire:click="openEventModal"
                    class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors font-medium flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Nouvel Événement</span>
                </button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6">
        <!-- Main Calendar -->
        <div class="col-span-12 lg:col-span-9">
            <!-- Calendar Controls -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
                <div class="flex items-center justify-between">
                    <!-- Navigation -->
                    <div class="flex items-center space-x-4">
                        <button 
                            wire:click="previousPeriod"
                            class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        
                        <h2 class="text-xl font-bold text-gray-900 min-w-[200px] text-center">
                            {{ \Carbon\Carbon::parse($currentDate)->locale('fr')->isoFormat('MMMM YYYY') }}
                        </h2>
                        
                        <button 
                            wire:click="nextPeriod"
                            class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                        
                        <button 
                            wire:click="today"
                            class="px-4 py-2 bg-emerald-100 text-emerald-700 rounded-lg hover:bg-emerald-200 transition-colors font-medium">
                            Aujourd'hui
                        </button>
                    </div>

                    <!-- View Mode Selector -->
                    <div class="flex items-center space-x-2 bg-gray-100 rounded-lg p-1">
                        <button 
                            wire:click="changeViewMode('month')"
                            class="px-4 py-2 rounded-lg font-medium transition-colors {{ $viewMode === 'month' ? 'bg-white text-emerald-600 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                            Mois
                        </button>
                        <button 
                            wire:click="changeViewMode('week')"
                            class="px-4 py-2 rounded-lg font-medium transition-colors {{ $viewMode === 'week' ? 'bg-white text-emerald-600 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                            Semaine
                        </button>
                        <button 
                            wire:click="changeViewMode('agenda')"
                            class="px-4 py-2 rounded-lg font-medium transition-colors {{ $viewMode === 'agenda' ? 'bg-white text-emerald-600 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                            Agenda
                        </button>
                    </div>
                </div>
            </div>

            <!-- Calendar Grid (Month View) -->
            @if($viewMode === 'month' && $calendarData)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Days Header -->
                <div class="grid grid-cols-7 border-b border-gray-200 bg-gray-50">
                    @foreach(['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'] as $day)
                    <div class="p-3 text-center text-sm font-semibold text-gray-600">
                        {{ $day }}
                    </div>
                    @endforeach
                </div>

                <!-- Calendar Days -->
                @foreach($calendarData as $week)
                <div class="grid grid-cols-7 border-b border-gray-200 last:border-b-0">
                    @foreach($week as $day)
                    <div class="min-h-[120px] border-r border-gray-200 last:border-r-0 p-2 {{ $day['isCurrentMonth'] ? 'bg-white' : 'bg-gray-50' }} {{ $day['isToday'] ? 'ring-2 ring-emerald-500 ring-inset' : '' }} hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium {{ $day['isToday'] ? 'bg-emerald-600 text-white w-7 h-7 rounded-full flex items-center justify-center' : ($day['isCurrentMonth'] ? 'text-gray-900' : 'text-gray-400') }}">
                                {{ $day['day'] }}
                            </span>
                            @if($day['events']->count() > 3)
                            <span class="text-xs text-gray-500">+{{ $day['events']->count() - 3 }}</span>
                            @endif
                        </div>
                        
                        <div class="space-y-1">
                            @foreach($day['events']->take(3) as $event)
                            <button 
                                wire:click="viewEventDetails({{ $event->id }})"
                                class="w-full text-left px-2 py-1 rounded text-xs font-medium truncate transition-all hover:shadow-md"
                                style="background-color: {{ $event->color }}20; color: {{ $event->color }}; border-left: 3px solid {{ $event->color }}">
                                {{ $event->start_time ? \Carbon\Carbon::parse($event->start_time)->format('H:i') : '' }} 
                                {{ $event->title }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>
            @endif

            <!-- Agenda View -->
            @if($viewMode === 'agenda')
            <div class="space-y-4">
                @php
                    $groupedEvents = $this->events->groupBy(function($event) {
                        return \Carbon\Carbon::parse($event->start_date)->format('Y-m-d');
                    })->sortKeys();
                @endphp

                @forelse($groupedEvents as $date => $dayEvents)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-4 bg-gradient-to-r from-emerald-50 to-teal-50 border-b border-gray-200">
                        <h3 class="font-bold text-gray-900">
                            {{ \Carbon\Carbon::parse($date)->locale('fr')->isoFormat('dddd D MMMM YYYY') }}
                        </h3>
                        <p class="text-sm text-gray-600">{{ $dayEvents->count() }} événement(s)</p>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @foreach($dayEvents->sortBy('start_time') as $event)
                        <button 
                            wire:click="viewEventDetails({{ $event->id }})"
                            class="w-full p-4 hover:bg-gray-50 transition-colors text-left">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-16 text-center">
                                    @if($event->start_time)
                                    <div class="text-sm font-bold text-gray-900">
                                        {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}
                                    </div>
                                    @if($event->end_time)
                                    <div class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}
                                    </div>
                                    @endif
                                    @else
                                    <div class="text-xs text-gray-500">Toute la journée</div>
                                    @endif
                                </div>
                                
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-2 mb-1">
                                        <div class="w-3 h-3 rounded-full" style="background-color: {{ $event->color }}"></div>
                                        <h4 class="font-semibold text-gray-900">{{ $event->title }}</h4>
                                        <span class="text-xs px-2 py-1 rounded-full bg-{{ $event->getPriorityColor() }}-100 text-{{ $event->getPriorityColor() }}-800">
                                            {{ $event->getTypeLabel() }}
                                        </span>
                                    </div>
                                    @if($event->description)
                                    <p class="text-sm text-gray-600 line-clamp-2">{{ $event->description }}</p>
                                    @endif
                                    <div class="flex items-center space-x-3 mt-2 text-xs text-gray-500">
                                        @if($event->location)
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            </svg>
                                            {{ $event->location }}
                                        </span>
                                        @endif
                                        @if($event->classe)
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                            </svg>
                                            {{ $event->classe->full_name }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </button>
                        @endforeach
                    </div>
                </div>
                @empty
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-gray-500">Aucun événement pour cette période</p>
                </div>
                @endforelse
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-span-12 lg:col-span-3 space-y-6">
            <!-- Upcoming Events -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-4 border-b border-gray-200 bg-gradient-to-r from-emerald-500 to-teal-600">
                    <h3 class="font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Prochainement
                    </h3>
                </div>
                <div class="p-4 space-y-3 max-h-96 overflow-y-auto">
                    @forelse($upcomingEvents as $event)
                    <button 
                        wire:click="viewEventDetails({{ $event->id }})"
                        class="w-full text-left p-3 rounded-lg border-2 border-gray-200 hover:border-emerald-500 transition-all">
                        <div class="flex items-start space-x-2">
                            <div class="w-2 h-2 rounded-full mt-2" style="background-color: {{ $event->color }}"></div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-900 text-sm truncate">{{ $event->title }}</p>
                                <p class="text-xs text-gray-600">
                                    {{ $event->start_date->format('d/m') }}
                                    @if($event->start_time)
                                        à {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </button>
                    @empty
                    <p class="text-sm text-gray-500 text-center py-4">Aucun événement à venir</p>
                    @endforelse
                </div>
            </div>

            <!-- Administrative Deadlines -->
            @if($this->administrativeDeadlines->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-4 border-b border-gray-200 bg-gradient-to-r from-orange-500 to-red-600">
                    <h3 class="font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        Échéances Administratives
                    </h3>
                </div>
                <div class="p-4 space-y-3 max-h-96 overflow-y-auto">
                    @foreach($this->administrativeDeadlines as $deadline)
                    <div class="p-3 rounded-lg border-2 {{ $deadline->isPast() ? 'border-red-300 bg-red-50' : 'border-orange-200 bg-orange-50' }}">
                        <div class="flex items-start justify-between mb-2">
                            <div class="flex-1">
                                <p class="font-medium text-gray-900 text-sm">{{ $deadline->title }}</p>
                                <p class="text-xs text-gray-600 mt-1">{{ $deadline->getCategoryLabel() }}</p>
                            </div>
                            @if(!$deadline->isCompletedBy($teacher->id))
                            <button 
                                wire:click="markDeadlineComplete({{ $deadline->id }})"
                                class="flex-shrink-0 p-1 hover:bg-white rounded transition-colors"
                                title="Marquer comme fait">
                                <svg class="w-5 h-5 text-gray-400 hover:text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </button>
                            @else
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            @endif
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-{{ $deadline->getPast() ? 'red' : 'orange' }}-700 font-medium">
                               {{ \Carbon\Carbon::parse($deadline->deadline_date)->format('d/m/Y') }}
                                @if($deadline->deadline_time)
                                    à {{ \Carbon\Carbon::parse($deadline->deadline_time)->format('H:i') }}
                                @endif
                            </span>
                            @if(!$deadline->isPast())
                            <span class="text-gray-600">
                                {{ $deadline->getDaysRemaining() }} jour(s) restant(s)
                            </span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Filters -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-4 border-b border-gray-200">
                    <h3 class="font-semibold text-gray-900">Filtres</h3>
                </div>
                <div class="p-4 space-y-4">
                    <!-- Type Filters -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Types d'événements</label>
                        <div class="space-y-2">
                            @foreach(['evaluation' => '📝', 'course' => '📚', 'meeting' => '👥', 'deadline' => '⏰', 'event' => '🎉', 'personal' => '👤'] as $type => $icon)
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input 
                                    type="checkbox" 
                                    wire:click="toggleTypeFilter('{{ $type }}')"
                                    {{ in_array($type, $filterTypes) ? 'checked' : '' }}
                                    class="rounded text-emerald-600 focus:ring-emerald-500">
                                <span class="text-sm text-gray-700">{{ $icon }} {{ ucfirst($type) }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Options -->
                    <div class="pt-4 border-t border-gray-200">
                        <label class="flex items-center space-x-2 cursor-pointer mb-2">
                            <input 
                                type="checkbox" 
                                wire:model.live="showTimetable"
                                class="rounded text-emerald-600 focus:ring-emerald-500">
                            <span class="text-sm text-gray-700">Afficher l'emploi du temps</span>
                        </label>
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input 
                                type="checkbox" 
                                wire:model.live="showDeadlines"
                                class="rounded text-emerald-600 focus:ring-emerald-500">
                            <span class="text-sm text-gray-700">Afficher les échéances</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create/Edit Event Modal -->
    @if($showEventModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" wire:click="closeEventModal">
        <div class="bg-white rounded-xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto" wire:click.stop>
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-900">
                        {{ $eventId ? 'Modifier l\'événement' : 'Nouvel événement' }}
                    </h3>
                    <button wire:click="closeEventModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <form wire:submit.prevent="saveEvent" class="p-6 space-y-4">
                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Titre *</label>
                    <input 
                        type="text" 
                        wire:model="eventTitle"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500"
                        placeholder="Ex: Réunion d'équipe">
                    @error('eventTitle') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Type and Priority -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Type *</label>
                        <select wire:model="eventType" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                            <option value="evaluation">📝 Évaluation</option>
                            <option value="course">📚 Cours</option>
                            <option value="meeting">👥 Réunion</option>
                            <option value="deadline">⏰ Date limite</option>
                            <option value="holiday">🏖️ Vacances</option>
                            <option value="event">🎉 Événement</option>
                            <option value="personal">👤 Personnel</option>
                            <option value="revision">📖 Révision</option>
                            <option value="trip">🚌 Sortie</option>
                            <option value="ceremony">🎓 Cérémonie</option>
                            <option value="parent_meeting">👨‍👩‍👧 Rencontre parents</option>
                            <option value="pedagogical">🏫 Journée pédagogique</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Priorité</label>
                        <select wire:model="eventPriority" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                            <option value="low">🔵 Basse</option>
                            <option value="medium">🟡 Moyenne</option>
                            <option value="high">🟠 Haute</option>
                            <option value="urgent">🔴 Urgente</option>
                        </select>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea 
                        wire:model="eventDescription"
                        rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500"
                        placeholder="Détails de l'événement..."></textarea>
                </div>

                <!-- All Day Checkbox -->
                <div>
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input 
                            type="checkbox" 
                            wire:model.live="eventAllDay"
                            class="rounded text-emerald-600 focus:ring-emerald-500">
                        <span class="text-sm font-medium text-gray-700">Événement sur toute la journée</span>
                    </label>
                </div>

                <!-- Dates and Times -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date de début *</label>
                        <input 
                            type="date" 
                            wire:model="eventStartDate"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                    </div>
                    @if(!$eventAllDay)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Heure de début</label>
                        <input 
                            type="time" 
                            wire:model="eventStartTime"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                    </div>
                    @endif
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date de fin</label>
                        <input 
                            type="date" 
                            wire:model="eventEndDate"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                    </div>
                    @if(!$eventAllDay)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Heure de fin</label>
                        <input 
                            type="time" 
                            wire:model="eventEndTime"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                    </div>
                    @endif
                </div>

                <!-- Class and Subject -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Classe (optionnel)</label>
                        <select wire:model="eventClassId" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                            <option value="">Aucune classe</option>
                            @foreach($this->classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Matière (optionnel)</label>
                        <select wire:model="eventSubjectId" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                            <option value="">Aucune matière</option>
                            @foreach($this->subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Location -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Lieu</label>
                    <input 
                        type="text" 
                        wire:model="eventLocation"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500"
                        placeholder="Ex: Salle 201, Amphi A">
                </div>

                <!-- Color -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Couleur</label>
                    <div class="flex items-center space-x-2">
                        <input 
                            type="color" 
                            wire:model="eventColor"
                            class="w-12 h-12 border border-gray-300 rounded-lg cursor-pointer">
                        <span class="text-sm text-gray-600">{{ $eventColor }}</span>
                    </div>
                </div>

                <!-- Reminder -->
                <div>
                    <label class="flex items-center space-x-2 cursor-pointer mb-2">
                        <input 
                            type="checkbox" 
                            wire:model.live="eventHasReminder"
                            class="rounded text-emerald-600 focus:ring-emerald-500">
                        <span class="text-sm font-medium text-gray-700">Ajouter un rappel</span>
                    </label>
                    
                    @if($eventHasReminder)
                    <select wire:model="eventReminderMinutes" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                        <option value="5">5 minutes avant</option>
                        <option value="15">15 minutes avant</option>
                        <option value="30">30 minutes avant</option>
                        <option value="60">1 heure avant</option>
                        <option value="120">2 heures avant</option>
                        <option value="1440">1 jour avant</option>
                    </select>
                    @endif
                </div>

                <!-- Notes -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes personnelles</label>
                    <textarea 
                        wire:model="eventNotes"
                        rows="2"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500"
                        placeholder="Notes internes..."></textarea>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                    <button 
                        type="button"
                        wire:click="closeEventModal"
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Annuler
                    </button>
                    <button 
                        type="submit"
                        class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors font-medium">
                        {{ $eventId ? 'Modifier' : 'Créer' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Event Detail Modal -->
    @if($showDetailModal && $selectedEvent)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" wire:click="closeDetailModal">
        <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto" wire:click.stop>
            <!-- Header -->
            <div class="p-6 border-b border-gray-200" style="background: linear-gradient(135deg, {{ $selectedEvent->color }}20, {{ $selectedEvent->color }}40);">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-2">
                            <div class="w-4 h-4 rounded-full" style="background-color: {{ $selectedEvent->color }}"></div>
                            <span class="text-sm font-medium" style="color: {{ $selectedEvent->color }}">
                                {{ $selectedEvent->getTypeLabel() }}
                            </span>
                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-{{ $selectedEvent->getPriorityColor() }}-100 text-{{ $selectedEvent->getPriorityColor() }}-800">
                                {{ ucfirst($selectedEvent->priority) }}
                            </span>
                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-{{ $selectedEvent->getStatusBadgeColor() }}-100 text-{{ $selectedEvent->getStatusBadgeColor() }}-800">
                                {{ ucfirst($selectedEvent->status) }}
                            </span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $selectedEvent->title }}</h3>
                    </div>
                    <button wire:click="closeDetailModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6 space-y-4">
                <!-- Date and Time -->
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <div>
                        <p class="font-medium text-gray-900">
                            {{ $selectedEvent->start_date->format('d/m/Y') }}
                            @if($selectedEvent->start_time)
                                à {{ \Carbon\Carbon::parse($selectedEvent->start_time)->format('H:i') }}
                            @endif
                        </p>
                        @if($selectedEvent->end_date)
                        <p class="text-sm text-gray-600">
                            Jusqu'au {{ $selectedEvent->end_date->format('d/m/Y') }}
                            @if($selectedEvent->end_time)
                                à {{ \Carbon\Carbon::parse($selectedEvent->end_time)->format('H:i') }}
                            @endif
                        </p>
                        @endif
                        @if($selectedEvent->getDuration())
                        <p class="text-sm text-gray-500">Durée : {{ $selectedEvent->getDuration() }}</p>
                        @endif
                    </div>
                </div>

                <!-- Location -->
                @if($selectedEvent->location)
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    </svg>
                    <p class="font-medium text-gray-900">{{ $selectedEvent->location }}</p>
                </div>
                @endif

                <!-- Class and Subject -->
                @if($selectedEvent->classe || $selectedEvent->subject)
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <div>
                        @if($selectedEvent->classe)
                        <p class="font-medium text-gray-900">{{ $selectedEvent->classe->name }}</p>
                        @endif  
                        @if($selectedEvent->subject)
                        <p class="text-sm text-gray-600">{{ $selectedEvent->subject->name }}</p>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Description -->
                @if($selectedEvent->description)
                <div class="pt-4 border-t border-gray-200">
                    <h4 class="font-medium text-gray-900 mb-2">Description</h4>
                    <p class="text-gray-600 whitespace-pre-wrap">{{ $selectedEvent->description }}</p>
                </div>
                @endif

                <!-- Notes -->
                @if($selectedEvent->notes)
                <div class="p-4 bg-blue-50 border-l-4 border-blue-500 rounded">
                    <h4 class="font-medium text-blue-900 mb-1">📝 Notes personnelles</h4>
                    <p class="text-sm text-blue-800">{{ $selectedEvent->notes }}</p>
                </div>
                @endif

                <!-- Reminder -->
                @if($selectedEvent->has_reminder)
                <div class="flex items-center space-x-2 text-sm text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <span>Rappel : {{ $selectedEvent->reminder_minutes }} minutes avant</span>
                </div>
                @endif
            </div>

            <!-- Actions -->
            @if($selectedEvent->created_by === $teacher->user_id)
            <div class="p-6 border-t border-gray-200 flex items-center justify-end space-x-3">
                <button 
                    wire:click="deleteEvent({{ $selectedEvent->id }})"
                    wire:confirm="Êtes-vous sûr de vouloir supprimer cet événement ?"
                    class="px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors font-medium">
                    🗑️ Supprimer
                </button>
                <button 
                    wire:click="editEvent({{ $selectedEvent->id }})"
                    class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors font-medium">
                    ✏️ Modifier
                </button>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>