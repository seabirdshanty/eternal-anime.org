<?php 
session_start();
$prevPage = $_SESSION['prevpage'];

if ($_GET['login']) {
     if ($_POST['password'] == 'agree') { // idc if its plaintext its just to agree.
			  $_SESSION['rules'] = 1;
			  header("Location: $prevPage");
			  exit();
        exit;
     } 
	 else { 
		header("Location: error.php?404");
	}
	 die();
}


require_once( './files/header.php' );
require_once( './files/h-default.php' );
?>


		<strong>«  DISCLAIMER » </strong>: Before you go in: <ul>
		<li><strong>BE AWARE that Don't Like, Don't Read is in effect here!</strong> This site includes an array of fanworks, including content that one may not agree with.</li>
		<li>This site is soley for the display of fan works only, and is in no way official or affliated with any creator, mangaka, studio or company.</li>
		<li>The content that is on this site is complete fiction, and does not represent my views in any way. No work, character, or setting is meant to represent any real person, place, or thing, and any such occurences are mere coincidence.</li>
		<li><strong>You are not being forced to browse this site, or its content.</strong> If you run into something you don't like, remember you can always close the window and never navigate here again.</li>
		<li>If you are a minor, please obey the laws in your country/state/area pretaining to the age you are allowed to be online. There is no adult content on this site, however there may be suggestive content in the fanworks hosted.</li></ul>
		
<center>
		<p>By accepting these conditions, you hereby consent to reading/viewing the content within and that you are 16 years of age or older.
<p><strong>If you agree to these terms, please type "agree" below to access the site content. <br />If you do not agree, then <a href="http://crouton.net">please leave.</a></p></p></strong>

<form action="rules.php?login=1" method="post">
<input type="password" name="password" />
<input type="submit" />
</form>
</center>
<?php

require_once( './files/f-default.php' );
require_once( './files/footer.php' );

?>
