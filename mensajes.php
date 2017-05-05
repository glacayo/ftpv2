<?php
include("clases/conect.php");
$q = "SELECT * FROM ftp_peticiones";
$res = $dataBase->query($q) or die ($ex->getMessage());
while($timi = $res->fetchArray(SQLITE3_ASSOC))
{
	echo "Mensaje: ".$timi['usuario'];
	echo "<br>";
}
?>