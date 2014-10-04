<?php
	$conn=mysqli_connect("localhost", "root", "root", "gescoll") or die("error");
	$submitId=$_REQUEST['submitName'];
	$photoQuery="SELECT * FROM Photo";
	$result=mysqli_query($conn, $photoQuery);
	while($row=mysqli_fetch_array($result)){
		if($submitId==$row['Id_Object_Cover']){
			$deletePhotoQuery="DELETE FROM Photo WHERE Id_Object_Cover='$submitId'";
			$r=mysqli_query($conn, $deletePhotoQuery);
		}
		if($submitId==$row['Id_Object']){
			$deletePhotoQuery="DELETE FROM Photo WHERE Id_Object='$submitId'";
			$r=mysqli_query($conn, $deletePhotoQuery);
		}
	}
	$query="DELETE FROM Object WHERE Id='$submitId'";
	$result=mysqli_query($conn, $query);
	header("Location: panelContent.php");
?>