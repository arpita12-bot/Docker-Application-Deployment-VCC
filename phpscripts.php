<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job Aplication Form</title>
</head>
<body>
    <h2>Submit Form</h2>
    <form action="submit.php" method="post">
        <label for="first_name">First Name:</label><br>
        <input type="text" id="first_name" name="first_name" 
         placeholder = "Enter First Name" required><br><br>

	<label for="last_name">Last Name:</label><br>
        <input type="text" id="last_name" name="last_name"
         placeholder = "Enter Last Name" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" 
         placeholder = "Enter Email" required><br><br>

	<label for="job_role">Job Role:</label><br>
	<input type="job_role" id="job_role" name="job_role" 
         placeholder = "Enter your role" required><br><br>
 

        <label for="address">Address:</label><br>
        <textarea id="address" name="address" rows="10" cols="30"
        placeholder="Enter Full Address" required></textarea><br><br>


	<label for="city">City:</label><br>
        <input type="text" id="city" name="city" placeholder="Enter City" required><br><br>

	<label for="pincode">Pincode:</label><br>
        <input type="number" id="pincode" name="pincode" placeholder="Enter Pincode" required><br><br>

	<label for="date">Date:</label><br>
        <input type="date" id="date" name="date" value="2024-07-26" required><br><br>

	<label for="cv">Upload Your CV:</label><br>
        <input type="file" id="cv" name="cv">

        <input type="submit" value="Apply Now">
    </form>
</body>
</html>

<?php
$servername = "192.168.56.102";
$username = "rootarp";
$password = "Arpita1205@";
$dbname = "iitj";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Checking whether the form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = $_POST['email'];
	$job_role = $_POST['job_role'];
	$address = $_POST['address'];
	$city = $_POST['city'];
	$pincode = $_POST['pincode'];
	$date = $_POST['date'];
	$cv_file = $_POST['cv'];

	//file name with a random number so that similar don't get replaced
	$pname = rand(1000,10000)."-".$_FILES["file"]["name"];

	//temporary file name to store file
	$tname = $_FILES["files"]["tmp_name"];

	//upload directory path
	$uploads_dir = '/images';

	//To move the uploaded file to specific location 
	move_uploaded_file($tname, $uploads_dir.'/'.$pname);

	// Insert data into mysql
	$sql = "INSERT INTO job_applied(first_name, last_name, email, job_role, address, city, pincode, date, title, cv_file) VALUES('$first_name', '$last_name', '$email', '$job_role', '$address',
               '$city', '$pincode', '$date', '$cv_file', '$pname')";
	if ($conn->query($sql) === TRUE) {
		echo "New record created successfully";
	} 
	else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}		
}
$conn->close();
?>