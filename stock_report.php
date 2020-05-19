

<?php include 'connection.php';?>
   
	
	<div class="container content">
		<h2 class="ui blue ribbon big label">Stock Report</h2>
		<form action="report.php" method="post">
			<div  class="d-flex justify-content-center">
				<input type="text" name="fname" required="">
				<button class="ui  button" name="export" type="submit">Excel</button>
			  	<button class="ui  button" name="export" type="submit">CVS</button>
			  	<button class="ui button" name="export" type="submit">xsl</button>
			</div>
		
		
			<br/>
			<div class="ui action input" style="margin: 16px;">	
				<div class="ui button">From</div>
				<input type="date" name="from" id="from">	
				<div class="ui button">To</div>
				<input class="border-right" type="date" name="to" id="to">
				<div class="ui green button" name="range" onclick="range()"> Search </div> 
			</div>
		
			<div>
				<?php include "search_co.php"?>
				<div id="barchart" style="width: auto; height: 350px;"></div>
			</div>
		</form>
	</div>
	<script type="text/javascript">
		mktb();
		function mktb(position=-1){
			if(checkSize(position)){
				condition="where ";
		          var today = new Date();
		          var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
		          if(from!='' && to!='')
		            condition+= "s.date >= '"+from+"' and s.date <= '"+to+"'";
		          else if(from!='' && to=='')
		            condition+= "s.date = '"+from+"'";
		          else condition+=" s.date='"+date+"' ";

		          var sql = "SELECT s.id,s.date,s.name,price,opening_qty,purchase_qty,consume_qty,balance_qty FROM stock_report as s inner join product as p on s.id=p.id "+condition+" order by date desc LIMIT "+offset+" OFFSET "+size+" ";
					console.log(sql);
					var t = $("#table");
					head = ["#","id","Date","Product&nbsp;name","Price","Opening&nbsp;qty","Purchase&nbsp;qty","Consumed&nbsp;qty","Balance&nbsp;qty"];
				table(sql,head,-1);
				google.charts.load('current', {'packages':['corechart']});
				google.charts.setOnLoadCallback(drawChart);
			}	
		}
	 	
	    function drawChart() {
	        var list = new Array();
	          list[0] = ['Prodct Name', 'Balance Quantity','Purchase','Consumed']; 
	          i = 1;    
	          for (x in myObj) 
	            list[i++] = [
	              myObj[x]['name'],
	              parseInt(Math.abs(myObj[x]['balance_qty'])),
	              parseInt(Math.abs(myObj[x]['purchase_qty'])),
	              parseInt(Math.abs(myObj[x]['consume_qty']))
	            ];
	          // console.log(list);
	          // document.getElementById("demo1").innerHTML=list;
	          var data = google.visualization.arrayToDataTable(list);
	          var options = {
	            title: 'Today Stock',
	            chartArea: {width: '50%'},
	          hAxis: {
	            title: 'Stock',
	            minValue: 0
	          },
	          vAxis: {
	            title: 'Products'
	          }
	          };
	          var chart = new google.visualization.BarChart(document.getElementById('barchart'));
	          chart.draw(data, options);
	    }
	</script>