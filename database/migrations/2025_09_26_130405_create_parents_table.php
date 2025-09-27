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
        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('relationship', ['father', 'mother', 'guardian', 'other']);
            $table->string('phone');
            $table->string('phone_2')->nullable();
            $table->string('email')->nullable();
            $table->string('profession')->nullable();
            $table->text('address');
            $table->boolean('is_emergency_contact')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parents');
    }
};
