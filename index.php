<?php
$conn = mysqli_connect("localhost","samsung_vote","m6MG6jyzqdXACr4S","samsung_vote");

$phoneName = 'Samsung Galaxy Fold';

// Check connection
if ($conn -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

//Record votes
if(isset($_POST['vote'])) {
	
	$sql = "Update features
		Set `vote_count` = `vote_count` + 1
		Where `id` = '$_POST[voted_for]';"; //Retrieve the ID of the item a vote was submitted for
	mysqli_query($conn, $sql);
}


//Handle new submissions
if(isset($_POST['submit'])) {
	
	$featureName = $_POST['feature-name'];
	$featureDescription = $_POST['feature-description'];
	$name = $_POST['submitter-name'];			
	
	$sql = "INSERT INTO features (phoneid, feature_name, feature_details, feature_submitter, vote_count) VALUES (1, '$featureName', '$featureDescription', '$name', 0);";
	
	if (mysqli_query($conn, $sql)) {
		//
	} else {
	  $submitError = "Submit Error: " . $sql . "<br>" . mysqli_error($conn);
	}
	
}



?>

<link rel=StyleSheet href="styles.css" title="Main">


<body class="backstage2">

	<div id=intro>
		<h2 class="title"><?php echo $phoneName ?>'s most popular features</h2>
		<h3>As voted by the Backstage community!</h3>
	</div>


	<div id="features-container">
	
		<?php
		

		
		
		
			$sql = "SELECT * FROM features WHERE phoneid=1 ORDER BY vote_count DESC;";
			$result = mysqli_query($conn, $sql);
			$resultCheck = mysqli_num_rows($result);
			
			if ($resultCheck > 0) {
				while ($row = mysqli_fetch_assoc($result)) { ?>
				<div class="feature">
					<h4><?php echo $row['feature_name'] ?></h4>
					<p class="vote-count"><?php echo $row['vote_count'] ?> votes</p>
					<p><?php echo $row['feature_details'] ?></p>
					<p class="submitted-by">Submitted by <?php echo $row['feature_submitter'] ?></p>		
					<form action="" method="post">
						<input type="hidden" name="voted_for" value="<?php echo $row['id'] ?>">
						<input type="submit" name="vote" value="Vote for this feature!">
					</form>
		
					
				</div>
			<?php }
			} else { ?>
				<div id="no-results">
					<p>Nobody has submitted their favourite feature's for the <?php echo $phoneName ?> yet - why not be the first?</p>
				</div>
			<?php } ?>
		
	</div>

	<div id="submit-feature">
		<?php
		if(isset($_POST['submit'])) {
			if (mysqli_query($conn, $sql)) {
				echo "<p>Thanks for your submission!</p>";
			} else {
			  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
		} else { ?>
			<div id="submit-area:">
				<h3>Want to submit a feature?</h3>
				<p>Tell us your favourite feature about the <?php echo $phoneName ?> and let other Backstage users vote for it!</p>
				<form action="" method="post">
					<input type="hidden" name="phone-name" value ="<?php echo $phoneName ?>">
					<label for="submitter-name">Your Name:</label>
					<input type="text" id="submitter-name" name="submitter-name">
					<label for="feature-name">Feature Title:</label>
					<input type="text" id="feature-name" name="feature-name">
					<label for="feature-description">Feature Description:</label>
					<input type="text" id="feature-description" name="feature-description">
					<input type="submit" name="submit" value="submit">
				</form>
			</div>
		<?php } //Close the else statement?> 
	</div>




<div id="debugging">
	<pre>
		<?php echo print_r($_POST)?>
		
		<?php echo print_r($result) ?>
		
		<?php echo $submitError ?>
		
	</pre>
</div>



</body>