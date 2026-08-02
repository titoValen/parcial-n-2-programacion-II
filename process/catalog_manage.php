<?php
require_once __DIR__ . '/../middleware/admin_guard.php';
require_once __DIR__ . '/../data/conex.php';
require_once __DIR__ . '/../classes/Category.php';
require_once __DIR__ . '/../classes/Brand.php';

$categoryName = trim($_POST['category_name'] ?? '');
$brandName = trim($_POST['brand_name'] ?? '');
$deleteCategoryId = $_POST['delete_category_id'] ?? '';
$deleteBrandId = $_POST['delete_brand_id'] ?? '';

if ($categoryName !== '') {
    Category::createCategory($categoryName);
}

if ($brandName !== '') {
    Brand::createBrand($brandName);
}

if ($deleteCategoryId !== '') {
    Category::deleteCategory((int) $deleteCategoryId);
}

if ($deleteBrandId !== '') {
    Brand::deleteBrand((int) $deleteBrandId);
}

header('Location: ../index.php?vista=admin');
exit;
