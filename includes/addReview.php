<?php
	session_start();
	if(!isset($_SESSION['userGeekhavenLoggedIn']) or !($_SESSION['userGeekhavenLoggedIn'] == true) or !isset($_SESSION['securityKey']) or !($_SESSION['securityKey'] = "@hw72h2k^vdw#gjk!")) {
	    $_SESSION['errorMsg'] = "Please login first";
	    header("Location: ../index.php");
	}

	if(isset($_POST['reviewEvent'])) {
		$review = $_POST['review'];
		$eventID = $_POST['eventID'];
		$conn = new mysqli("localhost", "root", "", "geekhaven");
		$stmt = $conn->prepare("INSERT INTO reviews(`userID`, `eventID`, `review`) values(?, ?, ?)");
        $stmt->bind_param("sss", $_SESSION['userID'], $eventID, $review);
        $result = $stmt->execute();
        $stmt->close();

        if($result) {
        	$_SESSION['successMsg'] = "You have successfully reviewed the event";
        } else {
        	$_SESSION['errorMsg'] = "Some technical issue";
        }
        header("Location: eventDetails.php?eventID=".$eventID);
	} else {
		header("Location: ../dashboard.php");
	}

?>