<?php include('../includes/header.php'); ?>

<div class="container mt-5">
  <h2>Predicción de Género 👦👧</h2>
  <form method="GET" class="mb-3">
    <label for="name">Introduce un nombre:</label>
    <input type="text" name="name" id="name" class="form-control" required>
    <button type="submit" class="btn btn-primary mt-2">Consultar</button>
  </form>

  <?php
  if (isset($_GET['name'])) {
    $nameInput = trim($_GET['name']);

    if (strlen($nameInput) < 2) {
      echo "<div class='alert alert-warning mt-3'>Por favor, introduce un nombre válido con al menos 2 caracteres.</div>";
    } else {
      $name = htmlspecialchars($nameInput);
      $url = "https://api.genderize.io/?name=" . urlencode($name);
      $response = @file_get_contents($url);

      if ($response !== false) {
        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE || !isset($data['gender'])) {
          echo "<div class='alert alert-danger mt-3'>No se pudo procesar la respuesta. Intenta con otro nombre.</div>";
        } else {
          $gender = $data['gender'];
          $emoji = '🤔';
          $color = 'secondary';

          if ($gender === 'male') {
            $emoji = '💙';
            $color = 'primary';
          } elseif ($gender === 'female') {
            $emoji = '💖';
            $color = 'pink';
          }

          $genderDisplay = $gender ? ucfirst($gender) : 'No determinado';

          echo "<div class='alert alert-$color mt-3'>
                  Nombre: <strong>$name</strong><br>
                  Género estimado: <strong>$genderDisplay</strong> $emoji
                </div>";
        }
      } else {
        echo "<div class='alert alert-danger mt-3'>Error al conectar con la API. Intenta más tarde.</div>";
      }
    }
  }
  ?>
</div>

<?php include('../includes/footer.php'); ?>
