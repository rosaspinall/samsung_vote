<?php
require 'includes/header.php';

$phoneName = 'Samsung Galaxy Fold';


?>

<link rel=StyleSheet href="styles.css" title="Main">


<body class="backstage2">

	<div id=intro>
		<h2 class="title">Welcome to Samsung Vote</h2>
		<h3>What is Samsung Vote?</h3>
		<p>Samsung vote is where backstage users can submit and vote on their favourite features of each Samsung phone. Let's all work together to find out what the most popular and most sales-generating features of each phone are!</p>
	</div>


	<div id="choose-phone">
		<h3>Choose a phone</h3>
		<p>Select from the list below that you'd like to see features for.<p>
			
		<?php
			$sql = "SELECT * FROM phones";
			$result = mysqli_query($conn, $sql);
			$resultCheck = mysqli_num_rows($result);
		
			if ($resultCheck > 0) {
				while ($row = mysqli_fetch_assoc($result)) { ?>
				<div class="phone">
					<p><a href="/vote.php?phoneid=<?php echo $row['id'] ?>"><?php echo $row['phone_name'] ?></a></p>
				
				</div>
			<?php }
			} else { ?>
				<div id="no-results">
					<p>There aren't any phones to vote for features on yet, check back soon.'</p>
				</div>
			<?php } ?>
			
		
	</div>


<div id="debugging">
	<pre>
		<?php echo print_r($_POST)?>
		
		<?php echo print_r($result) ?>
		
		<?php echo $submitError ?>
		
	</pre>
</div>



</body>