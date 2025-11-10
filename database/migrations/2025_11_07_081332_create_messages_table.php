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
        //new table for messages
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();

            $table->enum('type', ['text', 'file', 'image', 'system', 'proposal'])->default('text');
            $table->text('body')->nullable();
            $table->json('payload')->nullable(); // untuk data seperti proposal, kontrak, atau reply
            $table->timestamp('sent_at')->useCurrent();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['conversation_id', 'sent_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_messages');
    }
};
