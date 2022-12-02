<?php

	if(!$_SERVER['QUERY_STRING']) { $_SERVER['QUERY_STRING'] = 418; }

	$showError = (int) $_SERVER['QUERY_STRING'];

	if ($showError <= 300 || $showError >= 600) {
		$showError = 418;
	}

	$imgPath ="https://solstice.party/a/pb/pixels/sailormoon/";

	switch($showError) {
		case 301: $text = "Moved Permanently"; $img ="mn39a.gif"; break;
		case 302: $text = "Moved Temporarilly"; $img ="mn39a.gif"; break;
		case 400: $text = "Bad Request"; $img = "mn33.gif"; break;
		case 401: $text = "Unauthorized"; $img ="cm30a.gif";  break;
		case 403: $text = "Forbidden"; $img ="cm30a.gif"; break;
		case 404: $text = "Not found"; $img =" ";  break;
		case 410: $text = "Gone"; $img ="aniSA.gif"; break;
		case 418: $text = "I'm a Teapot!"; $img ="cmoon29.gif"; break;
		case 500: $text = "Foul Call"; $img ="mn41.gif"; break;
		case 502: $text = "Bad Gateway"; $img ="mn41.gif"; break;
		default:
			$text = "Silence Glaive!"; $img ="aniSA.gif"; break;
		break;
	}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <title>ERROR</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
	<!-- Google Fonts -->
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <!-- bootstrap requirements -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <!-- // end requirements -->

		<style>

			@keyframes animatedBackground {
				from { background-position: 0 0; }
				to { background-position: 100% 100%; }
			}
		
			body {
				height: 100%;
				width: 100%;
				overflow:  hidden;
				margin: 0;
				padding: 0;
				/* background-image: url('http://tome.solstice.party/files/img/bg06.gif');
				background-attachment: fixed;
				animation: animatedBackground 80s linear infinite; */
			}
		
			* {
				font-family: 'Press Start 2P', cursive;
				font-size: 14px;
				color: #000;
			}

			html {
			  box-sizing: border-box;
			  margin: 0;
			  padding: 0;
			}
				
			a, a:hover, a:visited {
				 color: #280900
			}

			main {
				margin-top: 2em;
			}
			
		</style>

  </head>
  <body>
<main style="text-align:center;">

	<?php if($showError == 404) { ?>
			<a href="error_old.php">
				<img src="<?php echo $imgPath; ?>mn54.gif" />
				<img src="<?php echo $imgPath; ?>starf64.gif">
			</a>
	<?php } else { 
			echo '<img src="' . $imgPath . $img . '" />';
			}
	?>
	<br />
	ERR <?php echo $showError . ": " . $text; ?>
</main>
</body>
</html>
