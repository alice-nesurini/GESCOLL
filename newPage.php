<html>
	<head>
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="style_template.css" rel="stylesheet">
	</head>
	<body bgcolor="#C2EBFF">
		<center>
			<div style="margin-top:10%;">
				<form action="new.php" method="POST" enctype="multipart/form-data">
					<input type="text" class="form-control" name="name" placeholder="Name" style="width:50%;">
					<input type="text" class="form-control" name="description" placeholder="Description" style="width:50%;">
					<input type="text" class="form-control" name="color" placeholder="Color" style="width:50%;">
					<input type="number" step="0.01" min="0" max="2147483646" class="form-control" name="price" placeholder="Price" style="width:50%;">
					<input type="number" step="0.01" min="0" max="2147483646" class="form-control" name="shipping" placeholder="Shipping" style="width:50%;">
					<input type="number" step="0.01" min="0" max="2147483646" class="form-control" name="cod" placeholder="Cod" style="width:50%;">
					</br>
					<select name="selling">
			       		<option value="Selling">Selling</option>
			       		<option value="Searching">Searching</option>
			       	</select></br>
			       	<select name="type">
			       	<?php
			       		$conn=mysqli_connect("localhost", "root", "root", "gescoll") or die("error");
						$sql="SELECT `Type` FROM `Type`";
						$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));
						while($row=mysqli_fetch_array($result)){
							echo("<option value=".$row['Type'].">".$row['Type']."</option>");
						}
						echo("</select>");
					?>
					</br></br>
					<label>Cover: </label><input type="file" name="image"/>
					</br>
					</br>
					<label>Other images (multiple selection): </label><input type="file" name="otherImages[]" multiple="multiple"/>
					</br>
			       	<button type="submit" class="btn btn-default">New</button>
			       	<button type="button" class="btn btn-default" onClick="window.open('panel.php', '_parent')">Cancel</button>
				</form>
			</div>
		</center>
	</body>
</html>