<?php
session_start();

if (!isset($_SESSION['log_rut']) OR !isset($_SESSION['log_nom']) OR !isset($_SESSION['log_tipo'])){                  
    echo '<input type="text" id="sesion" value="err">';
    return false;
}
?>

<?php 

require_once ("func/cnx.php");
$op=isset($_GET['op'])?$_GET['op']:null;

$alojamiento= new alojamiento();
switch($op){
    case'1':
        $alojamiento->inicio_alojamiento();
        break;        

    case'2':
        $alojamiento->grabar_alojamiento();
        break;        

    case'3':
        $alojamiento->eliminar_alojamiento();
        break;        

    case'4':
        $alojamiento->grilla_alojamiento();
        break;
}

class alojamiento {
###########################################################################################################
public function inicio_alojamiento() {    
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");        

    echo '
    <div class="titulo1" align="center">Alojamientos</div>';    

    //FORMULARIO
    echo '
    <FORM id="form_alojamiento" method="post">

    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="panel1" align="center">
    <tr height="40px"><td colspan="4" align="center"><label id="msn_update" class="msn_err"></label></td></tr>

    <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>
    
    <tr height="40px">
        <td align="center">ID Establecim:<br/>
            <input type="text" id="id_estab" size="12" class="txt3" onclick="limpia_form_alojamiento();" readonly/>
            <br/><label id="msn_id" class="msn_err"></label>
        </td>
        
        <td align="center">Empresa:<br/>';
            $sql ="SELECT ";
            $sql.="man_usuario.rut, ";
            $sql.="man_usuario.nombre, ";
            $sql.="man_usuario.id_comuna, ";
            $sql.="man_comuna.nom_comuna, ";
            $sql.="man_usuario.tipo_usu ";
            $sql.="FROM man_usuario ";
            $sql.="INNER JOIN man_comuna ON man_usuario.id_comuna = man_comuna.id_comuna ";
            $sql.="WHERE tipo_usu='Empresa'";
            
            if ($_SESSION['log_tipo']=="Empresa"){
                $sql.=" AND rut='".$_SESSION['log_rut']."'";
                $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());
                
                echo '
                <select id="rut_empr" class="txt3" disabled/>';
                if (mysql_num_rows($run_sql)){
                    while($row=mysql_fetch_array($run_sql)){
                      echo'<option value="'.$row['rut'].'">'.$row['nombre']." (".$row['nom_comuna'].')</option>';
                    }
                }
                echo '
                </select>';
                
            }else{
                $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());
                echo '
                <select id="rut_empr" class="txt1">
                <option value="@">--Seleccione Empresa--</option>';
                if (mysql_num_rows($run_sql)){
                    while($row=mysql_fetch_array($run_sql)){
                      echo'<option value="'.$row['rut'].'">'.$row['nombre']." (".$row['nom_comuna'].')</option>';
                    }
                }
                echo '
                </select>';
            }
            echo '     
            <br/><label id="msn_empresa" class="msn_err"></label>
        </td>
    </tr>
    
    <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>
    
    <tr height="40px">
        <td align="center">Nombre de Establecimiento:<br/>
            <input type="text" id="nom_estab" style="width:80%;" maxlength="100" class="txt1" placeholder="Nombre" onblur="valida_alfanum(this);"/>
            <br><label id="msn_nom_estab" class="msn_err"></label>
        </td>
    
        <td align="center">Tipo de Alojamiento:<br/>';
        
            $sql ="SELECT ";
            $sql.="man_tipo_alojam.id_tipo_alojam, ";
            $sql.="man_tipo_alojam.nom_tipo_alojam ";
            $sql.="FROM man_tipo_alojam ";
            $sql.="ORDER BY orden ";
            $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());
                echo '
                <select id="tipo_alojam" class="txt1">
                <option value="@">--Seleccione Tipo Alojam--</option>';
                if (mysql_num_rows($run_sql)){
                    while($row=mysql_fetch_array($run_sql)){
                      echo'<option value="'.$row['id_tipo_alojam'].'">'.$row['nom_tipo_alojam'].'</option>';
                    }
                }
                echo '
                </select>';
            echo '
            <br><label id="msn_tipo_alojam" class="msn_err"></label>
        </td>
    </tr>

    <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>
    
    <tr height="40px">
        <td align="center">Estrellas:<br/>
            <select id="estrella" style="width:80%;" class="txt1"/>
                <option value="@">--Seleccione Estrellas--</option>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            <br><label id="msn_estrella" class="msn_err"></label>
        </td> 
          
        
        <td align="center">Desayuno:<br/>
            <select id="id_desayuno" style="width:80%;" class="txt1"/>
                <option value="@">--Seleccione Desayuno--</option>
               
                <option value="1">Americano</option>
                <option value="2">Buffet</option>
                <option value="3">Continental</option>
                <option value="4">Ingles</option>
                <option value="5">Sin Desayuno</option>
            </select>
            <br><label id="msn_id_desayuno" class="msn_err"></label>
        </td>       
    </tr>

    <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>   

    <tr height="40px">        
        <td align="center">Restaurant:<br/>
            <select id="restaurant" style="width:80%;" class="txt1"/>
                <option value="@">--Tiene Restaurant ?--</option>
                <option value="0">No</option>
                <option value="1">Si</option>
            </select>
            <br><label id="msn_restaurant" class="msn_err"></label>
        </td>                                       
        
        <td align="center">Bar:<br/>
            <select id="bar" style="width:80%;" class="txt1"/>
                <option value="@">--Tiene Bar ?--</option>
                <option value="0">No</option>
                <option value="1">Si</option>
            </select>
            <br><label id="msn_bar" class="msn_err"></label>
        </td>
    </tr>
    <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>

    <tr height="40px">
        <td align="center">Quincho:<br/>
            <select id="quincho" style="width:80%;" class="txt1"/>
                <option value="@">--Tiene Quincho ?--</option>
                <option value="0">No</option>
                <option value="1">Si</option>
            </select>
            <br><label id="msn_quincho" class="msn_err"></label>
        </td>

        <td align="center">Piscina:<br/>
            <select id="piscina" style="width:80%;" class="txt1"/>
                <option value="@">--Tiene Piscina ?--</option>
                <option value="0">No</option>
                <option value="1">Si</option>
            </select>
            <br><label id="msn_piscina" class="msn_err"></label>
        </td>
    </tr>

    <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>
    
    <tr>
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
            <select id="id_comuna" style="width:80%;" class="txt1">
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
        
        <td align="center">Coordenadas:<br/>
            <input type="text" id="coord_maps" style="width:80%;" maxlength="30" class="txt1" placeholder="Latitud y Longitud" onblur="valida_alfanum(this);"/>
            <br><label id="msn_coordenadas" class="msn_err"></label>
        </td>    
    </tr>   
    
    <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>';    

    //Botones
    echo '
    <tr height="40px">
        <td colspan="2" align="center">
            <input type="button" title="Grabar" class="bt_grabar" onclick="grabar_alojamiento();">&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" title="Eliminar" class="bt_eliminar" onclick="eliminar_alojamiento();">&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" title="Buscar" class="bt_buscar" onclick="grilla_alojamiento('."'buscar'".');">&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" title="Copiar Datos" class="bt_exportar" onclick="copy_grilla_alojamiento();">&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" title="Limpiar" class="bt_limpiar" onclick="limpia_form_alojamiento();">
            <input type="button" name="bt_reload" onclick="grilla_alojamiento('."'reload'".');" style="display:none;">
        </td>
    </tr>
    </table>';    

    //GRILLA
    echo '
    <DIV id="grilla_alojamiento">';    
        //Cabecera Grilla
        echo '
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr class="tabla_head">
            <td>ID</td>
            <td>Empresa</td>
            <td>Nombre</td>
            <td>Tipo Alojamiento</td>
            <td>Estrellas</td>
            <td>Desayuno</td>
            <td>Restaurant</td>
            <td>Bar</td>
            <td>Quincho</td>
            <td>Piscina</td>
            <td>Comuna</td>
            <td>Coordenadas</td>
            <td align="center">Opc</td>
        </tr>';  

        //Datos Grilla        
        $sql ="SELECT ";
        $sql.="alojam_estab.id_estab, ";
        $sql.="alojam_estab.nom_estab, ";
        $sql.="alojam_estab.rut_empr, ";
        $sql.="man_usuario.nombre AS nom_empr, ";
        $sql.="alojam_estab.tipo_alojam, ";
        $sql.="man_tipo_alojam.nom_tipo_alojam, ";
        $sql.="alojam_estab.estrella, ";
        $sql.="alojam_estab.id_desayuno, ";
        $sql.="man_desayuno.nom_desayuno, ";
        $sql.="alojam_estab.restaurant, ";
        $sql.="alojam_estab.bar, ";
        $sql.="alojam_estab.quincho, ";
        $sql.="alojam_estab.piscina, ";
        $sql.="alojam_estab.id_comuna, ";
        $sql.="man_comuna.nom_comuna, ";
        $sql.="alojam_estab.coord_maps ";
        $sql.="FROM alojam_estab ";
        $sql.="INNER JOIN man_usuario ON alojam_estab.rut_empr = man_usuario.rut ";
        $sql.="INNER JOIN man_tipo_alojam ON alojam_estab.tipo_alojam = man_tipo_alojam.id_tipo_alojam ";
        $sql.="INNER JOIN man_desayuno ON alojam_estab.id_desayuno = man_desayuno.id_desayuno ";
        $sql.="INNER JOIN man_comuna ON alojam_estab.id_comuna = man_comuna.id_comuna ";
        
        if ($_SESSION['log_tipo']=="Empresa"){
            $sql.="WHERE rut='".$_SESSION['log_rut']."'";
        }
        
        $sql.="ORDER BY id_estab DESC";
        $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());

        if (mysql_num_rows($run_sql)){
            $n_row=0;
            $color_fila=1;
            while($row=mysql_fetch_array($run_sql)){
                $n_row++;            

                //Seleccion para este formulario
                $seleccion ="'".$row['id_estab']."',";
                $seleccion.="'".$row['rut_empr']."',";
                $seleccion.="'".$row['nom_estab']."',";            
                $seleccion.="'".$row['tipo_alojam']."',";
                $seleccion.="'".$row['estrella']."',";
                $seleccion.="'".$row['id_desayuno']."',";
                $seleccion.="'".$row['restaurant']."',";
                $seleccion.="'".$row['bar']."',";
                $seleccion.="'".$row['quincho']."',";
                $seleccion.="'".$row['piscina']."',";
                $seleccion.="'".$row['id_comuna']."',";
                $seleccion.="'".$row['coord_maps']."'";
                
                if ($color_fila==1){
                    echo '<tr height="60px" class="tabla_datos1" onclick="selecc_alojamiento('.$seleccion.');">';
                    $color_fila=2;
                    
                }else if ($color_fila==2){                                                              
                    echo '<tr height="60px" class="tabla_datos2" onclick="selecc_alojamiento('.$seleccion.');">';
                    $color_fila=1;
                }
                
                if ($row['restaurant']=="0"){
                    $restaurant = "No";
                }else{
                    $restaurant = "Si";
                }
                
                if ($row['bar']=="0"){
                    $bar = "No";
                }else{
                    $bar = "Si";
                }
                
                if ($row['quincho']=="0"){
                    $quincho = "No";
                }else{
                    $quincho = "Si";
                }
                
                if ($row['piscina']=="0"){
                    $piscina = "No";
                }else{
                    $piscina = "Si";
                }
                
                //CONT UNIDAD
                $sql2=" SELECT COUNT(*) AS cont_unidad FROM alojam_unidad ";
                $sql2.="WHERE id_estab='".$row['id_estab']."'";
                $run_sql2=mysql_query($sql2) or die ('ErrorSql > '.mysql_error ());                     
                if (mysql_num_rows($run_sql2)){                                        
                    while($row2=mysql_fetch_array($run_sql2)){
                        $cont_unidad=$row2['cont_unidad'];
                    }                    
                    if ($cont_unidad=="0"){
                        $cont_unidad=" ";
                    }
                }
                
                //CONT ARCH
                $sql2=" SELECT COUNT(*) AS cont_arch FROM alojam_estab_archivo ";
                $sql2.="WHERE id_estab='".$row['id_estab']."'";
                $run_sql2=mysql_query($sql2) or die ('ErrorSql > '.mysql_error ());                     
                if (mysql_num_rows($run_sql2)){                                        
                    while($row2=mysql_fetch_array($run_sql2)){
                        $cont_arch=$row2['cont_arch'];
                    }                    
                    if ($cont_arch=="0"){
                        $cont_arch=" ";
                    }
                }
                
                echo '
                <td>'.$row['id_estab'].'</td>
                <td>'.$row['nom_empr'].'</td>
                <td>'.$row['nom_estab'].'</td>
                <td>'.$row['nom_tipo_alojam'].'</td>
                <td>'.$row['estrella'].'</td>
                <td>'.$row['nom_desayuno'].'</td>
                <td>'.$restaurant.'</td>
                <td>'.$bar.'</td>
                <td>'.$quincho.'</td>
                <td>'.$piscina.'</td>
                <td>'.$row['nom_comuna'].'</td>
                <td>'.$row['coord_maps'].'</td>
                <td align="center">';
                    echo '<input type="button" title="Configuracion Habitaciones" class="icono_habitacion" value="'.$cont_unidad.'" onclick="go_habit_unidad('."'".$row['id_estab']."'".');">&nbsp;'; 
                    
                    echo '<input type="button" title="Fotos Establecimiento/Exterior" class="icono_foto" value="'.$cont_arch.'" onclick="go_arch_estab('."'".$row['id_estab']."'".');">';
                echo '
                </td>
                </tr>';
            }     

            echo '
            <tr class="tabla_head"><th colspan="13" align="center"> Cantidad de registros: '.$n_row.'</th> </tr>';
        }else{
            echo '
            <tr class="tabla_datos1"><td colspan="13" ><center>No se encontraron resultados</center></td> </tr>';
        }
        echo '
        </table>
    </DIV>
    
    <div id="salida"></div>
    </FORM>';
}

public function grabar_alojamiento() {    
    IF (isset($_SESSION['log_rut']) AND isset($_SESSION['log_nom']) AND isset($_SESSION['log_tipo'])){
        echo '<input type="hidden" id="sesion" value="ok">';
    ###########################################################################################
    
        $cnx=conexion();
        date_default_timezone_set("Chile/Continental");       
    
        $id_estab       = isset($_GET['id_estab'])?$_GET['id_estab']:null;
        $rut_empr       = isset($_GET['rut_empr'])?$_GET['rut_empr']:null;
        $nom_estab      = guardian($_GET['nom_estab']);//1era Letra De Cada Palabra Mayuscula 
        $tipo_alojam    = isset($_GET['tipo_alojam'])?$_GET['tipo_alojam']:null;
        $estrella       = isset($_GET['estrella'])?$_GET['estrella']:null;
        $id_desayuno    = isset($_GET['id_desayuno'])?$_GET['id_desayuno']:null;
        $restaurant     = isset($_GET['restaurant'])?$_GET['restaurant']:null; 
        $bar            = isset($_GET['bar'])?$_GET['bar']:null; 
        $quincho        = isset($_GET['quincho'])?$_GET['quincho']:null;
        $piscina        = isset($_GET['piscina'])?$_GET['piscina']:null;
        $id_comuna      = isset($_GET['id_comuna'])?$_GET['id_comuna']:null;
        $coord_maps     = isset($_GET['coord_maps'])?$_GET['coord_maps']:null;
    
        $sql="SELECT * FROM alojam_estab WHERE id_estab='".$id_estab."'";
        $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());         
    
        if (mysql_num_rows($run_sql)){
            $sql = "UPDATE alojam_estab SET ";
            $sql.= "rut_empr='".$rut_empr."',";
            $sql.= "nom_estab='".$nom_estab."',";
            $sql.= "tipo_alojam='".$tipo_alojam."',";
            $sql.= "estrella='".$estrella."',";
            $sql.= "id_desayuno='".$id_desayuno."',";
            $sql.= "restaurant='".$restaurant."',";
            $sql.= "bar='".$bar."',";
            $sql.= "quincho='".$quincho."',";
            $sql.= "piscina='".$piscina."',";
            $sql.= "id_comuna='".$id_comuna."',";
            $sql.= "coord_maps='".$coord_maps."',";
    
            
            $sql.= "reg_rut='".$_SESSION['log_rut']."',";
            $sql.= "reg_fecha='".date('Y-m-d H:i:s')."' ";
            $sql.= "WHERE id_estab='".$id_estab."'";
            $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
    
            echo '<input type="hidden" id="eco_grabar" value="update_ok"/>';         
    
        }else{
            $sql="SELECT MAX(id_estab) AS id_max FROM alojam_estab";
            $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
            if (mysql_num_rows($run_sql)){   
                while($row=mysql_fetch_array($run_sql)){
                    if($row['id_max']==""){
                        $new_id=1;
                    }else{
                        $new_id=($row['id_max']+1);                
                    }          
                }
            }
    
            $sql="INSERT INTO alojam_estab(";            
                $sql.="id_estab,";
                $sql.="rut_empr,";
                $sql.="nom_estab,";
                $sql.="tipo_alojam,";
                $sql.="estrella,";
                $sql.="id_desayuno,";
                $sql.="restaurant,";
                $sql.="bar,";
                $sql.="quincho,";
                $sql.="piscina,";
                $sql.="id_comuna,";
                $sql.="coord_maps,";            
                $sql.="reg_fecha,";
                $sql.="reg_rut)";        
            $sql.="VALUES (";        
                $sql.="'".$new_id."',";
                $sql.="'".$rut_empr."',";
                $sql.="'".$nom_estab."',";
                $sql.="'".$tipo_alojam."',";
                $sql.="'".$estrella."',";
                $sql.="'".$id_desayuno."',";
                $sql.="'".$restaurant."',";
                $sql.="'".$bar."',";         
                $sql.="'".$quincho."',";
                $sql.="'".$piscina."',";
                $sql.="'".$id_comuna."',";
                $sql.="'".$coord_maps."',";
                $sql.="'".date('Y-m-d H:i:s')."',";
                $sql.="'".$_SESSION['log_rut']."')";
            $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
    
                echo '<input type="hidden" id="eco_grabar" value="insert_ok"/>';
                echo '<input type="hidden" id="eco_id" value="'.$new_id.'"/>';
            }
    
    ###########################################################################################
    }ELSE{        
        echo '<input type="hidden" id="sesion" value="cerrar">';
    }
}

public function eliminar_alojamiento() {
    
    IF (isset($_SESSION['log_rut']) AND isset($_SESSION['log_nom']) AND isset($_SESSION['log_tipo'])){
        echo '<input type="hidden" id="sesion" value="ok">';
    ###########################################################################################
        
        $cnx=conexion();
        date_default_timezone_set("Chile/Continental");
    
        $id_estab   = isset($_GET['id_estab'])?$_GET['id_estab']:null;
        $nom_estab  = isset($_GET['nom_estab'])?$_GET['nom_estab']:null;
    
        $sql="SELECT * FROM alojam_estab ";
        $sql.="WHERE id_estab='".$id_estab."' AND  nom_estab='".$nom_estab."'";
        $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
        
        if (mysql_num_rows($run_sql)){
            $sql = "DELETE FROM alojam_estab ";
            $sql.="WHERE  id_estab='".$id_estab."'  AND nom_estab='".$nom_estab."'";
    
            $run_sql=mysql_query($sql) or die ('<center><label class="msn_err">No se puede eliminar porque hay datos vinculados<br/>
                                                
                                                ID: '.$id_estab.' &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;
                                                Nombre Establec: '.$nom_estab.'</b></label></center>');                                     
    
            echo '<input type="hidden" id="eco_eliminar" value="delete_ok"/>';      
    
        }else{
            echo '<input type="hidden" id="eco_eliminar" value="err_delete"/>';
        }
        
    ###########################################################################################    
    }ELSE{        
        echo '<input type="hidden" id="sesion" value="cerrar">';
    }
} 

public function grilla_alojamiento() {
    
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    $accion = isset($_GET['accion'])?$_GET['accion']:null;
    
    //Cabecera Grilla
    echo '
    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr class="tabla_head">
        <td>ID</td>
        <td>Empresa</td>
        <td>Nombre</td>
        <td>Tipo Alojamiento</td>
        <td>Estrellas</td>
        <td>Desayuno</td>
        <td>Restaurant</td>
        <td>Bar</td>
        <td>Quincho</td>
        <td>Piscina</td>
        <td>Comuna</td>
        <td>Coordenadas</td>
        <td align="center">Opc</td>
    </tr>';
    
    //Datos Grilla
    $sql ="SELECT ";
    $sql.="alojam_estab.id_estab, ";
    $sql.="alojam_estab.nom_estab, ";
    $sql.="alojam_estab.rut_empr, ";
    $sql.="man_usuario.nombre AS nom_empr, ";
    $sql.="alojam_estab.tipo_alojam, ";
    $sql.="man_tipo_alojam.nom_tipo_alojam, ";
    $sql.="alojam_estab.estrella, ";
    $sql.="alojam_estab.id_desayuno, ";
    $sql.="man_desayuno.nom_desayuno, ";
    $sql.="alojam_estab.restaurant, ";
    $sql.="alojam_estab.bar, ";
    $sql.="alojam_estab.quincho, ";
    $sql.="alojam_estab.piscina, ";
    $sql.="alojam_estab.id_comuna, ";
    $sql.="man_comuna.nom_comuna, ";
    $sql.="alojam_estab.coord_maps ";
    $sql.="FROM alojam_estab ";
    $sql.="INNER JOIN man_usuario ON alojam_estab.rut_empr = man_usuario.rut ";
    $sql.="INNER JOIN man_tipo_alojam ON alojam_estab.tipo_alojam = man_tipo_alojam.id_tipo_alojam ";
    $sql.="INNER JOIN man_desayuno ON alojam_estab.id_desayuno = man_desayuno.id_desayuno ";
    $sql.="INNER JOIN man_comuna ON alojam_estab.id_comuna = man_comuna.id_comuna ";    
    
    if ($accion=="buscar"){
        $id_estab       = isset($_GET['id_estab'])?$_GET['id_estab']:null;
        $rut_empr       = isset($_GET['rut_empr'])?$_GET['rut_empr']:null;
        $nom_estab      = isset($_GET['nom_estab'])?$_GET['nom_estab']:null;
        $tipo_alojam    = isset($_GET['tipo_alojam'])?$_GET['tipo_alojam']:null;
        $estrella       = isset($_GET['estrella'])?$_GET['estrella']:null;
        $id_desayuno    = isset($_GET['id_desayuno'])?$_GET['id_desayuno']:null;
        $restaurant     = isset($_GET['restaurant'])?$_GET['restaurant']:null;  
        $bar            = isset($_GET['bar'])?$_GET['bar']:null;
        $quincho        = isset($_GET['quincho'])?$_GET['quincho']:null;
        $piscina        = isset($_GET['piscina'])?$_GET['piscina']:null;
        $id_comuna      = isset($_GET['id_comuna'])?$_GET['id_comuna']:null;
        $coord_maps     = isset($_GET['coord_maps'])?$_GET['coord_maps']:null;      
    
        $filtro="";
    
    
        if ($id_estab!=""){
            $filtro=" id_estab = '".$id_estab."'";
        }
        
        if ($rut_empr!="@"){
            if ($filtro!=""){
                $filtro.=" AND";
            }
            $filtro=" rut_empr = '".$rut_empr."'";
        }
    
        if ($nom_estab!=""){
            if ($filtro!=""){
                $filtro.=" AND";
            }
            $filtro.=" nom_estab LIKE '%".$nom_estab."%'";
        }
    
         if ($tipo_alojam!="@"){
            if ($filtro!=""){
                $filtro.=" AND";
            }
            $filtro.=" tipo_alojam ='".$tipo_alojam."'";
        }
    
        if ($estrella!="@"){
            if ($filtro!=""){
                $filtro.=" AND";
            }
            $filtro.=" estrella ='".$estrella."'";
        }
    
         if ($id_desayuno!="@"){
            if ($filtro!=""){
                $filtro.=" AND";
            }
            $filtro.=" alojam_estab.id_desayuno ='".$id_desayuno."'";
        }
    
         if ($restaurant!="@"){
            if ($filtro!=""){
                $filtro.=" AND";
            }
            $filtro.=" restaurant ='".$restaurant."'";
        }
        
         if ($bar!="@"){
            if ($filtro!=""){
                $filtro.=" AND";
            }
            $filtro.=" bar ='".$bar."'";
        }
    
        if ($quincho!="@"){
            if ($filtro!=""){
                $filtro.=" AND";
            }
            $filtro.=" quincho ='".$quincho."'";
        }
    
        if ($piscina!="@"){
            if ($filtro!=""){
                $filtro.=" AND";
            }
            $filtro.=" piscina ='".$piscina."'";
        }
    
        if ($id_comuna!="@"){
            if ($filtro!=""){
                $filtro.=" AND";
            }
            $filtro.=" man_comuna.id_comuna ='".$id_comuna."'";
        }
    
    
    
        if ($coord_maps!=""){
            if ($filtro!=""){
                $filtro.=" AND";
            }
            $filtro.=" coord_maps ='".$coord_maps."'";
        }
        
        if($filtro!=""){
           $sql.=" WHERE ".$filtro;
        }
    }else{
        
        if ($_SESSION['log_tipo']=="Empresa"){
            $sql.="WHERE rut='".$_SESSION['log_rut']."'";
        }      
    }
    
    $sql.=" ORDER BY id_estab DESC";
    $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());
    
    if (mysql_num_rows($run_sql)){
        $n_row=0;
        $color_fila=1;
        while($row=mysql_fetch_array($run_sql)){            
            $n_row++;
            
            //Seleccion para este formulario
            $seleccion ="'".$row['id_estab']."',";
            $seleccion.="'".$row['rut_empr']."',";
            $seleccion.="'".$row['nom_estab']."',";            
            $seleccion.="'".$row['tipo_alojam']."',";
            $seleccion.="'".$row['estrella']."',";
            $seleccion.="'".$row['id_desayuno']."',";
            $seleccion.="'".$row['restaurant']."',";
            $seleccion.="'".$row['bar']."',";
            $seleccion.="'".$row['quincho']."',";
            $seleccion.="'".$row['piscina']."',";
            $seleccion.="'".$row['id_comuna']."',";
            $seleccion.="'".$row['coord_maps']."'";
            
            if ($color_fila==1){
                echo '<tr height="60px" class="tabla_datos1" onclick="selecc_alojamiento('.$seleccion.');">';
                $color_fila=2;
                
            }else if ($color_fila==2){                                                              
                echo '<tr height="60px" class="tabla_datos2" onclick="selecc_alojamiento('.$seleccion.');">';
                $color_fila=1;
            }
            
            if ($row['restaurant']=="0"){
                $restaurant = "No";
            }else{
                $restaurant = "Si";
            }
            
            if ($row['bar']=="0"){
                $bar = "No";
            }else{
                $bar = "Si";
            }
            
            if ($row['quincho']=="0"){
                $quincho = "No";
            }else{
                $quincho = "Si";
            }
            
            if ($row['piscina']=="0"){
                $piscina = "No";
            }else{
                $piscina = "Si";
            }
            
            //CONT UNIDAD
            $sql2=" SELECT COUNT(*) AS cont_unidad FROM alojam_unidad ";
            $sql2.="WHERE id_estab='".$row['id_estab']."'";
            $run_sql2=mysql_query($sql2) or die ('ErrorSql > '.mysql_error ());                     
            if (mysql_num_rows($run_sql2)){                                        
                while($row2=mysql_fetch_array($run_sql2)){
                    $cont_unidad=$row2['cont_unidad'];
                }                    
                if ($cont_unidad=="0"){
                    $cont_unidad=" ";
                }
            }
            
            //CONT ARCH
            $sql2=" SELECT COUNT(*) AS cont_arch FROM alojam_estab_archivo ";
            $sql2.="WHERE id_estab='".$row['id_estab']."'";
            $run_sql2=mysql_query($sql2) or die ('ErrorSql > '.mysql_error ());                     
            if (mysql_num_rows($run_sql2)){                                        
                while($row2=mysql_fetch_array($run_sql2)){
                    $cont_arch=$row2['cont_arch'];
                }                    
                if ($cont_arch=="0"){
                    $cont_arch=" ";
                }
            }
            
            echo '
            <td>'.$row['id_estab'].'</td>
            <td>'.$row['nom_empr'].'</td>
            <td>'.$row['nom_estab'].'</td>
            <td>'.$row['nom_tipo_alojam'].'</td>
            <td>'.$row['estrella'].'</td>
            <td>'.$row['nom_desayuno'].'</td>
            <td>'.$restaurant.'</td>
            <td>'.$bar.'</td>
            <td>'.$quincho.'</td>
            <td>'.$piscina.'</td>
            <td>'.$row['nom_comuna'].'</td>
            <td>'.$row['coord_maps'].'</td>
            <td align="center">';
                echo '<input type="button" title="Configuracion Habitaciones" class="icono_habitacion" value="'.$cont_unidad.'" onclick="go_habit_unidad('."'".$row['id_estab']."'".');">&nbsp;'; 
                
                echo '<input type="button" title="Fotos Establecimiento/Exterior" class="icono_foto" value="'.$cont_arch.'" onclick="go_arch_estab('."'".$row['id_estab']."'".');">';
            echo '
            </td>
            </tr>';
        }     
    
        echo '
        <tr class="tabla_head"><th colspan="13" align="center"> Cantidad de registros: '.$n_row.'</th> </tr>';
    }else{
        echo '
        <tr class="tabla_datos1"><td colspan="13" ><center>No se encontraron resultados</center></td> </tr>';
    }
    echo '
    </table>';
}
############################################################################################################
} // FIN CASE CLASS
?>