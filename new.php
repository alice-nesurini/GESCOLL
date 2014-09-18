<?php
	session_start();
	$conn=mysqli_connect("localhost", "root", "root", "gescoll") or die("error");
	$description=$_REQUEST['description'];
	$color=$_REQUEST['color'];
	$price=$_REQUEST['price'];
	$shipping=$_REQUEST['shipping'];
	$cod=$_REQUEST['cod'];
	$name=$_REQUEST['name'];
	$selling=$_REQUEST['selling'];
	$nameUser=$_SESSION['name'];
	$query="SELECT Id FROM `user` WHERE Nickname='$nameUser'";
	$result=mysqli_query($conn, $query);
	while($row=mysqli_fetch_array($result)){
		$idUser=$row['Id'];
	}
	if(strtolower($selling)=='selling'){
		$selling=1;
	}
	else{
		$selling=0;
	}
	$type=$_REQUEST['type'];
	$query="SELECT Id FROM `type` WHERE type='$type'";
	//echo($query)
	$result=mysqli_query($conn, $query);
	while($row=mysqli_fetch_array($result)){
		$typeId=$row['Id'];
	}
	$maxQuery="INSERT INTO Object VALUES(NULL, '$cod', '$name', '$description', '$price', '$color', '$shipping', '$selling', $idUser, '$typeId')";
	$result=mysqli_query($conn, $maxQuery) or die(mysqli_error($conn));
	header("Location: panelContent.php")
?>