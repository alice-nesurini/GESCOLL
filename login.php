<?php
    session_start();
    error_reporting(E_ALL);
    //ini_set('display_errors', '1');
    if(isset($_REQUEST['name']) && isset($_REQUEST['password'])){
        $name=$_REQUEST['name'];
        $password=$_REQUEST['password'];
        $password=hash("sha256", $password);      
        $conn=mysqli_connect("localhost", "root", "root", "gescoll");
      	$query="SELECT Nickname, Password FROM User";
		$result=mysqli_query($conn, $query);
        $logged=0;
		while($row=mysqli_fetch_array($result)){
			if($name==$row['Nickname'] && $password==$row['Password']){
                $_SESSION['name']=$name;
                $_SESSION['password']=$password;
                $logged=1;
				header('Location: panel.php');
			}
		}
        if($logged==0){
            header("Location: index.html");
        }
    }
    else{
        header('Location: index.html');
    }
?>