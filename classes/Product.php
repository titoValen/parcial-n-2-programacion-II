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

    $query = "
      SELECT
        p.id,
        p.name,
        p.description,
        p.price,
        p.image,
        p.alt,
        p.stock,
        c.name AS category,
        b.name AS brand
      FROM product p
      INNER JOIN category c ON p.id_category = c.id
      INNER JOIN brand    b ON p.id_brand    = b.id
    ";

    $PDOStatement = $PDO->prepare($query);
    $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
    $PDOStatement->execute();

    return $PDOStatement->fetchAll();
  }

  public static function productById($id)
  {
    $PDO = (new DB())->getDB();

    $query = "
      SELECT
        p.id,
        p.name,
        p.description,
        p.price,
        p.image,
        p.alt,
        p.stock,
        c.name AS category,
        b.name AS brand
      FROM product p
      INNER JOIN category c ON p.id_category = c.id
      INNER JOIN brand    b ON p.id_brand    = b.id
      WHERE p.id = :id
    ";

    $PDOStatement = $PDO->prepare($query);
    $PDOStatement->bindParam(':id', $id, PDO::PARAM_INT);
    $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
    $PDOStatement->execute();

    return $PDOStatement->fetch();
  }
}
