<?php 
include('server.php') ;

?>
<!DOCTYPE html>
<html>
<html lang="hu">
  <head>
        <meta charset="UTF-8" collate="utf8_hungarian_ci">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <title>Gitarkotta</title>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	 
        <style>
            .jumbotron
            {
                margin-bottom:auto;
                padding:10px;
            }
            #bal
            {
                float:left;
            }
            .blog-footer 
            {
            padding: 2.5rem 0;
            color: #999;
            text-align: center;
            background-color: #f9f9f9;
            border-top: .05rem solid #e5e5e5;
            }
            .blog-footer p:last-child
            {
            margin-bottom: 0;
			}
						.row
						{
							height:100px;
						}
						body {
							background: url('02.jpg') no-repeat center center fixed;
							-webkit-background-size: cover;
							-moz-background-size: cover;
							-o-background-size: cover;
							background-size: cover;

						}
						.card
						{
							margin:auto;
							background-color: rgba(255, 255, 255, 0.7); 
						}
						.card-header, .card-footer 
						{ 
							opacity: 1;
						}
						.aligncenter
						{
							text-align:center;
						}
						.marginbottom
						{
							margin-bottom:20px;
						}
        </style>
	</head>

<body>
 
	<div class="container">
		<div class="row">
			<div class="col-sm">
			
			</div>

			<div class="col-sm">
			
			</div>
			
			<div class="col-sm">
			
			</div>
		</div>
		<div class="row">
			<div class="col-sm"></div>

			<div class="col-sm">

				<div class="card" style="width: 18rem;">
					<div class="card-body">
						<form action="server.php" method="POST"> 
							
							<h1 class="h3 mb-3 font-weight-normal">Regisztráció</h1>
								<div class="input-group marginbottom">
									<label for="inputName" class="sr-only">Felhasználónév</label>
									<input type="text" id="inputName" name="username" class="form-control " placeholder="Felhasználónév" required autofocus>
								</div>

							<div class="input-group marginbottom">
								<label for="inputEmail" class="sr-only">e-mail cím</label>
								<input type="email" id="inputEmail" name="email" class="form-control" placeholder="e-mail cím" required>
							</div>

							<div class="input-group marginbottom">
								<label for="inputPassword_1" class="sr-only">Jelszó</label>
								<input type="password" id="inputPassword_1" name="password_1" class="form-control" placeholder="Jelszó" required>
							</div>

						<div class="input-group marginbottom">
								<label for="inputPassword_2" class="sr-only">Jelszó mégegyszer</label>
								<input type="password" id="inputPasswor_2d" name="password_2" class="form-control" placeholder="Jelszó mégegyszer" required>
							</div>

							<div class="input-group  marginbottom">
								<button type="submit" class="btn btn-block btn-success" name="reg_user">Regisztráció</button>
							</div>

							<p>
								Már tag vagy? <a href="login.php">Jelentkezz be!</a>
							</p>

							<div> 
								<?php include("errors.php"); ?>
							</div>
					</div>
				</div>
			</div>
			
			<div class="col-sm"></div>
		</div>
	</div>
</body>
</html>