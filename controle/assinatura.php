<?php

session_start();
include_once "../repo/documentoCRUD.php";


$codigoDoc = $_GET['codigo'];
$user = $_GET['user'];

$result = assinar($codigoDoc, $user);

if(verificarDoc($codigoDoc)){
    mudarSituacao($codigoDoc);
} 
if($result == 0){
    echo "<script>window.location.replace('../documento.php?result=1&codigo=".$codigoDoc."')</script>";
}else{
    echo "<script>window.location.replace('../documento.php?result=2&codigo=".$codigoDoc."')</script>";
}
