<?php
	session_start();
	$name=$_SESSION['name'];
	$password=$_SESSION['password'];
	if(!(isset($_SESSION['name'])) && !(isset($_SESSION['password']))){
		header("Location: login.php");
	}
	/* Alice Mariotti-Nesurini
	 * 11.09.14
	 * Pagina principale
	 */
?>
<html>
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="style_template.css" rel="stylesheet">
	<head>
		<link rel="shortcut icon" href="img/icon.png">
	</head>
	<body>
		<script type="text/javascript">
		function showValuePrice(newValue){
			//fonte: http://webtutsdepot.com/2010/04/24/html-5-slider-input-tutorial/
			document.getElementById("rangePrice").innerHTML=newValue;
		}
		function showValueShipping(newValue){
			document.getElementById("rangeShipping").innerHTML=newValue;
		}
		function setURL(url){
			document.getElementById('frameContent').src=url;
		}
		</script>
		<div id="container">
			<div id="header">
				<button type="button" class="btn btn-default btn-lg" onClick="setURL('panelContent.php')">
					<span class="glyphicon glyphicon-home"></span>
				</button>
				<button type="button" class="btn btn-default btn-lg" onClick="setURL('searchingFor.php')">
					<span class="glyphicon glyphicon-search">Searching for</span>
				</button>
				<button type="button" class="btn btn-default btn-lg" onClick="setURL('selling.php')">
					<span class="glyphicon glyphicon-shopping-cart">Selling</span>
				</button>
				<button type="button" class="btn btn-default btn-lg" onClick="setURL('meOptions.php')">
					<span class="glyphicon glyphicon-user"><?php echo($name);?></span>
				</button>
				<button type="button" class="btn btn-default btn-lg" onClick="window.open('logout.php', '_parent')">
					<span class="glyphicon glyphicon-log-out">Logout</span>
				</button>
			</div>
			
			<div id="navigation" style="margin-top:2%;">
				<button type="submit" class="btn btn-default btn-lg" onClick="setURL('newPage.php')">
					<span class="glyphicon glyphicon-upload">New object</span>
				</button>
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
					<form action="filterSearch.php" method="POST">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Name" name="name"/>
						</div>

						No max price <input type="checkbox" name="noPrice">
						<div>Max price</div>
						<input type="range" min="0" max=<?php echo($maxPrice); ?> name="priceSlider" onchange="showValuePrice(this.value)"/>
						<span id="rangePrice"><?php echo($maxPrice/2); ?></span></br>

						No max shipping <input type="checkbox" name="noShipping">
						<div>Shipping</div>
						<input type="range" min="0" max=<?php echo($maxShipping); ?> name="shippingSlider" onchange="showValueShipping(this.value)"/>
						<span id="rangeShipping"><?php echo($maxShipping/2); ?></span></BR></BR>

						Pick a color: <input type="color" name="color"/>

						<?php
							$sql="SELECT `Type` FROM `Type`";
							$result=mysqli_query($conn, $sql) or die(mysqli_error($conn));
							echo("<select name='type'>");
							while($row=mysqli_fetch_array($result)){
								echo("<option value=".$row['Type'].">".$row['Type']."</option>");
							}
							echo("</select>");
						?>
						<button type="submit" class="btn btn-default">Search</button>
					</form>
				</div>
			</div>
			<div class="content">
				<div>
					<iframe src="panelContent.php" width=50% height=100% frameBorder="0" id="frameContent" name="frameContent">Browser not compatible with iFrame.</iframe>
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