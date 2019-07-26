<?php
    session_start();
    require_once ("func/cnx.php");
?>

<script src="func/ajax.js" type="text/javascript"></script>
<script src="func/cambio_clave.js" type="text/javascript"></script>
<script src="func/validaciones.js" type="text/javascript"></script>
<link href="css/formatos.css" type="text/css" rel="stylesheet"  media="screen"/>
<script src="func/jquery.min.js" type="text/javascript"></script>
<script src="func/jquery.alerts.js" type="text/javascript"></script>
<link href="func/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen" />

<?php

$op=isset($_GET['op'])?$_GET['op']:null;

$cambio_clave= new cambio_clave();
switch($op){
case'1':
    $cambio_clave->inicio_cambio_clave();
    break;

case'2':
    $cambio_clave->grabar_cambio_clave();
    break;

}

class cambio_clave{

###########################################################################################################
public function inicio_cambio_clave(){
        echo '
        <BODY>                
        <input type="hidden" id="rut" value="'.$_SESSION['log_rut'].'">
                
        <div class="titulo" align="center">            
            <div class="titulo1"><img src="img/icono_cambio_clave.png"/>&nbsp;&nbsp;Cambio Clave</div>
        </div>
        
        <div class="panel1">
        <table border="0" cellpadding="0" cellspacing="0" width="80%" align="center" class="etq1">
        <tr height="30px">    
            <td width="50%">Usuario:</td>       
            <td width="50%"><label>'.$_SESSION['log_rut']." / ".$_SESSION['log_nom'].'</label></td>
        </tr>    
                    
        <tr height="30px">     
            <td>Clave Actual:</td>  
            <td><input type="password" id="clave_actual" size="10" maxlength="6" class="txt2"/>
                <br/><label id="msn_pass1" class="msn_err"></label>
            </td>   
        </tr>
        
        <tr height="30px">      
            <td colspan="2"><hr size="1" color="#333"></td> 
        </tr>
        
        <tr height="30px">      
            <td>Clave Nueva:</td>               
            <td><input type="password" id="clave_nueva1" size="10" maxlength="6" class="txt1"/>
                <br/><label id="msn_pass2" class="msn_err"></label>
            </td>   
        </tr>
        
        <tr height="30px">      
            <td>Confirmar Clave Nueva:</td>     
            <td><input type="password" id="clave_nueva2" size="10" maxlength="6" class="txt1"/>
                <br/><label id="msn_pass3" class="msn_err"></label>
            </td>   
        </tr>
        
        <tr height="30px">             
            <td colspan="2"><hr size="1" color="#333"></td>
        </tr>
        
        <tr height="30px">                 
            <td align="center" colspan="2" height="40">
                <input type="button" value="Aceptar" onclick="grabar_cambio_clave();"/>
            </td>
        </tr>
        </table>
        </div>
        
        <div id="salida"></div>
        
        </BODY>'; 
}

public function grabar_cambio_clave(){    
    $conexion=conexion();
    date_default_timezone_set("Chile/Continental");
    
    $rut            = guardian($_GET['rut']);
    $clave_actual   = guardian(sha1($_GET['clave_actual'])); //funcion sha1 permite encriptar la clave         
    $clave_nueva1   = guardian(sha1($_GET['clave_nueva1'])); //funcion sha1 permite encriptar la clave
    
    $sql="SELECT * FROM man_usuario ";        
    $sql.="WHERE rut='".$rut."' AND clave='".$clave_actual."' AND estado='1'"; 
    $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
    if(mysql_num_rows($run_sql)==1){            
        $sql = "UPDATE man_usuario SET ";           
        $sql.= "clave='".$clave_nueva1."',";
        $sql.= "reg_rut='".$_SESSION['rut']."',"; 
        $sql.= "reg_fecha='".date('Y-m-d H:i:s')."' ";
    	$sql.= "WHERE rut='".$rut."'";
        $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ()); 
        echo '<input type="hidden" id="eco_grabar" value="update_ok"/>';
    }else{
        echo '<input type="hidden" id="eco_grabar" value="err_update"/>';
    } 
}

###########################################################################################################

} // FIN CASE CLASS
?>        
