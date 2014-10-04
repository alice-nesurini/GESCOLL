<?php
	/* Inserimento nuovo tipo
	 * 01.10.14
	 * Alice Mariotti-Nesurini
	 */
	session_start();
	$conn=mysqli_connect("localhost", "root", "root", "gescoll") or die("error");
	$nameType=$_REQUEST['nameType'];
	
	$query="INSERT INTO Type VALUES(NULL, '$nameType')";
	$result=mysqli_query($conn, $query) or die(mysqli_error($conn));
	//echo("<script>window.location.href(http:\\localhost\GESCOLL\GESCOLL\panel.php)</script>");
	header("Location: panelContent.php");
?>