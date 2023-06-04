<?php
// Database connection settings
$host = "localhost"; // Host name
$user = "root"; // Mysql username
$password = ""; // Mysql password
$dbname = "flightticketbooking"; // Database name
// Create connection
$conn = mysqli_connect($host, $user, $password, $dbname);
$flag=0;
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
$username = $_POST["user"];
$password = $_POST["pass"];
$rpassword = $_POST["rpass"];
$email = $_POST["email"];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //check username
    if (empty($_POST["user"])) {
          echo "Please enter your name.";
          $flag=1;
      } else {
          if (!preg_match("/^[a-zA-Z\d ]*$/",$username)) {
              echo "Only letters,white space,digits allowed.";
              $flag=1;
          }
      }
    //check password
      if (empty($_POST["pass"])) {
        echo "Please enter your password.";
        $flag=1;
    } else {
        if (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,}$/",$password)){
            echo "Password should contain atleast one lowercase,uppercase alphabets,digit and length equal to 8";
            $flag=1;
        }
    }
    //check both password equal
    if($password!=$rpassword){
        $flag=1;
        echo "Password and Repeat password should be equal";
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
    //check username is unique
    $sql1 = "SELECT username FROM usertable WHERE username='$username'";
    $result1 = mysqli_query($conn, $sql1);
    if (mysqli_num_rows($result1)>0) {
        $flag=1; // username exist in database
        echo"<script>alert('Username already exist, Choose another username')</script>";
    } 

    if($flag==0){
      $sql = "INSERT INTO usertable VALUES ('$username', '$password','$email')";
    
      if (mysqli_query($conn, $sql)) {
        echo "Login Created!";
      } else {
        echo "Error: " . $mysqli_error($conn);
      }
    }
    // Close the database connection
    mysqli_close($conn);
   
    }
?>