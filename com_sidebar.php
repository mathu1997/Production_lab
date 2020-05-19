
<?php include 'header.html'?>
<?php include 'general_page.html'?>
<script>
if(getCookie("staff_id")=='')
	window.location.href = "index.php";
</script>

 <style>
		body {
		  margin: 0;
		}
		#menubar{
			padding-left: 0;
		}
		#dynamic{
			width: 1180px;
		}
		#cmnav {
		  list-style-type: none;
		  margin: 0;
		  padding: 0;
		  background-color: #f1f1f1;
		  overflow: auto;
		  width: 100%;
		}

		li button {
		  width: 100%;
		  display: block;
		  color: #000;
		  padding: 16px 16px;
		  text-decoration: none;
		  border-bottom: 1px solid black;
		}

		li button.active {
		  background-color: #4CAF50;
		  color: white;
		}

		li button:hover:not(.active) {
		  background-color: #555;
		  color: white;
		}

</style>

	<header>
		<nav class="navbar navbar-dark bg-dark flex-md-nowrap p-0">
	      	<a class="navbar-brand" href="#">
		      	<div id="logo-img" alt="logo image" class="float-left"></div>
		      	<div>
					<h1>Production Laboratory</h1>
					<p>Stock Management</p>
				</div>
			</a>
	      	<ul class="navbar-nav px-3">
		        <li class="nav-item text-nowrap">
		          <a class="nav-link"><button class="btn btn-outline-success" onclick="logout()">Logout</button></a>
		        </li>
		    </ul>
	    </nav>
		<!-- <nav id="header-nav" class="navbar navbar-default navbar-expand-lg fixed-top">
			<div class="navbar-header">
				<a href="#" class="float-left">
					<div id="logo-img" alt="logo image"></div>
				</a>
				<div class="navbar-brand">
					<h1>Production Laboratory</h1>
					<p>Stock Management</p>
				</div>
			</div>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		    	<span class="navbar-toggler-icon"></span>
		  	</button>
		  	<div class="collapse navbar-collapse float-right" id="navbarSupportedContent">
				<ul class="nav navbar-nav  navbar-right">
				      <li class="nav-item">
				        <a class="nav-link">
				        	<button type="button" class="btn btn-primary">
							  <i class="bell outline large icon"></i> <span class="badge badge-light">4</span>
							</button>
							</a>
				      </li>
				      <li class="nav-item">
				        <a class="nav-link"><button class="btn btn-outline-success" onclick="logout()">Logout</button></a>
				      </li>    
				</ul>
			</div>
		</nav> -->
	</header>
	<section class="container-section row">
		<div class="col-sm-2" id="menubar">
			<ul id="cmnav">
				<li>
					<button type="submit" class="item active" onclick="activate(0)" name="anchor" value="0" >
					<i class="calendar alternate icon"></i>Dashboard</button>
				</li>
			    <li>
			    	<button type="submit" class="item" onclick="activate(1)" name="anchor" value="1">
			    	<i class="shopping basket icon"></i>Consumable</button>
			    </li>
			    <li>
			    	<button type="submit" class="item" onclick="activate(2)" name="anchor" value="2">
			    	<i class="cloud upload icon"></i>Issue&nbsp;Items</button>
			    </li>
			    <li>
			    	<button type="submit" class="item" onclick="activate(3)" name="anchor" value="3">
			    	<i class="tasks icon"></i>Stock&nbsp;Report</button>
			    </li>
			    <li>
			    	<button type="submit" class="item" onclick="activate(4)" name="anchor" value="4">
			    	<i class="shopping cart icon"></i>Purchase&nbsp;Report</button>
			    </li>
			    <li>
			    	<button type="submit" class="item" onclick="activate(5)" name="anchor" value="5">
			    	<i class="chart pie icon"></i>
			    	Chart</button>
			    </li>
			    <li>
			    	<button type="submit" class="item" onclick="activate(6)" name="anchor" value="6">
				    <i aria-hidden="true" class="user plus icon"></i>Users
				    </button>
				</li>
			    <li>
			    	<button type="submit" class="item" onclick="activate(7)" name="anchor" value="7">
			    	<i class="id card icon"></i>Profile
			    	</button>
			    </li>
			</ul>	
		</div>
		<div class="col-sm-10" id="dynamic_tail">
			<div id="dynamic"></div>
		</div>
	</section>

<script type="text/javascript">
	function dynamicPage(id){
        $("#dynamic").html("");
        var urlMenu = ["dashboard","product","consumable","stock_report","purchase","chart","user","profile"];
        console.log(id);
        console.log(urlMenu[id]);
        $.ajax({
                  url: urlMenu[id]+".php",
                  success: function(data){
                    $("#dynamic").html(data);
                  }
              });
      }
	function checkCookie(element,val) {
        var page = getCookie(element);
        if (page == "") {
         setCookie(element,val,1);
        } 
      }
	checkCookie("page",0);
	function logout() {
		setCookie("staff_id",'',1);
		window.location.href = "index.php";
	}
	var acc = [];
	sql = "SELECT up,cp,sr,us FROM stock_user where id='"+getCookie("staff_id")+"'";
	$.ajax({
            type: "GET",
            url: "pie_chart.php",
            data: {"sql":sql},
            success: function(data){
            	acc.push(data[0]['up']);
            	acc.push(data[0]['cp']);
            	acc.push(data[0]['sr']);
            	acc.push(data[0]['us']);
            }
        });
	var accPermision = [1,2,6,3];
	function activate(id=0){
		console.log(acc);
		var btnContainer = document.getElementById("cmnav");
		var btns = btnContainer.getElementsByClassName("item");
	    var current = document.getElementsByClassName("active");

	    for (var i = 0; i < acc.length; i++) {
	    	console.log("acc[i] == 0 <:"+acc[i]);
	    	if(acc[i]==0)
	    		btns[accPermision[i]].style.display="none";
	    }
	    if (current.length > 0) {
	      current[0].className = current[0].className.replace(" active", "");
	    }
	    btns[id].className += " active";
	    dynamicPage(id);
	    setCookie("page",id,1);
	}
	activate(parseInt(getCookie("page")));
</script>

</body>
</html>