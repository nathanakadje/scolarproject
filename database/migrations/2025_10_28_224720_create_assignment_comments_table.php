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
        Schema::create('assignment_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained()->onDelete('cascade');
            $table->foreignId('submission_id')->nullable()->constrained('assignment_submissions')->onDelete('cascade');
            $table->morphs('commentable'); // Teacher or Student
            $table->text('comment');
            $table->foreignId('parent_id')->nullable()->constrained('assignment_comments')->onDelete('cascade');
            $table->boolean('is_private')->default(false); // Only teacher can see
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignment_comments');
    }
};
