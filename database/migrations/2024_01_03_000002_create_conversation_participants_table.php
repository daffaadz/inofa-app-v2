<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversation_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('role', ['admin', 'participant'])->default('participant');
            $table->timestamp('joined_at')->useCurrent();
            $table->timestamp('last_read_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->timestamp('last_sent_at')->nullable();

            $table->unique(['conversation_id', 'user_id']);
            $table->index(['conversation_id', 'last_read_at']);
            $table->index(['user_id', 'is_active']);
            $table->index('last_read_at');
            $table->index('last_sent_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversation_participants');
    }
};
