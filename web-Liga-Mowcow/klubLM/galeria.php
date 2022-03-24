<?php

	session_start();
	
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
		<div id="galeriainfo"> Znajdujesz się w wyjątkowej galerii zdjęć Ligi Mówców. W tym miejscu możesz przeglądać, dodawać swoje zdjęcia oraz je upubliczniać. </div>
		
		<form id="form" enctype="multipart/form-data" action="upload.php" 
				 method="post" >
			<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
			<input type="file" name="file" id="file" />
			<label for="file" id="galerialabel"> wybierz zdjęcie</label>
			<input type="submit" name="submit" value="wyślij"/>
		</form>
		
		<div>
				
			<?php
			
			if(!isset($_GET['page'])){
				$page = 1;
			}
			else{
				$page = $_GET['page'];
			}
			
			
			$imagesDirectory = "../przeslane_zdjecia/";

			if(is_dir($imagesDirectory))
			{
				$opendirectory = opendir($imagesDirectory);
			  
				$nr_of_results = 0;
				$results_per_page = 3;	//6 ?
				$nr_of_pages = 1;
			  
			  
				while (($image = readdir($opendirectory)) !== false)
				{
					if(($image == '.') || ($image == '..'))
					{						
						continue;						 
					}
					
					$pathParts = pathinfo($image);
												
					if(strstr($pathParts['filename'],"_mini"))
					{
						$fileActualExt = $pathParts['extension'];
						
						if(($fileActualExt == 'jpg') || ($fileActualExt == 'png'))
						{
							echo "<img src='".$imagesDirectory.$image."'> ";
							
							$nr_of_results++;
							
						}
					} 
				}
				
				closedir($opendirectory);			 
			}
			
			$nr_of_pages = ceil($nr_of_results/$results_per_page);
			
			$this_page_first_result = ($page-1)*$results_per_page;
			
			
			
			
			for($page=1;$page<=$nr_of_pages;$page++){
				
				echo '<a style="color:white" href="galeria.php?page=' . $page . '">' . $page . '</a> ';
				
			}
			
			
		
			?>
		
		
		</div>
		
		
	</div>

</body>
</html>