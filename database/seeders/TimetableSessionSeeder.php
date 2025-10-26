<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TimetableSession;

class TimetableSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academicYear = '2025-2026';

        TimetableSession::create([
            'teacher_id' => 1,
            'class_id' => 1,
            'subject_id' => 1,
            'day_of_week' => 'monday',
            'start_time' => '08:00',
            'end_time' => '10:00',
            'room' => 'A12',
            'building' => 'Bloc A',
            'valid_from' => '2025-09-01',
            'valid_until' => '2026-06-30',
            'academic_year' => $academicYear,
            'semester' => '1',
            'session_type' => 'course',
            'notes' => 'Cours de mathématiques générales',
        ]);

        TimetableSession::create([
            'teacher_id' => 1,
            'class_id' => 2,
            'subject_id' => 3,
            'day_of_week' => 'wednesday',
            'start_time' => '14:00',
            'end_time' => '16:00',
            'room' => 'B05',
            'building' => 'Bloc B',
            'valid_from' => '2025-09-01',
            'valid_until' => '2026-06-30',
            'academic_year' => $academicYear,
            'semester' => '2',
            'session_type' => 'tp',
            'notes' => 'Travaux pratiques sur les circuits électriques',
        ]);


    }
}
