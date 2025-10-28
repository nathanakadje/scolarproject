<div>
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                    </div>
                    <span>Mes Ressources Pédagogiques</span>
                </h1>
                <p class="mt-2 text-gray-600">Gérez et partagez vos documents, liens et ressources avec vos élèves</p>
            </div>

            <div class="flex gap-2">
                <button wire:click="$set('showCategoryModal', true)"
                    class="px-4 py-2 bg-white border-2 border-emerald-600 text-emerald-600 rounded-lg hover:bg-indigo-50 transition-all font-semibold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                    Gérer les catégories
                </button>
                <button wire:click="openResourceModal"
                    class="px-6 py-2 bg-gradient-to-r from-emerald-600 to-emerald-600 text-white rounded-lg hover:from-green-700 hover:to-emerald-700 transition-all font-semibold flex items-center gap-2 shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nouvelle Ressource
                </button>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Total Ressources</p>
                        <p class="text-3xl font-bold mt-2">{{ $this->stats['total_resources'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Vues Totales</p>
                        <p class="text-3xl font-bold mt-2">{{ number_format($this->stats['total_views']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Téléchargements</p>
                        <p class="text-3xl font-bold mt-2">{{ number_format($this->stats['total_downloads']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm font-medium">Catégories</p>
                        <p class="text-3xl font-bold mt-2">{{ $this->stats['total_categories'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filters and Search --}}
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                {{-- Search --}}
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rechercher</label>
                    <div class="relative">
                        <input type="text" wire:model.live.debounce.300ms="search"
                            placeholder="Titre, description, tags..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                {{-- Type Filter --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                    <select wire:model.live="filterType"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="all">Tous les types</option>
                        <option value="file">📁 Fichiers</option>
                        <option value="link">🔗 Liens</option>
                        <option value="video">🎬 Vidéos</option>
                        <option value="article">📰 Articles</option>
                    </select>
                </div>

                {{-- Category Filter --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
                    <select wire:model.live="filterCategory"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="all">Toutes les catégories</option>
                        @foreach($this->categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Sort --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Trier par</label>
                    <select wire:model.live="sortBy"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="recent">Plus récentes</option>
                        <option value="oldest">Plus anciennes</option>
                        <option value="popular">Plus consultées</option>
                        <option value="downloads">Plus téléchargées</option>
                        <option value="title">Par titre</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Categories Overview --}}
        @if($this->categories->count() > 0)
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                    Mes Catégories
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
                    @foreach($this->categories as $category)
                        <div wire:click="$set('filterCategory', '{{ $category->id }}')"
                            class="group cursor-pointer p-4 rounded-lg border-2 transition-all hover:shadow-md {{ $filterCategory == $category->id ? 'border-indigo-600 bg-indigo-50' : 'border-gray-200 hover:border-indigo-300' }}"
                            style="border-color: {{ $filterCategory == $category->id ? $category->color : '' }};">
                            <div class="flex items-center justify-between mb-2">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white font-bold"
                                    style="background: {{ $category->color }};">
                                    {{ substr($category->name, 0, 1) }}
                                </div>
                                <span class="text-xs font-semibold text-gray-500 bg-gray-100 px-2 py-1 rounded-full">
                                    {{ $category->resource_count }}
                                </span>
                            </div>
                            <h4 class="font-semibold text-gray-900 text-sm truncate">{{ $category->name }}</h4>
                            @if($category->subject)
                                <p class="text-xs text-gray-500 mt-1">{{ $category->subject->name }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Resources Grid --}}
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">
                    Ressources ({{ $this->resources->total() }})
                </h3>
            </div>

            @if($this->resources->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($this->resources as $resource)
                        <div
                            class="group relative bg-gradient-to-br from-gray-50 to-white rounded-xl border-2 border-gray-200 hover:border-indigo-400 hover:shadow-xl transition-all p-6">
                            {{-- Featured Badge --}}
                            @if($resource->is_featured)
                                <div class="absolute top-3 right-3">
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2 py-1 rounded-full">⭐
                                        Featured</span>
                                </div>
                            @endif

                            {{-- Type Icon --}}
                            <div class="flex items-start gap-4 mb-4">
                                <div
                                    class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center text-3xl shadow-lg">
                                    {{ $resource->type_icon }}
                                </div>
                                <div class="flex-1">
                                    <h4
                                        class="font-bold text-gray-900 text-lg line-clamp-2 group-hover:text-indigo-600 transition-colors">
                                        {{ $resource->title }}
                                    </h4>
                                    @if($resource->category)
                                        <span class="inline-block mt-1 text-xs font-semibold px-2 py-1 rounded-full"
                                            style="background: {{ $resource->category->color }}20; color: {{ $resource->category->color }};">
                                            {{ $resource->category->name }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Description --}}
                            @if($resource->description)
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $resource->description }}</p>
                            @endif

                            {{-- File Info --}}
                            @if($resource->type === 'file')
                                <div class="flex items-center gap-2 mb-4 text-sm text-gray-500">
                                    <span class="font-medium">{{ $resource->file_icon }}
                                        {{ strtoupper($resource->file_type) }}</span>
                                    <span>•</span>
                                    <span>{{ $resource->file_size_human }}</span>
                                </div>
                            @endif

                            {{-- Tags --}}
                            @if($resource->tags && count($resource->tags) > 0)
                                <div class="flex flex-wrap gap-1 mb-4">
                                    @foreach(array_slice($resource->tags, 0, 3) as $tag)
                                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">#{{ $tag }}</span>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Stats --}}
                            <div class="flex items-center gap-4 mb-4 text-sm text-gray-500">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <span>{{ $resource->view_count }}</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    <span>{{ $resource->download_count }}</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    <span>{{ $resource->classes->count() }} classes</span>
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="flex gap-2 pt-4 border-t border-gray-200">
                                <button wire:click="openResourceModal({{ $resource->id }})"
                                    class="flex-1 px-3 py-2 bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-200 transition-colors text-sm font-semibold">
                                    Modifier
                                </button>
                                <button wire:click="viewResourceStats({{ $resource->id }})"
                                    class="px-3 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </button>
                                <button wire:click="toggleFeatured({{ $resource->id }})"
                                    class="px-3 py-2 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                </button>
                                <button wire:click="duplicateResource({{ $resource->id }})"
                                    class="px-3 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </button>
                                <button wire:click="deleteResource({{ $resource->id }})"
                                    wire:confirm="Êtes-vous sûr de vouloir supprimer cette ressource ?"
                                    class="px-3 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $this->resources->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucune ressource trouvée</h3>
                    <p class="text-gray-600 mb-4">Commencez par créer votre première ressource pédagogique</p>
                    <button wire:click="openResourceModal"
                        class="px-6 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-all font-semibold">
                        Créer une ressource
                    </button>
                </div>
            @endif
        </div>
        {{-- Resource Modal --}}
        @if($showResourceModal)
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
                <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                    <div class="sticky top-0 bg-gradient-to-r from-purple-600 to-indigo-600 text-white p-6 rounded-t-2xl">
                        <div class="flex items-center justify-between">
                            <h3 class="text-2xl font-bold">
                                {{ $resourceId ? 'Modifier la ressource' : 'Nouvelle ressource' }}
                            </h3>
                            <button wire:click="$set('showResourceModal', false)" class="text-white/80 hover:text-white">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <form wire:submit.prevent="saveResource" class="p-6 space-y-6">
                        {{-- Title --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Titre de la ressource *</label>
                            <input type="text" wire:model="title"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                placeholder="Ex: Cours de Mathématiques - Les fonctions">
                            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Type Selection --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Type de ressource *</label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                <div wire:click="$set('type', 'file')"
                                    class="cursor-pointer p-4 border-2 rounded-xl transition-all {{ $type === 'file' ? 'border-purple-600 bg-purple-50' : 'border-gray-200 hover:border-purple-300' }}">
                                    <div class="text-center">
                                        <div class="text-3xl mb-2">📁</div>
                                        <div class="font-semibold text-sm">Fichier</div>
                                    </div>
                                </div>
                                <div wire:click="$set('type', 'link')"
                                    class="cursor-pointer p-4 border-2 rounded-xl transition-all {{ $type === 'link' ? 'border-purple-600 bg-purple-50' : 'border-gray-200 hover:border-purple-300' }}">
                                    <div class="text-center">
                                        <div class="text-3xl mb-2">🔗</div>
                                        <div class="font-semibold text-sm">Lien Web</div>
                                    </div>
                                </div>
                                <div wire:click="$set('type', 'video')"
                                    class="cursor-pointer p-4 border-2 rounded-xl transition-all {{ $type === 'video' ? 'border-purple-600 bg-purple-50' : 'border-gray-200 hover:border-purple-300' }}">
                                    <div class="text-center">
                                        <div class="text-3xl mb-2">🎬</div>
                                        <div class="font-semibold text-sm">Vidéo</div>
                                    </div>
                                </div>
                                <div wire:click="$set('type', 'article')"
                                    class="cursor-pointer p-4 border-2 rounded-xl transition-all {{ $type === 'article' ? 'border-purple-600 bg-purple-50' : 'border-gray-200 hover:border-purple-300' }}">
                                    <div class="text-center">
                                        <div class="text-3xl mb-2">📰</div>
                                        <div class="font-semibold text-sm">Article</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- File Upload --}}
                        @if($type === 'file')
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Télécharger un fichier *</label>
                                <div
                                    class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-purple-400 transition-colors">
                                    <input type="file" wire:model="file" class="hidden" id="fileInput">
                                    <label for="fileInput" class="cursor-pointer">
                                        <div class="text-5xl mb-3">📤</div>
                                        <p class="text-gray-600 mb-2">Cliquez pour sélectionner un fichier</p>
                                        <p class="text-sm text-gray-500">PDF, Word, Excel, PowerPoint, Images (Max 50MB)</p>
                                    </label>
                                    @if($file)
                                        <div class="mt-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                                            <p class="text-green-700 font-semibold">✓ {{ $file->getClientOriginalName() }}</p>
                                            <p class="text-sm text-green-600">{{ number_format($file->getSize() / 1024 / 1024, 2) }}
                                                MB</p>
                                        </div>
                                    @endif
                                </div>
                                @error('file') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        @else
                            {{-- URL Input --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">URL de la ressource *</label>
                                <input type="url" wire:model="url"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                    placeholder="https://example.com/resource">
                                @error('url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            {{-- Link Type --}}
                            @if($type !== 'file')
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Type de lien</label>
                                    <select wire:model="linkType"
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                        <option value="website">Site Web</option>
                                        <option value="youtube">YouTube</option>
                                        <option value="mooc">MOOC (Coursera, edX, etc.)</option>
                                        <option value="article">Article scientifique</option>
                                    </select>
                                </div>
                            @endif
                        @endif

                        {{-- Description --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                            <textarea wire:model="description" rows="4"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                placeholder="Décrivez brièvement cette ressource..."></textarea>
                            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Subject & Category --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Matière</label>
                                <select wire:model="selectedSubjectId"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    <option value="">Sélectionner une matière</option>
                                    @foreach($this->subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Catégorie</label>
                                <select wire:model="selectedCategoryId"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    <option value="">Sélectionner une catégorie</option>
                                    @foreach($this->categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Tags --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tags (séparés par des
                                virgules)</label>
                            <input type="text" wire:model="tags"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                placeholder="Ex: algèbre, équations, fonctions">
                            <p class="text-sm text-gray-500 mt-1">Utilisez des tags pour faciliter la recherche</p>
                        </div>

                        {{-- Access Level --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Niveau d'accès *</label>
                            <div class="grid grid-cols-2 gap-4">
                                <div wire:click="$set('accessLevel', 'public')"
                                    class="cursor-pointer p-4 border-2 rounded-xl transition-all {{ $accessLevel === 'public' ? 'border-green-600 bg-green-50' : 'border-gray-200 hover:border-green-300' }}">
                                    <div class="flex items-center gap-3">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <div>
                                            <div class="font-semibold">Public</div>
                                            <div class="text-sm text-gray-600">Accessible à tous</div>
                                        </div>
                                    </div>
                                </div>

                                <div wire:click="$set('accessLevel', 'restricted')"
                                    class="cursor-pointer p-4 border-2 rounded-xl transition-all {{ $accessLevel === 'restricted' ? 'border-orange-600 bg-orange-50' : 'border-gray-200 hover:border-orange-300' }}">
                                    <div class="flex items-center gap-3">
                                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        <div>
                                            <div class="font-semibold">Restreint</div>
                                            <div class="text-sm text-gray-600">Classes spécifiques</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Class Selection --}}
                        @if($accessLevel === 'restricted')
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Sélectionner les classes *</label>
                                <div
                                    class="grid grid-cols-2 md:grid-cols-3 gap-3 max-h-48 overflow-y-auto p-3 border-2 border-gray-200 rounded-lg">
                                    @foreach($this->classes as $class)
                                        <label
                                            class="flex items-center gap-2 p-3 rounded-lg border-2 cursor-pointer transition-all {{ in_array($class->id, $selectedClasses) ? 'border-purple-600 bg-purple-50' : 'border-gray-200 hover:border-purple-300' }}">
                                            <input type="checkbox" wire:model="selectedClasses" value="{{ $class->id }}"
                                                class="w-4 h-4 text-purple-600 rounded focus:ring-purple-500">
                                            <span class="text-sm font-medium">{{ $class->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('selectedClasses') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        @endif

                        {{-- Options --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <label
                                class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-purple-300 transition-all">
                                <input type="checkbox" wire:model="allowDownload"
                                    class="w-5 h-5 text-purple-600 rounded focus:ring-purple-500">
                                <div>
                                    <div class="font-semibold text-sm">Autoriser le téléchargement</div>
                                    <div class="text-xs text-gray-500">Les élèves peuvent télécharger</div>
                                </div>
                            </label>

                            <label
                                class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-purple-300 transition-all">
                                <input type="checkbox" wire:model="isFeatured"
                                    class="w-5 h-5 text-purple-600 rounded focus:ring-purple-500">
                                <div>
                                    <div class="font-semibold text-sm">⭐ Mettre en avant</div>
                                    <div class="text-xs text-gray-500">Ressource importante</div>
                                </div>
                            </label>

                            <label
                                class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-purple-300 transition-all">
                                <input type="checkbox" wire:model="publishNow"
                                    class="w-5 h-5 text-purple-600 rounded focus:ring-purple-500">
                                <div>
                                    <div class="font-semibold text-sm">📢 Publier maintenant</div>
                                    <div class="text-xs text-gray-500">Notifier les élèves</div>
                                </div>
                            </label>
                        </div>

                        {{-- Actions --}}
                        <div class="flex gap-3 pt-4 border-t-2 border-gray-200">
                            <button type="button" wire:click="$set('showResourceModal', false)"
                                class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-semibold">
                                Annuler
                            </button>
                            <button type="submit"
                                class="flex-1 px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-all font-semibold shadow-lg">
                                {{ $resourceId ? 'Mettre à jour' : 'Créer la ressource' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif


        {{-- Category Modal --}}
        @if($showCategoryModal)
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
                <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white p-6 rounded-t-2xl">
                        <div class="flex items-center justify-between">
                            <h3 class="text-2xl font-bold">Gérer les catégories</h3>
                            <button wire:click="$set('showCategoryModal', false)" class="text-white/80 hover:text-white">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="p-6">
                        {{-- Category Form --}}
                        <form wire:submit.prevent="saveCategory"
                            class="space-y-4 mb-6 p-4 bg-gray-50 rounded-xl border-2 border-gray-200">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nom de la catégorie *</label>
                                <input type="text" wire:model="categoryName"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                    placeholder="Ex: Maths 1ère">
                                @error('categoryName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                                <textarea wire:model="categoryDescription" rows="2"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                    placeholder="Description de la catégorie"></textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Matière associée</label>
                                    <select wire:model="categorySubjectId"
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                        <option value="">Aucune matière</option>
                                        @foreach($this->subjects as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Couleur *</label>
                                    <input type="color" wire:model="categoryColor"
                                        class="w-full h-12 px-2 py-1 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent cursor-pointer">
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all font-semibold shadow-lg">
                                {{ $categoryId ? 'Mettre à jour' : 'Créer la catégorie' }}
                            </button>
                        </form>

                        {{-- Existing Categories --}}
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-3">Catégories existantes</h4>
                            <div class="space-y-2 max-h-64 overflow-y-auto">
                                @forelse($this->categories as $category)
                                    <div
                                        class="flex items-center justify-between p-4 border-2 border-gray-200 rounded-lg hover:border-indigo-300 transition-all">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white font-bold"
                                                style="background: {{ $category->color }};">
                                                {{ substr($category->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-900">{{ $category->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $category->resource_count }} ressource(s)
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex gap-2">
                                            <button wire:click="openCategoryModal({{ $category->id }})"
                                                class="px-3 py-2 bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-200 transition-colors text-sm font-semibold">
                                                Modifier
                                            </button>
                                            <button wire:click="deleteCategory({{ $category->id }})"
                                                wire:confirm="Supprimer cette catégorie ?"
                                                class="px-3 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors text-sm font-semibold">
                                                Supprimer
                                            </button>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center text-gray-500 py-4">Aucune catégorie créée</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Stats Modal --}}
        @if($showStatsModal && $selectedResourceStats)
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
                <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                    <div class="bg-gradient-to-r from-green-600 to-teal-600 text-white p-6 rounded-t-2xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-2xl font-bold">📊 Statistiques détaillées</h3>
                                <p class="text-green-100 mt-1">{{ $selectedResourceStats->title }}</p>
                            </div>
                            <button wire:click="$set('showStatsModal', false)" class="text-white/80 hover:text-white">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="p-6 space-y-6">
                        {{-- Summary Stats --}}
                        <div class="grid grid-cols-3 gap-4">
                            <div class="bg-blue-50 rounded-xl p-4 border-2 border-blue-200">
                                <div class="text-3xl font-bold text-blue-600">{{ $selectedResourceStats->view_count }}</div>
                                <div class="text-sm text-blue-700 font-medium mt-1">Vues totales</div>
                            </div>
                            <div class="bg-purple-50 rounded-xl p-4 border-2 border-purple-200">
                                <div class="text-3xl font-bold text-purple-600">{{ $selectedResourceStats->download_count }}
                                </div>
                                <div class="text-sm text-purple-700 font-medium mt-1">Téléchargements</div>
                            </div>
                            <div class="bg-green-50 rounded-xl p-4 border-2 border-green-200">
                                <div class="text-3xl font-bold text-green-600">
                                    {{ $selectedResourceStats->views->unique('student_id')->count() }}</div>
                                <div class="text-sm text-green-700 font-medium mt-1">Élèves uniques</div>
                            </div>
                        </div>

                        {{-- Recent Views --}}
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Vues récentes (10 dernières)
                            </h4>
                            <div class="space-y-2 max-h-64 overflow-y-auto">
                                @forelse($selectedResourceStats->views->take(10) as $view)
                                    <div
                                        class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-semibold">
                                                {{ $view->student ? substr($view->student->first_name, 0, 1) . substr($view->student->last_name, 0, 1) : '?' }}
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900">
                                                    {{ $view->student ? $view->student->first_name . ' ' . $view->student->last_name : 'Anonyme' }}
                                                </div>
                                                <div class="text-sm text-gray-500">{{ $view->viewed_at->diffForHumans() }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center text-gray-500 py-4">Aucune vue enregistrée</p>
                                @endforelse
                            </div>
                        </div>

                        {{-- Recent Downloads --}}
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Téléchargements récents (10 derniers)
                            </h4>
                            <div class="space-y-2 max-h-64 overflow-y-auto">
                                @forelse($selectedResourceStats->downloads->take(10) as $download)
                                    <div
                                        class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 font-semibold">
                                                {{ $download->student ? substr($download->student->first_name, 0, 1) . substr($download->student->last_name, 0, 1) : '?' }}
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900">
                                                    {{ $download->student ? $download->student->first_name . ' ' . $download->student->last_name : 'Anonyme' }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $download->downloaded_at->diffForHumans() }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                <p class="text-center text-gray-500 py-4">Aucun téléchargement enregistré</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>