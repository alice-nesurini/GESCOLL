<?php
	session_start();
	$conn=mysqli_connect("localhost", "root", "root", "gescoll") or die("error");
	$name=$_REQUEST['name'];
	$cod=$_REQUEST['cod'];
	$price=$_REQUEST['price'];
	$shipping=$_REQUEST['shipping'];
	$color=$_REQUEST['color'];
	$desc=$_REQUEST['desc'];
	$type=$_REQUEST['type'];
	$selling=$_REQUEST['selling'];
	$id=$_SESSION['idObjEdit'];

	if(empty($price)){
		$price=0;
	}
	if(empty($shipping)){
		$shipping=0;
	}
	if(empty($color)){
		$color='No color';
	}

	if(isset($_FILES['image'])){
		$image=addslashes(file_get_contents($_FILES['image']['tmp_name']));
		echo(exif_imagetype($_FILES['image']['tmp_name']));
		if(exif_imagetype($_FILES['image']['tmp_name'])){
		  	$sql="INSERT INTO `photo` (`Id`, `Photo`, Id_Object_Cover) VALUES (NULL, '{$image}', '$id')";
			$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));
		}
	}

	if(is_array($_FILES['otherImages'])){
		echo(count($_FILES['otherImages']['name']));
		for($f=0; $f<count($_FILES['otherImages']['name']); $f++) {       
		    $image=addslashes(file_get_contents($_FILES['otherImages']['tmp_name'][$f]));
		    if(exif_imagetype($_FILES['otherImages']['tmp_name'][$f])){
				$sql="INSERT INTO `photo` (`Id`, `Photo`, Id_Object) VALUES (NULL, '{$image}', '$id')";
				$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));
			}
		}
	}

	if(empty($cod)){
		$query="UPDATE `Object` SET Name='$name', Cod=NULL, Price='$price', Shipping='$shipping', Color='$color', `Desc`='$desc', Type='$type', Selling='$selling' WHERE id='$id'";
	}
	else if(!(empty($cod))){
		$query="UPDATE `Object` SET Name='$name', Cod='$cod', Price='$price', Shipping='$shipping', Color='$color', `Desc`='$desc', Type='$type', Selling='$selling' WHERE id='$id'";
	}
	$result=mysqli_query($conn, $query);
	//echo($query);
	header("Location: editObjectPage.php");
?>