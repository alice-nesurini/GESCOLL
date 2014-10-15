<?php
	session_start();
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

	if(isset($_REQUEST['name'])){
		$_SESSION['nameObj']=$_REQUEST['name'];
	}
	if(isset($_REQUEST['noPrice'])){
		$_SESSION['noPrice']=$_REQUEST['noPrice'];
	}
	if(isset($_REQUEST['priceSlider'])){
		$_SESSION['priceSlider']=$_REQUEST['priceSlider'];
	}
	if(isset($_REQUEST['noShipping'])){
		$_SESSION['noShipping']=$_REQUEST['noShipping'];
	}
	if(isset($_REQUEST['shippingSlider'])){
		$_SESSION['shippingSlider']=$_REQUEST['shippingSlider'];
	}
	if(isset($_REQUEST['color'])){
		$_SESSION['color']=$_REQUEST['color'];
	}
	if(isset($_REQUEST['type'])){
		$_SESSION['type']=$_REQUEST['type'];
	}
	if(isset($_REQUEST['selling'])){
		$_SESSION['selling']=$_REQUEST['selling'];
	}


	if(!($_SESSION['nameObj']=="")){
		$name=$_SESSION['nameObj'];
		$where=$where." Name LIKE '%".$name."%' AND ";
	}
	if(isset($_SESSION['noPrice'])){
		$noPrice=$_SESSION['noPrice'];
	}
	else if(isset($_SESSION['priceSlider'])){
		$price=$_SESSION['priceSlider'];
		$where=$where." Price<=".$price." AND ";
	}
	if(isset($_SESSION['noShipping'])){
		$noShipping=$_SESSION['noShipping'];
	}
	else if(isset($_SESSION['shippingSlider'])){
		$shipping=$_SESSION['shippingSlider'];
		$where=$where." Shipping<=".$shipping." AND ";
	} 
	/*if(!($_REQUEST['color']=="")){
		$color=$_REQUEST['color'];
		$where=$where." Color LIKE '".strtolower($color)."' AND ";
	}*/
	if(isset($_SESSION['color'])){
		$color=$_SESSION['color'];
		if(!($color=='all')){
			$where=$where." Color='".$color."' AND ";
		}
	}
	if(isset($_SESSION['type'])){
		$type=$_SESSION['type'];
		if(!($type=='all')){
			$where=$where." Type=".$type." AND ";
		}
	}
	if(isset($_SESSION['selling'])){
		$selling=$_SESSION['selling'];
		if(!($selling=='all')){
			$where=$where." Selling=".$selling." AND ";
		}
		else{
			$where=$where." (Selling=0 OR Selling=1) AND ";
		}
	}
	$start=0;
	$limit=5;
	if(isset($_GET['id'])){
	    $id=$_GET['id'];
	    $start=($id-1)*$limit;
	}
	else{
		$id=1;
	}
	//echo("</br></br>".$where."</br></br>");
	$query="SELECT * FROM Object ".$where."1=1 ORDER BY CreationTime DESC LIMIT $start, $limit";
	//echo($query);
	$result=mysqli_query($conn, $query) or die(mysqli_error($conn));
	echo("<TABLE width=98%>");
	if(mysqli_num_rows($result)>0){
		while($row=mysqli_fetch_array($result)){
			echo("<tr style='width:5%;'>");
			$idobj=$row['Id'];
			$queryPhoto="SELECT * FROM Photo WHERE Id_Object_Cover='$idobj'";
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
			echo("<td style='border: 1px solid black;' rowspan=2>".$row['Desc']."</br>".$row['Color']."</td>");
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
			$queryPhoto="SELECT * FROM Photo WHERE Id_Object='$idobj'";
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
	}
	else{
		echo("<h3>No result found</h3>");
	}
	echo("</table>");
	$rows = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM Object ".$where."(Selling=0 OR Selling=1)"));
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