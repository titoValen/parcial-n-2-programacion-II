<?php
class DB
{
  private const DB_SERVER = "localhost";
  private const DB_NAME = "stepup_db";
  private const DB_USER = "root";
  private const DB_PASS = "";
  private const DB_CHARSET = "utf8mb4";

  private const DB_DSN = "mysql:host=" . self::DB_SERVER . ";dbname=" . self::DB_NAME . ";charset=" . self::DB_CHARSET;

  private PDO $db;

  public function __construct()
  {
    try {
      $this->db = new PDO(self::DB_DSN, self::DB_USER, self::DB_PASS);
    } catch (Exception $e) {
      echo "<p>Se produjo un error con la base de datos.</p>";
      echo "<p>El código de error es: ";
      echo $e->getMessage();
      echo ". Espere novedades.</p>";
      die('<p>Se produjo un error con la base de datos.</p>');
    }
  }

  public function getDB() {
    return $this->db;
  }
}