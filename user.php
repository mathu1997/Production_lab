

<?php include 'connection.php'?>
	
	<div class="container content">
		<h2 class="ui blue ribbon big label">Update User</h2>
		<form action="staff_detail.php" class="border border-primary rounded ui equal width form"  id="pro_form" method="post" style="padding: 30px;">
			<div class="row">
				<div class="col-lg-9">
					<div class="ui form">
					  <div class="fields">
					    <div class="field">
					      <label>Staff ID</label>
					      <input type="text" placeholder="Staff ID" name="id" id="id" required="required">				    
					  	</div>
					    <div class="field">
					      <label>Staff Name</label>
					      <input type="text" placeholder="Staff Name" name="name" id="name" required="required">
					    </div>
					    <div class="field">
					      <label>Email</label>
					      <input type="text" placeholder="Email" name="email" id="email" required="required">
					    </div>
					  </div>
					</div>
					<div class="ui form">
					  <div class="fields">
					    <div class="field">
					      <label>User Name</label>
					      <input type="text" placeholder="User Name" name="uname" id="uname" required="required">
					    </div>
					    <div class="field">
					      <label>Password</label>
					      <input type="text" placeholder="Password" name="pass" id="pass" required="required">
					    </div>
					  </div>
					</div>
  				</div>
  				<div class="col-lg-3" style="border-left: 1px solid black;">
  					<div class="fields">
		  				<div class="ui radio" style="margin-right: 100px;">
						  <input type="radio" onclick="category()" name="cat[]" id="admin" >
						  <label>Admin</label>
						</div>
		  				<div class="ui radio">
						  <input type="radio" onclick="category()" name="cat[]" id="staff">
						  <label>Staff</label>
						</div>
		  			</div>
					<h3>Privilages:</h3>
					<div class="ui form">
					    <div class="field">
				  			<div class="fields">
				  				<div class="ui checkbox">
								  <input type="checkbox" name="priv[]" id="update_prod" value="up">
								  <label>Update_Products</label>
								</div>
				  			</div>
				  			<div class="fields">
				  				<div class="ui checkbox">
				  					<input type="checkbox" name="priv[]" id="consume_prod" value="cp">
				  					<label>Consume_Product</label>
				  				</div>
				  			</div>
				  			<div class="fields">
				  				<div class="ui checkbox">
				  					<input type="checkbox" name="priv[]" id="update_staff" value="us">
				  					<label>Update_staff</label>
				  				</div>
				  			</div>
				  			<div class="fields">
				  				<div class="ui checkbox">
				  					<input type="checkbox" name="priv[]" id="stock_report" value="sr">
				  					<label>Stock_Report</label>
				  				</div>
				  			</div>
					  </div>
					</div>
				</div>
			</div>
			<center>
				<input type="submit" class="btn btn-primary" name="submit" value="submit"/>
				<input type="reset" class="btn btn-danger" name="submit" value="Reset"/>
			</center>
		</form>
		<h2 class="ui blue ribbon big label">Staff Details</h2>
		<div class="border border-info rounded" style="padding: 30px;">
			<?php include "search_co.php"?>
		</div>
	</div>
<script type="text/javascript">

		
	// table & type\
	mktb();
	function mktb(position=-1){
		if(checkSize(position)){
			sql = 'SELECT sno as id,name,email FROM stock_user LIMIT '+offset+' OFFSET '+size+' ';
			console.log(sql);
			head = ["#","id","Name","Email&nbsp;ID","Activity"];
			table(sql,head);
		}	
	}

	// select and delete
	function select(id,fill=0){
		var sql = "SELECT * FROM user where sno ="+id+"";
		obj = {"sql":sql};
		$.ajax({
              type: "GET",
              url: "pie_chart.php",
              data: obj,
              success: function(data){
              	// data = JSON.parse(data);
              	$("#id").val(data[0]["id"]+"");
              	$("#name").val(data[0]["name"]+"");
              	$("#email").val(data[0]["email"]+"");
              }
          });
	}

	function category(){
		var check="";

		var admin=["update_prod","update_staff","stock_report"];
		var staff=["update_prod","consume_prod"]
	    if ($("#admin").is(":checked")) {
	    	for (var i = 0; i < staff.length; i++) {
	    		document.getElementById(staff[i]).removeAttribute("checked");
	    	}
	    	for (var i = 0; i < admin.length; i++) {
	    		document.getElementById(admin[i]).setAttribute("checked", "checked");
	    	}

	    } 
	    if ($("#staff").is(":checked")) {
	    	
	    	for (var i = 0; i < admin.length; i++) {
	    		document.getElementById(admin[i]).removeAttribute("checked");
	    	}
	    	for (var i = 0; i < staff.length; i++) {
	    		document.getElementById(staff[i]).setAttribute("checked", "checked");
	    	}

	    }
	}

	function del(id){
		del_com(id,"stock_user");
	}
	</script>
	