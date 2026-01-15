<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ch_messages', function (Blueprint $table) {
            $table->foreign('project_agreement_id')->references('id')->on('project_agreements')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('ch_messages', function (Blueprint $table) {
            $table->dropForeign(['project_agreement_id']);
        });
    }
};
