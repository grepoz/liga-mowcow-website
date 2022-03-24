<?php

	session_start();
	
	function sprawdz_bledy_wysylania()
	{

	  if ($_FILES['file']['error'] > 0)
	  {
		echo 'problem: ';
		switch ($_FILES['file']['error'])
		{
		  case 1: {echo 'Rozmiar pliku jest zbyt duży.'; break;} 
		  case 2: {echo 'Rozmiar pliku jest zbyt duży.'; break;}
		  case 3: {echo 'Plik wysłany tylko częściowo.'; break;}
		  case 4: {echo 'Nie wysłano żadnego pliku.'; break;}

		  default: {echo 'Wystąpił błąd podczas wysyłania.'; break;}
		}
		return false;
	  }
	  return true;
	}


	function sprawdz_typ()
	{
		$fileName = $_FILES['file']['name'];
		$fileExt = explode('.', $fileName);
		$fileActualExt = strtolower(end($fileExt));
		
		$_SESSION['fileActualExt'] = $fileActualExt;
		
		$allowed = array('jpg', 'png');
		
		if (!in_array($fileActualExt, $allowed)){
			echo 'Plik ma inne rozszerzenie niż JPG lub PNG';
			return false;
		}
		return true;
	}


	function zapisz_plik()
	{
		$lokalizacja = '../przeslane_zdjecia/'.$_FILES['file']['name'];

		$_SESSION['lokalizacja'] = $lokalizacja;

		if(is_uploaded_file($_FILES['file']['tmp_name']))
		{
			if(!move_uploaded_file($_FILES['file']['tmp_name'], $lokalizacja))
			{
				echo 'problem: Nie udało się skopiować pliku do katalogu.';
				return false;  
			}
		}
		else
		{
			echo 'problem: Możliwy atak podczas przesyłania pliku.';
			echo 'Plik nie został zapisany.';
			return false;
		}
		return true;
	}
	
	function zmien_nazwe_pliku($lokalizacja, $fileActualExt, $change){
		
		$pathParts = pathinfo($lokalizacja);
		
		$filePathNoExt = $pathParts['dirname'].'/'.$pathParts['filename'];
		
		$nowaLokalizacja = $filePathNoExt.$change.'.'.$fileActualExt;
		
		
		return $nowaLokalizacja;
	}
	
	function stworz_znak_wodny(){
		
		$lokalizacja = $_SESSION['lokalizacja'];
		
		$fileActualExt = $_SESSION['fileActualExt'];
		
		if($fileActualExt == 'jpg')		
			$image = imagecreatefromjpeg($lokalizacja);		
		else		
			$image = imagecreatefrompng($lokalizacja);
		
		// First we create our stamp image manually from GD
		$stamp = imagecreatetruecolor(130, 60);
		imagefilledrectangle($stamp, 0, 0, 129, 60, 0x128870);
		imagefilledrectangle($stamp, 9, 9, 120, 50, 0xFFFFFF);
		imagestring($stamp, 5, 20, 20, 'Galeria LM', 0x128870);

		$right = 10;
		$bottom = 10;
		$sx = imagesx($stamp);
		$sy = imagesy($stamp);

		imagecopymerge($image, $stamp, imagesx($image) - $sx - $right, imagesy($image) - $sy - $bottom, 0, 0, imagesx($stamp), imagesy($stamp), 70);
		// Save the image to file and free memory
		
		$nowaLokalizacja = zmien_nazwe_pliku($lokalizacja, $fileActualExt,  '_with_wm');
		
		if($fileActualExt == 'jpg')
			imagejpeg($image, $nowaLokalizacja);
		else
			imagepng($image, $nowaLokalizacja);
			
		imagedestroy($image);
	
	}
	
	function stworz_miniaturke(){
		
		$lokalizacja = $_SESSION['lokalizacja'];
		
		$fileActualExt = $_SESSION['fileActualExt'];
		
		if($fileActualExt == 'jpg')		
			$image = imagecreatefromjpeg($lokalizacja);		
		else		
			$image = imagecreatefrompng($lokalizacja);
		

		$width  = imagesx($image);
		$height = imagesy($image);

		$width_mini  = 200;
		$height_mini = 125;
		
		$image_mini = imagecreatetruecolor($width_mini, $height_mini);
		
		imagecopyresampled($image_mini, $image, 0, 0, 0, 0, $width_mini, $height_mini, $width, $height);
		
		$nowaLokalizacja = zmien_nazwe_pliku($lokalizacja, $fileActualExt,  '_mini');
		
		if($fileActualExt == 'jpg')
			imagejpeg($image_mini, $nowaLokalizacja);
		else
			imagepng($image_mini, $nowaLokalizacja);
			
		imagedestroy($image);
		imagedestroy($image_mini);
		
	}
	
	
	//main
	if(isset($_POST['submit'])){
		
		$file = $_FILES['file'];
		$fileName = $_FILES['file']['name'];
		$fileTmpName = $_FILES['file']['tmp_name'];
		$fileSize = $_FILES['file']['size'];
		$fileError = $_FILES['file']['error'];
		$fileType = $_FILES['file']['type'];
		
		if(sprawdz_bledy_wysylania()&& sprawdz_typ()){	
			
			zapisz_plik();
			stworz_znak_wodny();
			stworz_miniaturke();			
			$_SESSION['tekst'] =  "wyslano zdjecie";
			
		}
		//header('Location: galeria.php');
	}
	else{
		$_SESSION['tekst'] =  "blad wysylania zdjecia";
	}
	
	
	
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title> Galeria klubu LM </title>
	<meta name="description" content="Tu znajdziesz wszystko by rosnąć scenicznie!"/>
	<meta name="keywords" content="scena, przemawianie, występy publiczne, teatr, improwizacja, zabawa, mic, mikrofon, stage"/>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href ="http://localhost/web/klubLM/style_klubLM.css" type="text/css"/>

	<link href="https://fonts.googleapis.com/css?family=Lato:400,900&display=swap&subset=latin-ext" rel="stylesheet">

</head>

<body>
	<div id="container">
	
		<div id="headertext"> Galeria klubu LM </div>
		<div></div>
		<?php
			echo $_SESSION['tekst'];
			
			
			
		?>
		
		
		
	</div>

</body>
</html>