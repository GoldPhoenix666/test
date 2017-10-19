<?php
include('connect.php');

$suppliersquery = mysqli_query($conn, "SELECT * FROM `suppliers`");

$suppliersrows = '';
while ($row = mysqli_fetch_assoc($suppliersquery)) {
    $suppliersrows .= 'activechartdata.addRow(["' . $row['suppliers'] . "  " . '", ' . $row['compliance'] . ']);';
}

//FIRST TABLE
$detailsdata = mysqli_query($conn, "SELECT * FROM `inspection details`");

while ($row = mysqli_fetch_assoc($detailsdata)) {
$detailstable = '<table class="table table-striped table-bordered" style="float: none; margin: 0 auto;">
			<tr>
				<th>Date:</th><td>'.$row['date'].'</td><th>Category:</th><td>' .$row['category']. '</td>
			</tr>
			<tr>
				<th>Inspector:</th><td>' .$row['inspector']. '</td><th>Location:</th><td>' .$row['location']. '</td>
			</tr>
			<tr>
				<th>Supplier:</th><td>' .$row['supplier']. '</td><th></th><td></td>
			</tr>';
}
$detailstable .= '</table>';






//SECOND TABLE
$productdata = mysqli_query($conn, "
	SELECT `product`.*, `inspection data`.*, `suppliers`.* 
	FROM `product` 
	JOIN `inspection data` 
	ON `inspection data`.`product` = `product`.`product` 
	JOIN `suppliers` 
	ON `suppliers`.`product` = `inspection data`.`product`");

while ($row = mysqli_fetch_assoc($productdata)) {
$producttable = '<table class="table table-striped table-bordered" style="float: none; margin: 0 auto;">
			<tr>
				<th>Product</th><th>Pack Size</th><th>Supplier</th><th>Date Code</th><th>Sample</th><th>N/C</th><th>Comments</th><th>Traceability Code</th>
			</tr>

			<tr>
				<td>data</td><td>data2</td>
			</tr>

				';
}
$producttable .= '</table>';


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


	<script type="text/javascript">
  		google.charts.load('current', {'packages':['corechart']});

		google.charts.setOnLoadCallback(drawVisualization);

		function drawVisualization() {

     	var activechartdata = new google.visualization.DataTable();
        activechartdata.addColumn('string', 'name');
        activechartdata.addColumn('number', 'Quantity');

<?php echo $suppliersrows ?>  

		activechartdata.sort({column: 1, desc: false});
		
      	var options = {title: 'Regional performance by supplier', chartArea: {width: '60%'},
      	hAxis: {
      	title: 'Compliance (%)', minValue: 0},
        vAxis: {title: 'Suppliers', direction:'1'},
        annotation:{1:{style:'line'}}};
      	var chart = new google.visualization.BarChart(document.getElementById('supplierschart'));
      	chart.draw(activechartdata, options);
		};
	</script>

<!--
	<script type="text/javascript">
  
		google.charts.setOnLoadCallback(drawVisualization);

		function drawVisualization() {

     	var namechartdata = new google.visualization.DataTable();
        namechartdata.addColumn('string', 'name');
        namechartdata.addColumn('number', 'Quantity');
    
<?php // echo $peoplechart ?>  

      	var options = {title: 'Peoples activities', chartArea: {width: '60%'},
      	hAxis: {
		title: '# of Activities', minValue: 0},
        vAxis: {title: 'Name', direction:'-1'},
        annotation:{1:{style:'line'}}};
      	var chart = new google.visualization.BarChart(document.getElementById('peoplediv'));
      	chart.draw(namechartdata, options);
		};
	</script>
-->

</head>
<body>

<h1>Summary Inspection Report - Atherstone</h1>

<div class="row-fluid">
	<div class="span9" style="border: 1px solid red;">
		<?php echo $detailstable ?>	
	</div>


	<div class="span3" style="border: 1px solid blue">
	</div>
</div>

<div class="row-fluid" >
	<div class="span9" style="border: 1px solid green">
		<?php echo $producttable ?>
	</div>
</div>
<br />

<div class="row-fluid">
	<div class="span9" style="border: 1px solid red">
		
	</div>
	
<div class="span3" style="border: 1px solid blue">
		<div id="supplierschart" style="border-top:20px solid lightgrey; border-radius: 5px; min-height:200px;"></div>
	</div>
</div>





</body>
</html>