<?php
session_start();

// Validate input fields
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$name = test_input($_POST["name"]);
	$age = test_input($_POST["age"]);
	$email = test_input($_POST["email"]);
	$dob = test_input($_POST["dob"]);
	$contact = test_input($_POST["contact"]);
	$profile = $_FILES["profile"]["name"];

	if (!preg_match("/^[0-9]*$/", $age)) {
		$_SESSION["error"] = "Please enter a valid age";
		header("Location: signup-page.php");
		exit();
	}

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$_SESSION["error"] = "Please enter a valid email";
		header("Location: signup-page.php");
		exit();
	}

	if (!preg_match("/^[0-9]{2}-[0-9]{2}-[0-9]{4}$/", $dob)) {
		$_SESSION["error"] = "Please enter a valid date of birth (dd-mm-yyyy)";
		header("Location: signup-page.php");
		exit();
	}

	if (!preg_match("/^[0-9]{10}$/", $contact)) {
		$_SESSION["error"] = "Please enter a 10-digit contact number";
		header("Location: signup-page.php");
		exit();
	}

	$allowed_extensions = array("png", "jpg", "jpeg");
	$extension = pathinfo($profile, PATHINFO_EXTENSION);
	if (!in_array($extension, $allowed_extensions)) {
		$_SESSION["error"] = "Please upload a valid image file (png, jpg, jpeg)";
		header("Location: signup-page.php");
		exit();
	}

	// Store user information in database
	$servername = "localhost";
	$username = "username";
	$password = "password";
	$dbname = "myDB";

	$conn = new mysqli($servername, $username, $password, $dbname);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$sql = "INSERT INTO users (name, age, email, dob, contact, profile) VALUES ('$name', '$age', '$email', '$dob', '$contact', '$profile')";

	if ($conn->query($sql) === TRUE) {
		$_SESSION["success"] = "Signup successful";
		header("Location: user-listing.php");
		exit();
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>