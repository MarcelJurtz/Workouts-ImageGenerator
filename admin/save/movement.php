<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
	header('Location: ./../index.html');
	exit;
}

if (!isset($_POST['id'])) {
	exit('No ID specified');
}

require_once('./../shared/db.php');
$con = getConnection();

if($_POST['id'] > 0) {
	$stmt = $con->prepare('UPDATE movement SET designation = ?, displayname = ?, hashtags = ? WHERE id = ?');
	$stmt->bind_param('sssi', $_POST["designation"], $_POST["displayname"], $_POST["hashtags"], $_POST["id"]);
	$status = $stmt->execute();
	$stmt->close();
} else {
	$stmt = $con->prepare('INSERT INTO movement (designation, displayname, hashtags) VALUES (?,?,?)');
	$stmt->bind_param('sss', $_POST["designation"], $_POST["displayname"], $_POST["hashtags"]);
	$status = $stmt->execute();
	$stmt->close();
}

header('Location: ./../index.php');
?>