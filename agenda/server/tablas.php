<?php
require('conector.php'); 
$con = new ConectorBD();
$usuarios = new Usuarios();
$eventos = new Eventos();
$response['detalle'] = "Se han encontrado los siguientes errores:</br><ol>";
$resonse['usuarios'] = "";
$response['eventos']='';
$result = $con->crearTabla($usuarios->nombreTabla, $usuarios->data);
if( $result == "ok"){
  $response['msg'] = 'ok';
  $response['detalle'] = "ok";
  $response['usuarios'] = 'ok';
}else{
  $response['detalle'] .= "<li>Error al crear la tabla usuarios.</li>";
}
$result = $con->crearTabla($eventos->nombreTabla, $eventos->data);
if( $result == "ok"){
  $response['msg'] = 'ok';
  $response['detalle'] = "ok";
  $response['eventos'] = 'ok';
}else{
  $response['detalle'] .= "<li>Error al crear la tabla eventos.</li>";
}

if($response['eventos'] =='ok' AND $response['usuarios'] == 'ok' ){
  $result =  $con->nuevaRestriccion($eventos->nombreTabla, 'ADD KEY fk_usuarios (fk_usuarios)');
  if( $result == "ok"){
    $response['Index'] = 'ok';
    $response['detalle'] = 'ok';
  }

  $result =  $con->nuevaRelacion($eventos->nombreTabla, $usuarios->nombreTabla, 'fk_usuarioemail_evento', 'fk_usuarios', 'email'); //nombre de la tabla origen, nomvre tabla destino, nombre de la clave foranea, nombre de la columna origen, nombre de columna destino
  if( $result == "ok"){
    $response['Clave Foránea'] = 'ok';
    $response['detalle'] = 'ok';
  }
}else{
  $response['detalle'] .='</ul> </br>Verifique que los datos del usuario utilizado para realizar la conexión en el archivo <code>conector.php</code> cuentr con permisos administrativos en phpmyadmin';
  $response['msg'] = $response['detalle'];
}

echo json_encode($response);
?>
