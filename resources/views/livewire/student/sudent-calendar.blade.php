<div>
    <!-- Header -->
    <!-- <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">📅 Mon Calendrier</h1>
        <p class="text-gray-600">Consultez tous vos événements, cours et devoirs à venir</p>
    </div> -->

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Calendar Main -->
        <div class="lg:col-span-3 space-y-6">
            <!-- Controls -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <!-- Navigation -->
                    <div class="flex items-center space-x-2">
                        <button wire:click="previousPeriod" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>

                        <button wire:click="today"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-emerald-100 hover:bg-gray-100 rounded-lg transition-colors">
                            Aujourd'hui
                        </button>

                        <button wire:click="nextPeriod" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </button>
                    </div>

                    <!-- Current Period -->
                    <h2 class="text-xl font-bold text-gray-900">
                        {{ \Carbon\Carbon::parse($currentDate)->locale('fr')->isoFormat('MMMM YYYY') }}
                    </h2>

                    <!-- View Mode -->
                    <div class="flex items-center space-x-2 bg-gray-100 rounded-lg p-1">
                        <button wire:click="changeViewMode('month')"
                            class="px-3 py-1.5 text-sm rounded-md transition-colors {{ $viewMode === 'month' ? 'bg-white text-emerald-600  font-semibold shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                            Mois
                        </button>
                        <!-- <button wire:click="changeViewMode('week')"
                            class="px-3 py-1.5 text-sm rounded-md transition-colors {{ $viewMode === 'week' ? 'bg-white text-emerald-600 font-semibold shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                            Semaine
                        </button> -->
                        <button wire:click="changeViewMode('agenda')"
                            class="px-3 py-1.5 text-sm rounded-md transition-colors {{ $viewMode === 'agenda' ? 'bg-white text-emerald-600 font-semibold shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                            Agenda
                        </button>
                    </div>
                </div>
            </div>

            <!-- Calendar Grid (Month View) -->
            @if($viewMode === 'month' && $calendarData)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <!-- Days Header -->
                    <div class="grid grid-cols-7 bg-gray-50 border-b border-gray-200">
                        @foreach(['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'] as $day)
                            <div class="p-3 text-center text-sm font-semibold text-gray-700">{{ $day }}</div>
                        @endforeach
                    </div>

                    <!-- Calendar Grid -->
                    <div class="divide-y divide-gray-200">
                        @foreach($calendarData as $week)
                            <div class="grid grid-cols-7 divide-x divide-gray-200">
                                @foreach($week as $day)
                                    <div
                                        class="min-h-[120px] p-2 {{ !$day['isCurrentMonth'] ? 'bg-gray-50' : 'bg-white' }} {{ $day['isToday'] ? 'bg-emerald-50' : '' }}">
                                        <div class="flex items-center justify-between mb-1">
                                            <span
                                                class="text-sm font-semibold {{ $day['isToday'] ? 'bg-emerald-600 text-white w-7 h-7 rounded-full flex items-center justify-center' : ($day['isCurrentMonth'] ? 'text-gray-900' : 'text-gray-400') }}">
                                                {{ $day['day'] }}
                                            </span>
                                        </div>

                                        <!-- Events for this day -->
                                        <div class="space-y-1">
                                            @foreach($day['events']->take(3) as $event)
                                                <button wire:click="viewEventDetails({{ $event->id }})"
                                                    class="w-full text-left text-xs px-2 py-1 rounded truncate hover:shadow-md transition-shadow"
                                                    style="background-color: {{ $event->color ?? '#10B981' }}20; color: {{ $event->color ?? '#10B981' }}">
                                                    <span class="font-medium">
                                                        @if(isset($event->type))
                                                            {{ $event->start_time ? substr($event->start_time, 0, 5) : '' }}
                                                        @else
                                                            {{ \Carbon\Carbon::parse($event->due_date)->format('H:i') }}
                                                        @endif
                                                    </span>
                                                    {{ $event->title }}
                                                </button>
                                            @endforeach

                                            @if($day['events']->count() > 3)
                                                <div class="text-xs text-gray-500 pl-2">
                                                    +{{ $day['events']->count() - 3 }} autres
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Agenda View -->
            @if($viewMode === 'agenda')
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="p-6">
                        <div class="space-y-4">
                            @forelse($upcomingEvents as $event)
                                <div class="flex items-start space-x-4 p-4 border-l-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors"
                                    style="border-color: {{ $event->color ?? '#10B981' }}">
                                    <div class="flex-shrink-0 w-16 text-center">
                                        <div class="text-2xl font-bold text-gray-900">
                                            {{ \Carbon\Carbon::parse($event->start_date ?? $event->due_date)->format('d') }}
                                        </div>
                                        <div class="text-xs text-gray-600">
                                            {{ \Carbon\Carbon::parse($event->start_date ?? $event->due_date)->format('M') }}
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900">{{ $event->title }}</h3>
                                        <p class="text-sm text-gray-600 mt-1">{{ $event->description ?? 'Devoir à rendre' }}</p>
                                        <div class="flex items-center space-x-4 mt-2 text-xs text-gray-500">
                                            @if(isset($event->type))
                                                <span>📅 {{ $event->start_time ?? 'Toute la journée' }}</span>
                                                @if($event->location)
                                                    <span>📍 {{ $event->location }}</span>
                                                @endif
                                            @else
                                                <span>📝 Devoir -
                                                    {{ \Carbon\Carbon::parse($event->due_date)->format('H:i') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <button wire:click="viewEventDetails({{ $event->id }})"
                                        class="px-4 py-2 text-sm text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors">
                                        Détails →
                                    </button>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <p class="text-gray-500">Aucun événement à venir</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Upcoming Events -->
            <div class="bg-gradient-to-br from-blue-900 to-indigo-600 rounded-xl shadow-sm p-6 text-white">
                <h3 class="text-lg font-semibold mb-4">À venir</h3>
                <div class="space-y-3">
                    @foreach($upcomingEvents->take(5) as $event)
                        <div class="bg-white bg-opacity-20 rounded-lg p-3 hover:bg-opacity-30 transition-colors cursor-pointer"
                            wire:click="viewEventDetails({{ $event->id }})">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <p class="font-medium text-sm">{{ $event->title }}</p>
                                    <p class="text-xs mt-1 opacity-90">
                                        {{ \Carbon\Carbon::parse($event->start_date ?? $event->due_date)->format('d/m à H:i') }}
                                    </p>
                                </div>
                                <span class="text-xl">
                                    @if(isset($event->type))
                                        {{ ['evaluation' => '📝', 'course' => '📚', 'meeting' => '👥', 'event' => '🎉'][$event->type] ?? '📅' }}
                                    @else
                                        📝
                                    @endif
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Filtres</h3>
                <div class="space-y-2">
                    @foreach([
                            'evaluation' => ['label' => 'Évaluations', 'icon' => '📝'],
                            'course' => ['label' => 'Cours', 'icon' => '📚'],
                            'meeting' => ['label' => 'Réunions', 'icon' => '👥'],
                            'holiday' => ['label' => 'Vacances', 'icon' => '🏖️'],
                            'event' => ['label' => 'Événements', 'icon' => '🎉'],
                        ] as $type => $info)
                        <label class="flex items-center space-x-2 cursor-pointer p-2 hover:bg-gray-50 rounded-lg">
                            <input type="checkbox" 
                                   wire:click="toggleTypeFilter('{{ $type }}')"
                                   {{ in_array($type, $filterTypes) ? 'checked' : '' }}
                                   class="rounded text-blue-600">
                            <span class="text-xl">{{ $info['icon'] }}</span>
                            <span class="text-sm text-gray-700">{{ $info['label'] }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Legend -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Légende</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex items-center space-x-2">
                        <div class="w-4 h-4 bg-emerald-100 border-2 border-emerald-600 rounded"></div>
                        <span class="text-gray-700">Aujourd'hui</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-4 h-4 bg-red-200 rounded"></div>
                        <span class="text-gray-700">Devoirs</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-4 h-4 bg-blue-200 rounded"></div>
                        <span class="text-gray-700">Cours</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-4 h-4 bg-purple-200 rounded"></div>
                        <span class="text-gray-700">Événements</span>
                    </div>
                </div>
            </div>

               </div>
    </div>

   <!-- Event Detail Modal -->
    @if($showDetailModal && $selectedEvent)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" wire:click="closeDetailModal">
            <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full" wire:click.stop>
                <!-- Header avec couleur -->
                <div class="p-6 border-b border-gray-200 rounded-t-xl" 
                     style="background: linear-gradient(135deg, {{ $selectedEvent->color ?? '#10B981' }}20, {{ $selectedEvent->color ?? '#10B981' }}10);">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-2">
                                <span class="text-3xl">
                                    {{ ['evaluation' => '📝', 'course' => '📚', 'meeting' => '👥', 'event' => '🎉'][$selectedEvent->type] ?? '📅' }}
                                </span>
                                <h3 class="text-2xl font-bold text-gray-900">{{ $selectedEvent->title }}</h3>
                            </div>
                            @if($selectedEvent->description)

                                   <p class="text-gray-600">{{ $selectedEvent->description }}</p>
                            @endif
                        </div>
                        <button wire:click="closeDetailModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Details -->
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">📅 Date</p>
                            <p class="text-gray-900 font-medium">
                                {{ \Carbon\Carbon::parse($selectedEvent->start_date)->format('d/m/Y') }}
                            </p>
                        </div>
                    @if($selectedEvent->start_time)
                        <div>
                            <p class="text-sm text-gray-500 mb-1">⏰ Heure</p>
                            <p class="text-gray-900 font-medium">
                                {{ substr($selectedEvent->start_time, 0, 5) }}
                                @if($selectedEvent->end_time)
                                    - {{ substr($selectedEvent->end_time, 0, 5) }}
                                @endif
                            </p>
                        </div>
                    @endif
                    </div>

                    @if($selectedEvent->location)
                        <div>
                            <p class="text-sm text-gray-500 mb-1">📍 Lieu</p>
                            <p class="text-gray-900 font-medium">{{ $selectedEvent->location }}</p>
                        </div>
                    @endif

                    @if($selectedEvent->subject)
                        <div>
                            <p class="text-sm text-gray-500 mb-1">📚 Matière</p>
                            <p class="text-gray-900 font-medium">{{ $selectedEvent->subject->name }}</p>
                        </div>
                    @endif

                    @if($selectedEvent->classe)
                        <div>
                            <p class="text-sm text-gray-500 mb-1">🎓 Classe</p>
                            <p class="text-gray-900 font-medium">{{ $selectedEvent->classe->name }}</p>
                        </div>
                    @endif
                </div>

                <!-- Footer -->
                <div class="p-6 border-t border-gray-200 bg-gray-50 rounded-b-xl">
                    <button wire:click="closeDetailModal" 
                            class="w-full px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors font-medium">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>