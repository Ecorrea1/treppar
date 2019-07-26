<?php
session_start();

require_once ("func/cnx.php");
$op = isset($_GET['op'])?$_GET['op']:null;
?>

<?php
####################################

$tour_actividad= new tour_actividad();
switch($op){
    case'1':
        $tour_actividad->grilla_actividad_pc();
        break;
        
    case'2':
        $tour_actividad->grilla_actividad_movil();
        break;
}

class tour_actividad{

###########################################################################################################


public function grilla_actividad_pc(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    
    $width  = isset($_GET['w'])?$_GET['w']:null;
    $height = isset($_GET['h'])?$_GET['h']:null;
    
    $_SESSION['ancho_celda']    = (int)($width/2)."px";
    $_SESSION['alto_celda']     = (int)(($_SESSION['ancho_celda']/3)*2)."px";
    
    $ciudad         = isset($_GET['ciudad'])?$_GET['ciudad']:null;
    $id_tipo_activ  = isset($_GET['id_tipo_activ'])?$_GET['id_tipo_activ']:null;    
    
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
    $sql.="actividad.id_activ, ";
    $sql.="actividad.nom_activ, ";
    $sql.="actividad.id_tipo_activ, ";
    $sql.="man_tipo_actividad.nom_tipo_activ, ";
    $sql.="actividad.id_comuna, ";
    $sql.="man_comuna.nom_comuna, ";
    $sql.="actividad.duracion_hr, ";
    $sql.="actividad.duracion_dia, ";
    $sql.="actividad.precio_adultojoven, ";
    $sql.="actividad.dolar_adultojoven, ";
    $sql.="actividad.dscto_adultojoven ";
    $sql.="FROM actividad ";
    $sql.="INNER JOIN man_tipo_actividad ON actividad.id_tipo_activ = man_tipo_actividad.id_tipo_activ ";
    $sql.="INNER JOIN man_comuna ON actividad.id_comuna = man_comuna.id_comuna ";
        
    $filtro = "";
    
    if ($ciudad!=""){
        $filtro.=" man_comuna.nom_comuna = '".$ciudad."'";   
    }    
    
    if ($id_tipo_activ!="*.all"){
    	if ($filtro!=""){
    		$filtro.=" AND";
    	}
    	$filtro.=" actividad.id_tipo_activ = '".$id_tipo_activ."'";
    }
    
    if($filtro!=""){
       $sql.=" WHERE ".$filtro;
    }
    
    $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());
    
    if (mysql_num_rows($run_sql)){
        $col=0;            
        echo '
        <br/>
        <div class="titulo">ACTIVIDADES</div>
        <table width="100%" border="0" cellspacing="10" cellpadding="0" align="center">';
           
        while($row=mysql_fetch_array($run_sql)){
            
            $precio_adultojoven = ($row['precio_adultojoven'] -( ($row['precio_adultojoven']*$row['dscto_adultojoven']/100) ));
            $precio_adultojoven = $precio_adultojoven + ( ($precio_adultojoven*$porc_cobro_gestion) / 100  );
            
            ####################################################################################
            $sql2 ="SELECT ";
            $sql2.="actividad_archivo.id_activ, ";
            $sql2.="actividad_archivo.nom_arch, ";
            $sql2.="actividad_archivo.tipo_arch ";
            $sql2.="FROM actividad_archivo ";   
            $sql2.="WHERE id_activ='".$row['id_activ']."' AND tipo_arch<>'video/mp4' ";
            $sql2.="ORDER BY nom_arch ";
            $sql2.="LIMIT 1";                
            $run_sql2=mysql_query($sql2) or die ('ErrorSql > '.mysql_error ());                
            
            if (mysql_num_rows($run_sql2)){
                while($row2=mysql_fetch_array($run_sql2)){
                    $img="background-image:url('../admin/app/arch/actividad/".$row2['nom_arch']."');background-repeat:no-repeat;background-size: 100% 100%;";           
                }
            }else{
                $img="";
            }            
            
            ####################################################################################
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
            ####################################################################################

            if ($img!=""){
                $col++;
                
                if ($col=="1"){
                    echo '
                    <tr valign="top">
                    <td width="'.$_SESSION['ancho_celda'].'" height="'.$_SESSION['alto_celda'].'" align="center" style="'.$img.'; border:3px solid #000; border-radius:10px;"/>';
                        echo '<div class="contenedor">';
                        echo '<label class="etq_producto">'.$row['nom_activ']." - ".$row['nom_comuna'].'</label>';                            
                        echo '<label class="etq_datox">'.$duracion.'</label>';
                        echo '<label class="etq_precio">$'.number_format($precio_adultojoven, 0, ",", ".").'</label>';
                        echo '<label class="etq_detalle" onclick="go_actividad_detalle('."'".$row['id_activ']."'".');">Ver Mas</label>';
                        echo '<label class="etq_reservar" onclick="go_actividad_reservar('."'".$row['id_activ']."'".');">Reservar</label>';
                        echo '</div>';
                    echo '
                    <br/>
                    </td>';
                    
                }elseif ($col=="2"){
                    echo '
                    <td width="'.$_SESSION['ancho_celda'].'" height="'.$_SESSION['alto_celda'].'" align="center" style="'.$img.'; border:3px solid #000; border-radius:10px;"/>';
                        echo '<div class="contenedor">';
                        echo '<label class="etq_producto">'.$row['nom_activ']." - ".$row['nom_comuna'].'</label>';                            
                        echo '<label class="etq_datox">'.$duracion.'</label>';
                        echo '<label class="etq_precio">$'.number_format($precio_adultojoven, 0, ",", ".").'</label>';
                        echo '<label class="etq_detalle" onclick="go_actividad_detalle('."'".$row['id_activ']."'".');">Ver Mas</label>';
                        echo '<label class="etq_reservar" onclick="go_actividad_reservar('."'".$row['id_activ']."'".');">Reservar</label>';
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
        
        echo '    
        <table width="100%" border="0" cellspacing="2" cellpadding="0" align="center" class="texto_trepadores">
        <tr>
            <td align="center">
                <center><b><u>Recomendaci&oacute;n General para Trepadores</u></b></center><br/>   
                Cada actividad, tiene condiciones especiales de realizaci&oacute;n, como por ejemplo, el uso de ropa y calzado adecuado a la
                actividad. Es deber del participante, llevar la indumentaria adecuada al efecto. Algunos operadores, entregan indumentaria 
                de seguridad, como cascos, Guantes, rodilleras, etc.. Adem&aacute;s, se sugiere la compra de un seguro, a todo evento, 
                en caso de sufrir alg&uacute;n tipo de accidente, para los turistas extranjeros, es siempre recomendable. Si ya estas de
                acuerdo con esta instrucciones, el paso siguiente en convertirte en un Trepador.
                <br/><br/>
                <i>
                VIVE LA AVENTURA TREPAR<br/>
                FUN LIIVE</i>
            </td>
        </tr>
        </table>';
}
############################################################################################################
############################################################################################################
############################################################################################################
############################################################################################################
public function grilla_actividad_movil(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    
    $ciudad         = isset($_GET['ciudad'])?$_GET['ciudad']:null;
    $id_tipo_activ  = isset($_GET['id_tipo_activ'])?$_GET['id_tipo_activ']:null;
    
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
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    $sql ="SELECT ";
    $sql.="actividad.id_activ, ";
    $sql.="actividad.nom_activ, ";
    $sql.="actividad.id_tipo_activ, ";
    $sql.="man_tipo_actividad.nom_tipo_activ, ";
    $sql.="actividad.id_comuna, ";
    $sql.="man_comuna.nom_comuna, ";
    $sql.="actividad.duracion_hr, ";
    $sql.="actividad.duracion_dia, ";
    $sql.="actividad.precio_adultojoven, ";
    $sql.="actividad.dolar_adultojoven, ";
    $sql.="actividad.dscto_adultojoven ";
    $sql.="FROM actividad ";
    $sql.="INNER JOIN man_tipo_actividad ON actividad.id_tipo_activ = man_tipo_actividad.id_tipo_activ ";
    $sql.="INNER JOIN man_comuna ON actividad.id_comuna = man_comuna.id_comuna ";
    
    $filtro = "";
    
    if ($ciudad!=""){
        $filtro.=" man_comuna.nom_comuna = '".$ciudad."'";   
    }    
    
    if ($id_tipo_activ!="*.all"){
    	if ($filtro!=""){
    		$filtro.=" AND";
    	}
    	$filtro.=" actividad.id_tipo_activ = '".$id_tipo_activ."'";
    }
    
    if($filtro!=""){
       $sql.=" WHERE ".$filtro;
    }
    
    $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());

        if (mysql_num_rows($run_sql)){                
            echo '
            <br/>
            <div class="titulo">ACTIVIDADES</div>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">';
               
            while($row=mysql_fetch_array($run_sql)){
                
                $precio_adultojoven = ($row['precio_adultojoven'] -( ($row['precio_adultojoven']*$row['dscto_adultojoven']/100) ));
                $precio_adultojoven = $precio_adultojoven + ( ($precio_adultojoven*$porc_cobro_gestion) / 100  );
                
                ####################################################################################
                $sql2 ="SELECT ";
                $sql2.="actividad_archivo.id_activ, ";
                $sql2.="actividad_archivo.nom_arch, ";
                $sql2.="actividad_archivo.tipo_arch ";
                $sql2.="FROM actividad_archivo ";   
                $sql2.="WHERE id_activ='".$row['id_activ']."' AND tipo_arch<>'video/mp4' ";
                $sql2.="ORDER BY nom_arch ";
                $sql2.="LIMIT 1";                
                $run_sql2=mysql_query($sql2) or die ('ErrorSql > '.mysql_error ());                
                
                if (mysql_num_rows($run_sql2)){
                    while($row2=mysql_fetch_array($run_sql2)){
                        $img='<img src="../admin/app/arch/actividad/'.$row2['nom_arch'].'" style="width:100%; border-radius:10px">';       
                    }
                }else{
                    $img="";
                }
                
                ####################################################################################
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
                ####################################################################################              
                
                if ($img!=""){                    
                    echo '
                    <tr valign="top">
                    <td width="100%" align="center">';                       
                        echo '<div class="contenedor">';                                
                        echo $img;
                        echo '<label class="etq_producto">'.$row['nom_activ']." - ".$row['nom_comuna'].'</label>';                                          
                        echo '<label class="etq_datox">'.$duracion.'</label>';
                        echo '<label class="etq_precio">$'.number_format($precio_adultojoven, 0, ",", ".").'</label>';
                        echo '<label class="etq_detalle" onclick="go_actividad_detalle('."'".$row['id_activ']."'".');">Ver Mas</label>';
                        echo '<label class="etq_reservar" onclick="go_actividad_reservar('."'".$row['id_activ']."'".');">Reservar</label>';
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
        
        echo '    
        <table width="100%" border="0" cellspacing="2" cellpadding="0" align="center" class="texto_trepadores">
        <tr>
            <td align="center">
                <center><b><u>Recomendaci&oacute;n General para Trepadores</u></b></center><br/>   
                Cada actividad, tiene condiciones especiales de realizaci&oacute;n, como por ejemplo, el uso de ropa y calzado adecuado a la
                actividad. Es deber del participante, llevar la indumentaria adecuada al efecto. Algunos operadores, entregan indumentaria 
                de seguridad, como cascos, Guantes, rodilleras, etc.. Adem&aacute;s, se sugiere la compra de un seguro, a todo evento, 
                en caso de sufrir alg&uacute;n tipo de accidente, para los turistas extranjeros, es siempre recomendable. Si ya estas de
                acuerdo con esta instrucciones, el paso siguiente en convertirte en un Trepador.
                <br/><br/>
                <i>
                VIVE LA AVENTURA TREPAR<br/>
                FUN LIIVE</i>
            </td>
        </tr>
        </table>';
}

############################################################################################################
} // FIN CASE CLASS
?>