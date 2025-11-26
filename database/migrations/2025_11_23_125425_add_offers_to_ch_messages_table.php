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
        Schema::table('ch_messages', function (Blueprint $table) {
            $table->bigInteger('offer_id')->unsigned()->nullable()->after('attachment');
            $table->text('metadata')->nullable()->after('offer_id');

            $table->foreign('offer_id')
                ->references('id')
                ->on('offers')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ch_messages', function (Blueprint $table) {
            $table->dropForeign(['offer_id']);
            $table->dropColumn(['offer_id', 'metadata']);
        });
    }
};
