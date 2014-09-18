<?php
 	/* Alice Mariotti-Nesurini
	 * 18.09.14
	 * Ricerca con i filtri
	 */
	$conn=mysqli_connect("localhost", "root", "root", "gescoll") or die("error");
	$name=$_REQUEST['name'];

	$color=$_REQUEST['color'];
	$type=$_REQUEST['type'];

	if(isset($_REQUEST['noPrice'])){
		$noPrice=$_REQUEST['noPrice'];
		echo($noPrice."</br>");
	}
	else{
		$priceSlider=$_REQUEST['priceSlider'];
		echo($priceSlider."</br>");
	}
	if(isset($_REQUEST['noShipping'])){
		$noShipping=$_REQUEST['noShipping'];
		echo($noShipping."</br>");
	}
	else{
		$shippingSlider=$_REQUEST['shippingSlider'];
		echo($shippingSlider."</br>");
	}

	echo($name."</br>");
	/*echo($noPrice."</br>");
	echo($noShipping."</br>");
	echo($priceSlider."</br>");
	echo($shippingSlider."</br>");*/
	echo($color."</br>");
	echo($type."</br>");
?>