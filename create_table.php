
<?php 		
	include 'connection.php';

	$date=date("Y-m-d");
	// delete module
	if(isset($_POST['delete'])){
		$sql = "delete from product where id =".$_POST['delete']." ";
		$stmt = $con->prepare($sql);
	    $stmt->execute();
	    $stmt->close();
	}
	$key = 0;
	if((isset($_POST['key']))){
		$_SESSION['key']=$_POST['key'];
		$key = $_SESSION['key'];
	}
	if(isset($_POST['name']) || isset($_POST['issued'])){
		$pid=0;
		$pname='';
		$unit='';
		$pspec='';
		$cost=0;
		$field= 0;
		$qty = 0;
		$cmp='';
		if(isset($_POST['cname'])) $cmp = $_POST['cname'];
		if(isset($_POST['issued'])){ 
			$pid=$_POST['id'];
			$field= 1;
			$qty = -$_POST['issued'];
		}
		else{
			$pname = $_POST['name'];
			$unit = $_POST['q_unit'];
			$qty = $_POST['qty'];
			$pspec = $_POST['spec'];
			$cost = $_POST['cost'];
		}
		$sql = "call create_table(".$pid.",'".$pname."','".$pspec."',".$qty.",'".$unit."',".$cost.",".$key.",".$field.",'".$cmp."');";
		// echo $sql;
		$stmt = $con->prepare($sql);
	    $stmt->execute();
	    $stmt->close();
	}
	$con->close();
		
	?>

		