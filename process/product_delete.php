<?php
require_once __DIR__ . '/../middleware/admin_guard.php';
require_once '../data/conex.php';
require_once '../classes/Product.php';

$id = $_GET['id'] ?? '';

if ($id !== '') {
	Product::deleteProduct($id);
}

header('Location: ../index.php?vista=admin');
exit;
?>