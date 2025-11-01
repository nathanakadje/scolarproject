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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('instructions')->nullable();
            $table->enum('type', ['homework', 'project', 'exercise', 'research', 'presentation'])->default('homework');
            $table->enum('difficulty', ['easy', 'medium', 'hard', 'expert'])->default('medium');
            $table->decimal('max_points', 5, 2)->default(20.00);
            $table->dateTime('assigned_date');
            $table->dateTime('due_date');
            $table->dateTime('late_submission_date')->nullable();
            $table->integer('estimated_duration')->nullable(); // en minutes
            $table->boolean('allow_late_submission')->default(true);
            $table->decimal('late_penalty_percent', 5, 2)->default(10.00);
            $table->boolean('allow_file_upload')->default(true);
            $table->boolean('allow_text_submission')->default(true);
            $table->json('allowed_file_types')->nullable(); // ['pdf', 'docx', etc.]
            $table->integer('max_file_size')->default(10240); // en KB
            $table->integer('max_files')->default(5);
            $table->boolean('group_assignment')->default(false);
            $table->integer('max_group_size')->nullable();
            $table->boolean('peer_review_enabled')->default(false);
            $table->integer('peer_reviews_required')->default(2);
            $table->boolean('auto_grade')->default(false);
            $table->json('rubric')->nullable(); // Grille d'évaluation
            $table->enum('status', ['draft', 'published', 'active', 'closed', 'archived'])->default('draft');
            $table->boolean('send_reminders')->default(true);
            $table->integer('reminder_days_before')->default(2);
            $table->text('resources_links')->nullable();
            $table->integer('submission_count')->default(0);
            $table->integer('graded_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
