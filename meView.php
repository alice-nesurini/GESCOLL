<?php
	session_start();
	/* Alice Mariotti-Nesurini
	 * 02.10.14
	 * Pagina visualizzazione dat utente
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
				echo("<table>");
				while($row=mysqli_fetch_array($result)){
					echo("<tr>");
					echo("<td>Name: </td><td style='text-align:center;'>".$row['Name']."</br>");
					echo("</tr>");
					echo("<tr>");
					echo("<td>Lastname: </td><td style='text-align:center;'>".$row['lastname']."</td>");
					echo("</tr>");
					echo("<tr>");
					echo("<td>Nickname: </td><td style='text-align:center;'>".$row['Nickname']."</td>");
					echo("</tr>");
					echo("<tr>");
					echo("<td>Email: </td><td style='text-align:center;'>".$row['Email']."</td>");
					echo("</tr>");
					echo("<tr>");
					echo("<td>Nation: </td><td style='text-align:center;'>".$row['Nation']."</td>");
					echo("</tr>");
					echo("<tr>");
					echo("<td>Address: </td><td style='text-align:center;'>".$row['Address']."</td>");
					echo("</tr>");
				}
				echo("</table>");
				echo("</br>");
				echo("<form action='meOptions.php' method='POST'><button name='submitUpdate' type='submit' class='glyphicon glyphicon-edit btn-sm'> Edit</button><button name='cancelBtn' onClick='window.open(\"panel.php\", \"_parent\")' class='glyphicon glyphicon-remove btn-sm'> Cancel</button></form>");
			?>
		</div>
	</body>
</html>