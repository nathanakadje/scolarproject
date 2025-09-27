<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AcademicLevel;
use App\Models\ClassModel;
use App\Models\Subject;
use App\Models\AcademicYear;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\ParentModel;
use Carbon\Carbon;
class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // 1. Créer les niveaux scolaires
        // $primary = AcademicLevel::create([
        //     'name' => 'Primaire',
        //     'code' => 'PRI',
        //     'description' => 'Enseignement primaire',
        //     'duration_years' => 6,
        //     'is_active' => true,
        // ]);

        // $secondary = AcademicLevel::create([
        //     'name' => 'Secondaire',
        //     'code' => 'SEC',
        //     'description' => 'Enseignement secondaire',
        //     'duration_years' => 7,
        //     'is_active' => true,
        // ]);

        // // 2. Créer les classes
        // $classes = [
        //     // Classes primaires
        //     ['name' => 'CP1', 'code' => 'CP1', 'level_id' => $primary->id, 'fees' => 50000],
        //     ['name' => 'CP2', 'code' => 'CP2', 'level_id' => $primary->id, 'fees' => 50000],
        //     ['name' => 'CE1', 'code' => 'CE1', 'level_id' => $primary->id, 'fees' => 55000],
        //     ['name' => 'CE2', 'code' => 'CE2', 'level_id' => $primary->id, 'fees' => 55000],
        //     ['name' => 'CM1', 'code' => 'CM1', 'level_id' => $primary->id, 'fees' => 60000],
        //     ['name' => 'CM2', 'code' => 'CM2', 'level_id' => $primary->id, 'fees' => 60000],

        //     // Classes secondaires
        //     ['name' => '6ème', 'code' => '6E', 'level_id' => $secondary->id, 'fees' => 80000],
        //     ['name' => '5ème', 'code' => '5E', 'level_id' => $secondary->id, 'fees' => 80000],
        //     ['name' => '4ème', 'code' => '4E', 'level_id' => $secondary->id, 'fees' => 85000],
        //     ['name' => '3ème', 'code' => '3E', 'level_id' => $secondary->id, 'fees' => 85000],
        //     ['name' => '2nde', 'code' => '2ND', 'level_id' => $secondary->id, 'fees' => 90000],
        //     ['name' => '1ère', 'code' => '1RE', 'level_id' => $secondary->id, 'fees' => 90000],
        //     ['name' => 'Terminale', 'code' => 'TLE', 'level_id' => $secondary->id, 'fees' => 95000],
        // ];

        // foreach ($classes as $classData) {
        //     ClassModel::create([
        //         'name' => $classData['name'],
        //         'code' => $classData['code'],
        //         'academic_level_id' => $classData['level_id'],
        //         'capacity' => 40,
        //         'school_fees' => $classData['fees'],
        //         'is_active' => true,
        //     ]);
        // }

        // // 3. Créer les matières
        // $subjects = [
        //     // Matières primaires
        //     ['name' => 'Français', 'code' => 'FR', 'coefficient' => 3, 'color' => '#e74c3c'],
        //     ['name' => 'Mathématiques', 'code' => 'MATH', 'coefficient' => 3, 'color' => '#3498db'],
        //     ['name' => 'Éducation Civique', 'code' => 'EC', 'coefficient' => 1, 'color' => '#2ecc71'],
        //     ['name' => 'Histoire-Géographie', 'code' => 'HG', 'coefficient' => 2, 'color' => '#f39c12'],
        //     ['name' => 'Sciences', 'code' => 'SCI', 'coefficient' => 2, 'color' => '#9b59b6'],
        //     ['name' => 'Éducation Physique', 'code' => 'EPS', 'coefficient' => 1, 'color' => '#1abc9c'],
        //     ['name' => 'Arts Plastiques', 'code' => 'ART', 'coefficient' => 1, 'color' => '#e67e22'],

        //     // Matières secondaires
        //     ['name' => 'Anglais', 'code' => 'ANG', 'coefficient' => 2, 'color' => '#34495e'],
        //     ['name' => 'Physique-Chimie', 'code' => 'PC', 'coefficient' => 3, 'color' => '#8e44ad'],
        //     ['name' => 'Sciences de la Vie et de la Terre', 'code' => 'SVT', 'coefficient' => 2, 'color' => '#27ae60'],
        //     ['name' => 'Philosophie', 'code' => 'PHILO', 'coefficient' => 3, 'color' => '#95a5a6'],
        //     ['name' => 'Économie', 'code' => 'ECO', 'coefficient' => 2, 'color' => '#16a085'],
        // ];

        // foreach ($subjects as $subjectData) {
        //     Subject::create($subjectData);
        // }

        // // 4. Créer l'année scolaire courante
        // $currentYear = AcademicYear::create([
        //     'name' => '2024-2025',
        //     'start_date' => Carbon::create(2024, 9, 1),
        //     'end_date' => Carbon::create(2025, 6, 30),
        //     'is_current' => true,
        //     'is_active' => true,
        // ]);

        // // 5. Créer des professeurs
        // $teachers = [
        //     [
        //         'teacher_number' => 'TEACH001',
        //         'first_name' => 'Marie',
        //         'last_name' => 'KOUADIO',
        //         'birth_date' => '1985-03-15',
        //         'gender' => 'F',
        //         'phone' => '0702030405',
        //         'email' => 'marie.kouadio@ecole.ci',
        //         'address' => 'Cocody, Abidjan',
        //         'qualification' => 'Master en Mathématiques',
        //         'hire_date' => '2020-09-01',
        //         'status' => 'active',
        //     ],
        //     [
        //         'teacher_number' => 'TEACH002',
        //         'first_name' => 'Jean',
        //         'last_name' => 'ASSI',
        //         'birth_date' => '1980-07-22',
        //         'gender' => 'M',
        //         'phone' => '0706070809',
        //         'email' => 'jean.assi@ecole.ci',
        //         'address' => 'Yopougon, Abidjan',
        //         'qualification' => 'Licence en Lettres Modernes',
        //         'hire_date' => '2018-09-01',
        //         'status' => 'active',
        //     ],
        //     [
        //         'teacher_number' => 'TEACH003',
        //         'first_name' => 'Fatou',
        //         'last_name' => 'DIALLO',
        //         'birth_date' => '1987-12-10',
        //         'gender' => 'F',
        //         'phone' => '0710111213',
        //         'email' => 'fatou.diallo@ecole.ci',
        //         'address' => 'Adjamé, Abidjan',
        //         'qualification' => 'Master en Sciences Physiques',
        //         'hire_date' => '2021-09-01',
        //         'status' => 'active',
        //     ],
        // ];

        // foreach ($teachers as $teacherData) {
        //     Teacher::create($teacherData);
        // }

        // 6. Créer des parents
        $parents = [
            [
                'first_name' => 'Kouame',
                'last_name' => 'YAO',
                'relationship' => 'father',
                'phone' => '0701020304',
                'email' => 'kouame.yao@gmail.com',
                'profession' => 'Ingénieur',
                'address' => 'Plateau, Abidjan',
                'is_emergency_contact' => true,
            ],
            [
                'first_name' => 'Aminata',
                'last_name' => 'YAO',
                'relationship' => 'mother',
                'phone' => '0705060708',
                'email' => 'aminata.yao@gmail.com',
                'profession' => 'Commerçante',
                'address' => 'Plateau, Abidjan',
                'is_emergency_contact' => false,
            ],
        ];

        foreach ($parents as $parentData) {
            ParentModel::create($parentData);
        }

        // 7. Créer des étudiants
        $students = [
            [
                'student_number' => 'STU2024001',
                'first_name' => 'Aya',
                'last_name' => 'YAO',
                'birth_date' => '2010-05-15',
                'birth_place' => 'Abidjan',
                'gender' => 'F',
                'phone' => null,
                'email' => null,
                'address' => 'Plateau, Abidjan',
                'enrollment_date' => '2024-09-01',
                'status' => 'active',
            ],
            [
                'student_number' => 'STU2024002',
                'first_name' => 'Koffi',
                'last_name' => 'BEUGRE',
                'birth_date' => '2009-08-22',
                'birth_place' => 'Yamoussoukro',
                'gender' => 'M',
                'phone' => null,
                'email' => null,
                'address' => 'Adjamé, Abidjan',
                'enrollment_date' => '2024-09-01',
                'status' => 'active',
            ],
        ];

        foreach ($students as $studentData) {
            $student = Student::create($studentData);

            // Associer les parents au premier étudiant
            if ($student->id === 1) {
                // $student->parents()->attach([1, 2], ['is_primary_contact' => [1 => true, 2 => false]]);
                $student->parents()->attach([
                    1 => ['is_primary_contact' => true],
                    2 => ['is_primary_contact' => false],
                ]);
            }
        }
    }
}
