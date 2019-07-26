<?php
session_start();

require_once ("../func/cnx.php");
$cnx=conexion();

IF (!isset($_POST['token_ws'])){
    echo '
    <br/><br/><br/><br/>
    <center><label style="font: bold 25px Arial;color:#e67e22;">
    
        No se han seleccionado productos para comprar.
    
    </label></center>';
    
    return false;
}

echo '<center>';
echo "<br/><b>Orden Compra:</b> ".$id_compra = isset($_GET['id_compra'])?$_GET['id_compra']:null;
echo "<br/><b>Token:</b> ".$_POST['token_ws'];
echo '</center>';

$email_cliente  = isset($_GET['email_cliente'])?$_GET['email_cliente']:null;
    
    /*
    $sql ="SELECT ";
    $sql.="compra.token ";
    $sql.="FROM compra ";
    $sql.="WHERE id_compra='".$id_compra."'";    
    $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());           
    if (mysql_num_rows($run_sql)){
        while($row=mysql_fetch_array($run_sql)){
            echo "<br/>Token: ".$row['token'];
        }
    }
    */
    
    

IF ($_SESSION['responseCode'] == 0) {
    ##########################################################################################    
    
    
    $sql ="SELECT ";
    $sql.="compra_producto.id_compra_prod, ";
    $sql.="compra_producto.id_compra, ";
    $sql.="compra_producto.tipo_prod, ";
    $sql.="compra_producto.id_prod, ";
    $sql.="compra_producto.nom_prod, ";
    $sql.="compra_producto.id_comuna, ";
    $sql.="man_comuna.nom_comuna, ";
    $sql.="compra_producto.fecha_in, ";
    $sql.="compra_producto.fecha_out, ";
    $sql.="compra_producto.detalle, ";
    $sql.="compra_producto.cant, ";
    $sql.="compra_producto.punit, ";
    $sql.="compra_producto.subtotal, ";
    $sql.="compra_producto.estado, ";
    $sql.="compra_producto.reg_fecha ";
    $sql.="FROM compra_producto ";
    $sql.="INNER JOIN man_comuna ON compra_producto.id_comuna = man_comuna.id_comuna ";
    $sql.="WHERE id_compra='".$id_compra."'";    
    $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());
        
    $datos_compra = "";
    $nom_prod_old = "";
    $total_compra = "";
           
    if (mysql_num_rows($run_sql)){
        while($row=mysql_fetch_array($run_sql)){
            if ($row["nom_prod"]!=$nom_prod_old){
                if ($nom_prod_old!=""){            
                    $datos_compra.='</table><br/>';//cierre detalle anterior
                }
                
                $datos_compra.='<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">'; 
                
                $datos_compra.='<tr style="font:15px Arial; color:#ffffff; background-color:#045FB4;">';                
                $datos_compra.='<td align="right" width="40%">Producto:&nbsp;&nbsp;</td>';
                $datos_compra.='<td align="left" width="60%">'.utf8_decode($row["nom_prod"]).'</td>';
                $datos_compra.='</tr>';
                
                $datos_compra.='<tr style="font:15px Arial; color:#ffffff; background-color:#045FB4;">';                
                $datos_compra.='<td align="right">Comuna:&nbsp;&nbsp;</td>';
                $datos_compra.='<td align="left">'.utf8_decode($row["nom_comuna"]).'</td>';
                $datos_compra.='</tr>';
                
                $datos_compra.='<tr style="font:15px Arial; color:#ffffff; background-color:#045FB4;">';                
                $datos_compra.='<td align="right">Fecha Ingreso:&nbsp;&nbsp;</td>';
                $datos_compra.='<td align="left">'.date('d-m-Y',strtotime($row["fecha_in"])).'</td>';
                $datos_compra.='</tr>';
                
                $datos_compra.='<tr style="font:15px Arial; color:#ffffff; background-color:#045FB4;">';                
                $datos_compra.='<td align="right">Fecha Salida:&nbsp;&nbsp;</td>';
                $datos_compra.='<td align="left">'.date('d-m-Y',strtotime($row["fecha_out"])).'</td>';
                $datos_compra.='</tr>';                
                $datos_compra.='</table>';
            }
            
            if ($row["nom_prod"]!=$nom_prod_old){
                
                $datos_compra.='<table width="98%" rules="rows" border="0" cellspacing="0" cellpadding="0" align="center" style="border:1px solid;">'; 
                $datos_compra.='<tr style="font:15px Arial; color:#ffffff; background-color:#045FB4;">';             
                $datos_compra.='<td align="center" width="64%">Detalle</td>';
                $datos_compra.='<td align="center" width="12%">Cant</td>';
                $datos_compra.='<td align="center" width="12%">P.Unit</td>';
                $datos_compra.='<td align="center" width="12%">SubTotal</td>';
                $datos_compra.='</tr>';
                
                $datos_compra.='<tr style="font:15px Arial; color:#045FB4;">';      
                $datos_compra.='<td align="center">'.utf8_decode($row["detalle"]).'</td>';
                $datos_compra.='<td align="center">'.$row["cant"].'</td>';
                $datos_compra.='<td align="center">'.number_format(($row["punit"]), 0, ",", ".").'</td>';
                $datos_compra.='<td align="center">'.number_format(($row["subtotal"]), 0, ",", ".").'</td>';
                $datos_compra.='</tr>';                
                
            }else{
                
                $datos_compra.='<tr style="font:15px Arial; color:#045FB4;">';
                $datos_compra.='<td align="center">'.utf8_decode($row["detalle"]).'</td>';
                $datos_compra.='<td align="center">'.$row["cant"].'</td>';
                $datos_compra.='<td align="center">'.number_format(($row["punit"]), 0, ",", ".").'</td>';
                $datos_compra.='<td align="center">'.number_format(($row["subtotal"]), 0, ",", ".").'</td>';
                $datos_compra.='</tr>';                
            }
            
            $nom_prod_old = $row["nom_prod"];
            $total_compra = $total_compra+$row["subtotal"];
        }
        $datos_compra.='</table>';
        
        $datos_compra.='<br/><table width="98%" rules="rows" border="0" cellspacing="0" cellpadding="0" align="center" style="border:1px solid;">'; 
        $datos_compra.='<tr style="font:15px Arial; color:#ffffff; background-color:#045FB4;">';        
        $datos_compra.='<td align="center">Total Compra: $'.number_format(($total_compra), 0, ",", ".").'</td>'; 
        $datos_compra.='</tr>'; 
        $datos_compra.='</table>';
    }
        
    ##################################################################################
    ##Se Envia Email
        
    require_once("../../admin/app/phpmailer5.2/class.phpmailer.php");
        
    ## Send email
    $mail = new PHPMailer(true);
    $mail->IsSMTP();
    $mail->SMTPAuth     = true;
    $mail->Port         = 25;
    $mail->Host         = "mail.treppar.cl";
    $mail->Username     = "compras@treppar.cl";
    $mail->Password     = "comprastreppar";
    $mail->From         = "compras@treppar.cl";
    $mail->FromName     = "compras@treppar.cl";
    $mail->AddAddress($email_cliente); //EMAIL DESTINO
    $mail->AddCC('compras@treppar.cl');
    
    $mail->IsHTML(true);//El correo se envía como HTML
    $mail->Subject      = "Confirmacion Compra Treppar";
    $mail->Body         = "<center><label style='font:bold 15px Arial; color:#045FB4;'>Gracias por su compra.</label></center>".$datos_compra;
    $mail->AddAttachment("../img/LogoTreppar.png");
        
    $exito = $mail->Send(); //Envía el correo.

    if($exito){
        
        echo '
        <br/>
        <center>
        
        <img src="../img/logo_treppar.png" height="100px">
        
        <br/><br/>
                    
        <label style="font:bold 35px Arial; color:#39BBF7;">
            Gracias por su compra.<br/>Se ha enviado el detalle de la compra a su email.
        </label>
        
        <br/><br/>'.utf8_encode($datos_compra).'<br/>
        
        
        
        </center>';
        
    }else{
        
        echo '
        <br/>
        <center>
        
        <img src="../img/logo_treppar.png" height="100px">
        
        <br/><br/>
                         
        <label style="font:bold 35px Arial; color:#e67e22;">
            Gracias por su compra.
            <br/>Se ha producido un error al enviar de la compra a su email.
            <br/>Contacte al Administrador.
        </label>
        
        </center>';
    }

}ELSE{
    
    echo '
    <br/><br/><br/><br/>
    <center><label style="font: bold 25px Arial;color:#e67e22;">
    
        Orden de Compra '.$id_compra.' rechazada.<br/>
        Las posibles causas de este rechazo son:<br/><br/>
        * Error en el ingreso de los datos de su tarjeta de Cr&eacute;dito o D&eacute;bito (fecha y/o c&oacute;digo de seguridad).<br/>
        * Su tarjeta de Cr&eacute;dito o D&eacute;bito no cuenta con saldo suficiente.<br/>
        * Tarjeta a&uacute;n no habilitada en el sistema financiero.<br/>
    
    </label></center>';
}
?>