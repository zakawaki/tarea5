<?php include('../includes/header.php'); ?>

<div class="container mt-5">
  <h2>Predicción de Edad 🎂</h2>
  <form method="GET" class="mb-3">
    <label for="name">Introduce un nombre:</label>
    <input type="text" name="name" id="name" class="form-control" required>
    <button type="submit" class="btn btn-success mt-2">Consultar Edad</button>
  </form>

  <?php
  if (isset($_GET['name'])) {
    $nameInput = trim($_GET['name']);

    if (strlen($nameInput) < 2) {
      echo "<div class='alert alert-warning mt-3'>Por favor, introduce un nombre válido (mínimo 2 letras).</div>";
    } else {
      $name = htmlspecialchars($nameInput);
      $url = "https://api.agify.io/?name=" . urlencode($name);
      $response = @file_get_contents($url);

      if ($response !== false) {
        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE || !isset($data['age']) || $data['age'] === null) {
          echo "<div class='alert alert-danger mt-3'>No se pudo estimar la edad para ese nombre. Intenta con otro.</div>";
        } else {
          $age = $data['age'];
          // Clasificación por edad
          if ($age < 18) {
            $categoria = "Joven 👶";
            $img = "https://cdn-icons-png.flaticon.com/512/2900/2900620.png";
          } elseif ($age < 60) {
            $categoria = "Adulto 🧑";
            $img = "https://cdn-icons-png.flaticon.com/512/3048/3048122.png";
          } else {
            $categoria = "Anciano 👴";
            $img = "https://cdn-icons-png.flaticon.com/512/4140/4140048.png";
          }

          echo "
          <div class='alert alert-info mt-3'>
            Nombre: <strong>$name</strong><br>
            Edad estimada: <strong>$age años</strong><br>
            Categoría: <strong>$categoria</strong><br>
            <img src='$img' alt='$categoria' width='100' class='mt-3'>
          </div>";
        }
      } else {
        echo "<div class='alert alert-danger mt-3'>No se pudo conectar con la API de edad. Intenta más tarde.</div>";
      }
    }
  }
  ?>
</div>

<?php include('../includes/footer.php'); ?>
