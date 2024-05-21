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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `add_new_Docente`(name VARCHAR(40), pat VARCHAR(40), mat VARCHAR(40), nac DATE, phone VARCHAR(12),
                                 usname VARCHAR(40), pass VARCHAR(200), active BOOLEAN, sex INT, cedula VARCHAR(20), token VARCHAR(100))
BEGIN

    DECLARE id_user INT;
    DECLARE id_docent INT;
    DECLARE rol_id INT;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
        BEGIN
            SHOW ERRORS;
            ROLLBACK;
        END;

    START TRANSACTION;
    set autocommit = false;

    SELECT id INTO rol_id FROM roles WHERE rol like 'Docente';

    INSERT INTO usuarios(nombre, ap_paterno, ap_materno, nacimiento, telefono, nombre_usuario, contrasena, activo,
                         id_sexo, id_rol, remember_token)
    VALUES (name, pat, mat, nac, phone, usname, pass, active, sex, rol_id, token);

    SET id_user = LAST_INSERT_ID();

    INSERT INTO DOCENTES(cedula_prof, id_usuario)
    VALUES (cedula, id_user);

    SET id_docent = LAST_INSERT_ID();

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
        DB::unprepared("DROP PROCEDURE IF EXISTS add_new_Docente");
    }
};
