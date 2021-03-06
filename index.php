<?php
include('../../includes/connect.php');

$suppliersquery = mysqli_query($conn, "SELECT * FROM `suppliers`");

$suppliersrows = '';
while ($row = mysqli_fetch_assoc($suppliersquery)) {
    $suppliersrows .= 'activechartdata.addRow(["' . $row['suppliers'] . "  " . '", ' . $row['compliance'] . ']);';
}

$grandtotal = mysqli_query($conn, "SELECT ((SUM(`sample`) - SUM(`nc`)))* 100 / (SELECT SUM(`sample`) FROM `inspection data` ) AS `percent` FROM `inspection data`");
$percentrow = mysqli_fetch_assoc($grandtotal); 
$totalsum = $percentrow['percent'];


$compliancechart = '';
while ($row = mysqli_fetch_assoc($totalsum)) {
    $compliancechart .= 'piedata.addRow([' . $row['percent'] . "Within Specifications" . ']);';
}

$remainingtotal = mysqli_query($conn, "SELECT SUM(`sample`) - (SELECT SUM(`sample`) FROM `inspection data` WHERE `inspection data`.`failed` = 'yes' ) AS `remain` FROM `inspection data`");
$newrow = mysqli_fetch_assoc($remainingtotal); 
$sampleremain = $newrow['remain'];


$totalquery = mysqli_query($conn, "SELECT SUM(`sample`) AS `sampletotal` FROM `inspection data`");
$newrow = mysqli_fetch_assoc($totalquery); 
$samplesum = $newrow['sampletotal'];


$badbatchquery = mysqli_query($conn, "SELECT SUM(`nc`) AS `nctotal` FROM `inspection data`");
$newrow = mysqli_fetch_assoc($badbatchquery); 
$ncsum = $newrow['nctotal'];

$percentagequery = mysqli_query($conn, "SELECT SUM(`sample`) - SUM(`nc`) FROM `inspection data`  AS `percentage`");




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
	SELECT `products`.*, `inspection data`.*, `suppliers`.* 
	FROM `products` 
	JOIN `inspection data` 
	ON `inspection data`.`product` = `products`.`product` 
	JOIN `suppliers` 
	ON `suppliers`.`product` = `inspection data`.`product`
	WHERE `inspection data`.`failed` = 'yes'
	");

$producttable = '<table class="table table-striped table-bordered" style="float: none; margin: 0 auto;">
			<tr style="color:white;">
				<th style="text-align:center; background-color:#008B8B">Product</th>
				<th style="text-align:center; background-color:#008B8B"">Pack Size</th>
				<th style="text-align:center; background-color:#008B8B"">Supplier</th>
				<th style="text-align:center; background-color:#008B8B"">Date Code</th>
				<th style="text-align:center; background-color:#008B8B"">Sample</th>
				<th style="text-align:center; background-color:#008B8B"">&nbsp;&nbsp;&nbsp;N/C&nbsp;&nbsp;&nbsp;</th>
				<th style="text-align:center; background-color:#008B8B"">Comments</th>
				<th style="text-align:center; background-color:#008B8B"">Traceability Code</th>
			</tr>
';

while ($row = mysqli_fetch_assoc($productdata)) {
$producttable .=
			'<tr>
				<td>'.$row['product'].'</td>
				<td>'.$row['pack size'].'</td>
				<td>'.$row['suppliers'].'</td>
				<td style="text-align:center;">'.$row['date'].'</td>
				<td style="text-align:center;">'.$row['sample'].'</td>
				<td style="text-align:center;">'.$row['nc'].'</td>
				<td>'.$row['nc'].' x '.$row['comments'].'</td>
				<td>'.$row['trace'].'</td>
			</tr>';
}

$producttable .= '
			<tr>
				<td></td>
			</tr>';


$producttable .= '
			<tr>
				<td>Remaining Sample</td><td></td><td></td><td></td><td style="text-align:center;">'.$sampleremain.'</td><td style="text-align:center;">0</td><td></td><td></td>
			</tr>';


$producttable .= '
			<tr>
				<td>Total</td><td></td><td></td><td></td><td style="text-align:center;">'.$samplesum.'</td>
				<td style="text-align:center;">'.$ncsum.'</td><td></td><td></td>
			</tr>';		



$producttable .= '
			<tr>
				<td>Performance Level for Inspection</td><td></td><td></td><td></td><td style="text-align:center;">'.$totalsum.'%</td><td></td><td></td><td></td>
			</tr>
</table>
';
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

	<script type="text/javascript" >
		google.charts.load('current', {'packages':['corechart']});
		google.charts.setOnLoadCallback(drawChart);

		function drawChart() {

		var piedata = new google.visualization.DataTable();

		piedata.addColumn('string', 'time');
		piedata.addColumn('number', 'percent');

<?php echo $compliancechart ?>

		var options = {title: 'Compliance with Specifications', sliceVisibilityThreshold: 0};

		var chart = new google.visualization.PieChart(document.getElementById('percentdiv'));
		chart.draw(piedata, options);};
	</script>



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
		}
	</script>

	<style type="text/css">
body{
/*	width:1100px;*/
}

	</style>
	
</head>
<body>

<h1>Summary Inspection Report - Atherstone</h1>

<div class="row-fluid">
	<div class="span9" style="border: 0px solid red;">
		<?php echo $detailstable ?>	
	</div>


	<div class="span3" style="border: 1px solid lightgrey; border-radius: 5px;">
		<div id="percentdiv" style="border-top:20px solid lightgrey; border-radius: 5px; min-height:200px;"></div>
	</div>
</div>

<div class="row-fluid" >
	<div class="span9" style="border: 0px solid green">
		<?php echo $producttable ?>
	</div>
	<div class="span3" style="border: 1px solid lightgrey; border-radius: 5px;">
		<div id="supplierschart" style="border-top:20px solid lightgrey; border-radius: 5px; min-height:200px;">

		</div>
	</div>
</div>
<br />

<div class="row-fluid">
	<div class="span9" style="border: 1px solid lightgrey; border-radius: 5px;">
		<div>
<?php
	$data = mysqli_query($conn, "SELECT * FROM `images` LEFT JOIN `inspection data` ON `images`.`product` = `inspection data`.`product` ORDER BY `image` ASC");
	while($newrow2 = mysqli_fetch_assoc($data))
{
	$imglocation = $newrow2['location'];

	echo '<div style="display: inline-block; margin-right:50px;"><p style="display: inline-block;" >'.$newrow2['product'].' with '.$newrow2['comments'].'</p><br />';
	echo '<img height="150px" width="150px" alt="img" src="'.$imglocation.'"> </div>';

}
?> 	

		</div>
	</div>
</div>
</body>
</html>