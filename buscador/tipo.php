<?php
function leerDatos(){
  $data_file = fopen('./data-1.json', 'r');
  $data = fread($data_file, filesize('./data-1.json'));
  $data = json_decode($data, true);
  fclose($data_file);
  return ($data);
};

function tipo($datos){
  $getTipo = Array();
  foreach ($datos as $tipos => $tipo) {
    if(in_array($tipo['Tipo'], $getTipo)){
    }else{
      array_push($getTipo, $tipo['Tipo']);
    }
  }
  echo json_encode($getTipo);
}
  $datos = leerDatos(); 
  tipo($datos);
 ?>
