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


	//Image data
	//30.09.14
	//Alice Mariotti-Nesurini
	//Aggiunta immagini per oggetto
	
	if($price==""){
		$price=0;
	}
	if($shipping==""){
		$shipping=0;
	}

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
	if($cod==""){
		$maxQuery="INSERT INTO Object VALUES(NULL, NULL, '$name', '$description', '$price', '$color', '$shipping', '$selling', $idUser, '$typeId', NOW())";
	}
	else{
		$maxQuery="INSERT INTO Object VALUES(NULL, '$cod', '$name', '$description', '$price', '$color', '$shipping', '$selling', $idUser, '$typeId', NOW())";
	}
	$result=mysqli_query($conn, $maxQuery) or die(mysqli_error($conn));
	$idObj=mysqli_insert_id($conn);

	//http://www.phpro.org/tutorials/Storing-Images-in-MySQL-with-PHP.html
	
	if(!isset($_FILES['image'])) {
    	echo '<p>Please select a file</p>';
    }
	else{
		$image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
		if(exif_imagetype($_FILES['image']['tmp_name'])){
			echo($idObj);
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
	header("Location: panelContent.php")
?>