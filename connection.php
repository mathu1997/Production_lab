<?php 
if(!isset($_SESSION))
	session_start();
if(!isset($_SESSION["current"])){
		$_SESSION["current"]=0;
				}
$con = new mysqli('localhost','root','','stock-management');
?>