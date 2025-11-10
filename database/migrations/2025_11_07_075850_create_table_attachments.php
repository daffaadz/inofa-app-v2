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
        Schema::create('attachments', function (Blueprint $t) {
            $t->id();
            $t->foreignId('message_id')->constrained()->cascadeOnDelete();
            $t->string('disk')->default('public');
            $t->string('path');                     // storage path
            $t->string('original_name');
            $t->string('mime', 191)->nullable();
            $t->unsignedBigInteger('size')->nullable();
            $t->timestamps();

            $t->index('message_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_attachments');
    }
};
