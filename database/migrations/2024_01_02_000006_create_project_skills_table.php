<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('skill_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('required_level')->default(2)->comment('1=Beginner, 2=Intermediate, 3=Advanced, 4=Expert');
            $table->timestamps();

            $table->unique(['project_id', 'skill_id']);
            $table->index(['skill_id', 'required_level']);
            $table->index('project_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_skills');
    }
};
