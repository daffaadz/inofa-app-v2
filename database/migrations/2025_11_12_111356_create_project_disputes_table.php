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
        Schema::create('project_disputes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_agreement_id')->constrained()->onDelete('cascade');
            $table->foreignId('raised_by')->constrained('users');
            $table->enum('status',['open','under_review','resolved','closed'])->default('open');
            $table->text('issue');
            $table->text('resolution')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_disputes');
    }
};
