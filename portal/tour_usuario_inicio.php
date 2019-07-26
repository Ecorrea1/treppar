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
    <script src="func/tour_usuario_inicio.js" type="text/javascript"></script>
    
    <!--Google translate --> 
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    
</head>
<body class="body">

<?php
$registro_cliente= new registro_cliente();
switch($op){
##############################################################
## 1) INICIAR SESION
    case'11':
        $registro_cliente->inicio_sesion_11();
        break;
        
    case'12':
        $registro_cliente->validar_sesion_12();
        break;

##############################################################
## 2) CREAR CUENTA
    case'21':
        $registro_cliente->buscar_email_crearcuenta_21();
        break;
        
    case'22':
        $registro_cliente->grabar_crearcuenta_22();
        break;

##############################################################
## 3) OLVIDE MI CLAVE
    case'31':
        $registro_cliente->enviar_codigo_email_31();
        break;
        
    case'32':
        $registro_cliente->validar_codigo_32();
        break;
        
    case'33':
        $registro_cliente->cambiar_clave_olvidada_33();
        break;
    }

class registro_cliente{

##############################################################
## PANTALLA INICIAL
public function inicio_sesion_11(){
    $cnx=conexion();    
    date_default_timezone_set("Chile/Continental");    
    
    echo '
    <input type="button" value="Salir" class="bt_amarillo" style="position:absolute;" onclick="window.close();"/>
    <div id="google_translate_element" class="traductor"></div>';
    
    //PESTAÑAS
    echo '
    <br/>
    <center>
        <label id="pesta1" class="pesta_in" style="text-align:center;" onclick="javascript:activa_pesta('."'1'".');">Iniciar Sesi&oacute;n</label>
        <label id="pesta2" class="pesta_out" style="text-align:center;" onclick="javascript:activa_pesta('."'2'".');">Crear Cuenta</label>
        <label id="pesta3" class="pesta_out" style="text-align:center;" onclick="javascript:activa_pesta('."'3'".');">Olvide Mi Clave</label>  
    </center>';
    
    ##1-INICIAR SESION##################################################################################################    
    echo'
    <DIV id="contenido1" class="contenido" style="display:block;">
        <table width="80%" border="0" cellspacing="0" cellpadding="0" class="etq1" align="center">
        
        <tr height="50px">
            <td align="center">Email:<br/>
                <input type="email" id="email_1" style="width:80%" maxlength="100" placeholder="xxxxx@xxxxx.com" class="txt1" onblur="valida_mail(this);">
                <br><label id="msn_email_1" class="msn_err"></label>
            </td>
        </tr>
        
        <tr height="50px">
            <td align="center">Clave:<br/>
                <input type="password" id="clave_1" style="width:80%;" maxlength="6" class="txt1">
                <br><label id="msn_clave_1" class="msn_err"></label>
            </td>
        </tr>
        
        <tr><td><hr size="1" color="#6E6E6E"></td></tr>
        
        <tr height="50px">
            <td align="center">
                <input type="button" title="Iniciar Sesion" value="Iniciar Sesi&oacute;n" style="width:80%" class="bt_aceptar" onclick="iniciar_sesion();"/>
            </td>
        </tr>
        </table>
    </DIV>';
    ##1-FIN SESION#####################################################################################################    
    
   
    ##2-CREAR CUENTA###################################################################################################
    echo'
    <DIV id="contenido2" class="contenido" style="display:none;">';
    
        //BUSCAR EMAIL
        echo '
        <table width="80%" border="0" cellspacing="0" cellpadding="0" class="etq1" align="center">
          
        <tr height="40px" valign="bottom">
            <td width="50%" align="center">Email:<br/>        
                <input type="email" id="email_2" style="width:80%" maxlength="100" placeholder="xxxxx@xxxxx.com" class="txt1" onblur="valida_mail(this);" onclick="limpia_datos_crearcuenta();"/>
                <br><label id="msn_email_2" class="msn_err"></label>
            </td>
            
            <td width="50%" align="center"><input type="button" title="Siguiente" value="Siguiente" style="width:80%" class="bt_aceptar" onclick="buscar_email_crearcuenta();"/></td>
        </tr>
        <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>
        </table>';    
        
        //FORMULARIO
        echo '    
        <div id="div_datos_2" style="display:none;">   
            <table width="80%" border="0" cellspacing="0" cellpadding="0" class="etq1" align="center">
            
            <tr height="40px">
                <td width="50%" align="center"><label class="msn_err">* </label>Nombres:<br/>
                    <input type="text" id="nombre_2" style="width:80%" maxlength="50" class="txt1" onblur="valida_alfanum(this);"/>
                    <br><label id="msn_nombre_2" class="msn_err"></label>
                </td>
                
                <td width="50%" align="center"><label class="msn_err">* </label>Apellidos:<br/>
                    <input type="text" id="apellido_2" style="width:80%" maxlength="50" class="txt1" onblur="valida_alfanum(this);"/>
                    <br><label id="msn_apellido_2" class="msn_err"></label>
                </td>
            </tr>
            
            <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>
            
            <tr height="40px">
                <td align="center"><label class="msn_err">* </label>Fecha Nacimiento:<br/>
                    <input type="date" id="fecha_nacim_2" style="width:80%" class="txt1">
                    <br/><label id="msn_nacim_2" class="msn_err"></label>
                </td>
                
                <td align="center"><label class="msn_err">* </label>Pa&iacute;s:<br/>';            
                    $sql ="SELECT ";                    
                    $sql.="man_pais.iso3, ";                    
                    $sql.="man_pais.pais_es ";
                    $sql.="FROM man_pais ";      
                    $sql.="ORDER BY pais_es";
                    $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());
                    if (mysql_num_rows($run_sql)){
                        echo '
                        <select id="pais_2" style="width:80%" class="txt1">
                        <option value=""/>--Seleccione Pais--</option>';
                        
                        while($row=mysql_fetch_array($run_sql)){
                            echo '<option value="'.$row['iso3'].'"/>'.$row['pais_es'].'</option>';
                        }                  
                        echo '
                        </select>';
                    }
                    echo '
                    <br><label id="msn_pais_2" class="msn_err"></label>
                </td>
            </tr>
                
            <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>
            
            <tr height="40px">
                <td align="center"><label class="msn_err">* </label>Fono:<br/>
                    <input type="text" id="fono_2" style="width:80%" maxlength="50" placeholder="Ej: 56 9 1234 5678" class="txt1" onblur="valida_alfanum(this);"/>
                    <br><label id="msn_fono_2" class="msn_err"></label>
                </td>
                
                <td align="center">Ciudad:<br/>
                    <input type="text" id="ciudad_2" style="width:80%" maxlength="100" class="txt2" onblur="valida_alfanum(this);"/>
                    <br><label id="msn_ciudad_2" class="msn_err"></label>
                </td>
            </tr>
            
            <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>
            
            <tr height="40px">    
                <td align="center">Domicilio:<br/>
                    <input type="text" id="domicilio_2" style="width:80%" maxlength="100" class="txt2" onblur="valida_alfanum(this);"/>
                    <br><label id="msn_domicilio_2" class="msn_err"></label>
                </td>
                
                <td align="center"><label class="msn_err">* </label>
                    <input type="radio" name="ci_2" value="rut" onclick="activar_ci_crearcuenta();" checked/>Rut-Chi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="ci_2" value="dni" onclick="activar_ci_crearcuenta();"/>Dni-Extranjero&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="ci_2" value="pasaporte" onclick="activar_ci_crearcuenta();"/>Pasaporte&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    
                    <input type="text" id="txtci_2" style="width:80%;" maxlength="10" class="txt1" placeholder="Rut (Ej: 11111111-1)">            
                    <br><label id="msn_ci_2" class="msn_err"></label>
                </td>
            </tr>
            
            <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>
                
            <tr height="40px">
                <td align="center"><label class="msn_err">* </label>Clave:<br/>
                    <input type="password" id="clave1_2" style="width:80%;" maxlength="6" class="txt1">
                    <br><label id="msn_clave1_2" class="msn_err"></label>
                </td>
                    
                <td align="center"><label class="msn_err">* </label>Confirmaci&oacute;n Clave:<br/>
                    <input type="password" id="clave2_2" style="width:80%;" maxlength="6" class="txt1">                    
                    <br><label id="msn_clave2_2" class="msn_err"></label>
                </td>
            </tr>
            
            <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>
            
            <tr height="40px">
                <td align="center" colspan="2">
                    <input type="button" title="Grabar" value="Grabar" class="bt_aceptar" style="width:90%" onclick="javascript:grabar_crearcuenta();">
                </td>
            </tr>    
            
            <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>
            </table>
        </div>
    </DIV>';
    ##2-FIN CREAR CLAVE#################################################################################################        
    
    ##3-OLVIDE MI CLAVE##################################################################################################
    echo'
    <DIV id="contenido3" class="contenido" style="display:none;">
    
        <table width="80%" border="0" cellspacing="0" cellpadding="0" class="etq1" align="center">       
        
        <tr height="50px">
            <td align="center">Email:<br/>
                <input type="email" id="email_3" style="width:80%" maxlength="100" placeholder="xxxxx@xxxxx.com" class="txt1" onblur="valida_mail(this);" onclick="oculta_cambio_clave();"/>
                <br/><label id="msn_email_3" class="msn_err"></label>
                <br/><input type="button" title="Enviar Codigo a Email" value="Enviar C&oacute;digo a Email" style="width:80%" class="bt_aceptar" onclick="enviar_codigo_email();"/>
            </td>
        </tr>
        
        <tr height="50px"><td><hr size="1" width="80%" color="#6E6E6E"></td></tr>
        
        <tr height="50px">
            <td align="center">Ingresa C&oacute;digo de Seguridad Enviado al Email:<br/>
                <input type="text" id="codigo_3" style="width:80%" maxlength="100" placeholder="Ingresa C&oacute;digo Aqu&iacute;" class="txt1" onkeypress="return esNumero(event);" onclick="oculta_cambioclave_olvidada();"/>               
                <br/><label id="msn_codigo_3" class="msn_err"></label>
                <br/><input type="button" title="Validar Codigo" value="Validar C&oacute;digo" style="width:80%" class="bt_aceptar" onclick="validar_codigo();"/>
            </td>
        </tr>
        
        <tr height="50px"><td><hr size="1" width="80%" color="#6E6E6E"></td></tr>
        
        <tr height="50px">
            <td align="center">
                <div id="div_cambio_clave_3" style="display:none;">
                    <div style="float:left;width:50%;">Nueva Clave:<br/>
                        <input type="password" id="clave1_3" style="width:50%;" maxlength="6" class="txt1">
                    </div>
            
                    <div style="float:left;width:50%;">Confirme Nueva Clave:<br/>
                        <input type="password" id="clave2_3" style="width:50%;" maxlength="6" class="txt1">                        
                    </div>
                    <br><label id="msn_clave_3" class="msn_err"></label>
                    
                    <br/><input type="button" title="Grabar Datos" value="Grabar" class="bt_aceptar"  style="width:80%" onclick="javascript:grabar_clave_olvidada();">                
                    
                </div>
            </td>
        </tr>        
        </table>    
    </DIV>';
    ##3-FIN OLVIDE MI CLAVE###################################################################################################
    
    echo '<div id="salida"></div>';
}

##############################################################
## 1) INICIAR SESION
##############################################################

public function validar_sesion_12(){
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
        
        $sql2 = "INSERT INTO reg_login_cliente(";
            $sql2.= "email,";
            $sql2.= "ip,";            
            $sql2.= "fecha_reg";
		$sql2.= ") VALUES (";
            $sql2.="'".$email."',";            
            $sql2.="'".$_SERVER['REMOTE_ADDR']."',";            
            $sql2.="'".date('Y-m-d H:i:s')."')";      
        $run_sql2=mysql_query($sql2) or die ('ErrorSql > ' . mysql_error ());
        
        echo '<input type="hidden" id="eco_validasesion_1" value="ok"/>';
        
    }else{        
        echo '<input type="hidden" id="eco_validasesion_1" value="err"/>';        
    }  
}

##############################################################
## 2) CREAR CUENTA
##############################################################

public function buscar_email_crearcuenta_21(){
    $cnx=conexion();    
    date_default_timezone_set("Chile/Continental");    
    $email = guardian(strtolower($_GET['email']));//todo a minusculas
    
    $sql="SELECT * FROM man_cliente WHERE email='".$email."'";
    $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
    
    if (mysql_num_rows($run_sql)){
        echo '<input type="hidden" id="eco_validaemail_2" value="ya_existe"/>';
    }else{
        echo '<input type="hidden" id="eco_validaemail_2" value="no_existe"/>';
    }    
}

public function grabar_crearcuenta_22(){  
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    
    $email          = guardian(strtolower($_GET['email']));//todo a minusculas
    $nombre         = ucwords(strtolower(guardian($_GET['nombre'])));//1era Letra De Cada Palabra Mayuscula
    $apellido       = ucwords(strtolower(guardian($_GET['apellido'])));//1era Letra De Cada Palabra Mayuscula
    $fecha_nacim    = isset($_GET['fecha_nacim'])?$_GET['fecha_nacim']:null;
    $cod_pais       = isset($_GET['cod_pais'])?$_GET['cod_pais']:null;
    $nom_pais       = isset($_GET['nom_pais'])?$_GET['nom_pais']:null;
    $fono           = ucwords(strtolower(guardian($_GET['fono'])));//1era Letra De Cada Palabra Mayuscula
    $ciudad         = ucwords(strtolower(guardian($_GET['ciudad'])));//1era Letra De Cada Palabra Mayuscula
    $domicilio      = ucwords(strtolower(guardian($_GET['domicilio'])));//1era Letra De Cada Palabra Mayuscula
    $txt_ci         = strtoupper(guardian($_GET['txt_ci']));// todo A MAYUSCULA
    $tipo_ci        = isset($_GET['tipo_ci'])?$_GET['tipo_ci']:null;
    $clave          = guardian(sha1($_GET['clave'])); //funcion sha1 permite encriptar la clave
            
    $sql="SELECT * FROM man_cliente WHERE email='".$email."'";
    $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
       	
    if (mysql_num_rows($run_sql)){        
        
        $sql2 = "UPDATE man_cliente SET ";
        $sql2.= "email='".$email."',";
        $sql2.= "nombre='".$nombre."',";
        $sql2.= "apellido='".$apellido."',";
        $sql2.= "fecha_nacim='".$fecha_nacim."',";
        $sql2.= "pais='".$cod_pais."',";
        $sql2.= "fono='".$fono."',";
        $sql2.= "ciudad='".$ciudad."',";
        $sql2.= "domicilio='".$domicilio."',";
        
        if ($tipo_ci=="rut"){     
            $sql2.= "rut='".$txt_ci."',";
              
        }else if ($tipo_ci=="dni"){
            $sql2.= "dni='".$txt_ci."',";
             
        }else if ($tipo_ci=="pasaporte"){
            $sql2.= "pasaporte='".$txt_ci."',";
             
        }
        
        $sql2.= "clave='".$clave."',";
        $sql2.= "reg_fecha='".date('Y-m-d H:i:s')."' ";
    	$sql2.= "WHERE email='".$email."'";
        $run_sql2=mysql_query($sql2) or die ('ErrorSql > ' . mysql_error ());
        
        echo '<input type="hidden" id="eco_grabar" value="update_ok"/>';
        
        $_SESSION['log_email']  = utf8_encode($email);
        $_SESSION['log_nombre'] = utf8_encode($nombre." ".$apellido);
         
    }else{
        
        $sql2="INSERT INTO man_cliente(";
            $sql2.= "email,";
            $sql2.= "nombre,";
            $sql2.= "apellido,";
            $sql2.= "fecha_nacim,";
            $sql2.= "pais,";
            $sql2.= "fono,";
            $sql2.= "ciudad,";
            $sql2.= "domicilio,";
            
            if ($tipo_ci=="rut"){     
                $sql2.= "rut,";
                  
            }else if ($tipo_ci=="dni"){
                $sql2.= "dni,";
                 
            }else if ($tipo_ci=="pasaporte"){
                $sql2.= "pasaporte,";
                 
            }
        
            $sql2.= "clave,";
            $sql2.="reg_fecha) ";
        $sql2.="VALUES (";        
            $sql2.="'".$email."',";
            $sql2.="'".$nombre."',";
            $sql2.="'".$apellido."',";
            $sql2.="'".$fecha_nacim."',";
            $sql2.="'".$cod_pais."',";
            $sql2.="'".$fono."',";
            $sql2.="'".$ciudad."',";
            $sql2.="'".$domicilio."',";
            $sql2.="'".$txt_ci."',";
            $sql2.="'".$clave."',";
            $sql2.="'".date('Y-m-d H:i:s')."')";
        $run_sql2=mysql_query($sql2) or die ('ErrorSql > ' . mysql_error ());
          
        echo '<input type="hidden" id="eco_grabar_2" value="insert_ok"/>';
        
        $_SESSION['log_email']  = utf8_encode($email);
        $_SESSION['log_nombre'] = utf8_encode($nombre." ".$apellido);
    }
    
    require_once("../admin/app/phpmailer5.2/class.phpmailer.php");
    
    ## Send email
    $mail = new PHPMailer(true);
    $mail->IsSMTP();
    $mail->SMTPAuth     = true;
    $mail->Port         = 25;
    $mail->Host         = "mail.treppar.cl";
    $mail->Username     = "registro@treppar.cl";
    $mail->Password     = "registrotreppar";
    $mail->From         = "registro@treppar.cl";
    $mail->FromName     = "registro@treppar.cl";
    $mail->AddAddress($email); //EMAIL DESTINO
    $mail->AddCC('registro@treppar.cl');
    
    $mail->IsHTML(true);//El correo se envía como HTML
    $mail->Subject  = "TREPPAR - Creacion de Cuenta Cliente OK";
    
    #####################################################################
    
    $fnac= explode("-", $fecha_nacim);
    $yy_nacim       = $fnac[0];
    $mm_nacim       = $fnac[1];
    $dd_nacim       = $fnac[2];
    $fecha_nacim    = $dd_nacim."-".$mm_nacim."-".$yy_nacim;
    
    $mensaje ="<table width='75%' rules='rows' style='border: 1px solid;' align='center'>";
    $mensaje.="<tr><td colspan='2' style='font:bold 16px Arial; color:#ffffff; background-color:#045FB4; height:40px;' align='center'><b>Su cuenta se ha creado con exito.</b></td></tr>";
     
    $mensaje.="<tr><td width='30%'>Email    </td>   <td width='70%'> <label style='font:14px Arial; color:#045FB4;'>: ".$email."    </label> </td></tr>";
    $mensaje.="<tr><td>Nombre               </td>   <td> <label style='font:14px Arial; color:#045FB4;'>: ".$nombre."               </label> </td></tr>";
    $mensaje.="<tr><td>Apellido             </td>   <td> <label style='font:14px Arial; color:#045FB4;'>: ".$apellido."             </label> </td></tr>";    
    $mensaje.="<tr><td>Fecha Nacim.         </td>   <td> <label style='font:14px Arial; color:#045FB4;'>: ".$fecha_nacim."          </label> </td></tr>";
    $mensaje.="<tr><td>Pais                 </td>   <td> <label style='font:14px Arial; color:#045FB4;'>: ".$nom_pais."             </label> </td></tr>";
    $mensaje.="<tr><td>Fono                 </td>   <td> <label style='font:14px Arial; color:#045FB4;'>: ".$fono."                 </label> </td></tr>";
    $mensaje.="<tr><td>Ciudad               </td>   <td> <label style='font:14px Arial; color:#045FB4;'>: ".$ciudad."               </label> </td></tr>";
    
    if ($tipo_ci=="rut"){     
        $mensaje.="<tr><td>Rut              </td>   <td> <label style='font:14px Arial; color:#045FB4;'>: ".$txt_ci."               </label> </td></tr>";          
    }else if ($tipo_ci=="dni"){
        $mensaje.="<tr><td>Dni              </td>   <td> <label style='font:14px Arial; color:#045FB4;'>: ".$txt_ci."               </label> </td></tr>";         
    }else if ($tipo_ci=="pasaporte"){
        $mensaje.="<tr><td>Pasaporte        </td>   <td> <label style='font:14px Arial; color:#045FB4;'>: ".$txt_ci."               </label> </td></tr>";         
    }    
            
    $mensaje.="<tr><td>Domicilio            </td>   <td> <label style='font:14px Arial; color:#045FB4;'>: ".$domicilio."            </label> </td></tr>";
    $mensaje.="</table><br/>";
    
    $mail->Body = $mensaje;
    
    $exito = $mail->Send(); //Envía el correo.
    if($exito){
        //Email OK        
    }else{        
        //ERR EMAIL        
    }
}

##############################################################
## 3) OLVIDE MI CLAVE
##############################################################
public function enviar_codigo_email_31(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    
    $email = guardian(strtolower($_GET['email']));//todo a minusculas
            
    $sql="SELECT * FROM man_cliente WHERE email='".$email."'";              
    $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());
     
    if (mysql_num_rows($run_sql)){
        $codigo = date('YmdHis');
        $codigo = $codigo*3;
        $codigo = substr($codigo, -5);
        
        $sql2 = "UPDATE man_cliente SET ";
        $sql2.= "codigo_clave='".$codigo."' ";
    	$sql2.= "WHERE email='".$email."'";
        $run_sql2=mysql_query($sql2) or die ('ErrorSql > ' . mysql_error ());
        
        
        require_once("../admin/app/phpmailer5.2/class.phpmailer.php");
        
        ## Send email
        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        $mail->SMTPAuth     = true;
        $mail->Port         = 25;
        $mail->Host         = "mail.treppar.cl";
        $mail->Username     = "registro@treppar.cl";
        $mail->Password     = "registrotreppar";
        $mail->From         = "registro@treppar.cl";
        $mail->FromName     = "registro@treppar.cl";
        $mail->AddAddress($email); //EMAIL DESTINO
        $mail->AddCC('registro@treppar.cl');
        
        $mail->IsHTML(true);//El correo se envía como HTML
        $mail->Subject  = "TREPPAR - Codigo Seguridad Cliente";
        
        #####################################################################
        
        $mail->Body = "Ingresa el siguiente codigo para cambiar clave:<br/><b>".$codigo."</b>";        
        
        $exito = $mail->Send(); //Envía el correo.
        if($exito){
            //Email OK        
        }else{        
            //ERR EMAIL        
        }
        
        echo '<input type="hidden" id="eco_enviarcodigo_3" value="ok"/>';        
        
    }else{        
        echo '<input type="hidden" id="eco_enviarcodigo_3" value="err"/>';        
    }
}

public function validar_codigo_32(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    
    $email  = guardian(strtolower($_GET['email']));//todo a minusculas
    $codigo = isset($_GET['codigo'])?$_GET['codigo']:null;    
            
    $sql="SELECT * FROM man_cliente ";
    $sql.="WHERE email='".$email."' AND codigo_clave='".$codigo."'";              
    $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());
     
    if (mysql_num_rows($run_sql)){
        
        echo '<input type="hidden" id="eco_validarcodigo_3" value="ok"/>';        
        
    }else{        
        echo '<input type="hidden" id="eco_validarcodigo_3" value="err"/>';        
    }
}

public function cambiar_clave_olvidada_33(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    
    $email  = guardian(strtolower($_GET['email']));//todo a minusculas    
    $clave  = guardian(sha1($_GET['clave'])); //funcion sha1 permite encriptar la clave
            
    $sql="SELECT * FROM man_cliente WHERE email='".$email."'";
    $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
       	
    if (mysql_num_rows($run_sql)){        
        while($row=mysql_fetch_array($run_sql)){
            $_SESSION['log_email']  = utf8_encode(guardian($row['email']));
            $_SESSION['log_nombre'] = utf8_encode(guardian($row['nombre']." ".$row['apellido']));
        }
        $sql2 = "UPDATE man_cliente SET ";
        $sql2.= "clave='".$clave."',";
        $sql2.= "codigo_clave='',";
        $sql2.= "reg_fecha='".date('Y-m-d H:i:s')."' ";
    	$sql2.= "WHERE email='".$email."'";
        $run_sql2=mysql_query($sql2) or die ('ErrorSql > ' . mysql_error ());
        
        echo '<input type="hidden" id="eco_cambiarclave_3" value="ok"/>';
        
    }else{
        echo '<input type="hidden" id="eco_cambiarclave_3" value="err"/>';
    }
}
############################################################################################################
} // FIN CASE CLASS
?>

</body>
</html>