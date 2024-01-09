<?php

// Función para descifrar un mensaje cifrado utilizando AES
function descifrarAES($mensajeCifrado, $clave) {
    // Decodificar el mensaje cifrado desde base64
    $mensajeCifrado = base64_decode($mensajeCifrado);

    // Extraer el vector de inicialización (IV) del mensaje cifrado
    $iv = substr($mensajeCifrado, 0, openssl_cipher_iv_length('aes-256-cbc'));

    // Extraer el mensaje cifrado sin el IV
    $mensajeCifrado = substr($mensajeCifrado, openssl_cipher_iv_length('aes-256-cbc'));

    // Intentar descifrar el mensaje utilizando AES-256-CBC y la clave proporcionada
    $mensajeDescifrado = openssl_decrypt($mensajeCifrado, 'aes-256-cbc', $clave, 0, $iv);

    // Verificar si la clave es correcta
    if ($mensajeDescifrado === false) {
        // La clave no es correcta, puedes manejar esto de la manera que desees (por ejemplo, mostrar un mensaje de error)
        $mensajeDescifrado = "Error: La clave proporcionada no es correcta.";
    }

    return $mensajeDescifrado;
}

// Verificar si el formulario se ha enviado y si se han proporcionado el mensaje cifrado y la clave
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["mensajeCifrado"], $_POST["clave"])) {
    // Obtener el mensaje cifrado y la clave del formulario
    $mensajeCifrado = $_POST["mensajeCifrado"];
    $claveSecreta = $_POST["clave"];

    // Descifrar el mensaje utilizando la función descifrarAES
    $mensajeDescifrado = descifrarAES($mensajeCifrado, $claveSecreta);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descifrado</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <div class="form">
    <h1>Mensaje Descifrado</h1>
    <?php if (isset($mensajeDescifrado)) : ?>
        <!-- Mostrar el mensaje descifrado si está presente -->
        <p>Mensaje descifrado: <?php echo $mensajeDescifrado; ?></p>
    <?php endif; ?>

    <!-- Botón para volver al inicio -->
    <a href="index.html"><button>Volver al Inicio</button></a>
    </div>

</body>
</html>
