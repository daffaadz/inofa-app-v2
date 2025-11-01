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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            $table->enum('role', ['consumer','developer','admin'])->default('consumer');
            $table->string('avatar')->nullable(); // konsisten untuk Chatify & profile
            $table->text('bio')->nullable();
            $table->string('location')->nullable();

            // Chatify
            $table->boolean('dark_mode')->default(false);
            $table->string('messenger_color')->default('#5aa07f');
            $table->boolean('active_status')->default(true);

            // Social login
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();

            $table->timestamps();

            // Indexes
            $table->index(['role','active_status']);
            $table->index(['email_verified_at']);
            $table->index(['created_at']);
            $table->index(['provider','provider_id'],'users_provider_provider_id_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
