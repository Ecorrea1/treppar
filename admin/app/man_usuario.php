<?php
session_start();

if (!isset($_SESSION['log_rut']) OR !isset($_SESSION['log_nom']) OR !isset($_SESSION['log_tipo'])){                  
    echo '<input type="hidden" id="sesion" value="err">';
    return false;
}
?>

<?php


require_once ("func/cnx.php");
$op=isset($_GET['op'])?$_GET['op']:null;

$usuario= new usuario();
switch($op){
    case'1':
        $usuario->inicio_usuario();
        break;        

    case'2':
        $usuario->grabar_usuario();
        break;        

    case'3':        
        $usuario->eliminar_usuario();
        break;        

    case'4':
        $usuario->grilla_usuario();
        break;
}

class usuario{
###########################################################################################################
public function inicio_usuario() {
    
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");        

    echo '
    <div class="titulo1" align="center">Usuarios</div>';    

    //FORMULARIO
    echo '
    <FORM id="form_usuario" method="post">     

    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="panel1" align="center">
    <tr height="40px"><td colspan="4" align="center"><label id="msn_update" class="msn_err"></label></td></tr>

    <tr height="40px">
        <td width="50%" align="center">Rut:<br/>';
        
            if ($_SESSION['log_tipo']=="Empresa"){
                echo '<input type="text" id="rut" style="width:90%;" value="'.$_SESSION['log_rut'].'" maxlength="10" class="txt3" placeholder="xxxxxxxx-x" onblur="valida_rut('."this,'msn_rut'".');" readonly/>';
            
            }else if ($_SESSION['log_tipo']=="Admin"){
                echo '<input type="text" id="rut" style="width:90%;" maxlength="10" class="txt1" placeholder="xxxxxxxx-x" onblur="valida_rut('."this,'msn_rut'".');"/>';
            }
            
            echo '           
            <br><label id="msn_rut" class="msn_err"></label>
        </td>

        <td width="50%" align="center">Nombre / Raz&oacute;n Social:<br/>
            <input type="text" id="nombre" style="width:90%;" maxlength="50" class="txt1" placeholder="Nombre" onblur="valida_alfanum(this);"/>
            <br><label id="msn_nombre" class="msn_err"></label>
        </td>
    </tr>
    
    <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>
        
    <tr height="40px">
        <td align="center">Contacto:<br/>
            <input type="text" id="contacto" style="width:90%;" maxlength="50" class="txt1" placeholder="Contacto" onblur="valida_alfanum(this);"/>
            <br><label id="msn_contacto" class="msn_err"></label>
        </td>
        
        <td align="center">Email:<br/>
            <input type="text" id="email" style="width:90%;" maxlength="100" class="txt1" placeholder="email@dominio.cl" onblur="valida_mail(this);"/>
            <br><label id="msn_email" class="msn_err"></label>
        </td>
    </tr>
    
    <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>

    <tr height="40px">
        <td align="center">Fono 1:<br/>
            <input type="text" id="fono1" style="width:90%;" maxlength="50" class="txt1" placeholder="56-9 xxxx xxxx" onblur="valida_alfanum(this);"/>
            <br><label id="msn_fono1" class="msn_err"></label>
        </td>
        
        <td align="center">Fono 2:<br/>
            <input type="text" id="fono2" style="width:90%;" maxlength="50" class="txt2" placeholder="56-9 xxxx xxxx" onblur="valida_alfanum(this);"/>           
        </td>
    </tr>
    
    <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>

    <tr height="40px">
        <td align="center">Domicilio:<br/>
            <input type="text" id="domicilio" style="width:90%;" maxlength="100" placeholder="Domicilio" class="txt1" onblur="valida_alfanum(this);"/>
            <br><label id="msn_domicilio" class="msn_err"></label>
        </td>
            
        <td align="center">Comuna:<br/>';
            $sql ="SELECT ";
            $sql.="man_comuna.id_comuna, ";
            $sql.="man_comuna.nom_comuna, ";
            $sql.="man_comuna.n_region, ";
            $sql.="man_comuna_region.nom_region ";
            $sql.="FROM man_comuna ";
            $sql.="INNER JOIN man_comuna_region ON man_comuna.n_region = man_comuna_region.n_region ";
            $sql.="ORDER BY orden_geo ASC, nom_comuna ASC";
            $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());
            $region_old = "";           

            echo '
            <select id="id_comuna" style="width:90%;" class="txt1" >
            <option value="@">--Seleccione Comuna--</option>';        

            if (mysql_num_rows($run_sql)){
                while($row=mysql_fetch_array($run_sql)){
                    if ($row['n_region']!=$region_old){
                        //Cambia de region
                        echo '<option value="@" class="titulo_cmb">'.$row['n_region']." - ".$row['nom_region'].'</option>';
                        echo '<option value="'.$row['id_comuna'].'">'.$row['nom_comuna'].'</option>';
                        $region_old=$row['n_region'];
                    }else{                        
                        //La misma región
                        echo '<option value="'.$row['id_comuna'].'">'.$row['nom_comuna'].'</option>';
                        $region_old=$row['n_region'];
                    }
                }
            }
            echo '
            </select>
            <br/><label id="msn_comuna" class="msn_err"></label>
        </td>
    </tr>
    
    <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>

    <tr height="40px">
        <td align="center">Tipo de Usuario:<br/>';
            
            if ($_SESSION['log_tipo']=="Empresa"){
                echo '
                <select id="tipo_usu" style="width:90%;" class="txt3" disabled/>                
                    <option value="Empresa">Empresa</option>   
                </select>';
                
            }else if ($_SESSION['log_tipo']=="Admin"){
                echo '
                <select id="tipo_usu" style="width:90%;" class="txt1"/>
                    <option value="@">--Seleccione Tipo--</option>
                    <option value="Empresa">Empresa</option>
                    <option value="Admin">Admin</option>           
                </select>';
            }
        
            echo '
            <br><label id="msn_tipo_usu" class="msn_err"></label>
        </td>

        <td align="center">Estado:<br/>
            <select id="estado" style="width:90%;" class="txt1"/>
                <option value="@">--Seleccione Estado--</option>
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
            </select>
            <br><label id="msn_estado" class="msn_err"></label>
        </td>
    </tr>
    
    <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>

    <tr height="40px">
        <td align="center">Clave:<br/>
            <input type="password" id="clave1" style="width:90%;" maxlength="6" class="txt2">
            <br><label id="msn_clave1" class="msn_err"></label>
        </td>

        <td align="center">Confirme Clave:<br/>
            <input type="password" id="clave2" style="width:90%;" maxlength="6" class="txt2">
            <br><label id="msn_clave2" class="msn_err"></label>
        </td>
    </tr>
    
    <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>';

    //Botones
    echo '
    <tr height="40px">
        <td colspan="4" align="center">
            <input type="button" title="Grabar" class="bt_grabar" onclick="grabar_usuario();">&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" title="Eliminar" class="bt_eliminar" onclick="eliminar_usuario();">&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" title="Buscar" class="bt_buscar" onclick="grilla_usuario('."'buscar'".');">&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" title="Copiar Datos" class="bt_exportar" onclick="copy_grilla_usuario();">&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" title="Limpiar" class="bt_limpiar" onclick="limpia_form_usuario();">&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
    </tr>
    </table>';    

    //GRILLA
    echo '
    <DIV id="grilla_usuario">';    
        //Cabecera Grilla
        echo '
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr class="tabla_head">
            <td>Rut</td>
            <td>Nombre</td>
            <td>Contacto</td>
            <td>Email</td>
            <td>Fono 1</td>
            <td>Fono 2</td>
            <td>Domicilio</td>
            <td>Comuna</td>
            <td>Tipo</td>
            <td>Estado</td>
        </tr>';         

        //Datos Grilla
        $sql ="SELECT ";
        $sql.="man_usuario.rut, ";
        $sql.="man_usuario.nombre, ";
        $sql.="man_usuario.contacto, ";
        $sql.="man_usuario.email, ";
        $sql.="man_usuario.fono1, ";
        $sql.="man_usuario.fono2, ";
        $sql.="man_usuario.domicilio, ";
        $sql.="man_comuna.id_comuna, ";
        $sql.="man_comuna.nom_comuna, ";
        $sql.="man_usuario.tipo_usu, ";
        $sql.="man_usuario.estado ";
        $sql.="FROM man_usuario ";
        $sql.="INNER JOIN man_comuna ON man_usuario.id_comuna = man_comuna.id_comuna ";
        
        if ($_SESSION['log_tipo']=="Empresa"){
            $sql.="WHERE rut='".$_SESSION['log_rut']."'" ;
        } 
        
        $sql.="ORDER BY tipo_usu DESC, nombre";
        $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());

        if (mysql_num_rows($run_sql)){
            $n_row=0;
            $color_fila=1;
            while($row=mysql_fetch_array($run_sql)){
                $n_row++;            

                //Seleccion para este formulario
                $seleccion ="'".$row['rut']."',";
                $seleccion.="'".$row['nombre']."',";            
                $seleccion.="'".$row['contacto']."',";
                $seleccion.="'".$row['email']."',";
                $seleccion.="'".$row['fono1']."',";
                $seleccion.="'".$row['fono2']."',";
                $seleccion.="'".$row['domicilio']."',";
                $seleccion.="'".$row['id_comuna']."',";
                $seleccion.="'".$row['tipo_usu']."',";
                $seleccion.="'".$row['estado']."'";               
                
                if ($color_fila==1){
                    echo '<tr class="tabla_datos1" onclick="selecc_usuario('.$seleccion.');">';
                    $color_fila=2;
                    
                }else if ($color_fila==2){           
                    echo '<tr class="tabla_datos2" onclick="selecc_usuario('.$seleccion.');">';
                    $color_fila=1;
                }

                if ($row['estado']=="0"){
                    $font_color="DF0101";
                }else{
                    if ($row['tipo_usu']=="Empresa"){
                        $font_color="2E2E2E";
                    }else{
                        $font_color="0040FF";
                    }                    
                }
                
                echo '
                <td style="color:#'.$font_color.'">'.$row['rut'].'</td>
                <td style="color:#'.$font_color.'">'.$row['nombre'].'</td>
                <td style="color:#'.$font_color.'">'.$row['contacto'].'</td>
                <td style="color:#'.$font_color.'">'.$row['email'].'</td>
                <td style="color:#'.$font_color.'">'.$row['fono1'].'</td>
                <td style="color:#'.$font_color.'">'.$row['fono2'].'</td>
                <td style="color:#'.$font_color.'">'.$row['domicilio'].'</td>
                <td style="color:#'.$font_color.'">'.$row['nom_comuna'].'</td>
                <td style="color:#'.$font_color.'">'.$row['tipo_usu'].'</td>
                <td style="color:#'.$font_color.'">';
                    if ($row['estado']=="0"){
                        echo "Inactivo";
                    }elseif ($row['estado']=="1"){
                        echo "Activo";
                    }echo '                
                </td>
                </tr>';
            }     

            echo '
            <tr class="tabla_head"><th colspan="10" align="center"> Cantidad de registros: '.$n_row.'</th> </tr>';
        }else{
            echo '
            <tr class="tabla_datos1"><td colspan="10" ><center>No se encontraron resultados</center></td> </tr>';
        }
        echo '
        </table>
    </DIV>
    
    <div id="salida"></div>
    </FORM>';
}


public function grabar_usuario() {        
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
    $tipo_usu   = isset($_GET['tipo_usu'])?$_GET['tipo_usu']:null;
    $estado     = isset($_GET['estado'])?$_GET['estado']:null;
    $clave1     = guardian(sha1($_GET['clave1'])); //funcion sha1 permite encriptar la clave

    $sql="SELECT * FROM man_usuario WHERE rut='".$rut."'";
    $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());       	

    if (mysql_num_rows($run_sql)){
        $sql = "UPDATE man_usuario SET ";
        $sql.= "nombre='".$nombre."',";
        $sql.= "contacto='".$contacto."',";        
        $sql.= "email='".$email."',";
        $sql.= "fono1='".$fono1."',";
        $sql.= "fono2='".$fono2."',";
        $sql.= "domicilio='".$domicilio."',";
        $sql.= "id_comuna='".$id_comuna."',";
        $sql.= "tipo_usu='".$tipo_usu."',";
        $sql.= "estado='".$estado."',";

        if ($clave1!="da39a3ee5e6b4b0d3255bfef95601890afd80709"){ //cadena vacia
            $sql.= "clave='".$clave1."',";
        }
        
        $sql.= "reg_rut='".$_SESSION['log_rut']."',";
        $sql.= "reg_fecha='".date('Y-m-d H:i:s')."'";
    	$sql.= "WHERE rut='".$rut."'";
        $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());        

        echo '<input type="hidden" id="eco_grabar" value="update_ok"/>';         

    }else{       

        if ($clave1=="da39a3ee5e6b4b0d3255bfef95601890afd80709"){ //cadena vacia
            echo '<input type="hidden" id="eco_grabar" value="falta_clave"/>';

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
                $sql.="'".$tipo_usu."',";
                $sql.="'".$estado."',";
                $sql.="'".$clave1."',";
                $sql.="'".date('Y-m-d H:i:s')."',";
                $sql.="'".$_SESSION['log_rut']."')";
            $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());

            echo '<input type="hidden" id="eco_grabar" value="insert_ok"/>';
        }
    }
}

public function eliminar_usuario() {
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    $rut    = guardian($_GET['rut']);
    $nombre = guardian($_GET['nombre']);  

    $sql="SELECT * FROM man_usuario ";
    $sql.="WHERE rut='".$rut."'AND nombre='".$nombre."'";
    $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
    
    if (mysql_num_rows($run_sql)){
    	$sql = "DELETE FROM man_usuario ";
        $sql.="WHERE rut='".$rut."'AND nombre='".$nombre."'";        

        $run_sql=mysql_query($sql) or die ('<center><label class="msn_err">No se puede eliminar porque hay datos vinculados<br/>
                                            Rut: '.$rut.' &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;
                                            Nombre: '.$nombre.'</b></label></center>');                                     

        echo '<input type="hidden" id="eco_eliminar" value="delete_ok"/>';      

    }else{
        echo '<input type="hidden" id="eco_eliminar" value="err_delete"/>';
    }
}

public function grilla_usuario() {    
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    $accion = isset($_GET['accion'])?$_GET['accion']:null;

    //Cabecera Grilla
    echo '
    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr class="tabla_head">
        <td>Rut</td>
        <td>Nombre</td>
        <td>Contacto</td>
        <td>Email</td>
        <td>Fono 1</td>
        <td>Fono 2</td>
        <td>Domicilio</td>
        <td>Comuna</td>
        <td>Tipo</td>
        <td>Estado</td>
    </tr>';

    //Datos Grilla
    $sql ="SELECT ";
    $sql.="man_usuario.rut, ";
    $sql.="man_usuario.nombre, ";
    $sql.="man_usuario.contacto, ";
    $sql.="man_usuario.email, ";
    $sql.="man_usuario.fono1, ";
    $sql.="man_usuario.fono2, ";
    $sql.="man_usuario.domicilio, ";
    $sql.="man_comuna.id_comuna, ";
    $sql.="man_comuna.nom_comuna, ";
    $sql.="man_usuario.tipo_usu, ";
    $sql.="man_usuario.estado ";
    $sql.="FROM man_usuario ";
    $sql.="INNER JOIN man_comuna ON man_usuario.id_comuna = man_comuna.id_comuna ";

    IF ($accion=="buscar"){        
        $rut        = guardian($_GET['rut']);
        $nombre     = guardian($_GET['nombre']);
        $contacto   = guardian($_GET['contacto']);
        $email      = guardian($_GET['email']);
        $fono1      = guardian($_GET['fono1']);
        $fono2      = guardian($_GET['fono2']);
        $domicilio  = guardian($_GET['domicilio']);
        $id_comuna  = isset($_GET['id_comuna'])?$_GET['id_comuna']:null;
        $tipo_usu   = isset($_GET['tipo_usu'])?$_GET['tipo_usu']:null;
        $estado     = isset($_GET['estado'])?$_GET['estado']:null;      

        $filtro="";
        
        if ($_SESSION['log_tipo']=="Empresa"){
            $filtro=" rut = '".$_SESSION['log_rut']."'";
        }else{
            if ($rut!=""){
                $filtro=" rut = '".$rut."'";
            }
        }

        if ($nombre!=""){
        	if ($filtro!=""){
        		$filtro.=" AND";
        	}
        	$filtro.=" nombre LIKE '%".$nombre."%'";
        }

        if ($contacto!=""){
            if ($filtro!=""){
                $filtro.=" AND";
            } 
            $filtro.=" contacto LIKE '%".$contacto."%'";
        }
        
        if ($email!=""){
            if ($filtro!=""){
                $filtro.=" AND";
            }            

            $filtro.=" email LIKE '%".$email."%'";
        }

        if ($fono1!=""){
            if ($filtro!=""){
                $filtro.=" AND";
            }
            $filtro.=" fono1 LIKE '%".$fono1."%'";
        }
        
        if ($fono2!=""){
            if ($filtro!=""){
                $filtro.=" AND";
            }
            $filtro.=" fono2 LIKE '%".$fono2."%'";
        }
        
        if ($domicilio!=""){
            if ($filtro!=""){
                $filtro.=" AND";
            }
            $filtro.=" domicilio LIKE '%".$domicilio."%'";
        }

        if ($id_comuna!="@"){
            if ($filtro!=""){
                $filtro.=" AND";
            }
            $filtro.=" man_comuna.id_comuna ='".$id_comuna."'";
        }

        if ($tipo_usu!="@"){
        	if ($filtro!=""){
        		$filtro.=" AND";
        	}
        	$filtro.=" tipo_usu ='".$tipo_usu."'";
        } 

        if ($estado!="@"){
            if ($filtro!=""){
                $filtro.=" AND";
            }
            $filtro.=" estado ='".$estado."'";
        }
        
        if($filtro!=""){            
           $sql.=" WHERE ".$filtro;
        }
        
    }ELSE{
        
        if ($_SESSION['log_tipo']=="Empresa"){
            $sql.="WHERE rut='".$_SESSION['log_rut']."'" ;
        }    
    }

    $sql.=" ORDER BY tipo_usu DESC, nombre";
    $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());

    if (mysql_num_rows($run_sql)){
        $n_row=0;
        $color_fila=1;
        while($row=mysql_fetch_array($run_sql)){            
            $n_row++;
            //Seleccion para este formulario
            $seleccion ="'".$row['rut']."',";
            $seleccion.="'".$row['nombre']."',";           
            $seleccion.="'".$row['contacto']."',";
            $seleccion.="'".$row['email']."',";
            $seleccion.="'".$row['fono1']."',";
            $seleccion.="'".$row['fono2']."',";
            $seleccion.="'".$row['domicilio']."',";
            $seleccion.="'".$row['id_comuna']."',";
            $seleccion.="'".$row['tipo_usu']."',";
            $seleccion.="'".$row['estado']."'";  

            if ($color_fila==1){
                echo '<tr class="tabla_datos1" onclick="selecc_usuario('.$seleccion.');">';
                $color_fila=2;
                
            }else if ($color_fila==2){           
                echo '<tr class="tabla_datos2" onclick="selecc_usuario('.$seleccion.');">';
                $color_fila=1;
            }

            if ($row['estado']=="0"){
                    $font_color="DF0101";
            }else{
                if ($row['tipo_usu']=="Empresa"){
                    $font_color="2E2E2E";
                }else{
                    $font_color="0040FF";
                }                    
            }
            
            echo '
            <td style="color:#'.$font_color.'">'.$row['rut'].'</td>
            <td style="color:#'.$font_color.'">'.$row['nombre'].'</td>
            <td style="color:#'.$font_color.'">'.$row['contacto'].'</td>
            <td style="color:#'.$font_color.'">'.$row['email'].'</td>
            <td style="color:#'.$font_color.'">'.$row['fono1'].'</td>
            <td style="color:#'.$font_color.'">'.$row['fono2'].'</td>
            <td style="color:#'.$font_color.'">'.$row['domicilio'].'</td>
            <td style="color:#'.$font_color.'">'.$row['nom_comuna'].'</td>
            <td style="color:#'.$font_color.'">'.$row['tipo_usu'].'</td>
            <td style="color:#'.$font_color.'">';
                if ($row['estado']=="0"){
                    echo "Inactivo";
                }elseif ($row['estado']=="1"){
                    echo "Activo";
                }echo '                
            </td>
            </tr>';
        }     

        echo '
        <tr class="tabla_head"><th colspan="10" align="center"> Cantidad de registros: '.$n_row.'</th> </tr>';
    }else{
        echo '
        <tr class="tabla_datos1"><td colspan="10" ><center>No se encontraron resultados</center></td> </tr>';
    }
    echo '
    </table>';         
}
############################################################################################################
} // FIN CASE CLASS
?>