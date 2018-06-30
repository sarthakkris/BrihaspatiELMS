<?php
session_start(); // Starting Session
$error=''; // Variable To Store Error Message
$email="";
$password="";


$connection = mysqli_connect("127.0.0.1", "root", ""); // Establishing connection with server..
// print_r($connection);   die;
$db = mysqli_select_db( $connection,"hrishique"); // Selecting Database.

//print_r($db); die;

//$email = $_POST["email"];



if(isset($_POST['email']) && isset($_POST['password'])){
$email=$_POST['email']; // Fetching Values from URL.

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $emailErr = "Invalid email format"; 
}

$password= $_POST['password']; 
// Password Encryption , If you like you can also leave sha1.
// To protect MySQL injection for Security purpose
/*$email = stripslashes($email);
$password = stripslashes($password);
$email = mysqli_real_escape_string($email);
$password = mysqli_real_escape_string($password);*/

$result = mysqli_query($connection,"SELECT * FROM entries WHERE email='$email' AND password='$password'");
//print_r($result);  die;
$data = mysqli_num_rows($result);
//print_r($data);  die;
 
if($data >0 ){
	$_SESSION['login_user']=$email; // Initializing Session
   header("location: leavemgmt.php"); // Redirecting to next page
   

}
else{
echo "Email or Password is wrong...!!!!";
	header("location: loginview.php");
}

	
		//print_r(mysqli_connect_error());
	
}
mysqli_close ($connection); // Connection Closed.
?>