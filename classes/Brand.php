<?php
class Brand
{
  private $id;
  private $name;

  // Getters
  public function getId()
  {
    return $this->id;
  }

  public function getName()
  {
    return $this->name;
  }

  // Setters
  public function setName($name)
  {
    $this->name = $name;
  }

  public static function getAllBrands()
  {
    $PDO = (new DB())->getDB();

    $query = "SELECT * FROM brand";
    $PDOStatement = $PDO->prepare($query);
    $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
    $PDOStatement->execute();
    $datos = $PDOStatement->fetchAll();
    return $datos;
  }

  public static function createBrand($name)
  {
    try {
      $PDO = (new DB())->getDB();
      $query = "INSERT INTO brand (name) VALUES (:name)";
      $PDOStatement = $PDO->prepare($query);
      $PDOStatement->bindValue(':name', trim($name), PDO::PARAM_STR);
      $PDOStatement->execute();

      return true;
    } catch (Exception $e) {
      return false;
    }
  }

  public static function deleteBrand($id)
  {
    try {
      $PDO = (new DB())->getDB();

      $checkProduct = $PDO->prepare("SELECT COUNT(*) FROM product WHERE id_brand = :id");
      $checkProduct->bindValue(':id', $id, PDO::PARAM_INT);
      $checkProduct->execute();

      if ((int) $checkProduct->fetchColumn() > 0) {
        return false;
      }

      $PDOStatement = $PDO->prepare("DELETE FROM brand WHERE id = :id");
      $PDOStatement->bindValue(':id', $id, PDO::PARAM_INT);
      $PDOStatement->execute();

      return true;
    } catch (Exception $e) {
      return false;
    }
  }
}