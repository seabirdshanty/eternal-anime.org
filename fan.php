<?php
// start session ///////////////////////
session_start();
////////////////////////////////////////

// Define constant for fansrite.blogm.php
define('BLOG_LOADED', true);
include_once('./fansrite.blogm.php');

// Initialize managers
$pageRunner = new PageRunner(); // Parsedown based Runner
$pageOfPaths = '/redacted/pages/'; //pages path
$blogPath = '/redacted/news/'; // news path

$blog = new FansRiteBlogManager( $blogPath ); // Blog manager for news posts

// errors to force page redirection
// we MUST get error redirection out of the way.
$errors = 0;

// for the GET pages
$kiminoURLwa ="";

// list "secure" pages
$secPages = array("redacted");

// for secure pages, check if rules are agreed to.
if ($_SESSION['rules'] != 1) {
	$theWorld = false;
} else {
	$theWorld = true;
}

if ($_SERVER['QUERY_STRING']) {  // check what the query string is

	$_GET = filter_input_array(INPUT_GET, FILTER_FLAG_STRIP_HIGH);
	// sanitise using PageRunner
	$kiminoURLwa = $pageRunner->queryRunner($_SERVER['QUERY_STRING']);

	foreach($secPages as $countMeIn) { // check for protected pages
		if($kiminoURLwa == $countMeIn) { $warpGate = true; }
	}

	unset($countMeIn); // destory the foreach() temp variable

	if ($theWorld == false && $warpGate == true) {
		$errors++;
		$newspage ="./rules.php";
		$_SESSION['prevpage'] = "fan.php?".$kiminoURLwa;
	} else {
		if($_SERVER["QUERY_STRING"]  != "hit-it-joe" || $_SERVER["QUERY_STRING"]  != "news") {
			$kiminoURLwa = $pageOfPaths . $kiminoURLwa . '.md';

			if(!file_exists($kiminoURLwa)) {
				$errors++;
				$newspage ="./404.html";
			}
		}
	}
}


if( $errors > 0 ) {
	header("Location: $newspage");
	unset($errors, $warpGate, $theWorld);
	die("Redirecting to... " . $newspage);
} else {

    # header for your header needs
	require_once( './files/header.html' );

	if (!$_SERVER['QUERY_STRING']) { ?>
	<section> 
		<?php $pageRunner->parsedownReader('content/pages/index.md'); ?>
	</section>
	<hr>
	<?php 
	$recentBlogPosts = array_slice($blog->getAll(), 0, 1);
	$blog->displayMultiple($recentBlogPosts);
	?>
	<section>
		<h2>Recent News</h2>
		<?php $blog->displayList(null, true, 5); ?>
	</section>


<?php
	} else {
		$MyPage = file_get_contents($kiminoURLwa);
		$pageRunner->parsedownReader($kiminoURLwa);

		echo "<p style='display: block;'><h6 style='float:right'>Page last updated " . date ("F d\, Y", filemtime($kiminoURLwa)) . ".</h6></p>";

	}

	#Footer for your footer needs
	require_once( './files/footer.html' );

}
?>
