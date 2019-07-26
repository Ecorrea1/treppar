<?php
session_start();

use Freshwork\Transbank\CertificationBagFactory;
use Freshwork\Transbank\TransbankServiceFactory;
use Freshwork\Transbank\RedirectorHelper;

include 'vendor/autoload.php';

$bag = CertificationBagFactory::integrationWebpayNormal();
$plus = TransbankServiceFactory::normal($bag);
$plus->addTransactionDetail($_SESSION['total_compra'], $_SESSION['id_compra']);// Monto e identificador de la orden
//$response = $plus->initTransaction('http://localhost/trepar/portal/tbank/response.php', 'http://localhost/trepar/portal/tbank/finish.php');

////$response = $plus->initTransaction('http://trepar.cl/portal/tbank/response.php', 'http://trepar.cl/portal/tbank/finish.php');


$response = $plus->initTransaction('https://treppar.cl/portal/tbank/response.php?id_compra='.$_SESSION['id_compra'], 'https://treppar.cl/portal/tbank/finish.php?id_compra='.$_SESSION['id_compra'].'&email_cliente='.$_SESSION['email_cliente']);

##########################################################################################
//Se Guarda $response->token en la base de datos
    require_once ("../func/cnx.php");
    $cnx=conexion();

    $sql = "UPDATE compra SET ";
    $sql.= "token='".$response->token."' ";
    $sql.= "WHERE id_compra='".$_SESSION['id_compra']."'";
    $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
    
    //Limpia arreglos de compra
    if(isset($_SESSION['arr_compra_cabecera_ok'])){
        unset($_SESSION['arr_compra_cabecera_ok']);
    }    
    
    if(isset($_SESSION['arr_compra_detalle_ok'])){
        unset($_SESSION['arr_compra_detalle_ok']);
    }
##########################################################################################

echo RedirectorHelper :: redirectHTML($response->url,$response->token);

?>