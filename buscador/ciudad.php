<?php
function leerDatos(){
  $data_file = fopen('./data-1.json', 'r');
  $data = fread($data_file, filesize('./data-1.json'));
  $data = json_decode($data, true);
  fclose($data_file);
  return ($data);
}

function ciudad($datos){
  $getCities = Array();
  foreach ($datos as $cities => $city) {
    if(in_array($city['Ciudad'], $getCities)){
    }else{
      array_push($getCities, $city['Ciudad']);
    }
  }
  echo json_encode($getCities);
}

$datos= leerDatos();
ciudad($datos);
 ?>
