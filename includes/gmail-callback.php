<?php
ob_start();
session_start();

// Holds the Google application Client Id, Client Secret and Redirect Url
require_once('gmail-setting.php');

// Holds the various APIs involved as a PHP class. Download this class at the end of the tutorial
require_once('google-login-api.php');

// Google passes a parameter 'code' in the Redirect Url
if(isset($_GET['code'])) {
	try {
		$gapi = new GoogleLoginApi();
		
		// Get the access token 
		$data = $gapi->GetAccessToken(CLIENT_ID, CLIENT_REDIRECT_URL, CLIENT_SECRET, $_GET['code']);

		// Access Tokem
		$access_token = $data['access_token'];
		
		// Get user information
        $user_info = $gapi->GetUserProfileInfo($access_token);
        
        $etag = $user_info['etag'];
        $name = explode(" ", $user_info["displayName"]);
        $email = strtolower($user_info["emails"][0]["value"]);
        $rollNum = str_replace("@iiita.ac.in", "", $email);
        $image = $user_info['image']['url'];
        // var_dump();
        if (strpos($email, '@iiita.ac.in') or strpos($email, '@iiitl.ac.in')) {

            $conn = new mysqli("localhost", "root", "", "geekhaven");
            $stmt = $conn->prepare("SELECT id from users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            $num_rows = $stmt->num_rows;
            $stmt->close();
            
            if(!($num_rows > 0)){
                $stmt = $conn->prepare("INSERT INTO users(`rollNum`, `first_name`, `last_name`, `email`, `image`) 
                            values(?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $rollNum, $name[0], $name[1], $email, $image);
                $result = $stmt->execute();
                $stmt->close();
            }

            $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            
            if($user){
                $_SESSION['access-token'] = (string)$access_token;
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

        } else {
            $_SESSION['errorMsg'] = "Only @iiita.ac.in or @iiitl.ac.in mail IDs are allowed";
            header("Location: ../index.php");
        }
	}
	catch(Exception $e) {
		// echo $e->getMessage();
		// exit();
        $_SESSION['errorMsg'] = "Unable to login";
        header("Location: ../index.php");
	}
}
?>