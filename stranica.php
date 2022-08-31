<?php
session_start();

if(!isset($_SESSION['korisnik_id']) && !isset($_SESSION['korisnik_admin_id'])) {
	header('Location: index.php');
	die();
}

require_once __DIR__ . '/tabele/Meni.php';
$meni = Meni::getAll();

require_once __DIR__ . '/tabele/Stranica.php';
if(isset($_GET['slug']))
	$slug = $_GET['slug'];
else
	$slug = 'pocetna';

$meni_id = Meni::getBySlug($slug)->id;

$stranica = Stranica::getByMeniId($meni_id);

require_once __DIR__ . '/tabele/Komentar.php';
if($stranica !== null)
	$komentari = Komentar::getAllByStranicaId($stranica->id);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Stranica</title>
	<script src="js/jquery.js"></script>
	<link rel="stylesheet" href="stilovi/stil-stranica.css">
	<script>
		$(function() {
			$('#komentar_forma').on('submit', function(e) {
				e.preventDefault();
				var komentar = $('textarea[name="komentar"]').val();
				if(komentar.length == 0)
					return;
				var stranica_id = $('input[name="stranica_id"]').val();
				
				$.ajax({
					url: $('#komentar_forma').attr('action'),
					method: $('#komentar_forma').attr('method'),
					data: {
						'komentar': komentar,
						'stranica_id': stranica_id,
						'ajax':true
					},
					success: function(odgovor) {
						console.log(odgovor);
						var komentar = JSON.parse(odgovor)
						$('#svi_komentari').prepend(
							'<div class="komentar">'+
								'<p>' + komentar.autor + '<span>' + komentar.vreme + '</span>' + '</p>'+
								'<p>' + komentar.komentar + '</p>'+
							'</div>'
						)
						$('textarea[name="komentar"]').val('');
					}
				})
			})
		});
		
	</script>
</head>

<body>
	<nav>
		<ul>
			<?php foreach($meni as $m) { ?>
				<li>
					<a href="stranica.php?slug=<?=$m->slug?>">
						<?=$m->natpis?>
					</a>
				</li>
			<?php } ?>
			<a id="odjava" href="logika/logout.php">Odjavi se</a>
		</ul>
	</nav>
	<main>
		<?php if($stranica !== null) { ?>
			<h1><?= $stranica->naslov ?></h1>
			<?php if($stranica->slika !=='') { ?>
				<img src="<?= $stranica->slika?>" alt="<?=$stranica->naslov?>">
			<?php } ?>
			<h2><?= $stranica->kratki_sadrzaj ?></h2>
			<div id="sadrzaj-prvi">
				<?= $stranica->sadrzaj ?>
			</div>
		<?php } ?>
		<?php if(isset($komentari)) { ?>
			<h3>Komentari</h3>
			<form action="logika/ostavi_komentar.php" method="post" id="komentar_forma">
				<textarea name="komentar"></textarea>
				<input type="hidden" name="stranica_id" value="<?=$stranica->id?>"><br>
				<input type="submit" value="Posalji komentar">
			</form>
			<br>
			<div id="svi_komentari">
				<?php foreach($komentari as $komentar) { ?>
					<div class="komentar">
						<p><?= $komentar->getKorisnik()->ime_prezime ?> <span><?= $komentar->formatirano_vreme() ?></span>
						<?php if(isset($_SESSION['korisnik_admin_id'])): ?>
							<a href="logika/obrisi_komentar.php?id=<?=$komentar->id?>">Obrisi</a>
						<?php endif ?>
						</p>
						<p><?= $komentar->komentar ?></p>
					</div>
				<?php } ?>
		<?php } ?>
		</div>
	</main>
</body>
</html>