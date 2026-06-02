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
}