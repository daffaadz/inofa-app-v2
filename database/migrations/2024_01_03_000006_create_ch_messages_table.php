<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ch_messages', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->bigInteger('from_id');
            $table->bigInteger('to_id');
            $table->unsignedBigInteger('conversation_id')->nullable();
            $table->string('body', 5000)->nullable();
            $table->string('attachment')->nullable();
            $table->char('project_agreement_id', 36)->nullable();
            $table->text('metadata')->nullable();
            $table->boolean('seen')->default(false);
            $table->timestamps();

            $table->foreign('conversation_id')->references('id')->on('conversations')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ch_messages');
    }
};
