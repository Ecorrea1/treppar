<?php
session_start();
?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>turismo</title>
    <!-- icono Web -->
    <link href="img/icono_web.png" type="image/x-icon" rel="shortcut icon"/>
    <!-- ajax -->
    <script src="func/ajax.js" type="text/javascript"></script>
    <!-- jquery - alert - confirm-->
    <script src="func/jquery.min.js" type="text/javascript"></script>
    <script src="func/jquery.alerts.js" type="text/javascript"></script>
    <link href="func/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen"/>
    
    <!-- Bootstrap-->    
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" media="screen"/>
    <!-- Bootstrap carrusel imagenes-->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
 
    <!--formatos - validaciones -->
    <link href="css/formato_tour.css" type="text/css" rel="stylesheet"  media="screen"/>
    <link href="css/formato_traductor.css" type="text/css" rel="stylesheet"  media="screen"/>
    <script src="func/validaciones.js" type="text/javascript"></script>

      <!--Google translate --> 
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
   
</head>
<body class="body">    

<?php
require_once ("func/cnx.php");

$op = isset($_GET['op'])?$_GET['op']:null;

$activ_detalle= new activ_detalle();
switch($op){
    case'1':
        $activ_detalle->inicio_activ_detalle();
        break;
}

class activ_detalle{

###########################################################################################################
public function inicio_activ_detalle(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    $id_activ = isset($_GET['id_activ'])?$_GET['id_activ']:null; 
    
    //Datos Grilla
    $sql ="SELECT ";
    $sql.="actividad.id_activ, ";
    $sql.="actividad.rut_empr, ";    
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
    $sql.="actividad.hr_inicio ";
    
    $sql.="FROM actividad ";    
    $sql.="INNER JOIN man_tipo_actividad ON actividad.id_tipo_activ = man_tipo_actividad.id_tipo_activ ";
    $sql.="INNER JOIN man_comuna ON actividad.id_comuna = man_comuna.id_comuna ";
    $sql.="WHERE id_activ='".$id_activ."'";
    $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());                 
                
    if (mysql_num_rows($run_sql)){
        while($row=mysql_fetch_array($run_sql)){
            #######################################################################################################        
            //Titulo
            echo '

            <div id="google_translate_element" class="traductor"></div>
            <div class="titulo">'.$row['nom_activ'].' - '.$row['nom_comuna'].'</div>';
            
            //Descripcion
            echo '
            <TABLE width="98%" border="0" cellpadding="0" cellspacing="0" align="center" class="tabla_fondo">
            <TR><TD><br>';  
                   
                echo '
                <table width="98%" border="0" cellpadding="0" cellspacing="0" align="center">
                <tr>
                    <td width="2%"></td>
                    <td width="49%" class="etq_dato" align="justify">'.$row['descripcion'].'</label></td>';                        
                              
                        $sql2 ="SELECT nom_arch ";               
                        $sql2.="FROM actividad_archivo ";              
                        $sql2.="WHERE id_activ='".$id_activ."' ";
                        $sql2.="ORDER BY nom_arch ";
                        $sql2.="LIMIT 1"; 
                        $run_sql2=mysql_query($sql2) or die ('ErrorSql > '.mysql_error ()); 
                
                        if (mysql_num_rows($run_sql2)){
                            while($row2=mysql_fetch_array($run_sql2)){             
                                $img='<img src="../admin/app/arch/actividad/'.$row2['nom_arch'].'" width="60%" style="border-radius:10px;">';
                            }                              
                            
                        }else{
                            $img="";
                        }
                        ####################################################################################
                        
                        if ($img!=""){                               
                            echo '<td width="49%" align="center" valign="center">'.$img.'</td>'; 
                        }else{
                            echo '<td width="49%"</td>';                         
                        }
                echo '    
                </tr>                  
                </table><br/>';
                    
            echo '
            </TD>
            </TR>
            </TABLE><br/>';
            
            //Sugerencias
            echo '
            <TABLE width="98%" border="0" cellpadding="0" cellspacing="0" align="center" class="tabla_fondo">
            <TR><TD>';
            
                echo '
                <table width="98%" border="0" cellpadding="0" cellspacing="0" align="center">
                <tr valign="top">
                    <td align="center">
                        <label class="etq_head">Sugerencias:</label><br/>
                        <label class="etq_dato">'.$row['sugerencia'].'</label>
                    </td>
                </tr>           
                </table>';
                
            echo '
            </TD>
            </TR>
            </TABLE><br/>';
            
            //Requisitos
            echo '
            <TABLE width="98%" border="0" cellpadding="0" cellspacing="0" align="center" class="tabla_fondo">
            <TR><TD>';
            
                echo '
                <table width="98%" border="0" cellpadding="0" cellspacing="0" align="center">
                <tr valign="top">
                    <td width="33%" align="center">
                        <label class="etq_head">Requisitos:</label><br/>
                        <label class="etq_dato">'.$row['requisito'].'</label>
                    </td>
                    
                    <td width="33%" align="center">
                        <label class="etq_head">Edad M&iacute;nima:</label><br/>
                        <label class="etq_dato">'.$row['edad_minima'].'</label>
                    </td>
                    
                    <td width="33%" align="center">
                        <label class="etq_head">Dificultad:</label><br/>
                        <label class="etq_dato">';               
                            if ($row['dificultad']==1){
                                echo "Bajo";
                            }elseif ($row['dificultad']==2){
                                echo "Medio";
                            }elseif ($row['dificultad']==3){
                                echo "Alto";
                            }
                        echo '
                        </label>
                    </td>
                </tr>           
                </table>';
                
            echo '
            </TD>
            </TR>
            </TABLE><br/>';
            
            //Duracion / Lugar / Hora Salida
            echo '
            <TABLE width="98%" border="0" cellpadding="0" cellspacing="0" align="center" class="tabla_fondo">
            <TR><TD>';
            
                echo '
                <table width="98%" border="0" cellpadding="0" cellspacing="0" align="center">
                <tr valign="top">
                    <td width="33%" align="center">
                        <label class="etq_head">Lugar Salida:</label><br/>
                        <label class="etq_dato">'.$row['lugar_salida'].'</label>
                    </td>
                    
                    <td width="33%" align="center">
                        <label class="etq_head">Duraci&oacute;n:</label><br/>';
                        
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
                        ####################################################################################
                        
                        echo '<label class="etq_dato">'.$duracion.'</label>'; 
                        ####################################################################################
                        ####################################################################################   
                        echo '
                    </td>
                    
                    <td width="33%" align="center">
                        <label class="etq_head">Hora Inicio:</label><br/>
                        <label class="etq_dato">'.date('H:i',strtotime($row['hr_inicio'])).' Horas</label>
                    </td>
                </tr>           
                </table><BR/>';
                
            echo '
            </TD>
            </TR>
            
            <TR>
            <TD ALIGN="CENTER">
                <hr style="border: 1px solid #e67e22;">         
                <input type="button" value="Reservar" class="bt_morado" onclick="location.href='."'tour_actividad_reservar.php?op=1&id_activ=".$id_activ."'".';"/>
                <br/><br/>
            </TD>
            </TR>
            </TABLE><br/>';
            
            //Carrusel Imagenes
            echo '
            <TABLE width="98%" border="0" cellpadding="0" cellspacing="0" align="center" class="tabla_fondo">
            <TR><TD>';
            
                echo '
                <br/>
                <table width="98%" border="0" cellpadding="0" cellspacing="0" align="center">
                <tr valign="top">
                    <td align="center">';
                    
                    echo '
                    <DIV id="imag" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">';
                        
                            //CONT ARCH
                            $sql2=" SELECT COUNT(*) AS cont_arch FROM actividad_archivo ";
                            $sql2.="WHERE id_activ='".$row['id_activ']."' AND tipo_arch<>'video/mp4'";
                            $run_sql2=mysql_query($sql2) or die ('ErrorSql > '.mysql_error ());                     
                            if (mysql_num_rows($run_sql2)){                                        
                                while($row2=mysql_fetch_array($run_sql2)){
                                    $cont_arch=$row2['cont_arch'];
                                }                    
                                if ($cont_arch=="0"){
                                    $cont_arch=" ";
                                }
                            }
                        
                            $sql2 ="SELECT ";        
                            $sql2.="actividad_archivo.id_activ, ";
                            $sql2.="actividad_archivo.nom_arch, ";
                            $sql2.="actividad_archivo.tipo_arch, ";
                            $sql2.="actividad_archivo.tam_arch ";              
                            $sql2.="FROM actividad_archivo ";          
                            $sql2.="WHERE id_activ='".$row['id_activ']."' AND tipo_arch<>'video/mp4'";
                            $sql2.="ORDER BY nom_arch ";                  
                            $run_sql2=mysql_query($sql2) or die ('ErrorSql > '.mysql_error ());                            
                            $n=1;
                            
                            if (mysql_num_rows($run_sql2)){     
                                while($row2=mysql_fetch_array($run_sql2)){
                                    
                                    if ($n==1){                                        
                                        echo '                                        
                                        <div class="carousel-item active"><label class="etq_nfoto">'.$n.' / '.$cont_arch.'</label>
                                        <img class="d-block w-60" src="../admin/app/arch/actividad/'.$row2['nom_arch'].'" style="border-radius:10px;">
                                        </div>';
                            
                                    }else{
                                        echo '                                        
                                        <div class="carousel-item"><label class="etq_nfoto">'.$n.' / '.$cont_arch.'</label>
                                        <img class="d-block w-60" src="../admin/app/arch/actividad/'.$row2['nom_arch'].'" style="border-radius:10px;">
                                        </div>';                            
                                    }                                    
                                    $n++;                              
                                }
                            }
                        echo '  
                        </div>                                                  
                        <a class="carousel-control-prev" href="#imag" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Anterior</span>
                        </a>
                        
                        <a class="carousel-control-next" href="#imag" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Siguiente</span>
                        </a>
                    </DIV>';

                        
                    echo '
                    </td>
                </tr>           
                </table><br/><br/><br/>';
                
            echo '
            </TD>
            </TR>
            </TABLE><br/><br/>';
        }
    }
}
############################################################################################################
} // FIN CASE CLASS
?>