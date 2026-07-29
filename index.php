<?php
session_start();

require_once 'config/created_views.php';

if (
  isset($_GET['vista']) &&
  !empty($_GET['vista']) &&
  in_array($_GET['vista'], $vistas_creadas)
) {
  $vista = $_GET['vista'];
} else {
  $vista = 'home';
}

if ($vista === 'admin' && (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? null) !== 'admin')) {
  $vista = 'form_admin';
}

$_GET['vista'] = $vista;

require_once 'components/head.php';
?>

<body>
  <?php
  if ($vista === 'admin' || $vista === 'form_admin') {
    require_once "views/$vista.php";
  } else {
    require_once 'components/header.php';
    require_once "views/$vista.php";
    require_once 'components/footer.php';
  }
  ?>
</body>

</html>