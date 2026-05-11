<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/config.php');
//Sin Composer
require ($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/vendor/PHPMailer-master/src/Exception.php');
require ($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/vendor/PHPMailer-master/src/PHPMailer.php');
require ($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/vendor/PHPMailer-master/src/SMTP.php');

//Seguridad contraseña
require_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/config.local.php');
//PDF
require_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/vendor/autoload.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/includes/conexion.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Se genera el pdf nuevamente pero configuro para enviar por e-mail
if(isset($_GET['id'])){
    $id_turno = $_GET['id'];
    // Vuelvo a consultar pero extraigo el e-mail
    $sql = "SELECT t.id,
                    e.nombre as especialidad, 
                    m.nombre as med_nombre, m.apellido as med_apellido, 
                    t.fecha_turno, 
                    p.nombre as pac_nombre, p.apellido as pac_apellido,
					p.email as pac_email
            FROM turnos t 
            JOIN medicos m ON t.id_medico = m.cod 
            JOIN especialidad e ON m.id_especialidad = e.cod
            JOIN pacientes p ON t.id_paciente = p.id
            WHERE t.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_turno);
    $stmt->execute();
    $turno = $stmt->get_result()->fetch_assoc();
}


if (isset($turno) && $turno) {
    
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->SetCreator('OdontoPlus');
    $pdf->SetTitle('Comprobante de Turno');
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
        
    $pdf->SetMargins(15, 15, 15);
    $pdf->AddPage();

    $pdf->SetFont('helvetica', '', 12);

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

    $pdf->writeHTML($html, true, false, true, false, '');
    
    // Guardo el pdf en un string
    $pdf_doc = $pdf->Output('comprobante.pdf', 'S');

    // 2. Configuración de PHPMailer
    $mail = new PHPMailer(true);

    try {

        $mail->CharSet = 'UTF-8'; // Esto arregla los acentos
        $mail->Encoding = 'base64';

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USER; 
        $mail->Password   = SMTP_PASS; // App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Destinatarios
        $mail->setFrom('cortinezmr@gmail.com', 'Odonto Plus');
        $mail->addAddress($turno['pac_email'], $turno['pac_nombre']); 

        // Envía el PDF que está en la variable
        $mail->addStringAttachment($pdf_doc, 'Comprobante_Turno.pdf');

        // Contenido
        $mail->isHTML(true);
        $mail->Subject = 'Solicitud de Turno - Odonto Plus';
        $mail->Body    = 'Buenos días <b>' . $turno['pac_nombre'] . '</b>, Usted ha solicitado un turno en nuestra clínica OdontoPlus. El mismo ya está reservado, en unos minutos lo confirmaremos.';

        $mail->send();
        header("Location: " . BASE_URL . "views/print-turno.php?id=" . $id_turno);
        exit;
    } catch (Exception $e) {
        echo "Error al enviar: {$mail->ErrorInfo}";
    }
}