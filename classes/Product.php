<?php
class Product
{
  private $id;
  private $name;
  private $description;
  private $price;
  private $image;
  private $alt;
  private $id_category;
  private $id_brand;
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

  public function getImagePath()
  {
    if (empty($this->image)) {
      return 'img/photo/zapatillas_correctas.webp';
    }

    $extensions = ['webp', 'jpg', 'jpeg', 'png'];

    foreach ($extensions as $extension) {
      $relativePath = 'img/zapatillas/' . $this->image . '.' . $extension;
      $absolutePath = __DIR__ . '/../' . $relativePath;

      if (file_exists($absolutePath)) {
        return $relativePath;
      }
    }

    return 'img/photo/zapatillas_correctas.webp';
  }

  public function getAlt()
  {
    return $this->alt;
  }
  public function getIdCategory()
  {
    return $this->id_category;
  }
  public function getIdBrand()
  {
    return $this->id_brand;
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
        p.id_category,
        p.id_brand,
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
        p.id_category,
        p.id_brand,
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

  public static function createProduct($name, $description, $price, $image, $alt, $id_category, $id_brand, $stock)
  {
    try {
      $PDO = (new DB())->getDB();

      $query = "
        INSERT INTO product (name, description, price, image, alt, id_category, id_brand, stock)
        VALUES (:name, :description, :price, :image, :alt, :id_category, :id_brand, :stock)
      ";

      $PDOStatement = $PDO->prepare($query);
      $PDOStatement->bindValue(':name', $name, PDO::PARAM_STR);
      $PDOStatement->bindValue(':description', $description, PDO::PARAM_STR);
      $PDOStatement->bindValue(':price', $price, PDO::PARAM_STR);

      if ($image === null || $image === '') {
        $PDOStatement->bindValue(':image', null, PDO::PARAM_NULL);
      } else {
        $PDOStatement->bindValue(':image', $image, PDO::PARAM_STR);
      }

      $PDOStatement->bindValue(':alt', $alt, PDO::PARAM_STR);
      $PDOStatement->bindValue(':id_category', $id_category, PDO::PARAM_INT);
      $PDOStatement->bindValue(':id_brand', $id_brand, PDO::PARAM_INT);
      $PDOStatement->bindValue(':stock', $stock, PDO::PARAM_INT);
      $PDOStatement->execute();

      return (int) $PDO->lastInsertId();
    } catch (Exception $e) {
      return 0;
    }
  }

  public static function updateProductImage($id, $image)
  {
    try {
      $PDO = (new DB())->getDB();

      $query = "
        UPDATE product
        SET image = :image
        WHERE id = :id
      ";

      $PDOStatement = $PDO->prepare($query);
      $PDOStatement->bindValue(':id', $id, PDO::PARAM_INT);
      $PDOStatement->bindValue(':image', $image, PDO::PARAM_STR);
      $PDOStatement->execute();

      return true;
    } catch (Exception $e) {
      return false;
    }
  }

  public static function updateProduct($id, $name, $description, $price, $image, $alt, $id_category, $id_brand, $stock)
  {
    $PDO = (new DB())->getDB();

    $query = "
      UPDATE product
      SET name = :name,
          description = :description,
          price = :price,
          image = :image,
          alt = :alt,
          id_category = :id_category,
          id_brand = :id_brand,
          stock = :stock
      WHERE id = :id
    ";

    $PDOStatement = $PDO->prepare($query);
    $PDOStatement->bindParam(':id', $id, PDO::PARAM_INT);
    $PDOStatement->bindParam(':name', $name, PDO::PARAM_STR);
    $PDOStatement->bindParam(':description', $description, PDO::PARAM_STR);
    $PDOStatement->bindParam(':price', $price, PDO::PARAM_STR);
    $PDOStatement->bindParam(':image', $image, PDO::PARAM_STR);
    $PDOStatement->bindParam(':alt', $alt, PDO::PARAM_STR);
    $PDOStatement->bindParam(':id_category', $id_category, PDO::PARAM_INT);
    $PDOStatement->bindParam(':id_brand', $id_brand, PDO::PARAM_INT);
    $PDOStatement->bindParam(':stock', $stock, PDO::PARAM_INT);
    $PDOStatement->execute();
  }

  public static function deleteProduct($id)
  {
    $PDO = (new DB())->getDB();

    $query = "DELETE FROM product WHERE id = :id";
    $PDOStatement = $PDO->prepare($query);
    $PDOStatement->bindParam(':id', $id, PDO::PARAM_INT);
    $PDOStatement->execute();
  }
}
