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

            // Supprimer la colonne
            $table->dropColumn('academic_year_id'); // ou 'academic_years_id'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('timetable_sessions', function (Blueprint $table) {
            //
            $table->foreignId('academic_year_id')->constrained()->onDelete('cascade');

        });
    }
};
