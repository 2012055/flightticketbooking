<?php
  // Database connection settings
$host = "localhost"; // Host name
$user = "root"; // Mysql username
$password = ""; // Mysql password
$dbname = "flightticketbooking"; // Database name
// Create connection
$conn = mysqli_connect($host, $user, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
$date=$_POST["date"];
$time=$_POST["time"];
$sql="SELECT * FROM admintable WHERE dates='$date' AND timess='$time'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
 // Output the data
 while ($row = mysqli_fetch_assoc($result)) {
   echo "Available flights based on your ".$date." and ".$time."<br>";
 
   echo "Departure: " . $row["departure"] . "<br>";
   echo "Destination: " . $row["destination"] . "<br>";
   echo "Date: " . $row["dates"] . "<br>";
   echo "Time: " . $row["timess"] . "<br>";
   echo "Flight Number: " . $row["flightnumber"] . "<br>";
   $seatcount=$row["seatcount"];
   echo "----------------------------------<br>";
 }
}
else{
 echo "No available flights on " . $date ;
}
mysqli_close($conn);
?>