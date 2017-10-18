<?php
include('C:\xampp\connection\connect.php');



?>

<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css">
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body>





<div class="row-fluid">
	<div class="span6" style="border: 0px red solid; text-align: center;">
		<h3>Add Information here</h3>
		<form action="newentry.php" method="post" style="float: none; margin: 0 auto;" >
			<label>Activity:</label>
				<input type="text" name="activity" required>
			<label>Hours:</label>
					<input type="number" name="hours" required>
			<label>Minutes:</label>
				<input type="number" name="minutes" min="0" max="59" required>
			<label>Name:</label>
				<select name="personid">

				<?php
				$newentry = mysqli_query($conn, "SELECT * FROM `personname`");
				$row = mysqli_num_rows($newentry);
				while ($row = mysqli_fetch_array($newentry)){
				echo "<option value='" . $row['personid'] . "'>". $row['personname']  . "</option>";
				};?>

 				</select>
				<br />
			<button type="submit" style="margin-top:-10px;" class="btn btn-success btn-small">Add</button>
		</form>
</div>

<div class="span6" style="border: 0px red solid;">
	<form action="addname.php" method="post" style="float: none; margin: 0 auto; text-align: center;">
		<h3>Add User</h3>		
		<label>Username:</label>
			<input type="text" name="personname" required />
			<br />
 		<button type="submit" style="margin-top:-10px;" class="btn btn-success btn-small">Add</button>
		<br />
	</form>
</div>
</div>




</body>
</html>