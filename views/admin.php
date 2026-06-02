<main>
  <h1>Administración</h1>

  <form action="./process/process_admin.php" method="post">
    <div>
      <label for="name">Nombre</label>
      <input required type="text" id="name" name="name">
    </div>
    <div>
      <label for="password">Contraseña</label>
      <input required type="password" id="password" name="password">
    </div>
    <button type="submit">Iniciar sesión</button>
  </form>
</main>