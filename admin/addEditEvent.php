<?php
	session_start();
	if(!isset($_SESSION['adminGeekhavenLoggedIn']) or !($_SESSION['adminGeekhavenLoggedIn'] == true) or !isset($_SESSION['securityKey']) or !($_SESSION['securityKey'] = "@hw72h2k^vdw#gjk!")) {
	    $_SESSION['errorMsg'] = "Please login first";
	    header("Location: ../index.php");
	}

	if(isset($_POST['addEvent'])) {

		$name = $_POST['eventName'];
		$description = $_POST['description'];
		$prerequisites = $_POST['prerequisites'];
		$start = $_POST['start'];
		$end = $_POST['end'];
		$adminID = $_SESSION['adminID'];
		$status = "";

		$conn = new mysqli("localhost", "root", "", "geekhaven");
		$stmt = $conn->prepare("INSERT INTO events(`eventName`, `description`, `prerequisites`, `startDate`, `endDate`, `conductedBy`, `eventStatus`) values(?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $name, $description, $prerequisites, $start, $end, $adminID, $status);
        $result = $stmt->execute();
        $stmt->close();

        if($result) {
        	$_SESSION['successMsg'] = "Event successfully added";
        } else {
        	$_SESSION['errorMsg'] = "Some technical issue";
        }
        header("Location: events.php");
	}
	else if(isset($_POST['editEvent'])) {

		$name = $_POST['eventName'];
		$description = $_POST['description'];
		$prerequisites = $_POST['prerequisites'];
		$start = $_POST['start'];
		$end = $_POST['end'];
		$adminID = $_SESSION['adminID'];
		$status = $_POST['eventStatus'];
		$eventID = $_POST['eventID'];

		$conn = new mysqli("localhost", "root", "", "geekhaven");
		$stmt = $conn->prepare("UPDATE events SET `eventName`=?, `description`=?, `prerequisites`=?, `startDate`=?, `endDate`=?, `conductedBy`=?, `eventStatus`=? WHERE id=?");
		echo $conn->error;
        $stmt->bind_param("ssssssss", $name, $description, $prerequisites, $start, $end, $adminID, $status, $eventID);
        $result = $stmt->execute();
        $stmt->close();

        if($result) {
        	$_SESSION['successMsg'] = "Event edited successfully";
        } else {
        	$_SESSION['errorMsg'] = "Some technical issue";
        }
        header("Location: events.php");
	}
	else {
		header("Location: ../index.php");
	}

?>