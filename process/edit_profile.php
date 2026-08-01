<?php
session_start();

require_once __DIR__ . '/../data/conex.php';
require_once __DIR__ . '/../classes/User.php';

if (!isset($_SESSION['user'])) {
  header('Location: ../index.php?vista=sesion');
  exit;
}

$id_user = $_SESSION['user']['id'];
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$address = trim($_POST['address'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$newPassword = trim($_POST['new_password'] ?? '');

if ($name === '' || $email === '') {
  header('Location: ../index.php?vista=perfil&error=incompleto');
  exit;
}

$actualizado = User::updateProfile(
  $id_user,
  $name,
  $email,
  $address,
  $phone,
  $newPassword !== '' ? $newPassword : null
);

if (!$actualizado) {
  header('Location: ../index.php?vista=perfil&error=email_en_uso');
  exit;
}

// Actualizamos nombre/email en sesión por si cambiaron (el header los usa)
$_SESSION['user']['name'] = $name;
$_SESSION['user']['email'] = $email;

header('Location: ../index.php?vista=perfil&ok=perfil_actualizado');
exit;
