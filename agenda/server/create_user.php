<?php
	require('conector.php');
	$con = new conectorBD();

	$response['conexion'] = $con->iniciarConexion($con->database);
	if ($response['conexion'] == 'ok'){
		$conexion = $con->getConexion();
		$insert = $conexion->prepare('INSERT INTO usuarios (email, nombre, password , fecha_nacimiento) VALUES (?,?,?,?)');
		$insert->bind_param("ssss", $email, $nombre, $password, $fecha_nacimiento);

		$user_password = "123456";
		$email = "mihael@nextu.com";
		$nombre = "mihael";
		$password = password_hash($user_password, PASSWORD_DEFAULT);
		$fecha_nacimiento = "2000-12-12";

		$insert->execute();

		$email = 'juan@nextu.com';
		$nombre = 'juan';
		$password = password_hash($user_password, PASSWORD_DEFAULT);
		$fecha_nacimiento = "2000-12-12";

		$insert->execute();

		$email = 'pablo@nextu.com';
		$nombre = 'pablo';
		$password = password_hash($user_password, PASSWORD_DEFAULT);
		$fecha_nacimiento = "2000-12-12";

		$insert->execute();
		$response['resultado'] = "1";
		$response['msg']= 'Informacio de inicio:';
		$getUsers = $con->consultar(['usuarios'],['*'],$condicion = "");
		while ($fila= $getUsers->fetch_assoc()) {
			$response['msg'].=$fila['email'];
		}
		$response['msg'].= 'contraenia: '.$user_password;
		}else{
			$response['resultado'] == "0";
			$response['msg'] = 'No se pudo conectar a la base de datos';
		}

		//echo json_encode($response);
		if ($response['resultado']=="1") {
			echo "<a class='button' href='../index.php'>Se guardaron los datos correctamente.</a>";
		}else {
			echo "<a class='button' href='../index.php'>Error no se guardaron los datos.</a>";
		}

 ?>
