<!--
//include('login.php'); // Includes Login Script
//if(isset($_SESSION['login_user'])){
//header("location: user_log.php");
//}
?>-->

<!DOCTYPE html>
<html>
<head>
<title>Brihaspati Leave Application</title>
  <!--<meta name="robots" content="noindex, nofollow"> -->
<!-- Include CSS File Here -->
<!--link rel="stylesheet" href="style.css"/-->
<!--Include CSS File Here --> 
<link rel = "stylesheet" type = "text/css" 
   href = "<?php echo base_url(); ?>assets/css/mobile/style.css">

<!--<script type='text/javascript' src="<?php echo base_url();?>assets/js/mobile/login.js"></script>-->

<script type='text/javascript' src="<?php echo base_url();?>assets/js/jquery-1.12.4.js"></script>

<script>
$(document).ready(function(){
	
$("#login").click(function(){
	
	
	var username = $("#username").val();
	var password = $("#password").val();
// Checking for blank fields.

	if( username =='' || password ==''){
	$('input[type="text"],input[type="password"]').css("border","2px solid red");
	$('input[type="text"],input[type="password"]').css("box-shadow","0 0 3px red");
	alert("Please fill all fields!");


	}
	else {
      
			var credentials = username +","+password;
			alert(credentials);
		  jQuery.ajax({
			type:"POST",
			url :"<?php echo site_url();?>user_log/user_login_process",
			data:{"credentials" : credentials},
			dataType:"html",
				success: function(data) {
					/*alert("kuch bhi");
					if(data='successfull login'){*/
					 alert("successful login");
					},
					error:function(data){
						alert("Invalid Username or Password");
					}
			//else/*(data='invalid credentials')*/{
			//	alert('invalid email or password!');
			//}
				});
		  }


	 } );
});
</script>


<!--<script type="text/javascript" src="login.js"></script>-->


</head>
<body>
<div class="container">
<div class="main">
	<?php echo base_url(); ?>
<form class="form" method="post" action=" ">
	
<h2>Login for Leave Application</h2>
Email : <input type="text" name="username" id="username">
Password : <input type="password" name="password" id="password">
<input type="submit" name="login" class="button" id="login" value="login">

</form>
</div>
</div>
</body>
</html>