<?php
session_start();

require_once ("func/cnx.php");
$op = isset($_GET['op'])?$_GET['op']:null;
?>

<html>
<head>
    <meta charset="utf-8"/>
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
    <link href="css/registro_empresa.css" type="text/css" rel="stylesheet"  media="screen"/>
    <script src="func/validaciones.js" type="text/javascript"></script>   
    <script src="func/registro_empresa.js" type="text/javascript"></script>
    
</head>
<body class="body">

<?php
$registro_empresa= new registro_empresa();
switch($op){

##############################################################
    case'20':
        $registro_empresa->inicio_crearcuenta_20();
        break;
        
    case'21':
        $registro_empresa->buscar_rut_crearcuenta_21();
        break;
        
    case'22':
        $registro_empresa->grabar_crearcuenta_22();
        break;
        
##############################################################        
    case'41':
        $registro_empresa->enviar_codigo_email_41();
        break;
        
    case'42':
        $registro_empresa->validar_codigo_42();
        break;
        
    case'43':
        $registro_empresa->cambiar_clave_olvidada_43();
        break;
        
############################################################## 
    
    }

class registro_empresa{
###########################################################################################################
public function inicio_crearcuenta_20(){
    $cnx=conexion();    
    date_default_timezone_set("Chile/Continental");    
   
    //PESTAÑAS
    echo '
    <input type="button" value="<< Volver" style="width:10%" class="bt_volver" onclick="volver();"/>
    <br/><br/>
    <center>    
        <label id="pesta2" class="pesta_in" style="text-align:center;" onclick="javascript:activa_pesta('."'2'".');">Crear Cuenta</label>
        <label id="pesta4" class="pesta_out" style="text-align:center;" onclick="javascript:activa_pesta('."'4'".');">Olvide Mi Clave</label>
    </center>';
   
    ##2-CREAR CUENTA###################################################################################################
    echo'
    <DIV id="contenido2" class="contenido">';
    
        //BUSCAR EMAIL
        echo '
        <table width="80%" border="0" cellspacing="0" cellpadding="0" class="tabla" align="center">
          
        <tr valign="center">
            <td width="20%" align="right">Rut:&nbsp;&nbsp;&nbsp;</td>            
            <td width="80%" align="center">
                <input type="text" id="rut_2" style="width:100%" maxlength="10" class="txt1" placeholder="xxxxxxxx-x" onblur="valida_rut('."this,'msn_rut_2'".');" onclick="limpia_datos_crearcuenta();"/>
                <br><label id="msn_rut_2" class="msn_err"></label>
            </td>
        </tr>
        
        <tr valign="center">
            <td></td>
            <td>
                <input type="button" title="Siguiente" value="Siguiente" style="width:100%" class="bt_aceptar" onclick="buscar_rut_crearcuenta();"/>
            </td>
        </tr>       
        </table>';    
        
        //FORMULARIO
        echo '    
        <div id="div_datos_2" style="display:none;">
          
            <table width="80%" border="0" cellspacing="0" cellpadding="0" class="tabla" align="center">
            
            <tr valign="center">
                <td width="20%" align="right">Nombre / Raz&oacute;n Social:&nbsp;&nbsp;&nbsp;</td>
                <td width="80%" align="center">
                    <input type="text" id="nombre_2" style="width:100%;" maxlength="50" class="txt1" placeholder="Nombre" onblur="valida_alfanum(this);"/>
                    <br><label id="msn_nombre_2" class="msn_err"></label>
                </td>
            </tr>
                
            <tr valign="center">
                <td align="right">Contacto:&nbsp;&nbsp;&nbsp;</td>
                <td align="center">
                    <input type="text" id="contacto_2" style="width:100%;" maxlength="50" class="txt1" placeholder="Contacto" onblur="valida_alfanum(this);"/>
                    <br><label id="msn_contacto_2" class="msn_err"></label>
                </td>
            </tr>            
        
            <tr valign="center">
                <td align="right">Email:&nbsp;&nbsp;&nbsp;</td>
                <td align="center">
                    <input type="text" id="email_2" style="width:100%;" maxlength="100" class="txt1" placeholder="email@dominio.cl" onblur="valida_mail(this);"/>
                    <br><label id="msn_email_2" class="msn_err"></label>
                </td>
            </tr>
                
            <tr valign="center">
                <td align="right">Fono 1:&nbsp;&nbsp;&nbsp;</td>
                <td align="center">
                    <input type="text" id="fono1_2" style="width:100%;" maxlength="50" class="txt1" placeholder="56-9 xxxx xxxx" onblur="valida_alfanum(this);"/>                   
                    <br><label id="msn_fono1_2" class="msn_err"></label>
                </td>
            </tr>
                
            <tr valign="center">                
                <td align="right">Fono 2:&nbsp;&nbsp;&nbsp;</td>
                <td align="center">
                    <input type="text" id="fono2_2" style="width:100%;" maxlength="50" class="txt2" placeholder="56-9 xxxx xxxx" onblur="valida_alfanum(this);"/>           
                </td>
            </tr>
                
            <tr valign="center">
                <td align="right">Domicilio:&nbsp;&nbsp;&nbsp;</td>
                <td align="center">
                    <input type="text" id="domicilio_2" style="width:100%;" maxlength="100" placeholder="Domicilio" class="txt1" onblur="valida_alfanum(this);"/>
                    <br><label id="msn_domicilio_2" class="msn_err"></label>
                </td>
            </tr>
                
            <tr valign="center">                    
                <td align="right">Comuna:&nbsp;&nbsp;&nbsp;</td>
                <td align="center">';
                    $sql ="SELECT ";
                    $sql.="man_comuna.id_comuna, ";
                    $sql.="man_comuna.nom_comuna, ";
                    $sql.="man_comuna.n_region, ";
                    $sql.="man_comuna_region.nom_region ";
                    $sql.="FROM man_comuna ";
                    $sql.="INNER JOIN man_comuna_region ON man_comuna.n_region = man_comuna_region.n_region ";
                    $sql.="ORDER BY orden_geo ASC, nom_comuna ASC";
                    
                    $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());
                    if (mysql_num_rows($run_sql)){
                        $region_old="";
                        
                        echo '
                        <select id="id_comuna_2" style="width:100%" class="txt1">
                        <option value=""/>--Seleccione Comuna--</option>';
                        
                        while($row=mysql_fetch_array($run_sql)){
                            if ($row['n_region']!=$region_old){
                                if ($region_old!=""){
                                    echo '</optgroup>';
                                    echo '<optgroup label="'.$row['n_region'].' - '.$row['nom_region'].'">';
                                }else{
                                    echo '<optgroup label="'.$row['n_region'].' - '.$row['nom_region'].'">';
                                }           
                                echo '
                                <option value="'.$row['id_comuna'].'"/>'.$row['nom_comuna'].'</option>';
                                
                            }else{
                                echo '
                                <option value="'.$row['id_comuna'].'"/>'.$row['nom_comuna'].'</option>';
                               
                            }
                            $region_old=$row['n_region'];
                        }
                        echo '</optgroup>';
                        echo '</select>';
                    }
                    echo '
                    <br/><label id="msn_comuna_2" class="msn_err"></label>
                </td>
            </tr>
                
            <tr valign="center">
                <td align="right">Clave:&nbsp;&nbsp;&nbsp;</td>
                <td align="center">
                    <input type="password" id="clave1_2" style="width:100%;" maxlength="6" placeholder="Clave" class="txt2">
                    <br><label id="msn_clave1_2" class="msn_err"></label>
                </td>
            </tr>
                
            <tr valign="center">        
                <td align="right">Confirme Clave:&nbsp;&nbsp;&nbsp;</td>
                <td align="center">
                    <input type="password" id="clave2_2" style="width:100%;" maxlength="6" placeholder="Confirmacion Clave" class="txt2">
                    <br><label id="msn_clave2_2" class="msn_err"></label>
                </td>
            </tr>
                
            <tr valign="center">
                <td></td>
                <td>
                    <input type="button" title="Grabar" value="Grabar" class="bt_aceptar" style="width:100%" onclick="javascript:grabar_crearcuenta();">
                </td>
            </tr> 
            </table>
        </div>
    </DIV>';
    ##2-FIN CREAR CLAVE#################################################################################################
            
    
    ##4-OLVIDE MI CLAVE##################################################################################################
    echo'
    <DIV id="contenido4" class="contenido" style="display:none;">
    
        <table width="80%" border="0" cellspacing="0" cellpadding="0" class="tabla" align="center">
        
        <tr height="50px">
            <td align="center">Email:<br/>
                <input type="email" id="email_4" style="width:80%" maxlength="100" placeholder="xxxxx@xxxxx.com" class="txt1" onblur="valida_mail(this);" onclick="oculta_cambio_clave();"/>
                <br/><label id="msn_email_4" class="msn_err"></label>
                <br/><input type="button" title="Enviar Codigo a Email" value="Enviar C&oacute;digo a Email" style="width:80%" class="bt_aceptar" onclick="enviar_codigo_email();"/>
            </td>
        </tr>
        
        <tr height="50px"><td><hr size="1" width="80%" color="#ffffff"></td></tr>
        
        <tr height="50px">
            <td align="center">Ingresa C&oacute;digo de Seguridad Enviado al Email:<br/>
                <input type="text" id="codigo_4" style="width:80%" maxlength="100" placeholder="Ingresa C&oacute;digo Aqu&iacute;" class="txt1" onkeypress="return esNumero(event);" onclick="oculta_cambioclave_olvidada();"/>               
                <br/><label id="msn_codigo_4" class="msn_err"></label>
                <br/><input type="button" title="Validar Codigo" value="Validar C&oacute;digo" style="width:80%" class="bt_aceptar" onclick="validar_codigo();"/>
            </td>
        </tr>
        
        <tr height="50px"><td><hr size="1" width="80%" color="#ffffff"></td></tr>
        
        <tr height="50px">
            <td align="center">
                <div id="div_cambio_clave_4" style="display:none;">
                    <div style="float:left;width:50%;">Nueva Clave:<br/>
                        <input type="password" id="clave1_4" style="width:50%;" maxlength="6" class="txt1">
                    </div>
            
                    <div style="float:left;width:50%;">Confirme Nueva Clave:<br/>
                        <input type="password" id="clave2_4" style="width:50%;" maxlength="6" class="txt1">                        
                    </div>
                    <br><label id="msn_clave_4" class="msn_err"></label>
                    
                    <br/><input type="button" title="Grabar Datos" value="Grabar" class="bt_aceptar"  style="width:80%" onclick="javascript:grabar_clave_olvidada();">                
                    
                </div>
            </td>
        </tr>        
        </table>    
    </DIV>';
    ##4-FIN OLVIDE MI CLAVE###################################################################################################    
    
    echo '<div id="salida"></div>';
}

#############################################################################################
#PESTAÑA 2###################################################################################
#############################################################################################

public function buscar_rut_crearcuenta_21(){
    $cnx=conexion();    
    date_default_timezone_set("Chile/Continental");    
    $rut = strtoupper(guardian($_GET['rut']));// todo A MAYUSCULA
    
    $sql="SELECT * FROM man_usuario WHERE rut='".$rut."'";
    $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
    
    if (mysql_num_rows($run_sql)){
        echo '<input type="hidden" id="eco_validarut_2" value="ya_existe"/>';
    }else{
        echo '<input type="hidden" id="eco_validarut_2" value="no_existe"/>';
    }    
}

public function grabar_crearcuenta_22(){  
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    
    $rut        = strtoupper(guardian($_GET['rut']));// todo A MAYUSCULA
    $nombre     = ucwords(strtolower(guardian($_GET['nombre'])));//1era Letra De Cada Palabra Mayuscula
    $contacto   = ucwords(strtolower(guardian($_GET['contacto'])));//1era Letra De Cada Palabra Mayuscula
    $email      = guardian(strtolower($_GET['email']));//todo a minusculas
    $fono1      = ucwords(strtolower(guardian($_GET['fono1'])));//1era Letra De Cada Palabra Mayuscula
    $fono2      = ucwords(strtolower(guardian($_GET['fono2'])));//1era Letra De Cada Palabra Mayuscula
    $domicilio  = ucwords(strtolower(guardian($_GET['domicilio'])));//1era Letra De Cada Palabra Mayuscula
    $id_comuna  = isset($_GET['id_comuna'])?$_GET['id_comuna']:null;
    $nom_comuna = isset($_GET['nom_comuna'])?$_GET['nom_comuna']:null;
    $clave1     = guardian(sha1($_GET['clave1'])); //funcion sha1 permite encriptar la clave
            
    $sql="SELECT * FROM man_usuario WHERE rut='".$rut."'";
    $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());       	

    if (mysql_num_rows($run_sql)){
        
        echo '<input type="hidden" id="eco_grabar_2" value="ya_existe"/>';

    }ELSE{ //ELSE existe usuario / empresa
    
        if ($clave1=="da39a3ee5e6b4b0d3255bfef95601890afd80709"){ //cadena vacia
            echo '<input type="hidden" id="eco_grabar_2" value="falta_clave"/>';

        }else{
            
            $sql="INSERT INTO man_usuario(";
                $sql.="rut,";
                $sql.="nombre,";
                $sql.="contacto,";
                $sql.="email,";
                $sql.="fono1,";
                $sql.="fono2,";
                $sql.="domicilio,";
                $sql.="id_comuna,";
                $sql.="tipo_usu,";
                $sql.="estado,";
                $sql.="clave,";            
                $sql.="reg_fecha,";
                $sql.="reg_rut)";
            $sql.="VALUES (";
                $sql.="'".$rut."',";
                $sql.="'".$nombre."',";
                $sql.="'".$contacto."',";
                $sql.="'".$email."',";
                $sql.="'".$fono1."',";
                $sql.="'".$fono2."',";
                $sql.="'".$domicilio."',";         
                $sql.="'".$id_comuna."',";
                $sql.="'Empresa',";
                $sql.="'1',";
                $sql.="'".$clave1."',";
                $sql.="'".date('Y-m-d H:i:s')."',";
                $sql.="'".$rut."')";
            $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());

            echo '<input type="hidden" id="eco_grabar_2" value="insert_ok"/>';
            
            ### MAIL ########################################################################################
            require_once("phpmailer5.2/class.phpmailer.php");
            
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
            $mail->Subject  = "TREPPAR - Creacion de Cuenta Operador OK";
            
            #####################################################################
            
            $fnac= explode("-", $fecha_nacim);
            $yy_nacim       = $fnac[0];
            $mm_nacim       = $fnac[1];
            $dd_nacim       = $fnac[2];
            $fecha_nacim    = $dd_nacim."-".$mm_nacim."-".$yy_nacim;
            
            $mensaje ="<table width='75%' rules='rows' style='border: 1px solid;' align='center'>";
            $mensaje.="<tr><td colspan='2' style='font:bold 16px Arial; color:#ffffff; background-color:#045FB4; height:40px;' align='center'><b>Su cuenta se ha creado con exito.</b></td></tr>";
                       
            $mensaje.="<tr><td width='30%'>Rut  </td>   <td width='70%'> <label style='font:14px Arial; color:#045FB4;'>: ".$rut."  </label> </td></tr>";
            $mensaje.="<tr><td>Nombre           </td>   <td> <label style='font:14px Arial; color:#045FB4;'>: ".$nombre."           </label> </td></tr>";
            $mensaje.="<tr><td>Contacto         </td>   <td> <label style='font:14px Arial; color:#045FB4;'>: ".$contacto."         </label> </td></tr>";          
            $mensaje.="<tr><td>Email            </td>   <td> <label style='font:14px Arial; color:#045FB4;'>: ".$email."            </label> </td></tr>";
            $mensaje.="<tr><td>Fono 1           </td>   <td> <label style='font:14px Arial; color:#045FB4;'>: ".$fono1."            </label> </td></tr>";
            $mensaje.="<tr><td>Fono 2           </td>   <td> <label style='font:14px Arial; color:#045FB4;'>: ".$fono2."            </label> </td></tr>";
            $mensaje.="<tr><td>Domicilio        </td>   <td> <label style='font:14px Arial; color:#045FB4;'>: ".$domicilio."        </label> </td></tr>";
            $mensaje.="<tr><td>Ciudad           </td>   <td> <label style='font:14px Arial; color:#045FB4;'>: ".$nom_comuna."       </label> </td></tr>";           
            $mensaje.="</table><br/>";
            
            $mail->Body = $mensaje;        
            
            $exito = $mail->Send(); //Envía el correo.
            
            if($exito){
                //Email OK        
            }else{        
                //ERR EMAIL        
            }
            
            ### FIN MAIL ####################################################################################
        }
    }
}


#############################################################################################
#PESTAÑA 4###################################################################################
#############################################################################################
public function enviar_codigo_email_41(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    
    $email = guardian(strtolower($_GET['email']));//todo a minusculas
            
    $sql="SELECT * FROM man_usuario WHERE email='".$email."'";              
    $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());
     
    if (mysql_num_rows($run_sql)){
        $codigo = date('YmdHis');
        $codigo = $codigo*3;
        $codigo = substr($codigo, -5);
        
        $sql2 = "UPDATE man_usuario SET ";
        $sql2.= "codigo_clave='".$codigo."' ";
    	$sql2.= "WHERE email='".$email."'";
        $run_sql2=mysql_query($sql2) or die ('ErrorSql > ' . mysql_error ());
        
        ######################################################################################
        require_once("phpmailer5.2/class.phpmailer.php");
        
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
        $mail->Subject  = "TREPPAR - Codigo Seguridad Operador";
        
        #####################################################################
        
        $mail->Body = "Ingresa el siguiente codigo para cambiar clave:<br/><b>".$codigo."</b>";        
        
        $exito = $mail->Send(); //Envía el correo.
        if($exito){
            //Email OK        
        }else{        
            //ERR EMAIL        
        }
        ######################################################################################
        
        echo '<input type="hidden" id="eco_enviarcodigo_4" value="ok"/>';        
        
    }else{        
        echo '<input type="hidden" id="eco_enviarcodigo_4" value="err"/>';        
    }
}

public function validar_codigo_42(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    
    $email  = guardian(strtolower($_GET['email']));//todo a minusculas
    $codigo = isset($_GET['codigo'])?$_GET['codigo']:null;    
            
    $sql="SELECT * FROM man_usuario ";
    $sql.="WHERE email='".$email."' AND codigo_clave='".$codigo."'";              
    $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());
     
    if (mysql_num_rows($run_sql)){
        
        echo '<input type="hidden" id="eco_validarcodigo_4" value="ok"/>';        
        
    }else{        
        echo '<input type="hidden" id="eco_validarcodigo_4" value="err"/>';        
    }
}

public function cambiar_clave_olvidada_43(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    
    $email  = guardian(strtolower($_GET['email']));//todo a minusculas    
    $clave  = guardian(sha1($_GET['clave'])); //funcion sha1 permite encriptar la clave
            
    $sql="SELECT * FROM man_usuario WHERE email='".$email."'";
    $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
       	
    if (mysql_num_rows($run_sql)){
        
        $sql2 = "UPDATE man_usuario SET ";
        $sql2.= "clave='".$clave."',";
        $sql2.= "codigo_clave='',";
        $sql2.= "reg_fecha='".date('Y-m-d H:i:s')."' ";
    	$sql2.= "WHERE email='".$email."'";
        $run_sql2=mysql_query($sql2) or die ('ErrorSql > ' . mysql_error ());
        
        echo '<input type="hidden" id="eco_cambiarclave_4" value="ok"/>';
        
    }else{
        echo '<input type="hidden" id="eco_cambiarclave_4" value="err"/>';
    }
}
############################################################################################################
} // FIN CASE CLASS
?>

</body>
</html>