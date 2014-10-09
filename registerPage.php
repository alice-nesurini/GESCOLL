<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <div class="boxCenter">
            <div class="header">
                <div>
                    <!--IMG<img class="" src="img/.png"/>-->
                </div>
                <div class="titleHeader">
                    Register
                </div>
            </div>
            <div class="registerButtons">
	            <form action="register.php" method="POST">
	                <input type="text" class="form-control" name="name" placeholder="Name*" style="width:50%;">
	                <input type="text" class="form-control" name="lastname" placeholder="lastname*" style="width:50%;">
	                <input type="text" class="form-control" name="nickname" placeholder="Nickname (for login)*" style="width:50%;">
	                <input type="password" class="form-control" name="password" placeholder="Password*" style="width:50%;">
	                <input type="email" class="form-control" name="email" placeholder="Email*" style="width:50%;">
	                <input type="text" class="form-control" name="nation" placeholder="Nation*" style="width:50%;">
	                <input type="text" class="form-control" name="address" placeholder="Address*" style="width:50%;">
	                <button type="submit" class="btn btn-default">Register</button>
	            </form>
                <form action="index.html" method="POST">
                    <button type="submit" class="btn btn-default">Cancel</button>
                </form>
                <?php
                    if(isset($_SESSION['nicknameExists'])){
                        $exists=$_SESSION['nicknameExists'];
                        if($exists==true){
                            echo("<center><div><font color='red'>Your Nickname already exists</font></div></centrer>");
                            $_SESSION['nicknameExists']=false;
                        }
                    }
                    if(isset($_SESSION['invalidData'])){
                        $exists=$_SESSION['invalidData'];
                        if($exists==true){
                            echo("<center><div><font color='red'>Your information are invalid</br>Please be sure you have complied all the fields</font></div></centrer>");
                            $_SESSION['invalidData']=false;
                        }
                    }
                ?>
	        </div>
        </div>
    </body>
</html>