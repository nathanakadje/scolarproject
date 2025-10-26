<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Espace Étudiant' }} - Plateforme Scolaire</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-xl hidden lg:block border-r border-gray-200">
            <div class="h-full flex flex-col">
                <!-- Logo -->
                <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-blue-600 to-indigo-600">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-white font-bold text-lg">Espace Étudiant</h2>
                            <p class="text-blue-100 text-xs">Plateforme Scolaire</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                    <a href="{{ route('student.dashboard') }}"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-all {{ request()->routeIs('student.dashboard') ? 'bg-indigo-50 text-indigo-600 font-semibold' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        Tableau de bord
                    </a>

                    <a href="#"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-all {{ request()->routeIs('student.courses') ? 'bg-indigo-50 text-indigo-600 font-semibold' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        Mes Cours
                    </a>

                    <a href="#"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-all {{ request()->routeIs('student.grades') ? 'bg-indigo-50 text-indigo-600 font-semibold' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                        Mes Notes
                    </a>

                    <a href="#"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-all {{ request()->routeIs('student.timetable') ? 'bg-indigo-50 text-indigo-600 font-semibold' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        Emploi du temps
                    </a>

                    <a href="#"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-all {{ request()->routeIs('student.calendar') ? 'bg-indigo-50 text-indigo-600 font-semibold' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        Calendrier
                    </a>

                    <a href="#"
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-all {{ request()->routeIs('student.messages') ? 'bg-indigo-50 text-indigo-600 font-semibold' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        Messages
                        <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">3</span>
                    </a>
                </nav>

                <!-- User Profile -->
                <div class="p-4 border-t border-gray-200">
                    <div class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 cursor-pointer">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center text-white font-semibold">
                            {{ substr(auth()->user()->name, 0, 2) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500 truncate">Étudiant</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm border-b border-gray-200 z-10">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <!-- Mobile menu button -->
                        <button class="lg:hidden text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>

                        <!-- Search Bar -->
                        <div class="flex-1 max-w-2xl mx-4">
                            <div class="relative">
                                <input type="text" placeholder="Rechercher un cours, un professeur..."
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Right Side -->
                        <div class="flex items-center space-x-4">
                            <!-- Notifications -->
                            <button class="relative text-gray-600 hover:text-gray-900">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                    </path>
                                </svg>
                                <span
                                    class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full text-xs text-white flex items-center justify-center">5</span>
                            </button>

                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="text-gray-600 hover:text-red-600 flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    <span class="hidden md:inline">Déconnexion</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 px-6 py-4">
                <div class="flex flex-col md:flex-row items-center justify-between text-sm text-gray-600">
                    <!-- <p>&copy; 2025 Plateforme Scolaire. Tous droits réservés.</p>
                    <div class="flex space-x-4 mt-2 md:mt-0">
                        <a href="#" class="hover:text-indigo-600">Support</a>
                        <a href="#" class="hover:text-indigo-600">Documentation</a>
                        <a href="#" class="hover:text-indigo-600">Confidentialité</a>
                    </div> -->
                </div>
            </footer>
        </div>
    </div>

</body>
@livewireScripts

</html>