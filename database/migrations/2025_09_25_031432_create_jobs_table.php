<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedBigInteger('reserved_at')->nullable();   // pakai BigInt biar aman sampai jauh
            $table->unsignedBigInteger('available_at');              // waktu job boleh dieksekusi
            $table->unsignedBigInteger('created_at');                // waktu job dibuat

            // Index tambahan untuk performa worker queue
            $table->index(['queue','reserved_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
