<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Carbon\Carbon;

#[Layout('layouts.professor-layout')]
class Calendar extends Component
{
    public $currentMonth;
    public $currentYear;
    public $events = [];
    public $selectedDate;
    public $showEventModal = false;

    public function mount()
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;

        // Événements simulés - à remplacer par de vraies données
        $this->events = [
            [
                'id' => 1,
                'title' => 'Examen de Mathématiques',
                'date' => '2025-10-15',
                'type' => 'exam',
                'color' => 'red',
                'description' => 'Examen final du semestre'
            ],
            [
                'id' => 2,
                'title' => 'Rendu TP Physique',
                'date' => '2025-10-12',
                'type' => 'assignment',
                'color' => 'blue',
                'description' => 'Dernier TP du chapitre 3'
            ],
            [
                'id' => 3,
                'title' => 'Vacances scolaires',
                'date' => '2025-10-20',
                'type' => 'holiday',
                'color' => 'green',
                'description' => 'Début des vacances'
            ],
            [
                'id' => 4,
                'title' => 'Sortie pédagogique',
                'date' => '2025-10-18',
                'type' => 'event',
                'color' => 'purple',
                'description' => 'Visite du musée des sciences'
            ],
        ];
    }

    public function previousMonth()
    {
        $this->currentMonth--;
        if ($this->currentMonth < 1) {
            $this->currentMonth = 12;
            $this->currentYear--;
        }
    }

    public function nextMonth()
    {
        $this->currentMonth++;
        if ($this->currentMonth > 12) {
            $this->currentMonth = 1;
            $this->currentYear++;
        }
    }

    public function selectDate($date)
    {
        $this->selectedDate = $date;
        $this->showEventModal = true;
    }

    public function getEventsForDate($date)
    {
        return collect($this->events)->filter(function ($event) use ($date) {
            return $event['date'] === $date;
        });
    }

    public function render()
    {
        $firstDayOfMonth = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1);
        $daysInMonth = $firstDayOfMonth->daysInMonth;
        $startDay = $firstDayOfMonth->dayOfWeek;

        return view('livewire.professor.calendar', [
            'firstDayOfMonth' => $firstDayOfMonth,
            'daysInMonth' => $daysInMonth,
            'startDay' => $startDay
        ]);
    }
}