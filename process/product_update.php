<?php
require_once __DIR__ . '/../middleware/admin_guard.php'; 
require_once __DIR__ . '/../data/conex.php';
require_once __DIR__ . '/../classes/Product.php';

$id = $_POST['id'] ?? '';
$name = $_POST['name'] ?? '';
$description = $_POST['description'] ?? '';
$price = $_POST['price'] ?? '';
$alt = $_POST['alt'] ?? '';
$id_category = $_POST['id_category'] ?? '';
$id_brand = $_POST['id_brand'] ?? '';

$uploadedImage = $_FILES['image'] ?? null;
$allowedExtensions = ['webp', 'jpg', 'jpeg', 'png'];
$imageName = '';

if (
	$id !== '' &&
	$uploadedImage &&
	$uploadedImage['error'] === UPLOAD_ERR_OK
) {
	$originalName = $uploadedImage['name'];
	$extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

	if (in_array($extension, $allowedExtensions, true)) {
		$targetDirectory = __DIR__ . '/../img/zapatillas/';

		// mismo criterio de nombre que product_add.php: product_{id}
		// así evitamos colisiones entre productos que suban una imagen con el mismo nombre original
		$imageName = 'product_' . $id;
		$targetFile = $targetDirectory . $imageName . '.' . $extension;

		if (move_uploaded_file($uploadedImage['tmp_name'], $targetFile)) {
			// imagen guardada, $imageName ya está seteado
		} else {
			$imageName = '';
		}
	}
}

if ($imageName === '') {
	$product = Product::productById($id);
	if ($product) {
		$imageName = $product->getImage();
	}
}

if ($id !== '' && $name !== '' && $description !== '' && $price !== '' && $imageName !== '' && $alt !== '' && $id_category !== '' && $id_brand !== '') {
	Product::updateProduct($id, $name, $description, $price, $imageName, $alt, $id_category, $id_brand);
}

header('Location: ../index.php?vista=admin');
exit;
