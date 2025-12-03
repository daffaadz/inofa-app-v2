<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_agreements', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->foreignId('project_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('project_title')->comment('Judul project');
            $table->foreignId('consumer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('developer_id')->constrained('users')->onDelete('cascade');
            $table->string('client_name')->nullable();
            $table->decimal('final_price', 15, 2)->default(0.00);
            $table->json('price_details')->nullable()->comment('Breakdown harga');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status', ['pending', 'accepted', 'active', 'completed', 'terminated', 'disputed'])->default('pending');
            $table->longText('terms')->nullable();
            $table->longText('scope_projects')->nullable();
            $table->json('projects_mvp')->nullable();
            $table->integer('progress')->default(0)->comment('Progress percentage (0-100)');
            $table->json('deliverables')->nullable();
            $table->timestamp('signed_at')->nullable();
            $table->foreignId('conversation_id')->nullable();
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_agreements');
    }
};
