<?php

// 1. app/Helpers/SchoolHelper.php - Fonctions utilitaires
namespace App\Helpers;

use App\Models\Student;
use App\Models\AcademicYear;
use App\Models\Payment;
use App\Models\Grade;
use App\Models\Attendance;
use Carbon\Carbon;

class SchoolHelper
{
    /**
     * Génère un numéro d'étudiant unique
     */
    public static function generateStudentNumber($year = null)
    {
        $year = $year ?? date('Y');
        $count = Student::whereYear('created_at', $year)->count() + 1;
        return 'STU' . $year . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Génère un numéro de professeur unique
     */
    public static function generateTeacherNumber($year = null)
    {
        $year = $year ?? date('Y');
        $count = \App\Models\Teacher::whereYear('created_at', $year)->count() + 1;
        return 'TEACH' . $year . str_pad($count, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Calcule la moyenne d'un étudiant pour une matière
     */
    public static function calculateStudentSubjectAverage($studentId, $subjectId, $academicYearId = null)
    {
        $query = Grade::whereHas('evaluation', function ($q) use ($subjectId, $academicYearId) {
            $q->where('subject_id', $subjectId);
            if ($academicYearId) {
                $q->where('academic_year_id', $academicYearId);
            }
        })->where('student_id', $studentId);

        $grades = $query->get();

        if ($grades->isEmpty()) {
            return null;
        }

        $totalScore = 0;
        $totalCoefficient = 0;

        foreach ($grades as $grade) {
            $coefficient = $grade->evaluation->subject->coefficient;
            $totalScore += $grade->score * $coefficient;
            $totalCoefficient += $coefficient;
        }

        return $totalCoefficient > 0 ? $totalScore / $totalCoefficient : 0;
    }

    /**
     * Calcule le taux d'assiduité d'un étudiant
     */
    public static function calculateAttendanceRate($studentId, $startDate = null, $endDate = null)
    {
        $query = Attendance::where('student_id', $studentId);

        if ($startDate && $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        }

        $total = $query->count();
        $present = $query->where('status', 'present')->count();

        return $total > 0 ? ($present / $total) * 100 : 0;
    }

    /**
     * Vérifie si les frais de scolarité sont à jour
     */
    public static function areFeesUpToDate($studentId, $academicYearId = null)
    {
        $academicYearId = $academicYearId ?? AcademicYear::current()->first()?->id;

        $enrollment = \App\Models\Enrollment::where('student_id', $studentId)
            ->where('academic_year_id', $academicYearId)
            ->first();

        if (!$enrollment) {
            return false;
        }

        return $enrollment->fees_paid >= $enrollment->fees_due;
    }

    /**
     * Formate un montant en FCFA
     */
    public static function formatCurrency($amount, $currency = 'FCFA')
    {
        return number_format($amount, 0, ',', ' ') . ' ' . $currency;
    }

    /**
     * Calcule l'âge à partir de la date de naissance
     */
    public static function calculateAge($birthDate)
    {
        return Carbon::parse($birthDate)->age;
    }

    /**
     * Génère un bulletin de notes pour un étudiant
     */
    public static function generateReportCard($studentId, $academicYearId = null)
    {
        $student = Student::with(['currentEnrollment.class'])->findOrFail($studentId);
        $academicYearId = $academicYearId ?? AcademicYear::current()->first()?->id;

        $subjects = $student->currentEnrollment->class->subjects;
        $reportCard = [];

        foreach ($subjects as $subject) {
            $average = self::calculateStudentSubjectAverage($studentId, $subject->id, $academicYearId);
            $reportCard[] = [
                'subject' => $subject,
                'average' => $average,
                'coefficient' => $subject->coefficient,
                'grades' => Grade::whereHas('evaluation', function ($q) use ($subject, $academicYearId) {
                    $q->where('subject_id', $subject->id)
                        ->where('academic_year_id', $academicYearId);
                })->where('student_id', $studentId)->with('evaluation')->get()
            ];
        }

        return $reportCard;
    }

    /**
     * Calcule la moyenne générale d'un étudiant
     */
    public static function calculateGeneralAverage($studentId, $academicYearId = null)
    {
        $student = Student::with(['currentEnrollment.class.subjects'])->findOrFail($studentId);
        $subjects = $student->currentEnrollment->class->subjects;

        $totalScore = 0;
        $totalCoefficient = 0;

        foreach ($subjects as $subject) {
            $average = self::calculateStudentSubjectAverage($studentId, $subject->id, $academicYearId);
            if ($average !== null) {
                $totalScore += $average * $subject->coefficient;
                $totalCoefficient += $subject->coefficient;
            }
        }

        return $totalCoefficient > 0 ? $totalScore / $totalCoefficient : 0;
    }
}
