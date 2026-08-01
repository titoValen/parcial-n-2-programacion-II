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
  public function setName($name)
  {
    $this->name = $name;
  }

  public function setEmail($email)
  {
    $this->email = $email;
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

  // Login histórico usado por form_admin.php — se deja igual para no romper lo que ya anda.
  // Ojo: todavía tiene el fallback de texto plano, sacalo cuando actualices el hash del seed de admin.
  public static function comparison($name, $pass)
  {
    $PDO = (new DB())->getDB();

    $query = "SELECT id, name, password, role FROM user WHERE name = ?";
    $stmt = $PDO->prepare($query);
    $stmt->execute([$name]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
      return false;
    }

    $storedPassword = trim($user['password']);

    if (
      $user['role'] === 'admin' &&
      (password_verify($pass, $storedPassword) || $pass === $storedPassword)
    ) {
      return $user;
    }

    return false;
  }

  public static function login($email, $pass)
  {
    $PDO = (new DB())->getDB();

    $query = "SELECT id, name, email, password, role FROM user WHERE email = ?";
    $stmt = $PDO->prepare($query);
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
      return false;
    }

    if (!password_verify($pass, trim($user['password']))) {
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

  // Registro de un cliente nuevo. Devuelve el id creado, o false si falló (ej. email duplicado).
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

  // Actualiza los datos del perfil. Si $newPassword es null, no toca la contraseña actual.
  public static function updateProfile($id, $name, $email, $address, $phone, $newPassword = null)
  {
    try {
      $PDO = (new DB())->getDB();

      $query = "UPDATE user SET name = :name, email = :email, address = :address, phone = :phone";
      if ($newPassword !== null) {
        $query .= ", password = :password";
      }
      $query .= " WHERE id = :id";

      $stmt = $PDO->prepare($query);
      $stmt->bindValue(':id', $id, PDO::PARAM_INT);
      $stmt->bindValue(':name', $name, PDO::PARAM_STR);
      $stmt->bindValue(':email', $email, PDO::PARAM_STR);
      $stmt->bindValue(':address', $address, PDO::PARAM_STR);
      $stmt->bindValue(':phone', $phone, PDO::PARAM_STR);

      if ($newPassword !== null) {
        $stmt->bindValue(':password', password_hash($newPassword, PASSWORD_DEFAULT), PDO::PARAM_STR);
      }

      $stmt->execute();
      return true;
    } catch (Exception $e) {
      return false;
    }
  }

  public static function verifyPassword($id, $password)
  {
    $PDO = (new DB())->getDB();

    $query = "SELECT password FROM user WHERE id = :id";
    $stmt = $PDO->prepare($query);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
      return false;
    }

    return password_verify($password, trim($row['password']));
  }

  // Borra al usuario y todo lo que depende de él (compras y carrito), en una transacción
  public static function delete($id)
  {
    $PDO = (new DB())->getDB();

    try {
      $PDO->beginTransaction();

      $PDO->prepare("
        DELETE bd FROM buys_detail bd
        INNER JOIN buys b ON b.id = bd.id_buys
        WHERE b.id_user = :id
      ")->execute([':id' => $id]);

      $PDO->prepare("DELETE FROM buys WHERE id_user = :id")->execute([':id' => $id]);
      $PDO->prepare("DELETE FROM cart WHERE id_user = :id")->execute([':id' => $id]);
      $PDO->prepare("DELETE FROM user WHERE id = :id")->execute([':id' => $id]);

      $PDO->commit();
      return true;
    } catch (Exception $e) {
      if ($PDO->inTransaction()) {
        $PDO->rollBack();
      }
      return false;
    }
  }
}
