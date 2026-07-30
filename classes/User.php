<?php
class User
{
  private $id;
  private $name;
  private $email;
  private $password;
  private $role;
  private $address;
  private $phone;

  // Getters
  public function getId()
  {
    return $this->id;
  }

  public function getName()
  {
    return $this->name;
  }

  public function getEmail()
  {
    return $this->email;
  }

  public function getPassword()
  {
    return $this->password;
  }

  public function getRole()
  {
    return $this->role;
  }

  public function getAddress()
  {
    return $this->address;
  }

  public function getPhone()
  {
    return $this->phone;
  }

  // Setters
  public function setEmail($email)
  {
    $this->email = $email;
  }

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

  public function setAddress($address)
  {
    $this->address = $address;
  }

  public function setPhone($phone)
  {
    $this->phone = $phone;
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
    if ($user['role'] === 'admin' && self::verifyPassword($pass, $storedPassword)) {
      return $user;
    }

    return false;
  }

  public static function login($email, $pass)
  {
    $PDO = (new DB())->getDB();

    $email = trim($email);
    $pass = trim($pass);

    $query = "SELECT id, name, email, password, role FROM user WHERE email = ?";
    $stmt = $PDO->prepare($query);
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
      return false;
    }

    if (!self::verifyPassword($pass, trim($user['password']))) {
      return false;
    }

    return $user;
  }

  public static function emailExists($email)
  {
    $PDO = (new DB())->getDB();

    $query = "SELECT id FROM user WHERE email = ?";
    $stmt = $PDO->prepare($query);
    $stmt->execute([$email]);

    return (bool) $stmt->fetch();
  }

  public static function register($name, $email, $password, $address = '', $phone = '')
  {
    try {
      $PDO = (new DB())->getDB();
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

      $query = "
        INSERT INTO user (name, email, password, role, address, phone)
        VALUES (:name, :email, :password, 'cliente', :address, :phone)
      ";

      $stmt = $PDO->prepare($query);
      $stmt->bindValue(':name', $name, PDO::PARAM_STR);
      $stmt->bindValue(':email', $email, PDO::PARAM_STR);
      $stmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
      $stmt->bindValue(':address', $address, PDO::PARAM_STR);
      $stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
      $stmt->execute();

      return (int) $PDO->lastInsertId();
    } catch (Exception $e) {
      return false; // probablemente el email ya existe (UNIQUE constraint)
    }
  }

  public static function getById($id)
  {
    $PDO = (new DB())->getDB();

    $query = "SELECT id, name, email, role, address, phone FROM user WHERE id = :id";
    $stmt = $PDO->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
    $stmt->execute();

    return $stmt->fetch();
  }

  private static function verifyPassword($plainPassword, $storedPassword)
  {
    $storedPassword = trim((string) $storedPassword);

    if ($storedPassword === '') {
      return false;
    }

    return password_verify($plainPassword, $storedPassword);
  }
}
