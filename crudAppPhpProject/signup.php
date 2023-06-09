<?php

    include('dbconnect.php');

    $showerror = false;
    $exist = false;
    if(isset($_POST['submit'])){
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];


        $existSql = "SELECT * FROM user_01 WHERE email = '$email'";


        $result = mysqli_query($conn, $existSql);

        $numExistRows = mysqli_num_rows($result);


        if($numExistRows > 0){
           $exist = true;
        }else{

          if(validName($name) && validEmail($email) && validPassword($password,$cpassword)){
              $hashPassword = password_hash($password, PASSWORD_DEFAULT);
              $sql = "INSERT INTO user_01 (username, email, password, date) VALUES('$name', '$email', '$hashPassword', current_timestamp())";
              session_start();
              $_SESSION['loggedin'] = true;
              $_SESSION['email'] = $email;
              $_SESSION['name'] = $name;
              if(mysqli_query($conn,$sql)){
                header("location: crud.php");   
              }
          }else{
              $showerror = true;
          }
        }


    }


    function validName($name){
        if(!preg_match("/[0-9]/",$name) && !empty($name) && preg_match("/^[a-zA-Z ]*$/",$name){
          return true;
        }else{
          return false;
        }
    }
    
    function validEmail($email){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
          return true;
        }else{
          return false;
        }
    }


    function validPassword($password,$cpassword){
            $passwordLength = strlen($password);
          if($password == $cpassword && $passwordLength >= 8){
                return true;
          }else{
            return false;
          }
    }


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="crud.php">iNote</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="crud.php">Home</a>
            </li>
            <?php
                  if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
                        echo '<li class="nav-item">
                        <a class="nav-link" href="logout.php" role="button" aria-expanded="false">
                          Logout
                        </a>
                      </li>';
                  }else{
                    echo '<li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link" href="signup.php" role="button" aria-expanded="false">
                      Signup
                    </a>
                  </li>';
                  }
              ?>
          </ul>

        </div>
      </div>
    </nav>
        <div class="container my-5">
            <h1 class="text-center my-3">Signup to our website</h1>
        <div class="mb-3 row col-md-8 mx-auto border p-4">
            <?php
                if($showerror){
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Invalid name or email or password.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                }
            ?>
            <?php
                if($exist){
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> You have already an account.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                }
            ?>
         <form action="signup.php" method="post"> 
        <div class="mb-3">
            <label for="username" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="name" name="name" required placeholder="Enter your name">
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required placeholder="Enter your password">
        </div>
        <div class="mb-3">
            <label for="cpassword" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="cpassword" required name="cpassword" placeholder="Confirm your password">
        </div>
        <button type="sumbit" class="btn btn-primary" id="submit" name="submit">Submit</button>
        </form>  
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
</body>

</html>
