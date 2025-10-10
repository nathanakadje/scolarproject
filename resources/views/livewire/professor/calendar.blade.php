<div>
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Calendrier Scolaire</h1>
        <p class="text-gray-600 mt-2">Consultez tous les événements, examens et dates importantes</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Calendar -->
        <div class="lg:col-span-3">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <!-- Calendar Header -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-bold text-gray-900">
                            {{ \Carbon\Carbon::createFromDate($currentYear, $currentMonth, 1)->format('F Y') }}
                        </h2>
                        <div class="flex space-x-2">
                            <button wire:click="previousMonth"
                                class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                            <button wire:click="nextMonth" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Calendar Grid -->
                <div class="p-6">
                    <!-- Day Headers -->
                    <div class="grid grid-cols-7 gap-2 mb-2">
                        @foreach(['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'] as $day)
                        <div class="text-center text-sm font-semibold text-gray-600 py-2">
                            {{ $day }}
                        </div>
                        @endforeach
                    </div>

                    <!-- Calendar Days -->
                    <div class="grid grid-cols-7 gap-2">
                        <!-- Empty cells before first day -->
                        @for($i = 0; $i < $startDay; $i++) <div class="aspect-square p-2 bg-gray-50 rounded-lg">
                    </div>
                    @endfor

                    <!-- Days of month -->
                    @for($day = 1; $day <= $daysInMonth; $day++) @php $date=sprintf('%04d-%02d-%02d', $currentYear,
                        $currentMonth, $day); $dayEvents=$this->getEventsForDate($date);
                        $isToday = $date === now()->format('Y-m-d');
                        @endphp
                        <div wire:click="selectDate('{{ $date }}')"
                            class="aspect-square p-2 border rounded-lg cursor-pointer transition-all hover:shadow-md
                             {{ $isToday ? 'border-indigo-600 bg-indigo-50' : 'border-gray-200 hover:border-indigo-300' }}">
                            <div class="flex flex-col h-full">
                                <span
                                    class="text-sm font-semibold {{ $isToday ? 'text-indigo-600' : 'text-gray-900' }}">
                                    {{ $day }}
                                </span>
                                <div class="flex-1 mt-1 space-y-1 overflow-hidden">
                                    @foreach($dayEvents as $event)
                                    <div class="w-full h-1.5 rounded-full bg-{{ $event['color'] }}-500"></div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endfor
                </div>
            </div>
        </div>
    </div>

    <!-- Events Sidebar -->
    <div class="space-y-6">
        <!-- Legend -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Légende</h3>
            <div class="space-y-3">
                <div class="flex items-center space-x-3">
                    <div class="w-4 h-4 rounded-full bg-red-500"></div>
                    <span class="text-sm text-gray-600">Examens</span>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-4 h-4 rounded-full bg-blue-500"></div>
                    <span class="text-sm text-gray-600">Devoirs</span>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-4 h-4 rounded-full bg-green-500"></div>
                    <span class="text-sm text-gray-600">Vacances</span>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-4 h-4 rounded-full bg-purple-500"></div>
                    <span class="text-sm text-gray-600">Événements</span>
                </div>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Événements à venir</h3>
            <div class="space-y-4">
                @foreach($events as $event)
                <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="flex-shrink-0 w-2 h-2 rounded-full bg-{{ $event['color'] }}-500 mt-2"></div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-semibold text-gray-900">{{ $event['title'] }}</h4>
                        <p class="text-xs text-gray-600 mt-1">{{ \Carbon\Carbon::parse($event['date'])->format('d M Y')
                            }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Event Modal -->
@if($showEventModal)
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    wire:click="$set('showEventModal', false)">
    <div class="bg-white rounded-xl shadow-2xl p-6 max-w-md w-full mx-4" wire:click.stop>
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900">{{ \Carbon\Carbon::parse($selectedDate)->format('d F Y') }}</h3>
            <button wire:click="$set('showEventModal', false)" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        @php
        $selectedEvents = $this->getEventsForDate($selectedDate);
        @endphp

        @if($selectedEvents->count() > 0)
        <div class="space-y-3">
            @foreach($selectedEvents as $event)
            <div class="p-4 border-l-4 border-{{ $event['color'] }}-500 bg-{{ $event['color'] }}-50 rounded">
                <h4 class="font-semibold text-gray-900">{{ $event['title'] }}</h4>
                <p class="text-sm text-gray-600 mt-2">{{ $event['description'] }}</p>
                <span
                    class="inline-block mt-2 text-xs px-2 py-1 rounded bg-{{ $event['color'] }}-100 text-{{ $event['color'] }}-800">
                    {{ ucfirst($event['type']) }}
                </span>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-500 text-center py-8">Aucun événement ce jour</p>
        @endif
    </div>
</div>
@endif
</div>