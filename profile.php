<?php include 'connection.php'; ?>
<style type="text/css">
	.profile-img{
		background-color: teal;
		padding:10px 0;
	}
	.profile-img>img{
		border-radius: 50%;
		width: 128px;
		height: 128px;
	} 
</style>
		<div class="container content">
			<h2 class="ui blue ribbon big label" >Product Updates</h2>
			<center class="profile-img" >
				<img src="img/logo.jpg" >
			</center>
			<div action="#" class="border border-primary rounded ui equal width form"  id="pro_form" method="post" style="padding: 30px;">
				<div class="ui form">
				  <div class="fields">
				    <div class="field">
				      <label>Staff ID</label>
				      <input type="text" placeholder="Staff ID" disabled style="font-size: 18px;" name="id" id="id" required="required">				    
				  	</div>
				    <div class="field">
				      <label>Staff Name</label>
				      <input type="text" placeholder="Staff Name" disabled style="font-size: 18px;" name="name" id="name" required="required">
				    </div>
				    <div class="field">
				      <label>Email</label>
				      <input type="text" placeholder="Email" disabled style="font-size: 18px;" name="email" id="email" required="required">
				    </div>
				  </div>
				</div>
				<div class="ui form">
				  <div class="fields">
				    <div class="field">
				      <label>Status</label>
				      <input type="text" disabled style="font-size: 18px;" name="status" id="status" required="required">
				    </div>
				    <div class="field">
				      <label>Accessablity</label>
				      <input type="text" disabled style="font-size: 18px;" name="acc" id="acc" required="required">
				    </div>
				  </div>
				</div>
				<div class="ui form" id="change">
				  <div class="fields">
				    <div class="field">
				      <label>New Password</label>
				      <input type="text" name="pass" id="pass">
				    </div>
				    <div class="field">
				      <label>Confirm Password</label>
				      <input type="text" name="cpass" id="cpass">
				    </div>
				  </div>
				</div>
				<center id="btns">
					<input type="button" class="btn btn-primary" onclick="rdis()" id="edit" name="edit" value="Edit" />
					
					<input type="button" class="btn btn-success" onclick="display()" id="cbtn"value="Change Password">
				</center>
			</div>
		</div>
		<script type="text/javascript">
			    
			var ids = ["id","name","email","status","acc"];
			var flag = false;
			var ch = false;
			
			function showbtn(){
				$("#edit").remove();
				$("#btns").prepend('<input type="submit" class="btn btn-primary" onclick="update()" id="edit" value="Save"/> <input type="button" class="btn btn-danger" onclick="hidebtn()" id="cancel" value="Cancel"/>');
			}
			function hidebtn(){
				$("#edit").remove();
				$("#cancel").remove();
				$("#btns").prepend('<input type="button" class="btn btn-primary" onclick="rdis()" id="edit" name="edit" value="Edit" />');
				flag = false;
				ch = false;
			    rdis();
				display();
			}
			function rdis(){
				
				if(flag){
					showbtn();
					for(i=0;i<ids.length-2;i++)
						$("#"+ids[i]).removeAttr("disabled");
					$("#cbtn").hide();
					}
				else{
					for(i=0;i<ids.length;i++)
						$("#"+ids[i]).attr("disabled","");
				}
				flag=!flag;
			}
			function display(){
				item = $("#change");
				if(ch){
					$("#cbtn").remove();
					item.show();
					$("#pass").attr("required","");
					$("#cpass").attr("required","");
					showbtn();
				}
				else{
					$("#cbtn").show();
					item.hide();
					$("#pass").removeAttr("required");
					$("#cpass").removeAttr("required");
				}
				ch=!ch;
			}
			function update(){
				var pass = $("#pass").val();
				
					$.ajax({
			            type: "POST",
			            url: "staff_detail.php",
			            data: {"id":$("#id").val(),"name":$("#name").val(),"email":$("#email").val(),"pass":pass},
			            success: function(data){
			            	Swal.fire({
							  position: 'top-end',
							  icon: 'success',
							  title: 'Your profile has been saved',
							  showConfirmButton: false,
							  timer: 1500
							});
			                fill();
			            }
			        });
			}
			function fill(){
				
				var acc = ["up","cp","us","sr"];
		      	var id = getCookie("staff_id");
	          	var sql = "SELECT * FROM stock_user where id='"+id+"' ";
		        obj = {"sql":sql };
		        $.ajax({
		              type: "GET",
		              url: "pie_chart.php",
		              data: obj,
		              success: function(data){
		              	myObj = data;
		              	for(i=0;i<ids.length-2;i++)
				        	$("#"+ids[i]).val(myObj[0][ids[i]]);
				        if(myObj[0][ids[i]]==1) $("#"+ids[i]).val("Admin");
				        else $("#"+ids[i]).val("Lab Assistent");
				        f=1;
				        for(i=0;i<acc.length;i++)
				        	if(myObj[0][acc[i]]==0){
				        		f=0;break;
				        	}
				        if(f==1) $("#acc").val("Full Access");
						else $("#acc").val("Partial Access");
				        flag = false;
						ch = false;
					    rdis();
						display();
		              	}
          		});
			    
			}
			fill();
		</script>