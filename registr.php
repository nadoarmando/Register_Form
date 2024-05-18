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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration form</title>

  <!------------BootStrap-------------->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
   if(isset($_POST["submit"])){
$fullName=$_POST["fullname"];
$email=$_POST["email"];
$password=$_POST["password"];
$rpass=$_POST["repeat_password"];
        $errors = array();
        $passwordhash = password_hash($password, PASSWORD_DEFAULT);
     if(empty($fullName) OR empty($email) OR empty($password) OR empty($rpass))
     {
            array_push($errors, "<div class='er'>all fields are required</div>");
     }   
     if(!filter_var($email,FILTER_VALIDATE_EMAIL))
     {
            array_push($errors, "Email is not valid");
     }  
     if(strlen($password)<8)
     {
            array_push($errors, "Password must be at least 8 characters long");
     }  
     if($password!==$rpass)
     {
            array_push($errors, "Password does not match");
     } 
     /*//////Print Errors///////*/
   require_once "database.php";
     $sql="SELECT *FROM users WHERE email ='$email'";
     $result =mysqli_query($conn,$sql);
           $rowcount = mysqli_num_rows($result);
           /*//////Check If Email Exists////////*/
           if($rowcount>0)
           {
                  array_push($errors, "Email already exists! ");
           }
             /*//////Print Errors///////*/
     if (count($errors)>0)
     {
        foreach ($errors as $error)
        {
            echo "<div class='alert alert-danger'>$error</div>";

        }
     }
     /*///////////If no Errors ////*/
     else
     {
            require_once "database.php";
            $sql = "INSERT INTO users (fullName ,email ,password) VALUES(?,?,?)";
            $stmt = mysqli_stmt_init($conn);
            $preparestmt = mysqli_stmt_prepare($stmt, $sql);
            if($preparestmt)
            {
                mysqli_stmt_bind_param($stmt, "sss", $fullName, $email, $passwordhash);
                mysqli_stmt_execute($stmt);
                echo "<div class='er'>You are registered successfully</div>";
            }
            else{
                         die("something went wrong");
            }
     }
   }
    ?>
    <div class="container">
    <form action="registr.php" method="post">
    <nav>     
     <ul>
        <li><a href="login.php" class="active">Login</a></li>
      <li><a href="registr.php">Register</a></li>
        </ul>
</nav>
        <div class="form-groub">
            <input type ="text" class="form-control" name="fullname" placeholder="Full name:" class="form-control">
     </div>
     <div class="form-groub">
            <input type ="email" class="form-control" name="email" placeholder="Email:" class="form-control">
     </div>
     <div class="form-groub">
            <input type ="password" class="form-control" name="password" placeholder="Password:" class="form-control">
     </div>
     <div class="form-groub">
            <input type ="password" class="form-control" name="repeat_password" placeholder="Repeat Password:" class="form-control">
     </div>
     <div class="form-btn">
            <input type ="submit" class="btn btn-primary" name="submit" value="Register">
     </div>
</form>
</div>
</body>
</html>