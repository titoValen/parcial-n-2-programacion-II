<?php
class Buy
{
  // descuenta stock de cada talle, y si algo falla, deshace todo (rollback).
  public static function confirm($id_user, $payment_method)
  {
    $PDO = (new DB())->getDB();

    $items = Cart::getItemsByUser($id_user);

    if (empty($items)) {
      return ['success' => false, 'error' => 'carrito_vacio'];
    }

    try {
      $PDO->beginTransaction();

      $total = 0;
      foreach ($items as $item) {
        $total += $item['price'] * $item['amount'];
      }

      $insertBuy = $PDO->prepare("
        INSERT INTO buys (id_user, total, state, payment_method)
        VALUES (:id_user, :total, 'pagado', :payment_method)
      ");
      $insertBuy->bindValue(':id_user', $id_user, PDO::PARAM_INT);
      $insertBuy->bindValue(':total', $total, PDO::PARAM_INT);
      $insertBuy->bindValue(':payment_method', $payment_method, PDO::PARAM_STR);
      $insertBuy->execute();

      $id_buy = (int) $PDO->lastInsertId();

      $insertDetail = $PDO->prepare("
        INSERT INTO buys_detail (id_buys, id_product, id_size, amount, unit_price)
        VALUES (:id_buys, :id_product, :id_size, :amount, :unit_price)
      ");

      foreach ($items as $item) {
        // Descuento atómico: solo resta si hay stock suficiente EN ESE MOMENTO
        // (protege contra dos compras simultáneas del último par disponible)
        $updateStock = $PDO->prepare("
          UPDATE product_size
          SET stock = stock - :amount
          WHERE id_product = :id_product AND id_size = :id_size AND stock >= :amount
        ");
        $updateStock->bindValue(':amount', $item['amount'], PDO::PARAM_INT);
        $updateStock->bindValue(':id_product', $item['id_product'], PDO::PARAM_INT);
        $updateStock->bindValue(':id_size', $item['id_size'], PDO::PARAM_INT);
        $updateStock->execute();

        if ($updateStock->rowCount() === 0) {
          $PDO->rollBack();
          return ['success' => false, 'error' => 'sin_stock', 'producto' => $item['name']];
        }

        $insertDetail->bindValue(':id_buys', $id_buy, PDO::PARAM_INT);
        $insertDetail->bindValue(':id_product', $item['id_product'], PDO::PARAM_INT);
        $insertDetail->bindValue(':id_size', $item['id_size'], PDO::PARAM_INT);
        $insertDetail->bindValue(':amount', $item['amount'], PDO::PARAM_INT);
        $insertDetail->bindValue(':unit_price', $item['price'], PDO::PARAM_INT);
        $insertDetail->execute();
      }

      $PDO->commit();

      Cart::clear($id_user); // se vacía recién si todo salió bien

      return ['success' => true, 'id_buy' => $id_buy];
    } catch (Exception $e) {
      if ($PDO->inTransaction()) {
        $PDO->rollBack();
      }
      return ['success' => false, 'error' => 'excepcion'];
    }
  }

  // Para la vista de perfil: historial de compras del usuario
  public static function getPurchasesByUser($id_user)
  {
    $PDO = (new DB())->getDB();

    $query = "
      SELECT id, date, total, state, payment_method
      FROM buys
      WHERE id_user = :id_user
      ORDER BY date DESC
    ";

    $stmt = $PDO->prepare($query);
    $stmt->bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Detalle de una compra puntual (qué productos/talles/cantidades incluyó)
  public static function getDetailByBuyId($id_buy)
  {
    $PDO = (new DB())->getDB();

    $query = "
      SELECT bd.id_product, bd.id_size, bd.amount, bd.unit_price, p.name, s.size
      FROM buys_detail bd
      INNER JOIN product p ON p.id = bd.id_product
      INNER JOIN size s ON s.id = bd.id_size
      WHERE bd.id_buys = :id_buy
    ";

    $stmt = $PDO->prepare($query);
    $stmt->bindValue(':id_buy', $id_buy, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
