<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        /* ----------  AFTER INSERT  ---------- */
        DB::unprepared("
            CREATE TRIGGER trg_pa_after_insert
            AFTER INSERT ON project_agreements
            FOR EACH ROW
            BEGIN
                IF NEW.status = 'completed' THEN
                    UPDATE developer_profiles
                    SET projects_completed = projects_completed + 1
                    WHERE user_id = NEW.developer_id;
                END IF;
            END
        ");

        /* ----------  AFTER UPDATE  ---------- */
        DB::unprepared("
            CREATE TRIGGER trg_pa_after_update
            AFTER UPDATE ON project_agreements
            FOR EACH ROW
            BEGIN
                /* baru jadi completed */
                IF NEW.status = 'completed' AND OLD.status <> 'completed' THEN
                    UPDATE developer_profiles
                    SET projects_completed = projects_completed + 1
                    WHERE user_id = NEW.developer_id;
                /* batal completed */
                ELSEIF NEW.status <> 'completed' AND OLD.status = 'completed' THEN
                    UPDATE developer_profiles
                    SET projects_completed = projects_completed - 1
                    WHERE user_id = NEW.developer_id;
                END IF;
            END
        ");

        /* ----------  AFTER DELETE  ---------- */
        DB::unprepared("
            CREATE TRIGGER trg_pa_after_delete
            AFTER DELETE ON project_agreements
            FOR EACH ROW
            BEGIN
                IF OLD.status = 'completed' THEN
                    UPDATE developer_profiles
                    SET projects_completed = projects_completed - 1
                    WHERE user_id = OLD.developer_id;
                END IF;
            END
        ");
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_pa_after_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_pa_after_update');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_pa_after_delete');
    }
};
