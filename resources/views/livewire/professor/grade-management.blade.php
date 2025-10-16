<div>
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Gestion des Notes</h1>
        <p class="text-gray-600 mt-2">Créez des évaluations et saisissez les notes de vos élèves</p>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-12 gap-6">
        <!-- Left Sidebar - Classes -->
        <div class="col-span-12 lg:col-span-3">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
                <div class="p-4 border-b border-gray-200 bg-gradient-to-r from-emerald-500 to-teal-600">
                    <h2 class="text-lg font-semibold text-white">Mes Classes</h2>
                </div>
                <div class="p-4 space-y-2 max-h-96 overflow-y-auto">
                    @foreach($this->classes as $class)
                        <button wire:click="selectClass({{ $class->id }})"
                            class="w-full text-left p-3 rounded-lg border-2 transition-all
                                                                                                                                                                                                                                                                                    {{ $selectedClassId == $class->id ? 'border-emerald-500 bg-emerald-50' : 'border-gray-200 hover:border-emerald-200' }}">
                            <div class="font-semibold text-gray-900">{{ $class->full_name }}</div>
                            <div class="text-sm text-gray-600">{{ $class->active_students_count }} élèves</div>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Subjects -->
            @if($selectedClassId && $this->subjects->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="p-4 border-b border-gray-200">
                        <h3 class="font-semibold text-gray-900">Matières</h3>
                    </div>
                    <div class="p-4 space-y-2">
                        @foreach($this->subjects as $subject)
                            <button wire:click="selectSubject({{ $subject->id }})"
                                class="w-full text-left p-3 rounded-lg border-2 transition-all
                                                                                                                                                                                                                                                                                                         {{ $selectedSubjectId == $subject->id ? 'border-emerald-500 bg-emerald-50' : 'border-gray-200 hover:border-emerald-200' }}">
                                <div class="font-semibold text-gray-900">{{ $subject->name }}</div>
                                <div class="text-xs text-gray-600">Coef. {{ $subject->coefficient }}</div>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Main Content -->
        <div class="col-span-12 lg:col-span-9">
            @if($selectedClassId && $selectedSubjectId)
                <!-- Evaluations List -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900">Évaluations</h2>
                                <p class="text-sm text-gray-600 mt-1">{{ $this->evaluations->count() }} évaluation(s)</p>
                            </div>
                            <button wire:click="openEvaluationModal"
                                class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors font-medium flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span>Nouvelle Évaluation</span>
                            </button>
                        </div>
                    </div>

                    <div class="p-6">
                        @if($this->evaluations->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($this->evaluations as $evaluation)
                                    <div wire:click="selectEvaluation({{ $evaluation->id }})"
                                        class="p-4 border-2 rounded-lg cursor-pointer transition-all hover:shadow-md
                                                                                                                                                                                                                                                                                     {{ $selectedEvaluationId == $evaluation->id ? 'border-emerald-500 bg-emerald-50' : 'border-gray-200 hover:border-emerald-200' }}">
                                        <div class="flex items-start justify-between mb-2">
                                            <div class="flex-1">
                                                <h3 class="font-semibold text-gray-900">{{ $evaluation->title }}</h3>
                                                <p class="text-sm text-gray-600 mt-1">
                                                    {{ \Carbon\Carbon::parse($evaluation->date)->format('d/m/Y') ?? '-'}}
                                                </p>
                                            </div>
                                            <span
                                                class="px-2 py-1 rounded text-xs font-medium
                                                                                                                                                                                                 {{ $evaluation->type == 'examen' ? 'bg-red-100 text-red-800' : ($evaluation->type == 'composition' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                                {{ ucfirst($evaluation->type) }}
                                            </span>
                                        </div>
                                        <div class="flex items-center justify-between text-sm">
                                            <span
                                                class="text-gray-600">{{ $evaluation->getGradedCount() }}/{{ $evaluation->getTotalStudents() }}
                                                notés</span>
                                            <span class="font-medium text-gray-900">Coef. {{ $evaluation->coefficient }}</span>
                                        </div>
                                        @if($evaluation->is_published)
                                            <div class="mt-2 inline-flex items-center text-xs text-green-600">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                Publiée
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12 text-gray-500">
                                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                                <p class="mb-4">Aucune évaluation créée</p>
                                <button wire:click="openEvaluationModal"
                                    class="text-emerald-600 hover:text-emerald-800 font-medium">
                                    Créer votre première évaluation →
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Grades Entry -->
                @if($this->selectedEvaluation)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                        <!-- Stats -->
                        <div class="p-6 bg-gradient-to-r from-emerald-500 to-teal-600 text-white">
                            <h3 class="text-xl font-bold mb-4">{{ $selectedEvaluation->title }}</h3>
                            <div class="grid grid-cols-5 gap-4">
                                <div class="text-center">
                                    <div class="text-2xl font-bold">{{ $stats['total_students'] }}</div>
                                    <div class="text-sm text-emerald-100">Élèves</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold">{{ $stats['graded'] }}</div>
                                    <div class="text-sm text-emerald-100">Notés</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold">{{ $stats['average'] }}</div>
                                    <div class="text-sm text-emerald-100">Moyenne</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold">{{ $stats['min'] }}</div>
                                    <div class="text-sm text-emerald-100">Minimum</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold">{{ $stats['max'] }}</div>
                                    <div class="text-sm text-emerald-100">Maximum</div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="p-4 border-b border-gray-200 bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-600">
                                    Note sur {{ $selectedEvaluation->max_score }} • Coefficient
                                    {{ $selectedEvaluation->coefficient }}
                                </div>
                                <div class="flex space-x-2">
                                    @if(!$selectedEvaluation->is_published)
                                        <button wire:click="publishEvaluation"
                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                                            📢 Publier
                                        </button>
                                    @endif
                                    <button wire:click="saveAllGrades"
                                        class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors text-sm font-medium">
                                        💾 Tout enregistrer
                                    </button>
                                    <button wire:click="deleteEvaluation({{ $selectedEvaluation->id }})"
                                        wire:confirm="Êtes-vous sûr de vouloir supprimer cette évaluation ?"
                                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm font-medium">
                                        🗑️ Supprimer
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Grades Table -->
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 border-b border-gray-200">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">N°</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom Complet
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase w-32">Note
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Commentaire
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($this->students as $student)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 text-sm font-mono text-gray-600">
                                                {{ $student->student_number }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="font-semibold text-gray-900">{{ $student->full_name }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <input type="number" step="0.25" min="0" max="{{ $selectedEvaluation->max_score }}"
                                                    wire:model="grades.{{ $student->id }}.score" placeholder="0"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                                            </td>
                                            <td class="px-6 py-4">
                                                <input type="text" wire:model="grades.{{ $student->id }}.feedback"
                                                    placeholder="Commentaire..."
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                                            </td>
                                            <td class="px-6 py-4">
                                                <button wire:click="saveGrade({{ $student->id }})"
                                                    class="px-3 py-1 bg-emerald-600 text-white rounded hover:bg-emerald-700 transition-colors text-sm">
                                                    💾 Sauver
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

            @else
                <!-- No Selection -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                    <svg class="w-20 h-20 mx-auto mb-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Sélectionnez une classe et une matière</h3>
                    <p class="text-gray-600">Choisissez une classe et une matière pour commencer la saisie des notes</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Create Evaluation Modal -->
    @if($showEvaluationModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
            wire:click="closeEvaluationModal">
            <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full" wire:click.stop>
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-gray-900">Nouvelle Évaluation</h3>
                        <button wire:click="closeEvaluationModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <form wire:submit.prevent="save" class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Titre *</label>
                        <input type="text" wire:model="evaluationTitle"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-500"
                            placeholder="Ex: Devoir 1, Examen final...">
                        @error('evaluationTitle') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea wire:model="evaluationDescription" rows="3"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-500"
                            placeholder="Description optionnelle..."></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Type *</label>
                            <select wire:model="evaluationType"
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-500">
                                <option value="">Sélectionnez un type</option>
                                <option value="quiz">Quiz</option>
                                <option value="test">Test</option>
                                <option value="exam">Examen</option>
                                <option value="assignment">Devoir</option>
                            </select>
                            @error('evaluationType') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date *</label>
                            <input type="date" wire:model="evaluationDate"
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-500">
                            @error('evaluationDate') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Note max *</label>
                            <input type="number" wire:model="maxScore" min="10" max="50"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                            @error('maxScore') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                            <select wire:model="evaluationStatus"
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-500">
                                <option value="">Sélectionnez un type</option>
                                <option value="draft">draft</option>
                                <option value="published">Test</option>
                                <option value="completed">Examen</option>
                            </select>
                            @error('evaluationStatus') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                    </div>
                    <input type="hidden" wire:model="classId">
                    <input type="hidden" wire:model="subjectId">
                    <input type="hidden" wire:model="teacherId">
                    <input type="hidden" wire:model="academicYearId">

                    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                        <button type="button" wire:click="closeEvaluationModal"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            Annuler
                        </button>
                        <button type="submit"
                            class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors font-medium">
                            Créer l'évaluation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>