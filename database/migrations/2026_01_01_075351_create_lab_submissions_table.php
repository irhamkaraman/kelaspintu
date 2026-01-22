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
        Schema::create('lab_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lab_session_id')->constrained('lab_sessions')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('source_code');
            $table->string('language', 50);
            $table->enum('status', ['pending', 'passed', 'failed', 'error'])->default('pending');
            $table->text('output')->nullable();
            $table->text('error_message')->nullable();
            $table->float('execution_time')->nullable()->comment('in seconds');
            $table->integer('memory_used')->nullable()->comment('in KB');
            $table->integer('score')->default(0);
            $table->json('test_results')->nullable();
            $table->timestamps();
            
            $table->index(['lab_session_id', 'user_id']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_submissions');
    }
};
