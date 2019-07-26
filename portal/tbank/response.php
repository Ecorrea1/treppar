<?php
session_start();

use Freshwork\Transbank\CertificationBagFactory;
use Freshwork\Transbank\TransbankServiceFactory;
use Freshwork\Transbank\RedirectorHelper;

include 'vendor/autoload.php';

//Obtenemos los certificados y llaves para utilizar el ambiente de integración de Webpay Normal
$bag = CertificationBagFactory::integrationWebpayNormal();
$plus = TransbankServiceFactory::normal($bag);

$result = $plus->getTransactionResult();

$_SESSION['responseCode'] =$result->detailOutput->responseCode;

##########################################################################################
require_once ("../func/cnx.php");
$cnx=conexion();

$id_compra = isset($_GET['id_compra'])?$_GET['id_compra']:null;

if ($result->detailOutput->responseCode == 0) {
    //Transaccion aprobada y se guardar en la base de datos
    
    $sql = "UPDATE compra SET ";
    $sql.= "estado='1' ";
    $sql.= "WHERE id_compra='".$id_compra."'";
    $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
    
    $sql = "UPDATE compra_producto SET ";
    $sql.= "estado='1' ";
    $sql.= "WHERE id_compra='".$id_compra."'";
    $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
    
}else{
	$sql = "UPDATE compra SET ";
    $sql.= "motivo_err='Error En Transaccion' ";
    $sql.= "WHERE id_compra='".$id_compra."'";
    $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
    
    $sql = "DELETE FROM compra_alojam_reservacion ";
    $sql.= "WHERE id_compra='".$id_compra."'";
    $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
    
}
##########################################################################################

$plus->acknowledgeTransaction();

echo RedirectorHelper::redirectBackNormal($result->urlRedirection);

?>