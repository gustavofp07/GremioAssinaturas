<?php

session_start();
include_once "../repo/documentoCRUD.php";


$codigoDoc = $_GET['codigo'];

$result = cancelarSubmissao($codigoDoc);

if($result == 0){
    echo  "<script>window.location.replace('../administrador.php?result=1');</script>";
}else{
    echo  "<script>window.location.replace('../administrador.php?result=2');</script>";
}
