<div>
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Mes Étudiants</h1>
                <!-- <p class="text-gray-600 mt-2">Vue d'ensemble de tous vos étudiants avec statistiques détaillées</p> -->
            </div>
            <div class="flex space-x-3">
                <button wire:click="toggleViewMode"
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-gray-200 transition-colors flex items-center space-x-2">
                    @if($viewMode === 'grid')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                        <span>Vue Tableau</span>
                    @else
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                        <span>Vue Grille</span>
                    @endif
                </button>
                <button wire:click="exportStudents"
                    class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <span>Exporter</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Global Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-6 mb-8">
        <!-- Total Students -->
        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-sm p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-medium opacity-90">Total Étudiants</h3>
                <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
            </div>
            <p class="text-4xl font-bold">{{ $globalStats['total'] }}</p>
            <p class="text-sm opacity-80 mt-2">Élèves actifs</p>
        </div>

        <!-- Boys -->
        <div class="bg-gradient-to-br from-cyan-500 to-blue-600 rounded-xl shadow-sm p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-medium opacity-90">Garçons</h3>
                <span class="text-2xl">👦</span>
            </div>
            <p class="text-4xl font-bold">{{ $globalStats['boys'] }}</p>
            <p class="text-sm opacity-80 mt-2">
                {{ $globalStats['total'] > 0 ? round(($globalStats['boys'] / $globalStats['total']) * 100, 1) : 0 }}% du
                total
            </p>
        </div>

        <!-- Girls -->
        <div class="bg-gradient-to-br from-pink-500 to-rose-600 rounded-xl shadow-sm p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-medium opacity-90">Filles</h3>
                <span class="text-2xl">👧</span>
            </div>
            <p class="text-4xl font-bold">{{ $globalStats['girls'] }}</p>
            <p class="text-sm opacity-80 mt-2">
                {{ $globalStats['total'] > 0 ? round(($globalStats['girls'] / $globalStats['total']) * 100, 1) : 0 }}%
                du total
            </p>
        </div>

        <!-- Average Age -->
        <div class="bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl shadow-sm p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-medium opacity-90">Âge Moyen</h3>
                <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
            </div>
            <p class="text-4xl font-bold">{{ $globalStats['average_age'] }}</p>
            <p class="text-sm opacity-80 mt-2">ans</p>
        </div>

        <!-- Attendance Rate -->
        <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl shadow-sm p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-medium opacity-90">Taux Présence</h3>
                <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-4xl font-bold">{{ $globalStats['attendance_rate'] }}%</p>
            <p class="text-sm opacity-80 mt-2">Moyen global</p>
        </div>

        <!-- Average Grade -->
        <div class="bg-gradient-to-br from-orange-500 to-red-600 rounded-xl shadow-sm p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-medium opacity-90">Moyenne</h3>
                <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                    </path>
                </svg>
            </div>
            <p class="text-4xl font-bold">{{ $globalStats['average_grade'] }}</p>
            <p class="text-sm opacity-80 mt-2">/20</p>
        </div>
    </div>

    <!-- Class Breakdown -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Répartition par Classe</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($classBreakdown as $breakdown)
                <div class="p-4 border border-gray-200 rounded-lg hover:border-emerald-500 transition-all cursor-pointer"
                    wire:click="selectClass({{ $this->classes->where('name', $breakdown['class'])->first()->id ?? '' }})">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-semibold text-gray-900">{{ $breakdown['class'] }}</h3>
                        <span class="px-2 py-1 bg-emerald-100 text-emerald-800 text-xs font-medium rounded">
                            {{ $breakdown['count'] }}/{{ $breakdown['capacity'] }}
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-emerald-600 h-2 rounded-full transition-all"
                            style="width: {{ $breakdown['percentage'] }}%"></div>
                    </div>
                    <p class="text-xs text-gray-600 mt-2">{{ $breakdown['percentage'] }}% de capacité</p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
            <!-- Search -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Rechercher</label>
                <input type="text" wire:model.live.debounce.300ms="searchTerm" placeholder="Nom, prénom, numéro..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
            </div>

            <!-- Class Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Classe</label>
                <select wire:model.live="selectedClassId"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                    <option value="">Toutes les classes</option>
                    @foreach($this->classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                <select wire:model.live="statusFilter"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                    <option value="all">Tous</option>
                    <option value="active">Actifs</option>
                    <option value="suspended">Suspendus</option>
                    <option value="graduated">Diplômés</option>
                    <option value="dropped">Abandons</option>
                </select>
            </div>

            <!-- Gender Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Genre</label>
                <select wire:model.live="genderFilter"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                    <option value="all">Tous</option>
                    <option value="M">Garçons</option>
                    <option value="F">Filles</option>
                </select>
            </div>

            <!-- Clear Filters -->
            <div class="flex items-end">
                <button wire:click="clearFilters"
                    class="w-full px-4 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-300 transition-colors">
                    Réinitialiser
                </button>
            </div>
        </div>
    </div>

    <!-- Students List -->
    @if($viewMode === 'grid')
        <!-- Grid View -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-6">
            @forelse($this->students as $student)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-all cursor-pointer"
                    wire:click="viewStudent({{ $student->id }})">
                    <!-- Header with photo -->
                    <div class="h-32 bg-gradient-to-br from-emerald-400 to-teal-500 relative">
                        <div class="absolute -bottom-12 left-1/2 transform -translate-x-1/2">
                            <div
                                class="w-24 h-24 rounded-full border-4 border-white bg-white flex items-center justify-center overflow-hidden">
                                @if($student->photo)
                                    <img src="{{ asset('storage/' . $student->photo) }}" class="w-full h-full object-cover"
                                        alt="{{ $student->full_name }}">
                                @else
                                    <span class="text-2xl font-bold text-emerald-600">
                                        {{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="pt-14 px-4 pb-4 text-center">
                        <h3 class="font-bold text-gray-900 text-lg">{{ $student->full_name }}</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $student->student_number }}</p>
                        <p class="text-sm font-medium text-emerald-600 mb-4">{{ $student->classe->full_name }}</p>

                        <!-- Quick Stats -->
                        <div class="grid grid-cols-3 gap-2 mb-4">
                            <div class="p-2 bg-blue-50 rounded">
                                <p class="text-xs text-gray-600">Âge</p>
                                <p class="text-sm font-bold text-gray-900">{{ $student->age }}</p>
                            </div>
                            <div class="p-2 bg-green-50 rounded">
                                <p class="text-xs text-gray-600">Présence</p>
                                <p class="text-sm font-bold text-gray-900">{{ $student->getAttendanceRateAttribute() }}%</p>
                            </div>
                            <div class="p-2 bg-purple-50 rounded">
                                <p class="text-xs text-gray-600">Moyenne</p>
                                <p class="text-sm font-bold text-gray-900">
                                    {{ number_format($student->grades->avg('score') ?? 0, 1) }}
                                </p>
                            </div>
                        </div>

                        <!-- Status Badge -->
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                                                                                                                                                                                                                                                                                {{ $student->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($student->status) }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    <p class="text-gray-500">Aucun élève trouvé</p>
                </div>
            @endforelse
        </div>
    @else
        <!-- Table View -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Photo</th>

                            <th wire:click="sortBy('student_number')"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer hover:bg-gray-100 transition-colors">
                                <div class="flex items-center space-x-1">
                                    <span>N° Étudiant</span>
                                    @if($sortBy === 'student_number')
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="{{ $sortDirection === 'asc' ? 'M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z' : 'M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z' }}"
                                                clip-rule="evenodd">
                                            </path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                clip-rule="evenodd">
                                            </path>
                                        </svg>
                                    @endif
                                </div>
                            </th>

                            <th wire:click="sortBy('last_name')"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer hover:bg-gray-100 transition-colors">
                                <div class="flex items-center space-x-1">
                                    <span>Nom Complet</span>
                                    @if($sortBy === 'last_name')
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="{{ $sortDirection === 'asc' ? 'M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z' : 'M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z' }}"
                                                clip-rule="evenodd">
                                            </path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                clip-rule="evenodd">
                                            </path>
                                        </svg>
                                    @endif
                                </div>
                            </th>

                            <th wire:click="sortBy('class_name')"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer hover:bg-gray-100 transition-colors">
                                <div class="flex items-center space-x-1">
                                    <span>Classe</span>
                                    @if($sortBy === 'class_name')
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="{{ $sortDirection === 'asc' ? 'M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z' : 'M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z' }}"
                                                clip-rule="evenodd">
                                            </path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                clip-rule="evenodd">
                                            </path>
                                        </svg>
                                    @endif
                                </div>
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Genre</th>

                            <th wire:click="sortBy('average_grade')"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer hover:bg-gray-100 transition-colors">
                                <div class="flex items-center space-x-1">
                                    <span>Moyenne</span>
                                    @if($sortBy === 'average_grade')
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="{{ $sortDirection === 'asc' ? 'M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z' : 'M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z' }}"
                                                clip-rule="evenodd">
                                            </path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                clip-rule="evenodd">
                                            </path>
                                        </svg>
                                    @endif
                                </div>
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($this->students as $student)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <!-- Photo -->
                                <td class="px-6 py-4">
                                    <div
                                        class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white font-semibold">
                                        @if($student->photo)
                                            <img src="{{ asset('storage/' . $student->photo) }}"
                                                class="w-10 h-10 rounded-full object-cover" alt="{{ $student->full_name }}">
                                        @else
                                            {{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}
                                        @endif
                                    </div>
                                </td>

                                <!-- Numéro étudiant -->
                                <td class="px-6 py-4">
                                    <span class="font-mono text-sm font-medium text-gray-900">
                                        {{ $student->student_number }}
                                    </span>
                                </td>

                                <!-- Nom complet -->
                                <td class="px-6 py-4">
                                    <div>
                                        <div class="font-semibold text-gray-900">{{ $student->full_name }}</div>
                                        <div class="text-sm text-gray-500">{{ $student->email }}</div>
                                    </div>
                                </td>

                                <!-- Classe -->
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $student->classe->name ?? '—' }}
                                    </span>
                                </td>

                                <!-- Genre -->
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $student->gender == 'M' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                        {{ $student->gender == 'M' ? 'Garçon' : 'Fille' }}
                                    </span>
                                </td>

                                <!-- Moyenne -->
                                <td class="px-6 py-4">
                                    <span
                                        class="font-semibold {{ $student->average_grade >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $student->average_grade ?? 'N/A' }}/20
                                    </span>
                                </td>

                                <!-- Statut -->
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $student->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $student->status == 'active' ? 'Actif' : 'Inactif' }}
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4">
                                    <button wire:click="viewStudent({{ $student->id }})"
                                        class="text-emerald-600 hover:text-emerald-900 font-medium text-sm mr-3">
                                        Voir
                                    </button>
                                    <button wire:click="sendMessage({{ $student->id }})"
                                        class="text-blue-600 hover:text-blue-900 font-medium text-sm">
                                        Message
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
                <div class="mt-2">
                    {{ $this->students->links() }}
                </div>
            </div>
        </div>
    @endif

    @if($showStudentModal && $this->selectedStudent)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
            wire:click="closeStudentModal">
            <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto" wire:click.stop>
                <!-- Modal Header -->
                <div class="sticky top-0 bg-gradient-to-r from-emerald-500 to-teal-600 p-6 text-white">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 rounded-full bg-white flex items-center justify-center">
                                @if($this->selectedStudent->photo)
                                    <img src="{{ asset('storage/' . $this->selectedStudent->photo) }}"
                                        class="w-16 h-16 rounded-full object-cover"
                                        alt="{{ $this->selectedStudent->full_name }}">
                                @else
                                    <span class="text-2xl font-bold text-emerald-600">
                                        {{ substr($this->selectedStudent->first_name, 0, 1) }}{{ substr($this->selectedStudent->last_name, 0, 1) }}
                                    </span>
                                @endif
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold">{{ $this->selectedStudent->full_name }}</h2>
                                <p class="text-emerald-100">{{ $this->selectedStudent->student_number }} •
                                    {{ $this->selectedStudent->classe->full_name }}
                                </p>
                            </div>
                        </div>
                        <button wire:click="closeStudentModal"
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
                    <!-- Student Info Grid -->
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600">Date de naissance</p>
                            <p class="font-semibold text-gray-900">
                                {{ \Carbon\Carbon::parse($this->selectedStudent->birth_date)->format('d/m/Y') ?? '-' }}
                                ({{ $this->selectedStudent->age }} ans)
                            </p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600">Lieu de naissance</p>
                            <p class="font-semibold text-gray-900">{{ $this->selectedStudent->birth_place }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600">Nationalité</p>
                            <p class="font-semibold text-gray-900">{{ $this->selectedStudent->nationality }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600">Genre</p>
                            <p class="font-semibold text-gray-900">
                                {{ $this->selectedStudent->gender == 'M' ? 'Masculin' : 'Féminin' }}
                            </p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600">Téléphone</p>
                            <p class="font-semibold text-gray-900">{{ $this->selectedStudent->phone ?? 'Non renseigné' }}
                            </p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="font-semibold text-gray-900">{{ $this->selectedStudent->email ?? 'Non renseigné' }}
                            </p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg col-span-2">
                            <p class="text-sm text-gray-600">Adresse</p>
                            <p class="font-semibold text-gray-900">{{ $this->selectedStudent->address }}</p>
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div class="grid grid-cols-3 gap-4 mb-6">
                        <div class="p-4 bg-blue-50 rounded-lg text-center">
                            <p class="text-2xl font-bold text-blue-600">

                                {{ $this->selectedStudent->attendance_rate ?? 'Non définie' }}%

                            </p>
                            <p class="text-sm text-gray-600">Taux de présence</p>
                        </div>
                        <div class="p-4 bg-green-50 rounded-lg text-center">
                            <p class="text-2xl font-bold text-green-600">
                                {{ number_format($this->selectedStudent->grades->avg('score') ?? 0, 2) }}
                            </p>
                            <p class="text-sm text-gray-600">Moyenne générale</p>
                        </div>
                        <div class="p-4 bg-purple-50 rounded-lg text-center">
                            <p class="text-2xl font-bold text-purple-600">{{ $this->selectedStudent->grades->count() }}</p>
                            <p class="text-sm text-gray-600">Évaluations</p>
                        </div>
                    </div>

                    <!-- Medical Info -->
                    @if($this->selectedStudent->medical_info)
                        <div class="p-4 bg-yellow-50 border-l-4 border-yellow-500 rounded mb-6">
                            <h4 class="font-semibold text-yellow-900 mb-2">⚕️ Informations Médicales</h4>
                            <p class="text-sm text-yellow-800">{{ $this->selectedStudent->medical_info }}</p>
                        </div>
                    @endif

                    <!-- Notes -->
                    @if($this->selectedStudent->notes)
                        <div class="p-4 bg-blue-50 border-l-4 border-blue-500 rounded">
                            <h4 class="font-semibold text-blue-900 mb-2">📝 Notes</h4>
                            <p class="text-sm text-blue-800">{{ $this->selectedStudent->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>