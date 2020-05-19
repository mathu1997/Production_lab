<?php include 'connection.php';?>
<?php 
			$output='';
			$date=date("Y-m-d");
			$condition =" s.date='".$date."' ";
			if(isset($_POST['from']) && isset($_POST['to'])){
				if($_POST['from']!='' && $_POST['to']!='')
					$condition= "s.date >= '".$_POST['from']."' and s.date <= '".$_POST['to']."'";
				else if($_POST['from']!='' && $_POST['to']=='')
					$condition= "s.date = '".$_POST['from']."'";
			}
			if(isset($_POST['txt']) && $_POST['txt']!='')
				$condition.=" and (p.name like '%".$_POST['txt']."%' or p.id like '%".$_POST['txt']."%' or p.category like '%".$_POST['txt']."%')";
			
			if(!isset($_SESSION)) session_start();

			// size and check box
			$_POST["size"]=10;
			if(!isset($_POST["check"])){
				$_POST["check"]="";
			}
			if(isset($_POST['init'])) $_SESSION['current']=0;
			
			
			$sql = "SELECT * FROM stock_report as s inner join product as p on s.id=p.id where ".$condition." limit 10 offset ".$_SESSION['current']." ";
			// echo $sql;
			$res = mysqli_query($con, $sql);
			$total=mysqli_num_rows($res);
			
			if(isset($_POST['current'])){
				if($_POST['current']==0&&$_SESSION['current']>=$_POST['size'])
					$_SESSION['current']-=$_POST['size'];
				if($_POST['current']==1 &&$_SESSION['current']<=$total)
					$_SESSION['current']+=$_POST['size'];
			}
			$check = $_POST["check"];
			if(isset($_POST['export']))
			$output.='<center><b><h2>Stock Report</h2></b></center>';
			$output.= '<div class="table-responsive">';
			$output.='<table id="stock" class="ui celled table"> <thead><tr>';
			$head = array("#","id","Date","Product","Rs/unit","Opening Stock","Purchase","Consumption","Balance");


			// header checkbox
			$output.='<th scope="col"><input type="checkbox" '.$check.' onclick="checkbox()" class="checkbox" id="all"></th>';


			// header
			for ($i=0; $i < count($head); $i++) { 
					$output.='<th scope="col" >'.$head[$i].'</th>';
			}
			$output.='</tr></thead><tbody>';

			// body
			if($total>0){
				$i=0;
				while($i<$total){
					$row = mysqli_fetch_array($res);
					$output.='<tr><td><input class="checkbox" type="checkbox" '.$check.'></td><td>'.($i+1).'</td>';
					for ($j=0; $j <count($head)-1 ; $j++) { 
						$output.='<td>'.$row[$j].'</td>';

					}
					$output.='</tr>';
					
					$i++;
				}

				$output.='<tr><td colspan="7">Total</td>';
				$sql = "SELECT 
				sum(purchase_qty),
				sum(consume_qty)
				FROM stock_report as s inner join product as p on s.id=p.id where ".$condition."";
				$res = mysqli_query($con, $sql);
				$row = mysqli_fetch_array($res);
				for ($i=0;$i<2;$i++){
					$output.='<td>'.round($row[$i]).'</td>';
				}
				$output.='</tr>';
			}
			else{
				$output.='<tr><td colspan="14">No Record found on '.$date.'</td></tr>';
			}
			$output.='</tbody></table></div>';
			$con->close();

			if(isset($_POST['export'])){
				$fname = "export_".$date.".xls";
				if(isset($_POST['fname']))
					$fname = $_POST['fname']."_".$date.".xls";
				echo $_POST['export'];
				header('Content-Type: application/vnd.ms-excel');
				header("Content-Disposition: attachment; filename=\"$fname\"");
				echo $output;
				exit();
			}
			echo $output;
		mysqli_free_result($res); 
			
			?>

		