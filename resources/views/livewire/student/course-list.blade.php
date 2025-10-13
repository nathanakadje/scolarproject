<div>
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Mes Cours</h1>
        <p class="text-gray-600 mt-2">Consultez vos cours, ressources et suivez votre progression</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-sm p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm">Total Cours</p>
                    <p class="text-3xl font-bold mt-2">{{ count($courses) }}</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl shadow-sm p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm">Crédits Totaux</p>
                    <p class="text-3xl font-bold mt-2">{{ collect($courses)->sum('credits') }}</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl shadow-sm p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm">Progression Moy.</p>
                    <p class="text-3xl font-bold mt-2">{{ round(collect($courses)->avg('progress')) }}%</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-orange-500 to-red-600 rounded-xl shadow-sm p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm">Heures/Semaine</p>
                    <p class="text-3xl font-bold mt-2">24h</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Courses Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @foreach($courses as $course)
            <div
                class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                <!-- Course Header -->
                <div class="h-3 bg-gradient-to-r from-{{ $course['color'] }}-400 to-{{ $course['color'] }}-600"></div>

                <div class="p-6">
                    <!-- Course Info -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-2">
                                <span
                                    class="px-3 py-1 bg-{{ $course['color'] }}-100 text-{{ $course['color'] }}-800 text-xs font-semibold rounded-full">
                                    {{ $course['code'] }}
                                </span>
                                <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-medium rounded-full">
                                    {{ $course['credits'] }} crédits
                                </span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $course['name'] }}</h3>
                            <p class="text-sm text-gray-600 mb-2">{{ $course['professor'] }}</p>
                            <p class="text-sm text-gray-500 line-clamp-2">{{ $course['description'] }}</p>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">Progression</span>
                            <span
                                class="text-sm font-bold text-{{ $course['color'] }}-600">{{ $course['progress'] }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-{{ $course['color'] }}-600 h-2 rounded-full transition-all"
                                style="width: {{ $course['progress'] }}%"></div>
                        </div>
                    </div>

                    <!-- Schedule Info -->
                    <div class="flex items-start space-x-2 mb-3 text-sm text-gray-600">
                        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ $course['schedule'] }}</span>
                    </div>

                    <div class="flex items-center space-x-2 mb-4 text-sm text-gray-600">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>{{ $course['room'] }}</span>
                    </div>

                    <!-- Next Class -->
                    <div class="p-3 bg-{{ $course['color'] }}-50 rounded-lg mb-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700">Prochain cours</span>
                            <span class="text-sm font-bold text-{{ $course['color'] }}-600">
                                {{ \Carbon\Carbon::parse($course['next_class'])->format('d/m à H:i') }}
                            </span>
                        </div>
                    </div>

                    <!-- Materials Count -->
                    <div class="flex items-center justify-between mb-4 text-sm">
                        <span class="text-gray-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            {{ count($course['materials']) }} ressources
                        </span>
                    </div>

                    <!-- Actions -->
                    <div class="flex space-x-2">
                        <button wire:click="viewCourse({{ $course['id'] }})"
                            class="flex-1 px-4 py-2 bg-{{ $course['color'] }}-600 text-white rounded-lg hover:bg-{{ $course['color'] }}-700 transition-colors font-medium text-sm">
                            Voir le cours
                        </button>
                        <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Course Details Modal -->
    @if($showCourseModal && $selectedCourse)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
            wire:click="$set('showCourseModal', false)">
            <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto" wire:click.stop>
                <!-- Modal Header -->
                <div
                    class="sticky top-0 bg-gradient-to-r from-{{ $selectedCourse['color'] }}-500 to-{{ $selectedCourse['color'] }}-600 p-6 text-white">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <span
                                class="inline-block px-3 py-1 bg-white bg-opacity-20 text-white text-xs font-semibold rounded-full mb-2">
                                {{ $selectedCourse['code'] }}
                            </span>
                            <h2 class="text-2xl font-bold mb-2">{{ $selectedCourse['name'] }}</h2>
                            <p class="text-{{ $selectedCourse['color'] }}-100">{{ $selectedCourse['professor'] }}</p>
                        </div>
                        <button wire:click="$set('showCourseModal', false)"
                            class="text-white hover:bg-white hover:bg-opacity-20 rounded-lg p-2 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Content -->
                <div class="p-6">
                    <!-- Course Description -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Description</h3>
                        <p class="text-gray-600">{{ $selectedCourse['description'] }}</p>
                    </div>

                    <!-- Course Details -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600 mb-1">Horaire</p>
                            <p class="font-semibold text-gray-900">{{ $selectedCourse['schedule'] }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600 mb-1">Salle</p>
                            <p class="font-semibold text-gray-900">{{ $selectedCourse['room'] }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600 mb-1">Crédits</p>
                            <p class="font-semibold text-gray-900">{{ $selectedCourse['credits'] }} ECTS</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600 mb-1">Progression</p>
                            <p class="font-semibold text-gray-900">{{ $selectedCourse['progress'] }}%</p>
                        </div>
                    </div>

                    <!-- Course Materials -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Ressources disponibles</h3>
                        <div class="space-y-3">
                            @foreach($selectedCourse['materials'] as $material)
                                <div
                                    class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center space-x-3">
                                        @if($material['type'] === 'pdf')
                                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                        @elseif($material['type'] === 'video')
                                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                                    </path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $material['name'] }}</p>
                                            <p class="text-sm text-gray-500">
                                                @if(isset($material['size']))
                                                    {{ $material['size'] }}
                                                @else
                                                    {{ $material['duration'] }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <button
                                        class="px-4 py-2 bg-{{ $selectedCourse['color'] }}-600 text-white rounded-lg hover:bg-{{ $selectedCourse['color'] }}-700 transition-colors text-sm font-medium">
                                        Télécharger
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex space-x-3">
                        <button
                            class="flex-1 px-6 py-3 bg-{{ $selectedCourse['color'] }}-600 text-white rounded-lg hover:bg-{{ $selectedCourse['color'] }}-700 transition-colors font-medium">
                            Contacter le professeur
                        </button>
                        <button
                            class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                            Ajouter aux favoris
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>