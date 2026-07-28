<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$usuarioActual = $_SESSION['usuario'] ?? null;

if (!$usuarioActual || ($usuarioActual["role"] ?? null) !== "admin") {
  header("Location: index.php");
  exit;
}
