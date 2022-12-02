
<?php
session_start();

  if ($_SESSION['rules'] != 1) {
		$_SESSION['prevpage'] = "gallery.php";
        header("Location: rules.php");
        exit;
    }


if(!$_GET["gal"] && $_GET["page"] ) {
	$newpage = "gallery.php?gal=" . $_SESSION["gal-check"] . "&page=" . $_GET["page"] ;
	#echo $newpage;
	header("Location: $newpage");
	die();
}

	// Include the UberGallery class
	include('./resources/UberGallery.php');

	// Initialize the UberGallery object
	$gallery = new UberGallery();
	$galleyPath = "redacted";
	// !!


//require_once( './header.htm' );
require_once( './files/header.php' );
require_once( './files/h-default.php' );

	if (!$_SERVER['QUERY_STRING'] && !$_GET["gal"]) {

	/*
		function RandImg($dirLot) {
			$imagesBabie = glob($dirLot . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
			$randomImageScan = $imagesBabie[array_rand($imagesBabie)];
			return $randomImageScan;
		}

	*/
		$TheGalleries  = array();
		// makes your gallery array

		$dircount = 0;
		// stops .  and .. from showing up as valid directories
		$scanGal = scandir($galleyPath);
		// scans your galleries path
		foreach($scanGal as $hungryHippo) {
			$dircount++;
			if($dircount >= 3 ) {
				$handSan = preg_replace('/[^\p{L}\p{N}\s]/u', '', $hungryHippo);
				//cleans the directory names.
				// echo "I took " . $hungryHippo . " and see " . $handSan  . "<br />";
				if (is_dir($galleyPath.$handSan."/")) {
					// echo $handSan . " is a valid directory! <br />";
					array_push($TheGalleries, $handSan);
					// pushes each dr into the galleries array/
				}
			}
		}
		unset($hungryHippo);


		?>
		<section>
	 	<h1>Image Galleries</h1>
		<p>Gallerys of different series illustrations/screenscaps/artwork, oh my! This is just a small collection.</p>
			<p style="text-align:left">
					<ul style="list-style-image: url(./files/img/folder.gif)">

			<?php

			foreach($TheGalleries as &$albumBaby) {

				/*
					// echo "DEBUG: This is $albumBaby.<br />";

					$thatsWhatICallArt = "./galleries/".$albumBaby."/";
					// echo "DEBUG: The directory is ".$thatsWhatICallArt."<br />";
					//$ahMyGoddess = RandImg($thatsWhatICallArt);

					$imagesSh = glob($thatsWhatICallArt . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
					$ahMyGoddess = $imagesSh[array_rand($imagesSh)];

					// echo "DEBUG: Image is $ahMyGoddess. !!<br />";
					*/
			?>

			<li>
				<a href="?gal=<?php echo $albumBaby ?>"><?php echo $albumBaby ?></a>
			</li>
<?php

			}

?>			</ul>
		<p></p>
	</section>

<?php
		} elseif($_GET["gal"] != "") {?>
		<section style="text-align:center;>
			<nav aria-label="breadcrumb">

		<?php

					$_SESSION["gal-check"] = $galpal = $_GET["gal"];
					// Initialize the gallery array
					// prepare your ass
					// echo "DEBUG: Hi! I'm looking for images from $galleyPath".$_GET["gal"]."!<br />";

					?>

				<ol class="breadcrumb arr-right">
					<li class="breadcrumb-item "><a href="gallery.php">Gallery</a></li>
					<?

					if(strpos($galpal,"/")) {
						#echo "DEBUG: This gallery is a subdirectory!<br />";
						$galleyBabies = explode('/', $galpal);
						$galleyBabiesDeus = sizeof($galleyBabies);
						$i == 0;
						foreach ($galleyBabies as &$memes) { $i++;?>

						<li class="breadcrumb-item<?php
								if($galleyBabiesDeus == $i) {
									echo " active"; }?>" aria-current="page">
								<?php if($galleyBabiesDeus != $i) { ?><?php echo $memes; ?><?php } else { echo $memes; } ?>

						<?php
						}

						unset($memes); // break the reference with the last element

					} else {


						?>
					<li class="breadcrumb-item active" aria-current="page"><?php echo $_GET["gal"]; ?></li>
					<?php } ?>


					  </ol>
					</nav>

					<p>
					<ul style="list-style-image: url(./files/img/folder.gif);text-align:left">
					<?php /////////////////////////////////////////////


					$testingBabey = array_diff(scandir($galleyPath.$galpal), array('..', '.'));
					foreach($testingBabey as &$forgetMe) {
						if(is_dir($galleyPath.$galpal."/".$forgetMe) == true) {
								echo "<li><a href=\"?gal=$galpal/".$forgetMe."\">$forgetMe</a></li>";
						}
					}
					unset($forgetMe);

					?>
					</ul>
					</p>


					<center>
		<?php


					$galleryArray = $gallery->readImageDirectory($galleyPath.$_GET["gal"]);

					// Define theme path
					if (!defined('THEMEPATH')) {
							define('THEMEPATH', $gallery->getThemePath());
					}

					// Set path to theme index
					$themeIndex = $gallery->getThemePath(true) . '/index.php';

					// Initialize the theme
					if (file_exists($themeIndex)) {
							include($themeIndex);
					} else {
							die('ERROR: Failed to initialize theme');
					}

					?>
					</center>
					</section>
					<?php

			}

			//include_once('footer.htm');

		require_once( './files/f-default.php' );
		require_once( './files/footer.php' );

	?>
