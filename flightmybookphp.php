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

$username=$_POST["user"];
$sql="SELECT * FROM ticketbookingtable WHERE username='$username'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  // Output the data
  while ($row = mysqli_fetch_assoc($result)) {
      echo '<div class="flight-details">';
      echo '<p><span class="label">Departure:</span> ' . $row["departure"] . '</p>';
      echo '<p><span class="label">Destination:</span> ' . $row["destination"] . '</p>';
      echo '<p><span class="label">Date:</span> ' . $row["dates"] . '</p>';
      echo '<p><span class="label">Time:</span> ' . $row["timess"] . '</p>';
      echo '<p><span class="label">Class:</span> ' . $row["class"] . '</p>';
      echo '</div>';
      echo '<hr>';
  }
} else {
  echo '<p class="no-bookings-msg">No Bookings have been made yet</p>';
}

mysqli_close($conn);
?>