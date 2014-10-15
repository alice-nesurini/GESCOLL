<?php
	session_start();
	/* Alice Mariotti-Nesurini
	 * 08.10.14
	 * Gestione mia collezione
	 */
?>
<html>
	<head>
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="style_template.css" rel="stylesheet">
	</head>
	<body>
		<div style="margin-left: 5%; margin-top: 5%;">
			<?php
				$conn=mysqli_connect("localhost", "root", "root", "gescoll") or die("error");
				$nameUser=$_SESSION['name'];
				if(isset($_REQUEST['editButton'])){
					$_SESSION['idObjEdit']=$_REQUEST['editButton'];
				}
				$id=$_SESSION['idObjEdit'];
				$_SESSION['idObj']=$id;
				$query="SELECT * FROM `Object` WHERE Id='$id'";
				$result=mysqli_query($conn, $query);
				$showUpload=false;
				while($row=mysqli_fetch_array($result)){

					
					$queryPhoto="SELECT * FROM Photo WHERE Id_Object_Cover='$id'";
					$resultPhoto=mysqli_query($conn, $queryPhoto) or die(mysqli_error($conn));
					if(mysqli_num_rows($resultPhoto)==0){
						echo('<td style="border: 1px solid black; max-width:150px;" rowspan=5><h3>No Image</h3></td>');
						$showUpload=true;
					}
					while($rowPhoto=mysqli_fetch_array($resultPhoto)){
						echo('<td style="border: 1px solid black; max-width:150px;" rowspan=5><b>Cover</br><img src="data:image/png;base64,'.base64_encode($rowPhoto['Photo']).'" width="150px"></b></td>');
						echo("<form action='deleteMyCollectionPhoto.php' method='POST'><button name='photoButton' type='submit' value=".$rowPhoto['Id']." class='glyphicon glyphicon-remove'></button></form>");
					}


					/*altre immagini
					 *02.10.14
   					 * Alice Mariotti-Nesurini
					 */
					$queryPhoto="SELECT * FROM Photo WHERE Id_Object='$id'";
					$resultPhoto=mysqli_query($conn, $queryPhoto) or die(mysqli_error($conn));
					if(mysqli_num_rows($resultPhoto)==0){
						echo('<td style="border: 1px solid black; max-width:150px;" rowspan=5><h3>No Image</h3></td>');
					}
					while($rowPhoto=mysqli_fetch_array($resultPhoto)){
						echo('<td style="border: 1px solid black;"><b>Other images</br><img src="data:image/png;base64,'.base64_encode($rowPhoto['Photo']).'" width="145px"></b></td>');
						echo("<form action='deleteMyCollectionPhoto.php' method='POST'><button name='photoButton' type='submit' value=".$rowPhoto['Id']." class='glyphicon glyphicon-remove'></button></form>");
					}

					echo("<form action='updateMyCollection.php' method='POST' enctype='multipart/form-data'>");
					if($showUpload){
						echo('<label>Cover: </label><input type="file" name="image"/>');
					}
					echo('</label><input type="file" name="otherImages[]" multiple="multiple"/>');
					echo("Name: <input type='text' class='form-control' name='name' value='".$row['Name']."' style='width:50%;'></br>");
					echo("Cod: <input type='number' step='0.01' min='0' max='2147483645' class='form-control' name='cod' value='".$row['Cod']."' style='width:50%;'></br>");
					echo("Color: <input type='text' class='form-control' name='color' value='".$row['Color']."' style='width:50%;'></br>");
					echo("Desc: <input type='text' class='form-control' name='desc' value='".$row['Desc']."' style='width:50%;'></br>");
					echo("Selling: <input type='text' class='form-control' disabled name='selling' value='My Collection' style='width:50%;'></br>");
					/*
					echo("<select name='selling'>");
					if($row['Selling']==1){
						echo("<option selected='selected' value='1'>Selling this object</option>");
						echo("<option value='0'>Searching for this object</option>");
					}
					else{
						echo("<option value='1'>Selling this object</option>");
						echo("<option selected='selected' value='0'>Searching for this object</option>");
					}
					echo("</select>");*/

					/*if($row['Selling']==1){
						echo("Selling: <input type='text' class='form-control' name='selling' value='Selling this object' style='width:50%;'></br>");
					}
					else{
						echo("Selling: <input type='text' class='form-control' name='selling' value='Searching for this object' style='width:50%;'></br>");
					}*/
					$sql="SELECT * FROM `Type`";
					$resultType=mysqli_query($conn, $sql) or die(mysqli_error($conn));
					echo("<select name='type'>");
					while($rowType=mysqli_fetch_array($resultType)){;
						if($row['Type']==$rowType['Id']){
							echo("<option selected='selected' value=".$rowType['Id'].">".$rowType['Type']."</option>");
						}
						else{
							echo("<option value=".$rowType['Id'].">".$rowType['Type']."</option>");
						}
					}
					echo("</select>");
					echo("</br>");
					echo("</br>");
					echo("<button name='submitUpdate' type='submit' class='glyphicon glyphicon-ok btn-sm'> Save</button>");
					echo("<button name='cancelBtn' onClick='window.open(\"panel.php\", \"_parent\")' class='glyphicon glyphicon-remove btn-sm'> Cancel</button>");
					echo("</form>");
				}
			?>
		</div>
	</body>
</html>