<?php
 	/* Alice Mariotti-Nesurini
	 * Data creazione: 18.09.14
	 * Modifica funzionante: 02.10.14
	 * condizione query che si 
	 * crea a seconda dei dati
	 * Ricerca con i filtri
	 */
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
		$where=$where." Price<".$price." AND ";
	}
	if(isset($_REQUEST['noShipping'])){
		$noShipping=$_REQUEST['noShipping'];
	}
	else if(isset($_REQUEST['shippingSlider'])){
		$shipping=$_REQUEST['shippingSlider'];
		$where=$where." Shipping<".$shipping." AND ";
	} 
	if(!($_REQUEST['color']=="")){
		$color=$_REQUEST['color'];
		$where=$where." Color LIKE '".strtolower($color)."' AND ";
	}
	if(isset($_REQUEST['type'])){
		$type=$_REQUEST['type'];
		$where=$where." Type=".$type." AND ";
	}
	echo("</br></br>".$where."</br></br>");
	$query="SELECT * FROM Object ".$where."1=1";
	echo($query);
	$result=mysqli_query($conn, $query) or die(mysqli_error($conn));
	while($row=mysqli_fetch_array($result)){
		echo("<h3>".$row['Name']."</h3>");
		echo($row['Type']);
		echo($row['Color']);
		echo($row['Price']);
		echo($row['Shipping']);
	}
?>