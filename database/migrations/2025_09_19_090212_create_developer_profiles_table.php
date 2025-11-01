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
        Schema::create('developer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->string('headline')->nullable();
            $table->text('experience')->nullable();
            $table->decimal('rate_min_byproject', 15, 2)->nullable();
            $table->decimal('rate_max_byproject', 15, 2)->nullable();
            $table->enum('availability', ['available','busy','unavailable'])->default('available');
            $table->integer('experience_years')->default(0);
            $table->string('education')->nullable();
            $table->text('certifications')->nullable();
            $table->json('portfolio_links')->nullable();
            $table->decimal('rating_average', 3, 2)->default(0);
            $table->integer('rating_count')->default(0);
            $table->integer('projects_completed')->default(0);
            $table->timestamps();

            $table->index(['availability', 'rating_average']);
            $table->index(['rating_average', 'rating_count']);
            $table->index(['rate_min_byproject', 'rate_max_byproject']);
        });

        // Tambahkan constraint pakai raw SQL
        DB::statement('ALTER TABLE developer_profiles ADD CONSTRAINT chk_devprof_rate_range CHECK (rate_min_byproject <= rate_max_byproject)');
        DB::statement('ALTER TABLE developer_profiles ADD CONSTRAINT chk_devprof_experience CHECK (experience_years >= 0)');
        DB::statement('ALTER TABLE developer_profiles ADD CONSTRAINT chk_devprof_rating CHECK (rating_average >= 0 AND rating_average <= 5)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('developer_profiles');
    }
};
