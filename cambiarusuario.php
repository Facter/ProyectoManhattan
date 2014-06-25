<!DOCTYPE HTML>
<META CHARSET="UTF-8">
<!-- Responsividad segun la resolución -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php 
	session_start();
	if ($_SESSION['tipo']==1) {
		include_once("settings/settings.inc.php");
		$conexion=@mysql_connect(SQL_HOST, SQL_USER, SQL_PWD);
		@mysql_select_db(SQL_DB, $conexion) or die(mysql_error());
		
		/* Borrar usuarios */
		if (isset($_GET['idusr'])) {
			$sql="DELETE FROM usuarios WHERE id='".$_GET['idusr']."';";
			$eliminar=mysql_query($sql, $conexion);
		}
		

		$sql="SELECT * FROM blog.usuarios;";
		$usuarios=mysql_query($sql, $conexion);
		if (isset($_SESSION['usuario'])) {
			echo "<div class='row'";
				echo "<div class='col-md-7'></div>";
				echo "<div class='col-md-5'>";
					echo "<p align='right'>";
					echo "<a class='btn btn-danger' href='cerrarsesion.php'><span class='glyphicon glyphicon-remove'></span> Cerrar sesion</a> ";
					echo "<a class='btn btn-default' href='index.php'><span class=' glyphicon glyphicon-home'></span> Página principal</a> <label class='glyphicon glyphicon-ok'></label> Hola ".$_SESSION['nombre']."</p>";
				echo "</div>";
			echo "</div>";
			echo "<hr>";
		}
		?>
		<html>	
			<head>
				<title>Bienvenido Admin</title>
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
					<h2>Control de usuarios</h2>
					<!--Despliegue de usuarios con sus datos-->
					<form action="cambiarusuario.php" method="GET"> <table width=50% class="table table-hover" align='center'>
						<tr align='center'>
							<td ><b>Nombre</b></td><td><b>Usuario</b></td><td><b>Tipo</b></td><td colspan=2><b>Acciones</b></td>
						</tr>
						<?php  
							while ($usuario = @mysql_fetch_array($usuarios)){
								echo "<tr align='center'>";
									echo "<td>".$usuario['nombre']."</td>";
									echo "<td>".$usuario['usuario']."</td>";
									echo "<td align='center'>".$usuario['tipo']."</td>";
									echo "<td align='center'><a  class='btn btn-warning' href='registro.php?idusr=".$usuario['id']."'><span class='glyphicon glyphicon-pencil'></span> Modificar</a>";
									echo "<td align='left'><a class='btn btn-danger' href='cambiarusuario.php?idusr=".$usuario['id']."'><span class='glyphicon glyphicon-trash'></span> Eliminar</a></td></td>";
								echo "</tr>";
							}
						?>
					</form></table>

					<!--Termino de despliege-->

					    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
					    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
					    <!-- Include all compiled plugins (below), or include individual files as needed -->
					    <script src="js/bootstrap.min.js"></script>
				</div>	
			</body>
		</html>

		<!--Seguridad-->
		<?php
	}
	else
	{
		header("location:index.php");
	}
 ?>