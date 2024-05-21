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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `update_Docente`(id_userr INT, name VARCHAR(40), pat VARCHAR(40), mat VARCHAR(40), nac DATE,
                                phone VARCHAR(12),
                                usname VARCHAR(40), pass VARCHAR(200), active BOOLEAN, sex INT, cedula VARCHAR(20))
BEGIN

    DECLARE id_user INT;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
        BEGIN
            SHOW ERRORS;
            ROLLBACK;
        END;

    START TRANSACTION;
    set autocommit = false;

    SELECT id INTO id_user FROM usuarios WHERE id = id_userr;

    UPDATE usuarios
    SET nombre         = name,
        ap_paterno     = pat,
        ap_materno     = mat,
        nacimiento     = nac,
        telefono       = phone,
        nombre_usuario = usname,
        contrasena     = pass,
        activo         = active,
        id_sexo        = sex
    where id = id_user;

    update docentes
    set cedula_prof = cedula
    where id_usuario = id_user;

    SELECT id, nombre
    FROM usuarios
    WHERE id = id_user;
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
        DB::unprepared("DROP PROCEDURE IF EXISTS update_Docente");
    }
};
