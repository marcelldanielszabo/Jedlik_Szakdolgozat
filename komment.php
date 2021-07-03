<?php

session_start(); 

  if (!isset($_SESSION['username'])) 
  {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) 
  {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["komment"]))
    {
        include("db_config.php");
        $_postcontent = $_POST["komment"];
        $_postdate = date("Y-m-d h:i:sa");
        $_posttopic = $_SESSION["atadott_id"];
        $user = $_SESSION['username'];
        $sql = "SELECT users.userID
        FROM users
        WHERE users.username = '$user' ;";
        $sor = $connection->query($sql)->fetch_assoc();
        $_postby = $sor["userID"] ;

        $sql_insert = "INSERT INTO posts (post_content, post_date, post_topic, post_by)
                        VALUES ('$_postcontent', NOW(), $_posttopic, $_postby); ";
        $connection->query($sql_insert);
        $_SESSION["alap"] = $_POST["atadott_id"];
        header("location: bejegyzes.php");
    }

?>