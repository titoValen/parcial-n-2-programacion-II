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

  public static function comparison($name, $pass)
  {
    $PDO = (new DB())->getDB();
    
    $query = "SELECT id, name, password, role FROM user WHERE name = ?";
    $stmt = $PDO->prepare($query);
    $stmt->execute([$name]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Primero comprobar si existe un usuario con ese nombre
    if (!$user) {
      return false;
    }

    // Limpiar espacios extra en el hash guardado por si la DB tiene un valor mal formado.
    $storedPassword = trim($user['password']);

    // Luego comparar la contraseña.
    if (
      $user['role'] === 'admin' &&
      (password_verify($pass, $storedPassword) || $pass === $storedPassword)
    ) {
      return $user;
    }

    return false;
  }
}