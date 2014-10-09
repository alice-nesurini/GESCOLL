<?php
 	/* Alice Mariotti-Nesurini
	 * Data creazione: 18.09.14
	 * Modifica funzionante: 08.10.14
	 * condizione query che si 
	 * crea a seconda dei dati
	 * Ricerca con i filtri
	 */
?>
<html>
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="style_template.css" rel="stylesheet">
	<head>
		<link rel="shortcut icon" href="img/icon.png">
	</head>
	<body></body>
</html>
<?php
	$conn=mysqli_connect("localhost", "root", "root", "gescoll") or die("error");
	$where="WHERE ";

	if(!($_REQUEST['name']=="")){
		$name=$_REQUEST['name'];
		$where=$where." Name LIKE '%".$name."%' AND ";
	}
	if(isset($_REQUEST['noPrice'])){
		$noPrice=$_REQUEST['noPrice'];
	}
	else if(isset($_REQUEST['priceSlider'])){
		$price=$_REQUEST['priceSlider'];
		$where=$where." Price<=".$price." AND ";
	}
	if(isset($_REQUEST['noShipping'])){
		$noShipping=$_REQUEST['noShipping'];
	}
	else if(isset($_REQUEST['shippingSlider'])){
		$shipping=$_REQUEST['shippingSlider'];
		$where=$where." Shipping<=".$shipping." AND ";
	} 
	if(!($_REQUEST['color']=="")){
		$color=$_REQUEST['color'];
		$where=$where." Color LIKE '".strtolower($color)."' AND ";
	}
	if(isset($_REQUEST['type'])){
		$type=$_REQUEST['type'];
		if(!($type=='all')){
			$where=$where." Type=".$type." AND ";
		}
	}
	//echo("</br></br>".$where."</br></br>");
	$query="SELECT * FROM Object ".$where."(Selling=0 OR Selling=1)";
	//echo($query);
	$result=mysqli_query($conn, $query) or die(mysqli_error($conn));
	echo("<TABLE width=98%>");
	while($row=mysqli_fetch_array($result)){
		echo("<tr style='width:5%;'>");
		$id=$row['Id'];
		$queryPhoto="SELECT * FROM Photo WHERE Id_Object_Cover='$id'";
		$resultPhoto=mysqli_query($conn, $queryPhoto) or die(mysqli_error($conn));
		if(mysqli_num_rows($resultPhoto)==0){
			echo('<td style="border: 1px solid black; max-width:145px;" rowspan=5>No Image</td>');
		}
		while($rowPhoto=mysqli_fetch_array($resultPhoto)){
			echo('<td style="border: 1px solid black; max-width:145px;" rowspan=5><b><img src="data:image/png;base64,'.base64_encode($rowPhoto['Photo']).'" width="145px"></b></td>');
		}
		echo("</tr>");
		echo("<tr>");
		echo("<td style='border: 1px solid black;' colspan=2><b>".$row['Name']."</b></td>");
		//echo("<td ><form action='editObjectPage.php' method='POST'><button name='editButton' type='submit' value=".$row['Id']." class='glyphicon glyphicon-edit btn-block'> Edit</button></form></td>");
		echo("</tr>");
		echo("<tr>");
		echo("<td style='border: 1px solid black;' rowspan=2>".$row['Desc']."</td>");
		if($row['Price']==0){
			echo("<td style='border: 1px solid black;'>This object is free</td>");
		}
		else{
			$priceDecimal=number_format((float)$row['Price'], 2, '.', '');
			echo("<td style='border: 1px solid black;'>Price: ".$priceDecimal." chf</td>");
		}
		//echo("<td ><form action='deleteObject.php' method='POST'><button onclick='return confirm(\"Are you sure you want to delete this item?\");' name='submitName' type='submit' value=".$row['Id']." class='glyphicon glyphicon-remove btn-block'> Remove</button></form></td>");
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
		$queryPhoto="SELECT * FROM Photo WHERE Id_Object='$id'";
		$resultPhoto=mysqli_query($conn, $queryPhoto) or die(mysqli_error($conn));
		if(mysqli_num_rows($resultPhoto)==0){
			echo('<td style="border: 1px solid black; max-width:145px;" colspan=3>No Images</td>');
		}
		while($rowPhoto=mysqli_fetch_array($resultPhoto)){
			echo('<td style="border: 1px solid black;"><b><img src="data:image/png;base64,'.base64_encode($rowPhoto['Photo']).'" width="145px"></b></td>');
		}
		echo("</tr><tr>");
		echo("<td height=50px></td>");
		echo("</tr>");
	}
	echo("</table>");
?>