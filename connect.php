<?php
$kasutaja='imerkulova21'; //d70420_merk21
$server='localhost'; //d70420.mysql.zonevs.eu
$andmebaas='imerkulova21';
$salasyna='123456'; //d70420_irinabaas
//teeme käsk mis ühendab andmebaasiga
$yhendus=new mysqli($server, $kasutaja, $salasyna, $andmebaas);
$yhendus->set_charset('UTF8');
/*
 * CREATE TABLE loomad(
    id int primary key AUTO_INCREMENT,
    loomanimi varchar(15) unique,
    vanus int,
    pilt text,
    silmadeVarv varchar(15))
*/
?>


