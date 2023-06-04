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
$flightnumber=$_POST["flightnumber"];
$time=$_POST["time"];
$bookings=0;
echo '<p style="color: red; font-size: 18px;">Bookings for Flight Number - ' . $flightnumber . ' and Time - ' . $time . ' are</p>';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql="SELECT username,passengers FROM ticketbookingtable WHERE timess='$time' AND flightnumber='$flightnumber'";
    $result = mysqli_query($conn, $sql);
   if (mysqli_num_rows($result) > 0) {
     // Output the data
     while ($row = mysqli_fetch_assoc($result)) {
     echo '<p style="color: blue;">Username : ' . $row["username"] . '<br>Passengers : ' . $row["passengers"] . '</p>';
     $bookings++;
     echo '<hr>';
     }
     echo '<p style="font-weight: bold;">Total Bookings made are : ' . $bookings . '</p>';
   }
   else{
    echo '<p style="color: gray;">No bookings made so far or Flight number doesn\'t exist</p>';
   }
}
mysqli_close($conn);
?>