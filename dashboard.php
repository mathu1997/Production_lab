
	<?php include 'connection.php'?>
	
		<div class="container content">
			<h2 class="ui blue ribbon big label" id="start">Inventory Dashboard</h2>
			<div class="border border-primary rounded ui equal width">
				<div id="detail"></div>

			</div>
			<!-- Recent -->
			<h2 class="ui green ribbon big label" id="start">Recent Purchase Invoice</h2>
			<div>
				<?php include "search_co.php"?>
			</div>
		</div>
		<script type="text/javascript">
			sql = "SELECT totalCount(1) as nonconsume,totalCount(0) as consumables,zero_stock() as purchaselist,totalCount(2) as returns";
			item = ["Non-consumables","consumables","Zero&nbsp;stock&nbsp;products","Damaged&nbsp;Item"];
			
			img = ["nonconsume","consumables","purchaselist","returns"];
			icon = ["warehouse","clipboard list","pallet"];
			$.ajax({
			    type: "GET",
			    url: "pie_chart.php",
			    data: {"sql":sql},
			    success: function(data){
			      // data = JSON.parse(data);
			      	output = '<div class="row">';
				    for (let x = 0; x < 4; x++) {
						output+=`
							<div class="col-lg-3 col-md-6 col-sm-6 dash-card">
								<div class="card">
									<img class="card-img-top" src="img/`+img[x]+`.jpg"  alt="Card image cap">
									<div class="card-body">
									  	<div class="ui statistics">
									  		<div class="statistic" style="margin:auto;font-size:24px;">
											    <div class="value">
											      <i class="`+icon[x]+` icon"></i> `+data[0][img[x]]+`
											    </div>
											    <div class="label" style="font-size:18px;margin-top:10px; ">`+item[x]+`</div> 
											</div>
										</div>
									</div>
								</div>
							</div>`;	
					}
					output+='</div>';
					console.log(output);
					$("#detail").append(output);
			    },
			    error: function(XMLHttpRequest, textStatus, errorThrown) { 
				        console.log("Status: " + textStatus); console.log("Error: " + errorThrown); 
				    }  
			});
		</script>
		<script type="text/javascript">
			mktb();
			function mktb(position=-1){
				if(checkSize(position)){
					sql = 'SELECT id,concat_ws(" ",name,"(",specification,")") as name,concat_ws(" ",quantity,"(",q_unit,")") as qty FROM product where prod_key = '+type+'  LIMIT '+offset+' OFFSET '+size+' ';
					console.log("sql = "+sql);
					head = ["#","id","Product&nbsp;name","Qty."];
					table(sql,head,-1);
				}	
			}
		</script>
		


		