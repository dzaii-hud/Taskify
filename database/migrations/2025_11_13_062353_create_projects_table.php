<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            // Proyek milik user mana (owner)
            $table->foreignId('owner_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->string('name');                 // Nama proyek
            $table->text('description')->nullable(); // Deskripsi proyek

            // Status sederhana dulu
            $table->string('status')->default('ongoing'); // planned / ongoing / completed

            // Deadline proyek (boleh null)
            $table->date('deadline')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
