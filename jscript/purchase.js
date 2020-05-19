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
	var cat = 0;
	<?php if(isset($_SESSION['key'])){?>
		cat = <?=$_SESSION['key']?>;
	<?php }?>
	dashboard(cat);
	function dashboard(key){
	move("purchase_report.php",{ 'key': key  });
	var btnContainer = document.getElementById("start");
	var btns = btnContainer.getElementsByClassName("btn");
	    var current = document.getElementsByClassName("active");
	    if (current.length > 0) {
	      current[0].className = current[0].className.replace(" active", "");
	    }
	    btns[key].className += " active";
	    switch(key){
	    	case 0: {
	    		document.getElementById("head").innerHTML = "Consumable Product Report";
	    		break;
	    }
	    	case 1:{
	    		document.getElementById("head").innerHTML = "Non-Consumable Product Report";
	    		break;
	    	}
	    	case 2:{
	    		document.getElementById("head").innerHTML = "Service Report";
	    	}
	    }
	}


	$(document).ready(function(){
		$('#txt').keyup(function(){
					var txt = $(this).val();
					move("purchase_report.php",{ 'txt': txt});});
	});
	
	function checkbox()
	{	
        if($("#all").is(":checked")) move("purchase_report.php",{ 'check': "checked"});
        else move("purchase_report.php",{ 'check': ""});
    }

    function travel(t){
		move("purchase_report.php",{ 'current':t });
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
		  	move("purchase_report.php",{ "delete":id });
			  	}
			})
		  }
		})
	}