<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_disputes', function (Blueprint $table) {
            $table->id();
            $table->char('project_agreement_id', 36)->nullable();
            $table->foreignId('raised_by')->constrained('users');
            $table->enum('status', ['open', 'under_review', 'resolved', 'closed'])->default('open');
            $table->text('issue');
            $table->text('resolution')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();

            $table->index('raised_by');
            $table->index('project_agreement_id');
            $table->foreign('project_agreement_id')->references('id')->on('project_agreements')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_disputes');
    }
};
