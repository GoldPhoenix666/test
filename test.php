<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "piechart";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 



?>

<!DOCTYPE html>
<html>
<head>

	<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  	<script type="text/javascript" src="https://www.google.com/jsapi"></script>

    <style type="text/css">
    	.span1{
    		border:1px red solid;
    		height:100px;
    	}
    	.span3{
    		border:1px blue solid;
    		height:100px;
    	}
    	.span6{
    		border: 1px orange solid;
    		height:100px;
    	}
    	.span12{
    		border:1px green solid;
	   		height:100px;
    	}
    </style>

    <!-- Latest compiled and minified CSS -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>

	<script type="text/javascript" >
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {



     	var data = new google.visualization.DataTable();

      	data.addColumn('string', 'time');
      	data.addColumn('number', 'hours');

        <?php echo $add_rows ?>

      var options = {
        title: 'Amount of Time in the day',
        sliceVisibilityThreshold: 0
      };

      var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
      chart.draw(data, options);

      

    // Changing legend  
   

    };


	</script>

</head>
<body>

<div class="row-fluid" >
	<div class="span1"></div>
	<div class="span1"></div>
	<div class="span1"></div>
	<div class="span1"></div>
	<div class="span1"></div>
	<div class="span1"></div>
	<div class="span1"></div>
	<div class="span1"></div>
	<div class="span1"></div>
	<div class="span1"></div>
	<div class="span1"></div>
	<div class="span1"></div>
</div>


<div class="row-fluid" >
	<div class="span3"></div>
	<div class="span3"></div>
	<div class="span3"></div>
	<div class="span3"></div>

</div>



<div class="row-fluid" >
	<div class="span6"></div>
	<div class="span6"></div>
</div>


<div class="row-fluid" >
	<div class="span12" ></div>
</div>


<div id="chart_div" style="width: 900px; height: 500px;"></div>



    <div class="table table-responsive"> 

        <table style="width:0%;" class="table .col-md-6 table-bordered">

            <thead>

                <tr>

                    <th>Row</th>

                    <th>First Name</th>

                    <th>Last Name</th>

                    <th>Email</th>

                    <th>Biography</th>

                </tr>

            </thead>

            <tbody>

                <tr>

                    <td>1</td>

                    <td>John</td>

                    <td>Carter</td>

                    <td>johncarter@mail.com</td>

                    <td>Lorem ipsum dolor sit amet…</td>

                </tr>

                <tr>

                    <td>2</td>

                    <td>Peter</td>

                    <td>Parker</td>

                    <td>peterparker@mail.com</td>

                    <td>Vestibulum consectetur scelerisque…</td>

                </tr>

                <tr>

                    <td>3</td>

                    <td>John</td>

                    <td>Rambo</td>

                    <td>johnrambo@mail.com</td>

                    <td>Integer pulvinar leo id risus…</td>

                </tr>

            </tbody>

        </table>

<table style="width:0%;"  class="table .col-md-6 table-bordered">

            <thead>

                <tr>

                    <th>Row</th>

                    <th>First Name</th>

                    <th>Last Name</th>

                    <th>Email</th>

                    <th>Biography</th>

                </tr>

            </thead>

            <tbody>

                <tr>

                    <td>1</td>

                    <td>John</td>

                    <td>Carter</td>

                    <td>johncarter@mail.com</td>

                    <td>Lorem ipsum dolor sit amet…</td>

                </tr>

                <tr>

                    <td>2</td>

                    <td>Peter</td>

                    <td>Parker</td>

                    <td>peterparker@mail.com</td>

                    <td>Vestibulum consectetur scelerisque…</td>

                </tr>

                <tr>

                    <td>3</td>

                    <td>John</td>

                    <td>Rambo</td>

                    <td>johnrambo@mail.com</td>

                    <td>Integer pulvinar leo id risus…</td>

                </tr>

            </tbody>

        </table>

    </div>


</body>
</html>