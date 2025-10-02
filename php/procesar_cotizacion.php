<?php
// 1. VERIFICAR QUE EL FORMULARIO FUE ENVIADO POR MÉTODO POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ----------------------------------------------------------------------
    // 2. CAPTURA DE DATOS INDIVIDUALES
    // Usamos isset() para asegurar que la variable existe y trim() para limpiar espacios
    // ----------------------------------------------------------------------
    
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : 'No especificado';
    $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : 'No especificado';
    $email = isset($_POST['email']) ? trim($_POST['email']) : 'No especificado';
    $fecha = isset($_POST['fecha']) ? trim($_POST['fecha']) : 'No especificado';
    $tipo_evento = isset($_POST['tipo_evento']) ? trim($_POST['tipo_evento']) : 'No especificado';
    $detalles = isset($_POST['detalles']) ? trim($_POST['detalles']) : 'No se proporcionaron detalles.';
    
    // ----------------------------------------------------------------------
    // 3. CAPTURA DE CHECKBOXES (Servicios Requeridos)
    // Los checkboxes se guardan como un array. Debemos revisarlo e imprimirlo.
    // ----------------------------------------------------------------------
    
    if (isset($_POST['servicios']) && is_array($_POST['servicios'])) {
        // Convierte el array de servicios seleccionados en una cadena separada por comas
        $servicios_seleccionados = implode(', ', $_POST['servicios']);
    } else {
        $servicios_seleccionados = 'Ninguno';
    }


    // ----------------------------------------------------------------------
    // 4. CONFIGURACIÓN DEL ENVÍO DE CORREO
    // ----------------------------------------------------------------------
    
    // Tu correo de destino
    $destinatario = "angeltrejo2904@gmail.com"; 
    $asunto = "NUEVA COTIZACIÓN WEB - " . $nombre;
    
    // Encabezados del correo
    $encabezados = "From: " . $email . "\r\n"; // El correo se enviará como si viniera del cliente
    $encabezados .= "Reply-To: " . $email . "\r\n";
    $encabezados .= "MIME-Version: 1.0\r\n";
    $encabezados .= "Content-Type: text/html; charset=UTF-8\r\n";
    
    
    // ----------------------------------------------------------------------
    // 5. COMPOSICIÓN DEL CUERPO DEL CORREO (Formato HTML)
    // ----------------------------------------------------------------------
    
    $cuerpo_mensaje = '
    <html>
    <head>
        <title>Nueva Solicitud de Cotización</title>
    </head>
    <body>
        <h2 style="color: #cc0000;">Nueva Solicitud de Cotización de Punto Rojo Multimedia</h2>
        
        <p>Se ha recibido una nueva solicitud de cotización para un evento. A continuación, los detalles:</p>
        
        <table border="1" cellpadding="10" cellspacing="0" width="100%" style="border-collapse: collapse;">
            <tr><td style="background-color: #f0f0f0;"><strong>Nombre Completo:</strong></td><td>' . htmlspecialchars($nombre) . '</td></tr>
            <tr><td style="background-color: #f0f0f0;"><strong>Teléfono:</strong></td><td>' . htmlspecialchars($telefono) . '</td></tr>
            <tr><td style="background-color: #f0f0f0;"><strong>Correo Electrónico:</strong></td><td>' . htmlspecialchars($email) . '</td></tr>
            <tr><td style="background-color: #f0f0f0;"><strong>Fecha del Evento:</strong></td><td>' . htmlspecialchars($fecha) . '</td></tr>
            <tr><td style="background-color: #f0f0f0;"><strong>Tipo de Evento:</strong></td><td>' . htmlspecialchars($tipo_evento) . '</td></tr>
            <tr><td style="background-color: #f0f0f0;"><strong>Servicios Requeridos:</strong></td><td>' . htmlspecialchars($servicios_seleccionados) . '</td></tr>
            <tr><td style="background-color: #f0f0f0;"><strong>Detalles del Evento:</strong></td><td colspan="3">' . htmlspecialchars($detalles) . '</td></tr>
        </table>
        
        <p style="margin-top: 20px;">*Responder a este correo enviará la respuesta directamente al cliente.</p>
    </body>
    </html>
    ';


    // ----------------------------------------------------------------------
    // 6. ENVÍO DEL CORREO Y REDIRECCIÓN
    // ----------------------------------------------------------------------
    
    if (mail($destinatario, $asunto, $cuerpo_mensaje, $encabezados)) {
        // Redirigir a una página de agradecimiento
        header("Location: gracias.html"); 
        exit;
    } else {
        // Redirigir a una página de error si el envío falla
        header("Location: error.html"); 
        exit;
    }

} else {
    // Si alguien intenta acceder al script directamente sin enviar el formulario
    echo "Acceso denegado. Por favor, utiliza el formulario de contacto.";
}
?>