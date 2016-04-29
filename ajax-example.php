<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "test";

// connect to mysql server
$connection = @mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (!$connection) {
    die('Connection error: ' . mysqli_connect_error());
}

// retrieve data from query string
$age = $_GET['age'];
$sex = $_GET['sex'];
$wpm = $_GET['wpm'];

// escape user input to help prevent sql injection
$age = mysqli_real_escape_string($connection, $age);
$sex = mysqli_real_escape_string($connection, $sex);
$wpm = mysqli_real_escape_string($connection, $wpm);

// build query
$query = "select * from ajax_example where sex = '$sex'";

if (is_numeric($age)) {
    $query .= " and age <= $age";
}

if (is_numeric($wpm)) {
    $query .= " and wpm <= $wpm";
}

// execute query
$qry_result = mysqli_query($connection, $query) or die(mysqli_error($connection));

// build result string
$display_string = "<table>";
$display_string .= "<tr>";
$display_string .= "<th>Name</th>";
$display_string .= "<th>Age</th>";
$display_string .= "<th>Sex</th>";
$display_string .= "<th>WPM</th>";
$display_string .= "</tr>";

// insert a new row in the table for each person returned
while ($obj = $qry_result->fetch_object()) {
    $display_string .= "<tr>";
    $display_string .= "<td>$obj->name</td>";
    $display_string .= "<td>$obj->age</td>";
    $display_string .= "<td>$obj->sex</td>";
    $display_string .= "<td>$obj->wpm</td>";
    $display_string .= "</tr>";
}

echo "Query: " . $query . "<br />";
$display_string .= "</table>";

echo $display_string;
