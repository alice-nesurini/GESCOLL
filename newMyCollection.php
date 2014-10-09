<?php
	session_start();
	$conn=mysqli_connect("localhost", "root", "root", "gescoll") or die("error");
	$description=$_REQUEST['description'];
	$color=$_REQUEST['color'];
	$cod=$_REQUEST['cod'];
	$name=$_REQUEST['name'];
	$nameUser=$_SESSION['name'];


	//Image data
	//08.10.14
	//Alice Mariotti-Nesurini

	$query="SELECT Id FROM `user` WHERE Nickname='$nameUser'";
	$result=mysqli_query($conn, $query);
	while($row=mysqli_fetch_array($result)){
		$idUser=$row['Id'];
	}
	$type=$_REQUEST['type'];
	$query="SELECT Id FROM `type` WHERE type='$type'";
	$result=mysqli_query($conn, $query);
	while($row=mysqli_fetch_array($result)){
		$typeId=$row['Id'];
	}
	$idObj=0;
	if(empty($cod)){
		$maxQuery="INSERT INTO Object VALUES(NULL, NULL, '$name', '$description', 0, '$color', 0, 2, $idUser, '$typeId', NOW())";
	}
	else{
		$maxQuery="INSERT INTO Object VALUES(NULL, '$cod', '$name', '$description', 0, '$color', 0, 2, $idUser, '$typeId', NOW())";
	}
	$result=mysqli_query($conn, $maxQuery) or die(mysqli_error($conn));
	/*$idNewObject="SELECT Id FROM Object WHERE Cod='$cod' AND Name='$name' AND `Desc`='$description'AND cod='$cod'";
	$result=mysqli_query($conn, $idNewObject) or die(mysqli_error($conn));
	while($row=mysqli_fetch_array($result)){
		$idObj=$row['Id'];
	}*/
	$idObj=mysqli_insert_id($conn);

	//http://www.phpro.org/tutorials/Storing-Images-in-MySQL-with-PHP.html
	
	if(!isset($_FILES['image'])) {
    	echo '<p>Please select a file</p>';
    }
	else{
		$image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
		if(exif_imagetype($_FILES['image']['tmp_name'])){
		  	$sql="INSERT INTO `photo` (`Id`, `Photo`, Id_Object_Cover) VALUES (NULL, '{$image}', '$idObj')";
			$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));
		}
	}
	//http://www.w3bees.com/2013/02/multiple-file-upload-with-php.html
	if(is_array($_FILES['otherImages'])){
		echo(count($_FILES['otherImages']['name']));
		for($f=0; $f<count($_FILES['otherImages']['name']); $f++) {       
		    $image=addslashes(file_get_contents($_FILES['otherImages']['tmp_name'][$f]));
		    if(exif_imagetype($_FILES['otherImages']['tmp_name'][$f])){
			  	$sql="INSERT INTO `photo` (`Id`, `Photo`, Id_Object) VALUES (NULL, '{$image}', '$idObj')";
				$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));
			}
		}
	}
	header("Location: myCollectionPage.php")
?>