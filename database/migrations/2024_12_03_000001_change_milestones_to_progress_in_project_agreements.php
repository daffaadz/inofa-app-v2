<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('project_agreements', function (Blueprint $table) {
            // Drop milestones column if exists and add progress column
            if (Schema::hasColumn('project_agreements', 'milestones')) {
                $table->dropColumn('milestones');
            }
            
            if (!Schema::hasColumn('project_agreements', 'progress')) {
                $table->integer('progress')->default(0)->comment('Progress percentage (0-100)')->after('projects_mvp');
            }
        });

        // Update existing records to have progress = 0
        DB::table('project_agreements')
            ->whereNull('progress')
            ->orWhere('progress', '')
            ->update(['progress' => 0]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_agreements', function (Blueprint $table) {
            // Revert back to milestones
            if (Schema::hasColumn('project_agreements', 'progress')) {
                $table->dropColumn('progress');
            }
            
            if (!Schema::hasColumn('project_agreements', 'milestones')) {
                $table->longText('milestones')->nullable()->after('projects_mvp');
            }
        });
    }
};
