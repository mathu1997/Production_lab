<?php
 include 'connection.php';?>

	
	<div class="container content">
		<h2 class="ui blue ribbon big label">Consume Items</h2>
		<div class="ui bottom attached segmen">
			<p><?php include "search_co.php"?></p>
		</div>
	</div>
	<script type="text/javascript">
	
	// table & type
	mktb();
	function mktb(position=-1){
		if(checkSize(position)){
			sql = 'SELECT p.id,concat_ws(" ",name,"(",c.category,")") as name,concat_ws(" ",quantity,"(",c.q_unit,")") as qty FROM product as p inner join  category_list as c on p.categoryid=c.cid where prod_key = '+type+'  LIMIT '+offset+' OFFSET '+size+' ';
			console.log("sql = "+sql);
			head = ["#","id","Product&nbsp;name","Qty.","Activity"];
			table(sql,head,0);
		}	
	}

	function save(id){
		var consume = document.getElementById("issue"+id).value;
		err=0;
		var sql = "SELECT * FROM product where id ="+id+" ";
		$.ajax({
              type: "GET",
              url: "pie_chart.php",
              data: {"sql":sql},
              success: function(data){
              	name = data[0]['name'];
              	if(data[0]['quantity']-consume>=0){ 
		              $.ajax({
		              type: "POST",
		              url: "create_table.php",
		              data: {'issued':consume,'id':id},
		              success: function(data){
							Swal.fire({
								  position: 'top-end',
								  icon: 'success',
								  title: '"'+name+'" has been saved',
								  showConfirmButton: false,
								  timer: 1500
								});
							table();
							}
			          });	
	          	}
	          	else{
	          		Swal.fire({
								  position: 'top-end',
								  icon: 'warning',
								  title: '"'+name+'" has insufficient quantity',
								  showConfirmButton: false,
								  timer: 2000
								});
	          	}
              }
          });
	}
	
	</script>
