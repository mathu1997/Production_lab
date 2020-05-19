<?php
include 'connection.php';
 if(isset($_POST['uname'])){
 	$sql = "SELECT * FROM stock_user where username = '".$_POST['uname']."'and password = '".$_POST['pass']."'";
 	$out = '';
 	if($res = mysqli_query($con, $sql)){
			$row = mysqli_fetch_array($res);
			if($res->num_rows>0){
				$_SESSION['id']=$row['id'];
				$_SESSION['url']=0;
				$out.= $_SESSION['id'];
				$_POST['logout']=1;
			}
			echo $res->num_rows;
			
		}
		
 }

 if(isset($_POST['logout'])){
 	$sql = "UPDATE stock_user set status = ".$_POST['logout']." where id='".$_SESSION['id']."'";
	$stmt = $con->prepare($sql);
    $stmt->execute();
    $stmt->close();
    if($_POST['logout']==0){
    	session_unset(); 
 		session_destroy(); 
    }
 	
 }
?>