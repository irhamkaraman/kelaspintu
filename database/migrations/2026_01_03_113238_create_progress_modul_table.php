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
        Schema::create('progress_modul', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('sub_modul_id')->constrained('sub_modul')->onDelete('cascade');
            $table->boolean('selesai')->default(false);
            $table->timestamp('waktu_selesai')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'sub_modul_id']);
            $table->index(['user_id', 'selesai']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress_modul');
    }
};
