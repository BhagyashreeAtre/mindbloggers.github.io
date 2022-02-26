<?php
  include "config.php";
  session_start();

  if(isset($_SESSION["username"])){
    header("Location: {$hostname}/admin/post.php");
  }


  
  if(isset($_POST["login"]))   
  {  
   if(!empty($_POST["username"]) && !empty($_POST["password"]))
   {
    $name = mysqli_real_escape_string($conn, $_POST["username"]);
    $cpass=mysqli_real_escape_string($conn, $_POST["password"]);
    $password = md5(mysqli_real_escape_string($conn, $_POST["password"]));
    $sql = "Select * from user where username = '" . $name . "' and password = '" . $password . "'"; 
    
    $result = mysqli_query($conn,$sql);  
    $user = mysqli_fetch_array($result);  
    if($user)   
    {  
     if(!empty($_POST["remember"]))   
     {  
      setcookie ("member_login",$name,time()+ (10 * 365 * 24 * 60 * 60));  
      setcookie ("member_password",$cpass,time()+ (10 * 365 * 24 * 60 * 60));
      $_SESSION["username"] = $name;
      $_SESSION["user_id"] = $user['user_id'];
      $_SESSION["user_role"] = $user['role'];
     }  
     else  
     {  
        $_SESSION["username"] = $name;
        $_SESSION["user_id"] = $user['user_id'];
        $_SESSION["user_role"] = $user['role'];
      if(isset($_COOKIE["member_login"]))   
      {  
       setcookie ("member_login","");  
      }  
      if(isset($_COOKIE["member_password"]))   
      {  
       setcookie ("member_password","");  
      }  
     }  
     header("Location: {$hostname}/admin/post.php");
    }  
    else  
    {  
     $message = "Invalid Login";  
    } 
   }
   else
   {
    $message = "Both are Required Fields";
   }
  }  
?>  



<!doctype html>
<html>
   <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>ADMIN | Login</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css" />
        <link rel="stylesheet" href="font/font-awesome-4.7.0/css/font-awesome.css">
        <link rel="stylesheet" href="../css/style.css">
    </head>

    <body>
        <div id="wrapper-admin" class="body-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-offset-4 col-md-4">
                        <img class="logo" src="images/A.png">
                        <h3 class="heading">Sign In</h3>
                        <div class="text-danger"><?php if(isset($message)) { echo $message; } ?></div>  
                        <!-- Form Start -->
                        <form  action="<?php $_SERVER['PHP_SELF']; ?>" method ="POST">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username"  value="<?php if(isset($_COOKIE["member_login"])) { echo $_COOKIE["member_login"]; } ?>" class="form-control" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password"  value="<?php if(isset($_COOKIE["member_password"])) { echo $_COOKIE["member_password"]; } ?>" class="form-control" placeholder="" required>
                            </div>
                            <div class="form-group">  
                                <input type="checkbox" name="remember" <?php if(isset($_COOKIE["member_login"])) { ?> checked <?php } ?> />  
                                <label for="remember-me">Remember me</label>  
                            </div> 
                            <input type="submit" name="login" class="btn btn-primary" value="login" />
                        </form>
                        <!-- /Form  End -->
                        
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
