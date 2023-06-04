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
echo '<p style="font-weight: bold;">Available flights are</p>';
$sql="SELECT * FROM admintable";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
 // Output the data
 while ($row = mysqli_fetch_assoc($result)) {
  echo '<div class="flight-details">';
  echo '<p><span class="label">Departure:</span> ' . $row["departure"] . '</p>';
  echo '<p><span class="label">Destination:</span> ' . $row["destination"] . '</p>';
  echo '<p><span class="label">Date:</span> ' . $row["dates"] . '</p>';
  echo '<p><span class="label">Time:</span> ' . $row["timess"] . '</p>';
  echo '<p><span class="label">Flight Number:</span> ' . $row["flightnumber"] . '</p>';
  echo '</div>';
  echo '<hr>';
 }
}
else {
  echo '<p style="color: gray;">No available flights</p>';
}
mysqli_close($conn); 

?>