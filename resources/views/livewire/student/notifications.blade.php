<div>
    <!-- Header -->
    <!-- <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">🔔 Mes Notifications</h1>
        <p class="text-gray-600">Restez informé de toutes vos activités scolaires</p>
    </div> -->

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Non lues</p>
                    <p class="text-3xl font-bold text-orange-600 mt-1">{{ $stats['unread'] }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Aujourd'hui</p>
                    <p class="text-3xl font-bold text-emerald-600 mt-1">{{ $stats['today'] }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <!-- Filters -->
            <div class="flex flex-wrap items-center gap-2">
                <button wire:click="$set('filterType', 'all')"
                    class="px-4 py-2 text-sm rounded-lg transition-colors {{ $filterType === 'all' ? 'bg-emerald-100 text-emerald-700 font-semibold' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Toutes
                </button>
                <button wire:click="$set('filterType', 'unread')"
                    class="px-4 py-2 text-sm rounded-lg transition-colors {{ $filterType === 'unread' ? 'bg-emerald-100 text-emerald-700 font-semibold' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Non lues ({{ $stats['unread'] }})
                </button>
                <button wire:click="$set('filterType', 'read')"
                    class="px-4 py-2 text-sm rounded-lg transition-colors {{ $filterType === 'read' ? 'bg-emerald-100 text-emerald-700 font-semibold' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Lues
                </button>

                <div class="w-px h-6 bg-gray-300 mx-2"></div>

                <button wire:click="$set('filterCategory', 'all')"
                    class="px-4 py-2 text-sm rounded-lg transition-colors {{ $filterCategory === 'all' ? 'bg-blue-100 text-blue-700 font-semibold' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    📋 Tout
                </button>
                <button wire:click="$set('filterCategory', 'calendar_event')"
                    class="px-4 py-2 text-sm rounded-lg transition-colors {{ $filterCategory === 'calendar_event' ? 'bg-blue-100 text-blue-700 font-semibold' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    📅 Calendrier
                </button>
                <button wire:click="$set('filterCategory', 'assignment')"
                    class="px-4 py-2 text-sm rounded-lg transition-colors {{ $filterCategory === 'assignment' ? 'bg-blue-100 text-blue-700 font-semibold' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    📝 Devoirs
                </button>
                <button wire:click="$set('filterCategory', 'grade')"
                    class="px-4 py-2 text-sm rounded-lg transition-colors {{ $filterCategory === 'grade' ? 'bg-blue-100 text-blue-700 font-semibold' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    🎯 Notes
                </button>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-2">
                @if($stats['unread'] > 0)
                    <button wire:click="markAllAsRead"
                        class="px-4 py-2 text-sm text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors font-medium">
                        Tout marquer comme lu
                    </button>
                @endif
                <button wire:click="deleteAllRead" wire:confirm="Supprimer toutes les notifications lues ?"
                    class="px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors font-medium">
                    Supprimer les lues
                </button>
            </div>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="space-y-4">
        @forelse($notifications as $notification)
            <div
                class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow {{ $notification->is_read ? '' : 'border-l-4 border-l-emerald-500' }}">
                <div class="flex items-start space-x-4">
                    <!-- Icon -->
                    <div class="flex-shrink-0 w-12 h-12 rounded-full flex items-center justify-center text-2xl"
                        style="background-color: {{ $notification->color }}20;">
                        {{ $notification->icon }}
                    </div>

                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between mb-2">
                            <div class="flex-1">
                                <h3
                                    class="text-lg font-semibold text-gray-900 {{ !$notification->is_read ? 'font-bold' : '' }}">
                                    {{ $notification->title }}
                                    @if(!$notification->is_read)
                                        <span
                                            class="ml-2 px-2 py-0.5 text-xs bg-emerald-100 text-emerald-700 rounded-full">Nouveau</span>
                                    @endif
                                </h3>
                                <p class="text-gray-600 mt-1">{{ $notification->message }}</p>
                            </div>
                        </div>

                        <!-- Meta Info -->
                        <div class="flex items-center space-x-4 text-sm text-gray-500 mt-3">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $notification->time_ago }}
                            </span>

                            @if($notification->priority === 'urgent')
                                <span class="flex items-center text-red-600 font-semibold">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    URGENT
                                </span>
                            @endif
                        </div>

                        <!-- Additional Data -->
                        @if($notification->data && !empty($notification->data))
                            <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                                <div class="grid grid-cols-2 gap-2 text-sm">
                                    @if(isset($notification->data['start_date']))
                                        <div>
                                            <span class="text-gray-600">📅 Date :</span>
                                            <span class="font-medium text-gray-900 ml-1">
                                                {{ \Carbon\Carbon::parse($notification->data['start_date'])->format('d/m/Y') }}
                                            </span>
                                        </div>
                                    @endif
                                    @if(isset($notification->data['start_time']))
                                        <div>
                                            <span class="text-gray-600">⏰ Heure :</span>
                                            <span
                                                class="font-medium text-gray-900 ml-1">{{ $notification->data['start_time'] }}</span>
                                        </div>
                                    @endif
                                    @if(isset($notification->data['location']))
                                        <div>
                                            <span class="text-gray-600">📍 Lieu :</span>
                                            <span
                                                class="font-medium text-gray-900 ml-1">{{ $notification->data['location'] }}</span>
                                        </div>
                                    @endif
                                    @if(isset($notification->data['subject_name']))
                                        <div>
                                            <span class="text-gray-600">📚 Matière :</span>
                                            <span
                                                class="font-medium text-gray-900 ml-1">{{ $notification->data['subject_name'] }}</span>
                                        </div>
                                    @endif
                                    @if(isset($notification->data['due_date']))
                                        <div class="col-span-2">
                                            <span class="text-gray-600">⏳ À rendre le :</span>
                                            <span class="font-medium text-orange-600 ml-1">
                                                {{ \Carbon\Carbon::parse($notification->data['due_date'])->format('d/m/Y à H:i') }}
                                            </span>
                                        </div>
                                    @endif
                                    @if(isset($notification->data['score']))
                                        <div class="col-span-2">
                                            <span class="text-gray-600">🎯 Note :</span>
                                            <span
                                                class="font-bold text-lg ml-1 {{ $notification->data['score'] >= $notification->data['max_score'] * 0.5 ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $notification->data['score'] }}/{{ $notification->data['max_score'] }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col space-y-2">
                        @if(!$notification->is_read)
                            <button wire:click="markAsRead({{ $notification->id }})"
                                class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors"
                                title="Marquer comme lu">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        @endif
                        <button wire:click="deleteNotification({{ $notification->id }})"
                            wire:confirm="Supprimer cette notification ?"
                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Supprimer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <svg class="w-20 h-20 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                    </path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucune notification</h3>
                <p class="text-gray-600">Vous êtes à jour ! 🎉</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $notifications->links() }}
    </div>
</div>