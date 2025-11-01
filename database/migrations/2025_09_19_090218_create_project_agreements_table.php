<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('project_agreements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('consumer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('developer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('offer_id')->constrained()->onDelete('cascade');
            $table->decimal('final_price',15,2);
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status',['draft','active','completed','terminated','disputed'])->default('draft');
            $table->text('terms')->nullable();
            $table->json('milestones')->nullable();
            $table->timestamp('signed_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'start_date']);   // Cari agreement berdasarkan status & urutan tanggal mulai
            $table->index(['developer_id', 'status']); // Agreement milik developer
            $table->index(['consumer_id', 'status']);  // Agreement milik consumer

        });
        DB::statement('ALTER TABLE project_agreements ADD CONSTRAINT chk_project_agreements_price CHECK (final_price >= 0)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_agreements');
    }
};
