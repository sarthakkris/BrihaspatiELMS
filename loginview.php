
<?php
include('login.php'); // Includes Login Script

if(isset($_SESSION['login_user'])){
header("location: user_log.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Brihaspati Leave Application</title>
  <!--<meta name="robots" content="noindex, nofollow"> -->
<!-- Include CSS File Here -->
<link rel="stylesheet" href="style.css"/>
<!--Include CSS File Here --> 
<link rel = "stylesheet" type = "text/css" 
   href = "<?php echo base_url(); ?>css/style.css">

<script type = 'text/javascript' src = "<?php echo base_url(); 
   ?>js/login.js"></script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript" src="login.js"></script>


</head>
<body>
<div class="container">
<div class="main">
<form class="form" method="post" action="login_user.php">
<h2>Login for Leave Application</h2>
Email : <input type="text" name="email" id="email">
Password : <input type="password" name="password" id="password">
<input type="submit" name="login" id="login" value="Login">
<span><?php echo $error; ?></span>
</form>
</div>
</div>
</body>
</html>
