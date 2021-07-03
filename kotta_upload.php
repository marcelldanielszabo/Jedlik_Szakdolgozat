<?php 
  session_start(); 

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }
  $_SESSION["atadott_id"] = NULL;
  $_SESSION["uid"] = NULL;


    include("header.html");
    include("navbar.html");
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <title>Gitarkotta</title>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        
        <link rel="stylesheet" href="style.css">

        <style>

         .jumbotron .container .row 
            {
                margin:0px!important;
                margin-bottom:auto;
                padding:0px !important;
                background-color: white !important; 
                
                
            }
            .card .card-body
            {
                border-radius:0 !important;
            }
            .button
    {
        background-color:white;
        border:none;
        max-width:500px;
        text-align:left;
        margin-left:10px;
    }
            
         </style>
    </head>
<body>
<div class="container">

        <div class="jumbotron">
            
        <div class="card">
                <div class="card-header">
                    Kotta feltöltése
                </div>
                    <div class="card-body">
                        <h5 class="card-title">Itt fel tudod tölteni a saját kottáidat, vagy másét</h5>
                        <form action="kotta.php" method="POST">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">A kotta neve : </label>
                                        <input type="name" class="form-control" name="cim" placeholder="A kotta neve">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">A kotta előadója : </label>
                                        <input type="name" class="form-control" name="eloado" placeholder="A kotta előadója">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">A kotta típusa</label>
                                        <select class="form-control" name="tipus">
                                        <option>Gitár</option>
                                        <option>Basszusgitár</option>
                                        </select>
                                    </div>
                                    <div class="row text-center">
                                            <div class ="col-md-3"></div>
                                                    <div class ="col-md-3">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="radio" id="inlineRadio1" value="1">
                                                            <label class="form-check-label" for="inlineRadio1">Magyar</label>
                                                        </div>
                                                    </div>
                                                    <div class ="col-md-3">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="radio" id="inlineRadio2" value="2">
                                                            <label class="form-check-label" for="inlineRadio2">Külföldi</label>
                                                        </div> 
                                                    </div>
                                                <div class ="col-md-3">

                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">A kotta youtube linkje </label>
                                        <input type="name" class="form-control" name="yt_link" placeholder="https://www.youtube.com/">
                                    </div>
                                    <div class="form-group">
                                                    <label for="exampleFormControlTextarea1">A kotta </label>
                                                    <textarea class="form-control" name="kotta_text" rows="30"></textarea>
                                                </div>

                                        <button type="submit" class="btn btn-primary btn-lg btn-block">A kotta feltöltése</button>
                                    </form>
                                    
                    </div>
                </div>
        </div>

    
</body>
</html>