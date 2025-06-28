<?php include('../includes/header.php'); ?>

<div class="container mt-5">
  <h2>Chiste Aleatorio 🤣</h2>

  <?php
  $url = "https://official-joke-api.appspot.com/random_joke";
  $response = @file_get_contents($url);

  if ($response !== false) {
    $data = json_decode($response, true);

    if (json_last_error() === JSON_ERROR_NONE && isset($data['setup']) && isset($data['punchline'])) {
      $setup = htmlspecialchars($data['setup']);
      $punchline = htmlspecialchars($data['punchline']);

      echo "
      <div class='alert alert-warning mt-4'>
        <p><strong>$setup</strong></p>
        <p>😆 <em>$punchline</em></p>
      </div>";
    } else {
      echo "<div class='alert alert-danger mt-4'>No se pudo procesar el chiste. Intenta nuevamente.</div>";
    }
  } else {
    echo "<div class='alert alert-danger mt-4'>No se pudo conectar con la API de chistes. Revisa tu conexión o intenta más tarde.</div>";
  }
  ?>
</div>

<?php include('../includes/footer.php'); ?>
