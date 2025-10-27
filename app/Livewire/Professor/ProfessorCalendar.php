<?php

namespace App\Livewire\Professor;

use App\Models\Teacher;
use App\Models\CalendarEvent;
use App\Models\TimetableSession;
use App\Models\AdministrativeDeadline;
use App\Traits\HasToastNotifications;
use App\Models\Classe;
use App\Models\Subject;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Carbon\Carbon;

#[Layout('layouts.professor-layout')]
class ProfessorCalendar extends Component
{
    use HasToastNotifications;

    public $selectedDate = null;

    public $teacher;

    // View mode
    public $viewMode = 'month'; // month, week, day, agenda
    public $currentDate;

    // Event modal
    public $showEventModal = false;
    public $showDetailModal = false;
    public $selectedEvent = null;

    // Create/Edit event
    public $eventId = null;
    public $eventTitle = '';
    public $eventDescription = '';
    public $eventType = 'event';
    public $eventStartDate;
    public $eventStartTime = '';
    public $eventEndDate;
    public $eventEndTime = '';
    public $eventAllDay = false;
    public $eventClassId = null;
    public $eventSubjectId = null;
    public $eventLocation = '';
    public $eventColor = '#10B981';
    public $eventPriority = 'medium';
    public $eventHasReminder = false;
    public $eventReminderMinutes = 30;
    public $eventNotes = '';

    // Filters
    public $filterTypes = [];
    public $filterClasses = [];
    public $showTimetable = true;
    public $showDeadlines = true;

    public function mount()
    {
        $this->teacher = Teacher::where('user_id', auth()->id())->first();

        if (!$this->teacher) {
            $this->toastsuccess(" Profil professeur non trouvé");
            // session()->flash('error', 'Profil professeur non trouvé');
            return redirect()->route('professor.dashboard');
        }

        $this->currentDate = today()->format('Y-m-d');
        $this->eventStartDate = today()->format('Y-m-d');
        $this->eventEndDate = today()->format('Y-m-d');

        // Initialize filters with all types selected
        $this->filterTypes = [
            'evaluation',
            'course',
            'meeting',
            'deadline',
            'holiday',
            'event',
            'personal',
            'revision',
            'trip',
            'ceremony',
            'parent_meeting',
            'pedagogical'
        ];
    }
    public function selectDate($date)
    {
        $this->selectedDate = $date;
    }
    #[Computed]
    public function classes()
    {
        return $this->teacher->getCurrentClasses();
    }

    #[Computed]
    public function subjects()
    {
        return $this->teacher->subjects()->distinct()->get();
    }

    #[Computed]
    public function events()
    {
        $startDate = $this->getViewStartDate();
        $endDate = $this->getViewEndDate();

        $query = CalendarEvent::forTeacher($this->teacher->user_id)
            ->inDateRange($startDate, $endDate)
            ->with(['classe', 'subject', 'evaluation']);

        // Apply type filters
        if (!empty($this->filterTypes)) {
            $query->whereIn('type', $this->filterTypes);
        }

        // Apply class filters
        if (!empty($this->filterClasses)) {
            $query->whereIn('class_id', $this->filterClasses);
        }

        return $query->orderBy('start_date')
            ->orderBy('start_time')
            ->get();
    }

    #[Computed]
    public function timetableSessions()
    {
        if (!$this->showTimetable)
            return collect();

        return TimetableSession::where('teacher_id', $this->teacher->id)
            ->active()
            ->with(['classe', 'subject'])
            ->get();
    }

    #[Computed]
    public function administrativeDeadlines()
    {
        if (!$this->showDeadlines)
            return collect();

        return AdministrativeDeadline::where(function ($query) {
            $query->whereJsonContains('concerned_teachers', $this->teacher->id)
                ->orWhereNull('concerned_teachers');
        })
            ->upcoming()
            ->get();
    }

    public function getViewStartDate()
    {
        $date = Carbon::parse($this->currentDate);

        return match ($this->viewMode) {
            'month' => $date->copy()->startOfMonth()->startOfWeek(),
            'week' => $date->copy()->startOfWeek(),
            'day' => $date,
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
            'day' => $date,
            'agenda' => $date->copy()->addDays(30),
            default => $date,
        };
    }

    // public function previousPeriod()
    // {
    //     $date = Carbon::parse($this->currentDate);

    //     $this->currentDate = match($this->viewMode) {
    //         'month' => $date->subMonth(),
    //         'week' => $date->subWeek(),
    //         'day' => $date->subDay(),
    //         'agenda' => $date->subDays(30),
    //         default => $date,
    //     }->format('Y-m-d');
    // }
    public function previousPeriod()
    {
        $date = Carbon::parse($this->currentDate);

        $newDate = match ($this->viewMode) {
            'month' => $date->subMonth(),
            'week' => $date->subWeek(),
            'day' => $date->subDay(),
            'agenda' => $date->subDays(30),
            default => $date,
        };

        $this->currentDate = $newDate->format('Y-m-d');
    }

    public function nextPeriod()
    {
        $date = Carbon::parse($this->currentDate);

        $nexDate = match ($this->viewMode) {
            'month' => $date->addMonth(),
            'week' => $date->addWeek(),
            'day' => $date->addDay(),
            'agenda' => $date->addDays(30),
            default => $date,
        };

        $this->currentDate = $nexDate->format('Y-m-d');
    }

    public function today()
    {
        $this->currentDate = today()->format('Y-m-d');
    }

    public function changeViewMode($mode)
    {
        $this->viewMode = $mode;
    }

    public function openEventModal()
    {
        $this->resetEventForm();
        $this->showEventModal = true;
    }

    public function editEvent($eventId)
    {
        $event = CalendarEvent::find($eventId);

        if (!$event || $event->created_by !== $this->teacher->user_id) {
            return;
        }

        $this->eventId = $event->id;
        $this->eventTitle = $event->title;
        $this->eventDescription = $event->description;
        $this->eventType = $event->type;
        $this->eventStartDate = Carbon::parse($event->start_date)->format('Y-m-d');
        // $this->eventStartDate = $event->start_date->format('Y-m-d');
        $this->eventStartTime = $event->start_time ?? '';
        // $this->eventEndDate = $event->end_date ? $event->end_date->format('Y-m-d') : $event->start_date->format('Y-m-d');
        $this->eventEndDate = $event->end_date
            ? Carbon::parse($event->end_date)->format('Y-m-d')
            : Carbon::parse($event->start_date)->format('Y-m-d');
        $this->eventEndTime = $event->end_time ?? '';
        $this->eventAllDay = $event->all_day;
        $this->eventClassId = $event->class_id;
        $this->eventSubjectId = $event->subject_id;
        $this->eventLocation = $event->location ?? '';
        $this->eventColor = $event->color;
        $this->eventPriority = $event->priority;
        $this->eventHasReminder = $event->has_reminder;
        $this->eventReminderMinutes = $event->reminder_minutes ?? 30;
        $this->eventNotes = $event->notes ?? '';

        $this->showEventModal = true;
    }

    public function saveEvent()
    {
        $this->validate([
            'eventTitle' => 'required|string|max:255',
            'eventType' => 'required',
            'eventStartDate' => 'required|date',
            'eventColor' => 'required|string',
        ]);

        $data = [
            'title' => $this->eventTitle,
            'description' => $this->eventDescription,
            'type' => $this->eventType,
            'start_date' => $this->eventStartDate,
            'start_time' => $this->eventAllDay ? null : ($this->eventStartTime ?: null),
            'end_date' => $this->eventEndDate ?: $this->eventStartDate,
            'end_time' => $this->eventAllDay ? null : ($this->eventEndTime ?: null),
            'all_day' => $this->eventAllDay,
            'class_id' => $this->eventClassId,
            'subject_id' => $this->eventSubjectId,
            'location' => $this->eventLocation,
            'color' => $this->eventColor,
            'priority' => $this->eventPriority,
            'has_reminder' => $this->eventHasReminder,
            'reminder_minutes' => $this->eventHasReminder ? $this->eventReminderMinutes : null,
            'notes' => $this->eventNotes,
            'created_by' => $this->teacher->user_id,
        ];

        if ($this->eventId) {
            $event = CalendarEvent::find($this->eventId);
            if ($event && $event->created_by === $this->teacher->user_id) {
                $event->update($data);
                $this->toastsuccess("Événement modifié avec succès");

                // session()->flash('success', 'Événement modifié avec succès');
            }
        } else {
            CalendarEvent::create($data);
            $this->toastsuccess("Événement créé avec succès");
            // session()->flash('success', 'Événement créé avec succès');
        }

        $this->closeEventModal();
    }

    public function viewEventDetails($eventId)
    {
        $this->selectedEvent = CalendarEvent::with(['classe', 'subject', 'evaluation', 'creator'])
            ->find($eventId);
        $this->showDetailModal = true;
    }
    public function confirmDelete($eventId)
    {
        $this->dispatch('confirm-delete', eventId: $eventId);
    }

    public function deleteEvent($eventId)
    {
        $event = CalendarEvent::find($eventId);

        if ($event && $event->created_by === $this->teacher->user_id) {
            $event->delete();
            $this->dispatch('event-deleted', id: $eventId);
            $this->toastsuccess(" Supprimé avec succès");
        } else {
            $this->toasterror(" Une erreur est survenue lors de la suppression ");
        }
        $this->closeDetailModal();
    }

    public function closeEventModal()
    {
        $this->showEventModal = false;
        $this->resetEventForm();
    }

    public function closeDetailModal()
    {
        $this->showDetailModal = false;
        $this->selectedEvent = null;
    }

    public function resetEventForm()
    {
        $this->eventId = null;
        $this->eventTitle = '';
        $this->eventDescription = '';
        $this->eventType = 'event';
        $this->eventStartDate = today()->format('Y-m-d');
        $this->eventStartTime = '';
        $this->eventEndDate = today()->format('Y-m-d');
        $this->eventEndTime = '';
        $this->eventAllDay = false;
        $this->eventClassId = null;
        $this->eventSubjectId = null;
        $this->eventLocation = '';
        $this->eventColor = '#10B981';
        $this->eventPriority = 'medium';
        $this->eventHasReminder = false;
        $this->eventReminderMinutes = 30;
        $this->eventNotes = '';
    }

    public function toggleTypeFilter($type)
    {
        if (in_array($type, $this->filterTypes)) {
            $this->filterTypes = array_values(array_diff($this->filterTypes, [$type]));
        } else {
            $this->filterTypes[] = $type;
        }
    }

    public function toggleClassFilter($classId)
    {
        if (in_array($classId, $this->filterClasses)) {
            $this->filterClasses = array_values(array_diff($this->filterClasses, [$classId]));
        } else {
            $this->filterClasses[] = $classId;
        }
    }

    public function markDeadlineComplete($deadlineId)
    {
        $deadline = AdministrativeDeadline::find($deadlineId);

        if ($deadline) {
            $deadline->markCompletedBy($this->teacher->id);
            $this->toastsuccess(" Échéance marquée comme complétée");
            // session()->flash('success', 'Échéance marquée comme complétée');
        }
    }

    public function getUpcomingEvents()
    {
        return CalendarEvent::forTeacher($this->teacher->user_id)
            ->upcoming(7)
            ->limit(5)
            ->get();
    }

    public function getEventsForDate($date)
    {
        return $this->events->filter(function ($event) use ($date) {
            $eventStart = Carbon::parse($event->start_date);
            $eventEnd = Carbon::parse($event->end_date ?? $event->start_date);

            return $date >= $eventStart->format('Y-m-d') && $date <= $eventEnd->format('Y-m-d');
        });
    }

    public function getTimetableForDay($dayOfWeek)
    {
        return $this->timetableSessions->where('day_of_week', $dayOfWeek)
            ->sortBy('start_time');
    }

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

    public function exportCalendar($format = 'ics')
    {
        // Logic for export (ICS, PDF)
        session()->flash('info', 'Export en cours de développement');
    }

    public function render()
    {
        $upcomingEvents = $this->getUpcomingEvents();
        $calendarData = $this->viewMode === 'month' ? $this->getMonthCalendarData() : null;

        return view('livewire.professor.professor-calendar', [
            'upcomingEvents' => $upcomingEvents,
            'calendarData' => $calendarData,
        ]);
    }
}