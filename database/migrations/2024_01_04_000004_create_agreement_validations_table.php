<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agreement_validations', function (Blueprint $table) {
            $table->id();
            $table->char('project_agreement_id', 36)->nullable();
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamp('validated_at')->nullable();
            $table->timestamps();

            $table->index('admin_id');
            $table->index('project_agreement_id');
            $table->foreign('project_agreement_id')->references('id')->on('project_agreements')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agreement_validations');
    }
};
