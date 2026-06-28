<?php
session_start();

require_once '../data/conex.php';
require_once '../classes/User.php';

$name = $_POST["name"] ?? '';
$pass = $_POST["password"] ?? '';

$user = User::comparison($name, $pass);

if ($user && ($user['role'] ?? null) === 'admin') {
	$_SESSION['user'] = [
		'id' => $user['id'],
		'name' => $user['name'],
		'role' => $user['role'],
	];

	header('Location: ../index.php?vista=admin');
	exit;
}

header('Location: ../index.php?vista=form_admin');
exit;
