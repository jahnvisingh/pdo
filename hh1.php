<?php
session_start();


$user=$_SESSION['username'];

try {
    $db= new PDO("mysql:host=localhost;dbname=id1665612_database","id1665612_user","jahnvi");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     
    if(isset($_POST['create'])){
      $note=$_POST['note'];
      $sql = $db->prepare("INSERT INTO notes(note,username) VALUES('".$note."','".$user."')"); 
      $sql->execute();
      }

   if(isset($_POST['delete_id'])){
      $delete_id = $_POST['delete_id'];
      $sq = $db->prepare("DELETE FROM notes WHERE note='".$delete_id."'"); 
      $sq->execute();
      header('Location: hh1.php');
      }




   }

 catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}



?>

<!DOCTYPE>
<html> 
<head><link rel="stylesheet" type="text/css" href="sss.css"/></head>
<body>
<div id="msg">
  <?php if(isset($_SESSION['message']))
  echo $_SESSION['message'].'<br>'; ?>
</div>
<div id="welcome">WELCOME</div><br>
<div id="name"><?php echo "USER : ".$_SESSION['username']."<br>"; ?></div>

<form method="POST" action="hh1.php" id="create">
     Add a note:<input type="text" name="note"><br><br>
    <input type="submit" value="create" name="create"><br>
</form>



<?php 
  $sl = $db->prepare("SELECT*FROM notes WHERE username='".$user."'"); 
  $sl->execute(); ?>

<table id="table" cellspacing="50">
  <tr>
    <td>Notes:</td>
  </tr>
  <?php while($row=$sl->fetch(PDO::FETCH_ASSOC)) : ?>
  <tr>
    <td><?php echo $row['note']; ?></td>
  
    <td>
      <form action="hh1.php" method="post">
        <input type="hidden" name="delete_id" value="<?php echo $row['note']; ?>" />
        <input type="submit" value="Delete" />
      </form>
    </td>
  </tr>
  <?php endwhile; ?>
</table>

<div id="logout"><a href="log1.php"> Logout </a></div>
</body>
</html>