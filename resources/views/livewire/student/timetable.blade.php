<div>
    <!-- Current & Next Session Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Current Session -->
        @if($currentSession)
            <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <p class="text-emerald-100 text-sm font-medium mb-1">🔴 EN COURS</p>
                        <h3 class="text-2xl font-bold">{{ $currentSession->subject->name ?? 'Matière inconnue' }}</h3>
                    </div>
                    <div
                        class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center animate-pulse">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ substr($currentSession->start_time, 0, 5) }} - {{ substr($currentSession->end_time, 0, 5) }}
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ $currentSession->room ?? 'Salle non définie' }}
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ $currentSession->teacher->first_name ?? '' }}
                        {{ $currentSession->teacher->last_name ?? 'Professeur inconnu' }}
                    </div>
                </div>
            </div>
        @else
            <div class="bg-gray-100 rounded-xl shadow-sm p-6">
                <div class="text-center py-6">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-gray-600 font-medium">Aucun cours en ce moment</p>
                    <p class="text-gray-500 text-sm mt-1">Profitez de votre pause ! ☕</p>
                </div>
            </div>
        @endif

        <!-- Next Session -->
        @if($nextSession)
            <div class="bg-white rounded-xl shadow-sm border-2 border-blue-200 p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <p class="text-blue-600 text-sm font-medium mb-1">⏭️ PROCHAIN COURS</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $nextSession->subject->name ?? 'Matière inconnue' }}
                        </h3>
                    </div>
                    <div class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">
                        {{ \Carbon\Carbon::parse($nextSession->start_time)->diffForHumans() }}
                    </div>
                </div>
                <div class="space-y-2 text-sm text-gray-600">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ substr($nextSession->start_time, 0, 5) }} - {{ substr($nextSession->end_time, 0, 5) }}
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ $nextSession->room ?? 'Salle non définie' }}
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ $nextSession->teacher->first_name ?? '' }}
                        {{ $nextSession->teacher->last_name ?? 'Professeur inconnu' }}
                    </div>
                </div>
            </div>
        @else
            <div class="bg-gray-100 rounded-xl shadow-sm p-6">
                <div class="text-center py-6">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-gray-600 font-medium">Fin des cours pour aujourd'hui</p>
                    <p class="text-gray-500 text-sm mt-1">À demain ! 🎉</p>
                </div>
            </div>
        @endif
    </div>

    <!-- Controls -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <!-- Navigation -->
            <div class="flex items-center space-x-2">
                <button wire:click="previousWeek" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                </button>

                <button wire:click="goToToday"
                    class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                    Cette semaine
                </button>

                <button wire:click="nextWeek" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>

            <!-- Week Info -->
            <h2 class="text-lg font-bold text-gray-900">
                Semaine du {{ \Carbon\Carbon::parse($currentWeek)->format('d/m/Y') }}
            </h2>

            <!-- Stats Badge -->
            <div class="flex items-center space-x-4 text-sm">
                <div class="px-3 py-1.5 bg-emerald-100 text-emerald-700 rounded-lg font-medium">
                    📚 {{ $weekStats['totalCourses'] }} cours
                </div>
                <div class="px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg font-medium">
                    ⏱️ {{ $weekStats['totalHours'] }}h
                </div>
            </div>
        </div>
    </div>

    <!-- Timetable Grid -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Days Header -->
        <div class="grid grid-cols-8 border-b border-gray-200 bg-gray-50">
            <div class="p-4 text-center text-sm font-semibold text-gray-700">Horaire</div>
            @foreach($weekDays as $day)
                <div class="p-4 text-center border-l border-gray-200 {{ $day['isToday'] ? 'bg-emerald-100' : '' }}">
                    <div class="text-xs text-gray-600 mb-1">{{ $day['dayShort'] }}</div>
                    <div class="text-lg font-bold {{ $day['isToday'] ? 'text-emerald-600' : 'text-gray-900' }}">
                        {{ $day['dayNumber'] }}
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Timetable Body -->
        <div class="divide-y divide-gray-200">
            @php
                $timeSlots = [
                    '08:00',
                    '09:00',
                    '10:00',
                    '11:00',
                    '12:00',
                    '13:00',
                    '14:00',
                    '15:00',
                    '16:00',
                    '17:00'
                ];
            @endphp

            @foreach($timeSlots as $time)
                <div class="grid grid-cols-8 min-h-[80px]">
                    <!-- Time Column -->
                    <div class="p-4 text-center text-sm font-medium text-gray-600 border-r border-gray-200 bg-gray-50">
                        {{ $time }}
                    </div>

                    <!-- Days Columns -->
                    @foreach($weekDays as $day)
                        <div class="p-2 border-l border-gray-200 {{ $day['isToday'] ? 'bg-emerald-50' : '' }}">
                            @php
                                $sessions = $this->getSessionsForDay($day['dayOfWeek'])
                                    ->filter(function ($session) use ($time) {
                                        $sessionStart = substr($session->start_time, 0, 5);
                                        $sessionEnd = substr($session->end_time, 0, 5);
                                        $nextHour = date('H:i', strtotime($time . ' +1 hour'));

                                        // Afficher le cours s'il commence pendant cette heure
                                        // ou s'il chevauche cette plage horaire
                                        return ($sessionStart >= $time && $sessionStart < $nextHour) ||
                                            ($sessionStart <= $time && $sessionEnd > $time);
                                    });
                            @endphp

                            @foreach($sessions as $session)
                                <div class="rounded-lg p-2 mb-2 text-xs shadow-sm hover:shadow-md transition-shadow cursor-pointer"
                                    style="background-color: {{ $session->subject->color ?? '#3b82f6' }}20; border-left: 3px solid {{ $session->subject->color ?? '#3b82f6' }}">
                                    <div class="font-semibold text-gray-900 mb-1">
                                        {{ $session->subject->name ?? 'Matière inconnue' }}</div>
                                    <div class="text-gray-600 space-y-0.5">
                                        <div class="flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3"></path>
                                            </svg>
                                            {{ substr($session->start_time, 0, 5) }}-{{ substr($session->end_time, 0, 5) }}
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                </path>
                                            </svg>
                                            {{ $session->room ?? 'N/A' }}
                                        </div>
                                        <div class="flex items-center truncate">
                                            <svg class="w-3 h-3 mr-1 flex-shrink-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            {{ $session->teacher->first_name ?? '' }}
                                            {{ $session->teacher->last_name ? substr($session->teacher->last_name, 0, 1) . '.' : '' }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    <!-- Weekly Summary -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <!-- Today's Schedule -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">📅 Programme d'aujourd'hui</h3>
            <div class="space-y-3">
                @forelse($todaySessions as $session)
                    <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex-shrink-0 w-16 text-center">
                            <div class="text-sm font-bold text-gray-900">{{ substr($session->start_time, 0, 5) }}</div>
                            <div class="text-xs text-gray-500">{{ substr($session->end_time, 0, 5) }}</div>
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900">{{ $session->subject->name ?? 'Matière inconnue' }}
                            </div>
                            <div class="text-sm text-gray-600">{{ $session->room ?? 'Salle N/A' }}</div>
                            <div class="text-xs text-gray-500 mt-1">
                                {{ $session->teacher->first_name ?? '' }} {{ $session->teacher->last_name ?? '' }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p>Pas de cours aujourd'hui</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Subjects Distribution -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">📊 Répartition par matière</h3>
            <div class="space-y-3">
                @forelse($weekStats['subjects'] as $subject => $hours)
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700">{{ $subject }}</span>
                            <span class="text-sm font-bold text-gray-900">{{ $hours }}h</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
    <div class="bg-emerald-600 h-2 rounded-full transition-all"
         style="width: {{ min(100, ($hours / max($weekStats['totalHours'], 1)) * 100) }}%">
    </div>
</div>

                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">Aucune donnée disponible</p>
                @endforelse
            </div>
        </div>
    </div>
</div>