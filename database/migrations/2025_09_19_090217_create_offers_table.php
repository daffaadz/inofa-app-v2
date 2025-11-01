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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // developer
            $table->decimal('proposed_price',15,2);
            $table->date('proposed_deadline');
            $table->text('cover_letter');
            $table->json('milestones')->nullable();
            $table->enum('status',['pending','accepted','rejected','withdrawn'])->default('pending');
            $table->timestamp('accepted_at')->nullable();
            $table->timestamps();
            $table->unique(['project_id','user_id']);

            $table->index(['status', 'created_at']); // Pending offers
            $table->index(['user_id', 'status']); // Developer's offers
            $table->index(['project_id', 'status', 'created_at']); // Project offers
            $table->index(['accepted_at']); // Accepted offers timeline
        });
        DB::statement('ALTER TABLE offers ADD CONSTRAINT chk_offers_price CHECK (proposed_price >= 0)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
