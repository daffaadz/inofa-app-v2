<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedBigInteger('reserved_at')->nullable();
            $table->unsignedBigInteger('available_at');
            $table->unsignedBigInteger('created_at');

            $table->index(['queue', 'reserved_at']);
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('connection');
            $table->string('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();

            $table->index(['queue', 'failed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('failed_jobs');
    }
};
