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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('consumer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('developer_id')->constrained('users')->onDelete('cascade');

            $table->tinyInteger('rating'); // 1-5

            $table->text('comment')->nullable();
            $table->json('rating_breakdown')->nullable();
            $table->boolean('is_public')->default(true);
            $table->timestamps();

             $table->unique(['project_id','consumer_id']); // 1 review per consumer per project

            $table->index(['developer_id', 'rating']); // Developer reviews
            $table->index(['consumer_id']); // Consumer reviews
            $table->index(['rating', 'created_at']); // Top reviews
            $table->index(['developer_id', 'created_at']);   // Developer's reviews ordered by date
        });
        DB::statement('ALTER TABLE reviews ADD CONSTRAINT chk_reviews_rating CHECK (rating >= 1 AND rating <= 5)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
