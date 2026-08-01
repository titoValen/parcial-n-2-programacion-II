<?php
session_start();

require_once __DIR__ . '/../data/conex.php';
require_once __DIR__ . '/../classes/User.php';

if (!isset($_SESSION['user'])) {
  header('Location: ../index.php?vista=sesion');
  exit;
}

$id_user = $_SESSION['user']['id'];
$password = $_POST['password'] ?? '';

if (!User::verifyPassword($id_user, $password)) {
  header('Location: ../index.php?vista=perfil&error=password_incorrecta');
  exit;
}

$eliminado = User::delete($id_user);

session_unset();
session_destroy();

if ($eliminado) {
  header('Location: ../index.php?vista=home&ok=cuenta_eliminada');
} else {
  header('Location: ../index.php?vista=home&error=no_se_pudo_eliminar');
}
exit;
