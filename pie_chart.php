
<?php
header("Content-Type: application/json; charset=UTF-8");
include 'connection.php';
if(isset($_GET['sql'])){
$sql = $_GET['sql'];
$stmt = $con->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$outp = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($outp);
}
?>
