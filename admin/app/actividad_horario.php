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
    <script src="func/actividad_horario.js" type="text/javascript"></script>
    
</head>
<body>     

<?php
require_once ("func/cnx.php");
header("Content-Type: text/html;charset=utf-8");

$op = isset($_GET['op'])?$_GET['op']:null;

$actividad_horario= new actividad_horario();
switch($op){
    case'1':
        $actividad_horario->inicio_actividad_horario();
        break;
        
    case'2':
        $actividad_horario->grabar_actividad_horario();
        break;
        
    case'3':
        $actividad_horario->eliminar_actividad_horario();
        break;
        
    case'4':
        $actividad_horario->grilla_actividad_horario();
        break;
}

class actividad_horario{

###########################################################################################################
public function inicio_actividad_horario(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    $id_activ = isset($_GET['id_activ'])?$_GET['id_activ']:null;
        
    echo '
    <div id="titulo" class="titulo1">Horarios</div>';
    
    $sql ="SELECT ";
    $sql.="actividad.id_activ, ";
    $sql.="actividad.rut_empr, ";
    $sql.="man_usuario.nombre, ";
    $sql.="actividad.nom_activ, ";
    $sql.="actividad.id_tipo_activ, ";
    $sql.="man_tipo_actividad.nom_tipo_activ, ";
    $sql.="actividad.lugar_salida, ";
    $sql.="actividad.id_comuna, ";
    $sql.="man_comuna.nom_comuna, ";
    $sql.="actividad.descripcion ";
    $sql.="FROM actividad ";
    $sql.="INNER JOIN man_usuario ON actividad.rut_empr = man_usuario.rut ";
    $sql.="INNER JOIN man_tipo_actividad ON actividad.id_tipo_activ = man_tipo_actividad.id_tipo_activ ";
    $sql.="INNER JOIN man_comuna ON actividad.id_comuna = man_comuna.id_comuna ";
    $sql.="WHERE id_activ='".$id_activ."' LIMIT 1";
    $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());   
 
    if (mysql_num_rows($run_sql)){
        while($row=mysql_fetch_array($run_sql)){
            echo '
            <table width="100%" rules="rows" border="0" cellspacing="0" cellpadding="0" class="panel1" align="center">
            <tr>
                <td class="etq2" width="33%">ID Actividad:  <label class="etq1" id="id_activ">'.$row['id_activ'].'</label></td>
                <td class="etq2" width="33%">Empresa:       <label class="etq1">'.$row['rut_empr'].' / '.$row['nombre'].'</label></td>
                <td class="etq2" width="33%">Actividad:     <label class="etq1">'.$row['nom_activ'].'</label></td>           
            </tr>
            
            <tr>
                <td class="etq2">Tipo Actividad:            <label class="etq1">'.$row['nom_tipo_activ'].'</label></td>
                <td class="etq2">Lugar Salida:              <label class="etq1">'.$row['lugar_salida'].'</label></td>
                <td class="etq2">Comuna:                    <label class="etq1">'.$row['nom_comuna'].'</label></td>
            </tr>
            
            <tr>
                <td class="etq2" colspan="3">Descripci&oacute;n:    <label class="etq1">'.$row['descripcion'].'</label></td>    
            </tr>
            </table>';
        }
    }
    
    //FORMULARIO
    echo '  
    <FORM id="form_actividad_horario" method="post">
    
    <table width="80%" border="0" cellspacing="0" cellpadding="0" class="etq1" align="center">
    <tr height="40px"><td colspan="3" align="center"><label id="msn_update" class="msn_err"></label></td></tr>
    
    <tr>
        <td width="10%" align="center">ID:<br/>
            <input type="text" id="id_hr" style="width:90%;" maxlength="8" class="txt3" onclick="limpia_form_actividad_horario();" readonly/>  
        </td>
        
        <td width="55%" align="center">Detalle:<br/>          
            <input type="text" id="detalle" style="width:90%;" maxlength="150" class="txt1" onblur="valida_alfanum(this);"/>
            <br><label id="msn_detalle" class="msn_err"></label>
        </td>
        
        <td width="35%" align="center">Horario:<br>
            <label class="etq3">Ingreso:</label>
            <select id="hh_ini" class="txt1">';
                for ($x=0;$x<=24; $x++){
                    if ($x==$vvhr_ini){
                        echo '<option value="'.str_pad($x, 2, '0', STR_PAD_LEFT).'" selected="selected">'.str_pad($x, 2, '0', STR_PAD_LEFT).'</option>';
                    }else{
                        echo '<option value="'.str_pad($x, 2, '0', STR_PAD_LEFT).'">'.str_pad($x, 2, '0', STR_PAD_LEFT).'</option>';
                    }
        		}	
        	    echo'
        	    </select>:
    
                <select id="mm_ini" class="txt1">';  
        		for ($x=0;$x<=59; $x++){
                    if ($x==$vvmm_ini){
                        echo '<option value="'.str_pad($x, 2, '0', STR_PAD_LEFT).'" selected="selected">'.str_pad($x, 2, '0', STR_PAD_LEFT).'</option>';
                    }else{
                        echo '<option value="'.str_pad($x, 2, '0', STR_PAD_LEFT).'">'.str_pad($x, 2, '0', STR_PAD_LEFT).'</option>';
                    }
        		}
        	    echo'
            </select>           
            
            &nbsp;&nbsp;&nbsp;&nbsp;
            <label class="etq3">Salida:</label>
            <select id="hh_fin" class="txt1">';  
            for ($x=0;$x<=24; $x++){                
                echo '<option value="'.str_pad($x, 2, '0', STR_PAD_LEFT).'">'.str_pad($x, 2, '0', STR_PAD_LEFT).'</option>';
    		}           
    	    echo'
    	    </select>:
	    
    	    <select id="mm_fin" class="txt1">';	    
    		for ($x=0;$x<=59; $x++){
                echo '<option value="'.str_pad($x, 2, '0', STR_PAD_LEFT).'">'.str_pad($x, 2, '0', STR_PAD_LEFT).'</option>';
    		}
    	    echo'
    	    </select>
            <br/><label id="msn_horario" class="msn_err"></label>                                
        </td>
    </tr>
    <tr><td colspan="3"><hr size="1" color="#6E6E6E"></td></tr>';
    
    //BOTONES
    echo '
    <tr height="40px">
        <td colspan="3" align="center">     
            <input type="button" title="Grabar" class="bt_grabar" onclick="grabar_actividad_horario();">&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" title="Eliminar" class="bt_eliminar" onclick="eliminar_actividad_horario();">&nbsp;&nbsp;&nbsp;&nbsp;            
            <input type="button" title="Copiar Datos" class="bt_exportar" onclick="copy_grilla_actividad_horario();">&nbsp;&nbsp;&nbsp;&nbsp; 
            <input type="button" title="Limpiar" class="bt_limpiar" onclick="limpia_form_actividad_horario();">&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
    </tr>
    </table>';
    
    //GRILLA
    echo '    
    <DIV id="grilla_actividad_horario">';
                
        //Cabecera Grilla
        echo '       
        <table width="80%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr class="tabla_head">
            <td></td>
            <td></td>
            <td colspan="2" align="center">Horario</td>
            <td></td>
        </tr>
        
        <tr class="tabla_head">
            <td align="center" width="9%">ID</td>
            <td align="center" width="60%">Detalle</td>
            <td align="center" width="15%" style="border-top:1px solid #ffffff;border-left:1px solid #ffffff;">Ingreso</td>
            <td align="center" width="15%" style="border-top:1px solid #ffffff;border-right:1px solid #ffffff;">Salida</td>
            <td width="1%"></td> 
        </tr>';
         
        //Datos Grilla
        $sql ="SELECT ";
        $sql.="actividad_horario.id_hr, ";
        $sql.="actividad_horario.id_activ, ";
        $sql.="actividad_horario.detalle, ";
        $sql.="actividad_horario.hr_ini, ";
        $sql.="actividad_horario.hr_fin, ";
        $sql.="actividad_horario.reg_rut, ";
        $sql.="actividad_horario.reg_fecha ";
        $sql.="FROM actividad_horario ";
        $sql.="WHERE id_activ='".$id_activ."' ";
        $sql.="ORDER BY detalle";
        
        $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());                    
        			
        if (mysql_num_rows($run_sql)){
            $n_row=0;
            $color_fila=1;
            while($row=mysql_fetch_array($run_sql)){    
                $n_row++;
                                        
                //Seleccion para este formulario
                $seleccion ="'".$row['id_hr']."',";
                $seleccion.="'".$row['detalle']."',";
                $seleccion.="'".date('H',strtotime($row['hr_ini']))."',";
                $seleccion.="'".date('i',strtotime($row['hr_ini']))."',";
                $seleccion.="'".date('H',strtotime($row['hr_fin']))."',";
                $seleccion.="'".date('i',strtotime($row['hr_fin']))."',";
                
                if ($color_fila==1){
                    echo '<tr class="tabla_datos1" onclick="selecc_actividad_horario('.$seleccion.');">';
                    $color_fila=2;
                    
                }else if ($color_fila==2){           
                    echo '<tr class="tabla_datos2" onclick="selecc_actividad_horario('.$seleccion.');">';
                    $color_fila=1;
                }
     
                echo '
                <td align="center">'.$row['id_hr'].'</td>
                <td align="center">'.$row['detalle'].'</td>
                <td align="center">'.date('H:i',strtotime($row['hr_ini'])).'</td>
                <td align="center">'.date('H:i',strtotime($row['hr_fin'])).'</td>
                <td></td>
                </tr>';
            }     
                echo '
                <tr class="tabla_head"><th colspan="5" align="center">Cantidad de registros: '.$n_row.'</th> </tr>';
                                    
        }else{            
                echo '
                <tr class="tabla_datos1"><td colspan="5" ><center>No se encontraron resultados</center></td> </tr>';
        }
       echo '
       </table>
       
    </DIV>
    <div id="salida"></div> 
    </FORM>';
}

public function grabar_actividad_horario(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    
    $id_hr      = isset($_GET['id_hr'])?$_GET['id_hr']:null;
    $id_activ   = isset($_GET['id_activ'])?$_GET['id_activ']:null;
    $detalle    = ucwords(strtolower(guardian($_GET['detalle'])));//1era Letra De Cada Palabra Mayuscula
    $hr_ini     = isset($_GET['hr_ini'])?$_GET['hr_ini']:null;
    $hr_fin     = isset($_GET['hr_fin'])?$_GET['hr_fin']:null;    
    
    $sql="SELECT * FROM actividad_horario ";
    $sql.="WHERE id_hr='".$id_hr."' AND id_activ='".$id_activ."'";
    $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
       	
    if (mysql_num_rows($run_sql)){
        $sql = "UPDATE actividad_horario SET ";
        $sql.= "detalle='".$detalle."',";
        $sql.= "hr_ini='".$hr_ini."',";
        $sql.= "hr_fin='".$hr_fin."',";        
        $sql.= "reg_rut='".$_SESSION['log_rut']."',";
        $sql.= "reg_fecha='".date('Y-m-d H:i:s')."' ";
    	$sql.="WHERE id_hr='".$id_hr."' AND id_activ='".$id_activ."'";
        $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
        
        echo '<input type="hidden" id="eco_grabar" value="update_ok"/>';
         
    }else{
        $sql="SELECT MAX(id_hr) AS id_max FROM actividad_horario";
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
        
        $sql="INSERT INTO actividad_horario(";
            $sql.="id_hr,";
            $sql.="id_activ,";
            $sql.="detalle,";        
            $sql.="hr_ini,";
            $sql.="hr_fin,";        
            $sql.="reg_rut,";
            $sql.="reg_fecha) ";
        $sql.="VALUES (";
            $sql.="'".$new_id."',";
            $sql.="'".$id_activ."',";
            $sql.="'".$detalle."',";
            $sql.="'".$hr_ini."',";
            $sql.="'".$hr_fin."',";     
            $sql.="'".$_SESSION['log_rut']."',";
            $sql.="'".date('Y-m-d H:i:s')."')";         
        $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
        
        echo '<input type="hidden" id="eco_newid" value="'.$new_id.'"/>';
        echo '<input type="hidden" id="eco_grabar" value="insert_ok"/>';
    }
}

public function eliminar_actividad_horario(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    
    $id_hr      = isset($_GET['id_hr'])?$_GET['id_hr']:null;
    $id_activ   = isset($_GET['id_activ'])?$_GET['id_activ']:null;
    $detalle    = guardian($_GET['detalle']);
    $horario    = isset($_GET['horario'])?$_GET['horario']:null;    
  
    $sql ="SELECT * FROM actividad_horario ";
    $sql.="WHERE id_hr='".$id_hr."' AND id_activ='".$id_activ."'";
    $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
    
    if (mysql_num_rows($run_sql)){
    	$sql ="DELETE FROM actividad_horario ";
        $sql.="WHERE id_hr='".$id_hr."' AND id_activ='".$id_activ."'";
        
        $run_sql=mysql_query($sql) or die ('<center><label class="msn_err">No se puede eliminar porque hay datos vinculados<br/>
                                            ID: '.$id_hr.' &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;
                                            Detalle: '.$detalle.' &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;                      
                                            Horario: '.$horario.'</b></label></center>');
                                                 
        echo '<input type="hidden" id="eco_eliminar" value="delete_ok"/>';
    }else{
        echo '<input type="hidden" id="eco_eliminar" value="err_delete"/>';
    }
}

public function grilla_actividad_horario(){  
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    $id_activ = isset($_GET['id_activ'])?$_GET['id_activ']:null;
    
    //Cabecera Grilla
    echo '       
    <table width="80%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr class="tabla_head">
        <td></td>
        <td></td>
        <td colspan="2" align="center">Horario</td>
        <td></td>
    </tr>
    
    <tr class="tabla_head">
        <td align="center" width="9%">ID</td>
        <td align="center" width="60%">Detalle</td>
        <td align="center" width="15%" style="border-top:1px solid #ffffff;border-left:1px solid #ffffff;">Ingreso</td>
        <td align="center" width="15%" style="border-top:1px solid #ffffff;border-right:1px solid #ffffff;">Salida</td>
        <td width="1%"></td> 
    </tr>';
     
    //Datos Grilla
    $sql ="SELECT ";
    $sql.="actividad_horario.id_hr, ";
    $sql.="actividad_horario.id_activ, ";
    $sql.="actividad_horario.detalle, ";
    $sql.="actividad_horario.hr_ini, ";
    $sql.="actividad_horario.hr_fin, ";
    $sql.="actividad_horario.reg_rut, ";
    $sql.="actividad_horario.reg_fecha ";
    $sql.="FROM actividad_horario ";
    $sql.="WHERE id_activ='".$id_activ."' ";
    $sql.="ORDER BY detalle";
    
    $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());                    
    			
    if (mysql_num_rows($run_sql)){
        $n_row=0;
        $color_fila=1;
        while($row=mysql_fetch_array($run_sql)){    
            $n_row++;
                                    
            //Seleccion para este formulario
            $seleccion ="'".$row['id_hr']."',";
            $seleccion.="'".$row['detalle']."',";
            $seleccion.="'".date('H',strtotime($row['hr_ini']))."',";
            $seleccion.="'".date('i',strtotime($row['hr_ini']))."',";
            $seleccion.="'".date('H',strtotime($row['hr_fin']))."',";
            $seleccion.="'".date('i',strtotime($row['hr_fin']))."',";         
            
            if ($color_fila==1){
                echo '<tr class="tabla_datos1" onclick="selecc_actividad_horario('.$seleccion.');">';
                $color_fila=2;
                
            }else if ($color_fila==2){           
                echo '<tr class="tabla_datos2" onclick="selecc_actividad_horario('.$seleccion.');">';
                $color_fila=1;
            }
 
            echo '
            <td align="center">'.$row['id_hr'].'</td>
            <td align="center">'.$row['detalle'].'</td>
            <td align="center">'.date('H:i',strtotime($row['hr_ini'])).'</td>
            <td align="center">'.date('H:i',strtotime($row['hr_fin'])).'</td>
            <td></td>
            </tr>';
        }     
            echo '
            <tr class="tabla_head"><th colspan="5" align="center">Cantidad de registros: '.$n_row.'</th> </tr>';
                                
    }else{            
            echo '
            <tr class="tabla_datos1"><td colspan="5" ><center>No se encontraron resultados</center></td> </tr>';
    }
   echo '
   </table>';
}
############################################################################################################
} // FIN CASE CLASS
?>