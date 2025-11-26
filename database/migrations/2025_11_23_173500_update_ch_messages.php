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
        if (Schema::hasTable('ch_messages')) {
            Schema::table('ch_messages', function (Blueprint $table) {
                // Cek apakah kolom sudah ada untuk menghindari duplikasi
                if (!Schema::hasColumn('ch_messages', 'project_agreement_id')) {
                    // Tambahkan kolom UUID
                    $table->uuid('project_agreement_id')->nullable()->after('attachment');

                    // Tambahkan Foreign Key
                    $table->foreign('project_agreement_id')
                        ->references('id')->on('project_agreements')
                        ->onDelete('cascade');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('ch_messages')) {
            Schema::table('ch_messages', function (Blueprint $table) {
                if (Schema::hasColumn('ch_messages', 'project_agreement_id')) {
                    // Hapus Foreign Key dulu (gunakan array syntax agar Laravel mencari nama constraint otomatis)
                    try {
                        $table->dropForeign(['project_agreement_id']);
                    } catch (\Exception $e) {
                        // Abaikan jika tidak ditemukan
                    }

                    // Hapus kolom
                    $table->dropColumn('project_agreement_id');
                }
            });
        }
    }
};
