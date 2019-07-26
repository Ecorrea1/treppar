<?php
session_start();

require_once ("func/cnx.php");
$op = isset($_GET['op'])?$_GET['op']:null;
?>

<html>
<head>
    
    <title>turismo</title>
   <!-- icono Web -->
   <link href="img/icono_web.png" type="image/x-icon" rel="shortcut icon"/>
   
    <!-- ajax -->
    <script src="func/ajax.js" type="text/javascript"></script>

    <!-- func - jquery - alert - confirm-->
    <script src="func/jquery.min.js" type="text/javascript"></script>
    <script src="func/jquery.alerts.js" type="text/javascript"></script>
    <link href="func/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen"/>
  
    <!--formatos - validaciones --> 
    <link href="css/formato_usuario.css" type="text/css" rel="stylesheet"  media="screen"/>
    <link href="css/formato_traductor.css" type="text/css" rel="stylesheet"  media="screen"/>
    <script src="func/validaciones.js" type="text/javascript"></script>   
    <script src="func/tour_usuario_miperfil.js" type="text/javascript"></script>
    
    <!--Google translate --> 
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    
</head>
<body class="body">

<?php
$registro_cliente= new registro_cliente();
switch($op){
##############################################################
## 2) CAMBIAR CLAVE
    case'21':
        $registro_cliente->grabar_cambioclave_21();
        break;   


##############################################################
## 1) ACTUALIZAR MIS DATOS
    case'11':
        $registro_cliente->inicio_11();
        break;   
        
    case'12':
        $registro_cliente->buscar_misdatos_actualizar_12();
        break;
        
    case'13':
        $registro_cliente->grabar_misdatos_actualizar_13();
        break;

/*       
##############################################################
## 6) MIS DATOS COMPRA
    case'61':
        $registro_cliente->confirma_misdatos_comprar_61();
        break;
        
    case'62':
        $registro_cliente->grabar_misdatos_comprar_62();
        break;
*/
    }

class registro_cliente{

##############################################################
## PANTALLA INICIAL
public function inicio_11(){
    $cnx=conexion();    
    date_default_timezone_set("Chile/Continental");    
   
    echo '
    <input type="button" value="Salir" class="bt_amarillo" style="position:absolute;" onclick="window.close();"/>
    <div id="google_translate_element" class="traductor"></div>';
    
    //PESTAÑAS
    echo '
    <br/>
    
    <center>
        <label id="pesta1" class="pesta_in" style="text-align:center;" onclick="javascript:activa_pesta('."'1'".');">Actualizar Mis Datos</label>
        <label id="pesta2" class="pesta_out" style="text-align:center;" onclick="javascript:activa_pesta('."'2'".');">Cambiar Clave</label>        
    </center>';
    
    ##1-ACTUALIZAR MIS DATOS#############################################################################################
    echo'
    <DIV id="contenido1" class="contenido" style="display:block;">';
       
        echo '
        <table width="80%" border="0" cellspacing="0" cellpadding="0" class="etq1" align="center">
          
        <tr height="40px">
            <td width="50%" align="center"><label class="msn_err">* </label>Email:<br/>';
                if ( isset($_SESSION['log_email'])){
                    echo '<input type="email" id="email_1" style="width:80%" maxlength="100" placeholder="xxxxx@xxxxx.com" value="'.$_SESSION['log_email'].'" class="txt1" onblur="valida_mail(this);" onclick="limpia_actualizar_misdatos();"/>';
                }else{
                    echo '<input type="email" id="email_1" style="width:80%" maxlength="100" placeholder="xxxxx@xxxxx.com" class="txt1" onblur="valida_mail(this);" onclick="limpia_actualizar_misdatos();"/>'; 
                }
                echo '                
                <br><label id="msn_email_1" class="msn_err"></label>
            </td>
       
            <td width="50%" align="center"><label class="msn_err">* </label>Clave:<br/>
                <input type="password" id="clave_1" style="width:80%" maxlength="6" class="txt1" onclick="limpia_actualizar_misdatos();"/>
                <br/><label id="msn_clave_1" class="msn_err"></label>
            </td>            
        </tr>        
        <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>
        
        <tr>
            <td colspan="2" align="center">
                <input type="button" title="Buscar Datos" value="Buscar Datos" class="bt_aceptar"  style="width:90%" onclick="javascript:buscar_actualizar_misdatos();">
            </td>
        </tr>
        </table>';    
        
        //FORMULARIO
        echo '    
        <div id="div_datos_1"></div>';
        
        
    echo '    
    </DIV>';
    ##-FIN ACTUALIZAR MIS DATOS###############################################################################################
    
    ##2-CAMBIAR CLAVE###################################################################################################
    echo'
    <DIV id="contenido2" class="contenido" style="display:none;">
    
        <table width="80%" border="0" cellspacing="0" cellpadding="0" class="etq1" align="center">
        <tr height="40px">
            <td width="50%" align="center"><label class="msn_err">* </label>Email:<br/>';
                if ( isset($_SESSION['log_email'])){
                    echo '<input type="email" id="email_2" style="width:80%" maxlength="100" placeholder="xxxxx@xxxxx.com" value="'.$_SESSION['log_email'].'" class="txt1" onblur="valida_mail(this);"/>';
                }else{
                    echo '<input type="email" id="email_2" style="width:80%" maxlength="100" placeholder="xxxxx@xxxxx.com" class="txt1" onblur="valida_mail(this);"/>';   
                }
                echo '                
                <br><label id="msn_email_2" class="msn_err"></label>
            </td>
       
            <td width="50%" align="center"><label class="msn_err">* </label>Clave Actual:<br/>
                <input type="password" id="clave_actual_2" style="width:80%" maxlength="6" class="txt1"/>
                <br/><label id="msn_clave1_2" class="msn_err"></label>
            </td>            
        </tr>
        
        <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>
        
        <tr height="40px">
            <td align="center"><label class="msn_err">* </label>Clave Nueva:<br/>
                <input type="password" id="clave_nueva1_2" style="width:80%" maxlength="6" class="txt1"/>
                <br/><label id="msn_clave2_2" class="msn_err"></label>
            </td>
            
            <td align="center"><label class="msn_err">* </label>Confirmaci&oacute;n Clave Nueva:<br/>
                <input type="password" id="clave_nueva2_2" style="width:80%" maxlength="6" class="txt1"/>
                <br/><label id="msn_clave3_2" class="msn_err"></label>
            </td>
        </tr>
        
        <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>
        
        <tr height="40px">       
            <td align="center" colspan="2">
                <input type="button" title="Grabar" value="Grabar" class="bt_aceptar" style="width:90%" onclick="javascript:grabar_cambioclave();">
            </td>
        </tr>
        </table>
    </DIV>';
    ##2-FIN CAMBIAR CLAVE################################################################################################
    
    echo '<div id="salida"></div>';
}

##############################################################
## 1) ACTUALIZAR MIS DATOS
##############################################################

public function buscar_misdatos_actualizar_12(){    
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    
    $email  = guardian(strtolower($_GET['email']));//todo a minusculas
    $clave  = guardian(sha1($_GET['clave'])); //funcion sha1 permite encriptar la clave
    
    $sql="SELECT ";
    $sql.="man_cliente.email, ";
    $sql.="man_cliente.nombre, ";
    $sql.="man_cliente.apellido, ";
    $sql.="man_cliente.fecha_nacim, ";
    $sql.="man_cliente.pais, ";
    $sql.="man_cliente.fono, ";
    $sql.="man_cliente.ciudad, ";
    $sql.="man_cliente.domicilio, ";
    $sql.="man_cliente.rut, ";
    $sql.="man_cliente.dni, ";
    $sql.="man_cliente.pasaporte ";
    $sql.="FROM man_cliente ";           
    $sql.="WHERE email='".$email."' AND clave='".$clave."'";                    
    $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());     
     
    if (mysql_num_rows($run_sql)){                        
        while($row=mysql_fetch_array($run_sql)){           
            
            echo '            
            <table width="80%" border="0" cellspacing="0" cellpadding="0" class="etq1" align="center">        
            <tr height="40px">
                <td width="50%" align="center"><label class="msn_err">* </label>Nombres:<br/>
                    <input type="text" id="nombre_1" value="'.$row['nombre'].'" style="width:80%" maxlength="50" class="txt1" onblur="valida_alfanum(this);"/>
                    <br><label id="msn_nombre_1" class="msn_err"></label>
                </td>
                
                <td width="50%" align="center"><label class="msn_err">* </label>Apellidos:<br/>
                    <input type="text" id="apellido_1" value="'.$row['apellido'].'" style="width:80%" maxlength="50" class="txt1" onblur="valida_alfanum(this);"/>
                    <br><label id="msn_apellido_1" class="msn_err"></label>
                </td>
            </tr>
            
            <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>
            
            <tr height="40px">
                <td align="center"><label class="msn_err">* </label>Fecha Nacimiento:<br/>
                    <input type="date" id="fecha_nacim_1" value="'.$row['fecha_nacim'].'" style="width:80%" class="txt1">
                    <br/><label id="msn_nacim_1" class="msn_err"></label>
                </td>
                
                <td align="center"><label class="msn_err">* </label>Pa&iacute;s:<br/>';       
                    $sql2 ="SELECT ";
                    $sql2.="man_pais.iso3, ";  
                    $sql2.="man_pais.pais_es ";
                    $sql2.="FROM man_pais ";
                    $sql2.="ORDER BY pais_es";
                    $run_sql2=mysql_query($sql2) or die ('ErrorSql > '.mysql_error ());
                    if (mysql_num_rows($run_sql2)){
                        echo '
                        <select id="pais_1" style="width:80%" class="txt1">
                        <option value=""/>--Seleccione Pais--</option>';
                        
                        while($row2=mysql_fetch_array($run_sql2)){
                            if ($row['pais']==$row2['iso3']){
                                echo '<option value="'.$row2['iso3'].'" selected/>'.$row2['pais_es'].'</option>';
                            }else{
                                echo '<option value="'.$row2['iso3'].'"/>'.$row2['pais_es'].'</option>';
                            }
                        }              
                        echo '
                        </select>';
                    }
                    echo '
                    <br><label id="msn_pais_1" class="msn_err"></label>
                </td>
            </tr>
                
            <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>
            
            <tr height="40px">
                <td align="center"><label class="msn_err">* </label>Fono:<br/>
                    <input type="text" id="fono_1" value="'.$row['fono'].'" style="width:80%" maxlength="50" placeholder="Ej: 56 9 1234 5678" class="txt1" onblur="valida_alfanum(this);"/>
                    <br><label id="msn_fono_1" class="msn_err"></label>
                </td>
                
                <td align="center">Ciudad:<br/>
                    <input type="text" id="ciudad_1" value="'.$row['ciudad'].'" style="width:80%" maxlength="100" class="txt2" onblur="valida_alfanum(this);"/>
                    <br><label id="msn_ciudad_1" class="msn_err"></label>
                </td>
            </tr>
            
            <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>
            
            <tr height="40px">  
                <td align="center">Domicilio:<br/>
                    <input type="text" id="domicilio_1" value="'.$row['domicilio'].'" style="width:80%" maxlength="100" class="txt2" onblur="valida_alfanum(this);"/>
                    <br><label id="msn_domicilio_1" class="msn_err"></label>
                </td>
                
                <td align="center"><label class="msn_err">* </label>';
                    if ($row['rut']!=""){
                        echo '
                        <input type="radio" name="ci_1" value="rut" onclick="activar_ci_actualizar_misdatos();" checked/>Rut-Chi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="ci_1" value="dni" onclick="activar_ci_actualizar_misdatos();"/>Dni-Extranjero&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="ci_1" value="pasaporte" onclick="activar_ci_actualizar_misdatos();"/>Pasaporte&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        
                        <input type="text" id="txtci_1" style="width:80%;" maxlength="10" class="txt1" placeholder="Rut (Ej: 11111111-1)" value="'.$row['rut'].'">';
                        
                    }else if ($row['dni']!=""){
                        echo '
                        <input type="radio" name="ci_1" value="rut" onclick="activar_ci_actualizar_misdatos();"/>Rut-Chi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="ci_1" value="dni" onclick="activar_ci_actualizar_misdatos();" checked/>Dni-Extranjero&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="ci_1" value="pasaporte" onclick="activar_ci_actualizar_misdatos();"/>Pasaporte&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        
                        <input type="text" id="txtci_1" style="width:80%;" maxlength="10" class="txt1" placeholder="Dni / Extranjero" value="'.$row['dni'].'">';                        
                        
                    }else if ($row['pasaporte']!=""){
                        echo '
                        <input type="radio" name="ci_1" value="rut" onclick="activar_ci_actualizar_misdatos();"/>Rut-Chi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="ci_1" value="dni" onclick="activar_ci_actualizar_misdatos();"/>Dni-Extranjero&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="ci_1" value="pasaporte" onclick="activar_ci_actualizar_misdatos();" checked/>Pasaporte&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        
                        <input type="text" id="txtci_1" style="width:80%;" maxlength="10" class="txt1" placeholder="Pasaporte" value="'.$row['pasaporte'].'">';                    
                    }
                    echo '
                    <br><label id="msn_ci_1" class="msn_err"></label>
                </td>
            </tr>
            
            <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>
            
            <tr height="40px"> 
                <td align="center" colspan="2">
                    <input type="button" title="Grabar" value="Grabar" class="bt_aceptar" style="width:90%" onclick="javascript:grabar_actualizar_misdatos();">
                </td>
            </tr>            
            </table>
            <input type="hidden" id="eco_buscar_misdatos_1" value="ok">';
        }        

    }else{
            echo '
            <input type="hidden" id="eco_buscar_misdatos_1" value="err">
            <br/><center><label class="msn_err">No se encontraron resultados.</label></center>';
    }
}

public function grabar_misdatos_actualizar_13(){  
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    
    $email          = guardian(strtolower($_GET['email']));//todo a minusculas
    $nombre         = ucwords(strtolower(guardian($_GET['nombre'])));//1era Letra De Cada Palabra Mayuscula
    $apellido       = ucwords(strtolower(guardian($_GET['apellido'])));//1era Letra De Cada Palabra Mayuscula
    $fecha_nacim    = isset($_GET['fecha_nacim'])?$_GET['fecha_nacim']:null;
    $cod_pais       = isset($_GET['cod_pais'])?$_GET['cod_pais']:null;    
    $fono           = ucwords(strtolower(guardian($_GET['fono'])));//1era Letra De Cada Palabra Mayuscula
    $ciudad         = ucwords(strtolower(guardian($_GET['ciudad'])));//1era Letra De Cada Palabra Mayuscula
    $domicilio      = ucwords(strtolower(guardian($_GET['domicilio'])));//1era Letra De Cada Palabra Mayuscula
    $txt_ci         = strtoupper(guardian($_GET['txt_ci']));// todo A MAYUSCULA
    $tipo_ci        = isset($_GET['tipo_ci'])?$_GET['tipo_ci']:null;
            
    $sql="SELECT * FROM man_cliente WHERE email='".$email."'";
    $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
       	
    if (mysql_num_rows($run_sql)){
        $sql2 = "UPDATE man_cliente SET ";        
        $sql2.= "nombre='".$nombre."',";
        $sql2.= "apellido='".$apellido."',";
        $sql2.= "fecha_nacim='".$fecha_nacim."',";
        $sql2.= "pais='".$cod_pais."',";
        $sql2.= "fono='".$fono."',";
        $sql2.= "ciudad='".$ciudad."',";
        $sql2.= "domicilio='".$domicilio."',";
        
        if ($tipo_ci=="rut"){     
            $sql2.= "rut='".$txt_ci."',";
            $sql2.= "dni='',";
            $sql2.= "pasaporte='',";
              
        }else if ($tipo_ci=="dni"){
            $sql2.= "rut='',";
            $sql2.= "dni='".$txt_ci."',";
            $sql2.= "pasaporte='',";
             
        }else if ($tipo_ci=="pasaporte"){
            $sql2.= "rut='',";
            $sql2.= "dni='',";
            $sql2.= "pasaporte='".$txt_ci."',";
             
        }
                
        $sql2.= "reg_fecha='".date('Y-m-d H:i:s')."' ";
    	$sql2.= "WHERE email='".$email."'";
        $run_sql2=mysql_query($sql2) or die ('ErrorSql > ' . mysql_error ());
        
        echo '<input type="hidden" id="eco_grabar_misdatos" value="ok"/>';
        
        $_SESSION['log_email']  = utf8_encode($email);
        $_SESSION['log_nombre'] = utf8_encode($nombre." ".$apellido);
         
    }else{
        
        echo '<input type="hidden" id="eco_grabar_misdatos" value="err"/>';        
    }
}

##############################################################
## 2) CAMBIAR CLAVE
##############################################################
public function grabar_cambioclave_21(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    
    $email          = guardian($_GET['email']);
    $clave_actual   = guardian(sha1($_GET['clave_actual'])); //funcion sha1 permite encriptar la clave         
    $clave_nueva    = guardian(sha1($_GET['clave_nueva'])); //funcion sha1 permite encriptar la clave
    
    $sql ="SELECT * FROM man_cliente ";        
    $sql.="WHERE email='".$email."' AND clave='".$clave_actual."'"; 
    $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
           	
    if (mysql_num_rows($run_sql)){        
        while($row=mysql_fetch_array($run_sql)){
            $_SESSION['log_email']  = utf8_encode(guardian($row['email']));
            $_SESSION['log_nombre'] = utf8_encode(guardian($row['nombre']." ".$row['apellido']));
        }
        
        $sql = "UPDATE man_cliente SET ";           
        $sql.= "clave='".$clave_nueva."',";
        $sql.= "reg_fecha='".date('Y-m-d H:i:s')."' ";
    	$sql.= "WHERE email='".$email."'";
        $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ()); 
        echo '<input type="hidden" id="eco_grabar_cambioclave_2" value="ok"/>';
    }else{
        echo '<input type="hidden" id="eco_grabar_cambioclave_2" value="err"/>';
    } 
}

/*
##############################################################
## 6) MIS DATOS COMPRA
##############################################################
public function confirma_misdatos_comprar_61(){    
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    
    echo '
    <div id="google_translate_element" class="traductor"></div>
      
    <input type="button" value="<< Volver" class="bt_volver" onclick="history.back()"/>
    <br/><br/>
    
    <div class="titulo">Confirme Sus Datos</div>';
    
    if(isset($_SESSION['log_email'])){
    
        $sql="SELECT ";
        $sql.="man_cliente.email, ";
        $sql.="man_cliente.nombre, ";
        $sql.="man_cliente.apellido, ";
        $sql.="man_cliente.fecha_nacim, ";
        $sql.="man_cliente.pais, ";
        $sql.="man_cliente.fono, ";
        $sql.="man_cliente.ciudad, ";
        $sql.="man_cliente.domicilio ";    
        $sql.="FROM man_cliente ";    
        $sql.="WHERE email='".$_SESSION['log_email']."'";                    
        $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());     
         
        if (mysql_num_rows($run_sql)){                        
            while($row=mysql_fetch_array($run_sql)){           
                
                echo '
                <br/>            
                <div class="contenido">     
                    <center>
                        <input type="text" id="email_6" value="'.$_SESSION['log_email'].'" style="width:80%; font:bold 20px Arial; color:#045FB4; background-color:transparent; border:0px solid; text-align: center;">                        
                        <br><label id="msn_email_6" class="msn_err"></label>
                    </center>
                    
                    <table width="80%" border="0" cellspacing="0" cellpadding="0" class="etq1" align="center">
                    
                    <tr height="40px">
                        <td width="50%" align="center">Nombres:<br/>
                            <input type="text" id="nombre_6" value="'.$row['nombre'].'" style="width:80%" maxlength="50" class="txt1" onblur="valida_alfanum(this);"/>
                            <br><label id="msn_nombre_6" class="msn_err"></label>
                        </td>
                        
                        <td width="50%" align="center">Apellidos:<br/>
                            <input type="text" id="apellido_6" value="'.$row['apellido'].'" style="width:80%" maxlength="50" class="txt1" onblur="valida_alfanum(this);"/>
                            <br><label id="msn_apellido_6" class="msn_err"></label>
                        </td>
                    </tr>
                    
                    <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>
                    
                    <tr height="40px">
                        <td align="center">Fecha Nacimiento:<br/>
                            <input type="date" id="fecha_nacim_6" value="'.$row['fecha_nacim'].'" style="width:80%" class="txt1">
                            <br/><label id="msn_nacim_6" class="msn_err"></label>
                        </td>
                        
                        <td align="center">Pa&iacute;s:<br/>';            
                            $sql2 ="SELECT ";
                            $sql2.="man_pais.iso2, ";
                            $sql2.="man_pais.iso3, ";
                            $sql2.="man_pais.continente, ";
                            $sql2.="man_pais.pais_es, ";
                            $sql2.="man_pais.pais_en, ";
                            $sql2.="man_pais.capital, ";
                            $sql2.="man_pais.cod_fono ";
                            $sql2.="FROM man_pais ";      
                            $sql2.="ORDER BY continente ASC, pais_es ASC";
                            $run_sql2=mysql_query($sql2) or die ('ErrorSql > '.mysql_error ());
                            if (mysql_num_rows($run_sql2)){
                                $continente_old="";
                                
                                echo '
                                <select id="pais_6" style="width:80%" class="txt1">
                                <option value=""/>--Seleccione Pais--</option>';
                                
                                while($row2=mysql_fetch_array($run_sql2)){
                                    if ($row2['continente']!=$continente_old){
                                        if ($continente_old!=""){
                                            echo '</optgroup>';
                                            echo '<optgroup label="'.$row2['continente'].'">';
                                        }else{
                                            echo '<optgroup label="'.$row2['continente'].'">';
                                        }
                                        
                                        if ($row['pais']==$row2['iso3']){      
                                            echo '<option value="'.$row2['iso3'].'" selected/>'.$row2['pais_es'].'</option>';
                                        }else{
                                            echo '<option value="'.$row2['iso3'].'"/>'.$row2['pais_es'].'</option>';
                                        }
                                        
                                    }else{
                                        if ($row['pais']==$row2['iso3']){      
                                            echo '<option value="'.$row2['iso3'].'" selected/>'.$row2['pais_es'].'</option>';
                                        }else{
                                            echo '<option value="'.$row2['iso3'].'"/>'.$row2['pais_es'].'</option>';
                                        }
                                       
                                    }
                                    $continente_old=$row2['continente'];
                                }
                                echo '</optgroup>';
                                echo '</select>';
                            }
                            echo '
                            <br><label id="msn_pais_6" class="msn_err"></label>
                        </td>
                    </tr>
                        
                    <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>
                    
                    <tr height="40px">
                        <td align="center">Fono:<br/>
                            <input type="text" id="fono_6" value="'.$row['fono'].'" style="width:80%" maxlength="50" placeholder="Ej: 56 9 1234 5678" class="txt1" onblur="valida_alfanum(this);"/>
                            <br><label id="msn_fono_6" class="msn_err"></label>
                        </td>
                        
                        <td align="center">Ciudad:<br/>
                            <input type="text" id="ciudad_6" value="'.$row['ciudad'].'" style="width:80%" maxlength="100" class="txt2" onblur="valida_alfanum(this);"/>
                            <br><label id="msn_ciudad_6" class="msn_err"></label>
                        </td>
                    </tr>
                    
                    <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>
                    
                    <tr height="40px">    
                        <td align="center">Domicilio:<br/>
                            <input type="text" id="domicilio_6" value="'.$row['domicilio'].'" style="width:80%" maxlength="100" class="txt2" onblur="valida_alfanum(this);"/>
                            <br><label id="msn_domicilio_6" class="msn_err"></label>
                        </td>
                        
                        <td align="center">Clave:<br/>
                            <input type="password" id="clave_6" style="width:80%;" maxlength="6" class="txt1">
                            <br><label id="msn_clave_6" class="msn_err"></label>
                        </td>
                    </tr>
                    
                    <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>
                    
                    <tr height="40px">
                        <td align="center" colspan="2">
                            <input type="button" value="&#9463; &#x00A; Grabar y Comprar >>" class="bt_comprar" onclick="grabar_misdatos_para_compra();"/>
                        </td>
                    </tr>        
                    </table>
                </div>';
            }        
    
        }else{
            echo '<br/><center><label class="msn_err">No se encontraron los datos del usuario.</label></center>';
        }
    }else{
        echo '<br/><center><label class="etq1">No se encontraron los datos del usuario.</label></center>';
    }
    
    echo '<div id="salida"></div>';   
}

public function grabar_misdatos_comprar_62(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    
    $email  = guardian(strtolower($_GET['email']));//todo a minusculas
    $clave  = guardian(sha1($_GET['clave'])); //funcion sha1 permite encriptar la clave
            
    $sql="SELECT * FROM man_cliente WHERE email='".$email."' AND clave='".$clave."'";
    $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());
     
    if (mysql_num_rows($run_sql)){          
        while($row=mysql_fetch_array($run_sql)){
            $_SESSION['log_email']  = utf8_encode(guardian($row['email']));
            $_SESSION['log_nombre'] = utf8_encode(guardian($row['nombre']." ".$row['apellido']));
        }
                
        $nombre     = ucwords(strtolower(guardian($_GET['nombre'])));//1era Letra De Cada Palabra Mayuscula
        $apellido   = ucwords(strtolower(guardian($_GET['apellido'])));//1era Letra De Cada Palabra Mayuscula
        $fecha_nacim= isset($_GET['fecha_nacim'])?$_GET['fecha_nacim']:null;
        $cod_pais   = isset($_GET['cod_pais'])?$_GET['cod_pais']:null;
        $fono       = ucwords(strtolower(guardian($_GET['fono'])));//1era Letra De Cada Palabra Mayuscula
        $ciudad     = ucwords(strtolower(guardian($_GET['ciudad'])));//1era Letra De Cada Palabra Mayuscula
        $domicilio  = ucwords(strtolower(guardian($_GET['domicilio'])));//1era Letra De Cada Palabra Mayuscula
        
        $sql2 = "UPDATE man_cliente SET ";
        $sql2.= "nombre='".$nombre."',";
        $sql2.= "apellido='".$apellido."',";
        $sql2.= "fecha_nacim='".$fecha_nacim."',";
        $sql2.= "pais='".$cod_pais."',";
        $sql2.= "fono='".$fono."',";
        $sql2.= "ciudad='".$ciudad."',";
        $sql2.= "domicilio='".$domicilio."',";
        $sql2.= "reg_fecha='".date('Y-m-d H:i:s')."' ";
    	$sql2.= "WHERE email='".$email."'";
        $run_sql2=mysql_query($sql2) or die ('ErrorSql > ' . mysql_error ());
        
        ####################################################################################
        
        $sql2 = "INSERT INTO reg_login_cliente(";
            $sql2.= "email,";
            $sql2.= "ip,";            
            $sql2.= "fecha_reg";
		$sql2.= ") VALUES (";
            $sql2.="'".$email."',";            
            $sql2.="'".$_SERVER['REMOTE_ADDR']."',";            
            $sql2.="'".date('Y-m-d H:i:s')."')";      
        $run_sql2=mysql_query($sql2) or die ('ErrorSql > ' . mysql_error ());
        
        echo '<input type="hidden" id="eco_grabar_misdatos_comprar" value="ok"/>';
        
    }else{        
        echo '<input type="hidden" id="eco_grabar_misdatos_comprar" value="err"/>';
    }
}
*/
############################################################################################################
} // FIN CASE CLASS
?>

</body>
</html>