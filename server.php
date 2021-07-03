<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array(); 

// connect to the database
include('db_config.php');

// REGISTER USER
if (isset($_POST['reg_user'])) {

  $username = mysqli_real_escape_string($connection, $_POST['username']);
  $email = mysqli_real_escape_string($connection, $_POST['email']);
  $password_1 = mysqli_real_escape_string($connection, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($connection, $_POST['password_2']);

  if ($password_1 != $password_2) 
  {
	  array_push($errors, "A két jelszó nem egyezik");
  }

  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($connection, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) {
    if ($user['username'] === $username) {
      array_push($errors, "Ilyen user már van");
    }

    if ($user['email'] === $email) {
      array_push($errors, "Ilyen e-mail már van");
    }
  }
  var_dump($username, $email, $password_1);
  if (count($errors) == 0) {
  	
    include("db_config.php");
    $password = md5($password_1);
    var_dump($username);
    var_dump($password);
    $usernev = $_POST['username'];
    var_dump($usernev);
  	$sql = "INSERT INTO guitar.users (username, email, pass, kep_eleresi_ut) 
  			      VALUES('$usernev', '$email', '$password', 'kepek/default.png')";
    if ($connection->query($sql) === TRUE) 
    {
      echo "New record created successfully";
    } 
    else 
    {
      echo "Error: " . $sql . "<br>" . $connection->error;
    }
  	$_SESSION['username'] = $usernev;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');
  }
  else
  {
    var_dump($errors);
  }
}