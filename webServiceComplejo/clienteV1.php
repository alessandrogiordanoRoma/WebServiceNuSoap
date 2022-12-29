<?php 

// Incluimos la biblioteca de NuSOAP (la misma que hemos incluido en el servidor, 
//ver la ruta que le especificamos)
require_once('nusoap.php');
//require_once('NuSoap-PHP-7.0-master/lib/nusoap.php');
// Crear un cliente apuntando al script del servidor (Creado con WSDL) - 
// Las proximas 3 lineas son de configuracion,
// y debemos asignarlas a nuestros parametros
//localhost/webServiceComplejo/servidor.php
$serverURL = 'http://localhost/webServiceComplejo/';	
$serverScript = 'servidor.php';
$metodoALlamar = 'obtenerProductoV1';

// Crear un cliente de NuSOAP para el WebService
$cliente = new nusoap_client("$serverURL/$serverScript?wsdl", 'wsdl');
$cliente->soap_defencoding='UTF-8';
$cliente->decode_utf=FALSE;



echo "<br>";
      echo "<br>";
      echo "<br>";
      
// Se pudo conectar?
$error = $cliente->getError();
if ($error) {
 echo '<pre style="color: red">' . $error  . '</pre>';
 echo '<p style="color:red;'>htmlspecialchars($cliente->getDebug(), ENT_QUOTES).'</p>';
 echo '<br>';
 die();
}else{

	echo "se pudo conectar";
	echo "<br>";
}
//exit();


// 1. Llamar a la funcion getRespuesta del servidor
$result = $cliente->call(
 "$metodoALlamar", // Funcion a llamar
  array(), // Parametros pasados a la funcion
 "uri:$serverURL/$serverScript", // namespace
 "uri:$serverURL/$serverScript/$metodoALlamar" // SOAPAction
);
//print_r($result);
// Verificacion que los parametros estan ok, y si lo estan. mostrar rta.
if ($cliente->fault) {
 //Comprobamos fallos
 echo "<h2>Fault</h2><pre>";
   print_r($result);
   echo "</pre>";
} else {
 $error = $cliente->getError();
 if ($error) {
 echo '<b style="color: red">Error: ' . $error . '</b>';
 } else {
 //echo 'Respuesta: '.$result;
 echo "<br>";
 print_r($result);
 
 $count = count($result);
 echo "<br>";
 print($count);
 echo "<br>";
 echo "<br>";
 }
}


//exit();
for($i=0;$i<$count;$i++){
        
        echo $result[$i]['id_usuario'];
	echo "<br>";
        echo $result[$i]['nombre'];
        echo "<br>";
	echo $result[$i]['apellido_paterno'];
        echo "<br>";
	echo $result[$i]['apellido_materno'];
        echo "<br>";
}
?> 
