<?php
session_start();
if(isset($_SESSION['korisnik_id'])) {
	header('Location: stranica.php');
	die();
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Login</title>
	<link rel="stylesheet" href="stilovi/stil-index.css">
</head>

<body>
	<form action="logika/prijavi_se.php" method="post">
		<input type="text" name="username" placeholder="Korisnicko ime">
		<input type="password" name="password" placeholder="Lozinka">
		<input type="submit" value="Prijavi se">
		<?php if(isset($_GET['error'])) { ?>
			<p id="error">Pogresno korisnicko ime ili lozinka.</p>
		<?php } ?>
	</form>
	
</body>
</html>