<?php
	/* Alice Mariotti-Nesurini
	 * 01.10.14
	 * stampa PDF della collezione
	 * di un utente
	 * con classe FPDF
	 * http://www.fpdf.org/ 
	 */
	session_start();
	require('fpdf.php');
	$pdf=new FPDF();
	$pdf->AddPage();
	$pdf->SetFont('courier');
	$pdf->Cell(190, 10, 'My Collection', 1, 1, 'C');

	//***************QUERIES******************//
	//$id=$_REQUEST['pdfButton'];
	//
	$conn=mysqli_connect("localhost", "root", "root", "gescoll") or die("error");
	$nameUser=$_SESSION['name'];
	$query="SELECT Id FROM `user` WHERE nickname='$nameUser'";
	$result=mysqli_query($conn, $query);
	while($row=mysqli_fetch_array($result)){
		$idUser=$row['Id'];
	}
	$userData="SELECT * FROM `User` WHERE nickname='$nameUser'";
	$resultUser=mysqli_query($conn, $userData);
	while($rowUser=mysqli_fetch_array($resultUser)){
		$userName=$rowUser['Name'];
		$userLastname=$rowUser['lastname'];
		$userNickname=$rowUser['Nickname'];
		$userEmail=$rowUser['Email'];
		$userNation=$rowUser['Nation'];
		$userAddress=$rowUser['Address'];
	}
	$pdf->Ln();
	$pdf->Cell(190, 10, 'Owner Info: '.$userLastname.", ".$userName, 1, 1);
	$pdf->MultiCell(190, 10, 'Email: '.$userEmail, 1, 1);
	$pdf->MultiCell(190, 10, 'Nation: '.$userNation, 1, 1);
	$pdf->MultiCell(190, 10, 'Address: '.$userAddress, 1, 1);
	$sql="SELECT * FROM Object WHERE Id_User=$idUser AND Selling=2";
	$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));
	while($row=mysqli_fetch_array($result)){
		$id=$row['Id'];
		$queryPhoto="SELECT * FROM Photo WHERE Id_Object_Cover='$id'";
		$resultPhoto=mysqli_query($conn, $queryPhoto) or die(mysqli_error($conn));
		if(mysqli_num_rows($resultPhoto)==0){
			$cover="No image";
		}
		while($rowPhoto=mysqli_fetch_array($resultPhoto)){
			$cover=base64_encode($rowPhoto['Photo']);
		}
		$objName=$row['Name'];
		$objDesc=$row['Desc'];
		$objCod=$row['Cod'];
		$objIdUser=$row['Id'];
		$objColor=$row['Color'];
		$type=$row['Type'];
		$typeQuery="SELECT * FROM Type WHERE Id='$type'";
		$typeResult=mysqli_query($conn, $typeQuery) or die(mysqli_error($conn));
		while($rowtype=mysqli_fetch_array($typeResult)){
			$objType=$rowtype['Type'];
		}
		//****************************************//
		$pdf->Ln();
		//$pdf->Image($cover, 5, 70, 33.78);
		//$pdf->Image($cover,10,10,-300);
		//$pdf->Cell( 40, 40, $pdf->Image($cover, $pdf->GetX(), $pdf->GetY(), 33.78, 'PNG'), 0, 0, 'L', false );
		$pdf->MultiCell(190, 10, "Name: ".$objName, 1, 1);
		$y=$pdf->GetY();
		$pdf->MultiCell(100, 30, "Description: ".$objDesc.", ".$objColor, 1, 1);
		$pdf->SetY($y);
		$pdf->SetX(110);
		$pdf->MultiCell(90, 10, "Code: ".$objCod, 1, 1);
		$pdf->SetX(110);
		$pdf->MultiCell(90, 10, 'Type: '.$objType, 1, 1);
		$pdf->Ln();
		$y=$pdf->GetY();
		if($y>190){
			$pdf->AddPage();
		}
	}
	$pdf->Output();
?>
