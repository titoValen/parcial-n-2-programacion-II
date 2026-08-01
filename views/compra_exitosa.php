<?php
$id_buy = $_GET['id'] ?? null;
?>

<main class="compra-exitosa-main">
  <h1>¡Compra confirmada!</h1>

  <?php if ($id_buy): ?>
    <p>Tu número de pedido es <strong>#<?= htmlspecialchars($id_buy, ENT_QUOTES, 'UTF-8') ?></strong>.</p>
  <?php endif; ?>

  <p>Podés ver el detalle en tu perfil.</p>
  <div class="container-compra-exitosa-links">
    <a href="?vista=perfil" class="compra-exitosa-link">Perfil</a>
    <a class="compra-exitosa-link" href="?vista=producto">Seguir comprando</a>
  </div>
</main>