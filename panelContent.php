<?php
	session_start();
	/* Alice Mariotti-Nesurini
	 * 17.09.14
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
			My objects
		</span>
		<div style="margin-left: 5%; margin-top: 5%;">
			<?php
				$conn=mysqli_connect("localhost", "root", "root", "gescoll") or die("error");
				$nameUser=$_SESSION['name'];
				$query="SELECT Id FROM `user` WHERE nickname='$nameUser'";
				$result=mysqli_query($conn, $query);
				while($row=mysqli_fetch_array($result)){
					$idUser=$row['Id'];
				}
				$sql="SELECT * FROM Object WHERE Id_User=$idUser";
				$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));
				echo("<TABLE width=100%>");
				while($row=mysqli_fetch_array($result)){
					echo("<tr>");
					echo("<td style='border: 1px solid black;' colspan=2><b>".$row['Name']."</b></td>");
					echo("</tr>");
					echo("<tr>");
					echo("<td style='border: 1px solid black;' rowspan=2>".$row['Desc']."</td>");
					if($row['Price']==0){
						echo("<td style='border: 1px solid black;'>This object is free</td>");
					}
					else{
						echo("<td style='border: 1px solid black;'>Price: ".$row['Price']." fr.-</td>");
					}
					echo("<td ><form action='deleteObject.php' method='POST'><button name='submitName' type='submit' value=".$row['Id']." class='glyphicon glyphicon-remove'></button></form></td>");
					echo("</tr>");
					echo("<tr>");
					if($row['Shipping']==0){
						echo("<td style='border: 1px solid black;'>No shipping</td>");
					}
					else{
						echo("<td style='border: 1px solid black;'>Shipping: ".$row['Shipping']." fr.-</td>");
					}
					echo("<td rowspan=2><form target='_blank' action='pdf.php' method='POST'><button name='pdfButton' type='submit' value=".$row['Id']." class='glyphicon glyphicon-file'></button></form></td>");
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
					echo("<td height=10></td>");
					echo("</tr>");
				}
				echo("</TABLE>");
			?>
		</div>
	</body>
</html>