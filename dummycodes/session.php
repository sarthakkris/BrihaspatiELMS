<?php
// Establishing Connection with Server by passing server_name, user_id and password as a parameter
$connection="";
$db="";
$user_check="";
$connection = mysqli_connect("127.0.0.1", "root", "");
//print_r($connection) ; die;
// Selecting Database
 $db = mysqli_select_db($connection,"hrishique" ); // Selecting Database.
session_start();// Starting Session
// Storing Session
$user_check=$_SESSION['login_user'];
// SQL Query To Fetch Complete Information Of User
$ses_sql= "SELECT email FROM entries where email='$user_check'";

$res=mysqli_query($connection,$ses_sql);
$row = mysqli_fetch_assoc($res);
$login_session =$row['email'];
//print_r($login_session) ; die;
if(!isset($login_session)){
mysqli_close($connection); // Closing Connection
header('Location: loginview.php'); // Redirecting To Home Page
}
?>