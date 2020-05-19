<?php include 'connection.php';?>
<?php 
			$output='';
			$date=date("Y-m-d");
			$condition =" s.date_time='".$date."' ";
			$key=0;
			if((isset($_POST['key']))) $_SESSION['key']=$_POST['key'];
			$key = $_SESSION['key'];
			// delete 
			if(isset($_POST['delete'])){
				$sql = "Delete from purchase_report where sno =".$_POST['delete']." ";
				echo $sql;
				$stmt = $con->prepare($sql);
			    $stmt->execute();
			    $stmt->close();

			}
			if(isset($_POST['txt']) && $_POST['txt']!='')
				{$condition.=" and name like '%".$_POST['txt']."%' ";}
				$condition.=" and pkey =".$key."";
				$sql = "SELECT * FROM purchase_report as s INNER JOIN product ON s.id=product.id where ".$condition." ";
				// echo $sql;
					if(!isset($_SESSION))
						session_start();
					
					if(!isset($_POST["check"])){
						$_POST["check"]="";
					}
					if(isset($_POST['init'])){
						$_SESSION['current']=0;
					
					}
					

					$check = $_POST["check"];
					$output.= '<div class="table-responsive">';
					$output.='<table class="ui celled table"> <thead><tr>';
						$head = array("#","id","Date","Product","Purchased","Consumed","Cost","Delete");
					if($key==1)
						$head = array("#","id","Date","Product","Purchased","Cost","Company","Delete");

					// header checkbox
					$output.='<th scope="col"><input type="checkbox" '.$check.' onclick="checkbox()" class="checkbox" id="all"></th>';

					// header
					for ($i=0; $i < count($head); $i++) { 
							$output.='<th scope="col">'.$head[$i].'</th>';
					}
					$output.='</tr></thead><tbody>';
					if($res = mysqli_query($con, $sql)){
						$total=mysqli_num_rows($res);
						if(!isset($_POST["size"])){
							$_POST["size"]=10;
						}
						else if($_POST['size']==0)
							$_POST['size']=$total;
						if(isset($_POST['current'])){
							
							if($_POST['current']==0&&$_SESSION['current']>=$_POST['size'])
								$_SESSION['current']-=$_POST['size'];
							if($_POST['current']==1 &&$_SESSION['current']<=$total){
								
								$_SESSION['current']+=$_POST['size'];	
							}
						}
					// body
					if($total>0){
						$k=$_SESSION['current'];
						$i=0;
						while($i<$total){
							$row = mysqli_fetch_array($res);
							if($k<=$i && $i<$k+$_POST["size"]){
								$value = array('date_time','name','purchase','consumed','purchase_cost');
								if($key==1)
									$value = array('date_time','name','purchase','purchase_cost','company_bill');
								
								$output.='<tr><td><input class="checkbox" type="checkbox" '.$check.'></td><td>'.$row['sno'].'</td><td>'.$row['id'].'</td>';
								for ($j=0; $j <count($value) ; $j++) { 
									$output.='<td>'.$row[$value[$j]].'</td>';
								}
								$output.='<td><button class="btn btn-danger" onclick="del('.$row['sno'].')">Delete</button></td>';
								$output.='</tr>';
							}
							$i++;
						}
						
					}
					else{
						$output.='<tr><td colspan="7">No Record found on '.$date.'</td></tr>';
					}
					
				}
				$output.='</tbody></table></div>';
					echo $output;
			?>

		