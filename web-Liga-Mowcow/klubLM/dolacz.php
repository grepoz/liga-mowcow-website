<?php

	session_start();
	
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: kontopriv.php');
		exit();
	}

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Dołącz do klubu Ligi Mówców</title>
	<meta name="description" content="Tu znajdziesz wszystko by rosnąć scenicznie!"/>
	<meta name="keywords" content="scena, przemawianie, występy publiczne, teatr, improwizacja, zabawa, mic, mikrofon, stage"/>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href ="style_klubLM.css" type="text/css"/>

	<link href="https://fonts.googleapis.com/css?family=Lato:400,900&display=swap&subset=latin-ext" rel="stylesheet">
</head>

<body>
	
	<div id="headertext"> Zaloguj się </div>
	
	<br/><br/>
	<div id="form">
		<form action="zaloguj.php" method="post">
			<div class="formfield">	
				<br/><input type="text" name="login"  placeholder="login"/> <br/>
			</div>
			<div class="formfield">	
				<br/> <input type="password" name="haslo" placeholder="hasło"/><br/><br/>
			</div>
			
			<?php
				if(isset($_SESSION['blad']))
				echo '<div class="error">'.$_SESSION['blad'].'</div>';
			?>
			
			<div class="formfield">
				<input type="submit" value="Zaloguj się" />
			</div>
		
			<div class="redirect"><a href="rejestracja.php" class="redirectlink">Zarejestruj się</a></div>
			<div class="redirect"><a href="../index.html" class="redirectlink">Wróć do strony głównej</a></div>
		
		</form>
	</div>
	

</body>
</html>