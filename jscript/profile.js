    function move(url,data){
    $.ajax({
              type: "POST",
              url: url,
              data: data,
              success: function(data){
                  document.getElementById("recent").innerHTML=data;
              }
          });
  }
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
				var xmlhttp = new XMLHttpRequest();
		      	var id = "<?php echo $_SESSION['id'];?>";
	          	var sql = "SELECT * FROM user where id='"+id+"' ";
		        obj = {"sql":sql };
		        dbParam = JSON.stringify(obj);
			    xmlhttp.onreadystatechange = function() {
			        if (this.readyState == 4 && this.status == 200) {
				        myObj = JSON.parse(this.responseText);
				        console.log(this.responseText);
				        for(i=0;i<ids.length-2;i++)
				        	$("#"+ids[i]).val(myObj[0][ids[i]]);
				        if(myObj[0][ids[i]]==1) $("#"+ids[i]).val("Admin");
				        else $("#"+ids[i]).val("Lab Assistent");
				        flag=1;
				        for(i=0;i<acc.length;i++)
				        	if(myObj[0][acc[i]]==0){
				        		flag=0;break;
				        	}
				        flag = false;
						ch = false;
					    rdis();
						display();
					}
					if(flag==1) $("#acc").val("Full Access");
					else $("#acc").val("Partial Access");
			      }
			    xmlhttp.open("GET", "pie_chart.php?x=" + dbParam, true);
			    xmlhttp.send();
			    
			}
			fill();