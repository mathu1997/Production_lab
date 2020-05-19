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
		move("create_table.php",{ 'size': 0 ,'consume':0 });
	}
	function travel(t){
		move("create_table.php",{ 'current':t ,'size': 0 ,'consume':0});
	}
	$(document).ready(function(){
		$('#search').keyup(function(){
					var txt = $(this).val();
					move("create_table.php",{ 'txt': txt,'consume':0});});
	});
	function save(id){
		var consume = document.getElementById("issue"+id).value;
		move("create_table.php",{ 'size': 0 ,'consume':0,'issued':consume,'id':id});
	}
	