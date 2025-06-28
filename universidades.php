<?php include('../includes/header.php'); ?>

<div class="container mt-5">
  <h2>Universidades por País 🎓</h2>
  <form method="GET" class="mb-3">
    <label for="country">Introduce un país (en inglés):</label>
    <input type="text" name="country" id="country" class="form-control" required>
    <button type="submit" class="btn btn-primary mt-2">Buscar Universidades</button>
  </form>

  <?php
  if (isset($_GET['country'])) {
    $country = trim($_GET['country']);

    if (strlen($country) < 2) {
      echo "<div class='alert alert-warning mt-3'>Por favor, introduce un nombre de país válido (mínimo 2 letras).</div>";
    } else {
      $countrySafe = htmlspecialchars($country);
      $url = "http://universities.hipolabs.com/search?country=" . urlencode($countrySafe);
      $response = @file_get_contents($url);

      if ($response !== false) {
        $universities = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($universities)) {
          echo "<div class='alert alert-danger mt-3'>La respuesta de la API no es válida.</div>";
        } elseif (empty($universities)) {
          echo "<div class='alert alert-warning mt-3'>No se encontraron universidades en <strong>$countrySafe</strong>.</div>";
        } else {
          echo "<h4 class='mt-4'>Universidades en <strong>$countrySafe</strong>:</h4><ul class='list-group mt-3'>";
          foreach ($universities as $uni) {
            $name = htmlspecialchars($uni['name']);
            $domain = htmlspecialchars($uni['domains'][0]);
            $web = htmlspecialchars($uni['web_pages'][0]);

            echo "
              <li class='list-group-item'>
                <strong>$name</strong><br>
                Dominio: $domain<br>
                <a href='$web' target='_blank'>Visitar sitio web 🌐</a>
              </li>";
          }
          echo "</ul>";
        }
      } else {
        echo "<div class='alert alert-danger mt-3'>No se pudo conectar con la API. Intenta más tarde.</div>";
      }
    }
  }
  ?>
</div>

<?php include('../includes/footer.php'); ?>
