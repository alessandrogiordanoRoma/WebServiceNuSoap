<?php 
Error_reporting(0);
// Incorporar la biblioteca nusoap al script, incluyendo nusoap.php (ver imagen de estructura de archivos)
require_once('nusoap.php');
//require_once('NuSoap-PHP-7.0-master/lib/nusoap.php');
// Modificar la siguiente linea con la direccion en la cual se aloja este script
$miURL = 'http://localhost/webServiceComplejo/';	
$server = new soap_server();
$server->configureWSDL('ws_orlando', $miURL);
$server->wsdl->schemaTargetNamespace=$miURL;

$server->xml_encoding = "utf-8";

$server->soap_defencoding = 'UTF-8';

$server->wsdl->addComplexType('producto','complexType','struct','all', ' ',
				array(
				'id_usuario'=>array('name'=>'id_usuario','type'=>'xsd:int'),
				'nombre'=>array('name'=>'nombre','type'=>'xsd:string'),
				'apellido_materno'=>array('name'=>'apellido_materno','type'=>'xsd:string'),
				'apellido_paterno'=>array('name'=>'apellido_paterno','type'=>'xsd:string')));
												
$server->register('obtenerProducto',
			array('id_usuario'=>'xsd:int'),
			array('return'=>'tns:producto'),
			$miURL);

function obtenerProducto($id){
	
	$con = new mysqli("11.254.16.82","rollito","rollito","viaticos");
	$sql = "SELECT id_usuario, 
			nombre,
			apellido_materno,
			apellido_paterno
			FROM usuarios_civ
			where usuarios_civ.id_usuario in ($id)";
				
	$smnt = $con->prepare($sql);
	$smnt->execute();
	$smnt->bind_result($col1,$col2,$col3,$col4);
	$smnt->fetch();
	
	$row[0] = $col1;
	$row[1] = $col2;
	$row[2] = $col3;
	$row[3] = $col4;
	
	return array('id_usuario'=>$row[0],
				  'nombre'=>$row[1],
				  'apellido_materno'=>$row[2],
				  'apellido_paterno'=>$row[3]);
}

$server->wsdl->addComplexType('productoV1','complexType','array','all', ' ',
				array(
				'id_usuario'=>array('name'=>'id_usuario','type'=>'xsd:int'),
				'nombre'=>array('name'=>'nombre','type'=>'xsd:string'),
				'apellido_materno'=>array('name'=>'apellido_materno','type'=>'xsd:string'),
				'apellido_paterno'=>array('name'=>'apellido_paterno','type'=>'xsd:string')));
												
$server->register('obtenerProductoV1',
				array(),
				array('return'=>'tns:productoV1'),
				$miURL);

function obtenerProductoV1(){
	$result=array();			
			
	$mysqli = new mysqli("11.254.16.82","rollito","rollito","viaticos");

	$sql = "SELECT id_usuario, 
			nombre,
			apellido_materno,
			apellido_paterno
			FROM usuarios_civ";
			
 $res = mysqli_query($mysqli, $sql);
 
 while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)){
  
      $id_usuario = $row["id_usuario"];
      $nombre = $row["nombre"]; 
      $apellido_materno = $row["apellido_materno"];
      $apellido_paterno  = $row["apellido_paterno"];
      
      $result[] = array('id_usuario' => $id_usuario,
		       'nombre' => $nombre,
		       'apellido_materno' => $apellido_materno,
		       'apellido_paterno' => $apellido_paterno);
	
		}
	return $result;
	}
	
	//$result2=array();
	//$result2=obtenerProductoV1();
	//print_r($result2);
	
// Las siguientes 2 lineas las aporto Ariel Navarrete. Gracias Ariel
if ( !isset( $HTTP_RAW_POST_DATA ) )
    $HTTP_RAW_POST_DATA = file_get_contents( 'php://input' );

$server->service($HTTP_RAW_POST_DATA);
?> 
