<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Registracija</title>
	<link rel="stylesheet" href="stilovi/stil-registracija.css">
</head>

<body>
	<form action="logika/registruj_se.php" method="post">
		<input type="text" name="username" placeholder="Korisnicko ime">
		<input type="password" name="password" placeholder="Lozinka">
		<input type="password" name="ponovo_password" placeholder="Ponovite lozinku">
		<input type="email" name="email" placeholder="E-mail">
		<input type="text" name="ime_prezime" placeholder="Ime i prezime">
		<input type="submit" value="Registruj se">
		<?php if(isset($_GET['error'])) { ?>
			<p id="error">Vec postoji korisnik sa tim korisnikom imenom ili e-mailom</p>
		<?php } ?>
	</form>
	
</body>
</html>