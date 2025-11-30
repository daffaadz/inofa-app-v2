<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('consumer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('developer_id')->constrained('users')->onDelete('cascade');
            $table->tinyInteger('rating');
            $table->text('comment')->nullable();
            $table->json('rating_breakdown')->nullable();
            $table->boolean('is_public')->default(true);
            $table->timestamps();

            $table->unique(['project_id', 'consumer_id']);
            $table->index(['developer_id', 'rating']);
            $table->index('consumer_id');
            $table->index(['rating', 'created_at']);
            $table->index(['developer_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
