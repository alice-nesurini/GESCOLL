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
	$idObj=0;
	$maxQuery="INSERT INTO Object VALUES(NULL, '$cod', '$name', '$description', '$price', '$color', '$shipping', '$selling', $idUser, '$typeId')";
	$result=mysqli_query($conn, $maxQuery) or die(mysqli_error($conn));
	$idNewObject="SELECT Id FROM Object WHERE Cod='$cod' AND Name='$name' AND `Desc`='$description' AND Price=$price AND cod='$cod'";
	$result=mysqli_query($conn, $idNewObject) or die(mysqli_error($conn));
	while($row=mysqli_fetch_array($result)){
		$idObj=$row['Id'];
	}

	//http://www.phpro.org/tutorials/Storing-Images-in-MySQL-with-PHP.html
	
	if(!isset($_FILES['image'])) {
    	echo '<p>Please select a file</p>';
    }
	else{
		$image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
	  	$sql="INSERT INTO `photo` (`Id`, `Photo`, Id_Object_Cover) VALUES (NULL, '{$image}', '$idObj')";
	  	//echo($sql);
		$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));
		/*$queryPhoto="SELECT * FROM Photo WHERE Id_Object_Cover='$idObj'";
		$result=mysqli_query($conn, $queryPhoto) or die(mysqli_error($conn));
		while($row=mysqli_fetch_array($result)){
			echo('<img src="data:image/png;base64,'.base64_encode($row['Photo']).'">');
		}*/
	}
	//http://www.w3bees.com/2013/02/multiple-file-upload-with-php.html
	if(is_array($_FILES['otherImages'])){
		echo(count($_FILES['otherImages']['name']));
		for($f=0; $f<count($_FILES['otherImages']['name']); $f++) {       
		        $image=addslashes(file_get_contents($_FILES['otherImages']['tmp_name'][$f]));
			  	$sql="INSERT INTO `photo` (`Id`, `Photo`, Id_Object) VALUES (NULL, '{$image}', '$idObj')";
				$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));
		}
	}
	header("Location: panelContent.php")
?>