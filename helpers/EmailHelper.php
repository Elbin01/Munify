<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Autoload de Composer
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/mail.php';

class EmailHelper {
    
    public static function enviarConfirmacionCita($destinatario, $nombreCliente, $detallesCita) {
        $mail = new PHPMailer(true);

        try {
            // Configuración del Servidor
            $mail->isSMTP();
            $mail->Host       = SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = SMTP_USER;
            $mail->Password   = SMTP_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = SMTP_PORT;
            $mail->CharSet    = 'UTF-8';

            // Destinatarios
            $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
            $mail->addAddress($destinatario, $nombreCliente);

            // Embeber imágenes
            $img1 = __DIR__ . '/../assets/Img/logo_munify/isotipo_negativo.png';
            $img2 = __DIR__ . '/../assets/Img/escuedo_gobierno.png';
            
            if (file_exists($img1)) $mail->addEmbeddedImage($img1, 'logo_munify');
            if (file_exists($img2)) $mail->addEmbeddedImage($img2, 'escudo_gobierno');

            // Contenido
            $mail->isHTML(true);
            $mail->Subject = 'Confirmación de Solicitud de Cita - Munify';
            
            $cuerpo = "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #e2e8f0; border-radius: 10px; overflow: hidden;'>
                <div style='background-color: #1C3166; padding: 20px; text-align: center;'>
                    <img src='cid:logo_munify' alt='Munify' style='height: 50px; margin-right: 20px; vertical-align: middle;'>
                    <img src='cid:escudo_gobierno' alt='Gobierno' style='height: 40px; vertical-align: middle; border-left: 1px solid rgba(255,255,255,0.3); padding-left: 20px;'>
                </div>
                <div style='padding: 30px;'>
                    <h3 style='color: #1C3166; text-align: center;'>¡Hola, $nombreCliente!</h3>
                    <p>Tu solicitud de trámite ha sido <strong>ACEPTADA</strong>.</p>
                    <hr style='border: 0; border-top: 1px solid #eee;'>
                    <p style='font-size: 16px; color: #1C3166; text-align: center; margin: 25px 0;'>
                        <strong>¡Te esperamos el día {$detallesCita['fecha']} a las {$detallesCita['hora']}!</strong>
                    </p>
                    <p style='margin-top: 20px;'>Por favor, preséntate puntual en las oficinas de la Alcaldía con tu documento de identidad.</p>
                </div>
                <div style='background-color: #f1f5f9; padding: 15px; text-align: center;'>
                    <p style='font-size: 12px; color: #64748b; margin: 0;'>Alcaldía Municipal - Munify</p>
                </div>
            </div>";

            $mail->Body = $cuerpo;

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Error al enviar correo: {$mail->ErrorInfo}");
            return false;
        }
    }

    public static function enviarNotificacionRecibido($destinatario, $nombreTramite, $detallesCita) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = SMTP_USER;
            $mail->Password   = SMTP_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = SMTP_PORT;
            $mail->CharSet    = 'UTF-8';

            $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
            $mail->addAddress($destinatario);

            // Embeber imágenes
            $img1 = __DIR__ . '/../assets/Img/logo_munify/isotipo_negativo.png';
            $img2 = __DIR__ . '/../assets/Img/escuedo_gobierno.png';
            
            if (file_exists($img1)) $mail->addEmbeddedImage($img1, 'logo_munify');
            if (file_exists($img2)) $mail->addEmbeddedImage($img2, 'escudo_gobierno');

            $mail->isHTML(true);
            $mail->Subject = 'Hemos recibido tu solicitud - Munify';
            
            $cuerpo = "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #e2e8f0; border-radius: 10px; overflow: hidden;'>
                <div style='background-color: #1C3166; padding: 20px; text-align: center;'>
                    <img src='cid:logo_munify' alt='Munify' style='height: 50px; margin-right: 20px; vertical-align: middle;'>
                    <img src='cid:escudo_gobierno' alt='Gobierno' style='height: 40px; vertical-align: middle; border-left: 1px solid rgba(255,255,255,0.3); padding-left: 20px;'>
                </div>
                <div style='padding: 30px;'>
                    <h3 style='color: #1C3166; text-align: center;'>¡Solicitud Recibida!</h3>
                    <p>Tu solicitud para <strong>$nombreTramite</strong> ha sido recibida correctamente y está siendo revisada por nuestro personal.</p>
                    <hr style='border: 0; border-top: 1px solid #eee;'>
                    <p><strong>Resumen de tu solicitud:</strong></p>
                    <ul style='list-style: none; padding: 0;'>
                        <li><strong>Fecha solicitada:</strong> {$detallesCita['fecha']}</li>
                        <li><strong>Hora solicitada:</strong> {$detallesCita['hora']}</li>
                    </ul>
                    <p style='margin-top: 20px;'>Te notificaremos por este mismo medio cuando tu cita sea confirmada.</p>
                </div>
                <div style='background-color: #f1f5f9; padding: 15px; text-align: center;'>
                    <p style='font-size: 12px; color: #64748b; margin: 0;'>Alcaldía Municipal - Munify</p>
                </div>
            </div>";

            $mail->Body = $cuerpo;
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
?>
