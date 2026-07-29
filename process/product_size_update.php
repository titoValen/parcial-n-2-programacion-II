<?php
require_once __DIR__ . '/../middleware/admin_guard.php';

require_once __DIR__ . '/../data/conex.php';
require_once __DIR__ . '/../classes/Product_Size.php';

$id_product = $_POST['id_product'] ?? '';
$sizes = $_POST['sizes'] ?? [];

if ($id_product !== '' && is_array($sizes)) {
  Product_Size::saveStockForProduct((int) $id_product, $sizes);
}

header('Location: ../index.php?vista=admin');
exit;
