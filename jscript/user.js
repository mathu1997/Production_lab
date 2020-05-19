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
		myFunction();
		function myFunction()
		  {
		    $.ajax({
		            type: "POST",
		            url: "staff_detail.php",
		            data: { 'size': 0  },
		            success: function(data){
		                document.getElementById("recent").innerHTML=data;
		            }
		        });
		        setTimeout(myFunction, 1000);
		  }
		function select(id)
		{	
			var ids=["id","name","email"];
			var j=["1","2","3"];
			for (var i = 0; i < ids.length; i++) {
				document.getElementById(ids[i]).value=document.getElementById("pro"+id+j[i]).innerHTML;
			}
		}
		function travel(t){
			$.ajax({
		            type: "POST",
		            url: "staff_detail.php",
		            data: { 'current':t ,'size': 0 },
		            success: function(data){
		                document.getElementById("recent").innerHTML=data;
		            }
		        });
		}
		function checkbox(){
	        	var check="";
	            if ($("#all").is(":checked"))  
	            	check ="checked";
	          $.ajax({
		            type: "POST",
		            url: "staff_detail.php",
		            data: { 'check': check},
		            success: function(data){
		                document.getElementById("recent").innerHTML=data;
		            }
		        	});
	      }
	      function category(){
	        	var check="";

	        	var admin=["update_prod","update_staff","stock_report"];
	        	var staff=["update_prod","consume_prod"]
	            if ($("#admin").is(":checked")) {
	            	for (var i = 0; i < staff.length; i++) {
	            		document.getElementById(staff[i]).removeAttribute("checked");
	            	}
	            	for (var i = 0; i < admin.length; i++) {
	            		document.getElementById(admin[i]).setAttribute("checked", "checked");
	            	}

	            } 
	            if ($("#staff").is(":checked")) {
	            	
	            	for (var i = 0; i < admin.length; i++) {
	            		document.getElementById(admin[i]).removeAttribute("checked");
	            	}
	            	for (var i = 0; i < staff.length; i++) {
	            		document.getElementById(staff[i]).setAttribute("checked", "checked");
	            	}

	            }
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
			  	move("staff_detail.php",{ "delete":id });
				  	}
				})
			  }
			})
		}