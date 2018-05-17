<?php

if(isset($_POST['submit']))
    {      
        $target_dir = "../images/permissions/";
        $target_file = $target_dir . basename($_FILES["permission"]["name"]);
        echo($target_file);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $filename = basename( $_FILES['permission']['name']);
        $path_parts = pathinfo($_FILES["permission"]["name"]);
        $image_path = $path_parts['filename'].'_'.date("Y-m-d_h:i:sa").'.'.$path_parts['extension'];
        $target_file = $target_dir.$image_path;
        echo($target_file);

        $check = getimagesize($_FILES["permission"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }

        if ($_FILES["permission"]["size"] > 500000) {
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
            if (move_uploaded_file($_FILES["permission"]["tmp_name"], $target_file)) {
                echo "The file ". basename( $_FILES["permission"]["name"]). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

        $servername = "localhost";
        $dbname = "geekhaven";
        $table = "events";
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $name = $_POST['name'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $addedBy = "Admin";
        $conductedBy = $_POST['conductedBy'];
        $status = "To Be Conducted";

        $query = "INSERT INTO events(eventName, startDate, endDate, addedBy, conductedBy, permission, eventStatus) VALUES('$name', '$startDate', '$endDate', '$addedBy', '$conductedBy', '$target_file', '$status')";
        $conn->exec($query);
    }

    header("Location: events.php");
?>