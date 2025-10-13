<div>
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Gestion des Classes</h1>
        <p class="text-gray-600 mt-2">Sélectionnez une classe pour gérer vos élèves et prendre les présences</p>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-12 gap-6">
        <!-- Left Sidebar - Classes List -->
        <div class="col-span-12 lg:col-span-3">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-4 border-b border-gray-200 bg-gradient-to-r from-emerald-500 to-teal-600">
                    <h2 class="text-lg font-semibold text-white">Mes Classes</h2>
                    <p class="text-emerald-100 text-sm">{{ $this->classes->count() }} classe(s)</p>
                </div>

                <div class="p-4 space-y-2 max-h-[calc(100vh-300px)] overflow-y-auto">
                    @forelse($this->classes as $class)
                        <button wire:click="selectClass({{ $class->id }})"
                            class="w-full text-left p-4 rounded-lg border-2 transition-all hover:shadow-md
                                                                                    {{ $selectedClassId == $class->id ? 'border-emerald-500 bg-emerald-50' : 'border-gray-200 hover:border-emerald-200' }}">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ $class->full_name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $class->code }}</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        <span class="inline-flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                                </path>
                                            </svg>
                                            {{ $class->active_students_count }} élèves
                                        </span>
                                    </p>
                                </div>
                                @if($selectedClassId == $class->id)
                                    <svg class="w-6 h-6 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                @endif
                            </div>
                        </button>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                            <p>Aucune classe assignée</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-span-12 lg:col-span-9">
            @if($this->selectedClass)
                <!-- Class Header with Stats -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
                    <div class="p-6 bg-gradient-to-r from-emerald-500 to-teal-600 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-2xl font-bold">{{  $this->selectedClass->name }}</h2>
                                <p class="text-emerald-100 mt-1">{{  $this->selectedClass->room ?? 'Salle non définie' }} •
                                    Année
                                    {{ $this->selectedClass->academicYear->name ?? 'Non définie' }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-emerald-100 text-sm">Effectif</p>
                                <p class="text-3xl font-bold">{{ $stats['active'] }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-4 gap-4 p-6">
                        <div class="text-center p-4 bg-green-50 rounded-lg">
                            <div class="text-3xl font-bold text-green-600">{{ $stats['present_today'] }}</div>
                            <div class="text-sm text-gray-600 mt-1">Présents</div>
                        </div>
                        <div class="text-center p-4 bg-red-50 rounded-lg">
                            <div class="text-3xl font-bold text-red-600">{{ $stats['absent_today'] }}</div>
                            <div class="text-sm text-gray-600 mt-1">Absents</div>
                        </div>
                        <div class="text-center p-4 bg-yellow-50 rounded-lg">
                            <div class="text-3xl font-bold text-yellow-600">{{ $stats['late_today'] }}</div>
                            <div class="text-sm text-gray-600 mt-1">Retards</div>
                        </div>
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <div class="text-3xl font-bold text-blue-600">{{ $stats['attendance_rate'] }}%</div>
                            <div class="text-sm text-gray-600 mt-1">Taux</div>
                        </div>
                    </div>
                </div>

                <!-- Subjects Filter -->
                @if($this->subjects->count() > 0)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
                        <label class="text-sm font-medium text-gray-700 mb-2 block">Matière enseignée</label>
                        <div class="flex flex-wrap gap-2">
                            <button wire:click="selectSubject(null)"
                                class="px-4 py-2 rounded-lg font-medium transition-all
                                                                                                                                                    {{ !$selectedSubjectId ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                Toutes les matières
                            </button>
                            @foreach($this->subjects as $subject)
                                <button wire:click="selectSubject({{ $subject->id }})"
                                    class="px-4 py-2 rounded-lg font-medium transition-all
                                                                                                                                                                                                                {{ $selectedSubjectId == $subject->id ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                    {{ $subject->name }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Filters and Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Search -->
                        <div>
                            <label class="text-sm font-medium text-gray-700 mb-2 block">Rechercher</label>
                            <input type="text" wire:model.live.debounce.300ms="searchStudent"
                                placeholder="Nom, prénom ou numéro..."
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                        </div>

                        <!-- Status Filter -->
                        <div>
                            <label class="text-sm font-medium text-gray-700 mb-2 block">Statut</label>
                            <select wire:model.live="statusFilter"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                                <option value="all">Tous les statuts</option>
                                <option value="active">Actifs</option>
                                <option value="suspended">Suspendus</option>
                            </select>
                        </div>

                        <!-- Date -->
                        <div>
                            <label class="text-sm font-medium text-gray-700 mb-2 block">Date</label>
                            <input type="date" wire:model.live="attendanceDate"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-200">
                        <div class="text-sm text-gray-600">
                            {{ $this->students->count() }} élève(s) affiché(s)
                        </div>
                        <div class="flex space-x-2">
                            <button wire:click="markAllPresent"
                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium">
                                ✓ Tout marquer présent
                            </button>
                            <button wire:click="exportAttendance"
                                class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors text-sm font-medium">
                                📥 Exporter
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Students List -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Photo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Numéro</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom Complet
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Genre</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Présence
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($this->students as $student)
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

                                        <!-- Student Number -->
                                        <td class="px-6 py-4">
                                            <span
                                                class="font-mono text-sm font-medium text-gray-900">{{ $student->student_number }}</span>
                                        </td>

                                        <!-- Full Name -->
                                        <td class="px-6 py-4">
                                            <div>
                                                <div class="font-semibold text-gray-900">{{ $student->full_name }}</div>
                                                <div class="text-sm text-gray-500">{{ $student->age }} ans</div>
                                            </div>
                                        </td>

                                        <!-- Gender -->
                                        <td class="px-6 py-4">
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                                                                                                                                    {{ $student->gender == 'M' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                                {{ $student->gender == 'M' ? 'Garçon' : 'Fille' }}
                                            </span>
                                        </td>

                                        <!-- Attendance -->
                                        <td class="px-6 py-4">
                                            <div class="flex space-x-1">
                                                <button wire:click="markAttendance({{ $student->id }}, 'present')"
                                                    class="p-2 rounded-lg transition-all
                                                                                                                                                                        {{ isset($attendanceStatus[$student->id]) && $attendanceStatus[$student->id] == 'present' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-green-100' }}"
                                                    title="Présent">
                                                    ✓
                                                </button>
                                                <button wire:click="markAttendance({{ $student->id }}, 'absent')"
                                                    class="p-2 rounded-lg transition-all
                                                                                                                                                                        {{ isset($attendanceStatus[$student->id]) && $attendanceStatus[$student->id] == 'absent' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-red-100' }}"
                                                    title="Absent">
                                                    ✗
                                                </button>
                                                <button wire:click="markAttendance({{ $student->id }}, 'late')"
                                                    class="p-2 rounded-lg transition-all
                                                                                                                                                                        {{ isset($attendanceStatus[$student->id]) && $attendanceStatus[$student->id] == 'late' ? 'bg-yellow-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-yellow-100' }}"
                                                    title="Retard">
                                                    ⏰
                                                </button>
                                                <button wire:click="markAttendance({{ $student->id }}, 'excused')"
                                                    class="p-2 rounded-lg transition-all
                                                                                                                                                                        {{ isset($attendanceStatus[$student->id]) && $attendanceStatus[$student->id] == 'excused' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-blue-100' }}"
                                                    title="Excusé">
                                                    📝
                                                </button>
                                            </div>
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-6 py-4">
                                            <button wire:click="viewStudentDetails({{ $student->id }})"
                                                class="text-emerald-600 hover:text-emerald-900 font-medium text-sm">
                                                Voir détails →
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                                </path>
                                            </svg>
                                            Aucun élève trouvé
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            @else
                <!-- No Class Selected -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                    <svg class="w-20 h-20 mx-auto mb-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Sélectionnez une classe</h3>
                    <p class="text-gray-600">Choisissez une classe dans la liste de gauche pour commencer</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Student Details Modal -->
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
                            <p class="text-2xl font-bold text-blue-600">{{ $this->selectedStudent->getAttendanceRate() }}%
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