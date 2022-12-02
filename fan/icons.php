<?php

session_start();

    if ($_SESSION['rules'] != 1) {
		$_SESSION['prevpage'] = "icons.php";
        header("Location: rules.php");
        exit;
    }

$iconpath = "./files/icon/"; // img path
$icon_series = array(
		"99",
		array( // 1....
			"series" => "atelier",
			"title" => "Atelier Series",
			"chara" => array(99,"meruru","annie"),
			"chara_full" => array(99,"Meruru","Annie")
		),
		array(
			"series" => "bdff",
			"title" => "Bravely Default: Flying Fairy",
			"chara" => array(99,"agnes","airy","alternis","edea","group","ringabel","tiz"),
			"chara_full" => array(99,"Agnes Oblige","Airy","Alternis Dim","Edea Lee","group","Ringabel","Tiz Arrior")
		),
		array(
			"series" => "bigorder",
			"title" => "Big Order",
			"chara" => array(99,"daisy","eiji","rin"),
			"chara_full" => array(99,"Daisy","Hoshimiya Eiji","Kurenai Rin")
		),
		array(
			"series" => "dr1",
			"title" => "DanganRonpa",
			"chara" => array(99,"sayaka"),
			"chara_full" => array(99,"Sayaka Miyazono"),
		),
		array(
			"series" => "dr2",
			"title" => "DanganRonpa 2",
			"chara" => array(99,"hajime","komaeda"),
			"chara_full" => array(99,"Hinata Hajime","Komaeda Nagito")
		),
		array(
			"series" => "kazumi",
			"title" => "Kazumi Magica",
			"chara" => array(99,"juubei"),
			"chara_full" => array(99,"Juubey")
		),
		array(
			"series" => "necromancer",
			"title" => "Necromancer",
			"chara" => array(99,"asutsuo","knochen"),
			"chara_full" => array(99,"Asutsuo Johann Faust","Knochen-fresserin")
		),
		array(
			"series" => "niera",
			"title" => "NieR: Automata",
			"chara" => array(99,"a2"),
			"chara_full" => array(99,"A2")
		),
		array(
			"series" => "olympios",
			"title" => "Olympios",
			"chara" => array(99,"hades"),
			"chara_full" => array(99,"Hades")
		),
		array(
			"series" => "pandorahearts",
			"title" => "Pandora Hearts",
			"chara" => array(99,"lrrh","mixed","oz"),
			"chara_full" => array(99,"Lottie Baskerville","Assorted","Oz Vessalius")
		),
		array(
			"series" => "voiceful",
			"title" => "Voiceful",
			"chara" => array(99,"kanae"),
			"chara_full" => array(99,"Kanae")
		),
	 array(
			"series" => "watgbs",
			"title" => "Wadanohara and The Great Blue Sea",
			"chara" => array(99,"lobco","chlomaki","same","wadda"),
			"chara_full" => array(99,"Lobco","Chlomaki","Samekichi","Wadanohara")
		)
);


$index_series = (int) $_GET['s']; // grab our series ID
$index_character = (int) $_GET['c']; // grab our character ID

if($_GET['s'] || $_GET['c']) {
	$errors = 0;
		if(!in_array($icon_series[$index_series], $icon_series)) { $errors++; }
		if(!in_array($icon_series[$index_series]["chara"][$index_character], $icon_series[$index_series]["chara"])) { $errors++; }

	if($errors >= 1) {
		header("Location: ./icons.php?error");
		die("Doesn't exist.");
	}
}

//require_once( './header.htm' );
require_once( './files/header.php' );
require_once( './files/h-default.php' );

?>
<style>
	.goblin {
		background: #fff;
		width: 100px !important;
		height: 100px !important;
		padding: 5px;
		margin: 5px;
	}

	.goblin2 {
		width: 48px;
		height: 48px;
		border: 1px solid grey;
		padding: 2px;
		background: #fff;
	}
</style>
<?php


if (!$_SERVER['QUERY_STRING']) { ?>
<h1>Icons</h1>
<p>These are icons I used to have on tumblr but now have reuploaded onto my fan collective for everyone to enjoy. I've cropped all these from original sources, and all are 100 x 100. <a href="icon_tut.php">I also have my (very outdated) icon tutorial here!</a></p>
<table class="table table-striped">
    <thead>
      <tr>
        <th>Preview</th>
        <th>Series</th>
        <th>Character</th>
				<th>#</th>
      </tr>
    </thead>
    <tbody>
<?php
$super_pero = 0;

$k = 0;
foreach($icon_series as $cookies) {
	$j = 0;
	foreach($cookies["chara_full"] as $candies) {
		if($candies == 99) { $j++; continue; }
	?>
	<tr>
		<td><?php
			$broker = glob($iconpath.$cookies["series"]."_".$cookies["chara"][$j]."/*.*");
			foreach($broker as $img) { echo "<a href='icons.php?s=".$k."&c=".$j."'><img class='goblin2' src='".$img."' '/></a>"; break; }
			?>
		</td>
		<td><strong><?php echo $cookies["title"]; ?></strong></td>
		<td><?php  echo $candies; ?></td>
		<td><?php
		 	if($k == 12 && $j == 4) {
				$wadda_bank = sizeof($broker);
				$wadanohara = array("Apprentice","Norm","Red","Sea","Sorcerer");
				foreach($wadanohara as $wada_type) {
					$bilbi = glob($iconpath."watgbs_wadda/".$wada_type."/*.png");
					$wadda_bank += sizeof($bilbi);
				}
				$super_pero += $wadda_bank;
				echo "$wadda_bank";
		 } elseif($k == 8 && $j == 1) {
			 $super_pero += sizeof($broker);
			 $super_pero += 6;
			echo sizeof($broker) + 6;
		 } else {
			 $super_pero += sizeof($broker);
			 echo sizeof($broker);
		 } ?> icons</td>
	</tr>
	<?php
 		$j++; } // foreach .. as $candies
	$k++; } //foreach .. as $cookies ?>
	<tr>
		<td><a href="?ect"><img class="goblin2" src="./files/icon/ect/1.png" /></a></td>
		<td colspan=2> <strong>misc. / unorganized icons</strong> </td>
		<td>12 icons</td>
	</tr>
	<tr>
		<td colspan=4><strong class="tolby"><center><?php echo $super_pero + 12; ?> icons total</center></strong></td>
	</tr>
</tbody>
</table>

<?php
} elseif($_GET['s'] || $_GET['c']) {

		// check errors.
		//if(in_array($icon_series[$index_series], $icon_series)) { echo "That exists!<br />"; } else { die("ERR: That doesnt exist!"); }
		//if(in_array($icon_series[$index_series]["chara"][$index_character], $icon_series[$index_series]["chara"])) { echo "That exists!<br />"; } else { die("ERR: That doesnt exist!"); }
		//end

		if(!in_array($icon_series[$index_series], $icon_series)) { die("ERR: That doesnt exist!"); }
		if(!in_array($icon_series[$index_series]["chara"][$index_character], $icon_series[$index_series]["chara"])) { die("ERR: That doesnt exist!"); }

		// if(!$_GET['s']) { die("ERR: Series not defined."); }
		// if(!$_GET['c']) { die("ERR: Character not defined."); }

		$mama_mia = 0;
		$testtube = $icon_series[$index_series]["series"] . "_" . $icon_series[$index_series]["chara"][$index_character]; // pick our Directory
		// echo "i am pulling images for " . $testtube . "<br />\n"; //make sure it works
		// echo "the images are located in " . $iconpath.$testtube ."\n"; // ensure the directory
		echo "\n\t<h2>".$icon_series[$index_series]["title"]." &raquo; ".$icon_series[$index_series]["chara_full"][$index_character]."</h2>\n";
		$i = 0;
		$electronika = glob($iconpath.$testtube."/*.*"); // grab all files in the directory and throw them in an array
		echo "<p class='text-center'>";
		foreach($electronika as $img) {
			echo "\t\t<img class='goblin' src='".$img."' alt='".$testtube ."' title='".$testtube."'/>\n";
			$i++;
		}
		echo "</p>";

		echo "\n\t<p><em>There are ".$i." icons total.</em></p>";

		$mama_mia = $i;

		if($_GET['s'] == 8 && $_GET['c'] == 1) {
			$i = 0;
			?><h3>Self Drawn Icons</h3>
			<p>As a bonus, A2 has icons drawn by me. These were meant for a Citta rp I never even started, lol.<br />You are free to use them <strong>as long as you credit back to this site.</strong></p>
			<?php $electronika = glob($iconpath.$testtube."/mine/*.*");
			echo "<p class='text-center'>";
			foreach($electronika as $img) {
				echo "\t\t<img class='goblin' src='".$img."' alt='".$testtube ."' title='".$testtube."'/>\n";
				$i++;
			}?></p><p><em>There are 6 icons total.</em></p><?php
		}


		if($_GET['s'] == 10 && $_GET['c'] == 1) {
			?><h3>RP Banner</h3>
			<p>As a bonus, Lottie has a (abit old) rp banner included!</p>
			<p><img style="padding: 3px; border: 1px solid #ccc;" src="./files/icon/lottie_rpbanner.gif" /></p><?php
		}

		if($_GET['s'] == 12 && $_GET['c'] == 4) {
			$wadanohara = array("Apprentice","Norm","Red","Sea","Sorcerer");
			foreach($wadanohara as $wada_type) { ?>
				<h4><?echo $wada_type; ?></h4>
				<?php
				$bendi = glob($iconpath."watgbs_wadda/".$wada_type."/*.png");
				$i = 0;
				foreach($bendi as $img) {
					echo "\t\t<img class='goblin' src='".$img."' alt='".$wada_type ."' title='".$wada_type."'/>\n";
					$i++;
				}
				echo "\n\t<p><em>There are ".$i." icons total in this section.</em></p>";
				$mama_mia += $i;
			}

			echo "\n\t<p><em>There are ".$mama_mia." icons total on this page.</em></p>";
		}

		echo "\n\t<p><a href='?'>&laquo; go back</a> ";

 } elseif($_SERVER['QUERY_STRING'] == "ect") { ?>
	 <h2>Ectcettera</h2>
	 <?php
	 $electronika = glob($iconpath."ect/*.*"); // grab all files in the directory and throw them in an array
	 echo "<p class='text-center'>";
	 $i = 0;
	 foreach($electronika as $img) {
		 echo "\t\t<img class='goblin' src='".$img."' />\n";
		 $i++;
	 }
		 echo "\n\t<p><em>There are ".$i." icons total.</em></p>";
		 echo "\n\t<p><a href='?'>&laquo; go back</a> ";

 } else {
// <p class="text-center"><img src="http://solstice.party/img/404/tumblr_inline_phhi3of6W41tpnmx1_1280.png" /></p>
	 ?>
	 <p class="text-center"><img src="./files/icon/hm.jpeg" /></p>
	 <p class="text-center">That never existed. Or doesn't exist yet. <a href='?'>Go back</a></p>
	<?php }

//require_once( './footer.htm' );

require_once( './files/f-default.php' );
require_once( './files/footer.php' );
?>
