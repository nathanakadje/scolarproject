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
        Schema::create('administrative_deadlines', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->date('deadline_date');
            $table->time('deadline_time')->nullable();

            $table->enum('category', [
                'grades_submission',      // Saisie des notes
                'reports',                // Rapports
                'bulletin_closure',       // Clôture bulletins
                'meeting',                // Réunion obligatoire
                'document_submission',    // Dépôt de documents
                'planning'                // Planning
            ]);

            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('high');
            $table->boolean('is_mandatory')->default(true);

            // Relations
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->json('concerned_teachers')->nullable(); // IDs des profs concernés

            // Statut de complétion
            $table->json('completion_status')->nullable(); // {user_id: completed_at}

            $table->timestamps();

            $table->index(['deadline_date', 'category']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administrative_deadlines');
    }
};
