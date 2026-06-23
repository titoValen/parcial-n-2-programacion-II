<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  <title>Parcial Programación II nº1</title>

  <link rel="stylesheet" href="style/gobal.css">
  <link rel="stylesheet" href="style/index.css">

  <?php
  require_once 'config/created_views.php';
  if (
    isset($_GET['vista']) &&
    in_array($_GET['vista'], $vistas_creadas)
  ): ?>
    <?php
    switch ($_GET['vista']) {
      case 'home':
        echo '<link rel="stylesheet" href="style/home.css">';
        echo '<script src="js/hero.js" defer type="module"></script>';
        break;
      case 'contacto':
        echo '<link rel="stylesheet" href="style/contacto.css">';
        break;
      case 'producto':
        echo '<link rel="stylesheet" href="style/producto.css">';
        echo '<script src="js/filter.js" defer type="module"></script>';
        break;
      case 'alumno':
        echo '<link rel="stylesheet" href="style/alumno.css">';
        break;
      case 'detalle':
        echo '<link rel="stylesheet" href="style/detalle.css">';
        break;
      case 'admin':
        echo '<link rel="stylesheet" href="style/admin.css">';
        break;
      case 'res_form':
        echo '<link rel="stylesheet" href="style/res_form.css">';
        break;
      default:
        echo 'Algo ocurrio mal al cargar la vista del css';
    }
    ?>
  <?php else: ?>
    <?php echo '<link rel="stylesheet" href="style/home.css">'; ?>
    <?php echo '<script src="js/hero.js" defer type="module"></script>'; ?>
  <?php endif ?>
</head>