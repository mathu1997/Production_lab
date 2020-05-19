<?php 
				$output='';
				$total=32;

				if(!isset($_SESSION))
					session_start();
				if(!isset($_POST["size"])){
					$_POST["size"]=10;
				}
				else if($_POST['size']==0)
					$_POST['size']=$total;

				if(isset($_POST['init'])){
					$_SESSION['current']=0;
				}
				if(isset($_POST['current'])){
					
					if($_POST['current']==0&&$_SESSION['current']>=$_POST['size'])
						$_SESSION['current']-=$_POST['size'];
					if($_POST['current']==1 &&$_SESSION['current']<=$total){
						
						$_SESSION['current']+=$_POST['size'];
						
					}

				}
				$output.= '<div class="table-responsive">';
				$output.='<table class="table table-bordered table-striped"> <thead><tr>';
				$head = array("#","Date","Product_name","Category","Qty.","consumed","Issue");

				// header
				for ($i=0;$i<count($head);$i++){
					$output.='<th scope="col">'.$head[$i].'</th>';
				}
				$output.='</tr></thead><tbody>';

				$k=$_SESSION['current'];
				$i=0;
				while($i<$_POST['size'] && $k<$total){
					$output.='<td>'.$k.'</td>';
					for($j=0;$j<count($head)-2;$j++){

						$output.='<td>'.$j.'</td>';
					}
					$output.='<td>
					<div class="ui action input">	
					<input type="number" name="issue"/>
					<div class="ui button" onclick="save('.$i.')">Save</div>	
					</div></td>';
					$output.='</tr>';
					$k++;
					$i++;
				}
				$output.='</tbody></table>';
				echo $output;
			?>

		