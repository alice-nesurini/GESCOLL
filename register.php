<?php
	$name=$_REQUEST['name'];
	$nickname=$_REQUEST['nickname'];
	$lastname=$_REQUEST['lastname'];
	$nation=$_REQUEST['nation'];
	$address=$_REQUEST['address'];
	$password=$_REQUEST['password'];
	$password=hash("sha256", $password);
	$email=$_REQUEST['email'];

	$conn=mysqli_connect("localhost", "root", "root", "gescoll") or die("error");
	$sql="INSERT INTO User(Name, lastname, Nickname, Password, Email, Nation, Address) VALUES('$name', '$lastname', '$nickname', '$password', '$email', '$nation', '$address')";
	$ris=mysqli_query($conn, $sql) or die(mysqli_error($conn));
	mysqli_close($conn);
	$_SESSION['name']=$name;
    $_SESSION['password']=$password;
	header("Location: panel.php");
?>