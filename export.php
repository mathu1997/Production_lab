<?php
// Database Connection
$_GET['export'] = 'true';
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "production_lab";
 
 $conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
 
if(isset($_GET['export'])){
if($_GET['export'] == 'true'){
$query = mysqli_query($conn, 'select * from date_update'); // Get data from Database from demo table
 
 
    $delimiter = ",";
    $filename = "stock_" . date('Ymd') . ".csv"; // Create file name
     
    //create a file pointer
    $f = fopen('php://memory', 'w'); 
     
    //set column headers
    $fields = array('S.No.','ID', 'Date', 'Order Quantity', 'Issued','Cost');
    fputcsv($f, $fields, $delimiter);
     
    //output each row of the data, format line as csv and write to file pointer
    while($row = $query->fetch_assoc()){
        
        $lineData = array($row['sno'], $row['id'], $row['date'], $row['order_quantity'], $row['issued'],$row['cost']);
        fputcsv($f, $lineData, $delimiter);

    }    
    //move back to beginning of file
    fseek($f, 0);
     
    //set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
     
    //output all remaining data on a file pointer
    fpassthru($f);
 
 }
}
?>