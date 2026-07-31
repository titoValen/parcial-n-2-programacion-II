<?php
session_start();

require_once __DIR__ . '/../data/conex.php';
require_once __DIR__ . '/../classes/Cart.php';

if (!isset($_SESSION['user'])) {
  header('Location: ../index.php?vista=sesion');
  exit;
}

$id_user = $_SESSION['user']['id'];
$id_cart = $_POST['id_cart'] ?? '';

if ($id_cart !== '') {
  Cart::removeItem((int) $id_cart, $id_user);
}

header('Location: ../index.php?vista=carrito');
exit;
