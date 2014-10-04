<?php
	/* Alice Mariotti-Nesurini
	 * 01.10.14
	 * stampa PDF della collezione
	 * di un utente
	 * con classe FPDF
	 * http://www.fpdf.org/ 
	 */
	require('fpdf.php');
	$pdf=new FPDF();
	$pdf->AddPage();
	$pdf->SetFont('courier');
	$pdf->Cell(190, 10, 'Oggetto collezione', 1, 1, 'C');

	//***************QUERIES******************//
	$id=$_REQUEST['pdfButton'];
	//
	$conn=mysqli_connect("localhost", "root", "root", "gescoll") or die("error");
	$nameUser=$_SESSION['name'];
	$query="SELECT Id FROM `user` WHERE nickname='$nameUser'";
	$result=mysqli_query($conn, $query);
	while($row=mysqli_fetch_array($result)){
		$idUser=$row['Id'];
	}
	$sql="SELECT * FROM Object WHERE Id_User=$idUser";
	$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));
	/*while($row=mysqli_fetch_array($result)){
		$id=$row['Id'];
		$queryPhoto="SELECT * FROM Photo WHERE Id_Object_Cover='$id'";
		$resultPhoto=mysqli_query($conn, $queryPhoto) or die(mysqli_error($conn));
		if(mysqli_num_rows($resultPhoto)==0){
			echo('<td style="border: 1px solid black; max-width:150px;" rowspan=5>No Image</td>');
		}
		while($rowPhoto=mysqli_fetch_array($resultPhoto)){
			echo('<td style="border: 1px solid black; max-width:150px;" rowspan=5><b><img src="data:image/png;base64,'.base64_encode($rowPhoto['Photo']).'" width="150px"></b></td>');
		}
		echo("<td style='border: 1px solid black;' colspan=2><b>".$row['Name']."</b></td>");
		echo("<td style='border: 1px solid black;' rowspan=2>".$row['Desc']."</td>");
		if($row['Price']==0){
			echo("<td style='border: 1px solid black;'>This object is free</td>");
		}
		else{
			echo("<td style='border: 1px solid black;'>Price: ".$row['Price']." fr.-</td>");
		}
		if($row['Shipping']==0){
			echo("<td style='border: 1px solid black;'>No shipping</td>");
		}
		else{
			echo("<td style='border: 1px solid black;'>Shipping: ".$row['Shipping']." fr.-</td>");
		}
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
	}*/
	//****************************************//
	$pdf->Ln();
	$pdf->MultiCell(190, 10, "Name: ".$objName, 1, 1);
	$y=$pdf->GetY();
	$pdf->MultiCell(100, 30, "Description: ".$objDesc, 1, 1);
	$pdf->SetY($y);
	$pdf->SetX(110);
	$pdf->MultiCell(90, 10, "Code: ".$objCod, 1, 1);
	$pdf->SetX(110);
	$pdf->MultiCell(90, 10, "Price: ".$objPrice, 1, 1);
	$pdf->SetX(110);
	$pdf->MultiCell(90, 10, "Shipping: ".$objShipping, 1, 1);
	if($objSelling==1){
		$pdf->MultiCell(190, 10, "Selling this object", 1, 1);
	}
	else if($objSelling==0){
		$pdf->MultiCell(190, 10, "Searching for this object", 1, 1);
	}
	$pdf->MultiCell(190, 10, 'Type: '.$typeType, 1, 1);
	$pdf->Ln();
	$pdf->Cell(190, 10, 'Object belongs to: '.$userLastname.", ".$userName, 1, 1);
	$pdf->Cell(190, 10, 'Owner info: ', 1, 1);
	$pdf->MultiCell(190, 10, 'Email: '.$userEmail, 1, 1);
	$pdf->MultiCell(190, 10, 'Nation: '.$userNation, 1, 1);
	$pdf->MultiCell(190, 10, 'Address: '.$userAddress, 1, 1);
	//$pdf->MultiCell(190, 10, $objName."\n".$objDesc."\n".$objColor."\n".$objPrice."\n".$objShipping."\n".$objSelling."\n".$objCod);
	$pdf->Output();
?>
