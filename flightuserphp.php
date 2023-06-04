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
$username=$_POST["username"];
$name=$_POST["name"];
$phone=$_POST["phone"];
$email=$_POST["email"];
$address=$_POST["address"];
$city=$_POST["city"];
$pincode=$_POST["pincode"];
$country=$_POST["country"];
$flighttype=$_POST["flighttype"];
$departure=$_POST["departure"];
$destination=$_POST["destination"];
$date=$_POST["date"];
$time=$_POST["time"];
$passengers=$_POST["passengers"];
$class=$_POST["class"];
$flag=0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //check name
      if (empty($name)) {
            echo "Please enter your name.";
            $flag=1;
        } else {
            if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
                echo "Only letters and white space allowed.";
                $flag=1;
            }
        }
      //check email
    if (empty($_POST["email"])) {
        echo "Please enter your Email.";
        $flag=1;
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo "Enter valid email";
            $flag=1;
        }
    }
    //check phonenumber
    if(empty($phone)){
        $flag=1;
        echo "Enter phone number";
    }else{
        if(strlen($phone)!=10){
            $flag=1;
            echo "Enter valid phone number must contain 10 digits";
        }
    }
    //check for empty cases
    if(empty($address)||empty($city)||empty($pincode)||empty($country)||empty($flighttype)||empty($departure)||empty($destination)||empty($date)||empty($time)||empty($passengers)||empty($class)){
      $flag=1;
      echo "Fill all required data";
    }
    //check availability of flights on user specific date and time
         $sql="SELECT * FROM admintable WHERE dates='$date' AND timess='$time'";
         $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) < 0) {
          // Output the data
          echo "No available flights on " . $date ."<br>"."Please get to know about available flights by clicking available flights";
          $flag=1;
        }
      //check for domestic flights
      if($flighttype=="domestic"){
        if(($departure=="Chennai"||$departure=="Mumbai"||$departure=="Delhi"||$departure=="Bangalore"||$departure=="Hyderabad"||$departure=="Trivandrum")
          &&($destination=="Sydney"||$destination=="Melborne"||$destination=="Brisbane"||$destination=="Adelaide"||$destination=="Los Angeles"||$destination=="San Francisco"||$destination=="Miami")){
          $flag=1;
          echo "Choose the departure correctly, Domestic flights land in same country you travel"."<br>";
        }
        else if(($departure=="Sydney"||$departure=="Melborne"||$departure=="Brisbane"||$departure=="Adelaide")&&
        ($destination=="Los Angeles"||$destination=="San Francisco"||$destination=="Miami"||$destination=="Chennai"||$destination=="Mumbai"||$destination=="Delhi"||$destination=="Bangalore"||$destination=="Hyderabad"||$destination=="Trivandrum")){
          $flag=1;
          echo "Choose the departure correctly, Domestic flights land in same country you travel"."<br>";
        }
        else if(($departure=="Los Angeles"||$departure=="San Francisco"||$departure=="Miami")&&
        ($destination=="Chennai"||$destination=="Mumbai"||$destination=="Delhi"||$destination=="Bangalore"||$destination=="Hyderabad"||$destination=="Trivandrum"||
        $destination=="Sydney"||$destination=="Melborne"||$destination=="Brisbane"||$destination=="Adelaide")){
          $flag=1;
          echo "Choose the departure correctly, Domestic flights land in same country you travel"."<br>";
        }
      }
      //check for international flights
      else if($flighttype=="international"){
        if(($departure=="Chennai"||$departure=="Mumbai"||$departure=="Delhi"||$departure=="Bangalore"||$departure=="Hyderabad"||$departure=="Trivandrum")
        &&($destination=="Chennai"||$destination=="Mumbai"||$destination=="Delhi"||$destination=="Bangalore"||$destination=="Hyderabad"||$destination=="Trivandrum")){
        $flag=1;
        echo "Choose the departure correctly, International flights dont't land in same country you travel"."<br>";
       }
       else if(($departure=="Sydney"||$departure=="Melborne"||$departure=="Brisbane"||$departure=="Adelaide")&&
        ($destination=="Sydney"||$destination=="Melborne"||$destination=="Brisbane"||$destination=="Adelaide")){
          $flag=1;
          echo "Choose the departure correctly, International flights dont't land in same country you travel"."<br>";
        }
        else if(($departure=="Los Angeles"||$departure=="San Francisco"||$departure=="Miami")&&
        ($destination=="Los Angeles"||$destination=="San Francisco"||$destination=="Miami")){
          $flag=1;
          echo "Choose the departure correctly, International flights dont't land in same country you travel"."<br>";
        }
      }
      //check if departure and destination are equal
        if($departure==$destination){
          $flag=1;
          echo "Departure and destination can't be same";
        }
      
      
   //check seat availability
$sql = "SELECT seatcount FROM admintable WHERE departure='$departure' AND destination='$destination'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $seatCount = $row["seatcount"];
    mysqli_free_result($result);

    // Check if there are enough seats available
    if ($seatCount >= $passengers) {
        // Decrement the seat count based on the number of passengers booked
        $updatedSeatCount = $seatCount - $passengers;

        // Update the seat count in the database
        $updateSql = "UPDATE admintable SET seatcount = $updatedSeatCount WHERE departure='$departure' AND destination='$destination'";
        $updateResult = mysqli_query($conn, $updateSql);
    } else {
        echo "Insufficient seats available.";
        $flag=1;
    }
} 
//get flightnumber
$sql1 = "SELECT flightnumber FROM admintable WHERE departure='$departure' AND destination='$destination' AND dates='$date' AND timess='$time'";
$result1 = mysqli_query($conn, $sql1);
if ($result1 && mysqli_num_rows($result1) > 0) {
  $row = mysqli_fetch_assoc($result1);
  $flightnumber = $row["flightnumber"];
  mysqli_free_result($result1);

}
else{
  $flag=1;
  echo '<p style="background-color:dodgerblue;font-size:large;">Flights not avilable, Please check available list</p>';
}

//check if already the user book for same destination on same date and time
$sql2 = "SELECT departure,destination FROM ticketbookingtable WHERE dates='$date' AND timess='$time'";
    $result2 = mysqli_query($conn, $sql2);
    if (mysqli_num_rows($result2)>0) {
      $row=mysqli_fetch_assoc($result2);
        $departures=$row["departure"];
        $destinations=$row["destination"];
        if($departure==$departures && $destination==$destinations){
          $flag=1;
          echo '<p style="background-color:dodgerblue;font-size:large;">Flights have already booked by you on same date and time, for same destination</p>';
        }
} 
    if($flag==0){
        $sql = "INSERT INTO ticketbookingtable VALUES ('$username', '$name','$phone','$email',
        '$address','$city','$pincode','$country','$flighttype','$departure','$destination','$date','$time','$passengers','$class','$flightnumber')";
    
      if (mysqli_query($conn, $sql)) {
          echo "Thank you for Booking Your Tickets!";
      } 
    }
  }
?>