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
}