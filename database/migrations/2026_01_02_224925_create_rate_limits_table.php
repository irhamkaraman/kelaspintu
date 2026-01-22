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
        Schema::create('rate_limits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Nullable for guest users
            $table->string('action_type'); // e.g., 'create_kelas', 'register_user'
            $table->string('ip_address', 45);
            $table->json('metadata')->nullable();
            $table->timestamp('created_at');
            
            // Indexes for performance
            $table->index(['user_id', 'action_type', 'created_at']);
            $table->index(['ip_address', 'action_type', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rate_limits');
    }
};
