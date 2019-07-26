<?php session_start() ?>


<?php 

require_once ("func/cnx.php");
$empresa = new empresa ();

$op=isset($_GET['op'])?$_GET['op']:null;
switch($op){
    case'1':
        $empresa->inicio_empresa();
        break;
        
    case'2':
        $empresa->grabar_empresa();
        break;
        
    case'3':
        $empresa->eliminar_empresa();
        break;
        
    case'4':
        $empresa->grilla_empresa();
        break;
}


class empresa {
	
public function inicio_empresa(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
        
    echo '
    <div class="titulo1" align="center">Empresas</div>';
    
    //FORMULARIO
    echo '
    <FORM id="form_empresa" method="post">
     
    <table width="85%" border="0" cellspacing="0" cellpadding="0" class="etq1" align="center">
    <tr height="40px"><td colspan="4" align="center"><label id="msn_update" class="msn_err"></label></td></tr>
    
    <tr>
        <td>Rut:<br/>
            <input type="text" id="rut" style="width:90%" maxlength="10" class="txt1" placeholder="xxxxxxxx-x" onblur="valida_rut('."this,'msn_rut'".');"/>     
            <br><label id="msn_rut" class="msn_err"></label>
        </td>
        
        <td>Razon Social:<br/>
            <input type="text" id="razon_social" style="width:90%" maxlength="50" class="txt1" placeholder="Razon Social" onblur="valida_alfanum(this);"/>   
            <br><label id="msn_razon_social" class="msn_err"></label>
        </td>
    
        <td>Contacto:<br/>
            <input type="text" id="contacto" style="width:90%" maxlength="50" class="txt1" placeholder="Nombre del Contacto" onblur="valida_alfanum(this);"/>      
            <br><label id="msn_contacto" class="msn_err"></label>
        </td>       
    </tr>
    
    <tr><td colspan="4"><hr size="1" color="#6E6E6E"></td></tr>
    
    <tr>
        <td>Tel&eacute;fono 1:<br/>
            <input type="text" id="fono1" style="width:90%" maxlength="50" class="txt1" placeholder="56-9 xxxx xxxx" onblur="valida_alfanum(this);"/>   
            <br><label id="msn_fono1" class="msn_err"></label>
        </td>
    
        <td>Tel&eacute;fono 2:<br/>
            <input type="text" id="fono2" style="width:50%" maxlength="50" class="txt1" placeholder="56-9 xxxx xxxx" onblur="valida_alfanum(this);"/>   
            <br><label id="msn_fono2" class="msn_err"></label>
        </td>
        
          <td>Email:<br/>
             <input type="text" id="email" style="width:90%" maxlength="100" class="txt2" placeholder="xxxxx@xxxxx.com" onblur="valida_alfanum(this);"/>   
            <br><label id="msn_email" class="msn_err"></label>
        </td>      
    </tr>
    
    <tr><td colspan="4"><hr size="1" color="#6E6E6E"></td></tr>
    
    <tr>   
     <td>Domicilio:<br/>
             <input type="text" id="domicilio" style="width:90%" maxlength="100" class="txt1" placeholder="Domicilio" onblur="valida_alfanum(this);"/>   
            <br><label id="msn_domicilio" class="msn_err"></label>
        </td>
        
        <td>Comuna:<br/>'; 
            $sql="SELECT ";
            $sql.="man_comuna_region.n_region, ";
            $sql.="man_comuna_region.nom_region, ";
            $sql.="man_comuna_region.orden_geo, ";
            $sql.="man_comuna.id_comuna, ";
            $sql.="man_comuna.nom_comuna, ";
            $sql.="man_comuna.id_provincia ";
            $sql.="FROM man_comuna_region ";
            $sql.="INNER JOIN man_comuna_provincia ON man_comuna_region.n_region = man_comuna_provincia.n_region ";
            $sql.="INNER JOIN man_comuna ON man_comuna_provincia.id_provincia = man_comuna.id_provincia ";
            $sql.="WHERE man_comuna.activo='1' ";
            $sql.="ORDER BY orden_geo ASC, nom_comuna ASC";
            $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());
            $region_old="";
            
            echo '
            <select id="id_comuna" class="txt1" style="width:90%">
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
            <br/><label id="msn_id_comuna" class="msn_err"></label>
        </td>
                   
        <td>Estado:<br/>
            <select id="estado" style="width:50%" class="txt1"/>
                <option value="@">--Seleccione Estado--</option>
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
            </select>
            <br><label id="msn_estado" class="msn_err"></label>
        </td>            
       
    </tr>
    
    <tr><td colspan="4"><hr size="1" color="#6E6E6E"></td></tr>';
    
    //Botones
    echo '
    <tr height="40px">
        <td colspan="4" align="center">
            <input type="button" title="Grabar" class="bt_grabar" onclick="grabar_empresa();">&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" title="Eliminar" class="bt_eliminar" onclick="eliminar_empresa();">&nbsp;&nbsp;&nbsp;&nbsp;
       <input type="button" title="Buscar" class="bt_buscar" onclick="grilla_empresa('."'buscar'".');">&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" title="Copiar Datos" class="bt_exportar" onclick="copy_grilla_empresa();">&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" title="Limpiar" class="bt_limpiar" onclick="limpia_form_empresa();">&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
    </tr>
    </table>';
    
    //GRILLA
    echo '    
    <DIV id="grilla_empresa">';
                
        //Cabecera Grilla aca puedes configurar la vista de la tabla desde el tamanode la tabla como cada columna
        echo '            
        <table width="85%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr class="tabla_head">
            <td>Rut</th>
            <td>Razon Social</th>
            <td>Contacto</th>
            <td>Fono 1</th>
            <td>Fono 2</th>
            <td>Email</th>
            <td>Domicilio</th>
            <td>Comuna</th>
            <td>Estado</th>
        </tr>';
         
        //Datos Grilla  
        $sql ="SELECT ";
        $sql.="man_empresa.rut, ";
        $sql.="man_empresa.razon_social, ";
        $sql.="man_empresa.contacto, ";
        $sql.="man_empresa.fono1, ";
        $sql.="man_empresa.fono2, ";
        $sql.="man_empresa.email, ";
        $sql.="man_empresa.domicilio, ";
        $sql.="man_comuna.id_comuna, ";
        $sql.="man_comuna.nom_comuna, ";
        $sql.="man_empresa.estado ";
        $sql.="FROM man_empresa ";
        $sql.="INNER JOIN man_comuna ON man_empresa.id_comuna = man_comuna.id_comuna ";
        $sql.="ORDER BY razon_social ";
        $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());            
                    
        if (mysql_num_rows($run_sql)){
            $n_row=0;
            $color_fila=1;
            while($row=mysql_fetch_array($run_sql)){        
                $n_row++;
                
                //Seleccion para este formulario
                $seleccion ="'".$row['rut']."',";
                $seleccion.="'".$row['razon_social']."',";              
                $seleccion.="'".$row['contacto']."',";
                $seleccion.="'".$row['fono1']."',";
                $seleccion.="'".$row['fono2']."',";
                $seleccion.="'".$row['email']."',";
                $seleccion.="'".$row['domicilio']."',";
                $seleccion.="'".$row['id_comuna']."',";
                $seleccion.="'".$row['estado']."'";
               
                if ($color_fila==1){
                    ?><tr class="tabla_datos1" onmouseover="this.className='tabla_datos_over'" onmouseout="this.className='tabla_datos1';" onclick="selecc_empresa(<?php echo $seleccion ?>);"><?php
                    $color_fila=2;
                }else if ($color_fila==2){                        
                    ?><tr class="tabla_datos2" onmouseover="this.className='tabla_datos_over'" onmouseout="this.className='tabla_datos2';" onclick="selecc_empresa(<?php echo $seleccion ?>);"><?php
                    $color_fila=1;                          
                }
                
                if ($row['estado']=="0"){
                    $font_color="DF0101";
                }else{
                    $font_color="2E2E2E";
                }
             
                echo '
                <td style="color:#'.$font_color.'">'.$row['rut'].'</td>
                <td style="color:#'.$font_color.'">'.$row['razon_social'].'</td>
                <td style="color:#'.$font_color.'">'.$row['contacto'].'</td>
                <td style="color:#'.$font_color.'">'.$row['fono1'].'</td>
                <td style="color:#'.$font_color.'">'.$row['fono2'].'</td>
                <td style="color:#'.$font_color.'">'.$row['email'].'</td>
                <td style="color:#'.$font_color.'">'.$row['domicilio'].'</td>
                <td style="color:#'.$font_color.'">'.$row['nom_comuna'].'</td>
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
                <tr class="tabla_head"><th colspan="9" align="center"> Cantidad de registros: '.$n_row.'</th> </tr>';
                                    
        }else{
            
            echo '<tr class="tabla_datos1"><td colspan="9" ><center>No se encontraron resultados</center></td> </tr>';
        }
        echo '
        </table>
    </DIV>
    
    <div id="salida"></div>
    </FORM>';
}
public function grabar_empresa(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
        
    $rut          = strtoupper(guardian($_GET['rut']));
    $razon_social = ucwords(strtolower(guardian($_GET['razon_social'])));//1era Letra De Cada Palabra Mayuscula
    $contacto     = ucwords(strtolower(guardian($_GET['contacto'])));//1era Letra De Cada Palabra Mayuscula
    $fono1        = ucwords(strtolower(guardian($_GET['fono1'])));//1era Letra De Cada Palabra Mayuscula
    $fono2        = ucwords(strtolower(guardian($_GET['fono2'])));//1era Letra De Cada Palabra Mayuscula
    $email        = guardian(strtolower($_GET['email']));//todo a minusculas 
    $domicilio    = ucwords(strtolower(guardian($_GET['domicilio'])));//1era Letra De Cada Palabra Mayuscula
    $id_comuna    = isset($_GET['id_comuna'])?$_GET['id_comuna']:null;
    $estado       = isset($_GET['estado'])?$_GET['estado']:null;

    $sql="SELECT * FROM man_empresa WHERE rut='".$rut."'";
    $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
        
    if (mysql_num_rows($run_sql)){
        $sql = "UPDATE man_empresa SET ";
        $sql.= "razon_social='".$razon_social."',";
        $sql.= "contacto='".$contacto."',";
        $sql.= "fono1='".$fono1."',";
        $sql.= "fono2='".$fono2."',";
        $sql.= "email='".$email."',";
        $sql.= "domicilio='".$domicilio."',";
        $sql.= "id_comuna='".$id_comuna."',";
        $sql.= "estado='".$estado."',";
        $sql.= "reg_rut='".$_SESSION['log_rut']."',";
        $sql.= "reg_fecha='".date('Y-m-d H:i:s')."'";
        $sql.= "WHERE rut='".$rut."'";
        $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
        
        echo '<input type="hidden" id="eco_grabar" value="update_ok"/>';
         
    }else{
    
        $sql="INSERT INTO man_empresa(";   
            $sql.="rut,";
            $sql.="razon_social,";
            $sql.="contacto,";
            $sql.="fono1,";
            $sql.="fono2,";
            $sql.="email,";
            $sql.="domicilio,";    
            $sql.="id_comuna,";
            $sql.="estado,";
            $sql.="reg_fecha,";
            $sql.="reg_rut)";
        $sql.="VALUES (";
            $sql.="'".$rut."',";
            $sql.="'".$razon_social."',";
            $sql.="'".$contacto."',";
            $sql.="'".$fono1."',";
            $sql.="'".$fono2."',";
            $sql.="'".$email."',";
            $sql.="'".$domicilio."',";         
            $sql.="'".$id_comuna."',";
            $sql.="'".$estado."',";
            $sql.="'".date('Y-m-d H:i:s')."',";
            echo $sql.="'".$_SESSION['log_rut']."')";
        $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
        
        echo '<input type="hidden" id="eco_grabar" value="insert_ok"/>';
    }
}

public function eliminar_empresa() {
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
        
    $rut            = guardian($_GET['rut']);
    $razon_social   = guardian($_GET['razon_social']);
  
    $sql="SELECT * FROM man_empresa ";
    $sql.="WHERE rut='".$rut."'AND razon_social='".$razon_social."'";
    $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
    
    if (mysql_num_rows($run_sql)){
        
        $sql = "DELETE FROM man_empresa ";
        $sql.="WHERE rut='".$rut."'AND razon_social='".$razon_social."'";
        
        $run_sql=mysql_query($sql) or die ('<center><label class="msn_err">No se puede eliminar porque hay datos vinculados<br/>
                                            Rut: '.$rut.' &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;
                                            Razon Social: '.$razon_social.'</b></label></center>');
                                               
        echo '<input type="hidden" id="eco_eliminar" value="delete_ok"/>';        
    }else{
        echo '<input type="hidden" id="eco_eliminar" value="err_delete"/>';
    }
}

public function grilla_empresa(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    $accion=isset($_GET['accion'])?$_GET['accion']:null;   
    
    //Cabecera Grilla aca puedes configurar la vista de la tabla desde el tamano de la tabla como cada columna
    echo '            
    <table width="85%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr class="tabla_head">
        <td>Rut</th>
        <td>Razon Social</th>
        <td>Contacto</th>
        <td>Fono</th>
        <td>Fono 2</th>
        <td>Email</th>
        <td>Domicilio</th>
        <td>Comuna</th>
        <td>Estado</th>
    </tr>';
    
    $sql="SELECT ";
    $sql.="man_empresa.rut, ";
    $sql.="man_empresa.razon_social, ";
    $sql.="man_empresa.contacto, ";
    $sql.="man_empresa.fono1, ";
    $sql.="man_empresa.fono2, ";
    $sql.="man_empresa.email, ";
    $sql.="man_empresa.domicilio, ";
    $sql.="man_comuna.id_comuna, ";
    $sql.="man_comuna.nom_comuna, ";
    $sql.="man_empresa.estado ";
    $sql.="FROM man_empresa ";
    $sql.="INNER JOIN man_comuna ON man_empresa.id_comuna = man_comuna.id_comuna ";
    
    if ($accion=="buscar"){
        
        $rut        = guardian($_GET['rut']);
        $razon_social= guardian($_GET['razon_social']);
        $contacto   = guardian($_GET['contacto']);
        $fono1       = guardian($_GET['fono1']);
        $fono2       = guardian($_GET['fono2']);
        $email      = guardian($_GET['email']);
        $domicilio  = guardian($_GET['domicilio']);           
        $id_comuna  = isset($_GET['id_comuna'])?$_GET['id_comuna']:null;
        $estado     = isset($_GET['estado'])?$_GET['estado']:null;
       
        $filtro="";
                            
        if ($rut!=""){ 
            $filtro=" rut = '".$rut."'";        
        }
        
        if ($razon_social!=""){
            if ($filtro!=""){
                $filtro.=" AND";
            }     
            $filtro.=" razon_social LIKE '%".$razon_social."%'";      
        }

        if ($contacto!=""){
            if ($filtro!=""){
                $filtro.=" AND";
            }
            $filtro.=" contacto LIKE '%".$contacto."%'";
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
        
        if ($email!=""){
            if ($filtro!=""){
                $filtro.=" AND";
            }     
            $filtro.=" email LIKE '%".$email."%'";  
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
               
         if ($estado!="@"){
            if ($filtro!=""){
                $filtro.=" AND";  
            }        
            $filtro.=" estado ='".$estado."'";     
        }
        
        if($filtro!=""){     
           $sql.=" WHERE ".$filtro;
        }
    }
    
    $sql.=" ORDER BY razon_social";
    $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());                         
                
    if (mysql_num_rows($run_sql)){
        $n_row=0;
        $color_fila=1;
        while($row=mysql_fetch_array($run_sql)){
            $n_row++;
            
            //Seleccion para este formulario
            $seleccion ="'".$row['rut']."',";
            $seleccion.="'".$row['razon_social']."',";         
            $seleccion.="'".$row['contacto']."',";
            $seleccion.="'".$row['fono1']."',";
            $seleccion.="'".$row['fono2']."',";
            $seleccion.="'".$row['email']."',";
            $seleccion.="'".$row['domicilio']."',";
            $seleccion.="'".$row['id_comuna']."',";
            $seleccion.="'".$row['estado']."'";
           
            if ($color_fila==1){
                ?><tr class="tabla_datos1" onmouseover="this.className='tabla_datos_over'" onmouseout="this.className='tabla_datos1';" onclick="selecc_empresa(<?php echo $seleccion ?>);"><?php
                $color_fila=2;
            }else if ($color_fila==2){           
                ?><tr class="tabla_datos2" onmouseover="this.className='tabla_datos_over'" onmouseout="this.className='tabla_datos2';" onclick="selecc_empresa(<?php echo $seleccion ?>);"><?php
                $color_fila=1;               
            }
            
            if ($row['estado']=="0"){
                $font_color="DF0101";
            }else{
                $font_color="2E2E2E";
            }  
         
            echo '
            <td style="color:#'.$font_color.'">'.$row['rut'].'</td>
            <td style="color:#'.$font_color.'">'.$row['razon_social'].'</td>
            <td style="color:#'.$font_color.'">'.$row['contacto'].'</td>
            <td style="color:#'.$font_color.'">'.$row['fono1'].'</td>
            <td style="color:#'.$font_color.'">'.$row['fono2'].'</td>
            <td style="color:#'.$font_color.'">'.$row['email'].'</td>
            <td style="color:#'.$font_color.'">'.$row['domicilio'].'</td>
            <td style="color:#'.$font_color.'">'.$row['nom_comuna'].'</td>
             
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
            <tr class="tabla_head"><th colspan="9" align="center"> Cantidad de registros: '.$n_row.'</th> </tr>';
                                
    }else{
        
        echo '<tr class="tabla_datos1"><td colspan="9" ><center>No se encontraron resultados</center></td> </tr>';
    }
    echo '
    </table>';
}

#######################################################################333
}//END CASE                     
?>