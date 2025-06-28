<?php
$response = file_get_contents("https://api.agify.io/?name=jose");

if ($response !== false) {
    echo "✅ Conexión exitosa: ";
    echo $response;
} else {
    echo "❌ No se pudo conectar a la API.";
}
?>
