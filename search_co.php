<style type="text/css">
	.ui.label.show{
		padding:0 0 0 10px;
	}
	.table-responsive-sm{

		padding: 10px 0;
	}
</style>
<div class="container">
	<div class="ui icon input search">
		<input oninput="w3.filterHTML('#myTable', 'tr', this.value)" class="w3-input w3-light-gray" placeholder="Search for names..">
		<i class="inverted circular search link icon"></i>
	</div>
	<div class="ui label show">Show
		<select class="right attached ui compact selection dropdown" onchange="changeSize($(this).val())" style="padding-bottom: 10px;">
			  <option value="10">10</option>
			  <option value="25">25</option>
			  <option value="50">50</option>
			  <option value="100">100</option>
		</select>
	</div>


	<div class="float-right">
			<div class="ui labeled icon green button" onclick="mktb(0)">
			  <i class="left arrow icon"></i>
			  Previous
			</div>
			<div class="ui right labeled icon green button" onclick="mktb(1)">
			  <i class="right arrow icon"></i>
			  Next
			</div>
		</div>
	<!-- Recent updates -->
	<div id="table"></div>
	<div class="d-flex justify-content-end">
		<div class="ui labeled icon green button" onclick="mktb(0)">
		  <i class="left arrow icon"></i>
		  Previous
		</div>
		<div class="ui right labeled icon green button" onclick="mktb(1)">
		  <i class="right arrow icon"></i>
		  Next
		</div>
	</div>
</div>

<script type="text/javascript">
	// table & type
	var myObj;
	type = 0;
	size=0;
	offset = 10;
	var from = '';
	var to = '';
	// table & type
	
	
	function range(){
		from=document.getElementById("from").value;
		to = document.getElementById("to").value;
		mktb();
	}

	function clearfield(){
		var x = $("form").serializeArray();
		for(let num in x)
			$("#"+x[num]['name']).val('');
	}

	function changeSize(value){
	  	size = 0;
	    offset = parseInt(value);
	    mktb();
	}

	function checkSize(position=-1){
		if(position==0) size-=offset;
		else if(position==1) size+=offset;
		if(size>=0) return true;
		else size=0;
		return false;
	}
	
	function table(sql,head,action=1){
		var t = $("#table");
		fetchdb(sql,function(data){
			t.empty();
		      if(data.length!=0){
		      	t.append(create_table(head,data,size+1,action));
		        myObj = data;
		      }
		      else{
		      	t.append(create_table(head,{0:{'err':"data not found"}},size,-1));
		      	size-=offset;
		      }
		});
	}

	function del_com(id,table){
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
            $.ajax({
                    type: "post",
                    url: "delete.php",
                    data: {"sql":"delete from "+table+" where id = "+id},
                    success: function(data){
                        mktb();
                    }
                });
              }
          })
          }
        })
    }
</script>