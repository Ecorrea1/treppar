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

$actividad= new actividad();
switch($op){
    case'1':        
        $actividad->inicio_actividad();
        break;
        
    case'2':        
        $actividad->grabar_actividad();
        break;
        
    case'3':        
        $actividad->eliminar_actividad();
        break;
        
    case'4':
        $actividad->grilla_actividad();
        break;
}

class actividad{

###########################################################################################################
public function inicio_actividad(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
        
    echo '    
    <div id="titulo" class="titulo1">Actividades</div>';
    
    //FORMULARIO
    echo '
    <FORM id="form_actividad" method="post">
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="panel1" align="center">
    <tr height="40px">
        <td >ID Actividad:<br/>
            <input type="text" id="id_activ" size="12" class="txt3" onclick="limpia_form_actividad();" readonly/>
            <br/><label id="msn_id" class="msn_err"></label>
        </td>
        
        <td colspan="2" align="center" valign="center">
            <label id="msn_update" class="msn_err"></label>
        </td>
    </tr>
    
    <tr><td colspan="4"><hr size="1" color="#6E6E6E"></td></tr>
    
    <tr>
        <td>Empresa:<br/>';
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
        
        <td>Nombre Actividad: <label class="etq3">(Titulo)</label><br/>
            <input type="text" id="nom_activ" style="width:90%;" maxlength="100" class="txt1" onblur="valida_alfanum(this);"/>
            <br/><label id="msn_nom_activ" class="msn_err"></label>
        </td>
        
        <td colspan="2">Tipo Actividad:<br/>';
            $sql="SELECT * FROM man_tipo_actividad ";
            $sql.="ORDER BY nom_tipo_activ ASC";
            $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());
            
            echo '
            <select id="id_tipo_activ" class="txt1">
            <option value="@">--Todas--</option>';
            
            if (mysql_num_rows($run_sql)){
                while($row=mysql_fetch_array($run_sql)){
                    echo '<option value="'.$row['id_tipo_activ'].'">'.$row['nom_tipo_activ'].'</option>';
                }
            }
            echo '
            </select>
            <br/><label id="msn_tipo_activ" class="msn_err"></label>
        </td>
    </tr>
    
    <tr><td colspan="4"><hr size="1" color="#6E6E6E"></td></tr>
    
    <tr>
        <td colspan="4">
            Descripci&oacute;n:
            <input type="text" id="nchar1" value="500" size="3" style="background-color: transparent;border-width:0px;color:#DF0101;" disabled/>
            <br/>
            <textarea id="descripcion" rows="2" style="width:90%;" maxlength="500" class="txt1" onblur="valida_alfanum(this);" onkeypress="javascript:contchar1();" onkeyup="javascript:contchar1();" onmouseout="javascript:contchar1();"></textarea>
            <br/><label id="msn_descripcion" class="msn_err"></label>
        </td>
    </tr>
    
    <tr><td colspan="4"><hr size="1" color="#6E6E6E"></td></tr>
    
    <tr>
        <td colspan="2">
            Sugerencias: <label class="etq3">(Ej: Llevar agua, provisiones, protector solar, ropa nieve, etc)</label>
            <input type="text" id="nchar2" value="250" size="3" style="background-color: transparent;border-width:0px;color:#DF0101;" disabled/>
            <br/>
            <textarea id="sugerencia" rows="2" style="width:90%;" maxlength="250" class="txt1" onblur="valida_alfanum(this);" onkeypress="javascript:contchar2();" onkeyup="javascript:contchar2();" onmouseout="javascript:contchar2();"></textarea>
            <br/><label id="msn_sugerencia" class="msn_err"></label>
        </td>
     
        <td colspan="2">
            Requisitos: <label class="etq3">(Ej: No tener enfermedades cardiacas, etc)</label>
            <input type="text" id="nchar3" value="250" size="3" style="background-color: transparent;border-width:0px;color:#DF0101;" disabled/>
            <br/>
            <textarea id="requisito" rows="2" style="width:90%;" maxlength="250" class="txt1" onblur="valida_alfanum(this);" onkeypress="javascript:contchar3();" onkeyup="javascript:contchar3();" onmouseout="javascript:contchar3();"></textarea>
            <br/><label id="msn_requisito" class="msn_err"></label>
        </td>
    </tr>
    
    <tr><td colspan="4"><hr size="1" color="#6E6E6E"></td></tr>
    
    <tr>
        <td>Nivel Dificultad:<br/>
            <select id="dificultad" class="txt1"/>
                <option value="@">--Seleccione Dificultad--</option>
                <option value="1">Bajo</option>
                <option value="2">Medio</option>
                <option value="3">Alto</option>
            </select>
            <br><label id="msn_dificultad" class="msn_err"></label>
        </td>
        
        <td>Edad M&iacute;nima:<br/>   
            <input type="text" id="edad_minima" size="2" maxlength="2" class="txt1" onkeypress="return esNumero(event);"/>
            <br/><label id="msn_edad_min" class="msn_err"></label>
        </td>
        
        <td>Lugar Salida: <label class="etq3">(Ej: Punto de encuentro)</label><br/>
            <input type="text" id="lugar_salida" style="width:90%;" maxlength="100" class="txt1" onblur="valida_alfanum(this);"/>
            <br/><label id="msn_lugar_sal" class="msn_err"></label>
        </td>
        
        <td>Comuna:<br/>';
            $sql ="SELECT ";
            $sql.="man_comuna.id_comuna, ";
            $sql.="man_comuna.nom_comuna, ";
            $sql.="man_comuna.n_region, ";
            $sql.="man_comuna_region.nom_region ";
            $sql.="FROM man_comuna ";
            $sql.="INNER JOIN man_comuna_region ON man_comuna.n_region = man_comuna_region.n_region ";
            $sql.="ORDER BY orden_geo ASC, nom_comuna ASC";
            $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());
            $region_old="";
            
            echo '
            <select id="id_comuna" class="txt1">
            <option value="@">--Todas--</option>';
            
            if (mysql_num_rows($run_sql)){   
                while($row=mysql_fetch_array($run_sql)){
                    if ($row['n_region']!=$region_old){
                        //Cambia de region
                        echo '<option value="@" class="titulo_cmb">'.$row['n_region']." - ".$row['nom_region'].'</option>';
                        echo '<option value="'.$row['id_comuna'].'">'.$row['nom_comuna'].'</option>';
                        $region_old=$row['n_region'];
                    }else{
                        //La misma region
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
    
    <tr><td colspan="4"><hr size="1" color="#6E6E6E"></td></tr>
    
    <tr valign="top"> 
        <td>D&iacute;as:<br/>&nbsp;&nbsp;&nbsp;
            LU<input type="checkbox" id="lun"/>&nbsp;&#8212;&nbsp;
            MA<input type="checkbox" id="mar"/>&nbsp;&#8212;&nbsp;
            MI<input type="checkbox" id="mie"/>&nbsp;&#8212;&nbsp;
            JU<input type="checkbox" id="jue"/>&nbsp;&#8212;&nbsp;
            VI<input type="checkbox" id="vie"/>&nbsp;&#8212;&nbsp;
            <label style="color:#DF0101;">SA</label><input type="checkbox" id="sab"/>&nbsp;&#8212;&nbsp;
            <label style="color:#DF0101;">DO</label><input type="checkbox" id="dom"/>
            <br/><label id="msn_dias" class="msn_err"></label>
        </td>
        
        <td>Duraci&oacute;n actividad:<br/>        
            <input type="radio" name="duracion" value="hora" onclick="activar_duracion();" checked/>Horas:
            <select id="duracion_hh" class="txt1">';
            for ($x=0;$x<=24; $x++){
                echo '<option value="'.str_pad($x, 2, '0', STR_PAD_LEFT).'">'.str_pad($x, 2, '0', STR_PAD_LEFT).'</option>';
    		}
    	    echo'
    	    </select>
    
            <select id="duracion_mm" class="txt1">';
    		for ($x=0;$x<=59; $x++){          
                echo '<option value="'.str_pad($x, 2, '0', STR_PAD_LEFT).'">'.str_pad($x, 2, '0', STR_PAD_LEFT).'</option>';
    		}echo '
            </select>
            <br/><label id="msn_duracion_hr" class="msn_err"></label>
        </td>
        
        <td><br/>
            <input type="radio" name="duracion" value="dia" onclick="activar_duracion();"/>D&iacute;as:
            <input type="text" id="duracion_dia" class="txt1" size="2" value="0" maxlength="2" style="visibility:hidden;" onkeypress="return esNumero(event);"/>
            <br/><label id="msn_duracion_dia" class="msn_err"></label>

        </td>
        
        <td>Hora Inicio:<br/>
            <select id="hh_ini" class="txt1">';
            for ($x=0;$x<=24; $x++){
                echo '<option value="'.str_pad($x, 2, '0', STR_PAD_LEFT).'">'.str_pad($x, 2, '0', STR_PAD_LEFT).'</option>';
    		}
    	    echo'
    	    </select>:
    
            <select id="mm_ini" class="txt1">';
    		for ($x=0;$x<=59; $x++){          
                echo '<option value="'.str_pad($x, 2, '0', STR_PAD_LEFT).'">'.str_pad($x, 2, '0', STR_PAD_LEFT).'</option>';
    		}
    	    echo'
            </select>
            <br/><label id="msn_hr_inicio" class="msn_err"></label>
        </td>
        </td>
    </tr>

    <tr><td colspan="4"><hr size="1" color="#6E6E6E"></td></tr>
    
    <tr>
        <td colspan="2">Precio Adulto:<br/>
            <input type="text" id="precio_adultojoven" size="8" maxlength="8" class="txt1"  placeholder="$CPL" onkeypress="return esNumero(event);"/>
            &#8212;
           <label class="etq3">Dolar:</label>
             <input type="text" id="dolar_adultojoven" size="8" maxlength="8" class="txt1"  placeholder="$US" onkeypress="return esNumero(event);"/>
            &#8212;
            <label class="etq3">% Dscto:</label>
            <input type="text" id="dscto_adultojoven" size="2" maxlength="2" value="0" class="txt1" placeholder="%" onkeypress="return esNumero(event);"/>
            <br><label id="msn_padultojoven" class="msn_err"></label>
        </td>

        
        <td colspan="2">Precio Ni&ntilde;o:<br/>
            <input type="text" id="precio_nino" size="8" maxlength="8" class="txt1" placeholder="$CLP" onkeypress="return esNumero(event);"/>
            &#8212;
             <label class="etq3">Dolar:</label>
             <input type="text" id="dolar_nino" size="8" maxlength="8" class="txt1"  placeholder="$US" onkeypress="return esNumero(event);"/>
            &#8212;
            <label class="etq3">% Dscto:</label>
            <input type="text" id="dscto_nino" size="2" maxlength="2" value="0" class="txt1" placeholder="%" onkeypress="return esNumero(event);"/>
            <br><label id="msn_pnino" class="msn_err"></label>
        </td>
        
        <tr><td colspan="4"><hr size="1" color="#6E6E6E"></td></tr>

        <td colspan="2">Precio Adulto Mayor:<br/>
            <input type="text" id="precio_adultomayor" size="8" maxlength="8" class="txt1" placeholder="$CLP" onkeypress="return esNumero(event);"/>
            &#8212;

              <label class="etq3">Dolar:</label>
             <input type="text" id="dolar_adultomayor" size="8" maxlength="8" class="txt1"  placeholder="$US" onkeypress="return esNumero(event);"/>
            &#8212;

            <label class="etq3">% Dscto:</label>
            <input type="text" id="dscto_adultomayor" size="2" maxlength="2" value="0" class="txt1" placeholder="%" onkeypress="return esNumero(event);"/>
            <br><label id="msn_padultomayor" class="msn_err"></label>
        </td>

        <td colspan="1">Precio Grupo:<br/>
            <input type="text" id="precio_grupo" size="8" maxlength="8" class="txt1" placeholder="$CLP" onkeypress="return esNumero(event);"/>
            &#8212;

              <label class="etq3">Dolar:</label>
             <input type="text" id="dolar_grupo" size="8" maxlength="8" class="txt1"  placeholder="$US" onkeypress="return esNumero(event);"/>
            &#8212;
            <label class="etq3">% Dscto:</label>
            <input type="text" id="dscto_grupo" size="2" maxlength="2" value="0" class="txt1" placeholder="%" onkeypress="return esNumero(event);"/>
            <br><label id="msn_pgrupo" class="msn_err"></label>
        </td>
                
        <td>Personas: <br/>   
            <input type="text" id="grupo" size="2" maxlength="2" class="txt1" onkeypress="return esNumero(event);"/> <label class="etq3">(Por Grupo)</label>
            <br/><label id="msn_grupo" class="msn_err"></label>
        </td>

    </tr>
    
    <tr><td colspan="4"><hr size="1" color="#6E6E6E"></td></tr>';

    //BOTONES
    echo '
    <tr height="40px">
        <td colspan="4" align="center">
            <input type="button" title="Grabar" class="bt_grabar" onclick="grabar_actividad();">&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" title="Eliminar" class="bt_eliminar" onclick="eliminar_actividad();">&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" title="Buscar" class="bt_buscar" onclick="grilla_actividad('."'buscar'".');">&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" title="Copiar Datos" class="bt_exportar" onclick="copy_grilla_actividad();">&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" title="Limpiar" class="bt_limpiar" onclick="limpia_form_actividad();">  
            <input type="button" name="bt_reload" onclick="grilla_actividad('."'reload'".');" style="display:none;">
        </td>
    </tr>
    </table>';
    
    //GRILLA
    echo '
    <DIV id="grilla_actividad">';
        //Cabecera Grilla
        echo '
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr class="tabla_head">             
            <td width="5%">ID</td>
            <td width="10%">Empresa</td>
            <td width="15%">Nombre Actividad</td>
            <td width="15%">Tipo Actividad</td>
            <td width="20%">Descripci&oacute;n</td>
            <td width="15%">Sugerencias</td>
            <td width="10%">Comuna</td>
            <td width="10%" align="center">Opc</td>
        </tr>';
    
        //Datos Grilla        
        $sql ="SELECT ";
        $sql.="actividad.id_activ, ";
        $sql.="actividad.rut_empr, ";
        $sql.="man_usuario.nombre, ";
        $sql.="actividad.nom_activ, ";
        $sql.="actividad.id_tipo_activ, ";
        $sql.="man_tipo_actividad.nom_tipo_activ, ";
        $sql.="actividad.descripcion, ";
        $sql.="actividad.sugerencia, ";
        $sql.="actividad.requisito, ";
        $sql.="actividad.dificultad, ";
        $sql.="actividad.edad_minima, ";
        $sql.="actividad.lugar_salida, ";
        $sql.="actividad.id_comuna, ";
        $sql.="man_comuna.nom_comuna, ";
        $sql.="actividad.lun, ";
        $sql.="actividad.mar, ";
        $sql.="actividad.mie, ";
        $sql.="actividad.jue, ";
        $sql.="actividad.vie, ";
        $sql.="actividad.sab, ";
        $sql.="actividad.dom, ";
        $sql.="actividad.duracion_hr, ";
        $sql.="actividad.duracion_dia, ";
        $sql.="actividad.hr_inicio, ";
        $sql.="actividad.precio_adultojoven, ";
        $sql.="actividad.precio_nino, ";
        $sql.="actividad.precio_adultomayor, ";
        $sql.="actividad.precio_grupo, ";
        $sql.="actividad.dolar_adultojoven, ";
        $sql.="actividad.dolar_nino, ";
        $sql.="actividad.dolar_adultomayor, ";
        $sql.="actividad.dolar_grupo, ";
        $sql.="actividad.dscto_adultojoven, ";
        $sql.="actividad.dscto_nino, ";
        $sql.="actividad.dscto_adultomayor, ";
        $sql.="actividad.dscto_grupo, ";
        $sql.="actividad.grupo ";
        $sql.="FROM actividad ";
        $sql.="INNER JOIN man_usuario ON actividad.rut_empr = man_usuario.rut ";
        $sql.="INNER JOIN man_tipo_actividad ON actividad.id_tipo_activ = man_tipo_actividad.id_tipo_activ ";
        $sql.="INNER JOIN man_comuna ON actividad.id_comuna = man_comuna.id_comuna ";
                
        if ($_SESSION['log_tipo']=="Empresa"){
            $sql.="WHERE rut='".$_SESSION['log_rut']."'";
        }
      
        $sql.=" ORDER BY id_activ DESC";
        $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());                 
       
        if (mysql_num_rows($run_sql)){
            $n_row=0;
            $color_fila="tabla_datos1";
            while($row=mysql_fetch_array($run_sql)){          
                $n_row++;
                                        
                //Seleccion para este formulario                
                $seleccion ="'".$row['id_activ']."',";
                $seleccion.="'".$row['rut_empr']."',";            
                $seleccion.="'".$row['nom_activ']."',";
                $seleccion.="'".$row['id_tipo_activ']."',";            
                $seleccion.="'".$row['descripcion']."',";
                $seleccion.="'".$row['sugerencia']."',";
                $seleccion.="'".$row['requisito']."',";
                $seleccion.="'".$row['dificultad']."',";
                $seleccion.="'".$row['edad_minima']."',";
                $seleccion.="'".$row['lugar_salida']."',";
                $seleccion.="'".$row['id_comuna']."',";           
                $seleccion.="'".$row['lun']."',";
                $seleccion.="'".$row['mar']."',";
                $seleccion.="'".$row['mie']."',";
                $seleccion.="'".$row['jue']."',";
                $seleccion.="'".$row['vie']."',";
                $seleccion.="'".$row['sab']."',";
                $seleccion.="'".$row['dom']."',";          
                $seleccion.="'".date('H',strtotime($row['duracion_hr']))."',";
                $seleccion.="'".date('i',strtotime($row['duracion_hr']))."',";
                $seleccion.="'".$row['duracion_dia']."',";
                $seleccion.="'".date('H',strtotime($row['hr_inicio']))."',";
                $seleccion.="'".date('i',strtotime($row['hr_inicio']))."',";
                $seleccion.="'".$row['precio_adultojoven']."',";      
                $seleccion.="'".$row['precio_nino']."',";       
                $seleccion.="'".$row['precio_adultomayor']."',";
                $seleccion.="'".$row['precio_grupo']."',";
                $seleccion.="'".$row['dolar_adultojoven']."',";      
                $seleccion.="'".$row['dolar_nino']."',";       
                $seleccion.="'".$row['dolar_adultomayor']."',";
                $seleccion.="'".$row['dolar_grupo']."',";
                $seleccion.="'".$row['dscto_adultojoven']."',";
                $seleccion.="'".$row['dscto_nino']."',";
                $seleccion.="'".$row['dscto_adultomayor']."',";
                $seleccion.="'".$row['dscto_grupo']."',";
                $seleccion.="'".$row['grupo']."'";
                
                
                //CONT HORARIOS
                $sql2=" SELECT COUNT(*) AS cont_hr FROM actividad_horario ";
                $sql2.="WHERE id_activ='".$row['id_activ']."'";
                $run_sql2=mysql_query($sql2) or die ('ErrorSql > '.mysql_error ());                     
                if (mysql_num_rows($run_sql2)){                                        
                    while($row2=mysql_fetch_array($run_sql2)){
                        $cont_hr=$row2['cont_hr'];
                    }                    
                    if ($cont_hr=="0"){
                        $cont_hr=" ";
                    }
                }
                
                //CONT ARCH
                $sql2=" SELECT COUNT(*) AS cont_arch FROM actividad_archivo ";
                $sql2.="WHERE id_activ='".$row['id_activ']."'";
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
                <tr class="'.$color_fila.'" style="cursor:pointer;" valign="top" onclick="selecc_actividad('.$seleccion.');" >   
                <td>'.$row['id_activ'].'</td>
                <td>'.$row['nombre'].'</td>
                <td>'.$row['nom_activ'].'</td>
                <td>'.$row['nom_tipo_activ'].'</td>
                <td>'.$row['descripcion'].'</td>
                <td>'.$row['sugerencia'].'</td>
                <td>'.$row['nom_comuna'].'</td>
               
                <td align="center">
                    <input type="button" class="icono_ver_detalle" id="btver_'.$row['id_activ'].'" value=" + " onclick="javascript:ver_detalle_actividad('."'".$row['id_activ']."'".');">                    
                    &nbsp;
                    <input type="button" class="icono_horario" value="'.$cont_hr.'" onclick="go_hrs_activ('."'".$row['id_activ']."'".');">
                    &nbsp; 
                    <input type="button" class="icono_foto" value="'.$cont_arch.'" onclick="go_arch_activ('."'".$row['id_activ']."'".');">
                </td>
            </tr>
            
            <tr class="'.$color_fila.'">
                <td colspan="8" style="border-bottom:2px solid #000;">
                    <div id="div_detalle_'.$row['id_activ'].'" style="display:none;">';
                        
                        //Datos2
                        echo '
                        <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center" style="border:1px solid;">
                        <tr class="'.$color_fila.'">                   
                            <td width="23%">                <b><u>  Requisitos              </u></b>    </td>
                            <td width="10%" align="center"> <b><u>  Nivel Dificultad        </u></b>    </td>
                            <td width="10%" align="center"> <b><u>  Edad M&iacute;nima      </u></b>    </td>
                            <td width="23%" align="center"> <b><u>  Lugar Salida            </u></b>    </td>                            
                            <td width="2%">                 <b><u>  Lu                      </u></b>    </td>
                            <td width="2%">                 <b><u>  Ma                      </u></b>    </td>
                            <td width="2%">                 <b><u>  Mi                      </u></b>    </td>
                            <td width="2%">                 <b><u>  Ju                      </u></b>    </td>
                            <td width="2%">                 <b><u>  Vi                      </u></b>    </td>
                            <td width="2%">                 <b><u>  Sa                      </u></b>    </td>
                            <td width="2%">                 <b><u>  Do                      </u></b>    </td>
                            <td width="10%" align="center"> <b><u>  Duraci&oacute;n Activ.   </u></b>    </td>
                            <td width="10%" align="center"> <b><u>  Hora Inicio              </u></b>    </td>                            
                        </tr>
                        
                        <tr class="'.$color_fila.'" valign="top">                           
                            <td>'.$row['requisito'].'</td>                            
                            <td align="center">';
                                if ($row['dificultad']==1){
                                    echo "Bajo";
                                }elseif ($row['dificultad']==2){
                                    echo "Medio";
                                }elseif ($row['dificultad']==3){
                                    echo "Alto";
                                }
                            echo '
                            </td>
                            
                            <td align="center">'.$row['edad_minima'].'</td>
                            <td align="center">'.$row['lugar_salida'].'</td>';
                            
                            if ($row['lun']=="1"){ echo '<td style="color:green">&#10003;</td>';}else{ echo '<td style="color:red">&#10005;</td>'; }
                            if ($row['mar']=="1"){ echo '<td style="color:green">&#10003;</td>';}else{ echo '<td style="color:red">&#10005;</td>'; }
                            if ($row['mie']=="1"){ echo '<td style="color:green">&#10003;</td>';}else{ echo '<td style="color:red">&#10005;</td>'; }
                            if ($row['jue']=="1"){ echo '<td style="color:green">&#10003;</td>';}else{ echo '<td style="color:red">&#10005;</td>'; }
                            if ($row['vie']=="1"){ echo '<td style="color:green">&#10003;</td>';}else{ echo '<td style="color:red">&#10005;</td>'; }
                            if ($row['sab']=="1"){ echo '<td style="color:green">&#10003;</td>';}else{ echo '<td style="color:red">&#10005;</td>'; }
                            if ($row['dom']=="1"){ echo '<td style="color:green">&#10003;</td>';}else{ echo '<td style="color:red">&#10005;</td>'; }
                            
                            ##DURACION##########################################################################  
                            if ($row['duracion_hr']!="00:00:00"){
                                
                                $h = (int) ( date('H',strtotime($row['duracion_hr'])) );
                                $i = (int) ( date('i',strtotime($row['duracion_hr'])) );
                                
                                if ($h==0){
                                    $duracion = $i.' Min';
                                    
                                }else{
                                    
                                    if ($i==0){
                                        $duracion = $h.' Hrs';
                                    }else{
                                        $duracion = $h.":".$i.' Hrs';
                                    }                        
                                }
                                
                            }else if ($row['duracion_dia']>0){
                                if ($row['duracion_dia']==1){
                                    $duracion = $row['duracion_dia'].' D&iacute;a';
                                }else{
                                    $duracion = $row['duracion_dia'].' D&iacute;as';
                                }
                                
                            }else{
                                $duracion = ' - ';
                            }
                            echo '                            
                            <td align="center">'.$duracion.'</td>';
                            
                            ####################################################################################
                            
                            echo '                            
                            <td align="center">'.date('H:i',strtotime($row['hr_inicio'])).'</td>
                        </tr>
                        </table><br/>';
                        
                        //Datos3                        
                        $pfinal_adultojoven = $row['precio_adultojoven']-( ($row['precio_adultojoven']*$row['dscto_adultojoven']/100) );
                        $pfinal_nino        = $row['precio_nino']-( ($row['precio_nino']*$row['dscto_nino']/100) );
                        $pfinal_adultomayor = $row['precio_adultomayor']-( ($row['precio_adultomayor']*$row['dscto_adultomayor']/100) );
                        $pfinal_grupo       = $row['precio_grupo']-( ($row['precio_grupo']*$row['dscto_grupo']/100) );

                        echo '
                        <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center"  style="border:1px solid;">
                        <tr class="'.$color_fila.'">
                            <th colspan="4" style="border-right:1px solid; border-bottom:1px solid;">    Adulto         </th>
                            <th colspan="4" style="border-right:1px solid; border-bottom:1px solid;">    Ni&ntilde;o    </th>
                            <th colspan="4" style="border-right:1px solid; border-bottom:1px solid;">    Adulto Mayor   </th>
                            <th colspan="5" style="border-bottom:1px solid;">                            Grupo          </th>                        
                        </tr>
                        
                        <tr class="'.$color_fila.'">                      
                            <th width="6%"><u>   Precio </u>    </th>
                            <th width="6%"><u>   Dolar  </u>    </th>
                            <th width="6%"><u>   Dscto  </u>    </th>
                            <th width="6%" style="border-right:1px solid;"><u>   Precio Final </u>    </th>
                            
                            <th width="6%"><u>   Precio </u>    </td>
                            <th width="6%"><u>   Dolar  </u>    </th>
                            <th width="6%"><u>   Dscto. </u>    </td>
                            <th width="6%" style="border-right:1px solid;"><u>   Precio Final </u>    </th>
                            
                            <th width="6%"><u>   Precio </u>    </td>
                            <th width="6%"><u>   Dolar  </u>    </th>
                            <th width="6%"><u>   Dscto. </u>    </td>
                            <th width="6%" style="border-right:1px solid;"><u>   Precio Final </u>    </th>
                            
                            <th width="6%"><u>   Precio </u>    </td>
                            <th width="6%"><u>   Dolar  </u>    </th>
                            <th width="6%"><u>   Dscto. </u>    </td>
                            <th width="6%"><u>   Precio Final </u>    </th>
                            <th width="4%"><u>   N&deg; Pers </u>    </th>
                            
                        </tr>
                        
                        <tr class="'.$color_fila.'">
                            <th>$'.number_format($row['precio_adultojoven'], 0, ",", ".").'</th>
                            <th>$'.number_format($row['dolar_adultojoven'], 0, ",", ".").'</th>
                            <th>'.number_format($row['dscto_adultojoven'], 0, ",", ".").'%</th>
                            <th style="border-right:1px solid;">$'.number_format($pfinal_adultojoven, 0, ",", ".").'</th>
                            
                            <th>$'.number_format($row['precio_nino'], 0, ",", ".").'</th>
                            <th>$'.number_format($row['dolar_nino'], 0, ",", ".").'</th>
                            <th>'.number_format($row['dscto_nino'], 0, ",", ".").'%</th>
                            <th style="border-right:1px solid;">$'.number_format($pfinal_nino, 0, ",", ".").'</th>
                            
                            <th>$'.number_format($row['precio_adultomayor'], 0, ",", ".").'</th>
                            <th>$'.number_format($row['dolar_adultomayor'], 0, ",", ".").'</th>
                            <th>'.number_format($row['dscto_adultomayor'], 0, ",", ".").'%</th>
                            <th style="border-right:1px solid;">$'.number_format($pfinal_adultomayor, 0, ",", ".").'</th>
                            
                            <th>$'.number_format($row['precio_grupo'], 0, ",", ".").'</th>
                            <th>$'.number_format($row['dolar_grupo'], 0, ",", ".").'</th>
                            <th>'.number_format($row['dscto_grupo'], 0, ",", ".").'%</th>
                            <th>$'.number_format($pfinal_grupo, 0, ",", ".").'</th>
                            <th>'.$row['grupo'].'</th>
                        </tr>
                        </table>
                        <br/>
                
                    </div>
                </td>     
            </tr>';
            
            if ($color_fila=="tabla_datos1"){
                $color_fila="tabla_datos2";                                       
            }else{
                $color_fila="tabla_datos1";                                                   
            }
        }     
            echo '
            <tr class="tabla_head"><th colspan="8" align="center">Cantidad de registros: '.$n_row.'</th> </tr>';
                                
    }else{ 
        
            echo '
            <tr class="tabla_datos1"><td colspan="8" ><center>No se encontraron resultados</center></td> </tr>';
    }
   echo '
   </table>';
       
    echo '   
    </DIV>
    <div id="salida"></div> 
    </FORM>';
}

public function grabar_actividad(){
    IF (isset($_SESSION['log_rut']) AND isset($_SESSION['log_nom']) AND isset($_SESSION['log_tipo'])){
        echo '<input type="hidden" id="sesion" value="ok">';
    ###########################################################################################
        
        $cnx=conexion();
        date_default_timezone_set("Chile/Continental");
        
        $id_activ       = isset($_GET['id_activ'])?$_GET['id_activ']:null;
        $rut_empr       = isset($_GET['rut_empr'])?$_GET['rut_empr']:null;
        $nom_activ      = guardian($_GET['nom_activ']);
        $id_tipo_activ  = isset($_GET['id_tipo_activ'])?$_GET['id_tipo_activ']:null;
        $descripcion    = guardian($_GET['descripcion']);
        $sugerencia     = guardian($_GET['sugerencia']);
        $requisito      = guardian($_GET['requisito']);
        $dificultad     = isset($_GET['dificultad'])?$_GET['dificultad']:null;
        $edad_minima    = isset($_GET['edad_minima'])?$_GET['edad_minima']:null;
        $lugar_salida   = guardian($_GET['lugar_salida']);
        $id_comuna      = isset($_GET['id_comuna'])?$_GET['id_comuna']:null;
        $lun            = isset($_GET['lun'])?$_GET['lun']:null;
        $mar            = isset($_GET['mar'])?$_GET['mar']:null;
        $mie            = isset($_GET['mie'])?$_GET['mie']:null;
        $jue            = isset($_GET['jue'])?$_GET['jue']:null;
        $vie            = isset($_GET['vie'])?$_GET['vie']:null;
        $sab            = isset($_GET['sab'])?$_GET['sab']:null;
        $dom            = isset($_GET['dom'])?$_GET['dom']:null;
        $duracion_hr    = isset($_GET['duracion_hr'])?$_GET['duracion_hr']:null;
        $duracion_dia   = isset($_GET['duracion_dia'])?$_GET['duracion_dia']:null;
        $hr_inicio      = isset($_GET['hr_inicio'])?$_GET['hr_inicio']:null;
        
        $precio_adultojoven = isset($_GET['precio_adultojoven'])?$_GET['precio_adultojoven']:null;
        $precio_nino        = isset($_GET['precio_nino'])?$_GET['precio_nino']:null;
        $precio_adultomayor = isset($_GET['precio_adultomayor'])?$_GET['precio_adultomayor']:null;
        $precio_grupo       = isset($_GET['precio_grupo'])?$_GET['precio_grupo']:null;
    
        $dolar_adultojoven  = isset($_GET['dolar_adultojoven'])?$_GET['dolar_adultojoven']:null;
        $dolar_nino         = isset($_GET['dolar_nino'])?$_GET['dolar_nino']:null;
        $dolar_adultomayor  = isset($_GET['dolar_adultomayor'])?$_GET['dolar_adultomayor']:null;
        $dolar_grupo        = isset($_GET['dolar_grupo'])?$_GET['dolar_grupo']:null;
    
        $dscto_adultojoven  = isset($_GET['dscto_adultojoven'])?$_GET['dscto_adultojoven']:null;
        $dscto_nino         = isset($_GET['dscto_nino'])?$_GET['dscto_nino']:null;
        $dscto_adultomayor  = isset($_GET['dscto_adultomayor'])?$_GET['dscto_adultomayor']:null;
        $dscto_grupo        = isset($_GET['dscto_grupo'])?$_GET['dscto_grupo']:null;
        
        $grupo              = isset($_GET['grupo'])?$_GET['grupo']:null;
        
        $sql="SELECT * FROM actividad WHERE id_activ='".$id_activ."'";
        $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
           	
        if (mysql_num_rows($run_sql)){
            $sql = "UPDATE actividad SET ";
            $sql.= "rut_empr='".$rut_empr."',";  
            $sql.= "nom_activ='".$nom_activ."',";
            $sql.= "id_tipo_activ='".$id_tipo_activ."',";
            $sql.= "descripcion='".$descripcion."',";
            $sql.= "sugerencia='".$sugerencia."',";
            $sql.= "requisito='".$requisito."',";
            $sql.= "dificultad='".$dificultad."',";
            $sql.= "edad_minima='".$edad_minima."',";
            $sql.= "lugar_salida='".$lugar_salida."',";
            $sql.= "id_comuna='".$id_comuna."',";
            $sql.= "lun='".$lun."',";
            $sql.= "mar='".$mar."',";
            $sql.= "mie='".$mie."',";
            $sql.= "jue='".$jue."',";
            $sql.= "vie='".$vie."',";
            $sql.= "sab='".$sab."',";
            $sql.= "dom='".$dom."',";
            $sql.= "duracion_hr='".$duracion_hr."',";
            $sql.= "duracion_dia='".$duracion_dia."',";
            $sql.= "hr_inicio='".$hr_inicio."',";  
            $sql.= "precio_adultojoven='".$precio_adultojoven."',";
            $sql.= "precio_nino='".$precio_nino."',";
            $sql.= "precio_adultomayor='".$precio_adultomayor."',";
            $sql.= "precio_grupo='".$precio_grupo."',";
            $sql.= "dolar_adultojoven='".$dolar_adultojoven."',";
            $sql.= "dolar_nino='".$dolar_nino."',";
            $sql.= "dolar_adultomayor='".$dolar_adultomayor."',";
            $sql.= "dolar_grupo='".$dolar_grupo."',";
            $sql.= "dscto_adultojoven='".$dscto_adultojoven."',";
            $sql.= "dscto_nino='".$dscto_nino."',";
            $sql.= "dscto_adultomayor='".$dscto_adultomayor."',";
            $sql.= "dscto_grupo='".$dscto_grupo."',";
            $sql.= "grupo='".$grupo."',";
            $sql.= "reg_rut='".$_SESSION['log_rut']."',";
            $sql.= "reg_fecha='".date('Y-m-d H:i:s')."' ";
        	$sql.= "WHERE id_activ='".$id_activ."'";
            $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
            
            echo '<input type="hidden" id="eco_grabar" value="update_ok"/>';
             
        }else{
            
            $sql="SELECT MAX(id_activ) AS id_max FROM actividad";
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
            
            $sql="INSERT INTO actividad(";
                $sql.="id_activ,";
                $sql.="rut_empr,";
                $sql.="nom_activ,";
                $sql.="id_tipo_activ,";
                $sql.="descripcion,";
                $sql.="sugerencia,";
                $sql.="requisito,";
                $sql.="dificultad,";
                $sql.="edad_minima,";
                $sql.="lugar_salida,";
                $sql.="id_comuna,";
                $sql.="lun,";
                $sql.="mar,";
                $sql.="mie,";
                $sql.="jue,";
                $sql.="vie,";
                $sql.="sab,";
                $sql.="dom,";
                $sql.="duracion_hr,";
                $sql.="duracion_dia,";
                $sql.="hr_inicio,";
                
                $sql.= "precio_adultojoven,";
                $sql.= "precio_nino,";
                $sql.= "precio_adultomayor,";
                $sql.= "precio_grupo,";
    
                $sql.="dolar_adultojoven, ";
                $sql.="dolar_nino,";
                $sql.="dolar_adultomayor, ";
                $sql.="dolar_grupo, ";
    
                $sql.= "dscto_adultojoven,";
                $sql.= "dscto_nino,";
                $sql.= "dscto_adultomayor,";
                $sql.= "dscto_grupo,";
                $sql.= "grupo,";
            
                $sql.="reg_rut,";
                $sql.="reg_fecha) ";
            $sql.="VALUES (";
                $sql.="'".$new_id."',";
                $sql.="'".$rut_empr."',";         
                $sql.="'".$nom_activ."',";
                $sql.="'".$id_tipo_activ."',";
                $sql.="'".$descripcion."',";
                $sql.="'".$sugerencia."',";
                $sql.="'".$requisito."',";        
                $sql.="'".$dificultad."',";   
                $sql.="'".$edad_minima."',";
                $sql.="'".$lugar_salida."',";
                $sql.="'".$id_comuna."',";       
                $sql.="'".$lun."',";
                $sql.="'".$mar."',";
                $sql.="'".$mie."',";
                $sql.="'".$jue."',";
                $sql.="'".$vie."',";
                $sql.="'".$sab."',";
                $sql.="'".$dom."',";
                $sql.="'".$duracion_hr."',";
                $sql.="'".$duracion_dia."',";
                $sql.="'".$hr_inicio."',";      
                $sql.="'".$precio_adultojoven."',";
                $sql.="'".$precio_nino."',";
                $sql.="'".$precio_adultomayor."',";
                $sql.="'".$precio_grupo."',";
                $sql.="'".$dolar_adultojoven."',";
                $sql.="'".$dolar_nino."',";
                $sql.="'".$dolar_adultomayor."',";
                $sql.="'".$dolar_grupo."',";
                $sql.="'".$dscto_adultojoven."',";
                $sql.="'".$dscto_nino."',";
                $sql.="'".$dscto_adultomayor."',";
                $sql.="'".$dscto_grupo."',";  
                $sql.="'".$grupo."',"; 
                $sql.="'".$_SESSION['log_rut']."',";
                $sql.="'".date('Y-m-d H:i:s')."')";
            $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
              
            echo '<input type="hidden" id="eco_grabar" value="insert_ok"/>';
            echo '<input type="hidden" id="eco_id" value="'.$new_id.'"/>';
        }
        
    ###########################################################################################    
    }ELSE{        
        echo '<input type="hidden" id="sesion" value="cerrar">';
    }
}

public function eliminar_actividad(){
    IF (isset($_SESSION['log_rut']) AND isset($_SESSION['log_nom']) AND isset($_SESSION['log_tipo'])){
        echo '<input type="hidden" id="sesion" value="ok">';
    ###########################################################################################
    
        $cnx=conexion();
        date_default_timezone_set("Chile/Continental");
            
        $id_activ    = isset($_GET['id_activ'])?$_GET['id_activ']:null;
        $nom_activ   = guardian($_GET['nom_activ']);
      
        $sql ="SELECT * FROM actividad WHERE id_activ='".$id_activ."'";
        $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
        
        if (mysql_num_rows($run_sql)){
            
        	$sql ="DELETE FROM actividad ";
            $sql.="WHERE id_activ='".$id_activ."'";
            
            $run_sql=mysql_query($sql) or die ('<center><label class="msn_err">No se puede eliminar porque hay datos vinculados<br/> 
                                                ID Actividad: '.$id_activ.' &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp; 
                                                Nombre: '.$nom_activ.'</b></label></center>');
                                                     
            echo '<input type="hidden" id="eco_eliminar" value="delete_ok"/>';            
        }else{
            echo '<input type="hidden" id="eco_eliminar" value="err_delete"/>';
        }
        
    ###########################################################################################
    }ELSE{        
        echo '<input type="hidden" id="sesion" value="cerrar">';
    }
}

public function grilla_actividad(){    
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    $accion=isset($_GET['accion'])?$_GET['accion']:null;
    
    //Cabecera Grilla
    echo '
    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr class="tabla_head">             
        <td width="5%">ID</td>
        <td width="10%">Empresa</td>
        <td width="15%">Nombre Actividad</td>
        <td width="15%">Tipo Actividad</td>
        <td width="20%">Descripci&oacute;n</td>
        <td width="15%">Sugerencias</td>
        <td width="10%">Comuna</td>
        <td width="10%" align="center">Opc</td>
    </tr>';

    //Datos Grilla
    $sql ="SELECT ";
    $sql.="actividad.id_activ, ";
    $sql.="actividad.rut_empr, ";
    $sql.="man_usuario.nombre, ";
    $sql.="actividad.nom_activ, ";
    $sql.="actividad.id_tipo_activ, ";
    $sql.="man_tipo_actividad.nom_tipo_activ, ";
    $sql.="actividad.descripcion, ";
    $sql.="actividad.sugerencia, ";
    $sql.="actividad.requisito, ";
    $sql.="actividad.dificultad, ";
    $sql.="actividad.edad_minima, ";
    $sql.="actividad.lugar_salida, ";
    $sql.="actividad.id_comuna, ";
    $sql.="man_comuna.nom_comuna, ";
    $sql.="actividad.lun, ";
    $sql.="actividad.mar, ";
    $sql.="actividad.mie, ";
    $sql.="actividad.jue, ";
    $sql.="actividad.vie, ";
    $sql.="actividad.sab, ";
    $sql.="actividad.dom, ";
    $sql.="actividad.duracion_hr, ";
    $sql.="actividad.duracion_dia, ";
    $sql.="actividad.hr_inicio, ";
    $sql.="actividad.precio_adultojoven, ";
    $sql.="actividad.precio_nino, ";
    $sql.="actividad.precio_adultomayor, ";
    $sql.="actividad.precio_grupo, ";
    $sql.="actividad.dolar_adultojoven, ";
    $sql.="actividad.dolar_nino, ";
    $sql.="actividad.dolar_adultomayor, ";
    $sql.="actividad.dolar_grupo, ";
    $sql.="actividad.dscto_adultojoven, ";
    $sql.="actividad.dscto_nino, ";
    $sql.="actividad.dscto_adultomayor, ";
    $sql.="actividad.dscto_grupo, ";
    $sql.="actividad.grupo ";
    $sql.="FROM actividad ";
    $sql.="INNER JOIN man_usuario ON actividad.rut_empr = man_usuario.rut ";
    $sql.="INNER JOIN man_tipo_actividad ON actividad.id_tipo_activ = man_tipo_actividad.id_tipo_activ ";
    $sql.="INNER JOIN man_comuna ON actividad.id_comuna = man_comuna.id_comuna ";
    
    if ($accion=="buscar"){
        $id_activ       = isset($_GET['id_activ'])?$_GET['id_activ']:null;
        $rut_empr       = isset($_GET['rut_empr'])?$_GET['rut_empr']:null;
        $nom_activ      = guardian($_GET['nom_activ']);
        $id_tipo_activ  = isset($_GET['id_tipo_activ'])?$_GET['id_tipo_activ']:null;
        $descripcion    = guardian($_GET['descripcion']);
        $sugerencia     = guardian($_GET['sugerencia']);
        $requisito      = guardian($_GET['requisito']);
        $dificultad     = isset($_GET['dificultad'])?$_GET['dificultad']:null;
        $edad_minima    = isset($_GET['edad_minima'])?$_GET['edad_minima']:null;
        $lugar_salida   = guardian($_GET['lugar_salida']);
        $id_comuna      = isset($_GET['id_comuna'])?$_GET['id_comuna']:null;
        
        $filtro="";
            
        if ($id_activ!=""){
               $filtro=" id_activ = '".$id_activ."'";
        }
        
        if ($rut_empr!="@"){
        	if ($filtro!=""){
        		$filtro.=" AND";
        	}
        	$filtro.=" rut_empr = '".$rut_empr."'";
        }
        
        if ($nom_activ!=""){
        	if ($filtro!=""){
        		$filtro.=" AND";
        	}
        	$filtro.=" nom_activ LIKE '%".$nom_activ."%'";	
        }
        
        if ($id_tipo_activ!="@"){
        	if ($filtro!=""){
        		$filtro.=" AND";
        	}
        	$filtro.=" actividad.id_tipo_activ = '".$id_tipo_activ."'";
        }
        
        if ($descripcion!=""){
        	if ($filtro!=""){
        		$filtro.=" AND";
        	}
            $filtro.=" descripcion LIKE '%".$descripcion."%'";
        }
        
        if ($sugerencia!=""){
        	if ($filtro!=""){
        		$filtro.=" AND";
        	}
            $filtro.=" sugerencia LIKE '%".$sugerencia."%'";
        }
        
        if ($requisito!=""){
        	if ($filtro!=""){
        		$filtro.=" AND";
        	}
            $filtro.=" requisito LIKE '%".$requisito."%'";
        }
        
        if ($dificultad!="@"){
        	if ($filtro!=""){
        		$filtro.=" AND";
        	}
        	$filtro.=" dificultad = '".$dificultad."'";
        }
        
        if ($edad_minima!=""){
        	if ($filtro!=""){
        		$filtro.=" AND";
        	}
        	$filtro.=" edad_minima = '".$edad_minima."'";
        }
        
        if ($lugar_salida!=""){
        	if ($filtro!=""){
        		$filtro.=" AND";
        	}
            $filtro.=" lugar_salida LIKE '%".$lugar_salida."%'";
        }
        
        if ($id_comuna!="@"){
        	if ($filtro!=""){
        		$filtro.=" AND";
        	}    
        	$filtro.=" actividad.id_comuna = '".$id_comuna."'";
        }
           
        if($filtro!=""){
           $sql.=" WHERE ".$filtro;
        }
        
    }else{
        
        if ($_SESSION['log_tipo']=="Empresa"){
            $sql.="WHERE rut='".$_SESSION['log_rut']."'";
        }      
    }
    
    $sql.=" ORDER BY id_activ DESC";
    $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());
    
    if (mysql_num_rows($run_sql)){
        $n_row=0;
        $color_fila="tabla_datos1";        
        while($row=mysql_fetch_array($run_sql)){          
            $n_row++;
                                    
            //Seleccion para este formulario                
            $seleccion ="'".$row['id_activ']."',";
            $seleccion.="'".$row['rut_empr']."',";            
            $seleccion.="'".$row['nom_activ']."',";
            $seleccion.="'".$row['id_tipo_activ']."',";            
            $seleccion.="'".$row['descripcion']."',";
            $seleccion.="'".$row['sugerencia']."',";
            $seleccion.="'".$row['requisito']."',";
            $seleccion.="'".$row['dificultad']."',";
            $seleccion.="'".$row['edad_minima']."',";
            $seleccion.="'".$row['lugar_salida']."',";
            $seleccion.="'".$row['id_comuna']."',";           
            $seleccion.="'".$row['lun']."',";
            $seleccion.="'".$row['mar']."',";
            $seleccion.="'".$row['mie']."',";
            $seleccion.="'".$row['jue']."',";
            $seleccion.="'".$row['vie']."',";
            $seleccion.="'".$row['sab']."',";
            $seleccion.="'".$row['dom']."',";          
            $seleccion.="'".date('H',strtotime($row['duracion_hr']))."',";
            $seleccion.="'".date('i',strtotime($row['duracion_hr']))."',";
            $seleccion.="'".$row['duracion_dia']."',";
            $seleccion.="'".date('H',strtotime($row['hr_inicio']))."',";
            $seleccion.="'".date('i',strtotime($row['hr_inicio']))."',";
            $seleccion.="'".$row['precio_adultojoven']."',";      
            $seleccion.="'".$row['precio_nino']."',";       
            $seleccion.="'".$row['precio_adultomayor']."',";
            $seleccion.="'".$row['precio_grupo']."',";
            $seleccion.="'".$row['dolar_adultojoven']."',";      
            $seleccion.="'".$row['dolar_nino']."',";       
            $seleccion.="'".$row['dolar_adultomayor']."',";
            $seleccion.="'".$row['dolar_grupo']."',";
            $seleccion.="'".$row['dscto_adultojoven']."',";
            $seleccion.="'".$row['dscto_nino']."',";
            $seleccion.="'".$row['dscto_adultomayor']."',";
            $seleccion.="'".$row['dscto_grupo']."',";
            $seleccion.="'".$row['grupo']."'";
            
            
            //CONT HORARIOS
            $sql2=" SELECT COUNT(*) AS cont_hr FROM actividad_horario ";
            $sql2.="WHERE id_activ='".$row['id_activ']."'";
            $run_sql2=mysql_query($sql2) or die ('ErrorSql > '.mysql_error ());                     
            if (mysql_num_rows($run_sql2)){                                        
                while($row2=mysql_fetch_array($run_sql2)){
                    $cont_hr=$row2['cont_hr'];
                }                    
                if ($cont_hr=="0"){
                    $cont_hr=" ";
                }
            }
            
            //CONT ARCH
            $sql2=" SELECT COUNT(*) AS cont_arch FROM actividad_archivo ";
            $sql2.="WHERE id_activ='".$row['id_activ']."'";
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
            <tr class="'.$color_fila.'" style="cursor:pointer;" valign="top" onclick="selecc_actividad('.$seleccion.');" >   
            <td>'.$row['id_activ'].'</td>
            <td>'.$row['nombre'].'</td>
            <td>'.$row['nom_activ'].'</td>
            <td>'.$row['nom_tipo_activ'].'</td>
            <td>'.$row['descripcion'].'</td>
            <td>'.$row['sugerencia'].'</td>
            <td>'.$row['nom_comuna'].'</td>
           
            <td align="center">
                <input type="button" class="icono_ver_detalle" id="btver_'.$row['id_activ'].'" value=" + " onclick="javascript:ver_detalle_actividad('."'".$row['id_activ']."'".');">                    
                &nbsp;
                <input type="button" class="icono_horario" value="'.$cont_hr.'" onclick="go_hrs_activ('."'".$row['id_activ']."'".');">
                &nbsp; 
                <input type="button" class="icono_foto" value="'.$cont_arch.'" onclick="go_arch_activ('."'".$row['id_activ']."'".');">
            </td>
        </tr>
        
        <tr class="'.$color_fila.'">
            <td colspan="8" style="border-bottom:2px solid #000;">
                <div id="div_detalle_'.$row['id_activ'].'" style="display:none;">';
                    
                    //Datos2
                    echo '
                    <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center" style="border:1px solid;">
                    <tr class="'.$color_fila.'">                   
                        <td width="23%">                <b><u>  Requisitos              </u></b>    </td>
                        <td width="10%" align="center"> <b><u>  Nivel Dificultad        </u></b>    </td>
                        <td width="10%" align="center"> <b><u>  Edad M&iacute;nima      </u></b>    </td>
                        <td width="23%" align="center"> <b><u>  Lugar Salida            </u></b>    </td>                            
                        <td width="2%">                 <b><u>  Lu                      </u></b>    </td>
                        <td width="2%">                 <b><u>  Ma                      </u></b>    </td>
                        <td width="2%">                 <b><u>  Mi                      </u></b>    </td>
                        <td width="2%">                 <b><u>  Ju                      </u></b>    </td>
                        <td width="2%">                 <b><u>  Vi                      </u></b>    </td>
                        <td width="2%">                 <b><u>  Sa                      </u></b>    </td>
                        <td width="2%">                 <b><u>  Do                      </u></b>    </td>
                        <td width="10%" align="center"> <b><u>  Duraci&oacute;n Activ.   </u></b>    </td>
                        <td width="10%" align="center"> <b><u>  Hora Inicio              </u></b>    </td>                            
                    </tr>
                    
                    <tr class="'.$color_fila.'" valign="top">                           
                        <td>'.$row['requisito'].'</td>                            
                        <td align="center">';
                            if ($row['dificultad']==1){
                                echo "Bajo";
                            }elseif ($row['dificultad']==2){
                                echo "Medio";
                            }elseif ($row['dificultad']==3){
                                echo "Alto";
                            }
                        echo '
                        </td>
                        
                        <td align="center">'.$row['edad_minima'].'</td>
                        <td align="center">'.$row['lugar_salida'].'</td>';
                        
                        if ($row['lun']=="1"){ echo '<td style="color:green">&#10003;</td>';}else{ echo '<td style="color:red">&#10005;</td>'; }
                        if ($row['mar']=="1"){ echo '<td style="color:green">&#10003;</td>';}else{ echo '<td style="color:red">&#10005;</td>'; }
                        if ($row['mie']=="1"){ echo '<td style="color:green">&#10003;</td>';}else{ echo '<td style="color:red">&#10005;</td>'; }
                        if ($row['jue']=="1"){ echo '<td style="color:green">&#10003;</td>';}else{ echo '<td style="color:red">&#10005;</td>'; }
                        if ($row['vie']=="1"){ echo '<td style="color:green">&#10003;</td>';}else{ echo '<td style="color:red">&#10005;</td>'; }
                        if ($row['sab']=="1"){ echo '<td style="color:green">&#10003;</td>';}else{ echo '<td style="color:red">&#10005;</td>'; }
                        if ($row['dom']=="1"){ echo '<td style="color:green">&#10003;</td>';}else{ echo '<td style="color:red">&#10005;</td>'; }
                        
                        ##DURACION##########################################################################  
                        if ($row['duracion_hr']!="00:00:00"){
                            
                            $h = (int) ( date('H',strtotime($row['duracion_hr'])) );
                            $i = (int) ( date('i',strtotime($row['duracion_hr'])) );
                            
                            if ($h==0){
                                $duracion = $i.' Min';
                                
                            }else{
                                
                                if ($i==0){
                                    $duracion = $h.' Hrs';
                                }else{
                                    $duracion = $h.":".$i.' Hrs';
                                }                        
                            }
                            
                        }else if ($row['duracion_dia']>0){
                            if ($row['duracion_dia']==1){
                                $duracion = $row['duracion_dia'].' D&iacute;a';
                            }else{
                                $duracion = $row['duracion_dia'].' D&iacute;as';
                            }
                            
                        }else{
                            $duracion = ' - ';
                        }
                        echo '                            
                        <td align="center">'.$duracion.'</td>';
                        
                        ####################################################################################
                        
                        echo '                            
                        <td align="center">'.date('H:i',strtotime($row['hr_inicio'])).'</td>
                    </tr>
                    </table><br/>';
                    
                    //Datos3                        
                    $pfinal_adultojoven = $row['precio_adultojoven']-( ($row['precio_adultojoven']*$row['dscto_adultojoven']/100) );
                    $pfinal_nino        = $row['precio_nino']-( ($row['precio_nino']*$row['dscto_nino']/100) );
                    $pfinal_adultomayor = $row['precio_adultomayor']-( ($row['precio_adultomayor']*$row['dscto_adultomayor']/100) );
                    $pfinal_grupo       = $row['precio_grupo']-( ($row['precio_grupo']*$row['dscto_grupo']/100) );

                    echo '
                    <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center"  style="border:1px solid;">
                    <tr class="'.$color_fila.'">
                        <th colspan="4" style="border-right:1px solid; border-bottom:1px solid;">    Adulto         </th>
                        <th colspan="4" style="border-right:1px solid; border-bottom:1px solid;">    Ni&ntilde;o    </th>
                        <th colspan="4" style="border-right:1px solid; border-bottom:1px solid;">    Adulto Mayor   </th>
                        <th colspan="5" style="border-bottom:1px solid;">                            Grupo          </th>                        
                    </tr>
                    
                    <tr class="'.$color_fila.'">                      
                        <th width="6%"><u>   Precio </u>    </th>
                        <th width="6%"><u>   Dolar  </u>    </th>
                        <th width="6%"><u>   Dscto  </u>    </th>
                        <th width="6%" style="border-right:1px solid;"><u>   Precio Final </u>    </th>
                        
                        <th width="6%"><u>   Precio </u>    </td>
                        <th width="6%"><u>   Dolar  </u>    </th>
                        <th width="6%"><u>   Dscto. </u>    </td>
                        <th width="6%" style="border-right:1px solid;"><u>   Precio Final </u>    </th>
                        
                        <th width="6%"><u>   Precio </u>    </td>
                        <th width="6%"><u>   Dolar  </u>    </th>
                        <th width="6%"><u>   Dscto. </u>    </td>
                        <th width="6%" style="border-right:1px solid;"><u>   Precio Final </u>    </th>
                        
                        <th width="6%"><u>   Precio </u>        </td>
                        <th width="6%"><u>   Dolar  </u>        </th>
                        <th width="6%"><u>   Dscto. </u>        </td>
                        <th width="6%"><u>   Precio Final </u>  </th>
                        <th width="4%"><u>   N&deg; Pers </u>   </th>                        
                    </tr>
                    
                    <tr class="'.$color_fila.'">
                        <th>$'.number_format($row['precio_adultojoven'], 0, ",", ".").'</th>
                        <th>$'.number_format($row['dolar_adultojoven'], 0, ",", ".").'</th>
                        <th>'.number_format($row['dscto_adultojoven'], 0, ",", ".").'%</th>
                        <th style="border-right:1px solid;">$'.number_format($pfinal_adultojoven, 0, ",", ".").'</th>
                        
                        <th>$'.number_format($row['precio_nino'], 0, ",", ".").'</th>
                        <th>$'.number_format($row['dolar_nino'], 0, ",", ".").'</th>
                        <th>'.number_format($row['dscto_nino'], 0, ",", ".").'%</th>
                        <th style="border-right:1px solid;">$'.number_format($pfinal_nino, 0, ",", ".").'</th>
                        
                        <th>$'.number_format($row['precio_adultomayor'], 0, ",", ".").'</th>
                        <th>$'.number_format($row['dolar_adultomayor'], 0, ",", ".").'</th>
                        <th>'.number_format($row['dscto_adultomayor'], 0, ",", ".").'%</th>
                        <th style="border-right:1px solid;">$'.number_format($pfinal_adultomayor, 0, ",", ".").'</th>
                        
                        <th>$'.number_format($row['precio_grupo'], 0, ",", ".").'</th>
                        <th>$'.number_format($row['dolar_grupo'], 0, ",", ".").'</th>
                        <th>'.number_format($row['dscto_grupo'], 0, ",", ".").'%</th>
                        <th>$'.number_format($pfinal_grupo, 0, ",", ".").'</th>
                        <th>'.$row['grupo'].'</th>
                    </tr>
                    </table>
                    <br/>            
                </div>                
            </td>     
            </tr>';
        
            if ($color_fila=="tabla_datos1"){
                $color_fila="tabla_datos2";                                       
            }else{
                $color_fila="tabla_datos1";                                                   
            }
        }//Fin while     
        echo '
        <tr class="tabla_head"><th colspan="8" align="center">Cantidad de registros: '.$n_row.'</th> </tr>';
                            
    }else{        
        echo '
        <tr class="tabla_datos1"><td colspan="8" ><center>No se encontraron resultados</center></td> </tr>';
    }
    echo '
    </table>';
}
############################################################################################################
} // FIN CASE CLASS
?>