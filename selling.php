<?php
	session_start();
	/* Alice Mariotti-Nesurini
	 * 17.09.14
	 * Visualizzazione degli oggetti
	 * che sono venduti
	 */
?>
<html>
	<head>
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="style_template.css" rel="stylesheet">
	</head>
	<body>
		<h1>Selling</h1>
	</body>
</html>
<?php
	$_SESSION['searchIn']="selling";
	echo("<div style='margin-left: 5%; margin-top: 5%''>");
	$conn=mysqli_connect("localhost", "root", "root", "gescoll") or die("error");
	$nameUser=$_SESSION['name'];
	$start=0;
	$limit=5;
	if(isset($_GET['id'])){
	    $id=$_GET['id'];
	    $start=($id-1)*$limit;
	}
	else{
		$id=1;
	}
	$query="SELECT * FROM `object` WHERE selling=1 ORDER BY CreationTime DESC LIMIT $start, $limit";
	$result=mysqli_query($conn, $query);
	echo("<TABLE width=100%>");
	while($row=mysqli_fetch_array($result)){
		echo("<tr style='width:5%;'>");
		$idObj=$row['Id'];
		$queryPhoto="SELECT * FROM Photo WHERE Id_Object_Cover='$idObj'";
		$resultPhoto=mysqli_query($conn, $queryPhoto) or die(mysqli_error($conn));
		if(mysqli_num_rows($resultPhoto)==0){
			echo('<td style="border: 1px solid black; max-width:150px;" rowspan=5>No Image</td>');
		}
		while($rowPhoto=mysqli_fetch_array($resultPhoto)){
			echo('<td style="border: 1px solid black; max-width:150px;" rowspan=5><b><img src="data:image/png;base64,'.base64_encode($rowPhoto['Photo']).'" width="150px"></b></td>');
		}
		echo("</tr>");
		echo("<tr>");
		echo("<td style='border: 1px solid black;' colspan=2><b>".$row['Name']."</b></td>");
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
		//$priceDecimal=number_format((float)$row['Price'], 2, '.', '');
		//echo("<td style='border: 1px solid black;'>Price: ".$row['Price'].".- chf</td>");
		echo("</tr>");
		echo("<tr>");
		if($row['Shipping']==0){
			echo("<td style='border: 1px solid black;'>No shipping tax</td>");
		}
		else{
			$shippingDecimal=number_format((float)$row['Shipping'], 2, '.', '');
			echo("<td style='border: 1px solid black;'>Shipping: ".$row['Shipping']." chf</td>");
		}
		echo("<td rowspan=2><form target='_blank' action='pdf.php' method='POST'><button name='pdfButton' type='submit' value=".$row['Id']." class='glyphicon glyphicon-file'>pdf</button></form></td>");
		echo("</tr>");
		echo("<tr>");
		$type=$row['Type'];
		$typeQuery="SELECT * FROM Type WHERE Id='$type'";
		$typeResult=mysqli_query($conn, $typeQuery) or die(mysqli_error($conn));
		while($rowtype=mysqli_fetch_array($typeResult)){
			$type=$rowtype['Type'];
		}
		echo("<td style='border: 1px solid black;'>type: ".$type."</td>");
		echo("<td style='border: 1px solid black;'>Selling this object</td>");
		echo("</tr>");
		echo("<tr>");
		$queryPhoto="SELECT * FROM Photo WHERE Id_Object='$idObj'";
		$resultPhoto=mysqli_query($conn, $queryPhoto) or die(mysqli_error($conn));
		if(mysqli_num_rows($resultPhoto)==0){
			echo('<td style="border: 1px solid black; max-width:140px;" colspan=3>No Images</td>');
		}
		while($rowPhoto=mysqli_fetch_array($resultPhoto)){
			echo('<td style="border: 1px solid black;"><b><img src="data:image/png;base64,'.base64_encode($rowPhoto['Photo']).'" width="145px"></b></td>');
		}
		echo("</tr><tr>");
		echo("<td height=50px></td>");
		echo("</tr>");
	}
	echo("</TABLE>");
	$rows = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `object` WHERE selling=1"));
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
	echo("</div>");
?>