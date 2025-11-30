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
        Schema::table('developer_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('profile_view_count')->default(0)->after('projects_completed');
            $table->timestamp('last_viewed_at')->nullable()->after('profile_view_count');
            
            $table->index('profile_view_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('developer_profiles', function (Blueprint $table) {
            $table->dropIndex(['profile_view_count']);
            $table->dropColumn(['profile_view_count', 'last_viewed_at']);
        });
    }
};
