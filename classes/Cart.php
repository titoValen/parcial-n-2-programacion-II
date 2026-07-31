<?php
class Cart
{
  // Trae el item puntual (para chequear cantidad actual antes de sumar más)
  public static function getItem($id_user, $id_product, $id_size)
  {
    $PDO = (new DB())->getDB();

    $query = "
      SELECT * FROM cart
      WHERE id_user = :id_user AND id_product = :id_product AND id_size = :id_size
    ";

    $stmt = $PDO->prepare($query);
    $stmt->bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->bindValue(':id_product', $id_product, PDO::PARAM_INT);
    $stmt->bindValue(':id_size', $id_size, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  // Agrega (o suma cantidad si ya existe el mismo producto+talle) usando la UNIQUE KEY de la tabla cart
  public static function addItem($id_user, $id_product, $id_size, $cantidad)
  {
    $PDO = (new DB())->getDB();

    $query = "
      INSERT INTO cart (id_user, id_product, id_size, amount)
      VALUES (:id_user, :id_product, :id_size, :amount)
      ON DUPLICATE KEY UPDATE amount = amount + VALUES(amount)
    ";

    $stmt = $PDO->prepare($query);
    $stmt->bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->bindValue(':id_product', $id_product, PDO::PARAM_INT);
    $stmt->bindValue(':id_size', $id_size, PDO::PARAM_INT);
    $stmt->bindValue(':amount', $cantidad, PDO::PARAM_INT);
    $stmt->execute();
  }

  // Trae todos los items del carrito de un usuario, con los datos ya necesarios para mostrarlos
  public static function getItemsByUser($id_user)
  {
    $PDO = (new DB())->getDB();

    $query = "
      SELECT
        c.id AS id_cart,
        c.id_product,
        c.id_size,
        c.amount,
        p.name,
        p.price,
        p.image,
        p.alt,
        s.size,
        COALESCE(ps.stock, 0) AS stock_disponible
      FROM cart c
      INNER JOIN product p ON p.id = c.id_product
      INNER JOIN size s ON s.id = c.id_size
      LEFT JOIN product_size ps ON ps.id_product = c.id_product AND ps.id_size = c.id_size
      WHERE c.id_user = :id_user
      ORDER BY c.date_added DESC
    ";

    $stmt = $PDO->prepare($query);
    $stmt->bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public static function updateQuantity($id_cart, $id_user, $cantidad)
  {
    if ($cantidad <= 0) {
      self::removeItem($id_cart, $id_user);
      return;
    }

    $PDO = (new DB())->getDB();

    $query = "
      UPDATE cart SET amount = :amount
      WHERE id = :id_cart AND id_user = :id_user
    ";

    $stmt = $PDO->prepare($query);
    $stmt->bindValue(':amount', $cantidad, PDO::PARAM_INT);
    $stmt->bindValue(':id_cart', $id_cart, PDO::PARAM_INT);
    $stmt->bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();
  }

  public static function removeItem($id_cart, $id_user)
  {
    $PDO = (new DB())->getDB();

    $query = "DELETE FROM cart WHERE id = :id_cart AND id_user = :id_user";
    $stmt = $PDO->prepare($query);
    $stmt->bindValue(':id_cart', $id_cart, PDO::PARAM_INT);
    $stmt->bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();
  }

  // Se usa al confirmar la compra, para vaciar el carrito después de generar la compra
  public static function clear($id_user)
  {
    $PDO = (new DB())->getDB();

    $query = "DELETE FROM cart WHERE id_user = :id_user";
    $stmt = $PDO->prepare($query);
    $stmt->bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();
  }
}
