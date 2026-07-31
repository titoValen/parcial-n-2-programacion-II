<?php
session_start();

require_once __DIR__ . '/../data/conex.php';
require_once __DIR__ . '/../classes/Cart.php';
require_once __DIR__ . '/../classes/Product_Size.php';

$id_product = $_POST['id'] ?? '';

if (!isset($_SESSION['user'])) {
  // lo mandamos a loguearse y de paso guardamos a dónde volver
  header('Location: ../index.php?vista=sesion&redirect=detalle&id=' . urlencode($id_product));
  exit;
}

$id_user = $_SESSION['user']['id'];
$id_size = $_POST['id_size'] ?? '';
$cantidad = (int) ($_POST['cantidad'] ?? 1);

if ($id_product === '' || $id_size === '' || $cantidad <= 0) {
  header('Location: ../index.php?vista=detalle&id=' . urlencode($id_product) . '&error=datos_incompletos');
  exit;
}

$stockDisponible = Product_Size::getStockByProductAndSize($id_product, $id_size);

// Ojo: si ya había una cantidad de este mismo producto+talle en el carrito,
// hay que sumarla antes de comparar contra el stock real.
$itemActual = Cart::getItem($id_user, $id_product, $id_size);
$cantidadActual = $itemActual['amount'] ?? 0;

if (($cantidadActual + $cantidad) > $stockDisponible) {
  header('Location: ../index.php?vista=detalle&id=' . urlencode($id_product) . '&error=stock_insuficiente');
  exit;
}

Cart::addItem($id_user, $id_product, $id_size, $cantidad);

header('Location: ../index.php?vista=carrito');
exit;
