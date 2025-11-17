<?php

namespace App\Livewire\Student;

use Livewire\Attributes\Computed;
use Livewire\Component;
use App\Models\Student;
use App\Models\TimetableSession;
use Carbon\Carbon;

use Livewire\Attributes\Layout;

#[Layout('layouts.student-layout')]
class Timetable extends Component
{
    public $student;
    public $currentWeek;
    public $viewMode = 'week'; // week or day
    public $selectedDay = null;

    // Mapping des jours
    private $dayMap = [
        'sunday' => 0,
        'monday' => 1,
        'tuesday' => 2,
        'wednesday' => 3,
        'thursday' => 4,
        'friday' => 5,
        'saturday' => 6
    ];

    private $reverseDayMap = [
        0 => 'sunday',
        1 => 'monday',
        2 => 'tuesday',
        3 => 'wednesday',
        4 => 'thursday',
        5 => 'friday',
        6 => 'saturday'
    ];

    public function mount()
    {
        // $this->student = Student::where('user_id', auth()->id())->first();
        // $this->currentWeek = now()->startOfWeek();
        // // Convertir le jour numérique en chaîne pour la sélection
        // $this->selectedDay = $this->reverseDayMap[now()->dayOfWeek];

        // dd($this->selectDay($this->selectedDay));

        // if (!$this->student) {
        //     abort(403, 'Profil étudiant non trouvé');
        // }
        $this->student = Student::where('user_id', auth()->id())->first();

        if (!$this->student) {
            abort(403, 'Profil étudiant non trouvé');
        }

        $this->currentWeek = now()->startOfWeek();

        $dayIndex = now()->dayOfWeek; // 0–6
        $this->selectedDay = $this->reverseDayMap[$dayIndex] ?? 'monday'; // valeur par défaut

        $this->selectDay($this->selectedDay);
        // dd($this->selectedDay);

    }

    #[Computed]
    public function timetableSessions()
    {
        if (!$this->student->class_id) {
            logger()->warning('Student n\'a pas de class_id', [
                'student_id' => $this->student->user_id,
                'class_id' => $this->student->class_id
            ]);


            dd($this->student);

            return collect();
        }

        // Charger la relation classe
        $this->student->load('classe');

        if (!$this->student->classe) {
            logger()->warning('Classe non trouvée pour class_id', [
                'student_id' => $this->student->user_id,
                'class_id' => $this->student->class_id
            ]);
            return collect();
        }

        try {
            $sessions = TimetableSession::where('class_id', $this->student->classe->id)
                ->where('is_active', true)
                ->where('valid_from', '<=', now())
                ->where(function ($query) {
                    $query->where('valid_until', '>=', now())
                        ->orWhereNull('valid_until');
                })
                ->with(['subject', 'teacher', 'classe'])
                ->orderByRaw("
            CASE day_of_week
                WHEN 'monday' THEN 1
                WHEN 'tuesday' THEN 2
                WHEN 'wednesday' THEN 3
                WHEN 'thursday' THEN 4
                WHEN 'friday' THEN 5
                WHEN 'saturday' THEN 6
                WHEN 'sunday' THEN 7
            END
        ")
                ->orderBy('start_time')
                ->get();

            return $sessions;
        } catch (\Exception $e) {
            logger()->error('Erreur emploi du temps : ' . $e->getMessage());
            return collect();
        }



        // try {
        //     $sessions = TimetableSession::where('class_id', $this->student->classe->id)
        //         ->where('is_active', true)
        //         ->where('valid_from', '<=', now())
        //         ->where(function ($query) {
        //             $query->where('valid_until', '>=', now())
        //                 ->orWhereNull('valid_until');
        //         })
        //         ->with(['subject', 'teacher', 'classe'])
        //         ->orderByRaw("FIELD(day_of_week, 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday')")
        //         ->orderBy('start_time')
        //         ->get();

        //     return $sessions;
        // } catch (\Exception $e) {
        //     logger()->error('Erreur emploi du temps : ' . $e->getMessage());
        //     return collect();
        // }
    }

    public function getSessionsForDay($dayOfWeek)
    {
        // Convertir le jour numérique en chaîne si nécessaire
        if (is_numeric($dayOfWeek)) {
            $dayOfWeek = $this->reverseDayMap[$dayOfWeek];
        }

        return $this->timetableSessions
            ->where('day_of_week', $dayOfWeek)
            ->sortBy('start_time');
    }

    #[Computed]
    public function todaySessions()
    {
        $todayString = $this->reverseDayMap[now()->dayOfWeek];
        return $this->getSessionsForDay($todayString);
    }

    #[Computed]
    public function nextSession()
    {
        $now = now();
        $todayString = $this->reverseDayMap[$now->dayOfWeek];
        $currentTime = $now->format('H:i:s');

        return $this->timetableSessions
            ->where('day_of_week', $todayString)
            ->where('start_time', '>', $currentTime)
            ->sortBy('start_time')
            ->first();
    }

    #[Computed]
    public function currentSession()
    {
        $now = now();
        $todayString = $this->reverseDayMap[$now->dayOfWeek];
        $currentTime = $now->format('H:i:s');

        return $this->timetableSessions
            ->where('day_of_week', $todayString)
            ->where('start_time', '<=', $currentTime)
            ->where('end_time', '>=', $currentTime)
            ->first();
    }

    public function previousWeek()
    {
        $this->currentWeek = Carbon::parse($this->currentWeek)->subWeek();
    }

    public function nextWeek()
    {
        $this->currentWeek = Carbon::parse($this->currentWeek)->addWeek();
    }

    public function goToToday()
    {
        $this->currentWeek = now()->startOfWeek();
        $this->selectedDay = $this->reverseDayMap[now()->dayOfWeek];
    }

    public function selectDay($day)
    {
        $this->selectedDay = $day;
        $this->viewMode = 'day';
    }

    public function changeViewMode($mode)
    {
        $this->viewMode = $mode;
    }

    #[Computed]
    public function weekDays()
    {
        $start = Carbon::parse($this->currentWeek);
        $days = [];

        for ($i = 0; $i < 7; $i++) {
            $date = $start->copy()->addDays($i);
            $dayOfWeek = $date->dayOfWeek; // 0-6
            $dayString = $this->reverseDayMap[$dayOfWeek];

            $days[] = [
                'dayOfWeek' => $dayString, // Utiliser la chaîne pour la compatibilité BD
                'dayOfWeekNumeric' => $dayOfWeek, // Garder le numérique pour l'affichage
                'date' => $date->format('Y-m-d'),
                'dayName' => $date->locale('fr')->dayName,
                'dayShort' => $date->locale('fr')->shortDayName,
                'dayNumber' => $date->day,
                'isToday' => $date->isToday(),
            ];
        }

        return $days;
    }

    public function getTimeSlots()
    {
        $slots = [];
        $start = Carbon::parse('07:00');
        $end = Carbon::parse('18:00');

        while ($start < $end) {
            $slots[] = $start->format('H:i');
            $start->addMinutes(30);
        }
        return $slots;
    }

    // #[Computed]
    // public function weekStats()
    // {
    //     $totalHours = 0;
    //     $subjects = [];

    //     foreach ($this->timetableSessions as $session) {
    //         $start = Carbon::parse($session->start_time);
    //         $end = Carbon::parse($session->end_time);
    //         $duration = $start->diffInMinutes($end) / 60;
    //         $totalHours += $duration;

    //         $subjectName = $session->subject->name ?? 'Matière inconnue';
    //         if (!isset($subjects[$subjectName])) {
    //             $subjects[$subjectName] = 0;
    //         }
    //         $subjects[$subjectName] += $duration;
    //     }

    //     return [
    //         'totalHours' => round($totalHours, 1),
    //         'totalCourses' => $this->timetableSessions->count(),
    //         'subjects' => $subjects,
    //     ];
    // }
    #[Computed]
    public function weekStats()
    {
        $totalHours = 0;
        $subjects = [];

        foreach ($this->timetableSessions as $session) {
            $start = Carbon::parse($session->start_time);
            $end = Carbon::parse($session->end_time);
            $duration = $start->diffInMinutes($end) / 60;
            $totalHours += $duration;

            $subjectName = $session->subject->name ?? 'Matière inconnue';
            if (!isset($subjects[$subjectName])) {
                $subjects[$subjectName] = 0;
            }
            $subjects[$subjectName] += $duration;
        }

        // Formater les heures pour arrondir à 1 décimale
        $totalHours = round($totalHours, 1);

        // Formater également chaque matière
        $formattedSubjects = [];
        foreach ($subjects as $subject => $hours) {
            $formattedSubjects[$subject] = round($hours, 1);
        }

        return [
            'totalHours' => $totalHours,
            'totalCourses' => $this->timetableSessions->count(),
            'subjects' => $formattedSubjects,
        ];
    }


    public function render()
    {
        return view('livewire.student.timetable', [
            'weekDays' => $this->weekDays,
            'todaySessions' => $this->todaySessions,
            'nextSession' => $this->nextSession,
            'currentSession' => $this->currentSession,
            'weekStats' => $this->weekStats,
        ]);
    }
}