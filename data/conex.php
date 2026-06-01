<?php
define("DB_SERVER", "localhost");
define("DB_NAME", "stepup_db");
const DB_USER = "root";
const DB_PASS = "";
const DB_CHARSET = "utf8mb4";

const DB_DSN = "mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;

try {
  $conex = new PDO(DB_DSN, DB_USER, DB_PASS);
} catch (Exception $e) {
  echo "<p>Se produjo un error con la base de datos.</p>";
  echo "<p>El código de error es: ";
  echo $e->getMessage();
  echo ". Espere novedades.</p>";
}