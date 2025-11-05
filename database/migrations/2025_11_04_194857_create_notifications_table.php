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
        // Vérifier si la table n'existe pas déjà
        if (!Schema::hasTable('notifications')) {

            Schema::create('notifications', function (Blueprint $table) {
                $table->id();
                $table->morphs('notifiable'); // user_id + user_type (Student, Teacher)
                $table->string('type'); // calendar_event, assignment, grade, etc.
                $table->string('title');
                $table->text('message');
                $table->json('data')->nullable(); // Données supplémentaires
                $table->foreignId('related_id')->nullable(); // ID de l'événement/devoir concerné
                $table->string('related_type')->nullable(); // CalendarEvent, Assignment, etc.
                $table->timestamp('read_at')->nullable();
                $table->string('priority')->default('normal'); // low, normal, high, urgent
                $table->string('icon')->nullable(); // Icône à afficher
                $table->string('color')->default('#3B82F6'); // Couleur de la notification
                $table->timestamps();

                // $table->index(['notifiable_type', 'notifiable_id']);
                // $table->index('read_at');
                // Index avec des noms personnalisés pour éviter les conflits
                $table->index(['notifiable_type', 'notifiable_id'], 'idx_notifiable');
                $table->index('read_at', 'idx_read_at');
                $table->index(['type', 'priority'], 'idx_type_priority');
                $table->index('created_at', 'idx_created_at');
            });
        } else {
            // Si la table existe déjà, ajouter les colonnes manquantes
            if (!Schema::hasColumn('notifications', 'icon')) {
                Schema::table('notifications', function (Blueprint $table) {
                    $table->string('icon')->nullable()->after('priority');
                });
            }

            if (!Schema::hasColumn('notifications', 'color')) {
                Schema::table('notifications', function (Blueprint $table) {
                    $table->string('color')->default('#3B82F6')->after('icon');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
