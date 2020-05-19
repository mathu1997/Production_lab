<?php 
				include 'connection.php';
				if(!isset($_POST["size"])){
					$_POST["size"]=5;
				}
				$output = '';
				$txt = $_POST['txt'];
				$var = $_POST['txt2'];
				$sql = "SELECT * FROM product where ".$var." like '".$txt."%'";
				if($res = mysqli_query($con, $sql)){
					$total=mysqli_num_rows($res);
					$output.='<table class="table table-striped">';
					$head = array("#","Date","Product_name","Category","Qty.","price");
					// for ($i=0;$i<count($head);$i++){
					// 	$output.='<th scope="col">'.$head[$i].'</th>';
					// }

					$output.='<tbody>';
					for ($i=0,$k=0;$i<$_POST['size'] && $k<$total;$i++,$k++){
						$row = mysqli_fetch_array($res);
						$output.='<tr onclick="select('.$row['id'].')">';
						for($j=0;$j<count($head);$j++){
							$output.='<td>'.$row[$j].'</td>';
						}
						$output.='</tr>';
					}
					$output.='</tbody></table>';
				}
				echo $output;
			?>