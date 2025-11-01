<?php

namespace App\Livewire\Professor;

use App\Models\ClassModel;
use App\Models\Grade;
use Livewire\Component;
use App\Models\Assignment;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Evaluation;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\computed;

#[Layout('layouts.professor-layout')]
class ProfDashboard extends Component
{
    public function render()
    {
        $teacher = auth()->user()->teacher;
        $classes = $teacher->getCurrentClasses();
        // Statistiques principales
        $stats = [
            'total_classes' => ClassModel::whereHas('teacherAssignments', function ($q) use ($teacher) {
                $q->where('teacher_id', $teacher->id);
            })->count(),

            'total_students' => Student::whereHas('classe', function ($q) use ($teacher) {
                $q->whereHas('teacherAssignments', function ($query) use ($teacher) {
                    $query->where('teacher_id', $teacher->id);
                });
            })->count(),

            'pending_assignments' => Assignment::where('teacher_id', $teacher->id)
                ->where('status', 'published')
                ->where('due_date', '>', now())
                ->count(),

            'assignments_to_grade' => Assignment::where('teacher_id', $teacher->id)
                ->whereHas('submissions', function ($q) {
                    $q->whereNotNull('submitted_at')->whereNull('graded_count');
                })
                ->count(),
        ];

        // Devoirs à venir (prochains 7 jours)
        $upcomingAssignments = Assignment::where('teacher_id', $teacher->id)
            ->where('status', 'published')
            ->whereBetween('due_date', [now(), now()->addDays(7)])
            ->with(['class', 'subject'])
            ->orderBy('due_date', 'asc')
            ->limit(5)
            ->get();

        // Devoirs en retard
        $overdueAssignments = Assignment::where('teacher_id', $teacher->id)
            ->where('status', 'published')
            ->where('due_date', '<', now())
            ->whereHas('submissions', function ($q) {
                $q->whereNull('submitted_at');
            })
            ->with(['class', 'subject'])
            ->orderBy('due_date', 'desc')
            ->limit(5)
            ->get();

        // Devoirs récents à noter
        $toGradeSubmissions = Assignment::where('teacher_id', $teacher->id)
            ->whereHas('submissions', function ($q) {
                $q->whereNotNull('submitted_at')->whereNull('graded_count');
            })
            ->with([
                'class',
                'subject',
                'submissions' => function ($q) {
                    $q->whereNotNull('submitted_at')->whereNull('graded_count')->with('student')->limit(5);
                }
            ])
            ->orderBy('due_date', 'desc')
            ->limit(3)
            ->get();

        // Mes classes
        $myClasses = ClassModel::whereHas('teacherAssignments', function ($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->with('students')->get();

        // Activités récentes
        $recentActivities = $this->getRecentActivities($teacher);

        return view(
            'livewire.professor.prof-dashboard',
            [
                'stats' => $stats,
                'upcomingAssignments' => $upcomingAssignments,
                'overdueAssignments' => $overdueAssignments,
                'toGradeSubmissions' => $toGradeSubmissions,
                'classes' => $classes,
                'recentActivities' => $recentActivities,
            ]

        );
    }
    #[Computed]
    public function class()
    {
        return $this->teacher->getCurrentClasses();
    }
    private function getRecentActivities($teacher)
    {
        $activities = collect();

        // Nouvelles soumissions (dernières 24h)
        $newSubmissions = Assignment::where('teacher_id', $teacher->id)
            ->whereHas('submissions', function ($q) {
                $q->whereNotNull('submitted_at')
                    ->where('submitted_at', '>', now()->subDay());
            })
            ->with([
                'submissions' => function ($q) {
                    $q->whereNotNull('submitted_at')
                        ->where('submitted_at', '>', now()->subDay())
                        ->with('student')
                        ->orderBy('submitted_at', 'desc');
                }
            ])
            ->get();

        foreach ($newSubmissions as $assignment) {
            foreach ($assignment->submissions as $submission) {
                $activities->push([
                    'type' => 'submission',
                    'message' => $submission->student->first_name . ' ' . $submission->student->last_name . ' a soumis le devoir',
                    'assignment' => $assignment->title,
                    'time' => $submission->submitted_at,
                ]);
            }
        }

        return $activities->sortByDesc('time')->take(8);
    }
}