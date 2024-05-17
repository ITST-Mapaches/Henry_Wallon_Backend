<?php

namespace App\Http\Controllers;

use Exception;
use TCPDF;
use DB;
use TCPDF_FONTS;

class PDFController extends TCPDF
{
    // Método para definir el contenido del footer
    public function Footer()
    {
        // Posiciona a 15 mm desde abajo
        $this->SetY(-2);
        // Establece la fuente para el footer
        $this->SetFont('calibri', 'I', 8);

        $html = '
        <style>
        .fz8 {
            font-size: 8pt;
            }
            .table_footer{
                width: 100%;
                border-collapse: separate;
                position: absolute;
                bottom: 0;
            }

            .table_footer td{
                max-width: 33.3%;
                width: 33.3%;
            }
            .text_center{
                text-align: center;
            }
            .datos_line {
                border-top: .5pt solid black;
                font-size: 7pt;
                margin-bottom: 8pt;
                }
        </style>
        <table class="table_footer">
        <tr class="text_center">
            <td class="fz8">TEZIUTLÁN, PUE.</td>
            <td class="fz8"></td>
            <td class="fz8">MTRA. BLANCA DANIELA BARRIENTOS ROA</td>
        </tr>
        <tr class="text_center">
            <td class="datos_line  fz8">LUGAR DE EXPEDICIÓN</td>
            <td class="  fz8">SELLO</td>
            <td class="datos_line  fz8">NOMBRE Y FIRMA <br> DE DIRECTORA DE NIVEL</td>
        </tr>
    </table>';

        // Agrega el texto al footer
        $this->writeHTML($html, true, false, true, false, '');
    }

    public function getBoleta($id)
    {
        // busca al usuario
        $alumno = DB::table('alumnos')->join('usuarios', 'alumnos.id_usuario', '=', 'usuarios.id')
            ->join('periodos_escolares', 'periodos_escolares.id', '=', 'alumnos.id_periodo')
            ->join('grupos', 'grupos.id', '=', 'alumnos.id_grupo')
            ->where('usuarios.id', $id)
            ->select(['alumnos.id', 'alumnos.num_control', 'usuarios.nombre', 'usuarios.ap_paterno', 'usuarios.ap_materno', 'grupos.prefijo', 'alumnos.id_periodo', 'periodos_escolares.numero', 'periodos_escolares.nombre_tipo'])->first();

        if (!$alumno) {
            return response([
                'status' => 404,
                'message' => 'No se ha encontrado un alumno con el id indicado'
            ], 404);
        }

        // obtiene la data del usuario
        $momentos = DB::table('momentos')->join('alumnos', 'momentos.id_alumno', '=', 'alumnos.id')
            ->join('asignaturas', 'momentos.id_asignatura', '=', 'asignaturas.id')
            ->where('momentos.id_alumno', $alumno->id)
            ->where('asignaturas.id_periodo', $alumno->id_periodo)
            ->select(['asignaturas.nombre', 'momentos.cal_primer_momento', 'momentos.cal_segundo_momento', 'momentos.cal_tercer_momento'])->get();

        if (!$momentos) {
            return response([
                'status' => 404,
                'message' => 'No se ha encontrado informacion del alumno indicado'
            ], 404);
        }


        try {
            // Crear una instancia de TCPDF
            $pdf = new PDFController('P', 'cm', array(21.59, 27.94), true, 'UTF-8', false);
            $pdf->setPrintHeader(false); // No imprimir encabezado en cada página
            $pdf->SetMargins(1, 0, 1); // Márgenes de 1 pulgada en cada lado
            $pdf->setFontSubsetting(false);
            $fontpath = public_path() . '/fonts/calibri-regular.ttf';
            TCPDF_FONTS::addTTFfont($fontpath, 'TrueTypeUnicode', '', 32);
            $pdf->SetFont('calibri', '', 12);

            $pdf->AddPage();


            $calificaciones = '';
            $promediosMaterias = [];
            $PromedioMomentoI = 0;
            $PromedioMomentoII = 0;
            $PromedioMomentoIII = 0;

            // ciclo para obtener calificaciones
            for ($i = 0; $i < count($momentos); $i++) {
                // generando fila de calificaciones
                $calificaciones .=
                    '<tr style="font-size: 7pt;"> <td class="fz8">' . $momentos[$i]->nombre . '</td>'
                    . '<td>' . $momentos[$i]->cal_primer_momento . '</td>'
                    . '<td>' . $momentos[$i]->cal_segundo_momento . '</td>'
                    . '<td>' . $momentos[$i]->cal_tercer_momento . '</td>';

                // redondeando el numero de promedio de materia
                $promedioRedondeado = round(($momentos[$i]->cal_primer_momento + $momentos[$i]->cal_segundo_momento + $momentos[$i]->cal_tercer_momento) / 3, 0, PHP_ROUND_HALF_UP);

                // asignando el promedio redondeado final de la materia al array de promedios materias
                $promediosMaterias[$i] = $promedioRedondeado;

                // complementando fila con promedio final de la maeria
                $calificaciones .= '<td>' . $promediosMaterias[$i] . '</td>' . '</tr>';

                $PromedioMomentoI += $momentos[$i]->cal_primer_momento;
                $PromedioMomentoII += $momentos[$i]->cal_segundo_momento;
                $PromedioMomentoIII += $momentos[$i]->cal_tercer_momento;
            }

            // obteniendo el promedio general
            $promedioFinal = 0;
            foreach ($promediosMaterias as $promedioMateria) {
                $promedioFinal += $promedioMateria;
            }

            $PromedioMomentoI = round($PromedioMomentoI / count($momentos), 0, PHP_ROUND_HALF_UP);
            $PromedioMomentoII = round($PromedioMomentoII / count($momentos), 0, PHP_ROUND_HALF_UP);
            $PromedioMomentoIII = round($PromedioMomentoIII / count($momentos), 0, PHP_ROUND_HALF_UP);
            $promedioFinal = round($promedioFinal / count($momentos), 0, PHP_ROUND_HALF_UP);

            $styles = '
                <style>
                .header {
                    width: 100%;
                    text-align: center;
                    }
        
                .title {
                    font-size: 18pt;
                    font-weight: bold;
                    }
        
                .subtitle {
                    font-size: 10pt;
                    }
        
                table {
                    width: 100%;
                    border-collapse: collapse;
                    }
        
                .datos_box {
                    padding: 2pt;
                    border: .5pt solid black;
                    font-size: 11pt;
                    font-weight: bolder;
                    }
        
                .text_center {
                    text-align: center;
                    }
        
                .datos_line {
                    border-top: .5pt solid black;
                    font-size: 7pt;
                    margin-bottom: 8pt;
                    }
        
                .fz7 {
                    font-size: 7pt;
                    }

                .fz8 {
                    font-size: 8pt;
                    }
        
                .fz11 {
                    font-size: 11pt;
                    }
        
                .table_container, .table_container__row, .table_container__col{
                    border-collapse: collapse;
                    border: none;
                    outline: none;
                }

                .container__item{
                    width: 100%;
                }

                .container__item__table tr, .container__item__table th, .container__item__table td{
                    border: .5pt solid black;
                    border-collapse: collapse;
                }


                .h_64{
                    height: 64pt;
                }

                </style>';

            // Contenido HTML para el PDF
            $html = '
            <div class="header">
                <h1 class="title">REPORTE INTERNO DE CALIFICACIONES</h1>
                <h3 class="subtitle">
                    ' . $alumno->numero . ' ' . strtoupper($alumno->nombre_tipo) . ' DE EDUCACIÓN MEDIA SUPERIOR
                    <br />
                    CICLO ESCOLAR 2023-2024
                </h3>
            </div>

            <table>
                    <tr>
                        <td class="datos_box" colspan="4">DATOS DEL (DE LA) ALUMNO (A)</td>
                    </tr>
                    <tr style="height: 0; font-size: 3pt;"><td></td></tr>
                    <tr class="text_center fz11">
                        <td>' . strtoupper($alumno->ap_paterno) . '</td>
                        <td>' . strtoupper($alumno->ap_materno) . '</td>
                        <td>' . strtoupper($alumno->nombre) . '</td>
                        <td>' . strtoupper($alumno->num_control) . '</td>
                    </tr>
                    <tr class="text_center fz8">
                        <td class="datos_line">PRIMER APELLIDO</td>
                        <td class="datos_line">SEGUNDO APELLIDO</td>
                        <td class="datos_line">NOMBRE (S)</td>
                        <td class="datos_line">CONTROL</td>
                    </tr>
                    <tr style="height: 8pt"><td></td></tr>
                    <tr>
                        <td class="datos_box" colspan="4">DATOS DE LA ESCUELA</td>
                    </tr>
                    <tr style="height: 0; font-size: 3pt;"><td></td></tr>
                    <tr class="text_center fz11">
                        <td colspan="2"> INSTITUTO HENRY WALLON </td>
                        <td>"' . strtoupper($alumno->prefijo) . '"</td>
                        <td>MATUTINO</td>
                    </tr>
                    <tr class="text_center fz8">
                        <td class="datos_line" colspan="2">NOMBRE DE LA ESCUELA</td>
                        <td class="datos_line">GRUPO</td>
                        <td class="datos_line">TURNO</td>
                    </tr>
                </table>

            <p class="fz8">El(la) maestro(a) registrará las calificaciones y los promedios que se generen de las evaluaciones
            por UAC, semestre o nivel educativo y se expresarán con número truncado a décimos.
        </p>

            <table class="table_container">
            <tr class="table_container__row">

                <td class="table_container__col">
                    <div class="container__item">
                        <table class="container__item__table text_center">
                            <thead>
                                <tr class="fz11">
                                    <th style="width:60%;" rowspan="2">UAC</th>
                                    <th style="width:60pt;" colspan="3">MOMENTO</th>
                                    <th style="font-size:10pt;" rowspan="2">PROMEDIO FINAL</th>
                                </tr>
                                <tr>
                                    <td>I</td>
                                    <td>II</td>
                                    <td>III</td>
                                </tr>
                            </thead>
                            <tbody class="fz8">
                            ' . $calificaciones . '
                            </tbody>
                            <tfoot>
                                <tr style="font-size: 7pt;">
                                    <td>PROMEDIO</td>
                                    <td>' . $PromedioMomentoI . '</td>
                                    <td>' . $PromedioMomentoII . '</td>
                                    <td>' . $PromedioMomentoIII . '</td>
                                    <td>' . $promedioFinal . '</td>
                                </tr>
                            </tfoot>
                        </table>
                        <br>
                        <br>
                        <table class="container__item__table" style="width:100%;">
                            <tr class="text_center fz7">
                                <td rowspan="2" style="width:65%;">MARQUE SI EL APREDNIZAJE Y (O LA PROMOCIÓN DE GRADO DEL (DE LA) ALUMNO(A) SE ENCUENTRA EN RIESGO</td>
                                <td style="width:12%">ALERTA</td>
                                <td style="width:12%">ALERTA</td>
                                <td style="width:12%">ALERTA</td>
                            </tr>
                            <tr class="text_center">
                                <td>'.( ($PromedioMomentoI >= 7) ? '○' : '●' ).'</td>
                                <td>'.( ($PromedioMomentoII >= 7) ? '○' : '●' ).'</td>
                                <td>'.( ($PromedioMomentoIII >= 7) ? '○' : '●' ).'</td>
                            </tr>
                        </table>
                    </div>
                </td>

            
                <!-- tabla fechas momentos -->
                <td class="table_container__col">
                    <div class="container__item">
                        <table class="container__item__table text_center">
                            <thead>
                                <tr class="fz8">
                                    <th colspan="3">MOMENTOS DE EVALUACIÓN / FIRMA DE PADRE O TUTOR</th>
                                </tr>
                                <tr style="font-size: 9pt;">
                                    <th>MOMENTO I</th>
                                    <th>MOMENTO II</th>
                                    <th>MOMENTO III</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="fz8">
                                    <td class="h_64"></td>
                                    <td class="h_64"></td>
                                    <td class="h_64"></td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <br>
                        <!-- tabla promedio final -->
                        <table class="container__item__table">
                        <tr class="text_center">
                            <td style="width: 50%;" >PROMEDIO FINAL</td>
                            <td style="width: 50%;" >' . $promedioFinal . '</td>
                        </tr>
                        </table>
                    </div> 
                </td>

                </tr>
            </table>';

            $page = $styles . $html;

            // Agregar el contenido HTML al PDF
            $pdf->writeHTML($page, true, false, true, false, '');

            // Obtener el contenido del PDF como una cadena
            $pdfContent = $pdf->Output('boleta.pdf', 'S');

            // Devolver el PDF como la respuesta de la solicitud HTTP
            return response($pdfContent, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="boleta.pdf"',
            ]);
        } catch (Exception $ex) {

            return response()->json(['error' => 'Error al generar el PDF: ' . $ex->getMessage()], 500);
        }
    }

}
