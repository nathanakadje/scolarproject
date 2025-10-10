<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.professor-layout')]
class CourseList extends Component
{
    public $courses = [];
    public $selectedCourse = null;
    public $showCourseModal = false;

    public function mount()
    {
        $this->courses = [
            [
                'id' => 1,
                'name' => 'Mathématiques Avancées',
                'code' => 'MATH301',
                'professor' => 'Dr. Kouame',
                'description' => 'Étude approfondie du calcul différentiel et intégral',
                'schedule' => 'Lundi 08:00-10:00, Mercredi 14:00-16:00',
                'room' => 'Salle 201',
                'credits' => 4,
                'progress' => 65,
                'next_class' => '2025-10-08 08:00',
                'color' => 'blue',
                'materials' => [
                    ['name' => 'Chapitre 1 - Introduction', 'type' => 'pdf', 'size' => '2.5 MB'],
                    ['name' => 'Exercices Série 1', 'type' => 'pdf', 'size' => '1.2 MB'],
                    ['name' => 'Correction TP1', 'type' => 'video', 'duration' => '45 min'],
                ]
            ],
            [
                'id' => 2,
                'name' => 'Physique Quantique',
                'code' => 'PHY401',
                'professor' => 'Prof. Diallo',
                'description' => 'Introduction aux principes de la mécanique quantique',
                'schedule' => 'Mardi 10:00-12:00, Jeudi 08:00-10:00',
                'room' => 'Labo B',
                'credits' => 5,
                'progress' => 45,
                'next_class' => '2025-10-08 10:00',
                'color' => 'green',
                'materials' => [
                    ['name' => 'Introduction à la Physique Quantique', 'type' => 'pdf', 'size' => '4.1 MB'],
                    ['name' => 'TP - Expérience double fente', 'type' => 'pdf', 'size' => '890 KB'],
                ]
            ],
            [
                'id' => 3,
                'name' => 'Programmation Avancée',
                'code' => 'INFO302',
                'professor' => 'Dr. Mensah',
                'description' => 'Concepts avancés de programmation orientée objet',
                'schedule' => 'Mercredi 10:00-12:00, Vendredi 14:00-17:00',
                'room' => 'Salle Info 1',
                'credits' => 6,
                'progress' => 80,
                'next_class' => '2025-10-09 10:00',
                'color' => 'purple',
                'materials' => [
                    ['name' => 'Design Patterns en Java', 'type' => 'pdf', 'size' => '3.2 MB'],
                    ['name' => 'Projet Final - Instructions', 'type' => 'pdf', 'size' => '756 KB'],
                    ['name' => 'Tutoriel Git Avancé', 'type' => 'video', 'duration' => '1h 20min'],
                ]
            ],
            [
                'id' => 4,
                'name' => 'Anglais Technique',
                'code' => 'ANG201',
                'professor' => 'Mme. Traore',
                'description' => 'Anglais appliqué aux sciences et technologies',
                'schedule' => 'Lundi 14:00-16:00',
                'room' => 'Salle 105',
                'credits' => 2,
                'progress' => 55,
                'next_class' => '2025-10-07 14:00',
                'color' => 'orange',
                'materials' => [
                    ['name' => 'Vocabulaire Technique', 'type' => 'pdf', 'size' => '1.5 MB'],
                    ['name' => 'Exercices de Grammaire', 'type' => 'pdf', 'size' => '980 KB'],
                ]
            ],
        ];
    }

    public function viewCourse($courseId)
    {
        $this->selectedCourse = collect($this->courses)->firstWhere('id', $courseId);
        $this->showCourseModal = true;
    }

    public function render()
    {
        return view('livewire.student.course-list');
    }
}