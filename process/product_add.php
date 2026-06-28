<?php
require_once '../data/conex.php';
require_once '../classes/Product.php';

$name = $_POST['name'] ?? '';
$description = $_POST['description'] ?? '';
$price = $_POST['price'] ?? '';
$alt = $_POST['alt'] ?? '';
$id_category = $_POST['id_category'] ?? '';
$id_brand = $_POST['id_brand'] ?? '';
$stock = $_POST['stock'] ?? '';

$uploadedImage = $_FILES['image'] ?? null;
$allowedExtensions = ['webp', 'jpg', 'jpeg', 'png'];

if (
	$name !== '' &&
	$description !== '' &&
	$price !== '' &&
	$alt !== '' &&
	$id_category !== '' &&
	$id_brand !== '' &&
	$stock !== '' &&
	$uploadedImage &&
	$uploadedImage['error'] === UPLOAD_ERR_OK
) {
	$originalName = $uploadedImage['name'];
	$extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
	$fileName = pathinfo($originalName, PATHINFO_FILENAME);

	if (in_array($extension, $allowedExtensions, true)) {
		$targetDirectory = __DIR__ . '/../img/zapatillas/';
		$targetFile = $targetDirectory . $fileName . '.' . $extension;

		if (move_uploaded_file($uploadedImage['tmp_name'], $targetFile)) {
			Product::createProduct($name, $description, $price, $fileName, $alt, $id_category, $id_brand, $stock);
		}
	}
}

header('Location: ../index.php?vista=admin');
exit;
?>