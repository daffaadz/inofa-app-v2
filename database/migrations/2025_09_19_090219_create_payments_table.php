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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_agreement_id')->constrained()->onDelete('cascade');
            $table->decimal('amount',15,2);
            $table->enum('type',['deposit','milestone','final','refund'])->default('deposit');
            $table->string('payment_method')->nullable();
            $table->string('consumer_payment_proof')->nullable();
            $table->enum('status',['pending','confirmed','transferred','failed','refunded'])->default('pending');
            $table->boolean('admin_confirmed')->default(false);
            $table->timestamp('admin_confirmed_at')->nullable();
            $table->boolean('admin_transferred')->default(false);
            $table->timestamp('admin_transferred_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']); // Pending payments
            $table->index(['admin_confirmed', 'admin_transferred']); // Admin workflow
            $table->index(['project_agreement_id', 'status']); // status pembayaran per kontrak
        });
        DB::statement('ALTER TABLE payments ADD CONSTRAINT chk_payments_amount CHECK (amount >= 0)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
