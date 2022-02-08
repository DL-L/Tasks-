<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneratesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
                CREATE FUNCTION task_updater() RETURNS TRIGGER LANGUAGE PLPGSQL
                    AS $$
                    BEGIN
                        INSERT INTO histories VALUES (NEW.id, NEW.title, NEW.description, NEW.status_id, NEW.deadline, now());
                        RETURN NEW;
                    END;
                    $$
                    ;

                CREATE TRIGGER task_trigger BEFORE INSERT OR UPDATE ON tasks FOR EACH ROW
                    EXECUTE FUNCTION task_updater();
                
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER ON task_updater');
    }
}
