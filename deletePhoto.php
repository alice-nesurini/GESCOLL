<?php
	$conn=mysqli_connect("localhost", "root", "root", "gescoll") or die("error");
	$photoId=$_REQUEST['photoButton'];
	$query="DELETE FROM Photo WHERE Id='$photoId'";
	$result=mysqli_query($conn, $query);
	header("Location: editObjectPage.php");
?>