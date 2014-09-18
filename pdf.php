<?php
	/* Alice Mariotti-Nesurin
	 * 18.09.14
	 * stampa PDF degli oggetti
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
	//id
	//$pdf->Cell(190, 10, $id, 1, 1, 'C');
	//
	$conn=mysqli_connect("localhost", "root", "root", "gescoll");
	$objectData="SELECT * FROM Object WHERE Id='$id'";
	$result=mysqli_query($conn, $objectData);
	while($row=mysqli_fetch_array($result)){
		$objName=$row['Name'];
		$objDesc=$row['Desc'];
		$objColor=$row['Color'];
		$objPrice=$row['Price'];
		$objShipping=$row['Shipping'];
		$objSelling=$row['Selling'];
		$objCod=$row['Cod'];
		$objIdUser=$row['Id_User'];
		$objType=$row['Type'];
	}
	$userData="SELECT * FROM `User` WHERE Id='$objIdUser'";
	$result=mysqli_query($conn, $userData);
	while($row=mysqli_fetch_array($result)){
		$userName=$row['Name'];
		$userLastname=$row['lastname'];
		$userNickname=$row['Nickname'];
		$userEmail=$row['Email'];
		$userNation=$row['Nation'];
		$userAddress=$row['Address'];
	}
	$typeData="SELECT * FROM `Type` WHERE Id='$objType'";
	$result=mysqli_query($conn, $typeData);
	while($row=mysqli_fetch_array($result)){
		$typeType=$row['Type'];
	}
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