<?php 		
	include 'connection.php';

	$date=date("Y-m-d");
	// delete module
	if(isset($_POST['delete'])){
		$sql = "DELETE FROM stock_user where sno =".$_POST['delete']." ";
		$stmt = $con->prepare($sql);
	    $stmt->execute();
	    $stmt->close();
	}
	if(isset($_POST['name'])){
		$var='';
		if(!empty($_POST['priv'])){
		$priv=array("up","cp","us","sr");
		$index=array(0,0,0,0);
		
		for($i=0;$i<4;$i++){
			
			if(in_array($priv[$i], $_POST['priv'])){ 
				$index[$i]=1;
				$var.=",".$priv[$i]."= 1";
			}
			else $var.=",".$priv[$i]."= 0";
		}
	}
		$sql = "SELECT * FROM stock_user where email = '".$_POST['email']."'or id = '".$_POST['id']."'";
		if($res = mysqli_query($con, $sql)){
			$row = mysqli_fetch_array($res);
			if ($res->num_rows == 0) {
				$sql = "Insert into stock_user(id,name,email,username,password,up,cp,us,sr) values(?,?,?,?,?,?,?,?,?)";
				$stmt = $con->prepare($sql);
				$stmt->bind_param("sssssiiii",$_POST['id'],$_POST['name'],$_POST['email'],$_POST['uname'],$_POST['pass'],$index[0],$index[1],$index[2],$index[3]);
				$stmt->execute();
				$stmt->close();
			}
			else{
				$set = 'name="'.$_POST['name'].'",email="'.$_POST['email'].'"';
				if($_POST['pass']!='') $set.=",password='".$_POST['pass']."' ";
				if(isset($_POST['uname'])) $set.=",username='".$_POST['uname']."'";
				$sql = "UPDATE stock_user SET ".$set." ".$var." WHERE id='".$row['id']."';";
				echo $sql;
				$stmt = $con->prepare($sql);
				$stmt->execute();
				$stmt->close();
			}
		}
	}
	// update or insert
	// search
	if(isset($_POST['txt']) && $_POST['txt']!='')
		{$sql = "SELECT * FROM stock_user where name like '%".$_POST['txt']."%' or id like '%".$_POST['txt']."%'";}
	else
		{$sql = "SELECT * FROM stock_user";}


	$output = '';

		if(!isset($_POST["check"])){
			$_POST["check"]="";
		}
		if(isset($_POST['init'])){
			$_SESSION['current']=0;
		
		}
		

		$check = $_POST["check"];
		$output.= '<div class="table-responsive">';
		$output.='<table class="ui celled table"> <thead><tr>';
		$head = array("status","#","id","Name","Email","Update","Delete");
		
		// header
		for ($i=0;$i<count($head);$i++){
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
				if($_POST['current']==1 &&$_SESSION['current']<=$total)
					$_SESSION['current']+=$_POST['size'];
			}
			// body
			
			$k=$_SESSION['current'];
			$i=0;
			while($i<$total){
				$row = mysqli_fetch_array($res);
				if($k<=$i && $i<$k+$_POST["size"]){
					if($row[0]==0)
						$output.='<td><i class="toggle off red icon"></i></td>';
					else $output.='<td><i class="toggle on green icon"></i></td>';
					$output.='<td>'.$row[1].'</td>';
					for($j=2;$j<count($head)-2;$j++){
						$output.='<td id="pro'.$row['sno'].$j.'">'.$row[$j].'</td>';
					}
					$output.="<td><a href='#pro_form'><button class='btn btn-secondary' onclick='select(".$row['sno'].")' > Update </button></a> </td>";
					$output.='<td><button class="btn btn-danger" onclick="del('.$row['sno'].')">Delete</button></td>';
					$output.='</tr>';
				}
				$i++;
			}
			
		}
		$output.='</tbody></table>';
			echo $output;
	if(isset($_POST['name']))
		header("Location: com_sidebar.php"); 
	?>