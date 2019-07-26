<?php
session_start();

if (!isset($_SESSION['log_rut']) OR !isset($_SESSION['log_nom']) OR !isset($_SESSION['log_tipo'])){    
    echo '<input type="hidden" id="sesion" value="err">';
    return false;
}
?>

<html>
<head>
    <meta charset="utf-8"/>
    <title>turismo</title>
    <!-- icono Web -->
    <link href="img/icono_web.png" type="image/x-icon" rel="shortcut icon"/>
    <!-- ajax -->
    <script src="func/ajax.js" type="text/javascript"></script>
    <!-- jquery - alert - confirm-->
    <script src="func/jquery.min.js" type="text/javascript"></script>
    <script src="func/jquery.alerts.js" type="text/javascript"></script>
    <link href="func/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen"/>    
    <!--formatos - validaciones -->    
    <link href="css/formatos.css" type="text/css" rel="stylesheet"  media="screen"/>
    <script src="func/validaciones.js" type="text/javascript"></script>
    
    <!--formulario -->
    <script src="func/alojam_unidad.js" type="text/javascript"></script> 
    
</head>
<body>     

<?php
require_once ("func/cnx.php");
header("Content-Type: text/html;charset=utf-8");

$op = isset($_GET['op'])?$_GET['op']:null;

$alojam_unidad= new alojam_unidad();
switch($op){
    case'1':
        $alojam_unidad->inicio_alojam_unidad();
        break;
        
    case'2':
        $alojam_unidad->grabar_alojam_unidad();
        break;
        
    case'3':
        $alojam_unidad->eliminar_alojam_unidad();
        break;
        
    case'4':
        $alojam_unidad->grilla_alojam_unidad();
        break;
}

class alojam_unidad{

###########################################################################################################
public function inicio_alojam_unidad(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    $id_estab = isset($_GET['id_estab'])?$_GET['id_estab']:null;
        
    echo '
    <div id="titulo" class="titulo1">Configuracion Habitaciones/Caba&ntilde;as/Departamentos</div>';
    
    $sql ="SELECT ";
    $sql.="alojam_estab.id_estab, ";
    $sql.="alojam_estab.nom_estab, ";    
    $sql.="alojam_estab.rut_empr, ";
    $sql.="man_usuario.nombre AS nom_empr, ";
    $sql.="alojam_estab.tipo_alojam, ";
    $sql.="man_tipo_alojam.nom_tipo_alojam, ";
    $sql.="alojam_estab.estrella, ";
    $sql.="alojam_estab.id_desayuno, ";
    $sql.="man_desayuno.nom_desayuno ";
    $sql.="FROM alojam_estab ";
    $sql.="INNER JOIN man_usuario ON alojam_estab.rut_empr = man_usuario.rut ";
    $sql.="INNER JOIN man_tipo_alojam ON alojam_estab.tipo_alojam = man_tipo_alojam.id_tipo_alojam ";
    $sql.="INNER JOIN man_desayuno ON alojam_estab.id_desayuno = man_desayuno.id_desayuno ";
    $sql.="WHERE id_estab='".$id_estab."' LIMIT 1";
    $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());   
 
    if (mysql_num_rows($run_sql)){
        while($row=mysql_fetch_array($run_sql)){
            echo '
            <table width="100%" rules="rows" border="0" cellspacing="0" cellpadding="0" class="panel1" align="center">
            <tr>
                <td class="etq2" width="33%">ID Establecimiento:    <label class="etq1" id="id_estab">'.$row['id_estab'].'</label></td>
                <td class="etq2" width="33%">Establecimiento:       <label class="etq1">'.$row['nom_estab'].'</label></td>     
                <td class="etq2" width="33%">Empresa:               <label class="etq1">'.$row['nom_empr'].'</label></td>
            </tr>
            
            <tr>
                <td class="etq2">Tipo Alojamiento:                  <label class="etq1">'.$row['nom_tipo_alojam'].'</label></td>
                <td class="etq2">Estrellas:                         <label class="etq1">'.$row['estrella'].'</label></td>
                <td class="etq2">Desayuno:                          <label class="etq1">'.$row['nom_desayuno'].'</label></td>
            </tr>
            </table>';
        }
    }
    
    //FORMULARIO
    echo '
    <FORM id="form_alojam_unidad">
     
    <table width="98%" border="0" cellspacing="0" cellpadding="0" class="etq1" align="center">
    
    <tr height="40px">       
        <td width="50%" align="center" colspan="2">
            <label id="msn_update" class="msn_err"></label>
        </td>
    </tr>
    
    <tr height="40px">
        <td width="50%" align="center">ID:<br/>
            <input type="text" id="id_unidad" style="width:90%;" maxlength="8" class="txt3" onclick="limpia_form_alojam_unidad();" readonly/>
            <br><label id="msn_id_unidad" class="msn_err"></label>
        </td>
        
        <td width="50%" align="center">Nombre:<br/>
            <input type="text" id="nom_unidad" style="width:90%;" maxlength="50" placeholder="Nombre" class="txt1" onblur="valida_alfanum(this);"/>
            <br><label id="msn_nom_unidad" class="msn_err"></label>
        </td>
    </tr>
    </table><br/>
    
    <TABLE width="93%" rules="all" cellspacing="0" cellpadding="0" align="center" style="border:1px solid;">
    <TR valign="top">
        <TD width="33%" align="center">
        
            <table width="100%" rules="rows" class="etq1">
            <tr><td colspan="2" align="center" class="tabla_head">Caracter&iacute;sticas A (Cantidad)</td></td>
            <tr height="28px">
                <td align="center">Cant. Personas:</td>
                <td align="center"><input type="text" id="cant_persona" size="3" maxlength="2" placeholder="Nro" class="txt1" onkeypress="return esNumero(event);"/></td>
            </tr>
            
            <tr height="28px">
                <td align="center">Cant. Habitaciones:</td>
                <td align="center"><input type="text" id="cant_habitacion" size="3" maxlength="2" placeholder="Nro" class="txt1" onkeypress="return esNumero(event);"/></td>
            </tr>
            
            <tr height="28px">
                <td align="center">Cant. Ba&ntilde;os Independientes:</td>
                <td align="center"><input type="text" id="cant_bano_ind" size="3" maxlength="2" placeholder="Nro" class="txt1" onkeypress="return esNumero(event);"/></td>
            </tr>
            
            <tr height="28px">
                <td align="center">Cant. Ba&ntilde;os Compartidos:</td>
                <td align="center"><input type="text" id="cant_bano_com" size="3" maxlength="2" placeholder="Nro" class="txt1" onkeypress="return esNumero(event);"/></td>
            </tr>
            
            <tr height="28px">
                <td align="center"></td>
                <td align="center"></td>
            </tr>            
            </table>
     
        </TD>
        
        <TD width="33%" align="center">
        
            <table width="100%" rules="rows" class="etq1">
            <tr><td colspan="2" align="center" class="tabla_head">Caracter&iacute;sticas B (Cantidad)</td></td>
            <tr height="28px">
                <td align="center">Cant. Camas Litera:</td>
                <td align="center"><input type="text" id="cant_cama_litera" size="3" maxlength="2" placeholder="Nro" class="txt1" onkeypress="return esNumero(event);"/></td>
            </tr>
            
            <tr height="28px">
                <td align="center">Cant. Camas 1 Plaza:</td>
                <td align="center"><input type="text" id="cant_cama_1plaza" size="3" maxlength="2" placeholder="Nro" class="txt1" onkeypress="return esNumero(event);"/></td>
            </tr>
            
            <tr height="28px">
                <td align="center">Cant. Camas 1 Plaza-Media:</td>
                <td align="center"><input type="text" id="cant_cama_1plazamedia" size="3" maxlength="2" placeholder="Nro" class="txt1" onkeypress="return esNumero(event);"/></td>
            </tr>
            
            <tr height="28px">
                <td align="center">Cant. Camas 2 Plazas:</td>
                <td align="center"><input type="text" id="cant_cama_2plaza" size="3" maxlength="2" placeholder="Nro" class="txt1" onkeypress="return esNumero(event);"/></td>
            </tr>
            
            <tr height="28px">
                <td align="center">Cant. Camas King:</td>
                <td align="center"><input type="text" id="cant_cama_king" size="3" maxlength="2" placeholder="Nro" class="txt1" onkeypress="return esNumero(event);"/></td>
            </tr>            
            </table>
     
        </TD>
        
        <TD width="33%" align="center">
        
            <table width="100%" rules="rows" class="etq1">
            <tr><td colspan="2" align="center" class="tabla_head">Caracter&iacute;sticas C (Tiene: Si/No)</td></td>
            <tr height="28px">
                <td align="center">Cocina:</td>
                <td align="center"><input type="checkbox" id="chk_cocina"></td>
            </tr>
            
            <tr height="28px">
                <td align="center">Comedor:</td>
                <td align="center"><input type="checkbox" id="chk_comedor"></td>
            </tr>
            
            <tr height="28px">
                <td align="center">Jacuzzi:</td>
                <td align="center"><input type="checkbox" id="chk_jacuzzi"></td>
            </tr>
            
            <tr height="28px">
                <td align="center">Wifi:</td>
                <td align="center"><input type="checkbox" id="chk_wifi"></td>
            </tr>
            
            <tr height="28px">
                <td align="center">Estacionamiento:</td>
                <td align="center"><input type="checkbox" id="chk_estacionam"></td>
            </tr>            
            </table>
     
        </TD>
    </TR>
    </TABLE><br/>
   
    
    <table width="98%" border="0" cellspacing="0" cellpadding="0" class="etq1" align="center">
    <tr height="40px">
        <td align="center" colspan="2">Obs:
            <input type="text" id="nchar1" value="250" size="3" style="background-color: transparent;border-width:0px;color:#DF0101;" disabled/>
            <br/>
            <textarea id="obs" rows="2" style="width:95%;" maxlength="250" placeholder="Obs" class="txt1" onblur="valida_alfanum(this);" onkeypress="javascript:cont_char1();" onkeyup="javascript:cont_char1();" onmouseout="javascript:cont_char1();"></textarea>            
            <br/><label id="msn_obs" class="msn_err"></label>
        </td>
    </tr>
    
    <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>
    
    <tr height="40px">
        <td align="center">Precio $CLP:<br/>
            <input type="text" id="precio" style="width:30%;" maxlength="8" class="txt1" placeholder="$CLP" onkeypress="return esNumero(event);"/>
            <br/><label id="msn_precio" class="msn_err"></label>
        </td>
        
        <td align="center">Dolar $US:<br/>
            <input type="text" id="dolar" style="width:30%;" maxlength="8" class="txt1" placeholder="$US" onkeypress="return esNumero(event);"/>
            <br/><label id="msn_dolar" class="msn_err"></label>
        </td>
    </tr>
    
    <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr> 
    
    <tr height="40px">
        <td colspan="3" align="center">     
            <input type="button" title="Grabar" class="bt_grabar" onclick="grabar_alojam_unidad();">&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" title="Eliminar" class="bt_eliminar" onclick="eliminar_alojam_unidad();">&nbsp;&nbsp;&nbsp;&nbsp;            
            <input type="button" title="Copiar Datos" class="bt_exportar" onclick="copy_grilla_alojam_unidad();">&nbsp;&nbsp;&nbsp;&nbsp; 
            <input type="button" title="Limpiar" class="bt_limpiar" onclick="limpia_form_alojam_unidad();">&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
    </tr>
    </table>';
    
    //GRILLA
    echo '    
    <DIV id="grilla_alojam_unidad">';
                
        //Cabecera Grilla
        echo '       
        <table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">        
        
        <tr class="tabla_head">
            <td align="center">ID</td>
            <td align="center" width="10%">Nombre</td>
            <td align="center">Caracter&iacute;sticas A <br/> (Cantidad)</td>
            <td align="center">Caracter&iacute;sticas B <br/> (Cantidad)</td>
            <td align="center">Caracter&iacute;sticas C <br/> (Tiene)</td>
            <td align="center">Obs</td>
            <td align="center">Precio $CLP</td>
            <td align="center">Dolar $US</td>
            <td align="center" width="6%">Opc</td>
        </tr>';
         
        //Datos Grilla        
        $sql= "SELECT ";
        $sql.="alojam_unidad.id_unidad, ";
        $sql.="alojam_unidad.nom_unidad, ";
        $sql.="alojam_unidad.id_estab, ";
        $sql.="alojam_unidad.cant_persona, ";
        $sql.="alojam_unidad.cant_habitacion, ";
        $sql.="alojam_unidad.cant_bano_ind, ";
        $sql.="alojam_unidad.cant_bano_com, ";
        $sql.="alojam_unidad.cant_cama_litera, ";
        $sql.="alojam_unidad.cant_cama_1plaza, ";
        $sql.="alojam_unidad.cant_cama_1plazamedia, ";
        $sql.="alojam_unidad.cant_cama_2plaza, ";
        $sql.="alojam_unidad.cant_cama_king, ";
        $sql.="alojam_unidad.cocina, ";
        $sql.="alojam_unidad.comedor, ";
        $sql.="alojam_unidad.jacuzzi, ";
        $sql.="alojam_unidad.wifi, ";
        $sql.="alojam_unidad.estacionam, ";
        $sql.="alojam_unidad.obs, ";        
        $sql.="alojam_unidad.precio, ";
        $sql.="alojam_unidad.dolar, ";
        $sql.="alojam_unidad.reg_rut, ";
        $sql.="alojam_unidad.reg_fecha ";
        $sql.="FROM alojam_unidad ";
        $sql.="WHERE id_estab='".$id_estab."' ";
        $sql.="ORDER BY nom_unidad";      
        
        $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());                    
        			
        if (mysql_num_rows($run_sql)){
            $n_row=0;
            $color_fila=1;
            
            $class_etq1="width:70%; color:#333 ;border:1px dotted #A4A4A4; float:left;";
            $class_etq2="width:20%; color:#333 ;border:1px dotted #A4A4A4; float:left;";
                
            while($row=mysql_fetch_array($run_sql)){    
                $n_row++;
                
                //Seleccion para este formulario
                $seleccion ="'".$row['id_unidad']."',";
                $seleccion.="'".$row['nom_unidad']."',";
                $seleccion.="'".$row['id_estab']."',";
                $seleccion.="'".$row['cant_persona']."',";
                $seleccion.="'".$row['cant_habitacion']."',";
                $seleccion.="'".$row['cant_bano_ind']."',";
                $seleccion.="'".$row['cant_bano_com']."',";
                $seleccion.="'".$row['cant_cama_litera']."',";
                $seleccion.="'".$row['cant_cama_1plaza']."',";
                $seleccion.="'".$row['cant_cama_1plazamedia']."',";
                $seleccion.="'".$row['cant_cama_2plaza']."',";
                $seleccion.="'".$row['cant_cama_king']."',";
                $seleccion.="'".$row['cocina']."',";
                $seleccion.="'".$row['comedor']."',";
                $seleccion.="'".$row['jacuzzi']."',";
                $seleccion.="'".$row['wifi']."',";
                $seleccion.="'".$row['estacionam']."',";
                $seleccion.="'".$row['obs']."',";                
                $seleccion.="'".$row['precio']."',";                
                $seleccion.="'".$row['dolar']."'";
                
                if ($color_fila==1){
                    echo '<tr class="tabla_datos1" onclick="selecc_alojam_unidad('.$seleccion.');">';
                    $color_fila=2;
                    
                }else if ($color_fila==2){           
                    echo '<tr class="tabla_datos2" onclick="selecc_alojam_unidad('.$seleccion.');">';
                    $color_fila=1;
                }
                
                $caract1 = "";
                $caract2 = "";
                $caract3 = "";
                
                //Caracteristicas A
                if ($row['cant_persona']>"0"){  $caract1.='<label style="'.$class_etq1.'">Personas:</label>                         <label style="'.$class_etq2.'">'.$row['cant_persona'].'</label>'; }
                if ($row['cant_habitacion']>"0"){    $caract1.='<label style="'.$class_etq1.'">Habitaciones:</label>                <label style="'.$class_etq2.'">'.$row['cant_habitacion'].'</label>'; }
                if ($row['cant_bano_ind']>"0"){ $caract1.='<label style="'.$class_etq1.'">Ba&ntilde;o Indep:</label>                <label style="'.$class_etq2.'">'.$row['cant_bano_ind'].'</label>'; }
                if ($row['cant_bano_com']>"0"){ $caract1.='<label style="'.$class_etq1.'">Ba&ntilde;o Compart:</label>              <label style="'.$class_etq2.'">'.$row['cant_bano_com'].'</label>'; }
                
                //Caracteristicas B
                if ($row['cant_cama_litera']>"0"){      $caract2.='<label style="'.$class_etq1.'">Cama Litera:</label>                <label style="'.$class_etq2.'">'.$row['cant_cama_litera'].'</label>'; }
                if ($row['cant_cama_1plaza']>"0"){      $caract2.='<label style="'.$class_etq1.'">Cama 1 Plaza:</label>               <label style="'.$class_etq2.'">'.$row['cant_cama_1plaza'].'</label>'; }
                if ($row['cant_cama_1plazamedia']>"0"){ $caract2.='<label style="'.$class_etq1.'">Cama 1 Plaza y Media:</label>       <label style="'.$class_etq2.'">'.$row['cant_cama_1plazamedia'].'</label>'; }
                if ($row['cant_cama_2plaza']>"0"){      $caract2.='<label style="'.$class_etq1.'">Cama 2 Plazas:</label>              <label style="'.$class_etq2.'">'.$row['cant_cama_2plaza'].'</label>'; }
                if ($row['cant_cama_king']>"0"){        $caract2.='<label style="'.$class_etq1.'">King:</label>                       <label style="'.$class_etq2.'">'.$row['cant_cama_king'].'</label>'; }
                
                //Caracteristicas C
                if ($row['cocina']=="1"){ $caract3.="Cocina <br/>"; }
                if ($row['comedor']=="1"){ $caract3.="Comedor <br/>"; }
                if ($row['jacuzzi']=="1"){ $caract3.="Jacuzzi <br/>"; }
                if ($row['wifi']=="1"){ $caract3.="Wifi <br/>"; }
                if ($row['estacionam']=="1"){ $caract3.="Estacionamiento <br/>"; }
                
                //CONT ARCH
                $sql2=" SELECT COUNT(*) AS cont_arch FROM alojam_unidad_archivo ";
                $sql2.="WHERE id_unidad='".$row['id_unidad']."'";
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
                <td align="center">'.$row['id_unidad'].'</td>
                <td align="center">'.$row['nom_unidad'].'</td>
                <td align="center" valign="middle">'.$caract1.'</td>
                <td align="center" valign="middle">'.$caract2.'</td>
                <td align="center">'.$caract3.'</td>
                <td align="center">'.$row['obs'].'</td>                
                <td align="center">'.number_format($row['precio'], 0, ",", ".").'</td>
                <td align="center">'.number_format($row['dolar'], 0, ",", ".").'</td>
                
                <td align="center">';                     
                   echo '<input type="button" title="Fotos Habitacion/Interior" class="icono_foto" value="'.$cont_arch.'" onclick="go_arch_unidad('."'".$row['id_unidad']."'".');">';
                echo '
                </td>
                
                </tr>';
            }     
                echo '
                <tr class="tabla_head"><th colspan="9" align="center">Cantidad de registros: '.$n_row.'</th> </tr>';
                                    
        }else{            
                echo '
                <tr class="tabla_datos1"><td colspan="9" ><center>No se encontraron resultados</center></td> </tr>';
        }
       echo '
       </table>
       
    </DIV>
    
    <div id="salida"></div>
    
    </FORM>';
}

public function grabar_alojam_unidad(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
   
    $id_estab               = isset($_GET['id_estab'])?$_GET['id_estab']:null;
    $id_unidad              = isset($_GET['id_unidad'])?$_GET['id_unidad']:null;
    $nom_unidad             = guardian($_GET['nom_unidad']);
    $cant_persona           = isset($_GET['cant_persona'])?$_GET['cant_persona']:null;
    $cant_habitacion        = isset($_GET['cant_habitacion'])?$_GET['cant_habitacion']:null;
    $cant_bano_ind          = isset($_GET['cant_bano_ind'])?$_GET['cant_bano_ind']:null;
    $cant_bano_com          = isset($_GET['cant_bano_com'])?$_GET['cant_bano_com']:null;
    
    $cant_cama_litera       = isset($_GET['cant_cama_litera'])?$_GET['cant_cama_litera']:null;
    $cant_cama_1plaza       = isset($_GET['cant_cama_1plaza'])?$_GET['cant_cama_1plaza']:null;
    $cant_cama_1plazamedia  = isset($_GET['cant_cama_1plazamedia'])?$_GET['cant_cama_1plazamedia']:null;
    $cant_cama_2plaza       = isset($_GET['cant_cama_2plaza'])?$_GET['cant_cama_2plaza']:null;
    $cant_cama_king         = isset($_GET['cant_cama_king'])?$_GET['cant_cama_king']:null;
    
    $cocina                 = isset($_GET['cocina'])?$_GET['cocina']:null;
    $comedor                = isset($_GET['comedor'])?$_GET['comedor']:null;
    $jacuzzi                = isset($_GET['jacuzzi'])?$_GET['jacuzzi']:null;
    $wifi                   = isset($_GET['wifi'])?$_GET['wifi']:null;
    $estacionam             = isset($_GET['estacionam'])?$_GET['estacionam']:null;
    
    $obs                    = guardian($_GET['obs']);
    $precio                 = isset($_GET['precio'])?$_GET['precio']:null;
    $dolar                  = isset($_GET['dolar'])?$_GET['dolar']:null;
    
    $sql="SELECT * FROM alojam_unidad ";
    $sql.="WHERE id_unidad='".$id_unidad."' AND id_estab='".$id_estab."'";
    $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
       	
    if (mysql_num_rows($run_sql)){
        $sql = "UPDATE alojam_unidad SET ";
        
        $sql.= "nom_unidad='".$nom_unidad."',";
        $sql.= "cant_persona='".$cant_persona."',";     
        $sql.= "cant_habitacion='".$cant_habitacion."',";       
        $sql.= "cant_bano_ind='".$cant_bano_ind."',";      
        $sql.= "cant_bano_com='".$cant_bano_com."',";     
        
        $sql.= "cant_cama_litera='".$cant_cama_litera."',";
        $sql.= "cant_cama_1plaza='".$cant_cama_1plaza."',";
        $sql.= "cant_cama_1plazamedia='".$cant_cama_1plazamedia."',";
        $sql.= "cant_cama_2plaza='".$cant_cama_2plaza."',";
        $sql.= "cant_cama_king='".$cant_cama_king."',";
        
        $sql.= "cocina='".$cocina."',";   
        $sql.= "comedor='".$comedor."',";
        $sql.= "jacuzzi='".$jacuzzi."',";
        $sql.= "wifi='".$wifi."',";
        $sql.= "estacionam='".$estacionam."',";    
        
        $sql.= "obs='".$obs."',";        
        $sql.= "precio='".$precio."',";        
        $sql.= "dolar='".$dolar."',";
      
        $sql.= "reg_rut='".$_SESSION['log_rut']."',";
        $sql.= "reg_fecha='".date('Y-m-d H:i:s')."' ";
    	
        $sql.="WHERE id_unidad='".$id_unidad."' AND id_estab='".$id_estab."'";
        $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
        
        echo '<input type="hidden" id="eco_grabar" value="update_ok"/>';
         
    }else{
        $sql="SELECT MAX(id_unidad) AS id_max FROM alojam_unidad";
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
        
        $sql="INSERT INTO alojam_unidad(";            
            $sql.="id_unidad,";        
            $sql.="nom_unidad,";
            $sql.="id_estab,";
            $sql.="cant_persona,";
            $sql.="cant_habitacion,";
            $sql.="cant_bano_ind,";
            $sql.="cant_bano_com,";
            
            $sql.="cant_cama_litera,";
            $sql.="cant_cama_1plaza,";
            $sql.="cant_cama_1plazamedia,";
            $sql.="cant_cama_2plaza,";
            $sql.="cant_cama_king,";
            
            $sql.="cocina,";
            $sql.="comedor,";
            $sql.="jacuzzi,";
            $sql.="wifi,";
            $sql.="estacionam,";
            
            $sql.="obs,";            
            $sql.="precio,";            
            $sql.="dolar,";
            
            $sql.="reg_rut,";
            $sql.="reg_fecha) ";
        $sql.="VALUES (";
            $sql.="'".$new_id."',";
            $sql.="'".$nom_unidad."',";
            $sql.="'".$id_estab."',";
            $sql.="'".$cant_persona."',";
            $sql.="'".$cant_habitacion."',";
            $sql.="'".$cant_bano_ind."',";
            $sql.="'".$cant_bano_com."',";
            
            $sql.="'".$cant_cama_litera."',";
            $sql.="'".$cant_cama_1plaza."',";
            $sql.="'".$cant_cama_1plazamedia."',";
            $sql.="'".$cant_cama_2plaza."',";
            $sql.="'".$cant_cama_king."',";
            
            $sql.="'".$cocina."',";
            $sql.="'".$comedor."',";
            $sql.="'".$jacuzzi."',";
            $sql.="'".$wifi."',";
            $sql.="'".$estacionam."',";
            
            $sql.="'".$obs."',";            
            $sql.="'".$precio."',";            
            $sql.="'".$dolar."',";
            
            $sql.="'".$_SESSION['log_rut']."',";
            $sql.="'".date('Y-m-d H:i:s')."')";         
        $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
        
        echo '<input type="hidden" id="eco_newid" value="'.$new_id.'"/>';
        echo '<input type="hidden" id="eco_grabar" value="insert_ok"/>';
    }
    
}

public function eliminar_alojam_unidad(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    
    $id_estab   = isset($_GET['id_estab'])?$_GET['id_estab']:null;
    $id_unidad  = isset($_GET['id_unidad'])?$_GET['id_unidad']:null;
    $nom_unidad = isset($_GET['nom_unidad'])?$_GET['nom_unidad']:null;
    
  
    $sql ="SELECT * FROM alojam_unidad ";
    $sql.="WHERE id_estab='".$id_estab."' AND id_unidad='".$id_unidad."'";
    $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
    
    if (mysql_num_rows($run_sql)){
    	$sql ="DELETE FROM alojam_unidad ";
        $sql.="WHERE id_estab='".$id_estab."' AND id_unidad='".$id_unidad."'";
        
        $run_sql=mysql_query($sql) or die ('<center><label class="msn_err">No se puede eliminar porque hay datos vinculados<br/>
                                            ID: '.$id_unidad.' &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;             
                                            Nombre: '.$nom_unidad.'</b></label></center>');
                                                 
        echo '<input type="hidden" id="eco_eliminar" value="delete_ok"/>';
    }else{
        echo '<input type="hidden" id="eco_eliminar" value="err_delete"/>';
    }
}

public function grilla_alojam_unidad(){  
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    $id_estab = isset($_GET['id_estab'])?$_GET['id_estab']:null;
    
    //Cabecera Grilla
    echo '       
    <table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">        
    
    <tr class="tabla_head">
        <td align="center">ID</td>
        <td align="center" width="10%">Nombre</td>
        <td align="center">Caracter&iacute;sticas A <br/> (Cantidad)</td>
        <td align="center">Caracter&iacute;sticas B <br/> (Cantidad)</td>
        <td align="center">Caracter&iacute;sticas C <br/> (Tiene)</td>
        <td align="center">Obs</td>
        <td align="center">Precio $CLP</td>
        <td align="center">Dolar $US</td>
        <td align="center" width="6%">Opc</td>
    </tr>';
     
    //Datos Grilla        
    $sql= "SELECT ";
    $sql.="alojam_unidad.id_unidad, ";
    $sql.="alojam_unidad.nom_unidad, ";
    $sql.="alojam_unidad.id_estab, ";
    $sql.="alojam_unidad.cant_persona, ";
    $sql.="alojam_unidad.cant_habitacion, ";
    $sql.="alojam_unidad.cant_bano_ind, ";
    $sql.="alojam_unidad.cant_bano_com, ";
    $sql.="alojam_unidad.cant_cama_litera, ";
    $sql.="alojam_unidad.cant_cama_1plaza, ";
    $sql.="alojam_unidad.cant_cama_1plazamedia, ";
    $sql.="alojam_unidad.cant_cama_2plaza, ";
    $sql.="alojam_unidad.cant_cama_king, ";
    $sql.="alojam_unidad.cocina, ";
    $sql.="alojam_unidad.comedor, ";
    $sql.="alojam_unidad.jacuzzi, ";
    $sql.="alojam_unidad.wifi, ";
    $sql.="alojam_unidad.estacionam, ";
    $sql.="alojam_unidad.obs, ";    
    $sql.="alojam_unidad.precio, ";
    $sql.="alojam_unidad.dolar, ";
    $sql.="alojam_unidad.reg_rut, ";
    $sql.="alojam_unidad.reg_fecha ";
    $sql.="FROM alojam_unidad ";
    $sql.="WHERE id_estab='".$id_estab."' ";
    $sql.="ORDER BY nom_unidad";      
    
    $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());                    
    			
    if (mysql_num_rows($run_sql)){
        $n_row=0;
        $color_fila=1;
        
        $class_etq1="width:70%; color:#333 ;border:1px dotted #A4A4A4; float:left;";
        $class_etq2="width:20%; color:#333 ;border:1px dotted #A4A4A4; float:left;";
            
        while($row=mysql_fetch_array($run_sql)){    
            $n_row++;
            
            //Seleccion para este formulario
            $seleccion ="'".$row['id_unidad']."',";
            $seleccion.="'".$row['nom_unidad']."',";
            $seleccion.="'".$row['id_estab']."',";
            $seleccion.="'".$row['cant_persona']."',";
            $seleccion.="'".$row['cant_habitacion']."',";
            $seleccion.="'".$row['cant_bano_ind']."',";
            $seleccion.="'".$row['cant_bano_com']."',";
            $seleccion.="'".$row['cant_cama_litera']."',";
            $seleccion.="'".$row['cant_cama_1plaza']."',";
            $seleccion.="'".$row['cant_cama_1plazamedia']."',";
            $seleccion.="'".$row['cant_cama_2plaza']."',";
            $seleccion.="'".$row['cant_cama_king']."',";
            $seleccion.="'".$row['cocina']."',";
            $seleccion.="'".$row['comedor']."',";
            $seleccion.="'".$row['jacuzzi']."',";
            $seleccion.="'".$row['wifi']."',";
            $seleccion.="'".$row['estacionam']."',";
            $seleccion.="'".$row['obs']."',";                
            $seleccion.="'".$row['precio']."',";                
            $seleccion.="'".$row['dolar']."'";
            
            if ($color_fila==1){
                echo '<tr class="tabla_datos1" onclick="selecc_alojam_unidad('.$seleccion.');">';
                $color_fila=2;
                
            }else if ($color_fila==2){           
                echo '<tr class="tabla_datos2" onclick="selecc_alojam_unidad('.$seleccion.');">';
                $color_fila=1;
            }
            
            $caract1 = "";
            $caract2 = "";
            $caract3 = "";
            
            //Caracteristicas A
            if ($row['cant_persona']>"0"){  $caract1.='<label style="'.$class_etq1.'">Personas:</label>                         <label style="'.$class_etq2.'">'.$row['cant_persona'].'</label>'; }
            if ($row['cant_habitacion']>"0"){    $caract1.='<label style="'.$class_etq1.'">Habitaciones:</label>                <label style="'.$class_etq2.'">'.$row['cant_habitacion'].'</label>'; }
            if ($row['cant_bano_ind']>"0"){ $caract1.='<label style="'.$class_etq1.'">Ba&ntilde;o Indep:</label>                <label style="'.$class_etq2.'">'.$row['cant_bano_ind'].'</label>'; }
            if ($row['cant_bano_com']>"0"){ $caract1.='<label style="'.$class_etq1.'">Ba&ntilde;o Compart:</label>              <label style="'.$class_etq2.'">'.$row['cant_bano_com'].'</label>'; }
            
            //Caracteristicas B
            if ($row['cant_cama_litera']>"0"){      $caract2.='<label style="'.$class_etq1.'">Cama Litera:</label>                <label style="'.$class_etq2.'">'.$row['cant_cama_litera'].'</label>'; }
            if ($row['cant_cama_1plaza']>"0"){      $caract2.='<label style="'.$class_etq1.'">Cama 1 Plaza:</label>               <label style="'.$class_etq2.'">'.$row['cant_cama_1plaza'].'</label>'; }
            if ($row['cant_cama_1plazamedia']>"0"){ $caract2.='<label style="'.$class_etq1.'">Cama 1 Plaza y Media:</label>       <label style="'.$class_etq2.'">'.$row['cant_cama_1plazamedia'].'</label>'; }
            if ($row['cant_cama_2plaza']>"0"){      $caract2.='<label style="'.$class_etq1.'">Cama 2 Plazas:</label>              <label style="'.$class_etq2.'">'.$row['cant_cama_2plaza'].'</label>'; }
            if ($row['cant_cama_king']>"0"){        $caract2.='<label style="'.$class_etq1.'">King:</label>                       <label style="'.$class_etq2.'">'.$row['cant_cama_king'].'</label>'; }
            
            //Caracteristicas C
            if ($row['cocina']=="1"){ $caract3.="Cocina <br/>"; }
            if ($row['comedor']=="1"){ $caract3.="Comedor <br/>"; }
            if ($row['jacuzzi']=="1"){ $caract3.="Jacuzzi <br/>"; }
            if ($row['wifi']=="1"){ $caract3.="Wifi <br/>"; }
            if ($row['estacionam']=="1"){ $caract3.="Estacionamiento <br/>"; }
            
            //CONT ARCH
            $sql2=" SELECT COUNT(*) AS cont_arch FROM alojam_unidad_archivo ";
            $sql2.="WHERE id_unidad='".$row['id_unidad']."'";
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
            <td align="center">'.$row['id_unidad'].'</td>
            <td align="center">'.$row['nom_unidad'].'</td>
            <td align="center" valign="middle">'.$caract1.'</td>
            <td align="center" valign="middle">'.$caract2.'</td>
            <td align="center">'.$caract3.'</td>
            <td align="center">'.$row['obs'].'</td>                
            <td align="center">'.number_format($row['precio'], 0, ",", ".").'</td>
            <td align="center">'.number_format($row['dolar'], 0, ",", ".").'</td>
            
            <td align="center">';                     
               echo '<input type="button" title="Fotos Habitacion/Interior" class="icono_foto" value="'.$cont_arch.'" onclick="go_arch_unidad('."'".$row['id_unidad']."'".');">';
            echo '
            </td>
            
            </tr>';
        }     
            echo '
            <tr class="tabla_head"><th colspan="9" align="center">Cantidad de registros: '.$n_row.'</th> </tr>';
                                
    }else{            
            echo '
            <tr class="tabla_datos1"><td colspan="9" ><center>No se encontraron resultados</center></td> </tr>';
    }
   echo '
   </table>';
}
############################################################################################################
} // FIN CASE CLASS
?>