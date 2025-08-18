&nbsp;

Contratar, bajo el régimen de contratación administrativa de servicios, personal para las diversas unidades orgánicas de nuestra Entidad.
<table style="width: 100%; font-family: Tahoma, Geneva, sans-serif;" border="0">
    <tbody>
    <tr style="background-color: #5e2129;">
        <td style="text-align: center; color: white; vertical-align: middle; font-size: 1.2em;" colspan="4">BASES DE CONVOCATORIAS</td>
    </tr>
    <tr>
        <td><img src="../documentos/images/pdf-file.png" alt="" width="20" height="20" border="0" /></td>
        <td><a style="color: black;" href="../documentos/convocatorias/cas/2017/RD_N_10_2017.pdf" target="_blank">Resolución Directoral N° 010-2017</a></td>
    </tr>
    <tr>
        <td><img src="../documentos/images/pdf-file.png" alt="" width="20" height="20" border="0" /></td>
        <td><a style="color: black;" href="../documentos/convocatorias/cas/2017/BASES_CONVOCATORIA_2017.pdf" target="_blank">Bases Generales Convocatoria Pública CAS 2017</a></td>
    </tr>
    <tr>
        <td><img src="../documentos/images/excel-file.png" alt="" width="20" height="20" border="0" /></td>
        <td><a style="color: black;" href="../documentos/convocatorias/cas/2017/FORMATO-PERFILES-Anexo1.xlsx" target="_blank">Formato de perfiles de puestos para procesos de selección de personal (Anexo N°1)</a></td>
    </tr>
    <tr>
        <td><img src="../documentos/images/pdf-file.png" alt="" width="20" height="20" border="0" /></td>
        <td><a style="color: black;" href="../documentos/convocatorias/cas/2017/ANEXO-2017.pdf" target="_blank">Anexos para convocatorias</a></td>
    </tr>
    <tr>
        <td><img src="../documentos/images/info-icon.png" alt="" width="20" height="20" border="0" /></td>
        <td><a style="color: black;" href="../transparencia" target="_blank">Personal Permanente y Contratado de la DDC-C</a></td>
    </tr>
    <tr>
        <td><img src="../documentos/images/pdf-file.png" alt="" width="20" height="20" border="0" /></td>
        <td><a style="color: black;" href="../documentos/convocatorias/cas/2017/DIRECTIVA-CAS-2015.pdf" target="_blank">Directiva que regula la contratación, asistencia, y permanencia del personal CAS</a></td>
    </tr>
    </tbody>
</table>
<strong>NOTA:</strong> El llenado del <strong>Anexo 8</strong> (Declaración Jurada para el control de Nepotismo) de las bases de la convocatoria será de acuerdo a la información obtenida de la <a style="color: black;" href="../transparencia">relación del personal permanente y contratado de la DDC-Cusco.</a>

&nbsp;

<!--
<div id="accordion">
<h6 class="accordion-toggle">CONVOCATORIA CAS 2017</h6>
<div class="accordion-content">CONVOCATORIA 2017</div>
</div>
-->
<div id="accordion">
    <h6 class="accordion-toggle">CONVOCATORIA CAS 2017</h6>
    <div class="accordion-content default">
    [insert_php]

    global $wpdb;

    $retrieve_data = $wpdb->get_results('SELECT * FROM ddc_convocatorias WHERE ano = "2017" ORDER BY fecha DESC');

    if($retrieve_data->num_rows > 0) {

        $ruta_base = "../wp-content/plugins/convocatorias/convocatorias/documentos/convocatorias/";

        echo '<table border="0">';
        echo '<tbody>';
        echo '<tr style="background-color: #a4bf96;" align="center">';
        echo '<td>FECHA</td>';
        echo '<td>CONVOCATORIA</td>';
        echo '<td>ESTADO</td>';
        echo '<td>PUBLICACION DE RESULTADOS</td>';
        echo '</tr>';

        foreach ($retrieve_data as $row) {

        echo '<tr>';
            echo '<td style="text-align: center; vertical-align: middle;">' . $row->fecha . '</td>';
            echo '<td style="text-align: center; vertical-align: middle;">';
                echo $row->codigo . ' <a href="' . $ruta_base . $row->tipo . '//' . $row->ano . '//' . $row->nro . '//' . $row->ruta_pdf . '" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0" /></a>';
                echo '</td>';
            echo '<td style="text-align: center; vertical-align: middle;">';
                if ($row->estado == 0) echo '..:: ABIERTO ::..';
                else echo '..:: CERRADO ::..';
                echo '</td>';
            echo '<td>';
                echo '<table style="width: 100%;" border="0">';
                    echo '<tbody>';

                    $retrieve_data2 = $wpdb->get_results( "SELECT * FROM ddc_conv_publicaciones WHERE id_ddc_convocatorias = ".$row->id );

                    foreach ($retrieve_data2 as $row2) {
                    echo '<tr>';

                        if ( is_null($row2->ruta_enlace) || $row2->ruta_enlace == '') {
                        echo '<td>' . $row2->detalle . ' ' . $row2->titulo . '</td>';
                        }
                        else {
                        echo '<td>' . $row2->detalle . ' ' . $row2->titulo . ' <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="' . $ruta_base . $row->tipo . '//' . $row->ano . '//' . $row->nro . '//' . $row2->ruta_enlace . '" target="_blank">VER</a></td>';
                        }

                        echo '</tr>';
                    }

                    echo '</tbody>';
                    echo '</table>';
                echo '</td>';
            echo '</tr>';
        }
    }
    else {
        echo 'CONVOCATORIA 2017';
    }
    echo '</tbody>';
    echo '</table>';
    [/insert_php]
    </div>
    <h6 class="accordion-toggle">CONVOCATORIA CAS 2016</h6>
    <div class="accordion-content" style>
        <table border="0">
            <tbody>
            <tr style="background-color: #a4bf96;" align="center">
                <td>FECHA</td>
                <td>CONVOCATORIA</td>
                <td>ESTADO</td>
                <td>PUBLICACION DE RESULTADOS</td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">02/12/2016</td>
                <td style="text-align:center; vertical-align:middle;">CAS-007-2016-DDC-C <a href="../documentos/convocatorias/cas/2016/7/CONVOCATORIA_CAS_007_2016.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a></td>
                <td style="text-align:center; vertical-align:middle;">..:: ABIERTO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>02, 03, 05, 06, 07/12/2016 PRESENTACION DE FILES</td>
                        </tr>
                        <tr>
                            <td>09, 12/12/2016 EV. CURRICULAR <a style=" color:green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2016/7/EVAL_CURRICULAR_CAS_007_2016.pdf" target="_blank">VER</a></td>
                        </tr>
                        <tr>
                            <td>13/12/2016 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2016/7/RESULT_FINAL_CAS_007_2016.pdf" target="_blank"> VER</a></td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">14/09/2016</td>
                <td style="text-align:center; vertical-align:middle;">CAS-006-2016-DDC-C <a href="../documentos/convocatorias/cas/2016/6/CONVOCATORIA_CAS_006_2016.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td style="text-align:center; vertical-align:middle;">
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>15, 16, 19, 20, 21/09/2016 PRESENTACION DE FILES </td>
                        </tr>
                        <tr>
                            <td>27/09/2016 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2016/6/RESULT_FINAL_CAS_006_2016.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>23/09/2014 EV. CURRICULAR <a style=" color:green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2016/6/EVAL_CURRICULAR_CAS_006_2016.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">06/05/2016</td>
                <td style="text-align:center; vertical-align:middle;">CAS-005-2016-DDC-C <a href="../documentos/convocatorias/cas/2016/5/CONVOCATORIA_CAS_005_2016.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>20, 23, 24, 25, 26/05/2016 PRESENTACION DE FILES </td>
                        </tr>
                        <tr>
                            <td>30/05/2016 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2016/5/RESULT_FINAL_CAS_005_2016.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>27/05/2016 EV. CURRICULAR <a style="color: green" href="../documentos/convocatorias/cas/2016/5/EVAL_CURRICULAR_CAS_005_2016.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">08/04/2016</td>
                <td style="text-align:center; vertical-align:middle;">CAS-004-2016-DDC-C <a href="../documentos/convocatorias/cas/2016/4/CONVOCATORIA_CAS_004_2016.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>22, 23, 25, 26, 27/04/2016 PRESENTACIÓN DE FILES </td>
                        </tr>
                        <tr>
                            <td><span style="color: #000000; font-family: Verdana, Arial, Helvetica, sans-serif;">28/04/2016 EV. CURRICULAR </span>
                            </td>
                        </tr>
                        <tr>
                            <td>25/04/2016 COMUNICADO <a style="color: green;" href="../documentos/convocatorias/cas/2016/4/COMUNICADO_CAS_004_2016" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>29/04/2016 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2016/4/RESULT_FINAL_CAS_004_2016.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>28/04/2016 EV. CURRICULAR <a style="color: green" href="../documentos/convocatorias/cas/2016/4/EVAL_CURRICULAR_CAS_004_2016.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">02/02/2016</td>
                <td style="text-align:center; vertical-align:middle;">CAS-003-2016-DDC-C <a href="../documentos/convocatorias/cas/2016/3/CONVOCATORIA_CAS_003_2016.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>09/02/2016 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2016/3/RESULT_FINAL_CAS_003_2016.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td><span style="color: #000000; font-family: Verdana, Arial, Helvetica, sans-serif;">08/02/2016 EV. CURRICULAR </span><a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2016/3/EVAL_CURRICULAR_CAS_003_2016.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">25/01/2016</td>
                <td style="text-align:center; vertical-align:middle;">CAS-002-2016-DDC-C <a href="../documentos/convocatorias/cas/2016/2/CONVOCATORIA_CAS_002_2016.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>03/02/2016 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2016/2/RESULT_FINAL_CAS_002_2016.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td><span style="color: #000000; font-family: Verdana, Arial, Helvetica, sans-serif;">02/02/2016 EV. CURRICULAR </span><a style=" color:green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2016/2/EVAL_CURRICULAR_CAS_002_2016.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">22/01/2016</td>
                <td style="text-align:center; vertical-align:middle;">CAS-001-2016-DDC-C <a href="../documentos/convocatorias/cas/2016/1/CONVOCATORIA_CAS_001_2016.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td><span style="color: #000000; font-family: Verdana, Arial, Helvetica, sans-serif;">COMUNICADO N°02 </span><a style="color:green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2016/1/COMUNICADO_CAS_001-2016_2.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td><span style="color: #000000; font-family: Verdana, Arial, Helvetica, sans-serif;">COMUNICADO N°01 </span><a style="color:green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2016/1/COMUNICADO_CAS_001_2016.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>02/02/2016 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2016/1/RESULT_FINAL_CAS_001_2016.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td><span style="color: #000000; font-family: Verdana, Arial, Helvetica, sans-serif;">28/01/2016 EV. CURRICULAR </span><a style="color:green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2016/1/EVAL_CURRICULAR_CAS_001_2016.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <h6 class="accordion-toggle">CONVOCATORIA CAS 2015</h6>
    <div class="accordion-content" style>
        <table border="0">
            <tbody>
            <tr style="background-color:#a4bf96;" align="center">
                <td>FECHA</td>
                <td>CONVOCATORIA</td>
                <td>ESTADO</td>
                <td>PUBLICACION DE RESULTADOS</td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">07/12/2015</td>
                <td style="text-align:center; vertical-align:middle;">CAS-011-2015-DDC-C <a href="../documentos/convocatorias/cas/2015/11/CONVOCATORIA_CAS_011_2015.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a></td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>15/12/2015 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2015/11/RESULT_FINAL_CAS_011_2015_1.pdf" target="_blank">VER</a></td>
                        </tr>
                        <tr>
                            <td>14/12/2015 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2015/11/EVAL_CURRICULAR_CAS_011_2015.pdf" target="_blank">VER</a></td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">24/11/2015</td>
                <td style="text-align:center; vertical-align:middle;">CAS-010-2015-DDC-C <a href="../documentos/convocatorias/cas/2015/10/CONVOCATORIA_CAS_010_2015.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a></td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>03/12/2015 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2015/10/RESULT_FINAL_CAS_010_2015_1.pdf" target="_blank">VER</a></td>
                        </tr>
                        <tr>
                            <td>30/11/2015 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2015/10/EVAL_CURRICULAR_CAS_010_2015.pdf" target="_blank">VER</a></td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">10/11/2015</td>
                <td style="text-align:center; vertical-align:middle;">CAS-009-2015-DDC-C <a href="../documentos/convocatorias/cas/2015/9/CONVOCATORIA_CAS_009_2015.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a></td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>COMUNICADO <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2015/9/COMUNICADO_1_CAS_009_2015.pdf" target="_blank">VER</a></td>
                        </tr>
                        <tr>
                            <td>17/11/2015 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2015/9/RESULT_FINAL_CAS_009_2015.pdf" target="_blank">VER</a></td>
                        </tr>
                        <tr>
                            <td>16/11/2015 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2015/9/EVAL_CURRICULAR_CAS_009_2015.pdf" target="_blank">VER</a></td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">19/10/2015</td>
                <td style="text-align:center; vertical-align:middle;">CAS-008-2015-DDC-C <a href="../documentos/convocatorias/cas/2015/8/CONVOCATORIA_CAS_008_2015.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a></td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>23/10/2015 COMUNICADO <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2015/8/COMUNICADO_1_CAS_008_2015.pdf" target="_blank">VER</a></td>
                        </tr>
                        <tr>
                            <td>29/10/2015 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2015/8/RESULT_FINAL_CAS_008_2015.pdf" target="_blank">VER</a></td>
                        </tr>
                        <tr>
                            <td>26/10/2015 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2015/8/EVAL_CURRICULAR_CAS_008_2015.pdf" target="_blank">VER</a></td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">23/09/2015</td>
                <td style="text-align:center; vertical-align:middle;">CAS-007-2015-DDC-C <a href="../documentos/convocatorias/cas/2015/7/CONVOCATORIA_CAS_007_2015.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>01/10/2015 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2015/7/RESULT_FINAL_CAS_007_2015.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>30/09/2015 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2015/7/EVAL_CURRICULAR_CAS_007_2015.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">03/09/2015</td>
                <td style="text-align:center; vertical-align:middle;">CAS-006-2015-DDC-C <a href="../documentos/convocatorias/cas/2015/6/CONVOCATORIA_CAS_006_2015.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>04/09/2015 COMUNICADO <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2015/6/COMUNICADO_1_CAS_006_2015.pdf" target="_blank">VER</a></td>
                        </tr>
                        <tr>
                            <td>14/09/2015 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2015/6/RESULT_FINAL_CAS_006_2015.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>09/09/2015 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2015/6/EVAL_CURRICULAR_CAS_006_2015.pdf" target="_blank">VER</a></td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">22/07/2015</td>
                <td style="text-align:center; vertical-align:middle;">CAS-005-2015-DDC-C <a href="../documentos/convocatorias/cas/2015/5/CONVOCATORIA_CAS_005_2015.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>24/07/2015 COMUNICADO <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2015/5/COMUNICADO_1_CAS_005_2015.pdf" target="_blank">VER</a></td>
                        </tr>
                        <tr>
                            <td>05/08/2015 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2015/5/RESULT_FINAL_CAS_005_2015.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>31/07/2015 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2015/5/EVAL_CURRICULAR_CAS_005_2015.pdf" target="_blank">VER</a></td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">25/06/2015</td>
                <td style="text-align:center; vertical-align:middle;">CAS-004-2015-DDC-C <a href="../documentos/convocatorias/cas/2015/4/CONVOCATORIA_CAS_004_2016.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>08/07/2015 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2015/4/RESULT_FINAL_CAS_004_2015.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>06/07/2015 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2015/4/EVAL_CURRICULAR_CAS_004_2015.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">18/05/2015</td>
                <td style="text-align:center; vertical-align:middle;">CAS-003-2015-DDC-C <a href="../documentos/convocatorias/cas/2015/3/CONVOCATORIA_CAS_003_2016.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>28/05/2015 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2015/3/RESULT_FINAL_CAS_003_2015.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>26/05/2015 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2015/3/EVAL_CURRICULAR_CAS_003_2015.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">20/04/2015</td>
                <td style="text-align:center; vertical-align:middle;">CAS-002-2015-DDC-C <a href="../documentos/convocatorias/cas/2015/2/CONVOCATORIA_CAS_002_2015.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>29/04/2015 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2015/2/RESULT_FINAL_CAS_002_2015.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>28/04/2015 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2015/2/EVAL_CURRICULAR_CAS_002_2015.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">21/03/2015</td>
                <td style="text-align:center; vertical-align:middle;">CAS-001-2015-DDC-C <a href="../documentos/convocatorias/cas/2015/1/CONVOCATORIA_CAS_001_2015.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>01/04/2015 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2015/1/RESULT_FINAL_CAS_001_2015.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>30/03/2015 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2015/1/EVAL_CURRICULAR_CAS_001_2015.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <h6 class="accordion-toggle">CONVOCATORIA CAS 2014</h6>
    <div class="accordion-content" style>
        <table border="0">
            <tbody>
            <tr style="background-color: #a4bf96;" align="center">
                <td>FECHA</td>
                <td>CONVOCATORIA</td>
                <td>ESTADO</td>
                <td>PUBLICACION DE RESULTADOS</td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">04/12/2014</td>
                <td style="text-align:center; vertical-align:middle;">CAS-30-2014-DDC-C <a href="../documentos/convocatorias/cas/2014/30/CAS_30_2014.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>15/12/2014 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2014/30/RESULTADO_FINAL_CAS_30_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>12/12/2014 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2014/30/EVAL_CURRI_CAS_30_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">26/11/2014</td>
                <td style="text-align:center; vertical-align:middle;">CAS-29-2014-DDC-C <a href="../documentos/convocatorias/cas/2014/29/CAS_29_2014.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>04/12/2014 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2014/29/RESULTADO_FINAL_CAS_29_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>03/12/2014 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2014/29/EVAL_CURRI_CAS_29_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">04/11/2014</td>
                <td style="text-align:center; vertical-align:middle;">CAS-28-2014-DDC-C <a href="../documentos/convocatorias/cas/2014/28/CAS_28_2014.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>13/11/2014 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2014/28/RESULTADO_FINAL_CAS_28_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>12/11/2014 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2014/28/EVAL_CURRI_CAS_28_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">07/10/2014</td>
                <td style="text-align:center; vertical-align:middle;">CAS-27-2014-DDC-C <a href="../documentos/convocatorias/cas/2014/27/CAS_27_2014.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>16/10/2014 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2014/27/RESULTADO_FINAL_CAS_27_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>15/10/2014 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2014/27/EVAL_CURRI_CAS_27_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">21/10/2014</td>
                <td style="text-align:center; vertical-align:middle;">CAS-26-2014-DDC-C <a href="../documentos/convocatorias/cas/2014/26/CAS_26_2014.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>29/10/2014 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2014/26/RESULTADO_FINAL_CAS_26_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>28/10/2014 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2014/26/EVAL_CURRI_CAS_26_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">06/10/2014</td>
                <td style="text-align:center; vertical-align:middle;">CAS-25-2014-DDC-C <a href="../documentos/convocatorias/cas/2014/25/CAS_25_2014.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>16/10/2014 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2014/25/RESULTADO_FINAL_CAS_25_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>15/10/2014 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2014/25/EVAL_CURRI_CAS_25_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">19/09/2014</td>
                <td style="text-align:center; vertical-align:middle;">CAS-24-2014-DDC-C <a href="../documentos/convocatorias/cas/2014/24/CAS_24_2014.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>29/09/2014 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2014/24/RESULTADO_FINAL_CAS_24_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>26/09/2014 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2014/24/EVAL_CURRI_CAS_24_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">30/09/2014</td>
                <td style="text-align:center; vertical-align:middle;">CAS-23-2014-DDC-C <a href="../documentos/convocatorias/cas/2014/23/CAS_23_2014.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>09/10/2014 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2014/23/RESULTADO_FINAL_CAS_23_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>07/10/2014 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2014/23/EVAL_CURRI_CAS_23_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">08/09/2014</td>
                <td style="text-align:center; vertical-align:middle;">CAS-22-2014-DDC-C <a href="../documentos/convocatorias/cas/2014/22/CAS_22_2014.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>COMUNICADO Nº 01 <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2014/22/COMUNICADO_01_CAS_22_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>01/10/2014 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2014/22/RESULTADO_FINAL_CAS_22_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>30/09/2014 EV. CURRICULAR <a style="color: green;" href="../documentos/convocatorias/cas/2014/22/EVAL_CURRI_CAS_22_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">08/09/2014</td>
                <td style="text-align:center; vertical-align:middle;">CAS-21-2014-DDC-C <a href="../documentos/convocatorias/cas/2014/21/CAS_21_2014.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>COMUNICADO Nº 01 <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2014/21/COMUNICADO_01_CAS_21_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>17/09/2014 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2014/21/RESULTADO_FINAL_CAS_21_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>16/09/2014 EV. CURRICULAR <a style="color: green;" href="../documentos/convocatorias/cas/2014/21/EVAL_CURRI_CAS_21_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">08/09/2014</td>
                <td style="text-align:center; vertical-align:middle;">CAS-20-2014-DDC-C <a href="../documentos/convocatorias/cas/2014/20/CAS_20_2014.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>17/09/2014 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2014/20/RESULTADO_FINAL_CAS_20_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>16/09/2014 EV. CURRICULAR <a style="color: green;" href="../documentos/convocatorias/cas/2014/20/EVAL_CURRI_CAS_20_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">21/08/2014</td>
                <td style="text-align:center; vertical-align:middle;">CAS-19-2014-DDC-C <a href="../documentos/convocatorias/cas/2014/19/CAS_19_2014.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>COMUNICADO Nº 01 <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2014/19/COMUNICADO_01_CAS_19_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>02/09/2014 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2014/19/RESULTADO_FINAL_CAS_19_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>01/09/2014 EV. CURRICULAR <a style="color: green; font-family: Verdana, Arial, Helvetica, sans-serif;" href="../documentos/convocatorias/cas/2014/19/EVAL_CURRI_CAS_19_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">03/09/2014</td>
                <td style="text-align:center; vertical-align:middle;">CAS-18-2014-DDC-C <a href="../documentos/convocatorias/cas/2014/18/CAS_18_2014.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>12/09/2014 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2014/18/RESULTADO_FINAL_CAS_18_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>11/09/2014 EV. CURRICULAR <a style="color: green;" href="../documentos/convocatorias/cas/2014/18/EVAL_CURRI_CAS_18_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">02/09/2014</td>
                <td style="text-align:center; vertical-align:middle;">CAS-17-2014-DDC-C <a href="../documentos/convocatorias/cas/2014/17/CAS_17_2014.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>10/09/2014 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2014/17/RESULTADO_FINAL_CAS_17_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>09/09/2014 EV. CURRICULAR <a style="color: green;" href="../documentos/convocatorias/cas/2014/17/EVAL_CURRI_CAS_17_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">07/08/2014</td>
                <td style="text-align:center; vertical-align:middle;">CAS-16-2014-DDC-C <a href="../documentos/convocatorias/cas/2014/16/CAS_16_2014.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>15/08/2014 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2014/16/RESULTADO_FINAL_CAS_16_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>14/08/2014 EV. CURRICULAR <a style="color: green;" href="../documentos/convocatorias/cas/2014/16/EVAL_CURRI_CAS_16_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">07/08/2014</td>
                <td style="text-align:center; vertical-align:middle;">CAS-15-2014-DDC-C <a href="../documentos/convocatorias/cas/2014/15/CAS_15_2014.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>COMUNICADO Nº 01 <a style="color: green;" href="../documentos/convocatorias/cas/2014/15/COMUNICADO_01_CAS_15_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>28/08/2014 FINAL <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2014/15/RESULTADO_FINAL_CAS_15_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>27/08/2014 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2014/15/EVAL_CURRI_CAS_15_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">07/08/2014</td>
                <td style="text-align:center; vertical-align:middle;">CAS-14-2014-DDC-C <a href="../documentos/convocatorias/cas/2014/14/CAS_14_2014.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>20/08/2014 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2014/14/RESULTADO_FINAL_CAS_14_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>19/08/2014 EV. CURRICULAR <a style="color: green; font-family: Verdana, Arial, Helvetica, sans-serif;" href="../documentos/convocatorias/cas/2014/14/EVAL_CURRI_CAS_14_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">01/08/2014</td>
                <td style="text-align:center; vertical-align:middle;">CAS-13-2014-DDC-C <a href="../documentos/convocatorias/cas/2014/13/CAS_13_2014.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>13/08/2014 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2014/13/RESULTADO_FINAL_CAS_13_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>11/08/2014 EV. CURRICULAR <a style="color: green;" href="../documentos/convocatorias/cas/2014/13/EVAL_CURRI_CAS_13_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">15/07/2014</td>
                <td style="text-align:center; vertical-align:middle;">CAS-12-2014-DDC-C <a href="../documentos/convocatorias/cas/2014/12/CAS_12_2014.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>COMUNICADO Nº 01 <a style="color: green;" href="../documentos/convocatorias/cas/2014/12/COMUNICADO_01_CAS_12_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>24/07/2014 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2014/12/RESULTADO_FINAL_CAS_12_2014.pdf" target="_blank"><span style="background-color: #ffffff;">VER</span></a>
                            </td>
                        </tr>
                        <tr>
                            <td>23/07/2014 EV. CURRICULAR <a style="color: green; font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #ffffcc;" href="../documentos/convocatorias/cas/2014/12/EVAL_CURRI_CAS_12_2014.pdf" target="_blank"><span style="background-color: #ffffff;">VER</span></a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">16/07/2014</td>
                <td style="text-align:center; vertical-align:middle;">CAS-11-2014-DDC-C <a href="../documentos/convocatorias/cas/2014/11/CAS_11_2014.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>COMUNICADO Nº 01<span style="color: #000000; font-family: Verdana, Arial, Helvetica, sans-serif;"> </span><a style="color: green; font-family: Verdana, Arial, Helvetica, sans-serif;" href="../documentos/convocatorias/cas/2014/11/COMUNICADO_01_CAS_11_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>31/07/2014 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2014/11/RESULTADO_FINAL_CAS_11_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>30/07/2014 EV. CURRICULAR <a style="color: green;" href="../documentos/convocatorias/cas/2014/11/EVAL_CURRI_CAS_11_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">30/06/2014</td>
                <td style="text-align:center; vertical-align:middle;">CAS-10-2014-DDC-C <a href="../documentos/convocatorias/cas/2014/10/CAS_10_2014.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>08/07/2014 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2014/10/RESULTADO_FINAL_CAS_10_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>07/07/2014 EV. CURRICULAR. <a style="color: green;" href="../documentos/convocatorias/cas/2014/10/EVAL_CURRI_CAS_10_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">30/06/2014</td>
                <td style="text-align:center; vertical-align:middle;">CAS-09-2014-DDC-C <a href="../documentos/convocatorias/cas/2014/09/CAS_09_2014.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>COMUNICADO Nº 02 <a style="color: green;" href="../documentos/convocatorias/cas/2014/09/COMUNICADO_02_CAS_09_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>COMUNICADO Nº 01 <a style="color: green;" href="../documentos/convocatorias/cas/2014/09/COMUNICADO_01_CAS_09_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>23/07/2014 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2014/09/RESULTADO_FINAL_CAS_09_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>22/07/2014 EV. CURRICULAR <a style="color: green;" href="../documentos/convocatorias/cas/2014/09/EVAL_CURRI_CAS_09_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">09/06/2014</td>
                <td style="text-align:center; vertical-align:middle;">CAS-08-2014-DDC-C <a href="../documentos/convocatorias/cas/2014/08/CAS_08_2014.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>COMUNICADO Nº 02 <a style="color: green;" href="../documentos/convocatorias/cas/2014/08/COMUNICADO_02_CAS_08_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>COMUNICADO Nº 01 <a style="color: green;" href="../documentos/convocatorias/cas/2014/08/COMUNICADO_01_CAS_08_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>20/06/2014 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2014/08/RESULTADO_FINAL_CAS_08_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>19/06/2014 EV. CURRICULAR <a style="color: green;" href="../documentos/convocatorias/cas/2014/08/EVAL_CURRI_CAS_08_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">03/06/2014</td>
                <td style="text-align:center; vertical-align:middle;">CAS-07-2014-DDC-C <a href="../documentos/convocatorias/cas/2014/07/CAS_07_2014.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>COMUNICADO Nº 03 <a style="color: green;" href="../documentos/convocatorias/cas/2014/07/COMUNICADO_03_CAS_07_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>COMUNICADO Nº 02 <a style="color: green;" href="../documentos/convocatorias/cas/2014/07/COMUNICADO_02_CAS_07_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>COMUNICADO Nº 01 <a style="color: green;" href="../documentos/convocatorias/cas/2014/07/COMUNICADO_01_CAS_07_2014.pdf" target="_blank">VER</a></td>
                        </tr>
                        <tr>
                            <td>17/06/2014 FINAL. <a style="color: green;" href="../documentos/convocatorias/cas/2014/07/RESULTADO_FINAL_CAS_07_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>13/06/2014 EV. CURRICULAR <a style="color: green;" href="../documentos/convocatorias/cas/2014/07/EVAL_CURRI_CAS_07_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">28/05/2014</td>
                <td style="text-align:center; vertical-align:middle;">CAS-06-2014-DDC-C <a href="../documentos/convocatorias/cas/2014/06/CAS_06_2014.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>10/06/2014 FINAL<a style="color: green;" href="../documentos/convocatorias/cas/2014/06/RESULTADO_FINAL_CAS_06_2014.pdf" target="_blank">VER</a></td>
                        </tr>
                        <tr>
                            <td>06/06/2014 EV. CURRICULAR <a style="color: green;" href="../documentos/convocatorias/cas/2014/EVAL_CURRI_CAS_06_2014.pdf" target="_blank">VER</a></td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">23/05/2014</td>
                <td style="text-align:center; vertical-align:middle;">CAS-05-2014-DDC-C <a href="../documentos/convocatorias/cas/2014/05/CAS_05_2014.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>COMUNICADO Nº 01 <a style="color: green;" href="../documentos/convocatorias/cas/2014/05/COMUNICADO_CAS_05_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>23/05/2014 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2014/05/RESULTADO_FINAL_CAS_05_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>25/05/2014 EV. CURRICULAR <a style="color: green;" href="../documentos/convocatorias/cas/2014/05/EVAL_CURRI_CAS_05_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">03/04/2014</td>
                <td style="text-align:center; vertical-align:middle;">CAS-04-2014-DDC-C <a href="../documentos/convocatorias/cas/2014/04/CAS_04_2014.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>COMUNICADO Nº 02 <a href="../documentos/convocatorias/cas/2014/04/COMUNICADO_02_CAS_04_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>COMUNICADO Nº 01 <a style="color: green;" href="../documentos/convocatorias/cas/2014/04/COMUNICADO_01_CAS_04_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>16/04/2014 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2014/04/RESULTADO_FINAL_CAS_04_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>14/04/2014 EV. CURRICULAR <a style="color: green;" href="../documentos/convocatorias/cas/2014/04/EVAL_CURRI_CAS_04_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">28/03/2014</td>
                <td style="text-align:center; vertical-align:middle;">CAS-03-2014-DDC-C <a href="../documentos/convocatorias/cas/2014/03/CAS_03_2014.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>COMUNICADO Nº 02 <a style="color: green;" href="../documentos/convocatorias/cas/2014/03/COMUNICADO_02_CAS_03_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>COMUNICADO Nº 01 <a style="color: green;" href="../documentos/convocatorias/cas/2014/03/COMUNICADO_01_CAS_03_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>25/04/2014 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2014/03/RESULTADO_FINAL_CAS_03_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>23/04/2014 EV. CURRICULAR <a style="color: green;" href="../documentos/convocatorias/cas/2014/03/EVAL_CURRI_CAS_03_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">27/02/2014</td>
                <td style="text-align:center; vertical-align:middle;">CAS-02-2014-DDC-C <a href="../documentos/convocatorias/cas/2014/02/CAS_02_2014.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>COMUNICADO Nº 05 <a style="color: green;" href="../documentos/convocatorias/cas/2014/02/COMUNICADO_05_CAS_02_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>COMUNICADO Nº 04 <a style="color: green;" href="../documentos/convocatorias/cas/2014/02/COMUNICADO_04_CAS_02_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>COMUNICADO Nº 03 <a style="color: green;" href="../documentos/convocatorias/cas/2014/02/COMUNICADO_03_CAS_02_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>COMUNICADO Nº 02 <a style="color: green;" href="../documentos/convocatorias/cas/2014/02/COMUNICADO_02_CAS_02_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>COMUNICADO Nº 01 <a style="color: green;" href="../documentos/convocatorias/cas/2014/02/COMUNICADO_01_CAS_02_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>18/03/2014 EV. CURRICULAR <a style="color: green;" href="../documentos/convocatorias/cas/2014/02/EVAL_CURRI_CAS_02_2014.pdf" target="_blank">VER</a><br>
                            </td></tr>
                        <tr>
                            <td>21/03/2014 EV. FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2014/02/RESULTADO_FINAL_CAS_02_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">21/02/2014</td>
                <td style="text-align:center; vertical-align:middle;">CAS-01-2014-DDC-C <a href="../documentos/convocatorias/cas/2014/01/CAS_1_2014.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>COMUNICADO Nº 05 <a style="color: green;" href="../documentos/convocatorias/cas/2014/01/COMUNICADO_05_CAS_01_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>COMUNICADO Nº 04 <a style="color: green;" href="../documentos/convocatorias/cas/2014/01/COMUNICADO_04_CAS_01_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>COMUNICADO Nº 03 <a style="color: green;" href="../documentos/convocatorias/cas/2014/01/COMUNICADO_03_CAS_01_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>COMUNICADO Nº 02 <a style="color: green;" href="../documentos/convocatorias/cas/2014/01/COMUNICADO_02_CAS_01_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>COMUNICADO Nº 01 <a style="color: green;" href="../documentos/convocatorias/cas/2014/01/COMUNICADO_01_CAS_01_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>05/03/2014 EV. CURRICULAR <a style="color: green;" href="../documentos/convocatorias/cas/2014/01/EVAL_CURRI_CAS_01_2014.pdf" target="_blank">VER</a><br>
                            </td></tr>
                        <tr>
                            <td>11/03/2014 EV. FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2014/01/RESULTADO_FINAL_CAS_01_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <h6 class="accordion-toggle">CONVOCATORIA CAS 2013</h6>
    <div class="accordion-content" style>
        <table border="0">
            <tbody>
            <tr style="background-color:#a4bf96;" align="center">
                <td>FECHA</td>
                <td>CONVOCATORIA</td>
                <td>ESTADO</td>
                <td>PUBLICACION DE RESULTADOS</td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">04/12/2013</td>
                <td style="text-align:center; vertical-align:middle;">CAS-12-2013-DDC-C <a href="../documentos/convocatorias/cas/2013/12/CAS_12_2013.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>12/12/2013 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2013/12/RESULTADO_FINAL_CAS_12_2013.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>11/12/2013 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2013/12/EVAL_CURRI_CAS_12_2013.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">02/12/2013</td>
                <td style="text-align:center; vertical-align:middle;">CAS-11-2013-DDC-C <a href="../documentos/convocatorias/cas/2013/11/CAS_11_2013.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>10/12/2013 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2013/11/RESULTADO_FINAL_CAS_11_2013.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>09/12/2013 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2013/11/EVAL_CURRI_CAS_11_2013.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">22/11/2013</td>
                <td style="text-align:center; vertical-align:middle;">CAS-10-2013-DDC-C <a href="../documentos/convocatorias/cas/2013/10/CAS_10_2013.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>COMUNICADO Nº 02 <a style="color: green;" href="../documentos/convocatorias/cas/2013/10/COMUNICADO_02_CAS_10_2013.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>COMUNICADO Nº 01 <a style="color: green;" href="../documentos/convocatorias/cas/2013/10/COMUNICADO_01_CAS_10_2013.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr><td>03/12/2013 FINAL GRUPO 2 <a style="color: green;" href="../documentos/convocatorias/cas/2013/10/RESULTADO_FINAL_CAS_10_2013_2.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>02/12/2013 FINAL GRUPO 1 <a style="color: green;" href="../documentos/convocatorias/cas/2013/10/RESULTADO_FINAL_CAS_10_2013_1.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>29/11/2013 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2013/10/EVAL_CURRI_CAS_10_2013.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                        </tr></tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">16/10/2013</td>
                <td style="text-align:center; vertical-align:middle;">CAS-09-2013-DDC-C <a href="../documentos/convocatorias/cas/2013/09/CAS_09_2013.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>COMUNICADO Nº 01 <a style="color: green;" href="../documentos/convocatorias/cas/2013/09/COMUNICADO_01_CAS_09_2013.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>08/11/2013 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2013/09/RESULTADO_FINAL_CAS_09_2013.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>07/11/2013 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2013/09/EVAL_CURRI_CAS_09_2013.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">14/10/2013</td>
                <td style="text-align:center; vertical-align:middle;">CAS-08-2013-DDC-C <a href="../documentos/convocatorias/cas/2013/08/CAS_08_2013.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>COMUNICADO Nº 01 <a style="color: green;" href="../documentos/convocatorias/cas/2013/08/COMUNICADO_01_CAS_08_2013.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>24/10/2013 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2013/08/RESULTADO_FINAL_CAS_08_2013.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>21-22/10/2013 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2013/08/EVAL_CURRI_CAS_08_2013.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">09/10/2013</td>
                <td style="text-align:center; vertical-align:middle;">CAS-07-2013-DDC-C <a href="../documentos/convocatorias/cas/2013/07/CAS_07_2013.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>16/10/2013 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2013/07/RESULTADO_FINAL_CAS_07_2013.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>15/10/2013 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2013/07/EVAL_CURRI_CAS_07_2013.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">24/09/2013</td>
                <td style="text-align:center; vertical-align:middle;">CAS-06-2013-DDC-C <a href="../documentos/convocatorias/cas/2013/06/CAS_06_2013.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>04/10/2013 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2013/06/RESULTADO_FINAL_CAS_06_2013.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>01-02/10/2013 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2013/06/EVAL_CURRI_CAS_06_2013.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">11/09/2013</td>
                <td style="text-align:center; vertical-align:middle;">CAS-05-2013-DDC-C <a href="../documentos/convocatorias/cas/2013/05/CAS_05_2013.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>COMUNICADO Nº 01 <a style="color: green;" href="../documentos/convocatorias/cas/2013/05/COMUNICADO_01_CAS_05_2013.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>19/09/2013 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2013/05/RESULTADO_FINAL_CAS_05_2013.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>18/09/2013 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2013/05/EVAL_CURRI_CAS_05_2013.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">12/09/2013</td>
                <td style="text-align:center; vertical-align:middle;">CAS-04-2013-DDC-C <a href="../documentos/convocatorias/cas/2013/04/CAS_04_2013.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>COMUNICADO Nº 01 <a style="color: green;" href="../documentos/convocatorias/cas/2013/04/COMUNICADO_01_CAS_04_2013.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>26/09/2013 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2013/04/RESULTADO_FINAL_CAS_04_2013.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>23-24/09/2013 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2013/04/EVAL_CURRI_CAS_04_2013.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">03/09/2013</td>
                <td style="text-align:center; vertical-align:middle;">CAS-03-2013-DDC-C <a href="../documentos/convocatorias/cas/2013/03/CAS_03_2013.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>COMUNICADO Nº 03 <a style="color: green;" href="../documentos/convocatorias/cas/2013/03/COMUNICADO-03-CAS_03_2013.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>COMUNICADO Nº 02 <a style="color: green;" href="../documentos/convocatorias/cas/2013/03/COMUNICADO_02_CAS_03_2013.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>COMUNICADO Nº 01 <a style="color: green;" href="../documentos/convocatorias/cas/2013/03/COMUNICADO_01_CAS_03-2013.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>13/09/2013 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2014/30/RESULTADO_FINAL_CAS_30_2014.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>12/09/2013 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2013/03/EVAL_CURRI_CAS_03_2013.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">21/08/2013</td>
                <td style="text-align:center; vertical-align:middle;">CAS-02-2013-DDC-C <a href="../documentos/convocatorias/cas/2013/02/CAS_02_2013_2.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>COMUNICADO Nº 01 <a style="color: green;" href="../documentos/convocatorias/cas/2013/02/COMUNICADO_01_CAS_02_2013_2.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>02/09/2013 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2013/02/RESULTADO_FINAL_CAS_02_2013_2.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>28/08/2013 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2013/02/EVAL_CURRI_CAS_02_2013_2.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">16/07/2013</td>
                <td style="text-align:center; vertical-align:middle;">CAS-01-2013-DDC-C <a href="../documentos/convocatorias/cas/2013/01/CAS_01_2013_2.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>COMUNICADO Nº 01 <a style="color: green;" href="../documentos/convocatorias/cas/2013/01/COMUNICADO_01_CAS_01_2013_2.jpg" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>12/08/2013 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2013/01/RESULTADO_FINAL_CAS_01_2013_2.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>08/08/2013 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2013/01/EVAL_CURRI_CAS_01_2013_2.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">13/05/2013</td>
                <td style="text-align:center; vertical-align:middle;">CAS-02-2013-DDC-C <a href="../documentos/convocatorias/cas/2013/02/CAS_02_2013.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>04/06/2013 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2013/02/RESULTADO_FINAL_CAS_02_2013.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>03/06/2013 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2013/02/EVAL_CURRI_CAS_02_2013.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">22/04/2013</td>
                <td style="text-align:center; vertical-align:middle;">CAS-01-2013-DDC-C <a href="../documentos/convocatorias/cas/2013/01/CAS_01_2013.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>17/05/2013 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2013/01/RESULTADO_FINAL_CAS_01_2013.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>14/05/2013 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2013/01/EVAL_CURRI_CAS_01_2013.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <h6 class="accordion-toggle">CONVOCATORIA CAS 2012</h6>
    <div class="accordion-content" style>
        <table border="0">
            <tbody>
            <tr style="background-color:#a4bf96;" align="center">
                <td>FECHA</td>
                <td>CONVOCATORIA</td>
                <td>ESTADO</td>
                <td>PUBLICACION DE RESULTADOS</td>
            </tr><tr>
                <td style="text-align:center; vertical-align:middle;">22/10/2012</td>
                <td style="text-align:center; vertical-align:middle;">CAS-19-2012-DDC-C <a href="../documentos/convocatorias/cas/2012/19/CAS_19_2012.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>05/11/2012 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2012/19/RESULTADO_FINAL_CAS_19_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>31/10/2012 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2012/19/EVAL_CURRI_CAS_19_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">03/10/2012</td>
                <td style="text-align:center; vertical-align:middle;">CAS-18-2012-DDC-C <a href="../documentos/convocatorias/cas/2012/18/CAS_18_2012.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>COMUNICADO Nº 01 <a style="color: green;" href="../documentos/convocatorias/cas/2012/18/COMUNICADO_01_CAS_18_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>12/10/2012 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2012/18/RESULTADO_FINAL_CAS_18_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>11/10/2012 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2012/18/EVAL_CURRI_CAS_18_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">25/09/2012</td>
                <td style="text-align:center; vertical-align:middle;">CAS-17-2012-DDC-C <a href="../documentos/convocatorias/cas/2012/17/CAS_17_2012.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>COMUNICADO Nº 01 <a style="color: green;" href="../documentos/convocatorias/cas/2012/17/COMUNICADO_01_CAS_17_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>12/10/2012 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2012/17/RESULTADO_FINAL_CAS_17_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>11/10/2012 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2012/17/EVAL_CURRI_CAS_17_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">10/09/2012</td>
                <td style="text-align:center; vertical-align:middle;">CAS-16-2012-DDC-C <a href="../documentos/convocatorias/cas/2012/16/CAS_16_2012.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>COMUNICADO Nº 01 <a style="color: green;" href="../documentos/convocatorias/cas/2012/16/COMUNICADO_01_CAS_16_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>18/09/2012 FINAL  <a style="color: green;" href="../documentos/convocatorias/cas/2012/16/RESULTADO_FINAL_CAS_16_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>17/09/2012 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2012/16/EVAL_CURRI_CAS_16_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">04/09/2012</td>
                <td style="text-align:center; vertical-align:middle;">CAS-15-2012-DDC-C <a href="../documentos/convocatorias/cas/2012/15/CAS_15_2012.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>11/09/2012 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2012/15/RESULTADO_FINAL_CAS_15_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>10/09/2012 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2012/15/EVAL_CURRI_CAS_15_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">13/08/2012</td>
                <td style="text-align:center; vertical-align:middle;">CAS-14-2012-DDC-C <a href="../documentos/convocatorias/cas/2012/14/CAS_14_2012.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>23/08/2012 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2012/14/RESULTADO_FINAL_CAS_14_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>22/08/2012 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2012/14/EVAL_CURRI_CAS_14_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">23/07/2012</td>
                <td style="text-align:center; vertical-align:middle;">CAS-13-2012-DDC-C <a href="../documentos/convocatorias/cas/2012/13/CAS_13_2012.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>07/08/2012 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2012/13/RESULTADO_FINAL_CAS_13_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>03/08/2012 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2012/13/EVAL_CURRI_CAS_13_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">22/06/2012</td>
                <td style="text-align:center; vertical-align:middle;">CAS-12-2012-DDC-C <a href="../documentos/convocatorias/cas/2012/12/CAS_12_2012.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>COMUNICADO Nº 01 <a style="color: green;" href="../documentos/convocatorias/cas/2012/12/COMUNICADO_01_CAS_12_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>08/07/2012 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2012/12/RESULTADO_FINAL_CAS_12_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>06/07/2012 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2012/12/EVAL_CURRI_CAS_12_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">12/06/2012</td>
                <td style="text-align:center; vertical-align:middle;">CAS-11-2012-DDC-C <a href="../documentos/convocatorias/cas/2012/11/CAS_11_2012.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>COMUNICADO Nº 01 <a style="color: green;" href="../documentos/convocatorias/cas/2012/11/COMUNICADO_01_CAS_11_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>26/06/2012 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2012/11/RESULTADO_FINAL_CAS_11_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>21/06/2012 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2012/11/EVAL_CURRI_CAS_11_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">01/06/2012</td>
                <td style="text-align:center; vertical-align:middle;">CAS-10-2012-DDC-C <a href="../documentos/convocatorias/cas/2012/10/CAS_10_2012.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>COMUNICADO Nº 01 <a style="color: green;" href="../documentos/convocatorias/cas/2012/10/COMUNICADO_01_CAS_10_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>13/06/2012 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2012/10/RESULTADO_FINAL_CAS_10_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>12/06/2012 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2012/10/EVAL_CURRI_CAS_10_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">21/05/2012</td>
                <td style="text-align:center; vertical-align:middle;">CAS-09-2012-DDC-C <a href="../documentos/convocatorias/cas/2012/09/CAS_09_2012.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>31/05/2012 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2012/09/RESULTADO_FINAL_CAS_09_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>29/05/2012 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2012/09/EVAL_CURRI_CAS_09_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">04/05/2012</td>
                <td style="text-align:center; vertical-align:middle;">CAS-08-2012-DDC-C <a href="../documentos/convocatorias/cas/2012/08/CAS_08_2012.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>11/05/2012 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2012/08/RESULTADO_FINAL_CAS_08_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>10/05/2012 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2012/08/EVAL_CURRI_CAS_08_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">18/04/2012</td>
                <td style="text-align:center; vertical-align:middle;">CAS-07-2012-DDC-C <a href="../documentos/convocatorias/cas/2012/07/CAS_07_2012.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>COMUNICADO Nº 01 <a style="color: green;" href="../documentos/convocatorias/cas/2012/07/COMUNICADO_01_CAS_07_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>04/05/2012 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2012/07/RESULTADO_FINAL_CAS_07_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>27/04/2012 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2012/07/EVAL_CURRI_CAS_07_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">29/03/2012</td>
                <td style="text-align:center; vertical-align:middle;">CAS-06-2012-DDC-C <a href="../documentos/convocatorias/cas/2012/06/CAS_06_2012.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>13/04/2012 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2012/06/RESULTADO_FINAL_CAS_06_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>12/04/2012 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2012/06/EVAL_CURRI_CAS_06_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">21/03/2012</td>
                <td style="text-align:center; vertical-align:middle;">CAS-05-2012-DDC-C <a href="../documentos/convocatorias/cas/2012/05/CAS_05_2012.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>28/03/2012 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2012/05/RESULTADO_FINAL_CAS_05_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>27/03/2012 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2012/05/EVAL_CURRI_CAS_05_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">19/03/2012</td>
                <td style="text-align:center; vertical-align:middle;">CAS-04-2012-DDC-C <a href="../documentos/convocatorias/cas/2012/04/CAS_04_2012.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>COMUNICADO Nº 01 <a style="color: green;" href="../documentos/convocatorias/cas/2012/04/COMUNICADO_01_CAS_04_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>09/04/2012 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2012/04/RESULTADO_FINAL_CAS_04_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>29/03/2012 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2012/04/EVAL_CURRI_CAS_04_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">21/03/2012</td>
                <td style="text-align:center; vertical-align:middle;">CAS-03-2012-DDC-C <a href="../documentos/convocatorias/cas/2012/03/CAS_03_2012.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>26/03/2012 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2012/03/RESULTADO_FINAL_CAS_03_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>22/03/2012 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2012/03/EVAL_CURRI_CAS_03_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">20/02/2012</td>
                <td style="text-align:center; vertical-align:middle;">CAS-02-2012-DDC-C <a href="../documentos/convocatorias/cas/2012/02/CAS_02_2012.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>COMUNICADO Nº 01 <a style="color: green;" href="../documentos/convocatorias/cas/2012/02/COMUNICADO_01_CAS_02_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>01/03/2012 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2012/02/RESULTADO_FINAL_CAS_02_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>28/02/2012 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2012/02/EVAL_CURRI_CAS_02_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; vertical-align:middle;">15/02/2012</td>
                <td style="text-align:center; vertical-align:middle;">CAS-01-2012-DDC-C <a href="../documentos/convocatorias/cas/2012/01/CAS_01_2012.pdf" target="_blank"><img style="border: 0px; vertical-align: top;" src="../documentos/images/list.png" alt="" width="20" height="20" border="0"></a>
                </td>
                <td style="text-align:center; vertical-align:middle;">..:: CERRADO ::..</td>
                <td>
                    <table style="width: 100%;" border="0">
                        <tbody>
                        <tr>
                            <td>COMUNICADO Nº 01 <a style="color: green;" href="../documentos/convocatorias/cas/2012/01/COMUNICADO_01_CAS_01_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>01/03/2012 FINAL <a style="color: green;" href="../documentos/convocatorias/cas/2012/01/RESULTADO_FINAL_CAS_01_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        <tr>
                            <td>23/02/2012 EV. CURRICULAR <a style="color: green; font-family: Verdana,Arial,Helvetica,sans-serif;" href="../documentos/convocatorias/cas/2012/01/EVAL_CURRI_CAS_01_2012.pdf" target="_blank">VER</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<p>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function($) {
            $('#accordion').find('.accordion-toggle').click(function(){
                $(this).next().slideToggle('fast');
                $(".accordion-content").not($(this).next()).slideUp('fast');
                //window.scrollTo(0,0);
            });
        });
    </script>
</p>

<style>
    .accordion-toggle {
        cursor: pointer;
        margin: 0;
        background-color: #5e2129;
        font-size:14px;
        border-bottom: 1px solid #a4bf96;
        padding:5px 5px 5px 5px;
        color: white;
    }
    .accordion-content {
        display: none;
    }
    .accordion-content.default {
        display: block;
    }
    table {
        width: 100%;
        font-size:12px;
        font-family: Tahoma, Geneva, sans-serif;
    }
</style>

<p>
    <br>
</p>