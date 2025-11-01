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
        Schema::create('skill_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('skill_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('proficiency_level')->default(1)->comment('1=Beginner, 2=Intermediate, 3=Advanced, 4=Expert');
            $table->timestamps();
            $table->unique(['user_id','skill_id']);

            $table->index(['skill_id', 'proficiency_level']); // Find experts in skill
            $table->index(['user_id', 'proficiency_level']); // User skills lookup
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skill_user');
    }
};
