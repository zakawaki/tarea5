<?php include('../includes/header.php'); ?>

<div class="container mt-5">
  <h2>Conversión de Monedas 💰</h2>
  <form method="GET" class="mb-3">
    <label for="cantidad">Cantidad en USD ($):</label>
    <input type="number" step="0.01" name="cantidad" id="cantidad" class="form-control" required>
    <button type="submit" class="btn btn-success mt-2">Convertir</button>
  </form>

  <?php
  if (isset($_GET['cantidad'])) {
    $cantidad = floatval($_GET['cantidad']);

    if ($cantidad <= 0) {
      echo "<div class='alert alert-warning mt-3'>Introduce una cantidad válida mayor a cero.</div>";
    } else {
      $url = "https://api.exchangerate.host/latest?base=USD";
      $response = @file_get_contents($url);

      if ($response !== false) {
        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE || !isset($data['rates'])) {
          echo "<div class='alert alert-danger mt-3'>Error al procesar la respuesta de la API.</div>";
        } else {
          $dop = $data['rates']['DOP'] ?? null;
          $eur = $data['rates']['EUR'] ?? null;
          $mxn = $data['rates']['MXN'] ?? null;

          if ($dop && $eur && $mxn) {
            echo "
            <div class='alert alert-light mt-3'>
              <p><strong>USD 💵: $" . number_format($cantidad, 2) . "</strong></p>
              <p>DOP 🇩🇴: <strong>" . number_format($cantidad * $dop, 2) . " RD$</strong></p>
              <p>EUR 🇪🇺: <strong>" . number_format($cantidad * $eur, 2) . " €</strong></p>
              <p>MXN 🇲🇽: <strong>" . number_format($cantidad * $mxn, 2) . " $</strong></p>
            </div>";
          } else {
            echo "<div class='alert alert-warning mt-3'>No se pudieron obtener todas las tasas de cambio requeridas.</div>";
          }
        }
      } else {
        echo "<div class='alert alert-danger mt-3'>No se pudo conectar con la API de tasas de cambio.</div>";
      }
    }
  }
  ?>
</div>

<?php include('../includes/footer.php'); ?>


