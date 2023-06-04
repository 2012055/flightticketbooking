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

$username = $_POST["user"];
$password = $_POST["pass"];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
if($username=="admin" && $password=="Admin-12"){
    header("Location: flightadmin.html"); // user exist in database
    exit();
}
else{
$sql = "SELECT * FROM usertable WHERE username = '$username' AND passwords = '$password'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result)>0) {
    header("Location: flightuser.html"); // user exist in database
    exit();
} else {
    // User does not exist in the database
    echo "Invalid username or password.";
}
}
    // Close the database connection
    mysqli_close($conn);
}
?>