<?php
class User
{
  private $id;
  private $name;
  private $password;
  private $role;

  // Getters
  public function getId()
  {
    return $this->id;
  }

  public function getName()
  {
    return $this->name;
  }

  public function getPassword()
  {
    return $this->password;
  }

  public function getRole()
  {
    return $this->role;
  }

  // Setters
  public function setName($name)
  {
    $this->name = $name;
  }

  public function setPassword($password)
  {
    $this->password = $password;
  }

  public function setRole($role)
  {
    $this->role = $role;
  }
}