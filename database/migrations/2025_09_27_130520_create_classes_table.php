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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 6ème, 5ème, CM2, etc.
            $table->string('code')->unique(); // 6E, 5E, CM2
            $table->foreignId('academic_level_id')->constrained()->onDelete('cascade');
            $table->integer('capacity')->default(40); // Capacité max
            $table->decimal('school_fees', 10, 2)->default(0); // Frais de scolarité
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
