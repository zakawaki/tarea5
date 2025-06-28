<?php include('../includes/header.php'); ?>

<div class="container mt-5">
  <h2>Buscar Pokémon ⚡</h2>
  <form method="GET" class="mb-3">
    <label for="pokemon">Nombre del Pokémon:</label>
    <input type="text" name="pokemon" id="pokemon" class="form-control" required>
    <button type="submit" class="btn btn-warning mt-2">Buscar</button>
  </form>

  <?php
  if (isset($_GET['pokemon'])) {
    $pokemonInput = trim($_GET['pokemon']);

    if (strlen($pokemonInput) < 2) {
      echo "<div class='alert alert-warning mt-3'>Por favor, introduce un nombre válido de Pokémon.</div>";
    } else {
      $pokemon = strtolower(htmlspecialchars($pokemonInput));
      $url = "https://pokeapi.co/api/v2/pokemon/$pokemon";
      $response = @file_get_contents($url);

      if ($response !== false) {
        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE || !isset($data['name'])) {
          echo "<div class='alert alert-danger mt-3'>Error al procesar los datos del Pokémon.</div>";
        } else {
          $nombre = ucfirst($data['name']);
          $imagen = $data['sprites']['front_default'] ?? '';
          $experiencia = $data['base_experience'] ?? 'N/A';
          $habilidades = isset($data['abilities']) ? array_map(fn($h) => $h['ability']['name'], $data['abilities']) : [];
          $audio = "https://play.pokemonshowdown.com/audio/cries/$pokemon.mp3";

          echo "
          <div class='card mt-3 p-3 bg-light'>
            <h4>$nombre</h4>";

          if ($imagen) {
            echo "<img src='$imagen' alt='$nombre' width='150'>";
          } else {
            echo "<p><em>Imagen no disponible.</em></p>";
          }

          echo "
            <p>Experiencia base: $experiencia</p>
            <p>Habilidades: " . (empty($habilidades) ? 'Ninguna' : implode(', ', $habilidades)) . "</p>
            <audio controls>
              <source src='$audio' type='audio/mpeg'>
              Tu navegador no soporta audio.
            </audio>
          </div>";
        }
      } else {
        echo "<div class='alert alert-danger mt-3'>Pokémon no encontrado o error al conectar con la API. Intenta con otro nombre.</div>";
      }
    }
  }
  ?>
</div>

<?php include('../includes/footer.php'); ?>

