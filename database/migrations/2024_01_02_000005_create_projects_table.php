<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consumer_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->decimal('budget', 15, 2);
            $table->date('deadline');
            $table->enum('status', ['draft', 'open', 'in_progress', 'completed', 'cancelled'])->default('open');
            $table->integer('views_count')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->json('requirements')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index(['consumer_id', 'status']);
            $table->index(['budget', 'deadline']);
            $table->index(['is_featured', 'status']);
            $table->index(['deadline', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
