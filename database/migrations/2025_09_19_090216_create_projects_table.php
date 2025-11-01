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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consumer_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->decimal('budget', 15, 2);
            $table->date('deadline');
            $table->enum('status',['draft','open','in_progress','completed','cancelled'])->default('open');
            $table->integer('views_count')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->json('requirements')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']); // List active projects
            $table->index(['consumer_id', 'status']); // Consumer's projects
            $table->index(['budget', 'deadline']); // Filter by budget/timeline
            $table->index(['is_featured', 'status']); // Featured projects
            $table->index(['deadline', 'status']); // Urgent projects

        });
        DB::statement('ALTER TABLE projects ADD CONSTRAINT chk_projects_budget CHECK (budget >= 0)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
