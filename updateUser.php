<?php
	/* Alice Mariotti-Nesurini
	 * 17.09.14
	 * Gestione opzioni utente
	 */
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

	$query="UPDATE `user` SET Name='$name', lastname='$lastname', Nickname='$nickname', Email='$email', Nation='$nation', Address='$address', NOW() WHERE id='$idUser'";
	$result=mysqli_query($conn, $query);
	header("Location: meOptions.php");
?>