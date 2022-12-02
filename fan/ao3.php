<?php
session_start();

$errors = 0;

$fanficPath = "redacted";

if ($_SESSION['rules'] != 1) { // for rules.
	$_SESSION['prevpage'] = "ao3.php"; // grab page to come back
  $errors++;
  $newspage ="rules.php";
}
elseif (strpos($_SERVER['QUERY_STRING'], 'ao3') !== false) {
  $kiminoNamaewa = $kiminoURLwa = $_SERVER['QUERY_STRING']; // grab both title and file
  $kiminoNamaewa = strtolower(str_ireplace('-', ' ', substr($kiminoNamaewa, 0, 40))); //sanitize
  $kiminoNamaewa = strtolower(str_ireplace('.ao3', '', substr($kiminoNamaewa, 0, 40))); //sanitize
  $kiminoURLwa = strtolower(str_ireplace('.ao3', '', substr($kiminoURLwa, 0, 40))); //
  $selectFanfic = $fanficPath . $kiminoURLwa . '.html'; // grab file url

  if(!file_exists($selectFanfic)) { // check if the Fanfic exists
      $errors++;
      $newspage ="ao3.php?404";
    }
}

if( $errors > 0 ) {
  echo "ERRORS: ". $errors . "<br />";
  header("Location: $newspage");
  // die!
  die("Redirecting to... " . $newspage);
}


//include_once('header.htm'); 
require_once( './files/header.php' );
require_once( './files/h-default.php' );
?>
<style>
	ul, li { list-style: none !important; }
	#meta, .meta, #chapters, #userstuff, .chapters, .userstuff { margin: 0 !important; padding: 0 !important; font-family: 'Gentium Basic', serif !important; }
</style>
<?php if (!$_SERVER['QUERY_STRING']) { ?>
<H2>Available fanfics to read....</h2>
<p>These are fanfics written by me, rehosted here. They are originally hosted on <a href="https://archiveofourown.org/users/freakmoch/pseuds/freakmoch">Archive of Our Own!</a><br />
Most of these fanfics contain spoilers to the series they hail from, so if you have not experienced the source material, I recommend you avoid reading unti you do!</p>

<hr>

<p><B>Nier Automata</b></p>
<ul>
<li><a href="?Sands-of-Silence.ao3">Sands of Silence </a> - A2 Drabble</li>
<li><a href="?Cursed-Rebirth.ao3">Cursed Rebirth </a> - After Ending E... Prequel to Unconcious</li>
<li><a href="?Unconcious.ao3">Unconcious</a> - After Ending E... Unfinished.</li>
<li><a href="?Get-In-The-Fucking-Bath-A2.ao3">Get In The Fucking Bath A2</a> - A crackfic.</li>
</ul>

<p><B>Bravely Default</b></p>
	<ul>
<li><a href="?New-Ventures.ao3">New Ventures </a> - Tiz follows Edea instead of Anges, and...</li>
<li><a href="?To-Ashes.ao3">To Ashes</a> - Alternis pining over Anges.</li>
<li><a href="?How-Tiz-Went-Into-A-Coma.ao3">How Tiz Went Into A Coma</a> *Parody. Contains Violence.</li>
<li><a href="?The-Best-Bravely-Second-Fanfic.ao3">The Best Bravely Second Fanfic</a>* Parody</li>
</ul>

<p><B>ECT</b></p>
	<ul>
	<li><a href="?A-Wonder-To-Behold.ao3">A WONDER to behold</a> - Descole goes to the store...</li>
<li><a href="?Sunsets.ao3">Sunsets</a> - Aldnoah Zero Fanfic.</li>
<li><a href="?The-Best-Kingdom-Hearts-Fanfic.ao3">The Best Kingdom Hearts Fanfic</a> *Parody</li>
<li><a href="?Eclipse-is-my-Yaoi-man-Edgelord.ao3">Eclipse is my Yaoi man Edgelord</a> *Parody</li>
</ul>

<p>&nbsp;</p>
<h2>Not by me</h2>
<?php /* <p>Alternatively, I have some of my favorite works hosted as well,<br>
just in case they're taken down....<br>
all credits are within each file, and if you enjoyed them as much as i do<br>
please PLEASE stop by the archive and give kudos!!!!!!!!!</p> */ ?>
<p>I also boast an archive of favorite fanfics not written by me. These were downloaded off AO3, and have all the tags/content warnings in the <b>very beginning of each page.</b> Again, spoilers are imminent.

<p><b>Bravely Default</b></p>
<ul>
<li><a href="?Stay.ao3">Stay by Raaj</a> - <i>They all need protection from their memories at times; a companion with which to stay in the present.</i></li>
<li><a href="?Halfway-Gone.ao3">Halfway Gone by Raaj</a> - <i>She just wants her friend to wake up. They say he should have by now.</i></li>
<li><a href="?Leave-Me-Your-Stardust.ao3">Leave Me Your Stardust by Sonneur</a> <i>Alternis never knew what he needed. Not until then, when it was too late.</i></li>
</ul>
<p><b>Professor Layton</b></p>
<ul>
	<li><a href="?6hershel.ao3">The Six People Hershel Layton Saw in Flora and The One He Didn't by safefontwork (customfont)</a> - <i>“It feels like I escaped one tower just to live in another!" Layton is forced to confront some emotional hangups concerning his daughter.</i></li>
	<li><a href="?spectral.ao3">Spectral by AnaScrawls</a> - <i>Whilst travelling aboard the Bostonius, Hershel contemplates who or what the enigmatic Desmond Sycamore reminds him of, and memories of a past that he can't recall begin to awaken.</i></li>
</ul>
<p><b>ECT.</b></p>
<ul>
<li><a href="?HalfEmpty.ao3">Half-Empty by Hieromancer</a> - [SDR2] <i>Hinata’s time and the changes he underwent at Kibogamine through the eyes of someone who knew him. Major DR1 and SDR2 spoilers, mild DR0 spoilers.</i></li>
<li><a href="?Where-Chrysanthemums-Blossom.ao3">Where Chrysanthemums Blossom</a> - [TOKYO GHOUL] <i>Everyone knows the story of how the moon came to be, of how a god clawed his way to the surface in an explosion of rubble, how the crater left in the wake of his birth is also the launch site of the sparkling jewel high in the night sky.</i></li>
<li><a href="?What-You-Need-Me-To-Be.ao3">What You Need Me To Be  by asdfgjkl</a> - [ALDNOAH ZERO] <i>It's the first time she visits.</i></li>
<li><a href="?greed.ao3">Let's Bring Greed Back! by Aqualisier & guyfierimpreg</a> - [FULLMETAL ALCHEMIST] <i>“But, Young Lord,” Lan Fan said, “in the case of a homunculus, it wouldn’t exactly be </i>human<i> transmutation, would it?” They continued the rest of the journey back to the palace in silence, but the gears in Ling's mind creaked into motion.</i></li>
<li><a href="?Mizael-Goes-To-Macys.ao3">Mizael Goes to Macy's by Mima</a> - [YU-GI-OH ZEXAL] <i>An AU where everything is the same, but Kaito loses on the moon. A few things go a little differently.</i><il>
</ul>

<?php } elseif (strpos($_SERVER['QUERY_STRING'], 'ao3') !== false) {
  echo "<h2>reading " . $kiminoNamaewa . "</h2>";
  require_once($selectFanfic);
  echo "<p><center><a href=\"ao3.php\" class=\"btn btn-primary\">Back to Main</a></center></p>";

} elseif (strpos($_SERVER['QUERY_STRING'], 'ao3') !== true) {?>

		<p class="text-center"><img src="./files/img/starf64.gif" /></p>
		<p class="text-center">That never existed. Or doesn't exist yet. <a href='?'>Go back</a></p>

  <?php

}


//include_once('footer.htm'); 
require_once( './files/f-default.php' );
require_once( './files/footer.php' );
?>
