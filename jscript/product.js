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
	var x = document.getElementById("cmp");
	var cat = 0;
	<?php if(isset($_SESSION['key'])){?>
		cat = <?=$_SESSION['key']?>;
	<?php }?>
	dashboard(cat);
	function dashboard(key){
	move("create_table.php",{ 'key': key  });
	var btnContainer = document.getElementById("start");
	var btns = btnContainer.getElementsByClassName("btn");
	    var current = document.getElementsByClassName("active");
	    if (current.length > 0) {
	      current[0].className = current[0].className.replace(" active", "");
	    }
	    btns[key].className += " active";
	    switch(key){
	    	case 0: {
	    		document.getElementById("head").innerHTML = "Consumable Product Updates";
	    		x.style.display = "none";
	    		$("#cost").show();
	    		break;
	    }
	    	case 1:{
	    		document.getElementById("head").innerHTML = "Non-Consumable Product Updates";
	    		x.style.display = "block";
	    		$("#cost").show();
	    		break;
	    	}
	    	case 2:{
	    		document.getElementById("head").innerHTML = "Service Updates";
	    		x.style.display = "none";
	    		$("#price").removeAttr("required");
	    		$("#price").val("0");
	    		$("#cost").hide();
	    		// document.getElementById("cost").style.display = "none";
	    	}
	    }
	}
	function select(id)
	{	var xmlhttp = new XMLHttpRequest();
		var sql = "SELECT * FROM stock_report as s inner join product as p on s.id=p.id where s.id ="+id+" ";
		obj = {"sql":sql };
        dbParam = JSON.stringify(obj);
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              myObj = JSON.parse(this.responseText);
              alert(myObj[0]["name"]);
              	$("#id").val(myObj[0]["id"]+"");
              	$("#name").val(myObj[0]["name"]+"");
              	$("#spec").val(myObj[0]["category"]+"");
              }
          };
      	xmlhttp.open("GET", "pie_chart.php?x=" + dbParam, true);
     	xmlhttp.send();
		$("#result").html("");
	}

	
	$(document).ready(function(){
		$('#id').keyup(function(){
			var txt = ""+$(this).val();
			if(txt!=''){ 
				$.ajax({
		            type: "POST",
		            url: "filter.php",
		            data: {"txt":txt,"txt2": "id"},
		            success: function(data){
		                document.getElementById("result").innerHTML=data;
		            }
		        });}
			else document.getElementById("result").innerHTML="";
		});
		$('#name').keyup(function(){
			var txt = ""+$(this).val();
			var id = "name";
			if(txt!=''){ 
				$.ajax({
		            type: "POST",
		            url: "filter.php",
		            data: { 'txt':txt ,'txt2': id },
		            success: function(data){
		                document.getElementById("result").innerHTML=data;
		            }
		        });}
			else document.getElementById("result").innerHTML="";
		});
		$('#txt').keyup(function(){
					var txt = $(this).val();
					move("create_table.php",{ 'txt': txt});});
	});
	
	function checkbox()
	{
        if($("#all").is(":checked")) move("create_table.php",{ 'check': "checked"});
        else move("create_table.php",{ 'check': ""});
    }

    function travel(t){
		var dropDown = document.getElementById("size");
		var size = dropDown.options[dropDown.selectedIndex].value;
		move("create_table.php",{ 'current':t });
	}

	function del(id){
		Swal.fire({
		  title: 'Are you sure?',
		  text: "You won't be able to revert this!",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
		  if (result.value) {
		    Swal.fire(
		      'Deleted!',
		      'Your file has been deleted.',
		      'success'
		    ).then((result) => {
		  if (result.value) {
		  	move("create_table.php",{ "delete":id });
			  	}
			})
		  }
		})
	}