<?php
	
	if($_FILES["file"]["name"] != "") 
	{
		$test = explode(".", $_FILES["file"]["name"]);
		$extension = end($test);
		$name = rand(1, 999)."_".$test[0].".".$extension;
		$location = "../uploads/reports/".$name;

		if(move_uploaded_file($_FILES["file"]["tmp_name"], $location)) {
		    
		    $eventID = $_POST['eventID'];
		    print_r($eventID);
		    $file_data = fopen($location, "r");
			fgetcsv($file_data);

			while($row = fgetcsv($file_data)) {
				print_r($row);
				$conn = new mysqli("localhost", "root", "", "geekhaven");
				
				$rollNum = mysqli_real_escape_string($conn, $row[0]);
				$grade = mysqli_real_escape_string($conn, $row[1]);
				
				$stmt = $conn->prepare("UPDATE events SET `reportUrl` = ? WHERE `id`=?");
                $stmt->bind_param("ss",$location, $eventID);
                $result = $stmt->execute();
                $stmt->close();
                
                $stmt = $conn->prepare("INSERT INTO attendance(eventID, rollNum, grade) VALUES(?, ?, ?)");
                echo $conn->error;
                $stmt->bind_param("sss",$eventID, $rollNum, $grade);
                $result = $stmt->execute();
                $stmt->close();
				
			}
			echo 1;
		}
		else {
			echo 0;
		}
	}

?>