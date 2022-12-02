<?php
// start session ///////////////////////
session_start();
////////////////////////////////////////

// Grab timezone
date_default_timezone_set('America/Los_Angeles');

// create a pages path for Parsedown to find
$pageOfPaths = 'redacted';

// ID for news redireciton
$id = 0;

// errors to force page redirection
// we MUST get error redirection out of the way.
$errors = 0;

// for the GET pages
$kiminoURLwa ="";

// list "secure" pages
$secPages = array("archives","extra","adopt","adopted","miscp");

// for collective stats
require( 'redacted/config.php' ); 
require_once( 'redacted/show_collective_stats.php' );

// for secure pages, check if rules are agreed to.
if ($_SESSION['rules'] != 1) {
	$theWorld = false;
} else {
	$theWorld = true;
}

if($_GET["id"] > 0) { // check if GET is asking for the cutenews page url
	$errors++;
	$newspage = "news.php?id=" . $_GET["id"] ;

}
elseif ($_SERVER['QUERY_STRING']) {  // check what the query string is

	$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
	$_GET = filter_input_array(INPUT_GET, FILTER_FLAG_STRIP_HIGH);
	// sanitise
	$kiminoURLwa = $_SERVER['QUERY_STRING'];
	// grab string
	$kiminoURLwa = strtolower(str_ireplace('<>', '', substr($kiminoURLwa, 0, 40)));
	$kiminoURLwa = preg_replace("![^a-z0-9]+!i", "-", $kiminoURLwa);
	//sanitize even more

	foreach($secPages as $countMeIn) { // check for protected pages
		if($kiminoURLwa == $countMeIn) { $warpGate = true; }
	}

	unset($countMeIn); // destory the foreach() temp variable

	if ($theWorld == false && $warpGate == true) {
		$errors++;
		$newspage ="./rules.php";
		$_SESSION['prevpage'] = "index.php?".$kiminoURLwa;
	} else {
		$kiminoURLwa = $pageOfPaths . $kiminoURLwa . '.md';

		if(!file_exists($kiminoURLwa)) {
			$errors++;
			$newspage ="./404.html";
		}
	}
}


if( $errors > 0 ) {
	echo "ERRORS: ". $errors . "<br />";
	echo "GET: ". $kiminoURLwa . "<br />";
	header("Location: $newspage");

	// unset all the variables used in error gen
	unset($errors);
	unset($warpGate);
	unset($theWorld);
	// die!
	die("Redirecting to... " . $newspage);
}

////////////////////////////////////////////////////////
////////////////////////////////////////////////////////

# header for your header needs
// require_once( './header.htm' );
require_once( './files/header.php' );
require_once( './files/h-default.php' );

# puts in parsedown immedietely.
include_once( './Parsedown.php' );
$Parsedown = new Parsedown();

if (!$_SERVER['QUERY_STRING']) {
#if no query string is present...

	$myBaby = $pageOfPaths.'index.md';
	// $Parsedown = new Parsedown();
	$MyPage = file_get_contents($myBaby);
	# gets a default index.md file
	echo Parsedown::instance()
	   ->setBreaksEnabled(true) # enables automatic line breaks
	   ->text($MyPage); ?>
	   

   <h3>Quick Collective Stats</h3>


	<table style="margin:0 auto;"><tr><td><img src="https://a.solstice.party/pb/pixels/sailormoon/senshicircle.gif" />
	</td><td>
   <?php include('./files/stats_table.php'); ?>
   </td></tr></table>

   <div id="spacer"></div>

		 <?php 


 		$number = 3;
 	  $template = "default_2";
     include("redacted/show_news.php");
	 


?> <center><p><a href="./news.php">Older updates</a></p></center>

<?php
} else {
	$MyPage = file_get_contents($kiminoURLwa);
	echo Parsedown::instance()
	   ->setBreaksEnabled(true) # enables automatic line breaks
	   ->text($MyPage);

	 echo "<p style='display: block;'><h6 style='float:right'>Page last updated " . date ("F d\, Y", filemtime($kiminoURLwa)) . ".</h6></p>";
}

require_once( './files/f-default.php' );
require_once( './files/footer.php' );

?>
