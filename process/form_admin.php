<?php
require_once '../data/conex.php';
require_once '../classes/User.php';

$name = $_POST["name"];
$pass = $_POST["password"];

User::comparison($name, $pass);
