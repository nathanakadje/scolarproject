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
        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('group_id')->nullable()->constrained('assignment_groups')->onDelete('cascade');
            $table->text('submission_text')->nullable();
            $table->json('files')->nullable(); // Array of file paths
            $table->dateTime('submitted_at');
            $table->boolean('is_late')->default(false);
            $table->integer('submission_attempt')->default(1);
            $table->enum('status', ['submitted', 'graded', 'returned', 'resubmit'])->default('submitted');
            $table->decimal('grade', 5, 2)->nullable();
            $table->decimal('adjusted_grade', 5, 2)->nullable(); // After late penalty
            $table->text('teacher_feedback')->nullable();
            $table->json('rubric_scores')->nullable();
            $table->dateTime('graded_at')->nullable();
            $table->foreignId('graded_by')->nullable()->constrained('teachers')->onDelete('set null');
            $table->text('student_comment')->nullable();
            $table->integer('time_spent')->nullable(); // en minutes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignment_submissions');
    }
};
