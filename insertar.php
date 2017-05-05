<?php
include("clases/conect.php");
header("Content-Type: application/json");
$usuario = isset($_POST['usuario']) ? $_POST['usuario']: ''; //NOMBRE DEL USUARIO QUE HIZO LA PETICION
$urlPeticion =  isset($_POST['urlPeticion']) ? $_POST['urlPeticion']: ''; // ID DE LA URL
$accionPeticion = isset($_POST['accionPeticion']) ? $_POST['accionPeticion']: ''; // ACCION A TOMAR
$motivoPeticion = isset($_POST['motivoPeticion']) ? $_POST['motivoPeticion']: ''; // MOTIVO DE LA PETICION
$mensajePeticion = isset($_POST['mensajePeticion']) ? $_POST['mensajePeticion']: ''; // MENSAJE ADICIONAL
$estadoPeticion = '0'; //ESTADO DE LA PETICION AL INCIO SERA UN VALOR VACIO
$gestorPeticion = 'Sin Antender';//GESTOR DE LA PETICION AL INICIO SERA UN VALOR VACIO
//Timezone Managua
date_default_timezone_set("America/Managua");

$timestamp = date("Y-m-d H:i:s");

//AHORA REGISTRAMOS EL MENSAJE
$stmt =  $dataBase->prepare('INSERT INTO ftp_peticiones ( usuario, urlPeticion, accionPeticion, motivoPeticion, mensajePeticion, estadoPeticion, gestorPeticion, timestamp ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ? )');
$stmt->bindParam(1, $usuario, SQLITE3_TEXT);
$stmt->bindParam(2, $urlPeticion, SQLITE3_TEXT);
$stmt->bindParam(3, $accionPeticion, SQLITE3_TEXT);
$stmt->bindParam(4, $motivoPeticion, SQLITE3_TEXT);
$stmt->bindParam(5, $mensajePeticion, SQLITE3_TEXT);
$stmt->bindParam(6, $estadoPeticion, SQLITE3_TEXT);
$stmt->bindParam(7, $gestorPeticion, SQLITE3_TEXT);
$stmt->bindParam(8, $timestamp, SQLITE3_TEXT);
$stmt->execute();

// try{
	//$stmt->execute();
	//$respuestaPositiva ='<div class="alert alert-success" id="respuestaPositiva"><strong><i class="fa fa-check-circle"></i></strong> La peticion se ha enviado.</div>';
	//echo $respuestaPositiva;
// }catch(Exception $e){
	//echo 'Caught exception: ' . $e->getMessage();
	//$respuestaNegativa ='<div class="alert alert-warning" id="respuestaNegativa"><strong><i class="fa fa-exclamation-triangle"></i> Error!</strong> Error en el sistema, no se ha enviado la peticion.</div>';
	//echo $respuestaNegativa;
// }
$dataBase->close(); 
unset($dataBase);
$arrayJSON = array();
$arrayJSON[] = array(
			'usuario'        => $usuario,//tipo de actualizacion
			'urlPeticion'    => $urlPeticion,//mensaje
			'accionPeticion' => $accionPeticion,//fecha de envio
			'motivoPeticion' => $motivoPeticion,
			'mensajePeticion'=> $mensajePeticion,
			'estadoPeticion' => $estadoPeticion,
			'gestorPeticion' => $gestorPeticion,
			'timestamp'		 => $timestamp,
			'actualizacion'  => '1'
);
echo json_encode($arrayJSON);
?>