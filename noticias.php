<?php include('../includes/header.php'); ?>

<div class="container mt-5">
  <h2>Noticias desde WordPress 📰</h2>
  <form method="GET" class="mb-3">
    <label for="sitio">Selecciona un sitio:</label>
    <select name="sitio" id="sitio" class="form-select" required>
      <option value="">-- Elige --</option>
      <option value="https://techcrunch.com">TechCrunch</option>
      <option value="https://wptavern.com">WP Tavern</option>
    </select>
    <button type="submit" class="btn btn-dark mt-2">Cargar Noticias</button>
  </form>

  <?php
  if (isset($_GET['sitio']) && !empty($_GET['sitio'])) {
    $sitioPermitido = ['https://techcrunch.com', 'https://wptavern.com'];
    $sitio = rtrim(trim($_GET['sitio']), '/');

    if (!in_array($sitio, $sitioPermitido)) {
      echo "<div class='alert alert-warning mt-3'>Sitio no permitido. Selecciona una opción válida.</div>";
    } else {
      $apiUrl = $sitio . "/wp-json/wp/v2/posts?per_page=3";
      $response = @file_get_contents($apiUrl);

      if ($response !== false) {
        $posts = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($posts)) {
          echo "<div class='alert alert-danger mt-3'>Error al procesar la respuesta del sitio.</div>";
        } elseif (empty($posts)) {
          echo "<div class='alert alert-warning mt-3'>No se encontraron publicaciones recientes.</div>";
        } else {
          echo "<div class='mt-4'><h4>Últimas noticias de <a href='$sitio' target='_blank'>$sitio</a>:</h4>";

          foreach ($posts as $post) {
            $title = htmlspecialchars($post['title']['rendered']);
            $excerpt = strip_tags($post['excerpt']['rendered']);
            $link = htmlspecialchars($post['link']);

            echo "
            <div class='card mb-3 p-3'>
              <h5>$title</h5>
              <p>$excerpt</p>
              <a href='$link' class='btn btn-sm btn-outline-primary' target='_blank'>Leer más</a>
            </div>";
          }

          echo "</div>";
        }
      } else {
        echo "<div class='alert alert-danger mt-3'>Error al conectar con el sitio seleccionado. Asegúrate de que esté disponible.</div>";
      }
    }
  }
  ?>
</div>

<?php include('../includes/footer.php'); ?>


