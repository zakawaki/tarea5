<?php include('../includes/header.php'); ?>

<div class="container mt-5">
  <h2>Clima en República Dominicana 🌦️</h2>
  <form method="GET" class="mb-3">
    <label for="ciudad">Ciudad:</label>
    <input type="text" name="ciudad" id="ciudad" class="form-control" required>
    <button type="submit" class="btn btn-info mt-2">Consultar Clima</button>
  </form>

  <?php
  if (isset($_GET['ciudad'])) {
    $ciudadInput = trim($_GET['ciudad']);

    if (strlen($ciudadInput) < 2) {
      echo "<div class='alert alert-warning mt-3'>Por favor, introduce una ciudad válida con al menos 2 letras.</div>";
    } else {
      $ciudad = htmlspecialchars($ciudadInput);
      $apiKey = 'TU_API_KEY'; // ⚠️ Reemplaza con tu clave real de OpenWeather
      $url = "https://api.openweathermap.org/data/2.5/weather?q=$ciudad,DO&units=metric&lang=es&appid=$apiKey";
      $response = @file_get_contents($url);

      if ($response !== false) {
        $data = json_decode($response, true);

        if (isset($data['cod']) && $data['cod'] === 200) {
          $clima = $data['weather'][0]['main'];
          $desc = ucfirst($data['weather'][0]['description']);
          $icon = $data['weather'][0]['icon'];
          $temp = $data['main']['temp'];

          $emoji = match ($clima) {
            'Clear' => '☀️',
            'Clouds' => '☁️',
            'Rain', 'Drizzle', 'Thunderstorm' => '🌧️',
            'Snow' => '❄️',
            default => '🌡️',
          };

          echo "
          <div class='alert alert-light mt-3'>
            <h4><strong>$ciudad</strong> - $emoji</h4>
            <p>Condición: <strong>$desc</strong></p>
            <p>Temperatura: <strong>$temp °C</strong></p>
            <img src='https://openweathermap.org/img/wn/$icon@2x.png' alt='icono del clima'>
          </div>";
        } else {
          echo "<div class='alert alert-warning mt-3'>No se encontró la ciudad <strong>$ciudad</strong> en República Dominicana. Intenta con otra.</div>";
        }
      } else {
        echo "<div class='alert alert-danger mt-3'>No se pudo conectar con la API de clima. Verifica tu conexión o tu API Key.</div>";
      }
    }
  }
  ?>
</div>

<?php include('../includes/footer.php'); ?>


