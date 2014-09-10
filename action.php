<?php
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    if(isset($_REQUEST['name']) && isset($_REQUEST['password'])){
        $name=$_REQUEST['name'];
        $password=$_REQUEST['password'];      
        $conn=mysqli_connect("localhost", "root", "root", "GESCOLL");
      	$query="SELECT Name, Password FROM User";
		$result=mysqli_query($conn, $query);
		while($row=mysqli_fetch_array($result)){
			if($name==$row['name'] && $password==$row['password']){
				//header('Location: bla.php');
				echo("Ok");
			}
			else{
				session_unset();
				session_destroy();
				$name="";
				$password="";
				header('Location: index.html');
			}
		}
        if(mysqli_connect_errno()){
            //header('Location: index.html');
            echo(mysqli_error($conn));
        }
        else{
            $_SESSION['name']=$name;
            $_SESSION['password']=$password;
            echo(mysqli_error($conn));
            //header('Location: panel.php'); 
        }
    }
    else{
        header('Location: index.html');
    }
?>
