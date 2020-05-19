
<?php include 'connection.php';?>
    
  
  <div class="container content">    
    <h2 class="ui blue ribbon big label">Char Visualization</h2><br>
      <div class="ui action input"> 
                <div class="ui button">From</div>
                <input type="date" name="from" id="from"> 
                <div class="ui button">To</div>
                <input class="border-right" type="date" name="to" id="to">
                <div class="ui green button" name="range" onclick="range()"> Search </div> 
      </div>
      <div class="ui icon input">
        <input type="text" name="txt" id="txt" placeholder="Search...">
        <i class="inverted circular search link icon"></i>
      </div>
      <br><br>
      <div class="float-right">
          <div class="ui labeled icon green button" onclick="travel(0)">
            <i class="left arrow icon"></i>
            Previous
          </div>
          <div class="ui right labeled icon green button" onclick="travel(1)">
            <i class="right arrow icon"></i>
            Next
          </div>
      </div>
      <br><br>
      <!-- Recent updates -->
      <h2 class="ui teal ribbon big label">Purchase and Consumed</h2>
      <div id="recent">
        <div id="barchart" style="width: auto; height: 500px;border:1px solid black;"></div>
        <div class="row">
          <div class="col-sm-6">
            <div id="piechart" style="width: auto; height: 500px;border:1px solid black;"></div>
          </div>
          <div class="col-sm-6">  
            <div id="piebalance" style="width: auto; height: 500px;border:1px solid black;"></div>
          </div>
        </div>
      </div>
      <h2 class="ui teal ribbon big label">Product Purchase</h2>
      <div id="single">
        <button class="ui labeled icon green button" id="b1">
            <i class="left arrow icon"></i>
            Previous
          </button>
          <button class="ui right labeled icon green button" id="b2">
            <i class="right arrow icon"></i>
            Next
          </button>
        <button class="ui right labeled icon green button" id="b3">
            <i class="zoom icon"></i>
            Zoom
          </button>
        <div id="visualization" style="width: 900px; height: 500px;"></div>
      </div>
  </div>
  <script type="text/javascript">
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
          $.ajax({
              type: "GET",
              url: "pie_chart.php",
              data: obj,
              success: function(data){
                myObj = data;
                google.charts.load('current', {'packages':['corechart']});
          google.charts.setOnLoadCallback(drawChart);
                }
              });
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
  </script>
