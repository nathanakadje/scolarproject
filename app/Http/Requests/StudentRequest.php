<?php

// App\Http\Requests\StudentRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Student;

class StudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $studentId = $this->route('student') ? $this->route('student')->id : null;

        return [
            'student_number' => 'required|string|unique:students,student_number,' . $studentId,
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'required|date|before:today',
            'birth_place' => 'nullable|string|max:255',
            'gender' => 'required|in:M,F',
            'nationality' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:students,email,' . $studentId,
            'address' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'enrollment_date' => 'required|date',
            'status' => 'required|in:active,suspended,graduated,dropped',
            'medical_info' => 'nullable|string',
            'notes' => 'nullable|string',
            'parents' => 'nullable|array',
            'parents.*' => 'exists:parent_models,id',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'student_number' => 'numéro étudiant',
            'first_name' => 'prénom',
            'last_name' => 'nom',
            'birth_date' => 'date de naissance',
            'birth_place' => 'lieu de naissance',
            'gender' => 'genre',
            'nationality' => 'nationalité',
            'phone' => 'téléphone',
            'email' => 'email',
            'address' => 'adresse',
            'photo' => 'photo',
            'enrollment_date' => 'date d\'inscription',
            'status' => 'statut',
            'medical_info' => 'informations médicales',
            'notes' => 'notes',
            'parents' => 'parents',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'birth_date.before' => 'La date de naissance doit être antérieure à aujourd\'hui.',
            'email.unique' => 'Cet email est déjà utilisé par un autre étudiant.',
            'student_number.unique' => 'Ce numéro étudiant est déjà utilisé.',
            'parents.*.exists' => 'Un ou plusieurs parents sélectionnés n\'existent pas.',
        ];
    }

    /**
     * Préparer les données avant la validation
     */
    protected function prepareForValidation(): void
    {
        // Générer automatiquement le numéro d'étudiant si vide
        if (empty($this->student_number)) {
            $this->merge([
                'student_number' => $this->generateUniqueStudentNumber()
            ]);
        }

        // Nettoyer le numéro de téléphone
        if ($this->phone) {
            $this->merge([
                'phone' => $this->cleanPhoneNumber($this->phone)
            ]);
        }

        // S'assurer que la date d'inscription est définie
        if (empty($this->enrollment_date)) {
            $this->merge([
                'enrollment_date' => now()->format('Y-m-d')
            ]);
        }

        // S'assurer que le statut est défini
        if (empty($this->status)) {
            $this->merge([
                'status' => 'active'
            ]);
        }
    }

    /**
     * Traiter les données après validation et avant sauvegarde
     */
    public function processValidatedData(): array
    {
        $data = $this->validated();

        // Traitement spécial pour la photo
        if ($this->hasFile('photo')) {
            $data['photo'] = $this->handlePhotoUpload();
        }

        return $data;
    }

    /**
     * Gérer les relations après création/mise à jour de l'étudiant
     */
    public function handleRelationships(Student $student): void
    {
        // Gérer la relation avec les parents
        if ($this->has('parents') && is_array($this->parents)) {
            $this->syncParentRelationships($student, $this->parents);
        }
    }

    /**
     * Synchroniser les relations parent-étudiant
     */
    private function syncParentRelationships(Student $student, array $parentIds): void
    {
        // Préparer les données de synchronisation avec pivot
        $syncData = [];

        foreach ($parentIds as $index => $parentId) {
            $syncData[$parentId] = [
                'is_primary_contact' => $index === 0, // Le premier est le contact principal
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Synchroniser avec la table pivot
        $student->parents()->sync($syncData);
    }

    /**
     * Générer un numéro d'étudiant unique
     */
    private function generateUniqueStudentNumber(): string
    {
        $year = date('Y');
        $prefix = 'STU' . $year;

        // Trouver le dernier numéro de l'année courante
        $lastStudent = Student::where('student_number', 'like', $prefix . '%')
            ->orderBy('student_number', 'desc')
            ->first();

        if ($lastStudent) {
            // Extraire le numéro séquentiel
            $lastSequence = intval(substr($lastStudent->student_number, -4));
            $nextSequence = $lastSequence + 1;
        } else {
            // Premier étudiant de l'année
            $nextSequence = 1;
        }

        $studentNumber = $prefix . str_pad($nextSequence, 4, '0', STR_PAD_LEFT);

        // Vérifier l'unicité (au cas où)
        while (Student::where('student_number', $studentNumber)->exists()) {
            $nextSequence++;
            $studentNumber = $prefix . str_pad($nextSequence, 4, '0', STR_PAD_LEFT);
        }

        return $studentNumber;
    }

    /**
     * Nettoyer le numéro de téléphone
     */
    private function cleanPhoneNumber(string $phone): string
    {
        // Supprimer tous les caractères non numériques sauf le +
        $cleaned = preg_replace('/[^+\d]/', '', $phone);

        // Ajouter le préfixe ivoirien si nécessaire
        if (!str_starts_with($cleaned, '+') && strlen($cleaned) === 8) {
            $cleaned = '+225' . $cleaned;
        }

        return $cleaned;
    }

    /**
     * Gérer l'upload de la photo
     */
    private function handlePhotoUpload(): ?string
    {
        if (!$this->hasFile('photo')) {
            return null;
        }

        $file = $this->file('photo');
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // Stocker dans le disque public sous le dossier students
        $path = $file->storeAs('students', $fileName, 'public');

        return $path;
    }

    /**
     * Méthode statique pour créer un étudiant avec toute la logique
     */
    public static function createStudent(array $data): Student
    {
        $request = new self($data);
        $request->setContainer(app());
        $request->validateResolved();

        // Traiter les données
        $processedData = $request->processValidatedData();

        // Créer l'étudiant
        $student = Student::create($processedData);

        // Gérer les relations
        $request->handleRelationships($student);

        return $student;
    }

    /**
     * Méthode statique pour mettre à jour un étudiant
     */
    public static function updateStudent(Student $student, array $data): Student
    {
        $request = new self($data);
        $request->setContainer(app());
        $request->setRouteResolver(function () use ($student) {
            return app('router')->current()->setParameter('student', $student);
        });
        $request->validateResolved();

        // Traiter les données
        $processedData = $request->processValidatedData();

        // Mettre à jour l'étudiant
        $student->update($processedData);

        // Gérer les relations
        $request->handleRelationships($student);

        return $student->fresh();
    }
}