
<style type="text/css">
	#pro_form{
	padding: 30px;
	}
	.profile-img{
		background-color: teal;
		padding:10px 0;
	}
	.profile-img>img{
		border-radius: 20%;
		width: 128px;
		height: 128px;
	} 

	.prod-img{
		width: 64px;
		height: 50px;
		/*background-image: url('img/CommonProduct.jpg');*/
		background-size: cover;
		border-radius: 30%;
		background-repeat: no-repeat;
	}
</style>
		<div class="container content content">
			<h2 class="ui blue ribbon big label" >Product Updates</h2>
			<div class="ui top attached green menu" id="start" >
			    <button class="item btn active" onclick="dashboard(0)">Consumables</button>
			    <button class="item btn" onclick="dashboard(1)">Non-Consumables</button>
			    <button class="item btn" onclick="dashboard(2)">Service</button>
			</div>
		
			<div class="ui bottom attached segment">
			 	<p>
					<!-- Button to Open the Modal -->
					<div class="d-flex flex-row" style="margin-left: 8px;">
					  <div class="p-2">
					  	<input type="button" class="btn btn-primary" align="right" onclick="clearfield()" data-toggle="modal" data-target="#newitem" value="New Item">
					  </div>
					  
					</div>
					
					<div>
						<?php include "search_co.php"?>
					</div>
			 	</p>
			</div>
		</div>
		<!-- The Modal -->
		<?php include "form_page.html"?>
<script type="text/javascript">
	
	form_product = ["img","name","specification","q_unit","quantity","company","prod_key"];
	form_purchase = ["id","logid","company_bill","purchased","purchase_cost"];
	
	// validate,insert,clear
  	function myFunction(){	
		  	name = $("#name").val();
			url = "create_table.php";
			data={};
			var x = $("form").serializeArray();
			for(let num in x)
				data[x[num]['name']]=x[num]['value'];
			console.log(x);
			err=0;
			ids = ["name","spec","qty","cost"];
			values = ["product name","specification","Quantity","Price amount"];
			for (var i = 0; i <ids.length; i++) {
				var inpObj = document.getElementById(ids[i]);
				if (!inpObj.checkValidity()) {
				    document.getElementById("errmsg").innerHTML = "Please fill out "+values[i]+" field.";
				    err++;
				    break;
				  } 
			}
			if(err==0){
				$.ajax({
	              type: "POST",
	              url: url,
	              data: data,
	              success: function(data){
	                  	clearfield();
						Swal.fire({
							  position: 'top-end',
							  icon: 'success',
							  title: '"'+name+'" has been saved',
							  showConfirmButton: false,
							  timer: 1500
							});
						dashboard(type);
					}
	          });
			}
	}
	
	dashboard(0);
	function dashboard(key){
		type=key;
		mktb();
		var btnContainer = document.getElementById("start");
		var btns = btnContainer.getElementsByClassName("btn");
	    var current = document.getElementsByClassName("active");
	    if (current.length > 0) {
	      current[1].className = current[1].className.replace(" active", "");
	    }
	    btns[type].className += " active";
	    var x = document.getElementById("cmp");
	    switch(type){
	    	case 0: {
	    		document.getElementById("head").innerHTML = "Consumable Product Updates";
	    		x.style.display = "none";
	    		$("#price").show();
	    		break;
			}
	    	case 1:{
	    		document.getElementById("head").innerHTML = "Non-Consumable Product Updates";
	    		x.style.display = "block";
	    		$("#price").show();
	    		break;
	    	}
	    }
	}

	function mktb(position=-1){
		if(checkSize(position)){
			sql = 'SELECT img,id,concat_ws(" ",name,"(",specification,")") as name,concat_ws(" ",quantity,"(",q_unit,")") as qty FROM product where prod_key = '+type+'  LIMIT '+offset+' OFFSET '+size+' ';
			console.log("sql = "+sql);
			head = ["sno.","Image","id","Product&nbsp;name","Qty.","Activity"];
			table(sql,head);
		}	
	}
	// select and delete
	function select(id,fill=0){
		var sql = "SELECT * FROM product where id ="+id+" ";
		fetchdb(sql,function(data){
			$("#id").val(data[0]["id"]+"");
          	$("#name").val(data[0]["name"]+"");
          	$("#spec").html(data[0]["specification"]+"");
          	$("#q_unit").html(data[0]["q_unit"]+"");
          	$("#prod-img").attr("src",data[0]["img"]);
		});
	}
	function del(id){
		del_com(id,"product");
	}
</script>

