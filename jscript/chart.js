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
      var from = '';
      var to = '';
      var txt = '';
      var limit = 0;
      var myObj;
      var len = 0;
      chartdata();
          
      function range(){
        from=document.getElementById("from").value;
        to = document.getElementById("to").value;
        chartdata();
      }
      $(document).ready(function(){
        $('#txt').keyup(function(){
          txt = $(this).val();
          if(txt!=''){
              $("recent").hide();
              $("single").show();
            }
          else {
                  $("recent").show();
                  $("single").hide();
            }
          
          chartdata();
          txt='';
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
              
          google.charts.load('current', {'packages':['corechart']});
          google.charts.setOnLoadCallback(drawChart);
            }
          };
          xmlhttp.open("GET", "pie_chart.php?x=" + dbParam, true);
          xmlhttp.send();
      }
      function travel(des){
        len =0;
        for (x in myObj) len++;
          if(des==0 && limit!=0) limit-=10;
          else if(des==1 && (len==0 || len==10)) limit+=10; 
          console.log(len+" "+limit);
          chartdata();
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

          // piechart purchase
          var list1 = new Array();
          list1[0] = ['Prodct Name','Purchase']; 
          i = 1;    
          for (x in myObj) 
            list1[i++] = [myObj[x]['name'],parseInt(Math.abs(myObj[x]['purchase_qty']))];
          
          var data1 = google.visualization.arrayToDataTable(list1);
          var optionspie = {
              title: 'Purchase',
              chartArea: {width: '50%'},
            };
          var chart1 = new google.visualization.PieChart(document.getElementById('piechart'));
          chart1.draw(data1, optionspie);

          // piechart balance
          list1[0] = ['Prodct Name','Purchase']; 
          i = 1;    
          for (x in myObj) 
            list1[i++] = [myObj[x]['name'],parseInt(Math.abs(myObj[x]['balance_qty']))];
          
          data1 = google.visualization.arrayToDataTable(list1);
          optionspie = {
              title: 'Balance',
              chartArea: {width: '50%'},
            };
          chart1 = new google.visualization.PieChart(document.getElementById('piebalance'));
          chart1.draw(data1, optionspie);

          //stepped chart
          var options = {
            width: 900,
            height: 500,
            animation: {
              duration: 500,
              easing: 'in'
            },
            hAxis: {
              title:'Date',
              viewWindow: {min:0, max:5}},
            vAxis: {
              title: 'Purchase'
            }
          };

          var chart = new google.visualization.SteppedAreaChart(document.getElementById('visualization'));
          var data = new google.visualization.DataTable();
          data.addColumn('string', 'x');
          data.addColumn('number', 'Purchase');
          data.addColumn('number', 'Consume');
          MAX = 0
          for (x in myObj) {
            MAX++;
            data.addRow([myObj[x]['date'],parseInt(Math.abs(myObj[x]['purchase_qty'])),parseInt(Math.abs(myObj[x]['consume_qty']))]);
          }

          var prevButton = document.getElementById('b1');
          var nextButton = document.getElementById('b2');
          var changeZoomButton = document.getElementById('b3');
          function drawStepped() {
            // Disabling the button while the chart is drawing.
            prevButton.disabled = true;
            nextButton.disabled = true;
            changeZoomButton.disabled = true;
            google.visualization.events.addListener(chart, 'ready',
                function() {
                  prevButton.disabled = options.hAxis.viewWindow.min <= 0;
                  nextButton.disabled = options.hAxis.viewWindow.max >= MAX;
                  changeZoomButton.disabled = false;
                });
            chart.draw(data, options);
          }

          prevButton.onclick = function() {
            options.hAxis.viewWindow.min -= 1;
            options.hAxis.viewWindow.max -= 1;
            drawStepped();
          }
          nextButton.onclick = function() {
            options.hAxis.viewWindow.min += 1;
            options.hAxis.viewWindow.max += 1;
            drawStepped();
          }
          var zoomed = false;
          changeZoomButton.onclick = function() {
            if (zoomed) {
              options.hAxis.viewWindow.min = 0;
              options.hAxis.viewWindow.max = 5;
            } else {
              options.hAxis.viewWindow.min = 0;
              options.hAxis.viewWindow.max = MAX;
            }
            zoomed = !zoomed;
            drawStepped();
          }
          drawStepped();
      }