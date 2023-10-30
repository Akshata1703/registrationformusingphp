<!DOCTYPE html>
<html>
<head>
	<title>User Listing Page</title>
</head>
<body>
	<h1>User Listing Page</h1>
	<?php
	session_start();

	// Check if user is logged in
	if (!isset($_SESSION["email"])) {
		header("Location: login-page.php");
		exit();
	}

	// Display user information from database
	$servername = "localhost";
	$username = "username";
	$password = "password";
	$dbname = "myDB";

	$conn = new mysqli($servername, $username, $password, $dbname);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$sql = "SELECT * FROM users WHERE email='" . $_SESSION["email"] . "'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo "Name: " . $row["name"] . "<br>";
			echo "Age: " . $row["age"] . "<br>";
			echo "Email: " . $row["email"] . "<br>";
			echo "Date of Birth: " . $row["dob"] . "<br>";
			echo "Contact Number: " . $row["contact"] . "<br>";
			echo "Profile Image: <img src='" . $row["profile"] . "'><br>";
		}
	} else {
		echo "0 results";
	}

	$conn->close();
	?>
	<br><br>
	<a href="update-page.php">Update Details</a><br><br>
	<a href="logout.php">Logout</a>
</body>
</html>
