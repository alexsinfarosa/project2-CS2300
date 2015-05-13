<?php include 'incs/header.php'; ?>


	<!-- SEARCH FORM -->
	<div class="container">
		<form id="search-form" action="index.php" method="get">
			<div class="col-6">
				<select name="status">
					<option value="status">Status</option>
					<option value="new">New</option>
					<option value="trending">Trending</option>
					<option value="popular">Popular</option>
				</select>		
			</div>
			<div class="col-2 text-center">
				<input type="text" name="search" placeholder="Search for package name or author">
			</div>
			<div class="col-6">
				<input type="submit" value="Search">	
			</div>
			<div class="col-6">
				<select name="rating">
					<option value="unspecified ">Rating</option>
					<option value="1">&#9733;</option>
					<option value="2">&#9733;&#9733;</option>
					<option value="3">&#9733;&#9733;&#9733;</option>
					<option value="4">&#9733;&#9733;&#9733;&#9733;</option>
					<option value="5">&#9733;&#9733;&#9733;&#9733;&#9733;</option>
				</select>
			</div>
		</form>
	</div>

	<!-- DISPLAY MESSAGE -->
	<div class="container text-center">
		<div class="col-1">
			<div class="errors">
				<?php echo form_errors($errors); ?>
				<?php echo "<h3>{$message}</h3>"; ?>
				<?php echo $exit; ?>
			</div>
		</div>
	</div>


	<!-- ITEMS COLLECTION -->
<?php

// Dispalying items
if ( !(isset($_GET['search'])) ) {	
	$lines = file("data.txt");
	foreach ($lines as $line) {
		$entry    = explode(' | ', $line);
		$entry[0] = ucwords($entry[0]);
		$entry[1] = ucwords($entry[1]);
echo <<<EOT
<div class="container-small text-center bg-chiaro">
	<div class="col-1">
		<p class="transition-L text-left border-bottom">	
			<span class="title">$entry[0]</span>
			<span class="author">by </span> <span class="package-author"> $entry[1]</span><br>
			<span class="status">Status: </span><span class="status-condition">$entry[2]</span><br>
			<span class="rating">Rating: </span><span class="rating-number">$entry[3]</span>
		</p>
	</div> <!-- end col-1 --> 
</div> <!-- end container --> 
EOT;

	}
} else {
// Displaying search items  
	$searchq = check_input( $_GET['search'] );
	$status  = 			    $_GET['status'];
	$rating  = 			    $_GET['rating'];

	$lines = file("data.txt");
	$check = true;
	foreach ($lines as $line) {
		$entry = explode(' | ', $line);		

		// Searching for same status and same rating
		if ( ((strcasecmp($status, $entry[2]) == 0) && (strcasecmp($rating, $entry[3]) == 0)) ) {
			$entry[0] = ucwords($entry[0]);
			$entry[1] = ucwords($entry[1]);
			$check = false;
echo <<<EOT
<div class="container-small text-center bg-chiaro">
	<div class="col-1">
		<p class="transition-L text-left border-bottom">	
			<span class="title">$entry[0]</span>
			<span class="author">by </span> <span class="package-author"> $entry[1]</span><br>
			<span class="status">Status: </span><span class="status-condition">$entry[2]</span><br>
			<span class="rating">Rating: </span><span class="rating-number">$entry[3]</span>
		</p>
	</div> <!-- end col-1 --> 
</div> <!-- end container --> 
EOT;

	} 
} 

foreach ($lines as $line) {
	$entry = explode(' | ', $line);	

	// Searching for either status or rating
	if ( $check && ((strcasecmp($status, $entry[2]) == 0) || (strcasecmp($rating, $entry[3]) == 0)) ) {
		$entry[0] = ucwords($entry[0]);
		$entry[1] = ucwords($entry[1]);
echo <<<EOT
<div class="container-small text-center bg-chiaro">
	<div class="col-1">
		<p class="transition-L text-left border-bottom">	
			<span class="title">$entry[0]</span>
			<span class="author">by </span> <span class="package-author"> $entry[1]</span><br>
			<span class="status">Status: </span><span class="status-condition">$entry[2]</span><br>
			<span class="rating">Rating: </span><span class="rating-number">$entry[3]</span>
		</p>
	</div> <!-- end col-1 --> 
</div> <!-- end container --> 
EOT;

	}
}

foreach ($lines as $line) {
	$entry = explode(' | ', $line);	

	// Searching for words in the search box. Returns results for package name and author
	if ( ($searchq != "") && ((preg_match("/$searchq/", "$entry[0]")) || (preg_match("/$searchq/", "$entry[1]"))) ) {
		$entry[0] = ucwords($entry[0]);
		$entry[1] = ucwords($entry[1]);
echo <<<EOT
<div class="container-small text-center bg-chiaro">
	<div class="col-1">
		<p class="transition-L text-left border-bottom">	
			<span class="title">$entry[0]</span>
			<span class="author">by </span> <span class="package-author"> $entry[1]</span><br>
			<span class="status">Status: </span><span class="status-condition">$entry[2]</span><br>
			<span class="rating">Rating: </span><span class="rating-number">$entry[3]</span>
		</p>
	</div> <!-- end col-1 --> 
</div> <!-- end container --> 
EOT;

	} else {
		$errors = "Sorry the query was not found";
	}
}
}

?>


	<!-- ADD ENTRY FORM -->
	<div class="container top-margin bottom-margin">
	<h3 class="col-1">Add your favorite plugins to the list <span class="required"> (* = required)</span></h3>
		<form  id="entry-form" name="myform" action="<?php echo($site_root); ?>/index.php" method="post" novalidate>
			<div class="col-5">
				<input type="text" name="name" placeholder="Package Name *" value="<?php echo old('name'); ?>">
			</div>
			<div class="col-5">
				<input type="text" name="author" placeholder="Author *" value="<?php echo old('author'); ?>">
			</div>
			<div class="col-5">
				<select name="status">
					<option value="unspecified" <?php echo $unspecified_status; ?>> Status *</option>
					<option value="new" <?php echo $new; ?>> New</option>
					<option value="trending" <?php echo $trending; ?>> Trending</option>
					<option value="popular" <?php echo $popular; ?>> Popular</option>
				</select>		
			</div>
			<div class="col-5">
				<select name="rating">
					<option value="unspecified" <?php echo $unspecified_rating; ?>> Rating</option>
					<option value="1" <?php echo $one; ?>> &#9733;</option>
					<option value="2" <?php echo $two; ?>> &#9733;&#9733;</option>
					<option value="3" <?php echo $three; ?>> &#9733;&#9733;&#9733;</option>
					<option value="4" <?php echo $four; ?>> &#9733;&#9733;&#9733;&#9733;</option>
					<option value="5" <?php echo $five; ?>> &#9733;&#9733;&#9733;&#9733;&#9733;</option>
				</select>
			</div>
			<div class="col-5">
				<input class="btn-primary" type="submit" name="submit" value="Create Entry">
			</div>
		</form>
	</div>




<?php include 'incs/footer.php'; ?>
