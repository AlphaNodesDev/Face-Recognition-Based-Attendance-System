<?php 
include 'Includes/dbcon.php';
session_start();
?>

<?php

  if(isset($_POST['login'])){

    $userType = $_POST['userType'];
    $username = $_POST['username'];
    $password = $_POST['password'];


    if($userType == "Administrator"){
        $password = md5($password);
      $query = "SELECT * FROM tbladmin WHERE emailAddress = '$username' AND password = '$password'";
      $rs = $conn->query($query);
      $num = $rs->num_rows;
      $rows = $rs->fetch_assoc();

      if($num > 0){

        $_SESSION['userId'] = $rows['Id'];
        $_SESSION['firstName'] = $rows['firstName'];
        $_SESSION['lastName'] = $rows['lastName'];
        $_SESSION['emailAddress'] = $rows['emailAddress'];

        echo "<script type = \"text/javascript\">
        window.location = (\"Admin/index.php\")
        </script>";
      }

      else{

        echo "<div class='alert alert-danger' role='alert'>
        Invalid Username/Password!
        </div>";

      }
    }
    else if($userType == "Student"){

        $query = "SELECT * FROM tblstudents WHERE admissionNumber = '$username' AND password = '$password'";
        $rs = $conn->query($query);
        $num = $rs->num_rows;
        $rows = $rs->fetch_assoc();
  
        if($num > 0){
  
          $_SESSION['userId'] = $rows['Id'];
          $_SESSION['firstName'] = $rows['firstName'];
          $_SESSION['admissionNumber'] = $rows['admissionNumber'];
          $_SESSION['lastName'] = $rows['lastName'];
          $_SESSION['emailAddress'] = $rows['emailAddress'];
          $_SESSION['classId'] = $rows['classId'];
          $_SESSION['classArmId'] = $rows['classArmId'];
  
          echo "<script type = \"text/javascript\">
          window.location = (\"students/index.php\")
          </script>";
        }
  
        else{
  
          echo "<div class='alert alert-danger' role='alert'>
          Invalid Username/Password!
          </div>";
  
        }
      }


    else if($userType == "faculty"){
        $password = md5($password);
      $query = "SELECT * FROM tblteachers WHERE emailAddress = '$username' AND password = '$password'";
      $rs = $conn->query($query);
      $num = $rs->num_rows;
      $rows = $rs->fetch_assoc();

      if($num > 0){

        $_SESSION['userId'] = $rows['Id'];
        $_SESSION['firstName'] = $rows['firstName'];
        $_SESSION['lastName'] = $rows['lastName'];
        $_SESSION['emailAddress'] = $rows['emailAddress'];
        $_SESSION['classId'] = $rows['classId'];
        $_SESSION['classArmId'] = $rows['classArmId'];
        $_SESSION['subject'] = $rows['subject'];
        echo "<script type = \"text/javascript\">
        window.location = (\"faculty/index.php\")
        </script>";
      }

      else{

        echo "<div class='alert alert-danger' role='alert'>
        Invalid Username/Password!
        </div>";

      }
    }
    else{

        echo "<div class='alert alert-danger' role='alert'>
        Invalid Username/Password!
        </div>";

    }
}
?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
  <title>FRecon-Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
<link href='https://fonts.googleapis.com/css?family=Roboto:300,400,600' rel='stylesheet' type='text/css'><link rel="stylesheet" href="./css/style.css">
<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
</head>
<body>
<!-- partial:index.partial.html -->
<div id="back">
  <canvas id="canvas" class="canvas-back"></canvas>
  <div class="backRight">    
  </div>
  <div class="backLeft">
  </div>
</div>

<div id="slideBox">
  <div class="topLayer">
    
    <div class="right">
      <div class="content">
        <div class="sidebar-brand2">
          <h1><span class="lab la-accusoft"><b>  </b><b>FRecon</b></span></h1>
        </div>
        <h2>Sign in </h2>
        <form class="user" method="Post" action="">
        <select required name="userType" class="form-control mb-3">
                                                <option value="">--Select User Roles--</option>
                                                <option value="Administrator">Administrator</option>
                                                <option value="faculty">faculty</option>
                                                <option value="Student">Student</option>
                                            </select>
          <div class="form-element form-stack">
            <label for="username-login" class="form-label">Username</label>
            <input type="text" class="form-control" required name="username" id="exampleInputEmail" placeholder="Enter Email Address">
          </div>
          <div class="form-element form-stack">
            <label for="password-login" class="form-label">Password</label>
            <input type="password" name="password" required class="form-control" id="exampleInputPassword" placeholder="Enter Password">
          </div>
          <div class="form-element form-submit">
            <button id="logIn" class="login" type="submit" value="Login" name="login">Log In</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/paper.js/0.11.3/paper-full.min.js'></script><script  src="./js/script.js"></script>

</body>
</html>
