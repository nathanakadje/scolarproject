<div>
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Bienvenue📚</h1>
        <p class="text-gray-600 mt-2">Gérez vos cours, suivez vos étudiants et consultez votre emploi du temps</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Étudiants -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Étudiants</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_students'] }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-gray-500">
                <span>Répartis sur {{ $stats['total_courses'] }} cours</span>
            </div>
        </div>

        <!-- Mes Cours -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Mes Cours</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_courses'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-green-600">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Tous actifs
            </div>
        </div>

        <!-- Devoirs à corriger -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">À corriger</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['assignments_to_grade'] }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-orange-600">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                En attente
            </div>
        </div>

        <!-- Performance moyenne -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Performance Moy.</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['average_class_performance'] }}/20</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-green-600">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"
                        clip-rule="evenodd"></path>
                </svg>
                +0.3 ce mois
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column (2/3) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Cours d'aujourd'hui -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-semibold text-gray-900">Mes cours aujourd'hui</h2>




                    </div>
                </div>
                <div class="p-6 space-y-4">
                    @foreach($upcomingClasses as $class)
                        <div
                            class="flex items-start p-4 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-lg border border-emerald-100 hover:shadow-md transition-shadow">
                            <div
                                class="flex-shrink-0 w-16 h-16 bg-emerald-600 rounded-lg flex flex-col items-center justify-center text-white">
                                <span class="text-xs font-semibold">{{ substr($class['time'], 0, 5) }}</span>
                                <span class="text-xs">{{ substr($class['time'], -5) }}</span>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h3 class="font-semibold text-gray-900 text-lg">{{ $class['course'] }}</h3>
                                        <p class="text-sm text-gray-600 mt-1">{{ $class['class'] }}</p>
                                    </div>
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        {{ $class['students_count'] }} élèves
                                    </span>
                                </div>
                                <div class="flex items-center mt-3 text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $class['room'] }}
                                </div>
                            </div>
                            <div class="ml-4 flex flex-col space-y-2">
                                <button
                                    class="px-4 py-2 bg-emerald-600 text-white text-sm rounded-lg hover:bg-emerald-700 transition-colors">
                                    Démarrer
                                </button>
                                <button
                                    class="px-4 py-2 bg-gray-100 text-gray-700 text-sm rounded-lg hover:bg-gray-200 transition-colors">
                                    Détails
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Devoirs en attente de correction -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-semibold text-gray-900">Devoirs à corriger</h2>



                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Cours</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Devoir</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Progression</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Échéance</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pendingAssignments as $assignment)
                                                    <tr class="hover:bg-gray-50 transition-colors">
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="text-sm font-medium text-gray-900">{{ $assignment['course'] }}</div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="text-sm text-gray-600">{{ $assignment['title'] }}</div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="flex items-center">
                                                                <div class="flex-1 bg-gray-200 rounded-full h-2 max-w-[100px]">
                                                                    <div class="bg-emerald-600 h-2 rounded-full"
                                                                        style="width: {{ ($assignment['submissions'] / $assignment['total']) * 100 }}%">
                                                                    </div>
                                                                </div>
                                                                <span class="ml-2 text-sm text-gray-600">{{ $assignment['submissions'] }}/{{
                                $assignment['total'] }}</span>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                            {{ \Carbon\Carbon::parse($assignment['deadline'])->format('d/m/Y') }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <button class="text-emerald-600 hover:text-emerald-900 font-medium text-sm">
                                                                Corriger →
                                                            </button>
                                                        </td>
                                                    </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column (1/3) -->
        <div class="space-y-6">
            <!-- Activités récentes -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Activités récentes</h2>
                </div>
                <div class="p-6 space-y-4">
                    @foreach($recentActivities as $activity)
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            @if($activity['type'] === 'submission')
                                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                        </path>
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                        </path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm text-gray-900">
                                                <span class="font-semibold">{{ $activity['student'] }}</span>
                                                {{ $activity['action'] }}
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1">{{ $activity['course'] }} • Il y a {{
                        $activity['time'] }}</p>
                                        </div>
                                    </div>
                    @endforeach
                </div>
                <div class="p-4 border-t border-gray-200">
                    <button class="w-full text-center text-sm text-emerald-600 hover:text-emerald-800 font-medium">
                        Voir toutes les activités
                    </button>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl shadow-sm p-6 text-white">
                <h2 class="text-xl font-semibold mb-4">Actions rapides</h2>
                <div class="space-y-3">
                    <a href="#"
                        class="flex items-center justify-between p-3 bg-white bg-opacity-20 rounded-lg hover:bg-opacity-30 transition-all cursor-pointer">
                        <span class="font-medium">Créer un cours</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                    </a>
                    <a href="#"
                        class="flex items-center justify-between p-3 bg-white bg-opacity-20 rounded-lg hover:bg-opacity-30 transition-all cursor-pointer">
                        <span class="font-medium">Ajouter un devoir</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                    </a>
                    <a href="#"
                        class="flex items-center justify-between p-3 bg-white bg-opacity-20 rounded-lg hover:bg-opacity-30 transition-all cursor-pointer">
                        <span class="font-medium">Envoyer un message</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </a>
                    <a href="#"
                        class="flex items-center justify-between p-3 bg-white bg-opacity-20 rounded-lg hover:bg-opacity-30 transition-all cursor-pointer">
                        <span class="font-medium">Ajouter un événement</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Stats de la semaine -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Cette semaine</h2>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Cours donnés</span>
                        <span class="text-lg font-bold text-gray-900">12</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Devoirs corrigés</span>
                        <span class="text-lg font-bold text-gray-900">45</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Messages envoyés</span>
                        <span class="text-lg font-bold text-gray-900">23</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Heures enseignées</span>
                        <span class="text-lg font-bold text-gray-900">24h</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>