<?php
class DataBase extends SQLite3
{
    function __construct()
    {
        $this->open('db/peticiones.db');
    }
}
$dataBase = new DataBase();
if(!$dataBase){
	echo $dataBase->lastErrorMsg();
} else {
	
}
?>