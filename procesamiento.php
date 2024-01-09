<?php

// Función para cifrar un mensaje utilizando AES
function cifrarAES($mensaje, $clave) {
    // Generar un vector de inicialización (IV) aleatorio
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

    // Cifrar el mensaje usando AES-256-CBC y la clave proporcionada
    $mensajeCifrado = openssl_encrypt($mensaje, 'aes-256-cbc', $clave, 0, $iv);

    // Codificar el IV y el mensaje cifrado en base64
    return base64_encode($iv . $mensajeCifrado);
}

// Verificar si el formulario se ha enviado y si se han proporcionado el mensaje y la clave
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["mensaje"], $_POST["clave"])) {
    // Obtener el mensaje original y la clave del formulario
    $mensajeOriginal = $_POST["mensaje"];
    $claveSecreta = $_POST["clave"];

    // Cifrar el mensaje utilizando la función cifrarAES
    $mensajeCifrado = cifrarAES($mensajeOriginal, $claveSecreta);
} else {
    // Si no se ha enviado el formulario, redireccionar o mostrar un mensaje de error
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensaje Encriptado</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>

    <div class="form">
    <h1>Mensaje Encriptado</h1>

    <?php if (isset($mensajeCifrado)) : ?>
        <!-- Mostrar el mensaje cifrado si está presente -->
        <p>Mensaje cifrado: <?php echo $mensajeCifrado; ?></p>
    <?php endif; ?>

    <!-- Botón para volver al inicio -->
    <a href="index.html"><button>Volver al Inicio</button></a>
    <!-- Botón para ir a la página de desencriptar -->
    <a href="desencriptar.html"><button>Desencriptar Mensaje</button></a>
    </div>

</body>
</html>
