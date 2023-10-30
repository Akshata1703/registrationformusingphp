<?php
session_start();

// Validate login credentials
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$email = test_input($_POST["email"]);
	$password = test_input($_POST["password"]);

	// Check if email and password match database records
	$servername = "localhost";
	$username = "username";
	$password = "password";
	$dbname = "myDB";

	$conn = new mysqli($servername, $username, $password, $dbname);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		$_SESSION["email"] = $email;
		header("Location: user-listing.php");
		exit();
	} else {
		$_SESSION["error"] = "Invalid email or password";
		header("Location: login-page.php");
		exit();
	}


}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>
