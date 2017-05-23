<?php
//CONECTAMOS A LA BASE DE DATOS
include("clases/conect.php");
//TYPE JSON
header("Content-Type: application/json");
//OBTENEMOS EL GESTOR QUE ESTA MANIPULANDO LA PETICION
$gestorPeticion = $_POST['gestorPeticion']; 
//SI EL GESTOR SOY YO EJECUTAR EL SIGUIENTE CODIGO
if ( $gestorPeticion == "Geovanny" ) {
  $nuevoEstado          = isset($_POST['newStatus']) ? $_POST['newStatus']: '0';
  $IDUpdate             = isset($_POST['IDUpdate']) ? $_POST['IDUpdate']: '';
  $uploader             = isset($_POST['gestorPeticion']) ? $_POST['gestorPeticion']: '';
  $queryAll             = $dataBase->query("SELECT * FROM ftp_peticiones WHERE id = '$IDUpdate'");
  $EstadoPeticionActual = $queryAll->fetchArray(SQLITE3_ASSOC);
  $EstadoPeticion       = $EstadoPeticionActual['estadoPeticion'];
  $GestorPeticion       = $EstadoPeticionActual['gestorPeticion'];
  $SolicitantePeticion  = $EstadoPeticionActual['usuario'];
  $urlPeticion          = $EstadoPeticionActual['urlPeticion'];
  $AccionPeticion       = $EstadoPeticionActual['accionPeticion'];
  //SOLO SI LA PETICION NO HA SIDO TOCADA PODRA REALIZAR LAS SIGUIENTES ACCIONES
  if ( $EstadoPeticion == 0 ) {
    //ELIMINAR SI EL ESTDO DE LA PETICION ES NUEVA
    if ( $nuevoEstado == 3 ) {
      $sql_insertar_estado = $dataBase->prepare("DELETE FROM ftp_peticiones WHERE id = '$IDUpdate'");
      @$sql_insertar_estado->execute();
      $dataBase->close(); 
      unset($dataBase);
    //PROCESANDO PETICION
    }elseif ( $nuevoEstado == 2 ) {
      $sql_insertar_estado = $dataBase->prepare("UPDATE ftp_peticiones SET estadoPeticion='$nuevoEstado', gestorPeticion='$uploader' WHERE id = '$IDUpdate'");
      @$sql_insertar_estado->execute();
      $dataBase->close(); 
      unset($dataBase);
    //PETICION HECHA
    }elseif ( $nuevoEstado == 1 ) {
      $sql_insertar_estado = $dataBase->prepare("UPDATE ftp_peticiones SET estadoPeticion='$nuevoEstado', gestorPeticion='$uploader' WHERE id = '$IDUpdate'");
      @$sql_insertar_estado->execute();
      $dataBase->close(); 
      unset($dataBase);
    }
  }elseif( $EstadoPeticion == 2 ){
    if ( $GestorPeticion == "Geovanny" ) {
      $sql_insertar_estado = $dataBase->prepare("UPDATE ftp_peticiones SET estadoPeticion='$nuevoEstado', gestorPeticion='$uploader' WHERE id = '$IDUpdate'");
      @$sql_insertar_estado->execute();
      if ( $nuevoEstado == 3 ) {
        $sql_insertar_estado = $dataBase->prepare("DELETE FROM ftp_peticiones WHERE id = '$IDUpdate'");
        @$sql_insertar_estado->execute();
        $dataBase->close(); 
        unset($dataBase);
      //PROCESANDO PETICION
      }
    }else{
      echo '<div class="alert alert-warning" id="AlertaAdmin"><strong><i class="fa fa-exclamation-triangle"></i> Error!</strong> No puede realizar esta accion </div>';
    }
  }
}elseif ( $gestorPeticion == "asyi" ) {
  $nuevoEstado          = isset($_POST['newStatus']) ? $_POST['newStatus']: '0';
  $IDUpdate             = isset($_POST['IDUpdate']) ? $_POST['IDUpdate']: '';
  $uploader             = isset($_POST['gestorPeticion']) ? $_POST['gestorPeticion']: '';
  $queryAll             = $dataBase->query("SELECT * FROM ftp_peticiones WHERE id = '$IDUpdate'");
  $EstadoPeticionActual = $queryAll->fetchArray(SQLITE3_ASSOC);
  $EstadoPeticion       = $EstadoPeticionActual['estadoPeticion'];
  $GestorPeticion       = $EstadoPeticionActual['gestorPeticion'];
  $SolicitantePeticion  = $EstadoPeticionActual['usuario'];
  $urlPeticion          = $EstadoPeticionActual['urlPeticion'];
  $AccionPeticion       = $EstadoPeticionActual['accionPeticion'];
  //SOLO SI LA PETICION NO HA SIDO TOCADA PODRA REALIZAR LAS SIGUIENTES ACCIONES
  if ( $EstadoPeticion == 0 ) {
    //ELIMINAR SI EL ESTDO DE LA PETICION ES NUEVA
    if ( $nuevoEstado == 3 ) {
      $sql_insertar_estado = $dataBase->prepare("DELETE FROM ftp_peticiones WHERE id = '$IDUpdate'");
      @$sql_insertar_estado->execute();
      $dataBase->close(); 
      unset($dataBase);
    //PROCESANDO PETICION
    }elseif ( $nuevoEstado == 2 ) {
      $sql_insertar_estado = $dataBase->prepare("UPDATE ftp_peticiones SET estadoPeticion='$nuevoEstado', gestorPeticion='$uploader' WHERE id = '$IDUpdate'");
      @$sql_insertar_estado->execute();
      $dataBase->close(); 
      unset($dataBase);
    //PETICION HECHA
    }elseif ( $nuevoEstado == 1 ) {
      $sql_insertar_estado = $dataBase->prepare("UPDATE ftp_peticiones SET estadoPeticion='$nuevoEstado', gestorPeticion='$uploader' WHERE id = '$IDUpdate'");
      @$sql_insertar_estado->execute();
      $dataBase->close(); 
      unset($dataBase);
    }
  }elseif( $EstadoPeticion == 2 ){
    if ( $GestorPeticion == "asyi" ) {
      $sql_insertar_estado = $dataBase->prepare("UPDATE ftp_peticiones SET estadoPeticion='$nuevoEstado', gestorPeticion='$uploader' WHERE id = '$IDUpdate'");
      @$sql_insertar_estado->execute();
      if ( $nuevoEstado == 3 ) {
        $sql_insertar_estado = $dataBase->prepare("DELETE FROM ftp_peticiones WHERE id = '$IDUpdate'");
        @$sql_insertar_estado->execute();
        $dataBase->close(); 
        unset($dataBase);
      //PROCESANDO PETICION
      }
    }else{
      echo '<div class="alert alert-warning" id="AlertaAdmin"><strong><i class="fa fa-exclamation-triangle"></i> Error!</strong> No puede realizar esta accion </div>';
    }
  }
}
$arrayJSON = array();
$arrayJSON[] = array(
      'nuevoEstado'         => $nuevoEstado,//tipo de actualizacion
      'IDUpdate'            => $IDUpdate,//mensaje
      'gestorPeticion'      => $uploader,//fecha de envio
      'SolicitantePeticion' => $SolicitantePeticion,//Solicitante peticion
      'urlPeticion'         => $urlPeticion,
      'AccionPeticion'      => $AccionPeticion,
      'actualizacion'       => '2'
);
echo json_encode($arrayJSON);

?>