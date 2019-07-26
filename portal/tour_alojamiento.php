<?php
session_start();

require_once ("func/cnx.php");
$op = isset($_GET['op'])?$_GET['op']:null;
?>


<?php
####################################

$tour_alojamiento= new tour_alojamiento();
switch($op){
    case'1':
        $tour_alojamiento->grilla_alojamiento_pc();
        break;
        
    case'2':
        $tour_alojamiento->grilla_alojamiento_movil();
        break;
}

class tour_alojamiento{

###########################################################################################################


public function grilla_alojamiento_pc(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");    
    
    $ciudad         = isset($_GET['ciudad'])?$_GET['ciudad']:null;
    $id_tipo_alojam = isset($_GET['id_tipo_alojam'])?$_GET['id_tipo_alojam']:null;
    
    $width  = isset($_GET['w'])?$_GET['w']:null;
    $height = isset($_GET['h'])?$_GET['h']:null;
    
    $_SESSION['ancho_celda']    = (int)($width/2)."px";
    $_SESSION['alto_celda']     = (int)(($_SESSION['ancho_celda']/3)*2)."px";
    
    ////////////////////////////////////////////////////////////////////////////////////////
    $sql="SELECT ";
    $sql.="man_parametros.id, ";
    $sql.="man_parametros.porc_cobro_gestion ";
    $sql.="FROM man_parametros ";
    $sql.="WHERE id='1'";  
    $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());    
    if (mysql_num_rows($run_sql)){
        while($row=mysql_fetch_array($run_sql)){
            $porc_cobro_gestion = $row['porc_cobro_gestion'];
        }
    }else{
        $porc_cobro_gestion = "0";
    }    
    ////////////////////////////////////////////////////////////////////////////////////////
    
    $sql ="SELECT ";
    $sql.="alojam_estab.id_estab, ";
    $sql.="alojam_estab.nom_estab, ";
    $sql.="alojam_estab.tipo_alojam, ";
    $sql.="man_tipo_alojam.nom_tipo_alojam, ";
    $sql.="alojam_estab.estrella, ";
    $sql.="alojam_estab.id_desayuno, ";
    $sql.="man_desayuno.nom_desayuno, ";
    $sql.="alojam_estab.id_comuna, ";
    $sql.="man_comuna.nom_comuna ";
    $sql.="FROM alojam_estab ";
    $sql.="INNER JOIN man_tipo_alojam ON alojam_estab.tipo_alojam = man_tipo_alojam.id_tipo_alojam ";
    $sql.="INNER JOIN man_desayuno ON alojam_estab.id_desayuno = man_desayuno.id_desayuno ";
    $sql.="INNER JOIN man_comuna ON alojam_estab.id_comuna = man_comuna.id_comuna ";
        
    $filtro = "";
    
    if ($ciudad!=""){
        $filtro.=" man_comuna.nom_comuna = '".$ciudad."'";   
    }    
    
    if ($id_tipo_alojam!="@"){
    	if ($filtro!=""){
    		$filtro.=" AND";
    	}
    	$filtro.=" alojam_estab.tipo_alojam = '".$id_tipo_alojam."'";                  
    }
    
    if($filtro!=""){
       $sql.=" WHERE ".$filtro;
    }    
    
    $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());
    
    if (mysql_num_rows($run_sql)){
        $col=0;            
        echo '
        <br/>
        <div class="titulo">ALOJAMIENTOS</div>
        <table width="100%" border="0" cellspacing="10" cellpadding="0" align="center">';
           
        while($row=mysql_fetch_array($run_sql)){  
            
            if ($row['estrella']=="0"){
                $star='';
                
            }else if ($row['estrella']=="1"){                
                $star='<img src="img/star.png">';
                
            }else if ($row['estrella']=="2"){
               $star='<img src="img/star.png"> <img src="img/star.png">';
                
            }else if ($row['estrella']=="3"){
                $star='<img src="img/star.png"> <img src="img/star.png"> <img src="img/star.png">';
                
            }else if ($row['estrella']=="4"){
                $star='<img src="img/star.png"> <img src="img/star.png"> <img src="img/star.png"> <img src="img/star.png">';
                
            }else if ($row['estrella']=="5"){
                $star='<img src="img/star.png"> <img src="img/star.png"> <img src="img/star.png"> <img src="img/star.png"> <img src="img/star.png">';
                
            }
            
            $sql2 ="SELECT MIN(precio) AS precio_min, MAX(precio) AS precio_max ";
            $sql2.="FROM alojam_unidad ";
            $sql2.="WHERE id_estab='".$row['id_estab']."' ";
            $run_sql2=mysql_query($sql2) or die ('ErrorSql > '.mysql_error ());                
            
            if (mysql_num_rows($run_sql2)){
                while($row2=mysql_fetch_array($run_sql2)){
                    $cobrogestion_min   =  (int)(($row2['precio_min']*$porc_cobro_gestion)/100);
                    $precio_min         =  (int) ($row2['precio_min']+$cobrogestion_min);
                    $precio_min         = '$'.number_format($precio_min, 0, ",", ".");
                    
                    $cobrogestion_max   =  (int)(($row2['precio_max']*$porc_cobro_gestion)/100);
                    $precio_max         =  (int) ($row2['precio_max']+$cobrogestion_max);
                    $precio_max         = '$'.number_format($precio_max, 0, ",", ".");
                }
            }else{
                $precio_min = "";
                $precio_max = "";
            }
            
            ####################################################################################
            
            $sql2 ="SELECT MIN(cant_persona) AS min_pers, MAX(cant_persona) AS max_pers ";
            $sql2.="FROM alojam_unidad ";
            $sql2.="WHERE id_estab='".$row['id_estab']."' ";
            $run_sql2=mysql_query($sql2) or die ('ErrorSql > '.mysql_error ());                
            
            if (mysql_num_rows($run_sql2)){
                while($row2=mysql_fetch_array($run_sql2)){
                    $min_pers = $row2['min_pers'];
                    $max_pers = $row2['max_pers'];
                }
            }else{
                $min_pers = "";
                $max_pers = "";
            }
            
            ####################################################################################
            $sql2 ="SELECT ";
            $sql2.="alojam_estab_archivo.id_estab, ";
            $sql2.="alojam_estab_archivo.nom_arch, ";
            $sql2.="alojam_estab_archivo.tipo_arch ";
            $sql2.="FROM alojam_estab_archivo ";   
            $sql2.="WHERE id_estab='".$row['id_estab']."' AND tipo_arch<>'video/mp4' ";
            $sql2.="ORDER BY nom_arch ";
            $sql2.="LIMIT 1";                
            $run_sql2=mysql_query($sql2) or die ('ErrorSql > '.mysql_error ());                
            
            if (mysql_num_rows($run_sql2)){
                while($row2=mysql_fetch_array($run_sql2)){                    
                    $img="background-image:url('../admin/app/arch/alojam_estab/".$row2['nom_arch']."');background-repeat:no-repeat;background-size: 100% 100%;";           
                }
            }else{
                $img="";
            }         
            
            ####################################################################################            

            if ($img!=""){
                $col++;
                
                if ($col=="1"){
                    echo '
                    <tr valign="top">
                    <td width="'.$_SESSION['ancho_celda'].'" height="'.$_SESSION['alto_celda'].'" align="center" style="'.$img.'; border:3px solid #000; border-radius:10px;"/>';
                        echo '<div class="contenedor">';
                        echo '<label class="etq_producto">'.$row['nom_estab'].' '.$star.' - '.$row['nom_comuna'].'</label>';
                        echo '<label class="etq_datox">Desayuno: '.$row['nom_desayuno'].'</label>';
                        echo '<label class="etq_precio">Desde '.$precio_min.'</label>';                    
                        echo '<label class="etq_detalle2" onclick="go_alojamiento_detalle('."'".$row['id_estab']."'".');">Ver Mas</label>';
                        echo '</div>';
                    echo '
                    <br/>
                    </td>';
                    
                }elseif ($col=="2"){
                    echo '
                    <td width="'.$_SESSION['ancho_celda'].'" height="'.$_SESSION['alto_celda'].'" align="center" style="'.$img.'; border:3px solid #000; border-radius:10px;"/>';
                        echo '<div class="contenedor">';
                        echo '<label class="etq_producto">'.$row['nom_estab'].' '.$star.' - '.$row['nom_comuna'].'</label>';
                        echo '<label class="etq_datox">Desayuno: '.$row['nom_desayuno'].'</label>';
                        echo '<label class="etq_precio">Desde '.$precio_min.'</label>';
                        echo '<label class="etq_detalle2" onclick="go_alojamiento_detalle('."'".$row['id_estab']."'".');">Ver Mas</label>';
                        echo '</div>';
                    echo '
                    <br/>
                    </td>
                    </tr>';
                    $col=0;
                }
            }
        }
        
        if ($col=="1"){
            echo '
            <td></td>
            </tr>';
        }
        
        echo '</table>';
    }else{
        echo '<br/><br/><center><label style="font:20px Arial;color:#084B8A;text-shadow: #848484 2px +2px 2px;">No se encontraron resultados.</label></center>';
    }
}
############################################################################################################
############################################################################################################
############################################################################################################
############################################################################################################
public function grilla_alojamiento_movil(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    
    $ciudad         = isset($_GET['ciudad'])?$_GET['ciudad']:null;
    $id_tipo_alojam = isset($_GET['id_tipo_alojam'])?$_GET['id_tipo_alojam']:null;
    
    ////////////////////////////////////////////////////////////////////////////////////////
    $sql="SELECT ";
    $sql.="man_parametros.id, ";
    $sql.="man_parametros.porc_cobro_gestion ";
    $sql.="FROM man_parametros ";
    $sql.="WHERE id='1'";  
    $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());    
    if (mysql_num_rows($run_sql)){
        while($row=mysql_fetch_array($run_sql)){
            $porc_cobro_gestion = $row['porc_cobro_gestion'];
        }
    }else{
        $porc_cobro_gestion = "0";
    }    
    ////////////////////////////////////////////////////////////////////////////////////////
    
    $sql ="SELECT ";
    $sql.="alojam_estab.id_estab, ";
    $sql.="alojam_estab.nom_estab, ";
    $sql.="alojam_estab.tipo_alojam, ";
    $sql.="man_tipo_alojam.nom_tipo_alojam, ";
    $sql.="alojam_estab.estrella, ";
    $sql.="alojam_estab.id_desayuno, ";
    $sql.="man_desayuno.nom_desayuno, ";
    $sql.="alojam_estab.id_comuna, ";
    $sql.="man_comuna.nom_comuna ";
    $sql.="FROM alojam_estab ";
    $sql.="INNER JOIN man_tipo_alojam ON alojam_estab.tipo_alojam = man_tipo_alojam.id_tipo_alojam ";
    $sql.="INNER JOIN man_desayuno ON alojam_estab.id_desayuno = man_desayuno.id_desayuno ";
    $sql.="INNER JOIN man_comuna ON alojam_estab.id_comuna = man_comuna.id_comuna ";
        
    $filtro = "";
    
    if ($ciudad!=""){
        $filtro.=" man_comuna.nom_comuna = '".$ciudad."'";   
    }    
    
    if ($id_tipo_alojam!="@"){
    	if ($filtro!=""){
    		$filtro.=" AND";
    	}
    	$filtro.=" alojam_estab.tipo_alojam = '".$id_tipo_alojam."'";                  
    }
    
    if($filtro!=""){
       $sql.=" WHERE ".$filtro;
    }    
    
    $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());
    
    if (mysql_num_rows($run_sql)){
        echo '
        <br/>
        <div class="titulo">ALOJAMIENTOS</div>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">';
           
        while($row=mysql_fetch_array($run_sql)){
            
            if ($row['estrella']=="0"){
                $star='';
                
            }else if ($row['estrella']=="1"){                
                $star='<img src="img/star.png">';
                
            }else if ($row['estrella']=="2"){
               $star='<img src="img/star.png"> <img src="img/star.png">';
                
            }else if ($row['estrella']=="3"){
                $star='<img src="img/star.png"> <img src="img/star.png"> <img src="img/star.png">';
                
            }else if ($row['estrella']=="4"){
                $star='<img src="img/star.png"> <img src="img/star.png"> <img src="img/star.png"> <img src="img/star.png">';
                
            }else if ($row['estrella']=="5"){
                $star='<img src="img/star.png"> <img src="img/star.png"> <img src="img/star.png"> <img src="img/star.png"> <img src="img/star.png">';
                
            }
            
            $sql2 ="SELECT MIN(precio) AS precio_min, MAX(precio) AS precio_max ";
            $sql2.="FROM alojam_unidad ";
            $sql2.="WHERE id_estab='".$row['id_estab']."' ";
            $run_sql2=mysql_query($sql2) or die ('ErrorSql > '.mysql_error ());                
            
            if (mysql_num_rows($run_sql2)){
                while($row2=mysql_fetch_array($run_sql2)){
                    $cobrogestion_min   =  (int)(($row2['precio_min']*$porc_cobro_gestion)/100);
                    $precio_min         =  (int) ($row2['precio_min']+$cobrogestion_min);
                    $precio_min         = '$'.number_format($precio_min, 0, ",", ".");
                    
                    $cobrogestion_max   =  (int)(($row2['precio_max']*$porc_cobro_gestion)/100);
                    $precio_max         =  (int) ($row2['precio_max']+$cobrogestion_max);
                    $precio_max         = '$'.number_format($precio_max, 0, ",", ".");
                }
            }else{
                $precio_min = "";
                $precio_max = "";
            }
            
            ####################################################################################
            
            $sql2 ="SELECT MIN(cant_persona) AS min_pers, MAX(cant_persona) AS max_pers ";
            $sql2.="FROM alojam_unidad ";
            $sql2.="WHERE id_estab='".$row['id_estab']."' ";
            $run_sql2=mysql_query($sql2) or die ('ErrorSql > '.mysql_error ());                
            
            if (mysql_num_rows($run_sql2)){
                while($row2=mysql_fetch_array($run_sql2)){
                    $min_pers = $row2['min_pers'];
                    $max_pers = $row2['max_pers'];
                }
            }else{
                $min_pers = "";
                $max_pers = "";
            }
            
            ####################################################################################
            $sql2 ="SELECT ";
            $sql2.="alojam_estab_archivo.id_estab, ";
            $sql2.="alojam_estab_archivo.nom_arch, ";
            $sql2.="alojam_estab_archivo.tipo_arch ";
            $sql2.="FROM alojam_estab_archivo ";   
            $sql2.="WHERE id_estab='".$row['id_estab']."' AND tipo_arch<>'video/mp4' ";
            $sql2.="ORDER BY nom_arch ";
            $sql2.="LIMIT 1";                
            $run_sql2=mysql_query($sql2) or die ('ErrorSql > '.mysql_error ());                
            
            if (mysql_num_rows($run_sql2)){
                while($row2=mysql_fetch_array($run_sql2)){
                    $img='<img src="../admin/app/arch/alojam_estab/'.$row2['nom_arch'].'" style="width:100%; border-radius:10px">';                              
                }
            }else{
                $img="";
            }         
            
            ####################################################################################
            
            if ($img!=""){                    
                echo '
                <tr valign="top">
                <td width="100%" align="center">';
                    echo '<div class="contenedor">';                                
                    echo $img;
                    echo '<label class="etq_producto">'.$row['nom_estab'].' '.$star.' - '.$row['nom_comuna'].'</label>';
                    echo '<label class="etq_datox">Desayuno: '.$row['nom_desayuno'].'</label>';
                    echo '<label class="etq_precio">Desde '.$precio_min.'</label>';
                    echo '<label class="etq_detalle2" onclick="go_alojamiento_detalle('."'".$row['id_estab']."'".');">Ver Mas</label>';
                    echo '</div>';
                echo '
                <br/>
                </td>
                </tr>';
            }
        }
        echo '</table>';
    }else{
        echo '<br/><br/><center><label style="font:20px Arial;color:#084B8A;text-shadow: #848484 2px +2px 2px;">No se encontraron resultados.</label></center>';
    }
}

############################################################################################################
} // FIN CASE CLASS
?>