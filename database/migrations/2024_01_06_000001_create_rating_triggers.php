<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Trigger untuk update rating saat review ditambahkan
        DB::unprepared('
            CREATE TRIGGER trg_reviews_after_insert
            AFTER INSERT ON reviews
            FOR EACH ROW
            BEGIN
                UPDATE developer_profiles AS dp
                SET dp.rating_count   = dp.rating_count + 1,
                    dp.rating_average = (
                        SELECT COALESCE(AVG(r2.rating), 0)
                        FROM reviews r2
                        WHERE r2.developer_id = NEW.developer_id
                    )
                WHERE dp.user_id = NEW.developer_id;
            END
        ');

        // Trigger untuk update rating saat review diubah
        DB::unprepared('
            CREATE TRIGGER trg_reviews_after_update
            AFTER UPDATE ON reviews
            FOR EACH ROW
            BEGIN
                IF NEW.rating <> OLD.rating OR NEW.developer_id <> OLD.developer_id THEN
                    IF OLD.developer_id <> NEW.developer_id THEN
                        UPDATE developer_profiles AS dp
                        SET dp.rating_count   = dp.rating_count - 1,
                            dp.rating_average = (
                                SELECT COALESCE(AVG(r2.rating), 0)
                                FROM reviews r2
                                WHERE r2.developer_id = OLD.developer_id
                            )
                        WHERE dp.user_id = OLD.developer_id;
                    END IF;

                    UPDATE developer_profiles AS dp
                    SET dp.rating_count   = dp.rating_count + 1,
                        dp.rating_average = (
                            SELECT COALESCE(AVG(r2.rating), 0)
                            FROM reviews r2
                            WHERE r2.developer_id = NEW.developer_id
                        )
                    WHERE dp.user_id = NEW.developer_id;
                END IF;
            END
        ');

        // Trigger untuk update rating saat review dihapus
        DB::unprepared('
            CREATE TRIGGER trg_reviews_after_delete
            AFTER DELETE ON reviews
            FOR EACH ROW
            BEGIN
                UPDATE developer_profiles AS dp
                SET dp.rating_count   = dp.rating_count - 1,
                    dp.rating_average = (
                        SELECT COALESCE(AVG(r2.rating), 0)
                        FROM reviews r2
                        WHERE r2.developer_id = OLD.developer_id
                    )
                WHERE dp.user_id = OLD.developer_id;
            END
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_reviews_after_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_reviews_after_update');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_reviews_after_delete');
    }
};
