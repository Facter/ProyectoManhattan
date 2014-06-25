<?php 

 //Mensajes de error por si el logeo falla

	$error=0;
	$message="Bienvenido";
	if (isset($_GET["error"])) {
		$error= $_GET["error"];
		switch ($error) {
			case '1':
				$message="El usuario no existe";
				break;
			case '2':
				$message="El contraseña es incorrecta";
				break;
			case '3':
				$message="El usuario no existe";
				break;
			case '4':
				$message="El usuario se ha creado";
				break;
		}
	}
 ?>

<!DOCTYPE HTML>
<META CHARSET="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<html>
	<head>
	<title>Inicia sesión</title>
		<!-- Bootstrap -->
	    <link href="css/bootstrap.min.css" rel="stylesheet">

	    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	    <![endif]-->
	</head>
	<body>
		<div class="container">
				<h1>Inicia Sesión</h1>
				<div class="row">
					<div class="col-xs-12 .col-sm-6 .col-md-12">
						<?php echo $message; ?>
					</div>
				</div>
				<div>
					<form action="validarlogin.php" class="form-horizontal" method="POST" name="login" id='contact-form' class='contact-form2'>
						<div class="form-group">
							<label for="exampleInputEmail1">Usuario</label>
							<input type="text" name="username" class="form-control" id="username" maxlength="15" placeholder="Usuario" size="25">
			  		    </div>
			  		    <div class="form-group">
			  		    	<label for="exampleInputPassword1">Password</label>
				  			<input type="password" name="userpwd" class="form-control" id="userpwd" maxlength="15" placeholder="Contraseña" size="25">
						</div>
					    <div class="checkbox">
					  		 <label>
					     		 <input type="checkbox"> Check me out
					   		 </label>
					 	</div>
					 	<hr>
						<input type='submit' id='contact-form' class='btn btn-default' value='Iniciar sesión'> o <a href="registro.php" class="btn btn-default">Registrate</a>
					</form>
				</div>

			    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
			    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
			    <!-- Include all compiled plugins (below), or include individual files as needed -->
			    <script src="js/bootstrap.min.js"></script>
		</div>
	</body>
</html>
