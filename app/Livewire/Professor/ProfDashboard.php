<?php

namespace App\Livewire\Professor;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.professor-layout')]
class ProfDashboard extends Component
{
    public $stats = [];
    public $recentActivities = [];
    public $upcomingClasses = [];
    public $pendingAssignments = [];

    public function mount()
    {
        $this->stats = [
            'total_students' => 145,
            'total_courses' => 4,
            'assignments_to_grade' => 28,
            'average_class_performance' => 14.2
        ];

        $this->upcomingClasses = [
            [
                'course' => 'Mathématiques Avancées',
                'class' => 'Terminale S1',
                'time' => '08:00 - 10:00',
                'room' => 'Salle 201',
                'students_count' => 35
            ],
            [
                'course' => 'Algèbre Linéaire',
                'class' => 'Licence 2',
                'time' => '10:30 - 12:30',
                'room' => 'Amphi A',
                'students_count' => 50
            ],
            [
                'course' => 'Géométrie',
                'class' => 'Première S2',
                'time' => '14:00 - 16:00',
                'room' => 'Salle 105',
                'students_count' => 30
            ]
        ];

        $this->recentActivities = [
            ['type' => 'submission', 'student' => 'Kouame Marie', 'action' => 'a rendu le devoir', 'course' => 'Mathématiques', 'time' => '2h'],
            ['type' => 'question', 'student' => 'Diallo Amadou', 'action' => 'a posé une question', 'course' => 'Algèbre', 'time' => '3h'],
            ['type' => 'submission', 'student' => 'Traore Fatou', 'action' => 'a rendu le devoir', 'course' => 'Géométrie', 'time' => '5h'],
        ];

        $this->pendingAssignments = [
            ['course' => 'Mathématiques Avancées', 'title' => 'Examen Final', 'submissions' => 32, 'total' => 35, 'deadline' => '2025-10-15'],
            ['course' => 'Algèbre Linéaire', 'title' => 'TP N°5', 'submissions' => 45, 'total' => 50, 'deadline' => '2025-10-12'],
            ['course' => 'Géométrie', 'title' => 'Exercices Ch.3', 'submissions' => 28, 'total' => 30, 'deadline' => '2025-10-10'],
        ];
    }
    public function render()
    {
        return view('livewire.professor.prof-dashboard');
    }
}
