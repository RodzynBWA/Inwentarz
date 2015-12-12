<?php
	require_once('libs/inwentarz-lib.php');
	$inwentarz = new Inwentarz();
?>
<!docType html>
<html lang="pl">
	<head>
		<meta charset="utf-8">
		<meta name="robots" content="all">
		<meta name="author" content="Dawid Rodzyn Tomas">
		<meta name="description" content="Inwentarz sprzętu komputerowego to aplikacja webowa która umożliwia sprawdzenie parametrów komputera bez jego fizycznej obecności. Aplikcja na pewno będzie przydatna w szkoła i urzędach">

		<title>Inwentarz sprzętu komputerowego</title>

        <link rel="stylesheet" type="text/css" href="css/powiadomienia.css">
		<link rel="stylesheet" type="text/css" href="css/logowanie.css">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/inwentarz.js"></script>
	</head>
	<body>
		<div class="tekst">
			<p>Inwentarz sprzętu komputerowego szkoły: <?php $inwentarz->nazwaSzkoly(); ?></p>
		</div>
		<section class="logowanie">
			<div class="tytul">Logowanie użytkownika</div>
			<form name="logowanie-inwentarz"  action="index.php" method="post">
				<input type="text" name="login" required title="Login wymagany!" placeholder="Login" data-icon="U">
				<input type="password" name="haslo" required title="Wymagane hasło!" placeholder="Hasło" data-icon="x">
				<input type="submit" name="zaloguj" value="Zaloguj" class="loguj">
			</form>
		</section>
        <?php $inwentarz->logowanie(); ?>
		<?php
            include('footer.php');
        ?>
		<script src="js/odliczanie.js"></script>
	</body>
</html>