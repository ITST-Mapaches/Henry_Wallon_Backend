<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_Docente`(id_us INT)
BEGIN
    DECLARE id_user INT;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
        BEGIN
            SHOW ERRORS;
            ROLLBACK;
        END;

    START TRANSACTION;
    set autocommit = false;

    SELECT id_usuario INTO id_user FROM docentes WHERE id_usuario = id_us;

    DELETE FROM docentes WHERE id_usuario = id_user;

    DELETE FROM usuarios where id = id_user;
    COMMIT;
    set autocommit = true;

END");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS delete_Docente");
    }
};
