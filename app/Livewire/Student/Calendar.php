<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Student;
use App\Models\CalendarEvent;
use App\Models\Assignment;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;


#[Layout('layouts.student-layout')]
class Calendar extends Component
{
    public $student;
    public $viewMode = 'month'; // month, week, agenda
    public $currentDate;
    public $selectedEvent = null;
    public $showDetailModal = false;
    public $filterTypes = [];

    public function mount()
    {
        $this->student = Student::where('user_id', auth()->id())->first();
        $this->currentDate = today()->format('Y-m-d');

        // Initialiser tous les filtres
        $this->filterTypes = [
            'evaluation',
            'course',
            'meeting',
            'deadline',
            'holiday',
            'event',
            'revision',
            'trip',
            'ceremony',
            'parent_meeting',
            'pedagogical'
        ];
    }

    #[Computed]
    public function getEventsProperty()
    {
        // if (!$this->student || !$this->student->classe_id) {
        //     return collect();
        // }
        if (!$this->student?->classe?->id) {
            return collect();
        }

        $startDate = $this->getViewStartDate();
        $endDate = $this->getViewEndDate();

        $query = CalendarEvent::where('class_id', $this->student->classe->id)
            ->whereBetween('start_date', [$startDate, $endDate])
            ->with(['classe', 'subject']);

        if (!empty($this->filterTypes)) {
            $query->whereIn('type', $this->filterTypes);
        }

        return $query->orderBy('start_date')
            ->orderBy('start_time')
            ->get();
    }
    #[Computed]
    public function getAssignmentsProperty()
    {
        // if (!$this->student || !$this->student->classe_id) {
        //     return collect();
        // }
        if (!$this->student?->classe?->id) {
            return collect();
        }

        $startDate = $this->getViewStartDate();
        $endDate = $this->getViewEndDate();

        return Assignment::where('class_id', $this->student->classe->id)
            ->where('status', 'published')
            ->whereBetween('due_date', [$startDate, $endDate])
            ->with(['subject'])
            ->get();
    }

    public function getViewStartDate()
    {
        $date = Carbon::parse($this->currentDate);

        return match ($this->viewMode) {
            'month' => $date->copy()->startOfMonth()->startOfWeek(),
            'week' => $date->copy()->startOfWeek(),
            'agenda' => $date,
            default => $date,
        };
    }

    public function getViewEndDate()
    {
        $date = Carbon::parse($this->currentDate);

        return match ($this->viewMode) {
            'month' => $date->copy()->endOfMonth()->endOfWeek(),
            'week' => $date->copy()->endOfWeek(),
            'agenda' => $date->copy()->addDays(30),
            default => $date,
        };
    }

    public function previousPeriod()
    {
        $date = Carbon::parse($this->currentDate);

        $newDate = match ($this->viewMode) {
            'month' => $date->subMonth(),
            'week' => $date->subWeek(),
            'agenda' => $date->subDays(30),
            default => $date,
        };

        $this->currentDate = $newDate->format('Y-m-d');
    }

    public function nextPeriod()
    {
        $date = Carbon::parse($this->currentDate);

        $newDate = match ($this->viewMode) {
            'month' => $date->addMonth(),
            'week' => $date->addWeek(),
            'agenda' => $date->addDays(30),
            default => $date,
        };

        $this->currentDate = $newDate->format('Y-m-d');
    }

    public function today()
    {
        $this->currentDate = today()->format('Y-m-d');
    }

    public function changeViewMode($mode)
    {
        $this->viewMode = $mode;
    }

    public function viewEventDetails($eventId)
    {
        $this->selectedEvent = CalendarEvent::with(['classe', 'subject', 'creator'])
            ->find($eventId);
        $this->showDetailModal = true;
    }

    public function closeDetailModal()
    {
        $this->showDetailModal = false;
        $this->selectedEvent = null;
    }

    public function toggleTypeFilter($type)
    {
        if (in_array($type, $this->filterTypes)) {
            $this->filterTypes = array_values(array_diff($this->filterTypes, [$type]));
        } else {
            $this->filterTypes[] = $type;
        }
    }

    public function getEventsForDate($date)
    {
        $events = $this->events->filter(function ($event) use ($date) {
            $eventStart = Carbon::parse($event->start_date);
            $eventEnd = Carbon::parse($event->end_date ?? $event->start_date);

            return $date >= $eventStart->format('Y-m-d') && $date <= $eventEnd->format('Y-m-d');
        });

        $assignments = $this->assignments->filter(function ($assignment) use ($date) {
            return Carbon::parse($assignment->due_date)->format('Y-m-d') === $date;
        });

        return $events->merge($assignments);
    }

    /**
     * Get events and assignments for a specific date.
     */
    // public function getEventsForDate(string $date)
    // {
    //     $searchDate = Carbon::parse($date)->format('Y-m-d');

    //     $filteredEvents = $this->events->filter(function ($event) use ($searchDate) {
    //         $eventStart = Carbon::parse($event->start_date);
    //         $eventEnd = Carbon::parse($event->end_date ?? $event->start_date);

    //         return $searchDate >= $eventStart->format('Y-m-d') &&
    //             $searchDate <= $eventEnd->format('Y-m-d');
    //     });

    //     $filteredAssignments = $this->assignments->filter(function ($assignment) use ($searchDate) {
    //         $dueDate = Carbon::parse($assignment->due_date);
    //         return $dueDate->format('Y-m-d') === $searchDate;
    //     });

    //     return $filteredEvents->merge($filteredAssignments);
    // }


    public function getMonthCalendarData()
    {
        $date = Carbon::parse($this->currentDate);
        $startDate = $date->copy()->startOfMonth()->startOfWeek();
        $endDate = $date->copy()->endOfMonth()->endOfWeek();

        $calendar = [];
        $currentDate = $startDate->copy();

        while ($currentDate <= $endDate) {
            $week = [];
            for ($i = 0; $i < 7; $i++) {
                $week[] = [
                    'date' => $currentDate->format('Y-m-d'),
                    'day' => $currentDate->day,
                    'isCurrentMonth' => $currentDate->month === $date->month,
                    'isToday' => $currentDate->isToday(),
                    'events' => $this->getEventsForDate($currentDate->format('Y-m-d')),
                ];
                $currentDate->addDay();
            }
            $calendar[] = $week;
        }

        return $calendar;
    }

    // public function getUpcomingEventsProperty()
    // {
    //     $events = CalendarEvent::where('class_id', $this->student->classe_id)
    //         ->where('start_date', '>=', today())
    //         ->orderBy('start_date')
    //         ->orderBy('start_time')
    //         ->limit(5)
    //         ->get();

    //     $assignments = Assignment::where('class_id', $this->student->classe_id)
    //         ->where('status', 'published')
    //         ->where('due_date', '>=', today())
    //         ->orderBy('due_date')
    //         ->limit(5)
    //         ->get();

    //     return $events->merge($assignments)->sortBy('start_date')->take(8);
    // }
    /**
     * Get upcoming events and assignments for the student.
     * 
     * @return \Illuminate\Support\Collection
     */

    #[Computed] // ✅ Ajouter cet attribut
    public function getUpcomingEventsProperty()
    {
        try {
            // Vérifier que l'étudiant et sa classe existent
            if (!$this->student || !$this->student->classe) {
                return collect();
            }

            $classId = $this->student->classe->id;

            $events = CalendarEvent::where('class_id', $classId)
                ->where('start_date', '>=', today())
                ->orderBy('start_date')
                ->orderBy('start_time')
                ->limit(5)
                ->get();

            $assignments = Assignment::where('class_id', $classId)
                ->where('status', 'published')
                ->where('due_date', '>=', today())
                ->orderBy('due_date')
                ->limit(5)
                ->get();

            // Fusionner et trier
            return $events->merge($assignments)
                ->sortBy(function ($item) {
                    return $item->start_date ?? $item->due_date;
                })
                ->take(8);

        } catch (\Exception $e) {
            // Log l'erreur et retourner une collection vide
            \Log::error('Error fetching upcoming events: ' . $e->getMessage());
            return collect();
        }
    }

    public function render()
    {
        $calendarData = $this->viewMode === 'month' ? $this->getMonthCalendarData() : null;

        return view('livewire.student.sudent-calendar', [
            'calendarData' => $calendarData,
            'upcomingEvents' => $this->upcomingEvents,
        ]);
    }
}