<?php
if(!isset($_POST['username'])) {
	header('Location: ../index.php');
	die();
}

$username = $_POST['username'];
$password = $_POST['password'];

$password = hash('sha512', $password);

require_once __DIR__ . '/../tabele/Korisnik.php';
$korisnik = Korisnik::login($username, $password);
require_once __DIR__ . '/../tabele/Uloga.php';
$uloga = Uloga::getByName('administrator');


if($korisnik !== null) {
	if($korisnik->uloga_id === $uloga->id && isset($_POST['admin_login'])) {
		session_start();
		$_SESSION['korisnik_admin_id'] = $korisnik->id;
		$_SESSION['korisnik_id'] = $korisnik->id;
		header('Location: ../admin.php');
	} else {
		session_start();
		$_SESSION['korisnik_id'] = $korisnik->id;
		header('Location: ../stranica.php');
	}	
} else {
	header('Location: ../index.php?error=login');
}