<?php

    if(isset($_POST['submit']))
    {      
        $target_dir = "../../images/users/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $filename = basename( $_FILES['image']['name']);

        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        if ($_FILES["image"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            echo "Sorry, only JPG, JPEG, PNG files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

        $servername = "localhost";
        $dbname = "geekhaven";
        $table = "users";
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $rollNum = $_POST['rollNum'];
        $name = $_POST['name'];
        $position = $_POST['position'];
        $contact = $_POST['contact'];
        $wing = $_POST['wing'];

        $query = "INSERT INTO users(rollNum, username, img, position, contact, wing) VALUES('$rollNum', '$name', '$target_file', '$position', '$contact', '$wing')";
        $conn->exec($query);
    }

    header("Location: ../users.php");
?>