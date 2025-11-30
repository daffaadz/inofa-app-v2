<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('developer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->string('headline')->nullable();
            $table->text('experience')->nullable();
            $table->decimal('rate_min_byproject', 15, 2)->nullable();
            $table->decimal('rate_max_byproject', 15, 2)->nullable();
            $table->enum('availability', ['available', 'busy', 'unavailable'])->default('available');
            $table->integer('experience_years')->default(0);
            $table->string('education')->nullable();
            $table->text('certifications')->nullable();
            $table->json('portfolio_links')->nullable();
            $table->decimal('rating_average', 3, 2)->default(0.00);
            $table->integer('rating_count')->default(0);
            $table->integer('projects_completed')->default(0);
            $table->timestamps();

            $table->index(['availability', 'rating_average']);
            $table->index(['rating_average', 'rating_count']);
            $table->index(['rate_min_byproject', 'rate_max_byproject']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('developer_profiles');
    }
};
