<?php
class Product
{
  private $id;
  private $name;
  private $description;
  private $price;
  private $image;
  private $alt;
  private $category;
  private $stock;
  private $brand;

  public function getId()
  {
    return $this->id;
  }
  public function getName()
  {
    return $this->name;
  }
  public function getDescription()
  {
    return $this->description;
  }
  public function getPrice()
  {
    return $this->price;
  }
  public function getImage()
  {
    return $this->image;
  }
  public function getAlt()
  {
    return $this->alt;
  }
  public function getCategory()
  {
    return $this->category;
  }
  public function getStock()
  {
    return $this->stock;
  }
  public function getBrand()
  {
    return $this->brand;
  }

  public static function obtenerProduct($data)
  {
    $json = file_get_contents($data);
    $arrayData = json_decode($json, true);

    $arrayProduct = [];

    foreach ($arrayData as $product) {
      $productNew = new self();

      $productNew->id = $product['id'];
      $productNew->name = $product['name'];
      $productNew->description = $product['description'];
      $productNew->price = $product['price'];
      $productNew->image = $product['image'];
      $productNew->alt = $product['alt'];
      $productNew->category = $product['category'];
      $productNew->stock = $product['stock'];
      $productNew->brand = $product['brand'];

      $arrayProduct[] = $productNew;
    }
    return $arrayProduct;
  }
}
