<?php 
//(ini_set('display_errors', 0);

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
$metodoALlamar = 'obtenerProducto';

// Crear un cliente de NuSOAP para el WebService
$cliente = new nusoap_client("$serverURL/$serverScript?wsdl", 'wsdl');
$cliente->soap_defencoding='UTF-8';
$cliente->decode_utf=FALSE;

// Se pudo conectar?
$error = $cliente->getError();
if ($error) {
 echo '<pre style="color: red">' . $error  . '</pre>';
 echo '<p style="color:red;'>htmlspecialchars($cliente->getDebug(), ENT_QUOTES).'</p>';
 die();
}else{

	echo "se pudo conectar";
	echo "<br>";
}
//exit();

//$parametro = $_GET['idProducto'];
$parametro = '7';

// 1. Llamar a la funcion getRespuesta del servidor
$result = $cliente->call(
 "$metodoALlamar", // Funcion a llamar
 array('id_usuario' => "$parametro"), // Parametros pasados a la funcion
 "uri:$serverURL/$serverScript", // namespace
 "uri:$serverURL/$serverScript/$metodoALlamar" // SOAPAction
);

// Verificacion que los parametros estan ok, y si lo estan. mostrar rta.
if ($cliente->fault) {
 echo '<b>Error: ';
 print_r($result);
 echo '</b>';
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
 }
}


//exit();
echo "<br>";
print '<h1>Producto<h1>'
		.'<br>Id producto : '.$result['id_usuario']  
		.'<br>Titulo :  '.$result['nombre']  
		.'<br>Descripcion : '.$result['apellido_paterno']  
		.'<br>Precio : '.$result['apellido_materno'];  
	
?> 
