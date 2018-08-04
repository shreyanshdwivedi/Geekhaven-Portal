<?php
session_start();

if(!isset($_SESSION['userGeekhavenLoggedIn']) or !($_SESSION['userGeekhavenLoggedIn'] == true) or !isset($_SESSION['securityKey']) or !($_SESSION['securityKey'] = "@hw72h2k^vdw#gjk!")) {
    $_SESSION['errorMsg'] = "Please login first";
    header("Location: ../index.php");
} 

include "config.php";

$userID = $_SESSION['userID'];
$eventID = $_POST['eventID'];
$rating = $_POST['rating'];

// Check entry within table
$query = "SELECT COUNT(*) AS cntevents FROM ratings WHERE eventID=".$eventID." and userID=".$userID;

$result = mysqli_query($conn,$query);
$fetchdata = mysqli_fetch_array($result);
$count = $fetchdata['cntevents'];

if($count == 0){
    $insertquery = "INSERT INTO ratings(userID, eventID, rating) values(".$userID.",".$eventID.",".$rating.")";
    mysqli_query($conn,$insertquery);
}else {
    $updatequery = "UPDATE ratings SET rating=" . $rating . " where userID=" . $userID . " and eventID=" . $eventID;
    mysqli_query($conn,$updatequery);
}


// get average
$query = "SELECT ROUND(AVG(rating),1) as averageRating FROM ratings WHERE eventID=".$eventID;
$result = mysqli_query($conn,$query) or die(mysqli_error());
$fetchAverage = mysqli_fetch_array($result);
$averageRating = $fetchAverage['averageRating'];

$return_arr = array("averageRating"=>$averageRating, "count"=>$count);

echo json_encode($return_arr);
?>