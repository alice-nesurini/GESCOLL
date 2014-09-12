<?php
	session_start();
	$name=$_SESSION['name'];
	$password=$_SESSION['password'];
	//echo("Registered user: ".$name." ".hash("sha256", $password));
?>
<html>
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="style_template.css" rel="stylesheet">
	<head></head>
	<body>
		<script type="text/javascript">
		function showValuePrice(newValue){
			//fonte: http://webtutsdepot.com/2010/04/24/html-5-slider-input-tutorial/
			document.getElementById("rangePrice").innerHTML=newValue;
		}
		function showValueShipping(newValue){
			//fonte: http://webtutsdepot.com/2010/04/24/html-5-slider-input-tutorial/
			document.getElementById("rangeShipping").innerHTML=newValue;
		}
		</script>
		<div id="container">
			<div id="header">
				<button type="button" class="btn btn-default btn-lg">
					<span class="glyphicon glyphicon-home"></span>
				</button>
				<button type="button" class="btn btn-default btn-lg">
					<span class="glyphicon glyphicon-search">Searching for</span>
				</button>
				<button type="button" class="btn btn-default btn-lg">
					<span class="glyphicon glyphicon-shopping-cart">Selling</span>
				</button>
				<button type="button" class="btn btn-default btn-lg">
					<span class="glyphicon glyphicon-user"><?php echo($name);?></span>
				</button>
			</div>
			
			<div id="navigation">
				<div>
					FILTERS
					<?php
						$conn=mysqli_connect("localhost", "root", "root", "gescoll") or die("error");
						$maxQuery="SELECT MAX(Price) FROM Object";
						$result=mysqli_query($conn, $maxQuery) or die(mysqli_error($conn));
						while($row=mysqli_fetch_array($result)){
							$maxPrice=($row['MAX(Price)']);
						}
						$maxQuery="SELECT MAX(Shipping) FROM Object";
						$result=mysqli_query($conn, $maxQuery) or die(mysqli_error($conn));
						while($row=mysqli_fetch_array($result)){
							$maxShipping=($row['MAX(Shipping)']);
						}
					?>
					<form action="" method="POST">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Name"/>
						</div>

						<div>Price</div>
						<input type="range" min="0" max=<?php echo($maxPrice); ?> onchange="showValuePrice(this.value)"/>
						<span id="rangePrice"><?php echo($maxPrice/2); ?></span>

						<div>Shipping</div>
						<input type="range" min="0" max=<?php echo($maxShipping); ?> onchange="showValueShipping(this.value)"/>
						<span id="rangeShipping"><?php echo($maxShipping/2); ?></span></BR></BR>

						Pick a color: <input type="color" name="favcolor"/>

						<?php
							$sql="SELECT `Type` FROM `Type`";
							$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));
							echo("<select>");
							while($row=mysqli_fetch_array($result)){
								echo("<option value=".$row['Type'].">".$row['Type']."</option>");
							}
							echo("</select>");
						?>
						<button type="submit" class="btn btn-default">Search</button>
					</form>
				</div>
			</div>
			<div id="extra">
				
			</div>
			<div id="footer">
				<center><p>&#169; Alice Nesurini - September - October 2014</p></center>
			</div>
		</div>
	</body>
</html>
<?php
	/*$conn=mysqli_connect("localhost", "root", "root", "gescoll") or die("error");
	$sql="SELECT * FROM User";
	$ris=mysqli_query($conn, $sql) or die(mysqli_error($conn));
	echo($sql);
	$allUser="SELECT * FROM User";*/
?>