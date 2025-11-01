<div>
    <div class="space-y-6">
        {{-- Header with Gradient --}}
        <div
            class="relative overflow-hidden bg-gradient-to-r from-emerald-600 via-teal-500 to-green-700 rounded-2xl shadow-2xl p-8">
            <div class="absolute inset-0 bg-black/10"></div>
            <div class="relative z-10">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div class="text-white">
                        <div class="flex items-center gap-3 mb-2">
                            <div
                                class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-4xl font-bold">Gestion des Devoirs</h1>
                                <!-- <p class="text-white/80 mt-1">Créez, suivez et évaluez les devoirs de vos élèves</p> -->
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button wire:click="openAssignmentModal"
                            class="px-6 py-3 bg-white text-indigo-600 rounded-xl hover:bg-gray-100 transition-all font-bold shadow-lg flex items-center gap-2 hover:scale-105 transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Nouveau Devoir
                        </button>
                    </div>
                </div>
            </div>

            {{-- Decorative elements --}}
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
        </div>

        {{-- Quick Stats Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4">
            <div
                class="bg-white rounded-xl p-4 shadow-md border-l-4 border-blue-500 hover:shadow-xl transition-shadow cursor-pointer">
                <div class="text-3xl font-bold text-blue-600">{{ $this->stats['total'] }}</div>
                <div class="text-sm text-gray-600 font-medium mt-1">Total</div>
            </div>

            <div
                class="bg-white rounded-xl p-4 shadow-md border-l-4 border-green-500 hover:shadow-xl transition-shadow cursor-pointer">
                <div class="text-3xl font-bold text-green-600">{{ $this->stats['active'] }}</div>
                <div class="text-sm text-gray-600 font-medium mt-1">Actifs</div>
            </div>

            <div
                class="bg-white rounded-xl p-4 shadow-md border-l-4 border-gray-500 hover:shadow-xl transition-shadow cursor-pointer">
                <div class="text-3xl font-bold text-gray-600">{{ $this->stats['draft'] }}</div>
                <div class="text-sm text-gray-600 font-medium mt-1">Brouillons</div>
            </div>

            <div
                class="bg-white rounded-xl p-4 shadow-md border-l-4 border-red-500 hover:shadow-xl transition-shadow cursor-pointer">
                <div class="text-3xl font-bold text-red-600">{{ $this->stats['overdue'] }}</div>
                <div class="text-sm text-gray-600 font-medium mt-1">En retard</div>
            </div>

            <div
                class="bg-white rounded-xl p-4 shadow-md border-l-4 border-yellow-500 hover:shadow-xl transition-shadow cursor-pointer">
                <div class="text-3xl font-bold text-yellow-600">{{ $this->stats['due_soon'] }}</div>
                <div class="text-sm text-gray-600 font-medium mt-1">Bientôt dus</div>
            </div>

            <div
                class="bg-white rounded-xl p-4 shadow-md border-l-4 border-orange-500 hover:shadow-xl transition-shadow cursor-pointer">
                <div class="text-3xl font-bold text-orange-600">{{ $this->stats['pending_grading'] }}</div>
                <div class="text-sm text-gray-600 font-medium mt-1">À corriger</div>
            </div>

            <div
                class="bg-white rounded-xl p-4 shadow-md border-l-4 border-purple-500 hover:shadow-xl transition-shadow cursor-pointer">
                <div class="text-3xl font-bold text-purple-600">{{ $this->stats['total_submissions'] }}</div>
                <div class="text-sm text-gray-600 font-medium mt-1">Soumissions</div>
            </div>

            <div
                class="bg-white rounded-xl p-4 shadow-md border-l-4 border-indigo-500 hover:shadow-xl transition-shadow cursor-pointer">
                <div class="text-3xl font-bold text-indigo-600">{{ number_format($this->stats['average_grade'], 1) }}
                </div>
                <div class="text-sm text-gray-600 font-medium mt-1">Moy. /20</div>
            </div>
        </div>

        {{-- View Mode Selector & Filters --}}
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-4">
                {{-- View Mode --}}
                <div class="flex bg-gray-100 rounded-lg p-1">
                    <button wire:click="$set('viewMode', 'grid')"
                        class="px-4 py-2 rounded-md transition-all {{ $viewMode === 'grid' ? 'bg-white shadow-md text-indigo-600 font-semibold' : 'text-gray-600 hover:text-gray-900' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                    </button>
                    <button wire:click="$set('viewMode', 'list')"
                        class="px-4 py-2 rounded-md transition-all {{ $viewMode === 'list' ? 'bg-white shadow-md text-indigo-600 font-semibold' : 'text-gray-600 hover:text-gray-900' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                </div>

                {{-- Bulk Actions --}}
                @if(count($selectedAssignments) > 0)
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-600 font-medium">{{ count($selectedAssignments) }}
                            sélectionné(s)</span>
                        <select wire:model="bulkAction" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                            <option value="">Actions groupées</option>
                            <option value="publish">Publier</option>
                            <option value="close">Fermer</option>
                            <option value="archive">Archiver</option>
                            <option value="delete">Supprimer</option>
                        </select>
                        <button wire:click="performBulkAction"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors text-sm font-semibold">
                            Appliquer
                        </button>
                    </div>
                @endif
            </div>

            {{-- Filters --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
                {{-- Search --}}
                <div class="lg:col-span-2">
                    <div class="relative">
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Rechercher un devoir..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                {{-- Status Filter --}}
                <div>
                    <select wire:model.live="filterStatus"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="all">Tous les statuts</option>
                        <option value="draft">📝 Brouillon</option>
                        <option value="published">📢 Publié</option>
                        <option value="active">✅ Actif</option>
                        <option value="closed">🔒 Fermé</option>
                        <option value="archived">📦 Archivé</option>
                    </select>
                </div>

                {{-- Type Filter --}}
                <div>
                    <select wire:model.live="filterType"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="all">Tous les types</option>
                        <option value="homework">📝 Devoir</option>
                        <option value="project">🎯 Projet</option>
                        <option value="exercise">💪 Exercice</option>
                        <option value="research">🔬 Recherche</option>
                        <option value="presentation">🎤 Présentation</option>
                    </select>
                </div>

                {{-- Class Filter --}}
                <div>
                    <select wire:model.live="filterClass"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="all">Toutes les classes</option>
                        @foreach($this->classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Sort --}}
                <div>
                    <select wire:model.live="sortBy"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="due_date_asc">Date limite ↑</option>
                        <option value="due_date_desc">Date limite ↓</option>
                        <option value="created_desc">Plus récents</option>
                        <option value="created_asc">Plus anciens</option>
                        <option value="title">Par titre</option>
                        <option value="submissions">Par soumissions</option>
                    </select>
                </div>
            </div>
        </div>



        {{-- Assignments Display --}}
        @if($viewMode === 'grid')
            {{-- Grid View --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($this->assignments as $assignment)
                    <div
                        class="group relative bg-white rounded-2xl shadow-md border-2 border-gray-200 hover:border-emerald-400 hover:shadow-2xl transition-all overflow-hidden">
                        {{-- Header with gradient --}}
                        <div
                            class="h-3 bg-gradient-to-r from-{{ $assignment->difficulty_color }}-400 to-{{ $assignment->difficulty_color }}-600">
                        </div>

                        {{-- Selection Checkbox --}}
                        <div class="absolute top-6 left-4 z-10">
                            <input type="checkbox" wire:model="selectedAssignments" value="{{ $assignment->id }}"
                                class="w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500">
                        </div>

                        <div class="p-6">
                            {{-- Type & Status Badges --}}
                            <div class="flex items-center justify-between mb-3">
                                <span
                                    class="inline-flex items-center gap-1 px-3 py-1 bg-{{ $assignment->status_color }}-100 text-{{ $assignment->status_color }}-700 rounded-full text-xs font-bold">
                                    {{ $assignment->status_label }}
                                </span>
                                <span class="text-2xl">{{ $assignment->type_icon }}</span>
                            </div>

                            {{-- Title --}}
                            <h3
                                class="text-xl font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-indigo-600 transition-colors">
                                {{ $assignment->title }}
                            </h3>

                            {{-- Class & Subject --}}
                            <div class="flex items-center gap-2 mb-3 text-sm text-gray-600">
                                <span class="font-semibold">{{ $assignment->class->name }}</span>
                                <span>•</span>
                                <span>{{ $assignment->subject->name }}</span>
                            </div>

                            {{-- Description --}}
                            @if($assignment->description)
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $assignment->description }}</p>
                            @endif

                            {{-- Due Date --}}
                            <div class="flex items-center gap-2 mb-4 p-3 bg-gray-50 rounded-lg">
                                <svg class="w-5 h-5 {{ $assignment->is_overdue ? 'text-red-500' : 'text-gray-500' }}"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="flex-1">
                                    <div class="text-xs text-gray-500">Date limite</div>
                                    <div class="font-semibold {{ $assignment->is_overdue ? 'text-red-600' : 'text-gray-900' }}">
                                        {{ $assignment->due_date->format('d/m/Y à H:i') }}
                                    </div>
                                </div>
                                @if($assignment->is_overdue)
                                    <span class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded-full font-bold">En retard</span>
                                @elseif($assignment->days_until_due <= 3 && $assignment->days_until_due >= 0)
                                    <span
                                        class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full font-bold">{{ $assignment->days_until_due }}j</span>
                                @endif
                            </div>

                            {{-- Stats --}}
                            <div class="grid grid-cols-3 gap-2 mb-4">
                                <div class="text-center p-2 bg-blue-50 rounded-lg">
                                    <div class="text-lg font-bold text-blue-600">{{ $assignment->submission_count }}</div>
                                    <div class="text-xs text-blue-700">Rendus</div>
                                </div>
                                <div class="text-center p-2 bg-green-50 rounded-lg">
                                    <div class="text-lg font-bold text-green-600">
                                        {{ number_format($assignment->submission_rate, 0) }}%
                                    </div>
                                    <div class="text-xs text-green-700">Taux</div>
                                </div>
                                <div class="text-center p-2 bg-purple-50 rounded-lg">
                                    <div class="text-lg font-bold text-purple-600">
                                        {{ number_format($assignment->grading_progress, 0) }}%
                                    </div>
                                    <div class="text-xs text-purple-700">Corrigés</div>
                                </div>
                            </div>

                            {{-- Progress Bar --}}
                            <div class="mb-4">
                                <div class="flex items-center justify-between text-xs text-gray-600 mb-1">
                                    <span>Progression</span>
                                    <span>{{ $assignment->graded_count }}/{{ $assignment->submission_count }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-2 rounded-full transition-all"
                                        style="width: {{ $assignment->grading_progress }}%"></div>
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="grid grid-cols-2 gap-2">
                                <button wire:click="viewSubmissions({{ $assignment->id }})"
                                    class="px-3 py-2 bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-200 transition-colors text-sm font-semibold flex items-center justify-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Rendus
                                </button>
                                <button wire:click="viewAnalytics({{ $assignment->id }})"
                                    class="px-3 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors text-sm font-semibold flex items-center justify-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                    Stats
                                </button>
                            </div>

                            {{-- More Actions Dropdown --}}
                            <div class="mt-2 flex gap-2">
                                @if($assignment->status === 'draft')
                                    <button wire:click="publishAssignment({{ $assignment->id }})"
                                        class="flex-1 px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-semibold">
                                        📢 Publier
                                    </button>
                                @endif

                                @if($assignment->status === 'active')
                                    <button wire:click="closeAssignment({{ $assignment->id }})"
                                        class="flex-1 px-3 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors text-sm font-semibold">
                                        🔒 Fermer
                                    </button>
                                @endif

                                <button wire:click="openAssignmentModal({{ $assignment->id }})"
                                    class="px-3 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>

                                <button wire:click="duplicateAssignment({{ $assignment->id }})"
                                    class="px-3 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </button>

                                <button wire:click="deleteAssignment({{ $assignment->id }})"
                                    wire:confirm="Êtes-vous sûr de vouloir supprimer ce devoir ?"
                                    class="px-3 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty

                    <div class="col-span-full">
                        <div class="text-center py-16 bg-white rounded-2xl shadow-md border-2 border-dashed border-gray-300">
                            <div
                                class="w-32 h-32 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-16 h-16 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Aucun devoir trouvé</h3>
                            <p class="text-gray-600 mb-6 max-w-md mx-auto">Commencez par créer votre premier devoir pour vos
                                élèves</p>
                            <button wire:click="openAssignmentModal"
                                class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all font-bold shadow-lg">
                                ✨ Créer mon premier devoir
                            </button>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($this->assignments->hasPages())
                <div class="mt-6">
                    {{ $this->assignments->links() }}
                </div>
            @endif
        @elseif($viewMode === 'list')
            {{-- List View --}}
            <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gradient-to-r from-emerald-900 via-teal-800 to-slate-900 text-white">
                            <tr>
                                <th class="px-4 py-3 text-left">
                                    <input type="checkbox" class="w-4 h-4 rounded">
                                </th>
                                <th class="px-4 py-3 text-left font-semibold">Titre</th>
                                <th class="px-4 py-3 text-left font-semibold">Classe</th>
                                <th class="px-4 py-3 text-left font-semibold">Type</th>
                                <th class="px-4 py-3 text-left font-semibold">Date limite</th>
                                <th class="px-4 py-3 text-center font-semibold">Rendus</th>
                                <th class="px-4 py-3 text-center font-semibold">Progression</th>
                                <th class="px-4 py-3 text-center font-semibold">Statut</th>
                                <th class="px-4 py-3 text-right font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($this->assignments as $assignment)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-4">
                                        <input type="checkbox" wire:model="selectedAssignments" value="{{ $assignment->id }}"
                                            class="w-4 h-4 text-indigo-600 rounded">
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-3">
                                            <span class="text-2xl">{{ $assignment->type_icon }}</span>
                                            <div>
                                                <div class="font-semibold text-gray-900">{{ $assignment->title }}</div>
                                                <div class="text-sm text-gray-500">{{ $assignment->subject->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="font-medium text-gray-700">{{ $assignment->class->name }}</span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span
                                            class="inline-flex items-center px-2 py-1 bg-{{ $assignment->difficulty_color }}-100 text-{{ $assignment->difficulty_color }}-700 rounded-full text-xs font-bold">
                                            {{ ucfirst($assignment->difficulty) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="text-sm">
                                            <div
                                                class="font-semibold {{ $assignment->is_overdue ? 'text-red-600' : 'text-gray-900' }}">
                                                {{ $assignment->due_date->format('d/m/Y') }}
                                            </div>
                                            <div class="text-gray-500">{{ $assignment->due_date->format('H:i') }}</div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <div class="font-bold text-gray-900">{{ $assignment->submission_count }}</div>
                                        <div class="text-xs text-gray-500">{{ number_format($assignment->submission_rate, 0) }}%
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-gradient-to-r from-green-500 to-emerald-600 h-2 rounded-full"
                                                style="width: {{ $assignment->grading_progress }}%"></div>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1 text-center">
                                            {{ number_format($assignment->grading_progress, 0) }}%
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span
                                            class="inline-flex items-center px-3 py-1 bg-{{ $assignment->status_color }}-100 text-{{ $assignment->status_color }}-700 rounded-full text-xs font-bold">
                                            {{ $assignment->status_label }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <button wire:click="viewSubmissions({{ $assignment->id }})"
                                                class="p-2 bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-200 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                            <button wire:click="openAssignmentModal({{ $assignment->id }})"
                                                class="p-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <button wire:click="deleteAssignment({{ $assignment->id }})"
                                                wire:confirm="Supprimer ce devoir ?"
                                                class="p-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-4 py-16 text-center text-gray-500">
                                        Aucun devoir trouvé
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- Assignment Creation/Edit Modal --}}
        @if($showAssignmentModal)
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
                <div class="bg-white rounded-2xl shadow-2xl max-w-5xl w-full max-h-[90vh] overflow-hidden">
                    {{-- Header --}}
                    <div class="bg-gradient-to-r from-emerald-600 via-teal-500 to-green-700 text-white p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-2xl font-bold">
                                    {{ $assignmentId ? '✏️ Modifier le devoir' : '✨ Créer un nouveau devoir' }}
                                </h3>
                                <p class="text-white/80 mt-1">Étape {{ $step }} sur 4</p>
                            </div>
                            <button wire:click="$set('showAssignmentModal', false)" class="text-white/80 hover:text-white">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        {{-- Progress Bar --}}
                        <div class="mt-4 flex gap-2">
                            @for($i = 1; $i <= 4; $i++)
                                <div class="flex-1 h-2 rounded-full {{ $step >= $i ? 'bg-white' : 'bg-white/30' }}"></div>
                            @endfor
                        </div>
                    </div>

                    <form wire:submit.prevent="saveAssignment" class="overflow-y-auto"
                        style="max-height: calc(90vh - 180px);">
                        <div class="p-6">
                            {{-- Step 1: Basic Info --}}
                            @if($step === 1)
                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">📌 Titre du devoir *</label>
                                        <input type="text" wire:model="title"
                                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-lg"
                                            placeholder="Ex: Devoir de Mathématiques - Les fonctions">
                                        @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-2">🏫 Classe *</label>
                                            <select wire:model="selectedClassId"
                                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                                <option value="">Sélectionner une classe</option>
                                                @foreach($this->classes as $class)
                                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('selectedClassId') <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-2">📚 Matière *</label>
                                            <select wire:model="selectedSubjectId"
                                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                                <option value="">Sélectionner une matière</option>
                                                @foreach($this->subjects as $subject)
                                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('selectedSubjectId') <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-3">🎯 Type de devoir *</label>
                                        <div class="grid grid-cols-5 gap-3">
                                            @foreach(['homework' => ['📝', 'Devoir'], 'project' => ['🎯', 'Projet'], 'exercise' => ['💪', 'Exercice'], 'research' => ['🔬', 'Recherche'], 'presentation' => ['🎤', 'Présentation']] as $typeKey => $typeData)
                                                <div wire:click="$set('type', '{{ $typeKey }}')"
                                                    class="cursor-pointer p-4 border-2 rounded-xl transition-all {{ $type === $typeKey ? 'border-indigo-600 bg-indigo-50 shadow-lg scale-105' : 'border-gray-200 hover:border-indigo-300' }}">
                                                    <div class="text-center">
                                                        <div class="text-3xl mb-2">{{ $typeData[0] }}</div>
                                                        <div class="text-sm font-semibold">{{ $typeData[1] }}</div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-3">⚡ Difficulté *</label>
                                        <div class="grid grid-cols-4 gap-3">
                                            @foreach(['easy' => ['🟢', 'Facile', 'green'], 'medium' => ['🟡', 'Moyen', 'yellow'], 'hard' => ['🟠', 'Difficile', 'orange'], 'expert' => ['🔴', 'Expert', 'red']] as $diffKey => $diffData)
                                                <div wire:click="$set('difficulty', '{{ $diffKey }}')"
                                                    class="cursor-pointer p-4 border-2 rounded-xl transition-all {{ $difficulty === $diffKey ? 'border-' . $diffData[2] . '-600 bg-' . $diffData[2] . '-50 shadow-lg scale-105' : 'border-gray-200 hover:border-' . $diffData[2] . '-300' }}">
                                                    <div class="text-center">
                                                        <div class="text-2xl mb-1">{{ $diffData[0] }}</div>
                                                        <div class="text-sm font-semibold">{{ $diffData[1] }}</div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">📝 Description</label>
                                        <textarea wire:model="description" rows="3"
                                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                            placeholder="Décrivez brièvement le devoir..."></textarea>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">📋 Instructions
                                            détaillées</label>
                                        <textarea wire:model="instructions" rows="5"
                                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                            placeholder="Instructions complètes pour les élèves..."></textarea>
                                    </div>
                                </div>
                            @endif

                            {{-- Step 2: Dates & Points --}}
                            @if($step === 2)
                                <div class="space-y-6">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-2">📅 Date
                                                d'attribution</label>
                                            <input type="date" wire:model="assignedDate"
                                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-2">⏰ Date limite *</label>
                                            <input type="date" wire:model="dueDate"
                                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                            @error('dueDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-2">🕐 Heure limite</label>
                                            <input type="time" wire:model="dueTime"
                                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-2">⏱️ Durée estimée
                                                (minutes)</label>
                                            <input type="number" wire:model="estimatedDuration"
                                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                                min="0">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">💯 Points maximum *</label>
                                        <input type="number" wire:model="maxPoints" step="0.5"
                                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                            min="0">
                                        @error('maxPoints') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="p-4 bg-yellow-50 border-2 border-yellow-200 rounded-xl">
                                        <label class="flex items-center gap-3 cursor-pointer">
                                            <input type="checkbox" wire:model.live="allowLateSubmission"
                                                class="w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500">
                                            <div>
                                                <div class="font-bold text-gray-900">Autoriser les soumissions en retard</div>
                                                <div class="text-sm text-gray-600">Les élèves pourront soumettre après la date
                                                    limite</div>
                                            </div>
                                        </label>

                                        @if($allowLateSubmission)
                                            <div class="mt-4 grid grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Date limite
                                                        retard</label>
                                                    <input type="date" wire:model="lateSubmissionDate"
                                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Pénalité
                                                        (%)</label>
                                                    <input type="number" wire:model="latePenaltyPercent"
                                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                                        min="0" max="100">
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="p-4 bg-blue-50 border-2 border-blue-200 rounded-xl">
                                        <label class="flex items-center gap-3 cursor-pointer">
                                            <input type="checkbox" wire:model="sendReminders"
                                                class="w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500">
                                            <div>
                                                <div class="font-bold text-gray-900">Envoyer des rappels automatiques</div>
                                                <div class="text-sm text-gray-600">Notifier les élèves avant la date limite
                                                </div>
                                            </div>
                                        </label>

                                        @if($sendReminders)
                                            <div class="mt-4">
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">Rappel avant
                                                    (jours)</label>
                                                <input type="number" wire:model="reminderDaysBefore"
                                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                                    min="1" max="30">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif


                            {{-- Step 3: Submission Settings --}}
                            @if($step === 3)
                                <div class="space-y-6">
                                    <div class="p-4 bg-green-50 border-2 border-green-200 rounded-xl">
                                        <label class="flex items-center gap-3 cursor-pointer">
                                            <input type="checkbox" wire:model="allowFileUpload"
                                                class="w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500">
                                            <div>
                                                <div class="font-bold text-gray-900">📎 Autoriser l'upload de fichiers</div>
                                                <div class="text-sm text-gray-600">Les élèves peuvent joindre des fichiers</div>
                                            </div>
                                        </label>

                                        @if($allowFileUpload)
                                            <div class="mt-4 space-y-3">
                                                <div>
                                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Types de fichiers
                                                        autorisés</label>
                                                    <div class="grid grid-cols-3 gap-2">
                                                        @foreach(['pdf' => 'PDF', 'docx' => 'Word', 'doc' => 'Word (ancien)', 'txt' => 'Texte', 'jpg' => 'Image JPG', 'png' => 'Image PNG', 'xlsx' => 'Excel', 'pptx' => 'PowerPoint', 'zip' => 'Archive'] as $ext => $label)
                                                            <label
                                                                class="flex items-center gap-2 p-2 bg-white border rounded-lg cursor-pointer hover:bg-gray-50">
                                                                <input type="checkbox" wire:model="allowedFileTypes" value="{{ $ext }}"
                                                                    class="w-4 h-4 text-indigo-600 rounded">
                                                                <span class="text-sm">{{ $label }}</span>
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Taille max par
                                                            fichier (KB)</label>
                                                        <input type="number" wire:model="maxFileSize"
                                                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                                            min="1024">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nombre max de
                                                            fichiers</label>
                                                        <input type="number" wire:model="maxFiles"
                                                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                                            min="1" max="10">
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-4 bg-purple-50 border-2 border-purple-200 rounded-xl">
                                        <label class="flex items-center gap-3 cursor-pointer">
                                            <input type="checkbox" wire:model="allowTextSubmission"
                                                class="w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500">
                                            <div>
                                                <div class="font-bold text-gray-900">✍️ Autoriser la saisie de texte</div>
                                                <div class="text-sm text-gray-600">Les élèves peuvent écrire directement leur
                                                    réponse</div>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="p-4 bg-orange-50 border-2 border-orange-200 rounded-xl">
                                        <label class="flex items-center gap-3 cursor-pointer">
                                            <input type="checkbox" wire:model.live="groupAssignment"
                                                class="w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500">
                                            <div>
                                                <div class="font-bold text-gray-900">👥 Devoir de groupe</div>
                                                <div class="text-sm text-gray-600">Les élèves travaillent en équipe</div>
                                            </div>
                                        </label>

                                        @if($groupAssignment)
                                            <div class="mt-4">
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">Taille max du
                                                    groupe</label>
                                                <input type="number" wire:model="maxGroupSize"
                                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                                    min="2" max="10">
                                            </div>
                                        @endif
                                    </div>

                                    <div class="p-4 bg-pink-50 border-2 border-pink-200 rounded-xl">
                                        <label class="flex items-center gap-3 cursor-pointer">
                                            <input type="checkbox" wire:model.live="peerReviewEnabled"
                                                class="w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500">
                                            <div>
                                                <div class="font-bold text-gray-900">🤝 Évaluation par les pairs</div>
                                                <div class="text-sm text-gray-600">Les élèves s'évaluent mutuellement</div>
                                            </div>
                                        </label>

                                        @if($peerReviewEnabled)
                                            <div class="mt-4">
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nombre d'évaluations
                                                    requises</label>
                                                <input type="number" wire:model="peerReviewsRequired"
                                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                                    min="1" max="5">
                                            </div>
                                        @endif
                                    </div>

                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">🔗 Liens de ressources
                                            (optionnel)</label>
                                        <textarea wire:model="resourcesLinks" rows="3"
                                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                            placeholder="https://exemple.com/ressource1&#10;https://exemple.com/ressource2"></textarea>
                                        <p class="text-sm text-gray-500 mt-1">Un lien par ligne</p>
                                    </div>
                                </div>
                            @endif

                            {{-- Step 4: Rubric & Review --}}
                            @if($step === 4)
                                <div class="space-y-6">
                                    <div class="p-4 bg-indigo-50 border-2 border-indigo-200 rounded-xl">
                                        <h4 class="font-bold text-gray-900 mb-3">📊 Grille d'évaluation (Rubric)</h4>
                                        <p class="text-sm text-gray-600 mb-4">Définissez les critères d'évaluation pour une
                                            correction cohérente</p>

                                        @foreach($rubricCriteria as $index => $criterion)
                                            <div class="mb-4 p-4 bg-white border-2 border-gray-200 rounded-xl">
                                                <div class="flex items-center justify-between mb-3">
                                                    <h5 class="font-semibold text-gray-900">Critère {{ $index + 1 }}</h5>
                                                    <button type="button" wire:click="removeRubricCriterion({{ $index }})"
                                                        class="text-red-600 hover:text-red-700">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="space-y-3">
                                                    <input type="text" wire:model="rubricCriteria.{{ $index }}.name"
                                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg"
                                                        placeholder="Nom du critère">
                                                    <textarea wire:model="rubricCriteria.{{ $index }}.description" rows="2"
                                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg"
                                                        placeholder="Description"></textarea>
                                                    <input type="number" wire:model="rubricCriteria.{{ $index }}.points"
                                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg"
                                                        placeholder="Points" min="0" step="0.5">
                                                </div>
                                            </div>
                                        @endforeach

                                        <button type="button" wire:click="addRubricCriterion"
                                            class="w-full px-4 py-3 bg-indigo-100 text-indigo-700 rounded-xl hover:bg-indigo-200 transition-colors font-semibold flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                            Ajouter un critère
                                        </button>
                                    </div>

                                    <div
                                        class="p-6 bg-gradient-to-br from-gray-50 to-gray-100 border-2 border-gray-300 rounded-xl">
                                        <h4 class="font-bold text-gray-900 mb-4 text-lg">📋 Récapitulatif</h4>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="bg-white p-3 rounded-lg">
                                                <div class="text-sm text-gray-600">Titre</div>
                                                <div class="font-semibold text-gray-900">{{ $title ?: 'Non défini' }}</div>
                                            </div>
                                            <div class="bg-white p-3 rounded-lg">
                                                <div class="text-sm text-gray-600">Type</div>
                                                <div class="font-semibold text-gray-900">{{ ucfirst($type) }}</div>
                                            </div>
                                            <div class="bg-white p-3 rounded-lg">
                                                <div class="text-sm text-gray-600">Difficulté</div>
                                                <div class="font-semibold text-gray-900">{{ ucfirst($difficulty) }}</div>
                                            </div>
                                            <div class="bg-white p-3 rounded-lg">
                                                <div class="text-sm text-gray-600">Points maximum</div>
                                                <div class="font-semibold text-gray-900">{{ $maxPoints }}</div>
                                            </div>
                                            <div class="bg-white p-3 rounded-lg">
                                                <div class="text-sm text-gray-600">Date limite</div>
                                                <div class="font-semibold text-gray-900">{{ $dueDate }} à {{ $dueTime }}</div>
                                            </div>
                                            <div class="bg-white p-3 rounded-lg">
                                                <div class="text-sm text-gray-600">Durée estimée</div>
                                                <div class="font-semibold text-gray-900">{{ $estimatedDuration }} min</div>
                                            </div>
                                        </div>

                                        <div class="mt-4 p-3 bg-white rounded-lg">
                                            <div class="text-sm text-gray-600 mb-2">Options activées</div>
                                            <div class="flex flex-wrap gap-2">
                                                @if($allowFileUpload)
                                                    <span
                                                        class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">📎
                                                        Upload fichiers</span>
                                                @endif
                                                @if($allowTextSubmission)
                                                    <span
                                                        class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">✍️
                                                        Saisie texte</span>
                                                @endif
                                                @if($groupAssignment)
                                                    <span
                                                        class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-semibold">👥
                                                        Devoir groupe</span>
                                                @endif
                                                @if($peerReviewEnabled)
                                                    <span
                                                        class="px-3 py-1 bg-pink-100 text-pink-700 rounded-full text-xs font-semibold">🤝
                                                        Peer review</span>
                                                @endif
                                                @if($allowLateSubmission)
                                                    <span
                                                        class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">⏰
                                                        Soumission tardive</span>
                                                @endif
                                                @if($sendReminders)
                                                    <span
                                                        class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-semibold">🔔
                                                        Rappels auto</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Footer Navigation --}}
                        <div class="bg-gray-50 px-6 py-4 border-t-2 border-gray-200 flex items-center justify-between">
                            <div>
                                @if($step > 1)
                                    <button type="button" wire:click="previousStep"
                                        class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition-colors font-semibold flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 19l-7-7 7-7" />
                                        </svg>
                                        Précédent
                                    </button>
                                @endif
                            </div>

                            <div class="flex gap-3">
                                <button type="button" wire:click="$set('showAssignmentModal', false)"
                                    class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition-colors font-semibold">
                                    Annuler
                                </button>

                                @if($step < 4)
                                    <button type="button" wire:click="nextStep"
                                        class="px-6 py-3 bg-gradient-to-r from-emerald-600 via-teal-500 to-green-700 text-white rounded-xl hover:from-emerald-700 hover:to-green-700 transition-all font-semibold flex items-center gap-2 shadow-lg">
                                        Suivant
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                @else
                                    <button type="submit"
                                        class="px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all font-bold flex items-center gap-2 shadow-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        {{ $assignmentId ? 'Mettre à jour' : 'Créer le devoir' }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        {{-- Submissions Modal --}}
        @if($showSubmissionsModal && $selectedSubmission)
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
                <div class="bg-white rounded-2xl shadow-2xl max-w-6xl w-full max-h-[90vh] overflow-hidden">
                    <div class="bg-gradient-to-r from-green-600 to-emerald-600 text-white p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-2xl font-bold">📥 Soumissions du devoir</h3>
                                <p class="text-white/80 mt-1">{{ $selectedSubmission->title }}</p>
                            </div>
                            <button wire:click="$set('showSubmissionsModal', false)" class="text-white/80 hover:text-white">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="p-6 overflow-y-auto" style="max-height: calc(90vh - 100px);">
                        {{-- Stats Overview --}}
                        <div class="grid grid-cols-4 gap-4 mb-6">
                            <div class="bg-blue-50 rounded-xl p-4 border-2 border-blue-200">
                                <div class="text-3xl font-bold text-blue-600">
                                    {{ $selectedSubmission->submissions->count() }}
                                </div>
                                <div class="text-sm text-blue-700 font-medium mt-1">Soumissions</div>
                            </div>
                            <div class="bg-green-50 rounded-xl p-4 border-2 border-green-200">
                                <div class="text-3xl font-bold text-green-600">
                                    {{ $selectedSubmission->submissions->where('status', 'graded')->count() }}
                                </div>
                                <div class="text-sm text-green-700 font-medium mt-1">Corrigées</div>
                            </div>
                            <div class="bg-yellow-50 rounded-xl p-4 border-2 border-yellow-200">
                                <div class="text-3xl font-bold text-yellow-600">
                                    {{ $selectedSubmission->submissions->where('is_late', true)->count() }}
                                </div>
                                <div class="text-sm text-yellow-700 font-medium mt-1">En retard</div>
                            </div>
                            <div class="bg-purple-50 rounded-xl p-4 border-2 border-purple-200">
                                <div class="text-3xl font-bold text-purple-600">
                                    {{ number_format($selectedSubmission->submissions->avg('grade'), 1) }}
                                </div>
                                <div class="text-sm text-purple-700 font-medium mt-1">Moyenne</div>
                            </div>
                        </div>

                        {{-- Submissions List --}}
                        <div class="space-y-3">
                            @forelse($selectedSubmission->submissions as $submission)
                                <div
                                    class="bg-gray-50 rounded-xl p-4 border-2 border-gray-200 hover:border-indigo-400 transition-all">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-4 flex-1">
                                            <div
                                                class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold">
                                                {{ substr($submission->student->first_name, 0, 1) }}{{ substr($submission->student->last_name, 0, 1) }}
                                            </div>
                                            <div class="flex-1">
                                                <div class="font-bold text-gray-900">{{ $submission->student->first_name }}
                                                    {{ $submission->student->last_name }}
                                                </div>
                                                <div class="text-sm text-gray-600">
                                                    Soumis le {{ $submission->submitted_at->format('d/m/Y à H:i') }}
                                                    @if($submission->is_late)
                                                        <span
                                                            class="ml-2 text-xs bg-red-100 text-red-700 px-2 py-1 rounded-full font-semibold">En
                                                            retard</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-4">
                                            @if($submission->grade)
                                                <div class="text-center">
                                                    <div class="text-2xl font-bold text-{{ $submission->grade_color }}-600">
                                                        {{ $submission->grade }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">/{{ $selectedSubmission->max_points }}</div>
                                                </div>
                                            @else
                                                <div class="text-center">
                                                    <div class="text-sm text-gray-500">Non noté</div>
                                                </div>
                                            @endif

                                            <span
                                                class="px-3 py-1 bg-{{ $submission->status_color }}-100 text-{{ $submission->status_color }}-700 rounded-full text-xs font-bold">
                                                {{ ucfirst($submission->status) }}
                                            </span>

                                            <div class="flex gap-2">
                                                <button wire:click="openGradingModal({{ $submission->id }})"
                                                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-semibold text-sm">
                                                    {{ $submission->grade ? '✏️ Modifier' : '✍️ Noter' }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    @if($submission->submission_text || $submission->files)
                                        <div class="mt-3 pt-3 border-t border-gray-300">
                                            @if($submission->submission_text)
                                                <div class="mb-2">
                                                    <div class="text-xs font-semibold text-gray-600 mb-1">Texte soumis :</div>
                                                    <p class="text-sm text-gray-700 line-clamp-2">{{ $submission->submission_text }}</p>
                                                </div>
                                            @endif

                                            @if($submission->files)
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach($submission->files as $file)
                                                        <a href="{{ Storage::url($file) }}" target="_blank"
                                                            class="inline-flex items-center gap-2 px-3 py-1 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 text-sm">
                                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                            </svg>
                                                            Fichier {{ $loop->iteration }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="text-center py-12 text-gray-500">
                                    <div class="text-6xl mb-4">📭</div>
                                    <p class="text-lg font-semibold">Aucune soumission pour le moment</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Grading Modal --}}
        @if($showGradingModal && $selectedSubmission)
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
                <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-600 to-pink-600 text-white p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-2xl font-bold">✍️ Noter la soumission</h3>
                                <p class="text-white/80 mt-1">{{ $selectedSubmission->student->first_name }}
                                    {{ $selectedSubmission->student->last_name }}
                                </p>
                            </div>
                            <button wire:click="$set('showGradingModal', false)" class="text-white/80 hover:text-white">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <form wire:submit.prevent="saveGrade" class="p-6 space-y-6 overflow-y-auto"
                        style="max-height: calc(90vh - 180px);">
                        {{-- Submission Content --}}
                        <div class="p-4 bg-gray-50 rounded-xl border-2 border-gray-200">
                            <h4 class="font-bold text-gray-900 mb-3">📄 Contenu de la soumission</h4>

                            @if($selectedSubmission->submission_text)
                                <div class="mb-4">
                                    <div class="text-sm font-semibold text-gray-600 mb-2">Texte :</div>
                                    <div class="p-3 bg-white rounded-lg border border-gray-300">
                                        <p class="text-gray-700">{{ $selectedSubmission->submission_text }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($selectedSubmission->files)
                                <div>
                                    <div class="text-sm font-semibold text-gray-600 mb-2">Fichiers joints :</div>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($selectedSubmission->files as $file)
                                            <a href="{{ Storage::url($file) }}" target="_blank"
                                                class="inline-flex items-center gap-2 px-4 py-2 bg-white border-2 border-indigo-300 rounded-lg hover:bg-indigo-50 font-semibold text-indigo-700">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                Télécharger fichier {{ $loop->iteration }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Grade Input --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">💯 Note (sur
                                {{ $selectedSubmission->assignment->max_points }}) *</label>
                            <input type="number" wire:model="grade" step="0.5" min="0"
                                max="{{ $selectedSubmission->assignment->max_points }}"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent text-2xl font-bold text-center">
                            @error('grade') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                            @if($selectedSubmission->is_late && $selectedSubmission->assignment->allow_late_submission)
                                <p class="mt-2 text-sm text-orange-600 font-semibold">
                                    ⚠️ Soumission en retard - Pénalité de
                                    {{ $selectedSubmission->assignment->late_penalty_percent }}% appliquée automatiquement
                                </p>
                            @endif
                        </div>

                        {{-- Quick Grade Buttons --}}
                        <div class="grid grid-cols-5 gap-2">
                            @foreach([0, 5, 10, 15, 20] as $quickGrade)
                                <button type="button" wire:click="$set('grade', {{ $quickGrade }})"
                                    class="px-4 py-3 bg-gradient-to-br from-gray-100 to-gray-200 hover:from-indigo-100 hover:to-indigo-200 rounded-xl font-bold text-gray-700 hover:text-indigo-700 transition-all">
                                    {{ $quickGrade }}
                                </button>
                            @endforeach
                        </div>

                        {{-- Feedback --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">💬 Commentaire / Feedback</label>
                            <textarea wire:model="feedback" rows="6"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                placeholder="Donnez un retour constructif à l'élève..."></textarea>
                        </div>
                        {{-- Actions --}}
                        <div class="flex gap-3 pt-4 border-t-2 border-gray-200">
                            <button type="button" wire:click="$set('showGradingModal', false)"
                                class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition-colors font-semibold">
                                Annuler
                            </button>
                            <button type="submit"
                                class="flex-1 px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-xl hover:from-purple-700 hover:to-pink-700 transition-all font-bold shadow-lg">
                                💾 Enregistrer la note
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif


        {{-- Analytics Modal --}}
        @if($showAnalyticsModal && $selectedAssignmentAnalytics)
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
                <div class="bg-white rounded-2xl shadow-2xl max-w-6xl w-full max-h-[90vh] overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-cyan-600 text-white p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-2xl font-bold">📊 Analytiques détaillées</h3>
                                <p class="text-white/80 mt-1">{{ $selectedAssignmentAnalytics->title }}</p>
                            </div>
                            <button wire:click="$set('showAnalyticsModal', false)" class="text-white/80 hover:text-white">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="p-6 overflow-y-auto" style="max-height: calc(90vh - 100px);">
                        {{-- Key Metrics --}}
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border-2 border-blue-200">
                                <div class="text-sm text-blue-700 font-medium mb-1">Taux de soumission</div>
                                <div class="text-3xl font-bold text-blue-600">
                                    {{ number_format($selectedAssignmentAnalytics->submission_rate, 1) }}%
                                </div>
                                <div class="text-xs text-blue-600 mt-1">
                                    {{ $selectedAssignmentAnalytics->submission_count }}/{{ $selectedAssignmentAnalytics->class->students()->count() }}
                                    élèves
                                </div>
                            </div>

                            <div
                                class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border-2 border-green-200">
                                <div class="text-sm text-green-700 font-medium mb-1">Note moyenne</div>
                                <div class="text-3xl font-bold text-green-600">
                                    {{ number_format($selectedAssignmentAnalytics->average_grade, 2) }}
                                </div>
                                <div class="text-xs text-green-600 mt-1">sur {{ $selectedAssignmentAnalytics->max_points }}
                                </div>
                            </div>

                            <div
                                class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 border-2 border-purple-200">
                                <div class="text-sm text-purple-700 font-medium mb-1">Progression correction</div>
                                <div class="text-3xl font-bold text-purple-600">
                                    {{ number_format($selectedAssignmentAnalytics->grading_progress, 0) }}%
                                </div>
                                <div class="text-xs text-purple-600 mt-1">
                                    {{ $selectedAssignmentAnalytics->graded_count }}/{{ $selectedAssignmentAnalytics->submission_count }}
                                    notés
                                </div>
                            </div>

                            <div
                                class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-4 border-2 border-orange-200">
                                <div class="text-sm text-orange-700 font-medium mb-1">Soumissions tardives</div>
                                <div class="text-3xl font-bold text-orange-600">
                                    {{ $selectedAssignmentAnalytics->submissions->where('is_late', true)->count() }}
                                </div>
                                <div class="text-xs text-orange-600 mt-1">
                                    {{ number_format(($selectedAssignmentAnalytics->submissions->where('is_late', true)->count() / max($selectedAssignmentAnalytics->submission_count, 1)) * 100, 1) }}%
                                    du total
                                </div>
                            </div>
                        </div>

                        {{-- Grade Distribution Chart --}}
                        <div class="bg-white rounded-xl p-6 border-2 border-gray-200 mb-6">
                            <h4 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <span class="text-2xl">📈</span>
                                Distribution des notes
                            </h4>
                            <div class="space-y-3">
                                @php
                                    $gradeRanges = [
                                        ['min' => 18, 'max' => 20, 'label' => 'Excellent (18-20)', 'color' => 'green'],
                                        ['min' => 16, 'max' => 17.99, 'label' => 'Très bien (16-18)', 'color' => 'blue'],
                                        ['min' => 14, 'max' => 15.99, 'label' => 'Bien (14-16)', 'color' => 'indigo'],
                                        ['min' => 12, 'max' => 13.99, 'label' => 'Assez bien (12-14)', 'color' => 'yellow'],
                                        ['min' => 10, 'max' => 11.99, 'label' => 'Passable (10-12)', 'color' => 'orange'],
                                        ['min' => 0, 'max' => 9.99, 'label' => 'Insuffisant (0-10)', 'color' => 'red'],
                                    ];
                                    $totalGraded = $selectedAssignmentAnalytics->submissions->whereNotNull('grade')->count();
                                @endphp

                                @foreach($gradeRanges as $range)
                                    @php
                                        $count = $selectedAssignmentAnalytics->submissions->whereBetween('grade', [$range['min'], $range['max']])->count();
                                        $percentage = $totalGraded > 0 ? ($count / $totalGraded) * 100 : 0;
                                    @endphp
                                    <div>
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="text-sm font-semibold text-gray-700">{{ $range['label'] }}</span>
                                            <span class="text-sm font-bold text-{{ $range['color'] }}-600">{{ $count }} élèves
                                                ({{ number_format($percentage, 1) }}%)</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-3">
                                            <div class="bg-{{ $range['color'] }}-500 h-3 rounded-full transition-all"
                                                style="width: {{ $percentage }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Time Analysis --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="bg-white rounded-xl p-6 border-2 border-gray-200">
                                <h4 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                                    <span class="text-2xl">⏰</span>
                                    Analyse temporelle
                                </h4>
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                                        <span class="text-sm font-medium text-gray-700">Soumissions à l'heure</span>
                                        <span
                                            class="text-lg font-bold text-blue-600">{{ $selectedAssignmentAnalytics->submissions->where('is_late', false)->count() }}</span>
                                    </div>
                                    <div class="flex items-center justify-between p-3 bg-orange-50 rounded-lg">
                                        <span class="text-sm font-medium text-gray-700">Soumissions en retard</span>
                                        <span
                                            class="text-lg font-bold text-orange-600">{{ $selectedAssignmentAnalytics->submissions->where('is_late', true)->count() }}</span>
                                    </div>
                                    <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                                        <span class="text-sm font-medium text-gray-700">Non soumis</span>
                                        <span
                                            class="text-lg font-bold text-red-600">{{ $selectedAssignmentAnalytics->class->students()->count() - $selectedAssignmentAnalytics->submission_count }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-xl p-6 border-2 border-gray-200">
                                <h4 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                                    <span class="text-2xl">🎯</span>
                                    Statistiques de performance
                                </h4>
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                                        <span class="text-sm font-medium text-gray-700">Note maximale</span>
                                        <span
                                            class="text-lg font-bold text-green-600">{{ number_format($selectedAssignmentAnalytics->submissions->max('grade'), 2) }}</span>
                                    </div>
                                    <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                                        <span class="text-sm font-medium text-gray-700">Note minimale</span>
                                        <span
                                            class="text-lg font-bold text-yellow-600">{{ number_format($selectedAssignmentAnalytics->submissions->min('grade'), 2) }}</span>
                                    </div>
                                    <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg">
                                        <span class="text-sm font-medium text-gray-700">Médiane</span>
                                        <span
                                            class="text-lg font-bold text-purple-600">{{ number_format($selectedAssignmentAnalytics->submissions->median('grade'), 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Students Who Haven't Submitted --}}
                        @php
                            $submittedStudentIds = $selectedAssignmentAnalytics->submissions->pluck('student_id')->toArray();
                            $notSubmitted = $selectedAssignmentAnalytics->class->students()->whereNotIn('id', $submittedStudentIds)->get();
                        @endphp

                        @if($notSubmitted->count() > 0)
                            <div class="bg-red-50 rounded-xl p-6 border-2 border-red-200">
                                <h4 class="font-bold text-red-900 mb-4 flex items-center gap-2">
                                    <span class="text-2xl">⚠️</span>
                                    Élèves n'ayant pas soumis ({{ $notSubmitted->count() }})
                                </h4>
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                    @foreach($notSubmitted as $student)
                                        <div class="bg-white p-3 rounded-lg border border-red-200">
                                            <div class="flex items-center gap-2">
                                                <div
                                                    class="w-8 h-8 bg-red-200 rounded-full flex items-center justify-center text-red-700 font-semibold text-sm">
                                                    {{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="text-sm font-semibold text-gray-900 truncate">
                                                        {{ $student->first_name }} {{ $student->last_name }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-4">
                                    <button wire:click="sendReminder({{ $selectedAssignmentAnalytics->id }})"
                                        class="w-full px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-semibold flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                        </svg>
                                        Envoyer un rappel à ces élèves
                                    </button>
                                </div>
                            </div>
                        @endif

                        {{-- Export Options --}}
                        <div class="mt-6 flex gap-3">
                            <button wire:click="exportGrades({{ $selectedAssignmentAnalytics->id }})"
                                class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all font-bold shadow-lg flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Exporter les notes (Excel)
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>