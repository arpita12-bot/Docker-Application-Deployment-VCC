# Docker-Application-Deployment-VCC
Assignment for Virtualization and Cloud computing
# Virtualization and Cloud Computing | PHP Docker App

This project demonstrates the deployment of a sample web application in php using Docker containers. The application is built from scratch, avoiding the use of pre-existing Docker container images.

## Table of Contents:
    1. Project Overview

    2. App Functionality

    3. Getting Started

    4. Files in This Repository

    5. Author
## Project Overview:
This project involves two main steps:

Creating Docker images from scratch for a web application and a MySQL database.

Deploying the application using Docker Compose.

The web application is a simple PHP-based course registration form that interacts with a MySQL database.

## App Functionality:
The application allows users to register for courses by submitting their name and course details through a form. The data is then stored in a MySQL database.

### Features:
* Web server running Apache2 with PHP 7.4

* MySQL database for storing registration data

* Docker containers for isolated and reproducible environments

## Deployment
To deploy the application, follow the steps below:

### Prerequisites:

Docker installed on your system

Docker Compose installed on your system

### Steps:

Step 1: Install Docker Desktop on Windows

1. *Download Docker Desktop*:
   - Visit the [Docker Desktop website](https://www.docker.com/products/docker-desktop) and download the installer.

2. *Install Docker Desktop*:
   - Run the installer and follow the on-screen instructions.
   - Ensure you enable the option to use WSL 2 during installation.

3. *Start Docker Desktop*:
   - After installation, start Docker Desktop from the Start menu.
   - Verify that Docker is running by opening a Command Prompt or PowerShell and running:
     sh
     docker --version
     
Clone this repository to your local machine.
Navigate to the project directory.
Build and start the Docker containers using Docker Compose
```bash
  docker-compose up --build
```

### Step 2: Create a Sample Web Application

1. *Create a project directory*:
   - Open Command Prompt or PowerShell and run:
     sh
     mkdir myapp
     cd myapp
     
Access the web application by navigating to http://localhost in your web browser.

Project Directory Structure
```bash
    .
├── docker-compose.yml
├── Dockerfile
├── index.php
└── README.md
```
### Files in This Repository
Dockerfile

Defines the web server environment:
```bash
Dockerfile

FROM php:7.4-apache

WORKDIR /var/www/html

COPY . /var/www/html/

RUN docker-php-ext-install mysqli

EXPOSE 80
```
docker-compose.yml

Defines the services and their configurations:

```bash
version: '3.1'

services:
  web:
    build: .
    ports:
      - "80:80"
    depends_on:
      - db

  db:
    image: mysql:5.7
    environment:
      MYSQL_ROOT_PASSWORD: example
      MYSQL_DATABASE: myDB
    volumes:
      - db_data:/var/lib/mysql

volumes:
  db_data:
```

index.php

The PHP script for handling form submissions and database interactions:
```bash
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
```
## Author : g23ai2082@iitj.ac.in
