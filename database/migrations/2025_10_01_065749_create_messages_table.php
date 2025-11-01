<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('body')->nullable(); // isi pesan (optional kalau type=file/image/system)
            $table->enum('type', ['text', 'file', 'image', 'system'])->default('text');
            $table->string('attachment')->nullable(); // file path / url
            $table->json('metadata')->nullable(); // info tambahan: size, mimetype, reply-to, dsb
            $table->timestamp('deleted_at')->nullable(); // soft delete untuk pesan (opsional)
            $table->timestamps();

            // Indexes
            $table->index(['conversation_id', 'created_at'], 'msg_conv_created_idx'); // pagination & unread
            $table->index(['conversation_id', 'id'], 'msg_conv_id_idx');              // seek pagination
            $table->index(['user_id', 'created_at'], 'msg_user_created_idx');         // pesan milik user
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
