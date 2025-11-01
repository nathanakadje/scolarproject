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
        Schema::create('peer_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('assignment_submissions')->onDelete('cascade');
            $table->foreignId('reviewer_id')->constrained('students')->onDelete('cascade');
            $table->decimal('rating', 3, 2)->nullable(); // 0-5 stars
            $table->text('review_text')->nullable();
            $table->json('criteria_scores')->nullable();
            $table->enum('status', ['pending', 'completed'])->default('pending');
            $table->dateTime('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peer_reviews');
    }
};
