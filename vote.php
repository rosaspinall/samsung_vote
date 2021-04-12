<?php

//Includes
require 'includes/header.php';

//Get phone ID
$phoneid = $_GET['phoneid'];

//Get matching phone name from ID
$sql = "SELECT phone_name FROM phones WHERE id=$phoneid;";
$query = mysqli_query($conn, $sql);
$phoneName = $query->fetch_object()->phone_name;
?>

<?php
//Record votes
if(isset($_POST['vote'])) {
	
	$sql = "UPDATE features
		SET `vote_count` = `vote_count` + 1
		WHERE `id` = '$_POST[voted_for]';"; //Retrieve the ID of the item a vote was submitted for
	mysqli_query($conn, $sql);
	 
	 } //end the if voted statement


//Handle new submissions
if(isset($_POST['submit'])) {
	
	$featureName = filter_var($_POST['feature-name'], FILTER_SANITIZE_STRING);
	$featureDescription = filter_var($_POST['feature-description'], FILTER_SANITIZE_STRING);
	$name = filter_var($_POST['submitter-name'], FILTER_SANITIZE_STRING);			
	
	$sql = "INSERT INTO features (phoneid, feature_name, feature_details, feature_submitter, vote_count) VALUES ($phoneid, '$featureName', '$featureDescription', '$name', 0);";
	
	if (mysqli_query($conn, $sql)) {
		//
	} else {
	  $submitError = "Submit Error: " . $sql . "<br>" . mysqli_error($conn);
	}
	
}



?>


	<div id=intro>
		<h2 class="title"><?php echo $phoneName ?>'s most popular features</h2>
		<h3>As voted by the Backstage community!</h3>
	</div>


	<div id="features-container">
	
		<?php
		
			$sql = "SELECT * FROM features WHERE phoneid=$phoneid ORDER BY vote_count DESC;";
			$result = mysqli_query($conn, $sql);
			$resultCheck = mysqli_num_rows($result);
			
			if ($resultCheck > 0) {
				while ($row = mysqli_fetch_assoc($result)) { ?>
				<div class="feature <?php
					if ($_POST[voted_for] == $row['id']) {
					echo "voted-true";
					} else {
					echo "voted-false";
					}
				?>">
					<h4><?php echo $row['feature_name'] ?></h4>
					<p class="vote-count"><?php echo $row['vote_count'] ?> votes</p>
					<p class="submitted-by">Submitted by <?php echo $row['feature_submitter']?> | <span class="time"><?php echo $row['creation_time'] ?></span></p>		
					<p><?php echo $row['feature_details'] ?></p>
					<form action="" method="post">
						<input type="hidden" name="voted_for" value="<?php echo $row['id'] ?>">
						<input type="submit" name="vote" <?php
							//Disable the submit button if already voted
							if ($_POST[voted_for] > 0) {
								echo "value='You have already voted!' disabled";
							} else {
								echo "value='Vote for this feature!'";
							}
						?>>
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
		<h3>Want to submit a feature?</h3>
			<div id="submit-area">
				<p>Tell us your favourite feature about the <?php echo $phoneName ?> and let other Backstage users vote for it!</p>
				<form action="" method="post">
					<input type="hidden" name="phone-name" value ="<?php echo $phoneName ?>">
					<label for="submitter-name">Your Name:</label><br>
					<input type="text" id="submitter-name" name="submitter-name" maxlength="40" cols="20" autocomplete="off"
><br>
					<label for="feature-name">Feature Title:</label><br>
					<input type="text" id="feature-name" name="feature-name" maxlength="40" cols="20" autocomplete="off"
><br>
					<label for="feature-description">Feature Description:</label>
					<textarea name="feature-description" cols="40" rows="5" maxlength="1000" id="feature-description" autocomplete="off"
></textarea>
					<input type="submit" name="submit" value="Submit" onclick="setVoted()">
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


<script>
	if ( window.history.replaceState ) {
		window.history.replaceState( null, null, window.location.href ); //Prevent refreshing submitting a vote again
	}
</script>
	


<?php
include 'includes/footer.php';
?>