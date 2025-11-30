<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->char('project_agreement_id', 36)->nullable();
            $table->decimal('amount', 15, 2);
            $table->enum('type', ['deposit', 'milestone', 'final', 'refund'])->default('deposit');
            $table->string('payment_method')->nullable();
            $table->string('consumer_payment_proof')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'transferred', 'failed', 'refunded'])->default('pending');
            $table->boolean('admin_confirmed')->default(false);
            $table->timestamp('admin_confirmed_at')->nullable();
            $table->boolean('admin_transferred')->default(false);
            $table->timestamp('admin_transferred_at')->nullable();
            $table->timestamps();
            $table->string('admin_transfer_proof')->nullable();

            $table->index(['status', 'created_at']);
            $table->index(['admin_confirmed', 'admin_transferred']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
