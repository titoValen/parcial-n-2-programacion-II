<?php
session_start();

require_once __DIR__ . '/../data/conex.php';
require_once __DIR__ . '/../classes/Cart.php';
require_once __DIR__ . '/../classes/Buy.php';

if (!isset($_SESSION['user'])) {
  header('Location: ../index.php?vista=sesion');
  exit;
}

$id_user = $_SESSION['user']['id'];
$payment_method = $_POST['payment_method'] ?? '';

$metodosValidos = ['efectivo', 'transferencia'];
if (!in_array($payment_method, $metodosValidos, true)) {
  header('Location: ../index.php?vista=compra_confirmar&error=metodo_invalido');
  exit;
}

$resultado = Buy::confirm($id_user, $payment_method);

if (!$resultado['success']) {
  header('Location: ../index.php?vista=compra_confirmar&error=' . urlencode($resultado['error']));
  exit;
}

header('Location: ../index.php?vista=compra_exitosa&id=' . $resultado['id_buy']);
exit;
