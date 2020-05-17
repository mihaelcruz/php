<?php
	require('conector.php');
	$con = new conectorBD();
	$response['conexion'] = $con->iniciarConexion($con->database);
	if ($response['conexion'] == 'ok') {
		if ($con->eliminarRegistro('eventos', 'id='.$_POST['id'])) {
			$response['msg'] = 'ok';
		}else{
			$response['msg'] = 'Error al eliminar el registro';
		}
	}else{
			$response['msg'] = "error en la comunicacion con la base de datos";
		}
	echo json_encode($response)


 ?>
