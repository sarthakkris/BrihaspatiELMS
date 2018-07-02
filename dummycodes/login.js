$(document).ready(function(){
$("#login").click(function(){
	var email = $("#email").val();
	var password = $("#password").val();
// Checking for blank fields.
	if( email =='' || password ==''){
	$('input[type="text"],input[type="password"]').css("border","2px solid red");
	$('input[type="text"],input[type="password"]').css("box-shadow","0 0 3px red");
	alert("Please fill all fields...!!!!!!");
	}
	else {
      //$('#login').on('change',function(){
				//var email = $('#email').val();
				//var password = $('#password').val();
				var credentials = email+"&&"+password;

		  $.ajax({
			type:'POST',
			url :"<?php echo base_url();?>sisindex.php/decode ",
			data:{'credentials' : credentials},
			dataType:"html",
				success: function(data) {
					if(data='successfull login'){
					 alert('successfll login')
					}

			else(data='invalid credentials'){
				alert('invalid email or password!')
			}
