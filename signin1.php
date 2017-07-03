<?php
session_start();
$error=false;
$var="";
$usererror="";
$passError="";

try {
    $db= new PDO("mysql:host=localhost;dbname=id1665612_database","id1665612_user","jahnvi");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    if(isset($_POST['login']))
{
   $username=$_POST['username'];
   $password=$_POST['password1'];


   if(empty($username)){
                      $error=true;
                      $usererror="please enter username";
                       }

  if (empty($password)){
                      $error=true;
                      $passError="Please enter password.";
                       }


$password=md5($password);  
  if(!$error){
  	$result = $db->prepare("SELECT * FROM db WHERE username='".$username."' AND password='".$password."'"); 
    $result->execute();
    $result = $db->prepare("SELECT FOUND_ROWS()"); 
    $result->execute();
    $row_count =$result->fetchColumn();
  	
    if($row_count>=1)
     {
  	  $_SESSION['message']="You are now logged in!";
  	  $_SESSION['username']=$username;
  	  header("location:hh1.php");
     }
    else
     {
       $var="incorrect username/password "."<br>"."combination"."<br>";
     }
   }
}


    }


    catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}


?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="sss.css"/>
	<title></title>
</head>
<body>


<div id="format"></div>
<form action="signin1.php" method="POST" id="enter">
   USERNAME:<br><input type="text" name="username" ><br><span class="text-danger"><?php echo $usererror; ?></span><br>
   PASSWORD:<br><input type="password" name="password1" ><br><span class="text-danger"><?php echo $passError; ?></span><br>
   

 <div id="var">
   <?php echo $var ?>
    <br>
 </div>

  <input type="submit" name="login" value="SIGN-IN"><br>

</form>

<div id="sign">
  create new account!<a href="signup1.php">SIGN-UP</a>
</div>
</body>
</html>