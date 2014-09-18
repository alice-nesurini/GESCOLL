<?php
	session_start();
	/* Alice Mariotti-Nesurini
	 * 17.09.14
	 * Visualizzazione degli oggeti che sono cercati
	 */
?>
<html>
	<head>
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="style_template.css" rel="stylesheet">
	</head>
	<body></body>
</html>
<?php
	$_SESSION['searchIn']="search";
	echo("<div style='margin-left: 5%; margin-top: 5%''>");
	$conn=mysqli_connect("localhost", "root", "root", "gescoll") or die("error");
	$nameUser=$_SESSION['name'];
	$query="SELECT * FROM `object` WHERE selling=0";
	$result=mysqli_query($conn, $query);
	echo("<TABLE width=100%>");
	while($row=mysqli_fetch_array($result)){
		echo("<tr>");
		echo("<td style='border: 1px solid black;' colspan=2><b>".$row['Name']."</b></td>");
		echo("</tr>");
		echo("<tr>");
		echo("<td style='border: 1px solid black;' rowspan=2>".$row['Desc']."</td>");
		echo("<td style='border: 1px solid black;'>Price: ".$row['Price']."</td>");
		echo("</tr>");
		echo("<tr>");
		if($row['Shipping']==0){
			echo("<td style='border: 1px solid black;'>No shipping</td>");
		}
		else{
			echo("<td style='border: 1px solid black;'>Shipping: ".$row['Shipping']." fr.-</td>");
		}
		echo("</tr>");
		echo("<tr>");
		$type=$row['Type'];
		$typeQuery="SELECT * FROM Type WHERE Id='$type'";
		$typeResult=mysqli_query($conn, $typeQuery) or die(mysqli_error($conn));
		while($rowtype=mysqli_fetch_array($typeResult)){
			$type=$rowtype['Type'];
		}
		echo("<td style='border: 1px solid black;'>type: ".$type."</td>");
		echo("<td style='border: 1px solid black;'>Searching for this object</td>");
		echo("</tr>");
		echo("<tr>");
		echo("<td height=10></td>");
		echo("</tr>");
	}
	echo("</TABLE>");
	echo("</div>");
?>