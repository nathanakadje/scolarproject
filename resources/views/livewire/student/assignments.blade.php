<div>
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">📝 Mes Devoirs</h1>
        <p class="text-gray-600">Consultez et soumettez vos devoirs</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">À faire</p>
                    <p class="text-3xl font-bold text-orange-600 mt-1">{{ $stats['pending'] }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Soumis</p>
                    <p class="text-3xl font-bold text-blue-600 mt-1">{{ $stats['submitted'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Notés</p>
                    <p class="text-3xl font-bold text-emerald-600 mt-1">{{ $stats['graded'] }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">En retard</p>
                    <p class="text-3xl font-bold text-red-600 mt-1">{{ $stats['late'] }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-2">
                <button wire:click="$set('filterStatus', 'all')"
                    class="px-4 py-2 text-sm rounded-lg transition-colors {{ $filterStatus === 'all' ? 'bg-emerald-100 text-emerald-700 font-semibold' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Tous
                </button>
                <button wire:click="$set('filterStatus', 'pending')"
                    class="px-4 py-2 text-sm rounded-lg transition-colors {{ $filterStatus === 'pending' ? 'bg-orange-100 text-orange-700 font-semibold' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    À faire ({{ $stats['pending'] }})
                </button>
                <button wire:click="$set('filterStatus', 'submitted')"
                    class="px-4 py-2 text-sm rounded-lg transition-colors {{ $filterStatus === 'submitted' ? 'bg-blue-100 text-blue-700 font-semibold' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Soumis ({{ $stats['submitted'] }})
                </button>
                <button wire:click="$set('filterStatus', 'graded')"
                    class="px-4 py-2 text-sm rounded-lg transition-colors {{ $filterStatus === 'graded' ? 'bg-emerald-100 text-emerald-700 font-semibold' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Notés ({{ $stats['graded'] }})
                </button>
                <button wire:click="$set('filterStatus', 'late')"
                    class="px-4 py-2 text-sm rounded-lg transition-colors {{ $filterStatus === 'late' ? 'bg-red-100 text-red-700 font-semibold' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    En retard ({{ $stats['late'] }})
                </button>
            </div>

            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Rechercher un devoir..."
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
        </div>
    </div>

    <!-- Assignments List -->
    <div class="space-y-4">
        @forelse($assignments as $assignment)
            @php
                $submission = $assignment->submissions->first();
                $isOverdue = $assignment->due_date < now();
                $isSubmitted = $submission && $submission->submitted_at;
                $isGraded = $submission && $submission->score !== null;
                $daysUntilDue = now()->diffInDays($assignment->due_date, false);
            @endphp

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-3 mb-3">
                            <h3 class="text-xl font-semibold text-gray-900">{{ $assignment->title }}</h3>

                            <!-- Status Badge -->
                            @if($isGraded)
                                <span class="px-3 py-1 text-xs font-semibold bg-emerald-100 text-emerald-700 rounded-full">
                                    ✓ Noté
                                </span>
                            @elseif($isSubmitted)
                                <span class="px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-700 rounded-full">
                                    ✓ Soumis
                                </span>
                            @elseif($isOverdue)
                                <span class="px-3 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded-full">
                                    ⚠ En retard
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold bg-orange-100 text-orange-700 rounded-full">
                                    ⏰ À faire
                                </span>
                            @endif

                            <!-- Subject Badge -->
                            <span class="px-3 py-1 text-xs font-semibold rounded-full"
                                style="background-color: {{ $assignment->subject->color }}20; color: {{ $assignment->subject->color }}">
                                {{ $assignment->subject->name }}
                            </span>
                        </div>

                        <p class="text-gray-600 mb-4">{{ $assignment->description }}</p>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                            <div class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span class="{{ $isOverdue && !$isSubmitted ? 'text-red-600 font-semibold' : '' }}">
                                    À rendre: {{ $assignment->due_date->format('d/m/Y H:i') }}
                                </span>
                            </div>

                            <div class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Note max: {{ $assignment->max_score }}/20
                            </div>

                            @if(!$isOverdue && !$isSubmitted)
                                <div
                                    class="flex items-center {{ $daysUntilDue <= 2 ? 'text-red-600 font-semibold' : 'text-gray-600' }}">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    @if($daysUntilDue == 0)
                                        Aujourd'hui !
                                    @elseif($daysUntilDue == 1)
                                        Demain
                                    @else
                                        Dans {{ $daysUntilDue }} jours
                                    @endif
                                </div>
                            @endif

                            @if($isGraded)
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 {{ $submission->final_score >= $assignment->max_score * 0.5 ? 'text-green-600' : 'text-red-600' }}"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span
                                        class="font-bold text-lg {{ $submission->final_score >= $assignment->max_score * 0.5 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ number_format($submission->final_score, 2) }}/{{ $assignment->max_score }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Feedback if graded -->
                        @if($isGraded && $submission->teacher_feedback)
                            <div class="mt-4 p-3 bg-blue-50 border-l-4 border-blue-500 rounded">
                                <p class="text-sm font-semibold text-gray-900 mb-1">💬 Commentaire du professeur :</p>
                                <p class="text-sm text-gray-700">{{ $submission->teacher_feedback }}</p>
                            </div>
                        @endif

                        <!-- Revision needed -->
                        @if($isGraded && $submission->needs_revision)
                            <div class="mt-4 p-3 bg-yellow-50 border-l-4 border-yellow-500 rounded">
                                <p class="text-sm font-semibold text-gray-900 mb-1">⚠️ Révision demandée :</p>
                                <p class="text-sm text-gray-700">{{ $submission->revision_notes }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Action Button -->
                    <div class="ml-6">
                        @if(!$isSubmitted)
                            <button wire:click="openSubmissionModal({{ $assignment->id }})"
                                class="px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors font-medium">
                                Soumettre
                            </button>
                        @else
                            <button wire:click="openSubmissionModal({{ $assignment->id }})"
                                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                Voir détails
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucun devoir trouvé</h3>
                <p class="text-gray-600">Vous êtes à jour ! 🎉</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->

    <!-- Submission Modal -->
    @if($showSubmissionModal && $selectedAssignment)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
            wire:click="closeSubmissionModal">
            <div class="bg-white rounded-xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto" wire:click.stop>
                <!-- Header -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-gray-900">{{ $selectedAssignment->title }}</h3>
                        <button wire:click="closeSubmissionModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6">
                    <!-- Assignment Details -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <p class="text-gray-700 mb-3">{{ $selectedAssignment->description }}</p>
                        @if($selectedAssignment->instructions)
                            <div class="mt-3 pt-3 border-t border-gray-200">
                                <p class="text-sm font-semibold text-gray-900 mb-2">📋 Instructions :</p>
                                <p class="text-sm text-gray-700 whitespace-pre-line">{{ $selectedAssignment->instructions }}</p>
                            </div>
                        @endif
                    </div>

                    @php
                        $submission = $selectedAssignment->submissions->first();
                        $isSubmitted = $submission && $submission->submitted_at;
                    @endphp

                    @if($isSubmitted)
                        <!-- Already Submitted -->
                        <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <p class="text-sm font-semibold text-blue-900 mb-2">✓ Devoir soumis le
                                {{ $submission->submitted_at->format('d/m/Y à H:i') }}
                            </p>

                            @if($submission->content)
                                <div class="mt-3">
                                    <p class="text-sm font-semibold text-gray-900 mb-1">Votre réponse :</p>
                                    <p class="text-sm text-gray-700 whitespace-pre-line">{{ $submission->content }}</p>
                                </div>
                            @endif

                            @if($submission->attachments && count($submission->attachments) > 0)
                                <div class="mt-3">
                                    <p class="text-sm font-semibold text-gray-900 mb-2">Fichiers joints :</p>
                                    <div class="space-y-2">
                                        @foreach($submission->attachments as $file)
                                            <a href="{{ Storage::url($file['path']) }}" target="_blank"
                                                class="flex items-center p-2 bg-white rounded hover:bg-gray-50">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                                <span class="text-sm text-gray-700">{{ $file['name'] }}</span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if($submission->score !== null)
                                <div class="mt-4 p-3 bg-white rounded-lg">
                                    <p class="text-sm font-semibold text-gray-900 mb-2">🎯 Note :</p>
                                    <p
                                        class="text-2xl font-bold {{ $submission->final_score >= $selectedAssignment->max_score * 0.5 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ number_format($submission->final_score, 2) }}/{{ $selectedAssignment->max_score }}
                                    </p>
                                    @if($submission->teacher_feedback)
                                        <p class="text-sm text-gray-700 mt-2">{{ $submission->teacher_feedback }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @else
                        <!-- Submission Form -->
                        <form wire:submit.prevent="submitAssignment">
                            <div class="space-y-4">
                                <!-- Text Content -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Votre réponse</label>
                                    <textarea wire:model="submissionContent" rows="6"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500"
                                        placeholder="Écrivez votre réponse ici..."></textarea>
                                    @error('submissionContent') <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- File Upload -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Fichiers joints
                                        (optionnel)</label>
                                    <input type="file" wire:model="submissionFiles" multiple
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                                    <p class="text-xs text-gray-500 mt-1">Max 10 MB par fichier</p>
                                    @error('submissionFiles.*') <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror

                                    <div wire:loading wire:target="submissionFiles" class="text-sm text-emerald-600 mt-2">
                                        Téléchargement en cours...
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-200">
                                <button type="button" wire:click="closeSubmissionModal"
                                    class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                                    Annuler
                                </button>
                                <button type="submit"
                                    class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 font-medium">
                                    Soumettre le devoir
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>