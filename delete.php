
<?php 		
	include 'connection.php';
	$sql = $_POST['sql'];
	$stmt = $con->prepare($sql);
    $stmt->execute();
    $stmt->close();
    ?>
	