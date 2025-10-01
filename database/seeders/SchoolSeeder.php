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
use App\Models\Enrollment;
use App\Models\User;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        // Créer un utilisateur admin
        $admin = User::create([
            'name' => 'Administrateur',
            'email' => 'admin@ecole.ci',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');

        // Créer les niveaux académiques
        $primary = AcademicLevel::create([
            'name' => 'Primaire',
            'code' => 'PRI',
            'description' => 'École primaire',
            'duration_years' => 6,
        ]);

        $secondary = AcademicLevel::create([
            'name' => 'Secondaire',
            'code' => 'SEC',
            'description' => 'École secondaire',
            'duration_years' => 7,
        ]);

        // Créer les matières
        $subjects = [
            ['name' => 'Mathématiques', 'code' => 'MATH', 'coefficient' => 3, 'color' => '#3b82f6'],
            ['name' => 'Français', 'code' => 'FR', 'coefficient' => 3, 'color' => '#ef4444'],
            ['name' => 'Anglais', 'code' => 'EN', 'coefficient' => 2, 'color' => '#10b981'],
            ['name' => 'Histoire-Géographie', 'code' => 'HG', 'coefficient' => 2, 'color' => '#f59e0b'],
            ['name' => 'Sciences Physiques', 'code' => 'SP', 'coefficient' => 2, 'color' => '#8b5cf6'],
            ['name' => 'Sciences Naturelles', 'code' => 'SN', 'coefficient' => 2, 'color' => '#06b6d4'],
            ['name' => 'Éducation Physique', 'code' => 'EPS', 'coefficient' => 1, 'color' => '#84cc16'],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }

        // Créer les classes
        $classes = [
            // Primaire
            ['name' => 'CP1', 'code' => 'CP1', 'academic_level_id' => $primary->id, 'capacity' => 35, 'school_fees' => 50000],
            ['name' => 'CP2', 'code' => 'CP2', 'academic_level_id' => $primary->id, 'capacity' => 35, 'school_fees' => 55000],
            ['name' => 'CE1', 'code' => 'CE1', 'academic_level_id' => $primary->id, 'capacity' => 40, 'school_fees' => 60000],
            ['name' => 'CE2', 'code' => 'CE2', 'academic_level_id' => $primary->id, 'capacity' => 40, 'school_fees' => 65000],
            ['name' => 'CM1', 'code' => 'CM1', 'academic_level_id' => $primary->id, 'capacity' => 40, 'school_fees' => 70000],
            ['name' => 'CM2', 'code' => 'CM2', 'academic_level_id' => $primary->id, 'capacity' => 40, 'school_fees' => 75000],

            // Secondaire
            ['name' => '6ème', 'code' => '6E', 'academic_level_id' => $secondary->id, 'capacity' => 45, 'school_fees' => 100000],
            ['name' => '5ème', 'code' => '5E', 'academic_level_id' => $secondary->id, 'capacity' => 45, 'school_fees' => 105000],
            ['name' => '4ème', 'code' => '4E', 'academic_level_id' => $secondary->id, 'capacity' => 45, 'school_fees' => 110000],
            ['name' => '3ème', 'code' => '3E', 'academic_level_id' => $secondary->id, 'capacity' => 45, 'school_fees' => 115000],
            ['name' => '2nde', 'code' => '2ND', 'academic_level_id' => $secondary->id, 'capacity' => 40, 'school_fees' => 120000],
            ['name' => '1ère', 'code' => '1ERE', 'academic_level_id' => $secondary->id, 'capacity' => 40, 'school_fees' => 125000],
            ['name' => 'Terminale', 'code' => 'TLE', 'academic_level_id' => $secondary->id, 'capacity' => 40, 'school_fees' => 130000],
        ];

        foreach ($classes as $class) {
            ClassModel::create($class);
        }

        // Créer l'année académique courante
        $currentYear = AcademicYear::create([
            'name' => '2024-2025',
            'start_date' => '2024-09-01',
            'end_date' => '2025-06-30',
            'is_current' => true,
        ]);

        // Créer des enseignants
        $teachers = [
            [
                'teacher_number' => 'T001',
                'first_name' => 'Marie',
                'last_name' => 'Kouassi',
                'birth_date' => '1985-03-15',
                'gender' => 'F',
                'phone' => '+225 07 12 34 56 78',
                'email' => 'marie.kouassi@ecole.ci',
                'address' => 'Cocody, Abidjan',
                'qualification' => 'Master en Mathématiques',
                'hire_date' => '2015-09-01',
                'salary' => 450000,
            ],
            [
                'teacher_number' => 'T002',
                'first_name' => 'Jean',
                'last_name' => 'Diabate',
                'birth_date' => '1982-07-22',
                'gender' => 'M',
                'phone' => '+225 05 87 65 43 21',
                'email' => 'jean.diabate@ecole.ci',
                'address' => 'Marcory, Abidjan',
                'qualification' => 'Licence en Lettres Modernes',
                'hire_date' => '2012-09-01',
                'salary' => 420000,
            ],
            [
                'teacher_number' => 'T003',
                'first_name' => 'Aissata',
                'last_name' => 'Traore',
                'birth_date' => '1988-11-10',
                'gender' => 'F',
                'phone' => '+225 01 23 45 67 89',
                'email' => 'aissata.traore@ecole.ci',
                'address' => 'Plateau, Abidjan',
                'qualification' => 'Master en Anglais',
                'hire_date' => '2018-09-01',
                'salary' => 400000,
            ],
        ];

        foreach ($teachers as $teacher) {
            Teacher::create($teacher);
        }

        // Créer des parents
        $parent1 = ParentModel::create(
            [
                'first_name' => 'Koffi',
                'last_name' => 'Yao',
                'relationship' => 'father',
                'phone' => '+225 07 11 22 33 44',
                'email' => 'koffi.yao@gmail.com',
                'profession' => 'Ingénieur',
                'address' => 'Riviera, Abidjan',
                'is_emergency_contact' => true,
            ]
        );

        $parent2 = ParentModel::create([
            'first_name' => 'Adjoua',
            'last_name' => 'Yao',
            'relationship' => 'mother',
            'phone' => '+225 05 55 66 77 88',
            'email' => 'adjoua.yao@gmail.com',
            'profession' => 'Infirmière',
            'address' => 'Riviera, Abidjan',
            'is_emergency_contact' => true,
        ]);

        // foreach ($parents as $parent) {
        //     ParentModel::create($parent);
        // }

        // Créer des étudiants
        $students = [
            [
                'student_number' => 'E2024001',
                'first_name' => 'Aya',
                'last_name' => 'Yao',
                'birth_date' => '2010-05-15',
                'birth_place' => 'Abidjan',
                'gender' => 'F',
                'nationality' => 'Ivoirienne',
                'phone' => null,
                'email' => null,
                'address' => 'Riviera, Abidjan',
                'enrollment_date' => '2024-09-01',
                'status' => 'active',
            ],
            [
                'student_number' => 'E2024002',
                'first_name' => 'Kouadio',
                'last_name' => 'Yao',
                'birth_date' => '2012-08-22',
                'birth_place' => 'Abidjan',
                'gender' => 'M',
                'nationality' => 'Ivoirienne',
                'phone' => null,
                'email' => null,
                'address' => 'Riviera, Abidjan',
                'enrollment_date' => '2024-09-01',
                'status' => 'active',
            ],
        ];

        foreach ($students as $studentData) {
            $student = Student::create($studentData);

            // Associer les parents aux étudiants
            // $student->parents()->attach([1, 2], [
            //     'is_primary_contact' => true,
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ]);
            // Associer l’étudiant aux deux parents
            $student->parents()->attach([
                $parent1->id => [
                    'is_primary_contact' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                $parent2->id => [
                    'is_primary_contact' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

        // Créer des inscriptions
        $student1 = Student::where('student_number', 'E2024001')->first();
        $student2 = Student::where('student_number', 'E2024002')->first();
        $class6e = ClassModel::where('code', '6E')->first();
        $classCE2 = ClassModel::where('code', 'CE2')->first();

        if ($student1 && $class6e) {
            Enrollment::create([
                'student_id' => $student1->id,
                'class_id' => $class6e->id,
                'academic_year_id' => $currentYear->id,
                'enrollment_date' => '2024-09-01',
                'fees_due' => $class6e->school_fees,
                'fees_paid' => $class6e->school_fees * 0.5, // 50% payé
                'status' => 'active',
            ]);
        }

        if ($student2 && $classCE2) {
            Enrollment::create([
                'student_id' => $student2->id,
                'class_id' => $classCE2->id,
                'academic_year_id' => $currentYear->id,
                'enrollment_date' => '2024-09-01',
                'fees_due' => $classCE2->school_fees,
                'fees_paid' => $classCE2->school_fees, // 100% payé
                'status' => 'active',
            ]);
        }

        $this->command->info('Données de test créées avec succès !');

        // public function run()
        // {
        //     // 1. Créer les niveaux scolaires
        //     $primary = AcademicLevel::create([
        //         'name' => 'Primaire',
        //         'code' => 'PRI',
        //         'description' => 'Enseignement primaire',
        //         'duration_years' => 6,
        //         'is_active' => true,
        //     ]);

        //     $secondary = AcademicLevel::create([
        //         'name' => 'Secondaire',
        //         'code' => 'SEC',
        //         'description' => 'Enseignement secondaire',
        //         'duration_years' => 7,
        //         'is_active' => true,
        //     ]);

        //     // 2. Créer les classes
        //     $classes = [
        //         // Classes primaires
        //         ['name' => 'CP1', 'code' => 'CP1', 'level_id' => $primary->id, 'fees' => 50000],
        //         ['name' => 'CP2', 'code' => 'CP2', 'level_id' => $primary->id, 'fees' => 50000],
        //         ['name' => 'CE1', 'code' => 'CE1', 'level_id' => $primary->id, 'fees' => 55000],
        //         ['name' => 'CE2', 'code' => 'CE2', 'level_id' => $primary->id, 'fees' => 55000],
        //         ['name' => 'CM1', 'code' => 'CM1', 'level_id' => $primary->id, 'fees' => 60000],
        //         ['name' => 'CM2', 'code' => 'CM2', 'level_id' => $primary->id, 'fees' => 60000],

        //         // Classes secondaires
        //         ['name' => '6ème', 'code' => '6E', 'level_id' => $secondary->id, 'fees' => 80000],
        //         ['name' => '5ème', 'code' => '5E', 'level_id' => $secondary->id, 'fees' => 80000],
        //         ['name' => '4ème', 'code' => '4E', 'level_id' => $secondary->id, 'fees' => 85000],
        //         ['name' => '3ème', 'code' => '3E', 'level_id' => $secondary->id, 'fees' => 85000],
        //         ['name' => '2nde', 'code' => '2ND', 'level_id' => $secondary->id, 'fees' => 90000],
        //         ['name' => '1ère', 'code' => '1RE', 'level_id' => $secondary->id, 'fees' => 90000],
        //         ['name' => 'Terminale', 'code' => 'TLE', 'level_id' => $secondary->id, 'fees' => 95000],
        //     ];

        //     foreach ($classes as $classData) {
        //         ClassModel::create([
        //             'name' => $classData['name'],
        //             'code' => $classData['code'],
        //             'academic_level_id' => $classData['level_id'],
        //             'capacity' => 40,
        //             'school_fees' => $classData['fees'],
        //             'is_active' => true,
        //         ]);
        //     }

        //     // 3. Créer les matières
        //     $subjects = [
        //         // Matières primaires
        //         ['name' => 'Français', 'code' => 'FR', 'coefficient' => 3, 'color' => '#e74c3c'],
        //         ['name' => 'Mathématiques', 'code' => 'MATH', 'coefficient' => 3, 'color' => '#3498db'],
        //         ['name' => 'Éducation Civique', 'code' => 'EC', 'coefficient' => 1, 'color' => '#2ecc71'],
        //         ['name' => 'Histoire-Géographie', 'code' => 'HG', 'coefficient' => 2, 'color' => '#f39c12'],
        //         ['name' => 'Sciences', 'code' => 'SCI', 'coefficient' => 2, 'color' => '#9b59b6'],
        //         ['name' => 'Éducation Physique', 'code' => 'EPS', 'coefficient' => 1, 'color' => '#1abc9c'],
        //         ['name' => 'Arts Plastiques', 'code' => 'ART', 'coefficient' => 1, 'color' => '#e67e22'],

        //         // Matières secondaires
        //         ['name' => 'Anglais', 'code' => 'ANG', 'coefficient' => 2, 'color' => '#34495e'],
        //         ['name' => 'Physique-Chimie', 'code' => 'PC', 'coefficient' => 3, 'color' => '#8e44ad'],
        //         ['name' => 'Sciences de la Vie et de la Terre', 'code' => 'SVT', 'coefficient' => 2, 'color' => '#27ae60'],
        //         ['name' => 'Philosophie', 'code' => 'PHILO', 'coefficient' => 3, 'color' => '#95a5a6'],
        //         ['name' => 'Économie', 'code' => 'ECO', 'coefficient' => 2, 'color' => '#16a085'],
        //     ];

        //     foreach ($subjects as $subjectData) {
        //         Subject::create($subjectData);
        //     }

        //     // 4. Créer l'année scolaire courante
        //     $currentYear = AcademicYear::create([
        //         'name' => '2024-2025',
        //         'start_date' => Carbon::create(2024, 9, 1),
        //         'end_date' => Carbon::create(2025, 6, 30),
        //         'is_current' => true,
        //         'is_active' => true,
        //     ]);

        //     // 5. Créer des professeurs
        //     $teachers = [
        //         [
        //             'teacher_number' => 'TEACH001',
        //             'first_name' => 'Marie',
        //             'last_name' => 'KOUADIO',
        //             'birth_date' => '1985-03-15',
        //             'gender' => 'F',
        //             'phone' => '0702030405',
        //             'email' => 'marie.kouadio@ecole.ci',
        //             'address' => 'Cocody, Abidjan',
        //             'qualification' => 'Master en Mathématiques',
        //             'hire_date' => '2020-09-01',
        //             'status' => 'active',
        //         ],
        //         [
        //             'teacher_number' => 'TEACH004',
        //             'first_name' => 'STEOHANE',
        //             'last_name' => 'KOUADIO',
        //             'birth_date' => '1985-03-15',
        //             'gender' => 'M',
        //             'phone' => '0702030405',
        //             'email' => 'azertyo@ecole.ci',
        //             'address' => 'Cocody, Abidjan',
        //             'qualification' => 'Master en Mathématiques',
        //             'hire_date' => '2020-09-01',
        //             'status' => 'active',
        //         ],
        //         [
        //             'teacher_number' => 'TEACH002',
        //             'first_name' => 'Jean',
        //             'last_name' => 'ASSI',
        //             'birth_date' => '1980-07-22',
        //             'gender' => 'M',
        //             'phone' => '0706070809',
        //             'email' => 'jean.assi@ecole.ci',
        //             'address' => 'Yopougon, Abidjan',
        //             'qualification' => 'Licence en Lettres Modernes',
        //             'hire_date' => '2018-09-01',
        //             'status' => 'active',
        //         ],
        //         [
        //             'teacher_number' => 'TEACH003',
        //             'first_name' => 'Fatou',
        //             'last_name' => 'DIALLO',
        //             'birth_date' => '1987-12-10',
        //             'gender' => 'F',
        //             'phone' => '0710111213',
        //             'email' => 'fatou.diallo@ecole.ci',
        //             'address' => 'Adjamé, Abidjan',
        //             'qualification' => 'Master en Sciences Physiques',
        //             'hire_date' => '2021-09-01',
        //             'status' => 'active',
        //         ],
        //     ];

        //     foreach ($teachers as $teacherData) {
        //         Teacher::create($teacherData);
        //     }

        //     // 6. Créer des parents
        //     $parents = [
        //         [
        //             'first_name' => 'Kouame',
        //             'last_name' => 'YAO',
        //             'relationship' => 'father',
        //             'phone' => '0701020304',
        //             'email' => 'kouame.yao@gmail.com',
        //             'profession' => 'Ingénieur',
        //             'address' => 'Plateau, Abidjan',
        //             'is_emergency_contact' => true,
        //         ],
        //         [
        //             'first_name' => 'Aminata',
        //             'last_name' => 'YAO',
        //             'relationship' => 'mother',
        //             'phone' => '0705060708',
        //             'email' => 'aminata.yao@gmail.com',
        //             'profession' => 'Commerçante',
        //             'address' => 'Plateau, Abidjan',
        //             'is_emergency_contact' => false,
        //         ],
        //         [
        //             'first_name' => 'lamile',
        //             'last_name' => 'kaala',
        //             'relationship' => 'mother',
        //             'phone' => '0705060708',
        //             'email' => 'akao@gmail.com',
        //             'profession' => 'Chauffeur',
        //             'address' => 'Koumassi, Abidjan',
        //             'is_emergency_contact' => false,
        //         ],
        //         [
        //             'first_name' => 'Amadou',
        //             'last_name' => 'Silveste',
        //             'relationship' => 'mother',
        //             'phone' => '0705060708',
        //             'email' => 'amadouo@gmail.com',
        //             'profession' => 'Acteur',
        //             'address' => 'Yopougon, Abidjan',
        //             'is_emergency_contact' => false,
        //         ],
        //     ];

        //     foreach ($parents as $parentData) {
        //         ParentModel::create($parentData);
        //     }

        //     // 7. Créer des étudiants
        //     $students = [
        //         [
        //             'student_number' => 'STU2024001',
        //             'first_name' => 'Aya',
        //             'last_name' => 'YAO',
        //             'birth_date' => '2010-05-15',
        //             'birth_place' => 'Abidjan',
        //             'gender' => 'F',
        //             'phone' => null,
        //             'email' => null,
        //             'address' => 'Plateau, Abidjan',
        //             'enrollment_date' => '2024-09-01',
        //             'status' => 'active',
        //         ],
        //         [
        //             'student_number' => 'STU2024002',
        //             'first_name' => 'Koffi',
        //             'last_name' => 'BEUGRE',
        //             'birth_date' => '2009-08-22',
        //             'birth_place' => 'Yamoussoukro',
        //             'gender' => 'M',
        //             'phone' => null,
        //             'email' => null,
        //             'address' => 'Adjamé, Abidjan',
        //             'enrollment_date' => '2024-09-01',
        //             'status' => 'active',
        //         ],
        //         [
        //             'student_number' => 'STU2024003',
        //             'first_name' => 'Yao',
        //             'last_name' => 'BALTI',
        //             'birth_date' => '2009-08-22',
        //             'birth_place' => 'Jacqueville',
        //             'gender' => 'M',
        //             'phone' => null,
        //             'email' => null,
        //             'address' => 'Adjamé, Abidjan',
        //             'enrollment_date' => '2024-09-01',
        //             'status' => 'active',
        //         ],
        //         [
        //             'student_number' => 'STU2024007',
        //             'first_name' => 'AMOU',
        //             'last_name' => 'KOULIBALI',
        //             'birth_date' => '2009-08-22',
        //             'birth_place' => 'Yamoussoukro',
        //             'gender' => 'M',
        //             'phone' => null,
        //             'email' => null,
        //             'address' => 'port bouet, Abidjan',
        //             'enrollment_date' => '2024-09-01',
        //             'status' => 'active',
        //         ],
        //         [
        //             'student_number' => 'STU2024004',
        //             'first_name' => 'Koffi',
        //             'last_name' => 'SIDJE',
        //             'birth_date' => '2009-08-22',
        //             'birth_place' => 'Man',
        //             'gender' => 'M',
        //             'phone' => null,
        //             'email' => null,
        //             'address' => 'Man, Cote ivoire',
        //             'enrollment_date' => '2024-09-01',
        //             'status' => 'active',
        //         ],
        //     ];

        //     foreach ($students as $studentData) {
        //         $student = Student::create($studentData);

        //         // Associer les parents au premier étudiant
        //         if ($student->id === 1) {
        //             // $student->parents()->attach([1, 2], ['is_primary_contact' => [1 => true, 2 => false]]);
        //             $student->parents()->attach([
        //                 1 => ['is_primary_contact' => true],
        //                 2 => ['is_primary_contact' => false],
        //             ]);
        //         }
        //     }
    }
}
