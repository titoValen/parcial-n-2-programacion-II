<?php
class Product_Size
{
  private $id;
  private $id_product;
  private $id_size;
  private $stock;
  private $size;

  public function getId()
  {
    return $this->id;
  }
  public function getIdProduct()
  {
    return $this->id_product;
  }
  public function getIdSize()
  {
    return $this->id_size;
  }
  public function getStock()
  {
    return $this->stock;
  }
  public function getSize()
  {
    return $this->size;
  }

  // Trae los talles de un producto, con su stock. Por defecto solo los que tienen stock > 0
  public static function getByProduct($id_product, $soloConStock = true)
  {
    $PDO = (new DB())->getDB();

    $query = "
      SELECT
        ps.id,
        ps.id_product,
        ps.id_size,
        ps.stock,
        s.size
      FROM product_size ps
      INNER JOIN size s ON ps.id_size = s.id
      WHERE ps.id_product = :id_product
    ";

    if ($soloConStock) {
      $query .= " AND ps.stock > 0";
    }

    $query .= " ORDER BY s.size ASC";

    $PDOStatement = $PDO->prepare($query);
    $PDOStatement->bindParam(':id_product', $id_product, PDO::PARAM_INT);
    $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
    $PDOStatement->execute();

    return $PDOStatement->fetchAll();
  }

  // Trae el stock de un talle puntual (útil para validar antes de agregar al carrito)
  public static function getStockByProductAndSize($id_product, $id_size)
  {
    $PDO = (new DB())->getDB();

    $query = "
      SELECT stock
      FROM product_size
      WHERE id_product = :id_product AND id_size = :id_size
    ";

    $PDOStatement = $PDO->prepare($query);
    $PDOStatement->bindParam(':id_product', $id_product, PDO::PARAM_INT);
    $PDOStatement->bindParam(':id_size', $id_size, PDO::PARAM_INT);
    $PDOStatement->execute();

    $resultado = $PDOStatement->fetch(PDO::FETCH_ASSOC);

    return $resultado ? (int) $resultado['stock'] : 0;
  }

  // Descuenta stock al confirmar una compra (usar dentro de una transacción)
  public static function descontarStock($id_product, $id_size, $cantidad)
  {
    $PDO = (new DB())->getDB();

    $query = "
      UPDATE product_size
      SET stock = stock - :cantidad
      WHERE id_product = :id_product
        AND id_size = :id_size
        AND stock >= :cantidad
    ";

    $PDOStatement = $PDO->prepare($query);
    $PDOStatement->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
    $PDOStatement->bindParam(':id_product', $id_product, PDO::PARAM_INT);
    $PDOStatement->bindParam(':id_size', $id_size, PDO::PARAM_INT);
    $PDOStatement->execute();

    // Si no afectó ninguna fila, es porque no había stock suficiente
    return $PDOStatement->rowCount() > 0;
  }
}
