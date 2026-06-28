<?php
require_once '../data/conex.php';
require_once '../classes/Product.php';

$id = $_GET['id'] ?? '';
$name = $_GET['name'] ?? '';
$description = $_GET['description'] ?? '';
$price = $_GET['price'] ?? '';
$image = $_GET['image'] ?? '';
$alt = $_GET['alt'] ?? '';
$id_category = $_GET['id_category'] ?? '';
$id_brand = $_GET['id_brand'] ?? '';
$stock = $_GET['stock'] ?? '';

if ($id !== '' && $name !== '' && $description !== '' && $price !== '' && $image !== '' && $alt !== '' && $id_category !== '' && $id_brand !== '' && $stock !== '') {
	Product::updateProduct($id, $name, $description, $price, $image, $alt, $id_category, $id_brand, $stock);
}

header('Location: ../index.php?vista=admin');
exit;
?>