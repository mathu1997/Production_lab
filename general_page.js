
      function fetchdb(sql,getdata){
        $.ajax({
            type: "GET",
            url: "pie_chart.php",
            data: {"sql":sql},
            success: function(data){
              getdata(data);
            }
        });
      } 
      
      function create_table(head,data,count=1,action=1){
        content='';
		    content+="<div class='table-responsive-sm w3-container'> <table id='myTable' class='table table-bordered table-hover w3-table-all'> <thead><tr>";
      	for (var i = 0; i < head.length; i++) {
          click = `onclick="w3.sortHTML('#myTable', '.tabledata', 'td:nth-child(`+(i+1)+`)')" style="cursor:pointer;"`;
      		content+="<th "+click+"><i class='sort icon'></i>"+head[i]+"</th>";
      	}
      	content+="</thead></tr><tbody>";
      	for (arr in data){
      		content+=`<tr class="tabledata"> <td>`+count+`</td>`;
                  j=0;
      		for (key in data[arr]){
            if(key=='img'){
              var style = "background-image:url('"+data[arr][key]+"');";
              content+="<td><div class='prod-img' style="+style+"></div></td>"; continue;}
            if(key=='err') content+="<td colspan='"+head.length+"'>"+data[arr][key]+"</td>";
      			else content+="<td>"+data[arr][key]+"</td>";
      	 }
                  if(action==1){
                        content+=`<td>
                                    <button class='ui blue button' onclick='select(`+data[arr]['id']+`)' style='margin-right: 10px;' 
                                    data-toggle="modal" data-target="#newitem">
                                    <i class='edit icon'></i> </button>`;
                        content+=`<button class="ui red button" onclick="del(`+data[arr]['id']+`)">
                                    <i class="trash icon"></i>
                                    </button></td>`;
                  }
                  else if(action==0){
                        content+=`<td>
                                    <div class="ui action input">
                                    <input type="number" id="issue`+data[arr]['id']+`" name="issue"/>
                                    <div class="ui button" onclick="save(`+data[arr]['id']+`)">Save</div>
                                    </div>
                                    </td>`;
                  }
                  else if(action==2){
                        content+=`<td><button class="ui red button" onclick="del(`+data[arr]['id']+`,`+table+`)">
                                    <i class="trash icon"></i>
                                    </button></td>`;
                  }
      		content+="</tr>";
      		count++;
      	}
      	content+="</tbody></table></div> ";
        
      	return content;
	     }
  
  
      function checkCookie(element,val) {
        var page = getCookie(element);
        if (page == "") {
         setCookie(element,val,1);
        } 
      }
      function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+ d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
      }
      function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
          var c = ca[i];
          while (c.charAt(0) == ' ') {
            c = c.substring(1);
          }
          if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
          }
        }
        return "";
      }


      