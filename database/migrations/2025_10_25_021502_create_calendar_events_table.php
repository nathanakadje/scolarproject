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
        Schema::create('calendar_events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');

            // Type d'événement
            $table->enum('type', [
                'evaluation',       // Devoir, examen, quiz
                'course',          // Séance de cours
                'meeting',         // Réunion
                'deadline',        // Date limite
                'holiday',         // Vacances
                'event',           // Événement scolaire
                'personal',        // Personnel
                'revision',        // Révision/rattrapage
                'trip',            // Sortie/voyage
                'ceremony',        // Cérémonie
                'parent_meeting',  // Rencontre parents
                'pedagogical'      // Journée pédagogique
            ])->default('event');

            // Dates et heures
            $table->date('start_date');
            $table->time('start_time')->nullable();
            $table->date('end_date')->nullable();
            $table->time('end_time')->nullable();
            $table->boolean('all_day')->default(false);

            // Relations optionnelles
            $table->foreignId('class_id')->nullable()->constrained('classes')->onDelete('cascade');
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->onDelete('set null');
            $table->foreignId('evaluation_id')->nullable()->constrained('evaluations')->onDelete('cascade');
            $table->string('location')->nullable(); // Salle, lieu

            // Apparence
            $table->string('color')->default('#10B981'); // Couleur personnalisable
            $table->string('icon')->nullable();

            // Récurrence
            $table->boolean('is_recurring')->default(false);
            $table->enum('recurrence_type', ['daily', 'weekly', 'monthly', 'yearly'])->nullable();
            $table->integer('recurrence_interval')->default(1)->nullable();
            $table->date('recurrence_end_date')->nullable();

            // Rappels
            $table->boolean('has_reminder')->default(false);
            $table->integer('reminder_minutes')->nullable(); // Minutes avant l'événement

            // Visibilité et statut
            $table->enum('visibility', ['private', 'public', 'shared'])->default('private');
            $table->enum('status', ['scheduled', 'completed', 'cancelled', 'postponed'])->default('scheduled');

            // Participants (JSON)
            $table->json('participants')->nullable(); // IDs des profs/classes concernés

            // Priorité
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');

            // Notes et pièces jointes
            $table->text('notes')->nullable();
            $table->json('attachments')->nullable();

            $table->timestamps();

            // Index pour performance
            $table->index(['start_date', 'created_by']);
            $table->index(['type', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendar_events');
    }
};
