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
		while($row=mysqli_fetch_array($result)){
			if($name==$row['Nickname'] && $password==$row['Password']){
                $_SESSION['name']=$name;
                $_SESSION['password']=$password;
				header('Location: panel.php');
			}
			else{
				//session_unset();
				//session_destroy();
				//$name="";
				//$password="";
                //echo($row['Nickname']." ".$row['Password']."</br>");
                //echo(mysqli_error($conn));
				//header('Location: index.html');
			}
		}
        /*if(mysqli_connect_errno()){
            //header('Location: index.html');
            echo(mysqli_error($conn));
        }
        else{
            $_SESSION['name']=$name;
            $_SESSION['password']=$password;
            echo("?");
            //header('Location: panel.php'); 
        }*/
    }
    else{
        header('Location: index.html');
    }
?>