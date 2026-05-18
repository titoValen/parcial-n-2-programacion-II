<?php 
require_once 'components/head.php'; 
?>

<body>
  <?php require_once 'components/header.php'; ?>
  <?php
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

  require_once "sections/$vista.php";

  ?>
  <?php require_once 'components/footer.php'; ?>
</body>

</html>