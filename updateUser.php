<?php
	session_start();
	$conn=mysqli_connect("localhost", "root", "root", "gescoll") or die("error");
	$nameUser=$_SESSION['name'];
	$name=$_REQUEST['name'];
	$lastname=$_REQUEST['lastname'];
	$nickname=$_REQUEST['nickname'];
	$email=$_REQUEST['email'];
	$nation=$_REQUEST['nation'];
	$address=$_REQUEST['address'];

	$query="SELECT Id FROM `user` WHERE nickname='$nameUser'";
	$result=mysqli_query($conn, $query);
	while($row=mysqli_fetch_array($result)){
		$idUser=$row['Id'];
	}

	$query="UPDATE `user` SET Name='$name', lastname='$lastname', Nickname='$nickname', Email='$email', Nation='$nation', Address='$address' WHERE id='$idUser'";
	$result=mysqli_query($conn, $query);
	/*echo(mysqli_error($conn));
	$query="SELECT * FROM `user` WHERE nickname='$nameUser'";
	$result=mysqli_query($conn, $query);
		while($row=mysqli_fetch_array($result)){
		echo("</br>".$row['Name']."</br>");
		echo($row['lastname']."</br>");
		echo($row['Nickname']."</br>");
		echo($row['Email']."</br>");
		echo($row['Nation']."</br>");
		echo($row['Address']."</br>");
	}*/
	header("Location: meOptions.php");
?>