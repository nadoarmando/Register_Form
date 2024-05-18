<?php
session_start();
if(isset($_SESSION['user']))
{
    header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=,initial-scale=1.0">
    <title>Login Form</title>
   
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
 <link  href="style.css" rel="stylesheet">
</head>
<?php
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    require_once "database.php";
    $sql = "SELECT *FROM users WHERE email ='$email'";
    $res = mysqli_query($conn, $sql);
    $user = mysqli_fetch_array($res, MYSQLI_ASSOC);
    if ($user) {
        if (password_verify($password, $user['password'])) {
         session_start();
           /*  session_start();*/
            $_SESSION['user'] = "yes";
            header("location: index.php");
            die();
        } else {
            echo "<div class='er'> Password doesn't match </div>";
        }
    } else {
        echo "<div class='er'> Emai doesn't found </div>";
    }
}
?>
<body>
    <div class="container">
     <form action="login.php" method="post">
       <nav>     
     <ul>
        <li><a href="login.php" class="active">Login</a></li>
      <li><a href="registr.php">Register</a></li>
        </ul>
</nav>
        <div class="form-groub">
            <input type="email" placeholder="Enter Email" name="email" class="form-control">
        </div>
        <div class="form-groub">
            <input type="password" placeholder="Enter Password" name="password" class="form-control">
        </div>
        <div class="form-btn">
            <input type="submit" value="login" name="login" class="btn btn-primary">
        </div>
   </form>
   <div style="text-align:center"><p> Not registered yet</p><a href="registr.php"> Forgot Password </a> </p></div>
    </div>
</body>
</html>