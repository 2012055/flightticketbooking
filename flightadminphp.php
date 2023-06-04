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
$departure=$_POST["departure"];
$destination=$_POST["destination"];
$date=$_POST["date"];
$time=$_POST["time"];
$flightnumber=$_POST["flightnumber"];
$seatcount=$_POST["seatcount"];
//$addflight=$_POST["addflight"];
//$removeflight=$_POST["removeflight"];

$flag=0;$uniq=0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($departure)||empty($destination)||empty($date)||empty($date)||empty($time)||empty($flightnumber)){
      $flag=1;
      $script = "<script>alert('Please fill out all the fields');</script>";
      echo $script;
    }
    if($departure==$destination){
        $flag=1;
        $script = "<script>alert('Departure and destination can't be equal');</script>";
        echo $script;
    }
  
    if($flag==0 && isset($_POST["addflight"])){
      //Check flight number exist in db 
      $sql1 = "SELECT flightnumber FROM admintable WHERE flightnumber=$flightnumber";
      $result1 = mysqli_query($conn, $sql1);
      if (mysqli_num_rows($result1)>0) {
          $uniq=1;
          echo '<p style="color:red;font-size:large;">Flight number already exist, Flight number should be unique</p>';
      } 
      if($uniq==0){
        $sql = "INSERT INTO admintable VALUES ('$departure', '$destination','$date','$time','$flightnumber','$seatcount')";
        if (mysqli_query($conn, $sql)) {
            $script = "<script>alert('Flight is added successfully');</script>";
            echo $script;
        } else {
          echo "Error: " . $mysqli_error($conn);
        }
      }
    }

    //for remove flight in db
    if($flag==0 && isset($_POST["removeflight"])){
        $sql = "DELETE FROM admintable WHERE dates=? AND timess=? AND flightnumber=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $date, $time, $flightnumber);
        $stmt->execute();

         // Check if the deletion was successful
          if ($stmt->affected_rows > 0) {
            $script = "<script>alert('Flight deleted Successfully');</script>";
            echo $script;
         } else {
          $script = "<script>alert('Flight not found or could not be deleted');</script>";
          echo $script;
         }  
    }
    if(isset($_POST["logout"])){
      header("Location:flightloginpage.html");
      exit();
    }
      mysqli_close($conn);
     
}

?>