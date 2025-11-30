<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ch_favorites', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->bigInteger('user_id');
            $table->bigInteger('favorite_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ch_favorites');
    }
};
