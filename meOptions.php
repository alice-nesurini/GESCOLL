<?php
	session_start();
	/* Alice Mariotti-Nesurini
	 * 17.09.14
	 * Gestione opzioni utente
	 */
?>
<html>
	<head>
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="style_template.css" rel="stylesheet">
	</head>
	<body>
		<div style="margin-left: 5%; margin-top: 5%;">
			<?php
				$conn=mysqli_connect("localhost", "root", "root", "gescoll") or die("error");
				$nameUser=$_SESSION['name'];
				$query="SELECT * FROM `user` WHERE nickname='$nameUser'";
				$result=mysqli_query($conn, $query);
				while($row=mysqli_fetch_array($result)){
					echo("<form action='updateUser.php' method='POST'>");
					echo("Name: <input type='text' class='form-control' name='name' value='".$row['Name']."' style='width:50%;'></br>");
					echo("Lastname: <input type='text' class='form-control' name='lastname' value='".$row['lastname']."' style='width:50%;'></br>");
					echo("Nickname: <input type='text' class='form-control' name='nickname' value='".$row['Nickname']."' style='width:50%;'></br>");
					echo("Email: <input type='email' class='form-control' name='email' value='".$row['Email']."' style='width:50%;'></br>");
					echo("Nation: <input type='text' class='form-control' name='nation' value='".$row['Nation']."' style='width:50%;'></br>");
					echo("Address: <input type='text' class='form-control' name='address' value='".$row['Address']."' style='width:50%;'></br>");
					echo("<button name='submitUpdate' type='submit' class='glyphicon glyphicon-ok btn-sm'>Save</button>");
					echo("<button name='cancelBtn' onClick='window.open(\"panel.php\", \"_parent\")' class='glyphicon glyphicon-remove btn-sm'>Cancel</button>");
					echo("</form>");
				}
			?>
		</div>
	</body>
</html>