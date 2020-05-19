
<?php include 'connection.php'?>
	
		<div class="container content">
			<h2 id="head" class="ui blue ribbon big label">Purchase Report</h2>
			<div class="ui top attached tabular green menu" id="start" >
			    <button class="item btn active" onclick="dashboard(0)">Consumables</button>
			    <button class="item btn" onclick="dashboard(1)">Non-Consumables</button>
			    <button class="item btn" onclick="dashboard(2)">Service</button>
			  
			</div>
			<div class="ui bottom attached segment">
			 	<p>
					
					<div class="border border-info rounded" style="padding: 30px;">
						<?php include "search_co.php"?>
					</div>
				</p>
			</div>
		</div>
<script type="text/javascript">
			 
	// table & type
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
	}
	
	function mktb(position=-1){
		if(checkSize(position)){
			if(type==1){
				sql = 'SELECT s.id,s.date_time,concat_ws(" ",p.name,"(",p.category,")") as name,s.purchase,p.cost,p.company FROM purchase_report as s,product as p where pkey = '+type+' and s.date_time="'+date+'" LIMIT '+offset+' OFFSET '+size+'';
				head = ["#","id","Date","Product","Purchased","Cost","Company","Delete"];
			}
			else{
				sql = 'SELECT s.id,s.date_time,concat_ws(" ",p.name,"(",p.category,")") as name,s.purchase,s.consumed,p.cost FROM purchase_report as s inner join product as p on s.id=p.id as p where pkey = '+type+' and s.date_time="'+date+'" LIMIT '+offset+' OFFSET '+size+'';
				head = ["#","id","Date","Product","Purchased","Consumed","Cost","Delete"];
			}
			table(sql,head,2);
		}	
	}
	
	function del(id){
		del_com(id,"purchase_report");
	}
</script>

