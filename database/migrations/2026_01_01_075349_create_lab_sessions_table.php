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
        Schema::create('lab_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->enum('bahasa_pemrograman', ['c', 'cpp', 'java', 'python', 'php', 'javascript']);
            $table->text('template_code')->nullable();
            $table->json('test_cases')->nullable()->comment('Format: {"input": "...", "expected_output": "..."}');
            $table->dateTime('deadline')->nullable();
            $table->timestamps();
            
            $table->index('kelas_id');
            $table->index('deadline');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_sessions');
    }
};
