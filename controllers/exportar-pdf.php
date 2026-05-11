<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/vendor/autoload.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/includes/conexion.php');

if(isset($_GET['id'])){
    $id_turno = $_GET['id'];
    // Vuelvo a consultar
    $sql = "SELECT t.id,
                    e.nombre as especialidad, 
                    m.nombre as med_nombre, m.apellido as med_apellido, 
                    t.fecha_turno, 
                    p.nombre as pac_nombre, p.apellido as pac_apellido
            FROM turnos t 
            JOIN medicos m ON t.id_medico = m.cod 
            JOIN especialidad e ON m.id_especialidad = e.cod
            JOIN pacientes p ON t.id_paciente = p.id
            WHERE t.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_turno);
    $stmt->execute();
    $turno = $stmt->get_result()->fetch_assoc();

    if ($turno) {
        // Inicia PDF (el que instale)
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Esto añade una página
        $pdf->SetCreator('OdontoPlus');
        $pdf->SetTitle('Comprobante de Turno');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        
        $pdf->SetMargins(15, 15, 15);
        $pdf->AddPage();

        // Para problema con fuentes
        $pdf->SetFont('helvetica', '', 12);

        // Le digo donde buscar la imagen que quiero insertar
        $logoPath = $_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/public/img/logo.png';

        // Le paso el html al motor pdf
        $html = '
        <table border="0" cellpadding="5">
            <tr>
                <td width="30%">
                    <img src="' . $logoPath .'" width="100">
                </td>
                <td width="70%" style="text-align: right;">
                    <h1>COMPROBANTE DE TURNO</h1>
                    <p><b>Odonto Plus - Clínica Dental</b></p>
                    <p>Fecha de emisión: ' . date("d/m/Y") . '</p>
                </td>
            </tr>
        </table>
        <hr>
        <br><br>
        <table border="0" cellpadding="10" style="background-color: #f2f2f2;">
            <tr>
                <td>
                    <h3>Detalles del Turno #' . $turno['id'] . '</h3>
                    <p><b>Paciente:</b> ' . $turno['pac_nombre'] . ' ' . $turno['pac_apellido'] . '</p>
                    <p><b>Especialidad:</b> ' . $turno['especialidad'] . '</p>
                    <p><b>Profesional:</b> Dr. ' . $turno['med_nombre'] . ' ' . $turno['med_apellido'] . '</p>
                    <p><b>Fecha y Hora:</b> ' . date("d/m/Y H:i", strtotime($turno['fecha_turno'])) . ' hs</p>
                </td>
            </tr>
        </table>
        <br><br>
        <p style="text-align: center; color: #666;">Por favor, asista 15 minutos antes de su turno.</p>
        ';

        // Pongo el html en el pdf
        $pdf->writeHTML($html, true, false, true, false, '');

        // Salida
        $pdf->Output('turno_'.$id_turno.'.pdf', 'D'); 
        exit;
    }
}