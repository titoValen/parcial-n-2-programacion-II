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

  public static function product()
  {
    $PDO = (new DB())->getDB();

    $query = "SELECT * FROM product";
    $PDOStatement = $PDO->prepare($query);
    $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
    $PDOStatement->execute();
    $datos = $PDOStatement->fetchAll();
    return $datos;
  }
}
