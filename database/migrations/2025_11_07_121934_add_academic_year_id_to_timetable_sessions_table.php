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
        Schema::table('timetable_sessions', function (Blueprint $table) {
            //
            $table->foreignId('academic_year_id')
                ->constrained('academic_years') // Référence la table academic_years
                ->onDelete('cascade') // Supprime les sessions si l'année académique est supprimée
                ->after('subject_id')->nullable(); // Position optionnelle dans la table
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('timetable_sessions', function (Blueprint $table) {
            //
            $table->dropForeign(['academic_year_id']);
            $table->dropColumn('academic_year_id');
        });
    }
};
