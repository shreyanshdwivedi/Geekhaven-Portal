<?php
	session_start();
	if(!isset($_SESSION['userGeekhavenLoggedIn']) or !($_SESSION['userGeekhavenLoggedIn'] == true) or !isset($_SESSION['securityKey']) or !($_SESSION['securityKey'] = "@hw72h2k^vdw#gjk!")) {
	    $_SESSION['errorMsg'] = "Please login first";
	    header("Location: ../index.php");
	}

	if(isset($_POST['updateProfile'])) {
		$conn = new mysqli("localhost", "root", "", "geekhaven");

		$phoneNum = $_POST['phoneNum'];
		$bio = $_POST['bio'];
		$experience = $_POST['experience'];
		$skills = $_POST['skills'];
		$email = $_SESSION['email'];
		$id = $_SESSION['userID'];

		$stmt = $conn->prepare("UPDATE users SET phoneNum=?, bio=?, experience=?, skills=? WHERE email=? AND id=?");
        $stmt->bind_param("ssssss", $phoneNum, $bio, $experience, $skills, $email, $id);
        $result = $stmt->execute();
        $stmt->close();

        if($result) {
        	$_SESSION['successMsg'] = "Profile updated successfully";
        	header("Location: profile.php");
        }
	}
	else if(isset($_POST['changePassword'])) {
		$conn = new mysqli("localhost", "root", "", "geekhaven");

		$password = md5($_POST['password']);
		$id = $_SESSION['userID'];

		$stmt = $conn->prepare("UPDATE users SET password=? WHERE id=?");
        $stmt->bind_param("ss", $password, $id);
        $result = $stmt->execute();
        $stmt->close();

        if($result) {
        	$_SESSION['successMsg'] = "Password updated successfully";
        	header("Location: profile.php");
        }
	}
	else if(isset($_POST['changeImage'])) {
        $conn = new mysqli("localhost", "root", "", "geekhaven");
        $target_dir = "../images/users/";
        // var_dump($_FILES);
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $filename = basename( $_FILES['image']['name']);
        $path_parts = pathinfo($_FILES["image"]["name"]);
        $image_path = $path_parts['filename'].'_'.date("Y-m-d_h:i:sa").'.'.$path_parts['extension'];
        $target_file = $target_dir.$image_path;
    
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check === false) {
            $_SESSION["errorMsg"] = "File is not an image. ";
            $uploadOk = 0;
        }
    
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $_SESSION["errorMsg"] += "Sorry, only JPG, JPEG, PNG files are allowed.";
            $uploadOk = 0;
        }
    
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $img = $target_file;
            } else {
                $img = "";
            }
        } else {
            header("Location: profile.php");
        }

        if($img == "") {
            $_SESSION["errorMsg"] = "There is an error";
        } else {
            $stmt = $conn->prepare("UPDATE users SET `image`=? WHERE id=?");
            $stmt->bind_param("ss", $img, $_SESSION['userID']);
            $result = $stmt->execute();
            $stmt->close();
            if($result) {
                $_SESSION["successMsg"] = "The file has been uploaded successfully.";
            }
        }
        header("Location: profile.php");
    }
?>