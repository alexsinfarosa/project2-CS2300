<?php 

require 'php/functions.php';

// Making sure the file is there
if( ! file_exists( 'data.txt' ) ) {
	echo "Can't find the file data.txt";
	exit;
}

$success = false;
$errors = array();
$message = "";
$exit = "";

$unspecified_status = "";
$new = "";
$trending = "";
$popular = "";

$unspecified_rating = "";
$one = "";
$two = "";
$three = "";
$four = "";
$five = "";

$search_result = "";

if ( isset($_POST['submit']) ) {
	$name 				= check_input( $_POST['name'] );
	$author 			= check_input( $_POST['author'] );
	$status 			= 			   $_POST['status'];
	$rating 			= 			   $_POST['rating'];

	$success = true;

	// GENERATING STICKY FIELDS 
	// Generating the select attribute for the dropdown menu - status
	$unspecified_status	= ( $status == "unspecified" ) ? "selected" : "" ;
	$new				= ( $status == "new" ) ? "selected" : "" ;
	$trending			= ( $status == "trending" ) ? "selected" : "" ;
	$popular			= ( $status == "popular" ) ? "selected" : "" ;

	// Generating the select attribute for the dropdown menu - rating
	$unspecified_rating	= ( $rating == "unspecified" ) ? "selected" : "" ;
	$one				= ( $rating == "1" ) ? "selected" : "" ;
	$two				= ( $rating == "2" ) ? "selected" : "" ;
	$three				= ( $rating == "3" ) ? "selected" : "" ;
	$four				= ( $rating == "4" ) ? "selected" : "" ;
	$five				= ( $rating == "5" ) ? "selected" : "" ;
	
	// VALIDATION
	if ( empty($name) || empty($author) || ($status == "unspecified") ) {
		$errors['empty-fields'] = "Required fields cannot be blank.";
	} 
	if ( strlen($name) < 3 ) {
		$errors['short-name'] = "Package name should be more than two characters.";
	}

	if ( strlen($name) > 35 ) {
		$errors['long-name'] = "Package name contains too many characters.";
	}

	if ( strlen($author) > 20) {
		$errors['long-author'] = "Author contains too many characters.";
	}
	

	$success = !$errors && $success;
	

	if ($success) {
		$lines = file("data.txt");
		$noMatch = true;

		foreach ($lines as $line) {
			$entry = explode(' | ', $line);
			if ( strcasecmp($name, $entry[0]) == 0 ) {
				$errors['duplicate'] = "The plugin you entered is already in the list.";
				$noMatch = false;
			}
		}

		if	($noMatch) {
			add_registered_user($name, $author, $status, $rating);
			$message = "The plugin has been added!";
			$exit = "<a class = 'exit text-center' href='index.php'>Reset</a>";
		}
	}
}

if(isset($_GET['search'])) {
	$exit = "<a class = 'exit text-center' href='index.php'>Reset</a>";
}

require 'php/index.tmpl.php';

 ?>