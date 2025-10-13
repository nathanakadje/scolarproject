<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.student-layout')]
class StudentDashboard extends Component
{
    public $upcomingClasses = [];
    public $recentGrades = [];
    public $announcements = [];
    public $stats = [];

    public function mount()
    {
        // Simuler des données - à remplacer par de vraies requêtes
        $this->stats = [
            'total_courses' => 8,
            'average_grade' => 15.5,
            'attendance_rate' => 92,
            'assignments_pending' => 3
        ];

        $this->upcomingClasses = [
            ['course' => 'Mathématiques', 'time' => '08:00 - 10:00', 'room' => 'Salle 201', 'professor' => 'Dr. Kouame'],
            ['course' => 'Physique', 'time' => '10:30 - 12:30', 'room' => 'Labo B', 'professor' => 'Prof. Diallo'],
            ['course' => 'Anglais', 'time' => '14:00 - 16:00', 'room' => 'Salle 105', 'professor' => 'Mme. Traore'],
        ];

        $this->recentGrades = [
            ['course' => 'Mathématiques', 'assignment' => 'Examen Final', 'grade' => 16.5, 'date' => '2025-10-05'],
            ['course' => 'Physique', 'assignment' => 'TP N°3', 'grade' => 14.0, 'date' => '2025-10-03'],
            ['course' => 'Histoire', 'assignment' => 'Dissertation', 'grade' => 15.0, 'date' => '2025-10-01'],
        ];

        $this->announcements = [
            ['title' => 'Vacances scolaires', 'content' => 'Les vacances de Noël débutent le 20 décembre', 'date' => '2025-10-06'],
            ['title' => 'Nouvelle bibliothèque', 'content' => 'La nouvelle bibliothèque numérique est maintenant disponible', 'date' => '2025-10-05'],
        ];
    }

    public function render()
    {
        return view('livewire.student.student-dashboard');
    }
}