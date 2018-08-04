<?php
  session_start();

  if(isset($_POST['userLoginGeekhaven'])) {

    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $conn = new mysqli("localhost", "root", "", "geekhaven");
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? AND password=?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();
            
    if($user){
        $_SESSION['successMsg'] = "You are successfully logged in";
        $_SESSION['name'] = $user["first_name"]." ".$user['last_name'];
        $_SESSION['image'] = $user['image']; 
        $_SESSION['email'] = $user['email'];
        $_SESSION['userID'] = $user['id'];
        $_SESSION['userGeekhavenLoggedIn'] = true;
        $_SESSION['securityKey'] = "@hw72h2k^vdw#gjk!";

        header("Location: ../dashboard.php");
    } else {
        $_SESSION['errorMsg'] = "Unable to login";
        header("Location: ../index.php");
    }
  } 
  else if(isset($_POST['adminLoginGeekhaven'])) {

    $username = $_POST['adminUsername'];
    $password = md5($_POST['adminPassword']);

    $conn = new mysqli("localhost", "root", "", "geekhaven");
    $stmt = $conn->prepare("SELECT * FROM wings WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $admin = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if($admin){
        $_SESSION['successMsg'] = "You are successfully logged in";
        $_SESSION['adminGeekhavenLoggedIn'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['name'] = $admin["name"];
        $_SESSION['image'] = $admin['image'];
        $_SESSION['adminID'] = $admin['id'];
        $_SESSION['securityKey'] = "@hw72h2k^vdw#gjk!";

        header("Location: ../admin/");
    } else {
        $_SESSION['errorMsg'] = "Unable to login";
        header("Location: ../index.php");
    }
  }
  else {
    $_SESSION['errorMsg'] = "Unable to login";
    header("Location: ../index.php");
  }
?>