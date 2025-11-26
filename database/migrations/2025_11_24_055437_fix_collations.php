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
        // Matikan Foreign Key Check agar kita bisa memodifikasi kolom Primary/Foreign Key
        Schema::disableForeignKeyConstraints();

        // Daftar tabel dan kolom yang perlu diseragamkan
        $targets = [
            // Tabel Utama (Primary Key) - NOT NULL
            ['table' => 'project_agreements', 'col' => 'id', 'nullable' => false],

            // Tabel Anak (Foreign Key) - NULLABLE (Sesuai migrasi sebelumnya)
            ['table' => 'payments', 'col' => 'project_agreement_id', 'nullable' => true],
            ['table' => 'ch_messages', 'col' => 'project_agreement_id', 'nullable' => true],
            ['table' => 'agreement_validations', 'col' => 'project_agreement_id', 'nullable' => true],
            ['table' => 'project_disputes', 'col' => 'project_agreement_id', 'nullable' => true],
            ['table' => 'messages', 'col' => 'agreement_id', 'nullable' => true],
        ];

        foreach ($targets as $target) {
            $tableName = $target['table'];
            $columnName = $target['col'];
            $nullable = $target['nullable'] ? 'NULL' : 'NOT NULL';

            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, $columnName)) {
                // Kita ubah collation kolom tersebut secara spesifik ke utf8mb4_unicode_ci
                DB::statement("ALTER TABLE `{$tableName}` MODIFY `{$columnName}` CHAR(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci {$nullable}");
            }
        }

        // Opsional: Ubah default collation tabel project_agreements agar kolom baru di masa depan seragam
        if (Schema::hasTable('project_agreements')) {
            DB::statement("ALTER TABLE `project_agreements` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        }

        // Hidupkan kembali Foreign Key Check
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak perlu reverse spesifik karena collation utf8mb4_unicode_ci aman digunakan
    }
};
