<?php
// dont allow direct access to this page!
if (!defined('BLOG_LOADED')) {
    die('Direct access not permitted');
}

date_default_timezone_set('America/Los_Angeles');

// parsedown required! (until i rewrite it myself)
include_once('./Parsedown.php'); 
if (!class_exists('Parsedown')) { die('Parsedown not found'); }


class PageRunner {

	public function settingsLoader( string $settingsPath ) {
		// this loads the settings from a json file and returns an array of settings. If the file doesn't exist, it returns an empty array.
		$settings = [];
		if (file_exists($settingsPath)) {
		    $json = file_get_contents($settingsPath);
		    $settings = json_decode($json, true) ?: [];
		}
		return $settings;
	}

	public function queryRunner( string $slugger ) {
		// this runs a reader & sanitizer for the $_SERVER global
		$slugger = strtolower(
            preg_replace("![^a-z0-9]+!i", "-", 
            str_ireplace('<>', '', substr($slugger, 0, 40)))
        );
		return $slugger;
	}

	public function parsedownReader( string $parsePath ) {
		// reads a markdown file and parses it with Parsedown, then displays it. If the file doesn't exist, it shows an error message.
    // MAKE SURE YOURE PASSING AN .MD FILE NERD!
        if (!file_exists($parsePath)) {
            echo "<em>Nothing here but us chickens!</em>";
        } else {
            $content = file_get_contents($parsePath);
            echo Parsedown::instance()
                ->setBreaksEnabled(true)
                ->text($content);
        }
    }

    public function pageScan( string $pageScanPath ) {
        if (!is_dir($pageScanPath)) {
            echo "<p>ERROR! Page scan path is not a directory!</p>";
            return;
        }

        $goodMorningSanDiego = array();
        $newsPath = $pageScanPath;
        $collectMyPages = glob($newsPath.'*.md');

        // echo "collectMyPages <br />";
        // print_r($collectMyPages);

        foreach($collectMyPages as $johns) {
             // echo $johns . "<br />";
            $johns = str_replace($newsPath, "", $johns);
            // echo $johns . "<br />";
            $johns = explode(".",$johns);
            array_unshift($goodMorningSanDiego, $johns[0]);
            unset($johns);
        }

        // echo "goodMorningSanDiego <br />";
        // print_r($goodMorningSanDiego);
            
        unset($johns);

        echo "<ol>";
        foreach($goodMorningSanDiego as $newsman) {
            echo "<li><a href=\"?" . $newsman . "\" >" . $newsman . "</a></li>";
        }
        echo "</ol>";

    }

}

class FansRiteBlogManager {
	/*
		The IDEA:
		unified content system using numeric sorting on date-based files.
			> readable data for article stored in a json file
			> body of article stored in markdown file
			> sorted using numeric conversion of YYYY-MM-DD to YYYYMMDD

		flow:
			1. list of news files is shown (sorted newest first)
			2. when news is selected, json file is parsed into readable text
			3. markdown file of body is parsed so news is readable.
			4. et viola!


    ==> initialize
        $blog = new FansRiteBlogManager('/path/to/blog/files/');

    ==> get files
        $newestFile = $blog->getNewest();           // Get 1 most recent
        $allFiles = $blog->getAll();                // Get all (sorted newest first)
        $recentFiles = $blog->getRecentDates(5);    // Get 5 most recent

    ==> display content
        $blog->displayContent('2024-09-03');        // Show specific post
        $blog->displayMultiple($recentFiles);       // Show multiple posts
        $blog->displayMultiple();                   // Show all posts

    ==> find posts
        $found = $blog->findByQuery($_GET['post']); // Search by date slug
	*/

	private $pageOfPaths;
	private $files = [];
	
	public function __construct ( string $path ) {
        $this->pageOfPaths = $path;
		if (!is_dir($this->pageOfPaths)) {
			die("<p>ERROR! Content $this->pageOfPaths is not a valid directory!</p>");
			return;
		}
		$this->loadDateBasedFiles();
    }

	private function loadDateBasedFiles() {
		// load all .json files with YYYY-MM-DD naming
		$all = scandir($this->pageOfPaths);
		$this->files = array_filter($all, function($file) {
			return preg_match('/^\d{4}-\d{2}-\d{2}\.json$/', $file);
		});
		$this->sortByNumericDate();
	}

	private function sortByNumericDate() {
		// sort files by converting YYYY-MM-DD to numeric YYYYMMDD
		usort($this->files, function($a, $b) {
			$dateA = str_replace('-', '', preg_replace('/\.json$/', '', $a));
			$dateB = str_replace('-', '', preg_replace('/\.json$/', '', $b));
			$numA = (int)$dateA;
			$numB = (int)$dateB;
			return $numB - $numA; // newest first
		});
	}

	private function parseJson( string $jsonRead ) {
    // parse them jsons.
		if (!file_exists($jsonRead)) { $json_data = null; } 
		else {
			$json = file_get_contents( $jsonRead ) ?? null;
			$json_data = json_decode($json, true) ?? null; 
		}
		if ($json_data == null) { 
			return ["error" => "Could not read JSON file or decode it properly."];
		 } else {
		 	return $json_data;
		 }
	}

	private function formatDate( string $dated ) {
    // format the date via the filename. 
    // yes i know i could just use the file's modify date but this is cuter. >:T
		if (strlen($dated) != 10 || !preg_match("/^\d{4}-\d{2}-\d{2}$/", $dated)) {
			return "Invalid date";
		} else {
			$dated = explode("-", $dated);
			$month_num = (int)$dated[1];
			$months = array("", "Jan", "Feb", "Mar", "Apr", "May", "Jun", 
                            "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
			$month = $months[$month_num] ?? "???";
			return $dated[2] . " " . $month . " " . $dated[0];
		}
	}

	public function getNewest() {
		return $this->files[0] ?? null;
	}

	public function getAll() {
		return $this->files;
	}

	public function findByQuery($query) {
		// sanitize the query
		$slug = strtolower(
			preg_replace("![^a-z0-9]+!i", "-", 
			str_ireplace('<>', '', substr($query, 0, 40)))
		);
		
		// try to find a matching file
		foreach($this->files as $file) {
			$dateOnly = preg_replace('/\.json$/', '', $file);
			if ($dateOnly === $slug) {
				return $dateOnly;
			}
		}
		return null;
	}

	public function displayContent( string $dateSlug ) {
		// validate date format
		if (strlen($dateSlug) != 10 || !preg_match("/^\d{4}-\d{2}-\d{2}$/", $dateSlug)) {
			echo "<p>ERROR! Invalid date format.</p>";
			return;
		}

		// create the paths for the json and markdown files based on the date
		$readJson = $this->pageOfPaths . $dateSlug . ".json";
		$readMark = $this->pageOfPaths . $dateSlug . ".md";

		// check if the json file exists
		if(!file_exists($readJson)) { 
			echo "<p>ERROR! Content file doesn't exist!</p>"; 
			return;
		}

		$json_data = $this->parseJson($readJson);

		// check for errors in json parsing
		if (isset($json_data['error'])) {
			echo "<p>ERROR! " . $json_data['error'] . "</p>";
			return;
		}

		$formattedDate = $this->formatDate($dateSlug);
		?>

		<article class="cutenews">
			<header><h2><?php echo $json_data["title"] ?? "Untitled"; ?></h2></header>
			<?php if (isset($json_data["avatar"]) && $json_data["avatar"]) { ?>
			<img src="<?php echo $json_data["avatar"]; ?>" class="avi"/>
			<?php } ?>
			<section>
			<?php

				if (!file_exists($readMark)) {
					echo "<p>ERROR! No content body found.</p>";
				} else {
					$MyPage = file_get_contents($readMark); 
					echo Parsedown::instance()
						->setBreaksEnabled(true)
						->text($MyPage); 
				}
					
			?>
			</section>
			<footer>Posted on <?php echo $formattedDate; ?></footer>
		</article>
		<?php
	}

	public function displayMultiple( array $dateArray = null ) {
		// if no array provided, show all files
		$filesToShow = $dateArray ?? $this->files;

		foreach($filesToShow as $dateFile) {
			// remove .json extension if present
			$dateSlug = preg_replace('/\.json$/', '', $dateFile);
			$this->displayContent($dateSlug);
		}
	}

	public function getRecentDates( int $limit = 5 ) {
		return array_slice($this->files, 0, $limit);
	}

	public function displayList( array $dateArray = null, bool $showLinks = true, int $limit = 0 ) {
		// if no array provided, show all files
		$filesToShow = $dateArray ?? $this->files;

		if ($limit > 0) {
			$filesToShow = array_slice($filesToShow, 0, $limit);
		} // apply limit if specified


		if (empty($filesToShow)) {
			echo "<p>No articles found.</p>";
			return;
		}

		echo "<ul class=\"article-list\">";
		foreach($filesToShow as $dateFile) {
			$dateSlug = preg_replace('/\.json$/', '', $dateFile);
			$json_data = $this->parseJson($this->pageOfPaths . $dateFile);

			if (isset($json_data['error'])) {
				continue;
			}

			$title = $json_data['title'] ?? 'Untitled';
			$formattedDate = $this->formatDate($dateSlug);

			if ($showLinks) {
				echo "<li><a href=\"news.php?" . htmlspecialchars($dateSlug) . "\">" . htmlspecialchars($title) . "</a> <span class=\"article-date\">(" . $formattedDate . ")</span></li>";
			} else {
				echo "<li>" . htmlspecialchars($title) . " <span class=\"article-date\">(" . $formattedDate . ")</span></li>";
			}
		}
		echo "</ul>";
	}

}

?>
