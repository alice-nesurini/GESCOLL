<?php
	session_start();
	/* Alice Mariotti-Nesurini
	 * Data creazione: 17.09.14
	 * Visualizzazione oggetti personali
	 */
?>
<html>
	<head>
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="style_template.css" rel="stylesheet">
	</head>
	<body>
		<span style="margin-left: 5%; margin-top: 15%;">
		</br>
		<h1>Home</h1>
		<form action="myCollectionPage.php" method"POST">
			<button style="margin-top: 4%;" type="submit" class="btn btn-default btn-lg btn-block">
				<span class="glyphicon glyphicon-file">My collection</span>
			</button>
		</form>
		</span>
		<div style="margin-left: 5%; margin-top: 5%;">
			<?php
				$start=0;
				$limit=5;
				if(isset($_GET['id'])){
				    $id=$_GET['id'];
				    $start=($id-1)*$limit;
				}
				else{
					$id=1;
				}
				$conn=mysqli_connect("localhost", "root", "root", "gescoll") or die("error");
				$nameUser=$_SESSION['name'];
				$query="SELECT Id FROM `user` WHERE nickname='$nameUser'";
				$result=mysqli_query($conn, $query);
				while($row=mysqli_fetch_array($result)){
					$idUser=$row['Id'];
				}
				$sql="SELECT * FROM Object WHERE Id_User=$idUser AND (Selling=0 OR Selling=1) ORDER BY CreationTime DESC LIMIT $start, $limit";
				$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));
				echo("<TABLE width=100%'>");
				while($row=mysqli_fetch_array($result)){
					echo("<tr style='width:5%;'>");
					$idObj=$row['Id'];
					$queryPhoto="SELECT * FROM Photo WHERE Id_Object_Cover='$idObj'";
					$resultPhoto=mysqli_query($conn, $queryPhoto) or die(mysqli_error($conn));
					if(mysqli_num_rows($resultPhoto)==0){
						echo('<td style="border: 1px solid black; max-width:150px;" rowspan=5>No Image</td>');
					}
					while($rowPhoto=mysqli_fetch_array($resultPhoto)){
						echo('<td style="border: 1px solid black; max-width:145px;" rowspan=5><b><img src="data:image/png;base64,'.base64_encode($rowPhoto['Photo']).'" width="145px"></b></td>');
					}
					echo("</tr>");
					echo("<tr>");
					echo("<td style='border: 1px solid black;' colspan=2><b>".$row['Name']."</b></td>");
					echo("<td ><form action='editObjectPage.php' method='POST'><button name='editButton' type='submit' value=".$row['Id']." class='glyphicon glyphicon-edit btn-block'> Edit</button></form></td>");
					echo("</tr>");
					echo("<tr>");
					echo("<td style='border: 1px solid black;' rowspan=2>".$row['Desc']."</br>".$row['Color']."</td>");
					if($row['Price']==0){
						echo("<td style='border: 1px solid black;'>This object is free</td>");
					}
					else{
						$priceDecimal=number_format((float)$row['Price'], 2, '.', '');
						echo("<td style='border: 1px solid black;'>Price: ".$priceDecimal." chf</td>");
					}
					echo("<td ><form action='deleteObject.php' method='POST'><button onclick='return confirm(\"Are you sure you want to delete this item?\");' name='submitName' type='submit' value=".$row['Id']." class='glyphicon glyphicon-remove btn-block'> Remove</button></form></td>");
					echo("</tr>");
					echo("<tr>");
					if($row['Shipping']==0){
						echo("<td style='border: 1px solid black;'>No shipping</td>");
					}
					else{
						$shippingDecimal=number_format((float)$row['Shipping'], 2, '.', '');
						echo("<td style='border: 1px solid black;'>Shipping: ".$shippingDecimal." chf</td>");
					}
					echo("<td rowspan=2><form target='_blank' action='pdf.php' method='POST'><button name='pdfButton' type='submit' value=".$row['Id']." class='glyphicon glyphicon-file btn-block'> pdf</button></form></td>");
					echo("</tr>");
					echo("<tr>");
					$type=$row['Type'];
					$typeQuery="SELECT * FROM Type WHERE Id='$type'";
					$typeResult=mysqli_query($conn, $typeQuery) or die(mysqli_error($conn));
					while($rowtype=mysqli_fetch_array($typeResult)){
						$type=$rowtype['Type'];
					}
					echo("<td style='border: 1px solid black;'>type: ".$type."</td>");
					if($row['Selling']==1){
						echo("<td style='border: 1px solid black;'>Selling this object</td>");
					}
					else if($row['Selling']==0){
						echo("<td style='border: 1px solid black;'>Searching for this object</td>");
					}
					echo("</tr>");
					echo("<tr>");
					$queryPhoto="SELECT * FROM Photo WHERE Id_Object='$idObj'";
					$resultPhoto=mysqli_query($conn, $queryPhoto) or die(mysqli_error($conn));
					if(mysqli_num_rows($resultPhoto)==0){
						echo('<td style="border: 1px solid black; max-width:150px;" colspan=3>No Images</td>');
					}
					while($rowPhoto=mysqli_fetch_array($resultPhoto)){
						echo('<td style="border: 1px solid black;"><b><img src="data:image/png;base64,'.base64_encode($rowPhoto['Photo']).'" width="145px"></b></td>');
					}
					echo("</tr><tr>");
					echo("<td height=50px></td>");
					echo("</tr>");
				}
				echo("</TABLE>");
				$rows = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM Object WHERE Id_User=$idUser AND (Selling=0 OR Selling=1)"));
				$total = ceil($rows / $limit);

				if($id>1){
					echo "<a href='?id=".($id-1)."' class='button'>PREVIOUS</a>";
				}
				if($id!=$total){
					echo "<a href='?id=".($id+1)."' class='button'>NEXT</a>";
				}
				echo("<ul class='page'>");
				for($i=1; $i<=$total; $i++){
				    if($i==$id){
				        echo("<li style='list-style: none; display:inline-block;' class='current'>".$i."</li>");
				    }
				    else{
				        echo("<li style='list-style: none; display:inline-block;'><a href='?id=".$i."'>".$i."</a></li>");
				    }
				}
			?>
		</div>
	</body>
</html>