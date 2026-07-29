<?php
class Product_Size
{
  private $id;
  private $id_product;
  private $id_size;
  private $stock;
  private $size; // viene del JOIN con la tabla `size`

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

  // Suma el stock de todos los talles de un producto (para mostrar un total en el listado admin)
  public static function getTotalStockByProduct($id_product)
  {
    $PDO = (new DB())->getDB();

    $query = "
      SELECT COALESCE(SUM(stock), 0) AS total
      FROM product_size
      WHERE id_product = :id_product
    ";

    $PDOStatement = $PDO->prepare($query);
    $PDOStatement->bindParam(':id_product', $id_product, PDO::PARAM_INT);
    $PDOStatement->execute();

    $resultado = $PDOStatement->fetch(PDO::FETCH_ASSOC);

    return (int) $resultado['total'];
  }

  // Trae TODOS los talles existentes (tabla size), con el stock actual del producto (0 si no tiene fila cargada todavía)
  // Se usa para armar el modal de "Gestionar talles": así el admin ve y puede cargar stock incluso en talles nuevos
  public static function getAllSizesWithStock($id_product)
  {
    $PDO = (new DB())->getDB();

    $query = "
      SELECT
        s.id AS id_size,
        s.size,
        COALESCE(ps.stock, 0) AS stock
      FROM size s
      LEFT JOIN product_size ps
        ON ps.id_size = s.id AND ps.id_product = :id_product
      ORDER BY s.size ASC
    ";

    $PDOStatement = $PDO->prepare($query);
    $PDOStatement->bindParam(':id_product', $id_product, PDO::PARAM_INT);
    $PDOStatement->execute();

    return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
  }

  // Guarda de una el stock de TODOS los talles de un producto (lo que llega del modal)
  // $stockPorTalla = [id_size => stock, ...]
  public static function saveStockForProduct($id_product, array $stockPorTalla)
  {
    $PDO = (new DB())->getDB();

    try {
      $PDO->beginTransaction();

      // Reemplazamos todas las filas del producto: más simple que andar comparando
      // cuáles ya existían, y no necesita una UNIQUE KEY para hacer upsert.
      $delete = $PDO->prepare("DELETE FROM product_size WHERE id_product = :id_product");
      $delete->bindValue(':id_product', $id_product, PDO::PARAM_INT);
      $delete->execute();

      $insert = $PDO->prepare("
        INSERT INTO product_size (id_product, id_size, stock)
        VALUES (:id_product, :id_size, :stock)
      ");

      foreach ($stockPorTalla as $id_size => $stock) {
        $stock = max(0, (int) $stock);

        if ($stock === 0) {
          continue; // no guardamos filas en 0, así no ensuciamos la tabla
        }

        $insert->bindValue(':id_product', $id_product, PDO::PARAM_INT);
        $insert->bindValue(':id_size', (int) $id_size, PDO::PARAM_INT);
        $insert->bindValue(':stock', $stock, PDO::PARAM_INT);
        $insert->execute();
      }

      $PDO->commit();
      return true;
    } catch (Exception $e) {
      $PDO->rollBack();
      return false;
    }
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
