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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            // Tugas milik proyek mana
            $table->foreignId('project_id')
                ->constrained('projects')
                ->onDelete('cascade');

            // Tugas bisa ditugaskan ke user tertentu (boleh null)
            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');

            $table->string('title');               // Judul tugas
            $table->text('description')->nullable(); // Deskripsi tugas

            // Status task
            $table->string('status')->default('todo'); // todo / in_progress / done

            // Deadline task
            $table->date('deadline')->nullable();

            // Prioritas (1 rendah - 3 tinggi) – boleh kita pakai nanti untuk filter
            $table->unsignedTinyInteger('priority')->default(2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
