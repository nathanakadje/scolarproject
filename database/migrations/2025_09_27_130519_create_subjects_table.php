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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Mathématiques, Français, etc.
            $table->string('code')->unique(); // MATH, FR
            $table->text('description')->nullable();
            $table->integer('coefficient')->default(1); // Coefficient pour les notes
            $table->string('color', 7)->default('#3490dc'); // Couleur pour l'interface
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
