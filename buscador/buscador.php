<?php
$filtroCiudad = $_GET['filtro']['Ciudad'];
$filtroTipo = $_GET['filtro']['Tipo'];
$filtroPrecio =  $_GET['filtro']['Precio'];
$datos = leerDatos();
filtrarDatos($filtroCiudad, $filtroTipo, $filtroPrecio,$datos);

function leerDatos(){
  $data_file = fopen('./data-1.json', 'r');
  $data = fread($data_file, filesize('./data-1.json'));
  $data = json_decode($data, true);
  fclose($data_file);
  return ($data);
};

function filtrarDatos($filtroCiudad, $filtroTipo, $filtroPrecio,$data){
  $itemList = Array();
  if($filtroCiudad == "" and $filtroTipo=="" and $filtroPrecio==""){
    foreach ($data as $index => $item) {
      array_push($itemList, $item);
    }
  }else{
    $menor = $filtroPrecio[0];
    $mayor = $filtroPrecio[1];
      if($filtroCiudad == "" and $filtroTipo == ""){
        foreach ($data as $items => $item) {
            $precio = precioNumero($item['Precio']);
        if ( $precio >= $menor and $precio <= $mayor){
            array_push($itemList,$item );
          }
        }
      }

      if($filtroCiudad != "" and $filtroTipo == ""){
          foreach ($data as $index => $item) {
            $precio = precioNumero($item['Precio']);
            if ($filtroCiudad == $item['Ciudad'] and $precio > $menor and $precio < $mayor){
              array_push($itemList,$item );
            }
        }
      }

      if($filtroCiudad == "" and $filtroTipo != ""){
          foreach ($data as $index => $item) {
            $precio = precioNumero($item['Precio']);
            if ($filtroTipo == $item['Tipo'] and $precio > $menor and $precio < $mayor){
              array_push($itemList,$item );
            }
        }
      }

      if($filtroCiudad != "" and $filtroTipo != ""){
          foreach ($data as $index => $item) {
            $precio = precioNumero($item['Precio']);
            if ($filtroTipo == $item['Tipo'] and $filtroCiudad == $item['Ciudad'] and $precio > $menor and $precio < $mayor){
              array_push($itemList,$item );
            }
        }
      }
  }
  echo json_encode($itemList);
};

function precioNumero($itemPrecio){
  $precio = str_replace('$','',$itemPrecio);
  $precio = str_replace(',','',$precio);
  return $precio;
}
?>
