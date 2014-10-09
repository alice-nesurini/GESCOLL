<?php
	session_start();
	$name=$_REQUEST['name'];
	$nickname=$_REQUEST['nickname'];
	$lastname=$_REQUEST['lastname'];
	$nation=$_REQUEST['nation'];
	$address=$_REQUEST['address'];
	$password=$_REQUEST['password'];
	$password=hash("sha256", $password);
	$email=$_REQUEST['email'];

	if($nickname=="" || $name=="" || $lastname=="" || $password=="" || $address=="" || $nation==""){
		$_SESSION['invalidData']=true;
		header("Location: registerPage.php");
	}
	else{
		$conn=mysqli_connect("localhost", "root", "root", "gescoll") or die("error");
		$sql="INSERT INTO User(Name, lastname, Nickname, Password, Email, Nation, Address) VALUES('$name', '$lastname', '$nickname', '$password', '$email', '$nation', '$address')";
		$doubleNames="SELECT Nickname FROM User";
		$result=mysqli_query($conn, $doubleNames);
		while($row=mysqli_fetch_array($result)){
			if($nickname==$row['Nickname']){
				/*echo("<div><font color='red'>Your Nickname already exists</font></div>");*/
				$_SESSION['nicknameExists']=true;
				header("Location: registerPage.php");
			}
		}
		$ris=mysqli_query($conn, $sql) or die(mysqli_error($conn));
		mysqli_close($conn);
		$_SESSION['name']=$name;
	    $_SESSION['password']=$password;
		header("Location: panel.php");
	}
?>