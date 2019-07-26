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

$actividad_archivo= new actividad_archivo();
switch($op){
    case'1':
        $actividad_archivo->inicio_actividad_archivo();
        break;
        
    case'2':
        $actividad_archivo->opciones_actividad_archivo();
        break;
}

class actividad_archivo{

###########################################################################################################
public function inicio_actividad_archivo(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    $id_activ = isset($_GET['id_activ'])?$_GET['id_activ']:null; 
        
    echo '
    <div id="titulo" class="titulo1">Archivos</div>';
    
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
                <td class="etq2" width="33%">ID Actividad:          <label class="etq1" id="id_activ">'.$row['id_activ'].'</label></td>
                <td class="etq2" width="33%">Empresa:               <label class="etq1">'.$row['rut_empr'].' / '.$row['nombre'].'</label></td>
                <td class="etq2" width="33%">Actividad:             <label class="etq1">'.$row['nom_activ'].'</label></td>           
            </tr>
            
            <tr>
                <td class="etq2">Actividad:                         <label class="etq1">'.$row['nom_tipo_activ'].'</label></td>
                <td class="etq2">Lugar Salida:                      <label class="etq1">'.$row['lugar_salida'].'</label></td>
                <td class="etq2">Comuna:                            <label class="etq1">'.$row['nom_comuna'].'</label></td>
            </tr>
            
            <tr>
                <td class="etq2" colspan="3">Descripci&oacute;n:    <label class="etq1">'.$row['descripcion'].'</label></td>      
            </tr>
            </table>';      
            
            //FORMULARIO
            echo '   
            <FORM id="form_arch" name="form_arch" action="actividad_archivo.php?op=2" method="post" enctype="multipart/form-data">
            
            <input type="hidden" id="id_activ" name="id_activ" value="'.$row['id_activ'].'"/>
            <input type="hidden" id="rut_empr" name="rut_empr" value="'.$row['rut_empr'].'"/>
            
            <table width="95%" border="0" cellspacing="0" cellpadding="0" class="etq1" align="center" >
            <tr height="80px">
            
                <td width="45%" align="center">                                    
                    <input type="file" name="archivo" id="archivo" class="etq1"/>                         
                </td>
                
                <td width="10%" align="center">                    
                    <input type="submit" id="bt_upload" name="bt_upload" title="Subir Archivo" value="&nbsp;" class="bt_upload"/>
                    <br/>Subir   
                </td>
                
                <td width="45%" align="center">                   
                    Formatos: <label style="color:green;">Jpg, Png y Mp4</label> &#8212; Tama&ntilde;o M&aacute;ximo: <label style="color:green;">30.000.000 KB</label>
                </td>
            </tr>
            
            <tr><td colspan="3"><hr size="1" color="#6E6E6E"></td></tr>
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
        $sql.="actividad_archivo.id_activ, ";
        $sql.="actividad_archivo.nom_arch, ";
        $sql.="actividad_archivo.tipo_arch, ";
        $sql.="actividad_archivo.tam_arch, ";
        $sql.="actividad_archivo.reg_rut, ";
        $sql.="man_usuario.nombre, ";        
        $sql.="actividad_archivo.reg_fecha ";
        $sql.="FROM actividad_archivo ";
        $sql.="INNER JOIN man_usuario ON actividad_archivo.reg_rut = man_usuario.rut ";
        $sql.="WHERE id_activ='".$id_activ."' ";
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
                <td align="center"><a href="arch/actividad/'.$archivo.'" target="preview"/>';
                    if ($row['tipo_arch']=="video/mp4"){
                        echo '<br/><img src="img/icono_video.png" width="40" height="40"></a><br/>'.$archivo.'<br/><br/>';
                    }else{
                        echo '<br/><img src="arch/actividad/'.$archivo.'" width="40" height="40"></a><br/>'.$archivo.'<br/><br/>';
                    }
                    
                echo '
                </td>
                <td align="center">'.date("d-m-Y H:i",strtotime($row['reg_fecha'])).'</td>
                <td align="center">'.number_format($row['tam_arch']).'</td>
                <td align="center">'.$row['nombre'].'</td>             
                <td align="center">                
                    <a href="actividad_archivo.php?op=2&bt_eliminar=true&id_activ='.$id_activ.'&nom_archivo='.$archivo.'" onclick="return eliminar_archivo('."'".$archivo."'".')"/>Eliminar</a>
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
            ?><script>opener.document.getElementById('form_actividad').bt_reload.onclick();</script><?php
        }
        
        $_SESSION['eco_archivo']="";         
    
    }else{//EndIf Existe ID
        echo '<br/><center><label class="msn_err"">Ha habido un error al cargar los datos. <br/> O se ha excedido el limite de tiempo para la carga.<br/>Comuniquese con soporte.</label></center>';
    }
}

public function opciones_actividad_archivo(){   
    require_once ("func/cnx.php");
    $cnx=conexion();
    $_SESSION['eco_archivo'] = "";
    $ruta       = 'arch/actividad/';
    
    //ACCION = UPLOAD
    IF (isset($_POST['bt_upload'])?$_POST['bt_upload']:null){
        $id_activ   = isset($_POST['id_activ'])?$_POST['id_activ']:null;
        $rut_empr   = isset($_POST['rut_empr'])?$_POST['rut_empr']:null;
    
        $file_nombre = $_FILES["archivo"]["name"];
    	$file_tipo   = $_FILES["archivo"]["type"];
        $file_tmp    = $_FILES["archivo"]["tmp_name"];
    	$file_tam    = $_FILES["archivo"]["size"];
        
        ##################################################################
        $file_nombre    = (guardian2($file_nombre));
            
        $nom_archivo = "activ".$id_activ."_".$rut_empr."_".$file_nombre;
        ##################################################################
        
        if ($id_activ==""){
            $_SESSION['eco_archivo']="No se ha definido actividad.";
            
        }elseif($file_tipo!="image/jpeg" AND $file_tipo!="image/png" AND $file_tipo!="video/mp4"){
            $_SESSION['eco_archivo']="La extension del archivo no es valida.";
            
        }elseif($file_tam>"30000000"){
            $_SESSION['eco_archivo']="El tama&ntilde;o del archivo es muy grande.";
        }else{
            
            $sql="SELECT * FROM actividad_archivo WHERE nom_arch='".$nom_archivo."' AND id_activ='".$id_activ."'";
            $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
            if (mysql_num_rows($run_sql)){                           
                 $_SESSION['eco_archivo']="Ya existe un archivo cargado con este nombre.";
            }else{
                if (move_uploaded_file($file_tmp, $ruta.$nom_archivo)){
                    $sql="INSERT INTO actividad_archivo(";                
                        $sql.="id_activ,";
                        $sql.="nom_arch,";
                        $sql.="tipo_arch,";
                        $sql.="tam_arch,";         
                        $sql.="reg_rut,";
                        $sql.="reg_fecha) ";
                    $sql.="VALUES (";
                        $sql.="'".$id_activ."',";
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
        $id_activ       = isset($_GET['id_activ'])?$_GET['id_activ']:null;
        $nom_archivo    = utf8_decode(isset($_GET['nom_archivo'])?$_GET['nom_archivo']:null);
        
        if ($id_activ==""){
            $_SESSION['eco_archivo']="No se ha definido actividad.";
            
        }else{
            $sql="SELECT * FROM actividad_archivo WHERE nom_arch='".$nom_archivo."' AND id_activ='".$id_activ."'";
            $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
            if (mysql_num_rows($run_sql)){
      		    $sql = "DELETE FROM actividad_archivo ";
                $sql.= "WHERE nom_arch='".$nom_archivo."' AND id_activ='".$id_activ."'";
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
    header("Location: actividad_archivo.php?op=1&id_activ=".$id_activ);
}
############################################################################################################
} // FIN CASE CLASS
?>