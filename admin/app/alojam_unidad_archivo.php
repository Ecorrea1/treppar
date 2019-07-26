<?php
session_start();

if (!isset($_SESSION['log_rut']) OR !isset($_SESSION['log_nom']) OR !isset($_SESSION['log_tipo'])){
    echo '
    <script>
        opener.document.getElementById("form_home").bt_logout.onclick();
        window.close();
    </script>';
}
?>

<html>
<head>    
    
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
    
    <script>
        function eliminar_archivo(arch){
            return confirm("Esta seguro(a) de eliminar el siguiente archivo?\n"+arch);
        }
    </script>
    
</head>
<body>     

<?php
require_once ("func/cnx.php");

$op = isset($_GET['op'])?$_GET['op']:null;

$alojam_unidad_archivo= new alojam_unidad_archivo();
switch($op){
    case'1':
        $alojam_unidad_archivo->inicio_alojam_unidad_archivo();
        break;
        
    case'2':
        $alojam_unidad_archivo->opciones_alojam_unidad_archivo();
        break;
}

class alojam_unidad_archivo{

###########################################################################################################
public function inicio_alojam_unidad_archivo(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    $id_unidad = isset($_GET['id_unidad'])?$_GET['id_unidad']:null; 
        
    echo '
    <div id="titulo" class="titulo1">Fotos Habitaciones/Caba&ntilde;as/Departamentos (Interior)</div>';
    
    $sql ="SELECT ";
    $sql.="alojam_unidad.id_unidad, ";
    $sql.="alojam_unidad.nom_unidad, ";
    $sql.="alojam_estab.id_estab, ";
    $sql.="alojam_estab.nom_estab, ";
    $sql.="alojam_estab.rut_empr, ";
    $sql.="man_comuna.nom_comuna ";    
    $sql.="FROM alojam_unidad ";
    $sql.="INNER JOIN alojam_estab ON alojam_unidad.id_estab = alojam_estab.id_estab ";
    $sql.="INNER JOIN man_comuna ON alojam_estab.id_comuna = man_comuna.id_comuna ";
    $sql.="WHERE id_unidad='".$id_unidad."' LIMIT 1";
    $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());  
    
    if (mysql_num_rows($run_sql)){
        while($row=mysql_fetch_array($run_sql)){
            echo '            
            <table width="100%" rules="rows" border="0" cellspacing="0" cellpadding="0" class="panel1" align="center">
            <tr>
                <td class="etq2" width="33%">Establecimiento:       <label class="etq1">'.$row['nom_estab'].'</label></td>
                <td class="etq2" width="33%">Comuna:                <label class="etq1">'.$row['nom_comuna'].'</label></td>
                <td class="etq2" width="33%">Nombre:                <label class="etq1">'.$row['nom_unidad'].'</label></td>     
                
            </tr>
            </table>';
            
            //FORMULARIO
            echo '   
            <FORM id="form_arch" name="form_arch" action="alojam_unidad_archivo.php?op=2" method="post" enctype="multipart/form-data">
            
            <input type="hidden" id="id_unidad" name="id_unidad" value="'.$row['id_unidad'].'"/>
            <input type="hidden" id="rut_empr" name="rut_empr" value="'.$row['rut_empr'].'"/>
            
            <table width="95%" border="0" cellspacing="0" cellpadding="0" class="etq1" align="center" >
            <tr height="80px">
                <td width="10%" align="center">  
                    <input type="button" value="&laquo; Volver" class="bt_volver" onclick="location.href='."'alojam_unidad.php?op=1&id_estab=".$row['id_estab']."'".';"/>               
                </td>
                
                <td width="40%" align="center">                                  
                    <input type="file" name="archivo" id="archivo" class="etq1"/>                         
                </td>
                
                <td width="10%" align="center">                    
                    <input type="submit" id="bt_upload" name="bt_upload" title="Subir Archivo" value="&nbsp;" class="bt_upload"/>
                    <br/>Subir   
                </td>
                
                <td width="40%" align="center">                   
                    Formatos: <label style="color:green;">Jpg, Png y Mp4</label> &#8212; Tama&ntilde;o M&aacute;ximo: <label style="color:green;">30.000.000 KB</label>
                </td>
            </tr>
            
            <tr><td colspan="4"><hr size="1" color="#6E6E6E"></td></tr>
            </table>
            <div id="salida"></div> 
            </FORM>';
        }//EndWhile Existe actividad
        
        //DATOS GRILLA
        echo '    
        <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
        
        <tr class="tabla_head">
            <td width="20%" align="center">Archivo</td>
            <td width="20%" align="center">Fecha Ingreso</td>            
            <td width="20%" align="center">Tama&ntilde;o</td>
            <td width="20%" align="center">Subido por</td>
            <td width="20%"></td>
        </tr>';
        
        $sql ="SELECT ";        
        $sql.="alojam_unidad_archivo.id_unidad, ";
        $sql.="alojam_unidad_archivo.nom_arch, ";
        $sql.="alojam_unidad_archivo.tipo_arch, ";
        $sql.="alojam_unidad_archivo.tam_arch, ";
        $sql.="alojam_unidad_archivo.reg_rut, ";
        $sql.="man_usuario.nombre, ";        
        $sql.="alojam_unidad_archivo.reg_fecha ";
        $sql.="FROM alojam_unidad_archivo ";
        $sql.="INNER JOIN man_usuario ON alojam_unidad_archivo.reg_rut = man_usuario.rut ";
        $sql.="WHERE id_unidad='".$id_unidad."' ";
        $sql.="ORDER BY nom_arch";
        $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ()); 
        
        if (mysql_num_rows($run_sql)){
            $n_row=0;
            $color_fila=1;        
            while($row=mysql_fetch_array($run_sql)){
                $n_row++;
                $archivo = $row["nom_arch"];
                //$archivo = guardian($row["nom_arch"]);
                //$archivo = utf8_encode($archivo);                
                
                if ($color_fila==1){
                    echo '<tr class="tabla_datos1">';
                    $color_fila=2;
                    
                }else if ($color_fila==2){           
                    echo '<tr class="tabla_datos2">';
                    $color_fila=1;
                }
                
                echo '                
                <td align="center"><a href="arch/alojam_unidad/'.$archivo.'" target="preview"/>';
                    if ($row['tipo_arch']=="video/mp4"){
                        echo '<br/><img src="img/icono_video.png" width="40" height="40"></a><br/>'.$archivo.'<br/><br/>';
                    }else{
                        echo '<br/><img src="arch/alojam_unidad/'.$archivo.'" width="40" height="40"></a><br/>'.$archivo.'<br/><br/>';
                    }
                    
                echo '
                </td>
                <td align="center">'.date("d-m-Y H:i",strtotime($row['reg_fecha'])).'</td>
                <td align="center">'.number_format($row['tam_arch']).'</td>
                <td align="center">'.$row['nombre'].'</td>             
                <td align="center">                
                    <a href="alojam_unidad_archivo.php?op=2&bt_eliminar=true&id_unidad='.$id_unidad.'&nom_archivo='.$archivo.'" onclick="return eliminar_archivo('."'".$archivo."'".')"/>Eliminar</a>
                </td>
                        
                </tr>';
            }
            
                echo '
                <tr class="tabla_head">
                    <th colspan="5" align="center">
                        Cantidad de registros: '.$n_row.'
                    </th>
                </tr>';
                 
                echo '
                <tr>
                    <td colspan="5">            
                        <iframe name="preview" align="center" scrolling="yes" width="100%" height="500px" style="border:1px solid #A4A4A4;">Preview</iframe>
                    </td>
              </tr>';          
        }else{
            echo '
            <tr class="tabla_datos1">   
                <td colspan="5"><center>No se encontraron resultados</center></td>                                                
            </tr>'; 
        }    
        echo '
        </table>';
        if (isset($_SESSION['eco_archivo'])?$_SESSION['eco_archivo']:null!=""){
            ?><script>javascript:jAlert("<?php echo $_SESSION['eco_archivo']; ?>","Estado Carga")</script><?php
            ?><script>opener.document.getElementById('form_alojamiento').bt_reload.onclick();</script><?php
        }
        
        $_SESSION['eco_archivo']="";         
    
    }else{//EndIf Existe ID
        echo '<br/><center><label class="msn_err"">Ha habido un error al cargar los datos. <br/> O se ha excedido el limite de tiempo para la carga.<br/>Comuniquese con soporte.</label></center>';
    }
}

public function opciones_alojam_unidad_archivo(){   
    require_once ("func/cnx.php");
    $cnx=conexion();
    $_SESSION['eco_archivo'] = "";
    $ruta = 'arch/alojam_unidad/';
    
    //ACCION = UPLOAD
    IF (isset($_POST['bt_upload'])?$_POST['bt_upload']:null){
        $id_unidad  = isset($_POST['id_unidad'])?$_POST['id_unidad']:null;
        $rut_empr   = isset($_POST['rut_empr'])?$_POST['rut_empr']:null;
    
        $file_nombre = $_FILES["archivo"]["name"];
    	$file_tipo   = $_FILES["archivo"]["type"];
        $file_tmp    = $_FILES["archivo"]["tmp_name"];
    	$file_tam    = $_FILES["archivo"]["size"];
        
        ##################################################################
        $file_nombre    = (guardian2($file_nombre));
            
        $nom_archivo = "unidad".$id_unidad."_".$rut_empr."_".$file_nombre;
        ##################################################################
        
        if ($id_unidad==""){
            $_SESSION['eco_archivo']="No se ha definido actividad.";
            
        }elseif($file_tipo!="image/jpeg" AND $file_tipo!="image/png" AND $file_tipo!="video/mp4"){
            $_SESSION['eco_archivo']="La extension del archivo no es valida.";
            
        }elseif($file_tam>"30000000"){
            $_SESSION['eco_archivo']="El tama&ntilde;o del archivo es muy grande.";
        }else{
            
            $sql="SELECT * FROM alojam_unidad_archivo WHERE nom_arch='".$nom_archivo."' AND id_unidad='".$id_unidad."'";
            $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
            if (mysql_num_rows($run_sql)){                           
                 $_SESSION['eco_archivo']="Ya existe un archivo cargado con este nombre.";
            }else{
                if (move_uploaded_file($file_tmp, $ruta.$nom_archivo)){
                    $sql="INSERT INTO alojam_unidad_archivo(";                
                        $sql.="id_unidad,";
                        $sql.="nom_arch,";
                        $sql.="tipo_arch,";
                        $sql.="tam_arch,";         
                        $sql.="reg_rut,";
                        $sql.="reg_fecha) ";
                    $sql.="VALUES (";
                        $sql.="'".$id_unidad."',";
                        $sql.="'".$nom_archivo."',";
                        $sql.="'".$file_tipo."',";
                        $sql.="'".$file_tam."',";           
                        $sql.="'".$_SESSION['log_rut']."',";
                        $sql.="'".date('Y-m-d H:i:s')."')";
                    $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
                        #############################################
                        $fin = "no";      
                        while ($fin=="no"){        
                          if (file_exists($ruta.$nom_archivo) ){
                            $fin = "si";
                          }
                          $_SESSION['eco_archivo']="El archivo fue subido con exito.";
                        }
                        #############################################
                        
                }else{ //Else copy archivo     
                    $_SESSION['eco_archivo']="Hubo un error al subir el archivo.";
                } //EndIf copy archivo
                
                
                
            }//EndIf ya existe archivo con este nombre
                
        }//EndIf validaciones en cadena
         
    }//EndIf bt_upload
    
 
    //ACCION = ELIMINAR
    IF (isset($_GET['bt_eliminar'])?$_GET['bt_eliminar']:null){
        $id_unidad      = isset($_GET['id_unidad'])?$_GET['id_unidad']:null;
        $nom_archivo    = utf8_decode(isset($_GET['nom_archivo'])?$_GET['nom_archivo']:null);
        
        if ($id_unidad==""){
            $_SESSION['eco_archivo']="No se ha definido actividad.";
            
        }else{
            $sql="SELECT * FROM alojam_unidad_archivo WHERE nom_arch='".$nom_archivo."' AND id_unidad='".$id_unidad."'";
            $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
            if (mysql_num_rows($run_sql)){
      		    $sql = "DELETE FROM alojam_unidad_archivo ";
                $sql.= "WHERE nom_arch='".$nom_archivo."' AND id_unidad='".$id_unidad."'";
                $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());            
                
                if(file_exists($ruta.$nom_archivo)){
                    unlink($ruta.$nom_archivo);
                }
                $_SESSION['eco_archivo']="Se ha eliminado el archivo con exito.";
            }else{
                $_SESSION['eco_archivo']="Se esta tratando de eliminar un registro que no existe, verifique informacion y vuelva a intentar.";
            }
        }
    } //FIN ACCION = ELIMINAR
    
    //Retorno
    header("Location: alojam_unidad_archivo.php?op=1&id_unidad=".$id_unidad);
}
############################################################################################################
} // FIN CASE CLASS
?>