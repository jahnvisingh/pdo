<?php
session_start();

try {
    $db= new PDO("mysql:host=localhost;dbname=id1665612_database","id1665612_user","jahnvi");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$error=false;
$fnameError="";
$lnameError="";
$emailError="";
$usererror="";
$passError="";

if(isset($_POST['register'])){
  $fname=$_POST['first'];
  $lname=$_POST['last'];
  $username=$_POST['username'];
  $password=$_POST['password1'];
  $password2=$_POST['password2'];
  $email=$_POST['email'];

  if (empty($fname)) {
   $error = true;
   $fnameError = "!Please enter your firstname.";
  } else if (strlen($fname) < 3) {
   $error = true;
   $fnameError = "Name must have atleast 3 characters.";
  } else if (!preg_match("/^[a-zA-Z ]+$/",$fname)) {
   $error = true;
   $fnameError = "Name must contain alphabets and space.";
  }

  if (empty($lname)) {
   $error = true;
   $lnameError = "!Please enter your lastname.";
  } else if (strlen($lname) < 3) {
   $error = true;
   $lnameError = "!Name must have atleast 3 characters.";
  } else if (!preg_match("/^[a-zA-Z ]+$/",$lname)) {
   $error = true;
   $lnameError = "!Name must contain alphabets and space.";
  }

   if(empty($username)){
	$error=true;
	$usererror="!Please enter username";
   }
   else {
   $result = $db->prepare("SELECT username FROM db WHERE username='".$username."'"); 
   $result->execute();
   $result = $db->prepare("SELECT FOUND_ROWS()"); 
   $result->execute();
   $row_count =$result->fetchColumn();
   if($row_count!=0){
                    $error = true;
                    $usererror = "!Provided Username is already in use.";
                    }
  }
   
   
  if(empty($email)){
   $error=true;
   $emailError = "!Please enter email address.";
   }
   else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
   $error = true;
   $emailError = "!Please enter valid email address.";
   } else {
   $result = $db->prepare("SELECT email FROM db WHERE email='".$email."'"); 
   $result->execute();
   $result = $db->prepare("SELECT FOUND_ROWS()"); 
   $result->execute();
   $row_count =$result->fetchColumn();
   if($row_count!=0){
                     $error = true;
                     $emailError = "!Provided Email is already in use.";
                    }
   }
  
   if (empty($password)){
   $error = true;
   $passError = "!Please enter password.";
  } else if(strlen($password) < 6) {
   $error = true;
   $passError = "!Password must have atleast 6 characters.";
  }


  if(!$error){

  if($password==$password2)
   { $password=md5($password);
   	$sql = $db->prepare("INSERT INTO db(firstname,lastname,username,password,email)VALUES('".$fname."','".$lname."','".$username."','".$password."','".$email."')"); 
    $sql->execute();
  	$_SESSION['message']="you are now logged in";
  	$_SESSION['username']=$username;
  	header("location: hh1.php");
   }
   else
   {$_SESSION['message']="The two passwords do not match!!";}

  }


  }
}

  catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
 
?>

<!DOCTYPE>
<html>
<head>
<link rel="stylesheet" type="text/css" href="sss.css"/>
	<title></title>
</head>
<body>

<div id="signup">SIGN-UP</div>
<div id="register"></div>
<div id="notes">Create,Save and Delete notes !</div>
<div id="img"><img src="user.png" height="100px" /></div>
 
  <form action="signup1.php" method="POST" id="f1">
     FIRST-NAME:<br><input type="text" name="first"><br><span class="text-danger"><?php echo $fnameError; ?></span><br>
     LAST-NAME:<br><input type="text" name="last"><br><span class="text-danger"><?php echo $lnameError; ?></span><br>
     USERNAME:<br><input type="text" name="username"><br> <span class="text-danger"><?php echo $usererror; ?></span><br>
     EMAIL:<br><input type="text" name="email"><br> <span class="text-danger"><?php echo $emailError; ?></span><br>
     PASSWORD:<br><input type="password" name="password1"><br><span class="text-danger"><?php echo $passError; ?></span><br>
     RE-PASSWORD:<br><input type="password" name="password2"><br>
     <input type="submit" name="register" value="SIGN-UP">
     <br>
  </form>

<div id="match">
   <?php
     if(isset($_SESSION['message']))
     echo $_SESSION['message'].'<br>';
    ?>
</div>

<div id="member">
   already a member? <a href="signin1.php"><strong>sign in</strong></a>
</div>

</body>
</html>