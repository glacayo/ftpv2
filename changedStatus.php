<?php
$gestorPeticion = $_POST['gestorPeticion']; 
if ( $gestorPeticion == "Geovanny" ) {
  $nuevoEstado = 0;
  if ( $_POST ) {
    $nuevoEstado = isset($_POST['newStatus']) ? $_POST['newStatus']: '';
    $IDUpdate = isset($_POST['IDUpdate']) ? $_POST['IDUpdate']: ''; 
    $uploader = isset($_POST['gestor_peticion']) ? $_POST['gestor_peticion']: '';
    $urlMessage = isset($_POST['urlMessage']) ? $_POST['urlMessage']: ''; 

    $queryAll = $dataBase->query("SELECT estado_peticion, gestor_peticion FROM ftp_peticiones WHERE id_peticion = '$IDUpdate'");
    $EstadoPeticionActual = $queryAll->fetchArray(SQLITE3_ASSOC);
    $EstadoPeticion = $EstadoPeticionActual['estado_peticion'];
    $GestorPeticion = $EstadoPeticionActual['gestor_peticion'];

    //SOLO SI LA PETICION NO HA SIDO TOCADA PODRA REALIZAR LAS SIGUIENTES ACCIONES
    if ( $EstadoPeticion == 0 ) {
      //ELIMINAR SI EL ESTDO DE LA PETICION ES NUEVA
      if ( $nuevoEstado == 3 ) {
        $sql_insertar_estado = $dataBase->prepare("DELETE FROM ftp_peticiones WHERE id_peticion = '$IDUpdate'");
        @$sql_insertar_estado->execute();
      //PROCESANDO PETICION
      }elseif ( $nuevoEstado == 2 ) {
        $sql_insertar_estado = $dataBase->prepare("UPDATE ftp_peticiones SET estado_peticion='$nuevoEstado', gestor_peticion='$uploader' WHERE id_peticion = '$IDUpdate'");
        @$sql_insertar_estado->execute();
      //PETICION HECHA
      }elseif ( $nuevoEstado == 1 ) {
        $sql_insertar_estado = $dataBase->prepare("UPDATE ftp_peticiones SET estado_peticion='$nuevoEstado', gestor_peticion='$uploader' WHERE id_peticion = '$IDUpdate'");
        @$sql_insertar_estado->execute();
      }
    }elseif( $EstadoPeticion == 2 ){
      if ( $GestorPeticion == "Geovanny" ) {
        $sql_insertar_estado = $dataBase->prepare("UPDATE ftp_peticiones SET estado_peticion='$nuevoEstado', gestor_peticion='$uploader' WHERE id_peticion = '$IDUpdate'");
        @$sql_insertar_estado->execute();
        if ( $nuevoEstado == 3 ) {
          $sql_insertar_estado = $dataBase->prepare("DELETE FROM ftp_peticiones WHERE id_peticion = '$IDUpdate'");
          @$sql_insertar_estado->execute();
        //PROCESANDO PETICION
        }
      }else{
        echo '<div class="alert alert-warning" id="AlertaAdmin"><strong><i class="fa fa-exclamation-triangle"></i> Error!</strong> No puede realizar esta accion </div>';
      }
    }
  }
}elseif (  $gestorPeticion == "Reyna"  ) {
  $nuevoEstado = 0;
  if ( $_POST ) {
    $nuevoEstado = isset($_POST['newStatus']) ? $_POST['newStatus']: '';
    $IDUpdate = isset($_POST['IDUpdate']) ? $_POST['IDUpdate']: ''; 
    $uploader = isset($_POST['gestor_peticion']) ? $_POST['gestor_peticion']: '';
    $urlMessage = isset($_POST['urlMessage']) ? $_POST['urlMessage']: ''; 

    $queryAll = $dataBase->query("SELECT estado_peticion, gestor_peticion FROM ftp_peticiones WHERE id_peticion = '$IDUpdate'");
    $EstadoPeticionActual = $queryAll->fetchArray(SQLITE3_ASSOC);
    $EstadoPeticion = $EstadoPeticionActual['estado_peticion'];
    $GestorPeticion = $EstadoPeticionActual['gestor_peticion'];

    //SOLO SI LA PETICION NO HA SIDO TOCADA PODRA REALIZAR LAS SIGUIENTES ACCIONES
    if ( $EstadoPeticion == 0 ) {
      //ELIMINAR SI EL ESTDO DE LA PETICION ES NUEVA
      if ( $nuevoEstado == 3 ) {
        $sql_insertar_estado = $dataBase->prepare("DELETE FROM ftp_peticiones WHERE id_peticion = '$IDUpdate'");
        @$sql_insertar_estado->execute();
      //PROCESANDO PETICION
      }elseif ( $nuevoEstado == 2 ) {
        $sql_insertar_estado = $dataBase->prepare("UPDATE ftp_peticiones SET estado_peticion='$nuevoEstado', gestor_peticion='$uploader' WHERE id_peticion = '$IDUpdate'");
        @$sql_insertar_estado->execute();
      //PETICION HECHA
      }elseif ( $nuevoEstado == 1 ) {
        $sql_insertar_estado = $dataBase->prepare("UPDATE ftp_peticiones SET estado_peticion='$nuevoEstado', gestor_peticion='$uploader' WHERE id_peticion = '$IDUpdate'");
        @$sql_insertar_estado->execute();
      }
    }elseif( $EstadoPeticion == 2 ){
      if ( $GestorPeticion == "Reyna" ) {
        $sql_insertar_estado = $dataBase->prepare("UPDATE ftp_peticiones SET estado_peticion='$nuevoEstado', gestor_peticion='$uploader' WHERE id_peticion = '$IDUpdate'");
        @$sql_insertar_estado->execute();
        if ( $nuevoEstado == 3 ) {
          $sql_insertar_estado = $dataBase->prepare("DELETE FROM ftp_peticiones WHERE id_peticion = '$IDUpdate'");
          @$sql_insertar_estado->execute();
        //PROCESANDO PETICION
        }
      }else{
        echo '<div class="alert alert-warning" id="AlertaAdmin"><strong><i class="fa fa-exclamation-triangle"></i> Error!</strong> No puede realizar esta accion </div>';
      }
    }
  }
}else{
  $nuevoEstado = 0;
  if ( $_POST ) {
    $nuevoEstado = isset($_POST['newStatus']) ? $_POST['newStatus']: '';
    $IDUpdate = isset($_POST['IDUpdate']) ? $_POST['IDUpdate']: ''; 
    $uploader = isset($_POST['gestor_peticion']) ? $_POST['gestor_peticion']: '';
    $urlMessage = isset($_POST['urlMessage']) ? $_POST['urlMessage']: ''; 
    $queryAll = $dataBase->query("SELECT estado_peticion FROM ftp_peticiones WHERE id_peticion = '$IDUpdate'");
    $EstadoPeticionActual = $queryAll->fetchArray(SQLITE3_ASSOC);
    $EstadoPeticion = $EstadoPeticionActual['estado_peticion'];
    if ( $EstadoPeticion == 2 ) {
      
    }elseif ( $EstadoPeticion == 0) {
      if ( $nuevoEstado == 3 ) {
        $sql_insertar_estado = $dataBase->prepare("DELETE FROM ftp_peticiones WHERE id_peticion = '$IDUpdate'");
        @$sql_insertar_estado->execute();
      }else{

      }
    }
  }
}
?>