<?php include('../includes/header.php'); ?>

<div class="container mt-5">
  <h2>Generador de Imágenes con IA 🖼️</h2>
  <form method="GET" class="mb-3">
    <label for="palabra">Palabra clave:</label>
    <input type="text" name="palabra" id="palabra" class="form-control" required>
    <button type="submit" class="btn btn-secondary mt-2">Buscar Imagen</button>
  </form>

  <?php
  if (isset($_GET['palabra'])) {
    $palabra = trim($_GET['palabra']);

    if (strlen($palabra) < 2) {
      echo "<div class='alert alert-warning mt-3'>Por favor, escribe al menos 2 caracteres.</div>";
    } else {
      $query = urlencode($palabra);
      $accessKey = 'TU_UNSPLASH_ACCESS_KEY'; // ⚠️ Reemplaza con tu clave real
      $url = "https://api.unsplash.com/photos/random?query=$query&client_id=$accessKey";

      $response = @file_get_contents($url);

      if ($response !== false) {
        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE || empty($data) || !isset($data['urls']['regular'])) {
          echo "<div class='alert alert-danger mt-3'>No se pudo procesar la imagen. Intenta otra palabra clave.</div>";
        } else {
          $imagen = $data['urls']['regular'];
          $desc = htmlspecialchars($data['alt_description'] ?? 'Imagen generada automáticamente');

          echo "
          <div class='card mt-3 p-3'>
            <img src='$imagen' class='img-fluid rounded' alt='Imagen'>
            <p class='mt-2'><strong>$desc</strong></p>
          </div>";
        }
      } else {
        echo "<div class='alert alert-danger mt-3'>Error al conectar con la API de imágenes. Verifica tu conexión o API Key.</div>";
      }
    }
  }
  ?>
</div>

<?php include('../includes/footer.php'); ?>
