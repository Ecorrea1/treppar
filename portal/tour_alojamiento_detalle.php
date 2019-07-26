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
    
    <script language="JavaScript" type="text/JavaScript"> 
        function ver_foto(id_unidad){            
            if (document.getElementById('img'+id_unidad).style.display=="block"){  
                document.getElementById('img'+id_unidad).style.display = "none";
                document.getElementById('btver'+id_unidad).value="+ Ver Fotos";                
            }else{           
                document.getElementById('img'+id_unidad).style.display = "block";
                document.getElementById('btver'+id_unidad).value="- Ocultar Fotos";
            }
        }
    
    </script>
   
</head>
<body class="body">    

<?php
require_once ("func/cnx.php");

$op = isset($_GET['op'])?$_GET['op']:null;

$tour_detalle= new tour_detalle();
switch($op){
    case'1':
        $tour_detalle->inicio_tour_detalle();
        break;
}

class tour_detalle{

###########################################################################################################
public function inicio_tour_detalle(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    $id_estab = isset($_GET['id_estab'])?$_GET['id_estab']:null;
    
    $sql ="SELECT ";
    $sql.="alojam_estab.id_estab, ";
    $sql.="alojam_estab.nom_estab, ";
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
    $sql.="INNER JOIN man_tipo_alojam ON alojam_estab.tipo_alojam = man_tipo_alojam.id_tipo_alojam ";
    $sql.="INNER JOIN man_desayuno ON alojam_estab.id_desayuno = man_desayuno.id_desayuno ";
    $sql.="INNER JOIN man_comuna ON alojam_estab.id_comuna = man_comuna.id_comuna ";
    $sql.="WHERE id_estab='".$id_estab."'";
    $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());                 
                
    if (mysql_num_rows($run_sql)){
        while($row=mysql_fetch_array($run_sql)){
            #######################################################################################################        
            //Titulo
            echo '
            <div id="google_translate_element" class="traductor"></div>
            <div class="titulo">'.$row['nom_estab'].' - '.$row['nom_comuna'].'</div>';
            
            //CARACTERISTICAS ESTABLECIMIENTO
            echo '
            <TABLE width="98%" border="0" cellpadding="0" cellspacing="0" align="center" class="tabla_fondo">
            <TR>
                <TD WIDTH="35%" ALIGN="CENTER">';
                
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
                       
                    echo '
                    <label class="etq_head">Tipo:</label>
                    <label class="etq_dato">'.$row['nom_tipo_alojam']." ".$star.'</label>
                    
                    <br/>
               
                    <label class="etq_head">Desayuno:</label>
                    <label class="etq_dato">'.$row['nom_desayuno'].'</label>';
                       
                    
                    if ($row['restaurant']=="1"){                  
                        echo '
                        <br/>
                        <label class="etq_head">Restaurant:</label>
                        <label class="etq_dato">Si</label>';
                    }
                    
                    if ($row['bar']=="1"){
                        echo '
                        <br/>
                        <label class="etq_head">Bar:</label>
                        <label class="etq_dato">Si</label>';
                    }
                    
                    if ($row['quincho']=="1"){
                        echo '
                        <br/>           
                        <label class="etq_head">Quincho:</label>
                        <label class="etq_dato">Si</label>';
                    }
                    
                    if ($row['piscina']=="1"){
                        echo '
                        <br/>               
                        <label class="etq_head">Piscina:</label>
                        <label class="etq_dato">Si</label>';
                    }                        
                echo '
                </TD>
                
                <TD WIDTH="65%" ALIGN="CENTER">
                
                    <DIV id="img_estab" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">';
                        
                            //CONT ARCH
                            $sql2=" SELECT COUNT(*) AS cont_arch FROM alojam_estab_archivo ";
                            $sql2.="WHERE id_estab='".$row['id_estab']."' AND tipo_arch<>'video/mp4'";
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
                            $sql2.="alojam_estab_archivo.id_estab, ";
                            $sql2.="alojam_estab_archivo.nom_arch, ";
                            $sql2.="alojam_estab_archivo.tipo_arch, ";
                            $sql2.="alojam_estab_archivo.tam_arch ";              
                            $sql2.="FROM alojam_estab_archivo ";          
                            $sql2.="WHERE id_estab='".$row['id_estab']."' AND tipo_arch<>'video/mp4'";
                            $run_sql2=mysql_query($sql2) or die ('ErrorSql > '.mysql_error ());                            
                            $n=1;
                            
                            if (mysql_num_rows($run_sql2)){     
                                while($row2=mysql_fetch_array($run_sql2)){
                                    
                                    if ($n==1){                                        
                                        echo '                                        
                                        <div class="carousel-item active">
                                            <label class="etq_nfoto">'.$n.' / '.$cont_arch.'</label>
                                            <img class="d-block w-60" src="../admin/app/arch/alojam_estab/'.$row2['nom_arch'].'" style="border-radius:10px;">                                            
                                        </div>';
                            
                                    }else{
                                        echo '                                        
                                        <div class="carousel-item">
                                            <label class="etq_nfoto">'.$n.' / '.$cont_arch.'</label>
                                            <img class="d-block w-60" src="../admin/app/arch/alojam_estab/'.$row2['nom_arch'].'" style="border-radius:10px;">
                                            
                                        </div>';                            
                                    }                                    
                                    $n++;                              
                                }
                            }
                        echo '  
                        </div>                                                  
                        <a class="carousel-control-prev" href="#img_estab" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Anterior</span>
                        </a>
                        
                        <a class="carousel-control-next" href="#img_estab" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Siguiente</span>
                        </a>
                    </DIV>
                    
                </TD>
            </TR>
            </TABLE><br/>';
            
            
            echo '
            <TABLE width="98%" border="0" cellpadding="0" cellspacing="0" align="center" class="tabla_fondo">
            <TR>
                <TD ALIGN="CENTER">';
        
                    //HABITACIONES
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
                    $sql.="alojam_unidad.dolar ";
                    $sql.="FROM alojam_unidad ";
                    $sql.="WHERE id_estab='".$id_estab."' ";
                    $sql.="ORDER BY precio";      
                    
                    $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());                    
                    			
                    if (mysql_num_rows($run_sql)){
                            
                        while($row=mysql_fetch_array($run_sql)){
                            echo '
                            <table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">                        
                            <tr class="tabla_head" style="border-radius:10px;">
                                <td width="33%" align="center">Nombre</td>
                                <td width="33%" align="center">Caracter&iacute;sticas</td>
                                <td width="33%" align="center">Precio</td>
                            </tr>
                            
                            <tr class="tabla_detalle">
                                <td align="center"><u>'.$row['nom_unidad'].'</u>
                                </td>
                                
                                <td align="center">';
                                    if ($row['cant_persona']>"0"){          echo '<br/><label class="etq_head">Personas:</label>                    <label class="etq_dato">'.$row['cant_persona'].'</label>'; }
                                    if ($row['cant_habitacion']>"0"){       echo '<br/><label class="etq_head">Habitaciones:</label>                <label class="etq_dato">'.$row['cant_habitacion'].'</label>'; }
                                    if ($row['cant_bano_ind']>"0"){         echo '<br/><label class="etq_head">Ba&ntilde;o Independiente:</label>   <label class="etq_dato">'.$row['cant_bano_ind'].'</label>'; }
                                    if ($row['cant_bano_com']>"0"){         echo '<br/><label class="etq_head">Ba&ntilde;o Compartido:</label>      <label class="etq_dato">'.$row['cant_bano_com'].'</label>'; }
                                    
                                    if ($row['cant_cama_litera']>"0"){      echo '<br/><label class="etq_head">Cama Litera:</label>             <label class="etq_dato">'.$row['cant_cama_litera'].'</label>'; }
                                    if ($row['cant_cama_1plaza']>"0"){      echo '<br/><label class="etq_head">Cama 1 Plaza:</label>            <label class="etq_dato">'.$row['cant_cama_1plaza'].'</label>'; }
                                    if ($row['cant_cama_1plazamedia']>"0"){ echo '<br/><label class="etq_head">Cama 1 Plaza y Media:</label>    <label class="etq_dato">'.$row['cant_cama_1plazamedia'].'</label>'; }
                                    if ($row['cant_cama_2plaza']>"0"){      echo '<br/><label class="etq_head">Cama 2 Plazas:</label>           <label class="etq_dato">'.$row['cant_cama_2plaza'].'</label>'; }
                                    if ($row['cant_cama_king']>"0"){        echo '<br/><label class="etq_head">Cama King:</label>                    <label class="etq_dato">'.$row['cant_cama_king'].'</label>'; }                   
                                
                                    if ($row['cocina']=="1"){               echo '<br/><label class="etq_head">Cocina:</label>                  <label class="etq_dato">Si</label>'; }
                                    if ($row['comedor']=="1"){              echo '<br/><label class="etq_head">Comedor:</label>                 <label class="etq_dato">Si</label>'; }
                                    if ($row['jacuzzi']=="1"){              echo '<br/><label class="etq_head">Jacuzzi:</label>                 <label class="etq_dato">Si</label>'; }
                                    if ($row['wifi']=="1"){                 echo '<br/><label class="etq_head">Wifi:</label>                    <label class="etq_dato">Si</label>'; }
                                    if ($row['estacionam']=="1"){           echo '<br/><label class="etq_head">Estacionamiento:</label>         <label class="etq_dato">Si</label>'; }
                                    echo '
                                </td>
                                
                                <td align="center">';
                                    
                                    #######################################################################################################                
                                    $sql2 ="SELECT porc_cobro_gestion ";     
                                    $sql2.="FROM man_parametros ";
                                    $sql2.="WHERE id='1'";
                                    $run_sql2=mysql_query($sql2) or die ('ErrorSql > '.mysql_error ());
                                    if (mysql_num_rows($run_sql2)){
                                        while($row2=mysql_fetch_array($run_sql2)){
                                            $cobrogestion   =  (int)(($row['precio']*$row2['porc_cobro_gestion'])/100);
                                            $precio         =  (int)(($row['precio']+$cobrogestion));
                                            
                                            $cobrogestion   =  (int)(($row['dolar']*$row2['porc_cobro_gestion'])/100);
                                            $dolar          =  (int)(($row['dolar']+$cobrogestion));
                                        }                        
                                        
                                    }else{
                                        $precio =  0;
                                        $dolar  =  0;
                                    }
                                    #######################################################################################################                                    
                                    
                                    echo '
                                    <label class="etq_dato">$'.number_format($precio, 0, ",", ".").'</label>
                                    <br/><br/>
                                    <input type="button" value="Reservar" class="bt_morado" style="width:50%;" onclick="location.href='."'tour_alojamiento_reservar.php?op=1&id_unidad=".$row['id_unidad']."'".';"/>
                                </td>
                            </tr>
                            
                            <tr class="tabla_detalle">
                                <td colspan="3" align="center"> ';
                                        
                                        $sql2 ="SELECT ";        
                                        $sql2.="alojam_unidad_archivo.id_unidad, ";
                                        $sql2.="alojam_unidad_archivo.nom_arch, ";
                                        $sql2.="alojam_unidad_archivo.tipo_arch, ";
                                        $sql2.="alojam_unidad_archivo.tam_arch ";              
                                        $sql2.="FROM alojam_unidad_archivo ";          
                                        $sql2.="WHERE id_unidad='".$row['id_unidad']."' AND tipo_arch<>'video/mp4'";
                                        $sql2.="ORDER BY nom_arch ";                  
                                        $run_sql2=mysql_query($sql2) or die ('ErrorSql > '.mysql_error ());                            
                                        $n=1;
                                        
                                        if (mysql_num_rows($run_sql2)){
                                            //INICIO CARRUSEL
                                            echo '
                                            <input type="button" id="btver'.$row['id_unidad'].'" value="+ Ver Fotos" onclick="javascript:ver_foto('."'".$row['id_unidad']."'".');"><br/>
                                            <DIV id="img'.$row['id_unidad'].'" class="carousel slide" data-ride="carousel" style="display:none;">
                                                <div class="carousel-inner">';
                                                
                                                    //CONT ARCH
                                                    $sql3=" SELECT COUNT(*) AS cont_arch FROM alojam_unidad_archivo ";
                                                    $sql3.="WHERE id_unidad='".$row['id_unidad']."' AND tipo_arch<>'video/mp4'";
                                                    $run_sql3=mysql_query($sql3) or die ('ErrorSql > '.mysql_error ());                     
                                                    if (mysql_num_rows($run_sql3)){                                        
                                                        while($row3=mysql_fetch_array($run_sql3)){
                                                            $cont_arch=$row3['cont_arch'];
                                                        }                    
                                                        if ($cont_arch=="0"){
                                                            $cont_arch=" ";
                                                        }
                                                    }
                                            
                                            while($row2=mysql_fetch_array($run_sql2)){
                                                
                                                if ($n==1){                                        
                                                    echo '                                        
                                                    <div class="carousel-item active">
                                                        <img class="d-block w-60" src="../admin/app/arch/alojam_unidad/'.$row2['nom_arch'].'" style="border-radius:10px;">
                                                        <label class="etq_nfoto">'.$n.' / '.$cont_arch.'</label>
                                                    </div>';
                                        
                                                }else{
                                                    echo '                                        
                                                    <div class="carousel-item">
                                                        <img class="d-block w-60" src="../admin/app/arch/alojam_unidad/'.$row2['nom_arch'].'" style="border-radius:10px;">
                                                        <label class="etq_nfoto">'.$n.' / '.$cont_arch.'</label>
                                                    </div>';                            
                                                }                                    
                                                $n++;                              
                                            }//End While Fotos
                                            
                                                echo '  
                                                </div>                                                  
                                                <a class="carousel-control-prev" href="#img'.$row['id_unidad'].'" role="button" data-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Anterior</span>
                                                </a>
                                                
                                                <a class="carousel-control-next" href="#img'.$row['id_unidad'].'" role="button" data-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Siguiente</span>
                                                </a>
                                            </DIV>';
                                            //FIN CARRUSEL
                                        }// End If Archivos  
                                echo '
                                </td>
                            </tr>
                            </table><br/>';
                        }
                    }
                          
                echo '
                </TD>
            </TR>
            </TABLE><br/>';
            
        }
    }
}
############################################################################################################
} // FIN CASE CLASS
?>