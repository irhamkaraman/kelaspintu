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
        Schema::create('sub_modul', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modul_id')->constrained('modul')->onDelete('cascade');
            $table->string('judul', 200);
            $table->longText('konten'); // Rich text HTML content
            $table->integer('urutan')->default(0);
            $table->integer('estimasi_menit')->nullable();
            
            // File attachments
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->string('link_eksternal')->nullable();
            
            $table->timestamps();
            
            $table->index(['modul_id', 'urutan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_modul');
    }
};
