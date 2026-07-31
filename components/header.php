<header class="header">
  <picture>
    <source media="(min-width: 600px)" srcset="img/logo/250x150.png">
    <img src="img/logo/150x75.png" alt="Imagen del logo">
  </picture>
  <nav class="nav desktop">
    <ul>
      <li><a href="?vista=home">Inicio</a></li>
      <li><a href="?vista=producto">Producto</a></li>
      <li><a href="?vista=carrito">Carrito</a></li>
      <?php if (isset($_SESSION['user'])): ?>
        <li class="nav-user">
          <a href="?vista=perfil"><?= htmlspecialchars($_SESSION['user']['name'], ENT_QUOTES, 'UTF-8') ?></a>
        </li>
      <?php else: ?>
        <li><a href="?vista=sesion">Inicio de sesión</a></li>
      <?php endif; ?>
      <li><a href="?vista=contacto">Contacto</a></li>
      <li><a href="?vista=alumno">Alumno</a></li>
    </ul>
  </nav>
  <!-- Hamburger menu -->
  <input type="checkbox" id="checkbox">
  <label for="checkbox" class="toggle">
    <div class="bars" id="bar1"></div>
    <div class="bars" id="bar2"></div>
    <div class="bars" id="bar3"></div>
  </label>
  <nav class="nav responsive">
    <ul>
      <li><a href="?vista=home">Inicio</a></li>
      <li><a href="?vista=producto">Producto</a></li>
      <li><a href="?vista=carrito">Carrito</a></li>
      <?php if (isset($_SESSION['user'])): ?>
        <li class="nav-user">
          <a href="?vista=perfil"><?= htmlspecialchars($_SESSION['user']['name'], ENT_QUOTES, 'UTF-8') ?></a>
        </li>
      <?php else: ?>
        <li><a href="?vista=sesion">Inicio de sesión</a></li>
      <?php endif; ?>
      <li><a href="?vista=contacto">Contacto</a></li>
      <li><a href="?vista=alumno">Alumno</a></li>
    </ul>
  </nav>
</header>