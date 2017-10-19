<?php
$servername = "impress51websites.co.uk";
$username = "i51websites";
$password = "T*8a2rure!upH6*r";
$dbname = "i51websites_inspections";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>