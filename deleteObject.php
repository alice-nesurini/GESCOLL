<?php
	$submitId=$_REQUEST['submitName'];
	$conn=mysqli_connect("localhost", "root", "root", "gescoll") or die("error");
	$query="DELETE FROM Object WHERE Id='$submitId'";
	$result=mysqli_query($conn, $query);
	header("Location: panelContent.php");
?>