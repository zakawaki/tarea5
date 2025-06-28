<?php include('../includes/header.php'); ?>

<div class="container mt-5">
  <h2>Datos de un País 🌍</h2>
  <form method="GET" class="mb-3">
    <label for="pais">Nombre del país (en inglés):</label>
    <input type="text" name="pais" id="pais" class="form-control" required>
    <button type="submit" class="btn btn-primary mt-2">Buscar</button>
  </form>

  <?php
  if (isset($_GET['pais'])) {
    $paisInput = trim($_GET['pais']);

    if (strlen($paisInput) < 2) {
      echo "<div class='alert alert-warning mt-3'>Por favor, introduce un nombre de país válido.</div>";
    } else {
      $pais = htmlspecialchars($paisInput);
      $url = "https://restcountries.com/v3.1/name/" . urlencode($pais);
      $response = @file_get_contents($url);

      if ($response !== false) {
        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE || empty($data) || !isset($data[0])) {
          echo "<div class='alert alert-danger mt-3'>Error al procesar la información del país.</div>";
        } else {
          $info = $data[0];

          $nombre   = $info['name']['common'] ?? 'Desconocido';
          $capital  = $info['capital'][0] ?? 'Desconocida';
          $poblacion = isset($info['population']) ? number_format($info['population']) : 'N/A';
          $bandera  = $info['flags']['png'] ?? '';
          $moneda   = isset($info['currencies']) ? array_values($info['currencies'])[0]['name'] ?? 'No disponible' : 'No disponible';

          echo "
          <div class='card mt-3 p-3'>
            <h4>$nombre</h4>";

          if ($bandera) {
            echo "<img src='$bandera' width='150' alt='Bandera de $nombre'>";
          } else {
            echo "<p><em>Bandera no disponible.</em></p>";
          }

          echo "
            <p>Capital: $capital</p>
            <p>Población: $poblacion</p>
            <p>Moneda: $moneda</p>
          </div>";
        }
      } else {
        echo "<div class='alert alert-danger mt-3'>No se pudieron obtener los datos del país. Intenta con otro nombre.</div>";
      }
    }
  }
  ?>
</div>

<?php include('../includes/footer.php'); ?>


