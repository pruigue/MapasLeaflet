<?php
/**
 * Description of Conexion
 *
 * @author Pablo Ruiz
 */
class Conexion {
    public static function conectar(){
        $opciones =array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8");
    $bdo = new PDO('mysql:host=localhost;dbname=mapas', 'root', '2Cfgs',$opciones);
    return $bdo;
    }
}
