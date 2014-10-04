<html>
	<head>
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="style_template.css" rel="stylesheet">
	</head>
	<body>
		<center>
			<div style="margin-top:10%;">
				<form action="newType.php" method="POST">
					<input type="text" class="form-control" name="nameType" placeholder="Name" style="width:50%;">
					</br>
			       	<button type="submit" class="btn btn-default">New</button>
			       	<button type="button" class="btn btn-default" onClick="window.open('panel.php', '_parent')">Cancel</button>
				</form>
			</div>
		</center>
	</body>
</html>