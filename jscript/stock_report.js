
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
		var myObj;
	      var len =0;
	      var from = '';
	      var to = '';
	      var txt = '';
	      var limit = 0;
		myFunction();
		chartdata();
		function myFunction()
		  {
		    move("report.php",{ 'size': 0,'init': 0});

		  }
		  
		function travel(t){
			from=document.getElementById("from").value;
			to = document.getElementById("to").value;
			move("report.php",{ 'current':t ,'from': from,'to': to });
			chartdata();
		}

		function range(){
			from=document.getElementById("from").value;
			to = document.getElementById("to").value;
			move("report.php",{ 'from': from,'to': to});
			chartdata();
		}
		function checkbox(){
	        if ($("#all").is(":checked")) move("report.php",{ 'check': "checked"});
	        else move("report.php",{ 'check': ""});
	    }

	 	$(document).ready(function(){
					$('#txt').keyup(function(){
						from=document.getElementById("from").value;
						to = document.getElementById("to").value;
						txt = $(this).val();
						move("report.php",{ 'txt': txt,'from': from,'to': to});
						chartdata();
					});
					});
			function chartdata(){
		      var xmlhttp = new XMLHttpRequest();
		      condition="where ";
	          var today = new Date();
	          var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
	          if(from!='' && to!='')
	            condition+= "s.date >= '"+from+"' and s.date <= '"+to+"'";
	          else if(from!='' && to=='')
	            condition+= "s.date = '"+from+"'";
	          else condition+=" s.date='"+date+"' ";

	          if(txt!='')
	            condition+=" and p.name like '"+txt+"%'";
	          var sql = "SELECT * FROM stock_report as s inner join product as p on s.id=p.id "+condition+" limit 10 offset "+limit+" ";
	          obj = {"sql":sql };
	          dbParam = JSON.stringify(obj);
		      xmlhttp.onreadystatechange = function() {
		        if (this.readyState == 4 && this.status == 200) {
		          myObj = JSON.parse(this.responseText);
		          console.log(this.responseText);
		          for (x in myObj) len++;
		        google.charts.load('current', {'packages':['corechart']});
		      	google.charts.setOnLoadCallback(drawChart);
		      if(len!=0){
		        document.getElementById('piechart').style.display="block";
		      }
		      else document.getElementById('piechart').style.display="none";
		        }
		      };
		      xmlhttp.open("GET", "pie_chart.php?x=" + dbParam, true);
		      xmlhttp.send();
		      
		  	}
		    function drawChart() {
		        var list = new Array();
		        list[0] = ['Prodct Name', 'Balance Quantity','Purchase','Consumed']; 
		        i = 1;    
		      	for (x in myObj) {
			        row = new Array(3); 
			        row[0] = myObj[x]['name'];
			        row[1] = parseInt(Math.abs(myObj[x]['balance_qty']));
			        row[2] = parseInt(Math.abs(myObj[x]['purchase_qty']));
			        row[3] = parseInt(Math.abs(myObj[x]['consume_qty']));
			        list[i] = row;
			        i++;
			      }


			      console.log(list);
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

		        var chart = new google.visualization.BarChart(document.getElementById('piechart'));

		        chart.draw(data, options);
		    }