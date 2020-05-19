<?php include 'header.html'; ?>
<?php include 'general_page.html'?>

<link rel="stylesheet" type="text/css" href="style.css">


<div class="login-container">
	<div class="d-flex justify-content-center h-100">
		<div class="login-card card">
			<div class="login-header card-header">
				<h3>Authentication</h3>
			</div>
			<div class="card-body">
				<div  name="loginform">
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input type="text" class="form-control" name="username" id="username" placeholder="username">	
					</div>
					<div class="input-group form-group">
						<p class="error" id="username"></p>
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input type="password" class="form-control" name="password" id="password" placeholder="password">
						
					</div>
					<div class="input-group form-group">
						<p class="error" id="password"></p>
					</div>
					<div class="row align-items-center remember">
						<input type="checkbox" name="rem">Remember Me
					</div>
					<div class="form-group">
						<input type="submit" onclick="validatelogin()" value="Login" class="btn float-right login_btn">
					</div>
					<div class="form-group">
						<div class="d-flex justify-content-center">
							<a href="#" onclick="forgot()">Forgot your password?</a>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>
<script type="text/javascript">
	function checkempty(id,str){
		if (id == "") {
	    document.getElementById(str).innerHTML="* "+str+" must be filled out";
	    document.getElementById(str).style.color="red";
	    return false;
	  }
	  else{
	  	document.getElementById(str).innerHTML="";
	    return true;
	  }
	}

	function validatelogin() {
		
	  var username = $("#username").val();
	  var password = $("#password").val();
	  console.log("validate: "+username+" , "+password);
	  if(checkempty(username,"username") && checkempty(password,"password")){
	  	sql = "SELECT id FROM stock_user where username = '"+username+"'and password = '"+password+"'";
	  	form_log = ["date","from_login","staff_id","status"];
	  	fetchdb(sql,function(data){
	  		if(data.length>0){
	  			form_log_val = ["curentdate","curentime",data[0]['id'],1];
	  			query = "insert into log(";
	  			for(var i in form_log){
	  				if(i) query+=form_log[i];
	  				else query+=","+form_log[i];
	  			}
	  			query+=") values(";
	  			for(var i in form_log){
	  				if(i) query+=form_log[i];
	  				else query+=","+form_log[i];
	  			}
        		console.log(data.length);
        		value_log=["cu",,data[0]['id'],1];
        		sql = "UPDATE stock_user set status = 1 where id='"+data[0]['id']+"'";
        		setCookie("staff_id",data[0]['id'],1);
        		$.ajax({type: "GET",url: "delete.php",data: {"sql":sql}});
				window.location.href = "com_sidebar.php";
			}
        	else{
            	Swal.fire({
				  title: "The username or password you entered isn't correct",
				  text: "Please check details entered and try again!",
				  icon: 'warning',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: 'try again!'
				});
            }
	  	});
	  
	}
	  
	}	
</script>
<script type="text/javascript">
	function forgot(){

		swal( {
			title: 'Forgot your password?',
			text: 'Enter the email address associated with your account',
			content: {
			    element: "input",
			    attributes: {
			      placeholder: "Type your password",
			      type: "email",
			    },
			},
		  	icon: 'info',
		 	buttons: true,
		})
		.then((value) => {
			if (!value) throw null;
			else
		  		swal("Check your email",`We will email you a link to reset your password: ${value}`,"success");
		})
		
	}
</script>
</body>
</html>
