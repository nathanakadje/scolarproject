<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('timetable_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');

            // Jour et heures
            $table->enum('day_of_week', ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']);
            $table->time('start_time');
            $table->time('end_time');

            // Lieu et informations
            $table->string('room');
            $table->string('building')->nullable();

            // Période de validité
            $table->date('valid_from');
            $table->date('valid_until')->nullable();
            $table->string('academic_year');
            $table->enum('semester', ['1', '2', '3'])->nullable();

            // Type de séance
            $table->enum('session_type', ['course', 'td', 'tp', 'permanent', 'support'])->default('course');

            // Statut
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['teacher_id', 'day_of_week']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timetable_sessions');
    }
};
