<main class="contacto-main">
  <h1 class="contacto-title">Contacto</h1>
  <form class="contacto-form" action="./process/form_data.php" method="POST">
    <label class="contacto-label" for="nombre">Nombre:</label>
    <input class="contacto-input" type="text" id="nombre" name="nombre" required>

    <label class="contacto-label" for="email">Email:</label>
    <input class="contacto-input" type="email" id="email" name="email" required>

    <label class="contacto-label" for="mensaje">Mensaje:</label>
    <textarea class="contacto-textarea" id="mensaje" name="mensaje" rows="5" required></textarea>

    <button class="contacto-button" type="submit">Enviar</button>
  </form>
</main>