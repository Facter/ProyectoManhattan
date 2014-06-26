<!DOCTYPE HTML>

<!-- Responsividad segun la resolución del dispositivo -->
<META CHARSET="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<html>
	<head>
		<title>Proyecto SECRETO!</title>
		 <!-- Bootstrap -->
	    <link href="css/bootstrap.min.css" rel="stylesheet">
	    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	    <![endif]-->
		<!--Esto es para que aparesca el nombre de usuario y las opciones-->
	</head>
	<body><hr>
		<div class="container">
			<div class="row">
		<p class="bg-success">
			<?php 

				session_start();
				if (isset($_SESSION['nombre'])) {
					echo "<div class='col-md-8'>Usted esta logeado como:<b> ".$_SESSION['usuario']. "</b></div>
					<div class='col-md-4'> 
					  <button type='button' class='btn btn-success'><span class='glyphicon glyphicon-bell'></span> Notificaciones</button>
					  <div class='btn-group'>
						  <button class='btn btn-default dropdown-toggle' type='button' data-toggle='dropdown'>
						    <span class='glyphicon glyphicon-plus'></span> Opciones <span class='caret'></span>
						  </button>
						  <ul class='dropdown-menu'>
				    		<li><a href='cerrarsesion.php'><span class='glyphicon glyphicon-off'></span> Cerrar sesion</a></li>					
					 ";
					if ($_SESSION['tipo']==1) 
						echo "
				    		<li><a href='cambiarusuario.php'><span class='glyphicon glyphicon-cog'></span> Control-USRS</a></li>
				  		  ";
					if ($_SESSION['tipo']==2 or $_SESSION['tipo']==1) 
							echo "<li><a href='ntemas.php'><span class='glyphicon glyphicon-plus-sign'></span> Añadir nuevo tema</a>
							</li></ul>"; 
					else echo "</ul></div>";
				}	
				else {
					echo "<div class='container'>Bienvenido
					<a href='login.php'>Inicia sesion</a> o <a href='registro.php'>registrate</a>";
				}
				?>
			</p>
			</div>
		</div><hr>
				<div class="row">
					 <div class="col-md-1">
						<img src="images/logo.gif" width='100px' class="img-circle">
					 </div>
					<div class="col-md-11">
				<h1>BLOG DEL ABUELO |
				<?php 
					if (isset($_SESSION['nombre'])) 
						echo $_SESSION['nombre'];
					echo "</h1><hr></div></div>";


				//Aqui termnina el enunciado del nombre
				//Aqui inicia el despliegue de temas del blog
				include_once("settings/settings.inc.php");
				$conexion=@mysql_connect(SQL_HOST, SQL_USER, SQL_PWD);
				@mysql_select_db(SQL_DB, $conexion) or die(mysql_error());
				$sql="select temas.*,  usuarios.nombre from temas, usuarios where temas.id_usuario = usuarios.id order by fecha_pub desc; ";
				$temas=mysql_query($sql, $conexion);
				echo "<table width=90%>";
				while ($tema = @mysql_fetch_array($temas))
				{
					//Consulta de comentarios
					$sql = "select comentarios.*, usuarios.nombre from comentarios, usuarios, temas " .
						"where comentarios.id_usuario = usuarios.id and comentarios.id_tema = temas.id " .
						"and comentarios.id_tema = " . $tema['id'];
					$comentarios=mysql_query($sql, $conexion);

					echo "<tr>";
						echo "<td><b><h2>".$tema['titulo']."</h2></td>";	
						echo "<td align='right' width=50%>";
							//Mostrar botones segun el tipo del usuario
								if (isset($_SESSION['tipo'])) {
									if ($_SESSION['tipo']==2 or $_SESSION['tipo']==1) {	
										echo "<a class='btn btn-default' href='ntemas.php?id=".$tema['id']."'><span class='glyphicon glyphicon-pencil'></span> Editar</a> ";
										echo "<a class='btn btn-danger' href='ntemas.php?ideliminar=".$tema['id']."'><span class='glyphicon glyphicon-trash'></span> Eliminar</a> ";

									}
									//Me gusta
									//SELECT  count(*) from megusta where id_tema=
										$sqllikes="SELECT id, count(*) from megusta where id_tema=".$tema['id'].";";
										$likes=mysql_query($sqllikes, $conexion);
										$like= mysql_fetch_array($likes);
										$num=$like['count(*)'];
										echo "<a class= 'btn btn-success' href='like.php?like=".$tema['id']."'><span class='glyphicon glyphicon-thumbs-up'></span> ".$num." Likes</a> ";
										echo "<a class='btn btn-default' href='ncomentario.php?ncomentario=".$tema['id']."&prev=".$tema['id']."'><span class='glyphicon glyphicon-comment'></span> Comentar</a> ";

								}
					//Cierre de TD y otras etiquetas
					echo "</td>";	
					echo "</tr>";
					echo "<tr><td><h5>".$tema['nombre']."</h5></td><td><i> Publicado el: ".$tema['fecha_pub']."</i></td></tr>";
					echo "<tr><td colspan='2'>".$tema['contenido']."</td></tr>";
					echo "<tr><td colspan='2'><b>Comentarios</b></td></tr>";
					//Arreglo estetico
					$ncomentarios=0;
					while ($comentario = @mysql_fetch_array($comentarios)) {
						echo "<tr>";
							 echo "<td width=80% colspan=2>".$comentario['comentario']; 
							 echo " - <i>".$comentario['nombre']."</i>";
							 if (isset($_SESSION['tipo'])) {
							 	if ($_SESSION['tipo']==1) {	
							 		echo " - <a href='ncomentario.php?idcomentario=".$comentario['id']."&prev=".$tema['id']."'>Editar</a>";
								echo " - <a href='ncomentario.php?idcomentariodelete=".$comentario['id']."&prev=".$tema['id']."'>Eliminar</a>";
								}
							 }
						echo "</td>";
						echo "</tr>";
						$ncomentarios = $ncomentarios+1;
					}
					//Mostrar "Sin comentarios" cuando no haya ninguno
					if ($ncomentarios < 1)
						echo "<tr><td colspan='2'><i>sin comentarios </i><a href='ncomentario.php?ncomentario=".$tema['id']."&prev=".$tema['id']."'>Añadir comentario</a></td></tr>";
				}
				echo "</table>";
				@mysql_close($conexion);
				//Final del blog y temas
			?>
		</div>
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	    <!-- Include all compiled plugins (below), or include individual files as needed -->
	    <script src="js/bootstrap.min.js"></script>
	</body>
	<!--Aqui va un pie de pagina -->
</html>