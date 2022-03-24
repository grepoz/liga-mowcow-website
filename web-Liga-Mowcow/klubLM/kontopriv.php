<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: dolacz.php');
		exit();
	}
	
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Konto członkowskie</title>
	<meta name="description" content="Tu znajdziesz wszystko by rosnąć scenicznie!"/>
	<meta name="keywords" content="scena, przemawianie, występy publiczne, teatr, improwizacja, zabawa, mic, mikrofon, stage"/>


	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href ="style_klubLM.css" type="text/css"/>

	<link href="https://fonts.googleapis.com/css?family=Lato:400,900&display=swap&subset=latin-ext" rel="stylesheet">
</head>

<body>
	
	<div>
	
		<?php

			echo '<div id="headertext">Witaj '.$_SESSION['user'].'!</div>';
			
		?>
		
		<div><a href="logout.php">wyloguj się</a></div>
		
	</div>

</body>
</html>