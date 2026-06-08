<?php
class Category
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

  public static function getAllCategories()
  {
    $PDO = (new DB())->getDB();

    $query = "SELECT * FROM category";
    $PDOStatement = $PDO->prepare($query);
    $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
    $PDOStatement->execute();
    $datos = $PDOStatement->fetchAll();
    return $datos;
  }
}