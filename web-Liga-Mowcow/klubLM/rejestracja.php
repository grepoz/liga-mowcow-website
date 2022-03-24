<?php

	session_start();
	
	if (isset($_POST['email']))
	{
		//Udana walidacja? Załóżmy, że tak!
		$wszystko_OK=true;
		
		//Sprawdź poprawność nickname'a
		$nick = $_POST['nick'];
		
		//Sprawdzenie długości nicka
		if ((strlen($nick)<3) || (strlen($nick)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_nick']="Nick musi posiadać od 3 do 20 znaków!";
		}
		
		if (ctype_alnum($nick)==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_nick']="Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
		}
		
		// Sprawdź poprawność adresu email
		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		{
			$wszystko_OK=false;
			$_SESSION['e_email']="Podaj poprawny adres e-mail!";
		}
		
		//Sprawdź poprawność hasła
		$haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];
		
		if ((strlen($haslo1)<8) || (strlen($haslo1)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Hasło musi posiadać od 8 do 20 znaków!";
		}
		
		if ($haslo1!=$haslo2)
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Podane hasła nie są identyczne!";
		}	

		$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
		
		//Czy zaakceptowano regulamin?
		if (!isset($_POST['regulamin']))
		{
			$wszystko_OK=false;
			$_SESSION['e_regulamin']="Potwierdź akceptację regulaminu!";
		}				
			
		
		//Zapamiętaj wprowadzone dane
		$_SESSION['fr_nick'] = $nick;
		$_SESSION['fr_email'] = $email;
		$_SESSION['fr_haslo1'] = $haslo1;
		$_SESSION['fr_haslo2'] = $haslo2;
		if (isset($_POST['regulamin'])) $_SESSION['fr_regulamin'] = true;
		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try 
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				//Czy email już istnieje?
				$rezultat = $polaczenie->query("SELECT id FROM czlonkowie WHERE email='$email'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_maili = $rezultat->num_rows;
				if($ile_takich_maili>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
				}		

				//Czy nick jest już zarezerwowany?
				$rezultat = $polaczenie->query("SELECT id FROM czlonkowie WHERE user='$nick'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_nickow = $rezultat->num_rows;
				if($ile_takich_nickow>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_nick']="Istnieje już gracz o takim nicku! Wybierz inny.";
				}
				
				if ($wszystko_OK==true)
				{
					//Hurra, wszystkie testy zaliczone, dodajemy gracza do bazy
					
					if ($polaczenie->query("INSERT INTO czlonkowie VALUES (NULL, '$nick', '$haslo_hash', '$email', 100, 100, 100, 14)"))
					{
						$_SESSION['udanarejestracja']=true;
						header('Location: witamy.php');
					}
					else
					{
						throw new Exception($polaczenie->error);
					}
					
				}
				
				$polaczenie->close();
			}
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
			echo '<br />Informacja developerska: '.$e;
		}
		
	}
	
	
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title> Zostań członkiem klubu LM</title>
	<meta name="description" content="Tu znajdziesz wszystko by rosnąć scenicznie!"/>
	<meta name="keywords" content="scena, przemawianie, występy publiczne, teatr, improwizacja, zabawa, mic, mikrofon, stage"/>


	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href ="style_klubLM.css" type="text/css"/>

	<link href="https://fonts.googleapis.com/css?family=Lato:400,900&display=swap&subset=latin-ext" rel="stylesheet">

</head>

<body>
	<div id="container">
	
		<div id="headertext"> Zostań członkiem klubu LM </div>
		
		<div id="form">
			<form method="post">
			
				<div class="formfield">				
					<br /> <input type="text" placeholder="login" value="<?php
						if (isset($_SESSION['fr_nick']))
						{
							echo $_SESSION['fr_nick'];
							unset($_SESSION['fr_nick']);
						}
					?>" name="nick" /><br />
					
				</div>
				
				<?php
					if (isset($_SESSION['e_nick']))
					{
						echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
						unset($_SESSION['e_nick']);
					}
				?>
				
				<div class="formfield">	
					<br /> <input type="text" placeholder="e-mail" value="<?php
						if (isset($_SESSION['fr_email']))
						{
							echo $_SESSION['fr_email'];
							unset($_SESSION['fr_email']);
						}
					?>" name="email" /><br />
				</div>
								
				<?php
					if (isset($_SESSION['e_email']))
					{
						echo '<div class="error">'.$_SESSION['e_email'].'</div>';
						unset($_SESSION['e_email']);
					}
				?>
				
				<div class="formfield">	
					<br /> <input type="password" placeholder="hasło" value="<?php
						if (isset($_SESSION['fr_haslo1']))
						{
							echo $_SESSION['fr_haslo1'];
							unset($_SESSION['fr_haslo1']);
						}
					?>" name="haslo1" /><br />
				</div>
				
				<?php
					if (isset($_SESSION['e_haslo']))
					{
						echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
						unset($_SESSION['e_haslo']);
					}
				?>		
				
				<div class="formfield">	
					<br /> <input type="password" placeholder="powtórz hasło" value="<?php
						if (isset($_SESSION['fr_haslo2']))
						{
							echo $_SESSION['fr_haslo2'];
							unset($_SESSION['fr_haslo2']);
						}
					?>" name="haslo2" /><br />
				</div>
				
				<div class="formfield">	
					<label>
						<input type="checkbox" name="regulamin" <?php
						if (isset($_SESSION['fr_regulamin']))
						{
							echo "checked";
							unset($_SESSION['fr_regulamin']);
						}
							?>/> Akceptuję regulamin
					</label>
				</div>
				
				<?php
					if (isset($_SESSION['e_regulamin']))
					{
						echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
						unset($_SESSION['e_regulamin']);
					}
				?>	<br />
				
				<div class="formfield">
					<input type="submit" value="Zarejestruj się" />
				</div>
				
				<div class="redirect"><a href="dolacz.php" class="redirectlink">Zaloguj się</a></div>
				<div class="redirect"><a href="../index.html" class="redirectlink">Wróć do strony głównej</a></div>
				
			</form>			
		</div>
		
		
		
	</div>

</body>
</html>