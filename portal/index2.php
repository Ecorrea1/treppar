<?php
session_start();

require_once ("func/cnx.php");
$op = isset($_GET['op'])?$_GET['op']:null;
?>

<html>
<head>

    <title>turismo</title>
    <!-- icono Web -->
    <link href="img/icono_web.png" type="image/x-icon" rel="shortcut icon"/>
   
    <!-- ajax -->
    <script src="func/ajax.js" type="text/javascript"></script>

    <!-- func - jquery - alert - confirm-->
    <script src="func/jquery.min.js" type="text/javascript"></script>
    <script src="func/jquery.alerts.js" type="text/javascript"></script>
    <link href="func/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen"/>
  
    <!--formatos - validaciones -->
    <link href="css/formato_tour.css" type="text/css" rel="stylesheet"  media="screen"/>
    
    
    <link href="css/formato_traductor.css" type="text/css" rel="stylesheet"  media="screen"/>
    <link href="css/formato_pie_pagina.css" type="text/css" rel="stylesheet"  media="screen"/>
    <script src="func/validaciones.js" type="text/javascript"></script>   
    <script src="func/index2.js" type="text/javascript"></script>

    <!--Google translate --> 
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    
</head>
<body>

<?php
####################################

$tour= new tour();
switch($op){
    case'1':
        $tour->inicio_pc();
        break;
        
    case'2':
        $tour->inicio_movil();
        break;
        
    case'3':
        $tour->filtro_pestana_actividad();
        break;
        
    case'4':
        $tour->filtro_pestana_alojamiento();
        break;
        
    case'5':
        $tour->buscar_ciudad();
        break;
}

class tour{

###########################################################################################################
public function inicio_pc(){    
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");    
    
    $width  = isset($_GET['w'])?$_GET['w']:null;
    $height = isset($_GET['h'])?$_GET['h']:null;
    
    $_SESSION['ancho_celda']    = (int)($width/2)."px";
    $_SESSION['alto_celda']     = (int)(($_SESSION['ancho_celda']/3)*2)."px";
     
    echo '     
    <form id="form_portal">
        <input type="button" id="bt_reload_pag" style="display:none;" onclick="document.location.reload(true);"/>    
    </form>';
    
    //////////////////////////////////////////////////////////////////
    echo '
    <div id="google_translate_element" class="traductor"></div>
    <table width="100%" height="500px" border="0" cellpadding="0" cellspacing="0" align="center" style="background-image:url(img/fondo.jpg);background-repeat:no-repeat;background-size: 100% 100%;">
    <tr>
        <td align="center" valign="top">';
        
            //Usuario
            echo '
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
            <tr>                
                <td width="40%" class="panel_2" style="cursor:pointer;" onclick="window.open('."'../admin/index.php','_blank'".');"/>Portal<br/>Operadores Tur&iacute;sticos</td>
                
                <td width="20%" class="panel_1"><img title="Treppar" src="img/logo_treppar.png" border="1"></td>';
                
                if ( isset($_SESSION['log_email']) AND isset($_SESSION['log_nombre']) ){                    
                    echo '
                    <td width="40%" class="panel_1">';
                        echo '<div style="float:left;width:70%;">'.$_SESSION['log_nombre'].'<br/><a href="../index.php" class="cerrar_sesion">Cerrar Sesi&oacute;n</a></div>';
                        echo '<div style="float:left;width:30%; cursor:pointer;"><img title="Mi Perfil" src="img/icono_usuario.png" width="40px" onclick="go_mi_perfil();"></div>';             
                    echo '
                    </td>';                    
                    
                }else{
                    echo '<td width="40%" class="panel_2" onclick="go_iniciar_sesion();">Iniciar Sesi&oacute;n</td>';                    
                } 
                echo '                
            </tr>
            </table><br/><br/>';
            
            //Filtro
            echo ' 
            <label id="pesta1" class="pesta_in" onclick="javascript:activa_pesta('."'1'".');">Actividades</label>
            <label id="pesta2" class="pesta_out" onclick="javascript:activa_pesta('."'2'".');">Alojamientos</label>
            
            <DIV id="div_filtro" class="contenido" style="display:block;">
                <table width="80%" border="0" cellpadding="0" cellspacing="0" align="center" class="etq1">                
                <tr><td><hr size="1" color="#fff" style="opacity: 0.5;"></td></tr>
                
                <tr valign="center">
                    <td align="center">Buscar Ciudad<br/>
                        <input type="text" id="ciudad" class="txt1" style="width:60%;" maxlength="30" autocomplete="off" onKeyUp="buscar_ciudad();"/>
                        <div id="ciudad_encontrada" class="div_ciudad_encontrada" style="display:none;"></div>
                    </td>                
                </tr>
                
                <tr><td><hr size="1" color="#fff" style="opacity: 0.5;"></td></tr>
                 
                <tr valign="center">
                    <td align="center">Tipo Actividad<br/>';
                        $sql="SELECT * FROM man_tipo_actividad ";
                        $sql.="ORDER BY nom_tipo_activ ASC";
                        $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());
                        
                        echo '
                        <select id="id_tipo_activ" class="txt1">
                        <option value="*.all">--Todas--</option>';
                        
                        if (mysql_num_rows($run_sql)){
                            while($row=mysql_fetch_array($run_sql)){
                                echo '<option value="'.$row['id_tipo_activ'].'">'.$row['nom_tipo_activ'].'</option>';
                            }
                        }
                        echo '
                        </select>
                    </td>
                </tr>
                
                <tr><td><hr size="1" color="#fff" style="opacity: 0.5;"></td></tr>
               
                <tr valign="center">
                    <td colspan="2" align="center"><br/>
                        <input type="button" title="Buscar" value="BUSCAR" style="width:60%;" class="bt_azul" onclick="javascript:buscar_actividad();">
                    </td>
                </tr>
                </table>                           
            </DIV>';
        
        echo '                        
        </td>
    </tr>
    </table>';
    //Fin filtro
    
    echo '    
    <div id="grilla_producto">';
    
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
      
        $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());
        
        if (mysql_num_rows($run_sql)){
            $col=0;            
            echo '
            <br/>
            <div class="titulo">ACTIVIDADES</div>
            <table width="100%" border="0" cellspacing="10" cellpadding="0" align="center">';
               
            while($row=mysql_fetch_array($run_sql)){
                
                $precio_adultojoven = ($row['precio_adultojoven'] -( ($row['precio_adultojoven']*$row['dscto_adultojoven']/100) ));
                $precio_adultojoven = $precio_adultojoven + (  ($precio_adultojoven*$porc_cobro_gestion) / 100 );
                
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
        </table>
    </div>'; 
    
    echo '
    <br/>
    <footer>    
    <div class="container-footer-all">    
        <div class="container-body">    
            <div class="colum1">
                <h1>Quienes Somos?</h1>    
                <p>
                    Treppar es un portal chileno de internet, donde podr&aacute;s buscar, en forma f&aacute;cil y efectiva, todas las actividades de turismo aventura 
                    y alojamientos en Chile, as&iacute; como otros servicios derivados del turismo en el pa&iacute;s, y donde se desplegar&aacute; una gran variedad de actividades 
                    y alojamientos, en todas sus clases. Al elegir, podr&aacute;s reservar y pagar tu compra, asegurando de esta forma una grata estad&iacute;a 
                    y una emocionante aventura. 
                    Treppar es una opci&oacute;n efectiva y segura de buscar en la web, de forma f&aacute;cil y segura, la aventura que est&aacute;s buscando en Chile
                    ...Trepa a la aventura
                </p>
            </div>
    
            <div class="colum2">
                <h1>Redes Sociales</h1>
                <div class="row">
                    <a href="https://www.facebook.com/Treppar-510356309483115">
                    <img src="img/facebook.png"></a>
                    <label>Siguenos en Facebook</label>
                </div>
                <div class="row">
                 <a href="https://twitter.com/Treppar_oficial">
                    <img src="img/twitter.png"> </a>
                    <label>Siguenos en Twitter</label>
                </div>
                <div class="row">
                     <a href="https://www.instagram.com/treppar_oficial/">
                    <img src="img/instagram.png"></a>
                    <label>Siguenos en Instagram</label>
                </div>
                <div class="row">
                    <a href="https://plus.google.com/u/2/116317185348111651003">
                    <img src="img/google-plus.png"></a>
                    <label>Siguenos en Google Plus</label>
                </div>
                <div class="row">
                    <a href="https://www.youtube.com/channel/UC9L4fs23FX8O5yIItk9s4AQ">
                    <img src="img/youtube.png"></a>
                    <label>Siguenos en Youtube</label>
                </div>
            </div>
    
            <div class="colum3">    
                <h1>Informacion Contactos</h1>    
                <div class="row2">
                    <img src="img/house.png">
                    <label>
                        Luis Uribe Sur S/N, Lote 29, Quepe, Freire
                    </label>
                </div>    
                <div class="row2">
                    <img src="img/smartphone.png">
                    <label>+56954619495</label>
                </div>    
                <div class="row2">
                    <img src="img/contact.png">
                     <label>info@treppar.cl</label>
                </div>    
            </div>    
        </div>    
    </div>
    
    <div class="container-footer">
           <div class="footer">
                <div class="copyright">
                    © 2018 Todos los Derechos Reservados | <a href="">Treppar</a>
                </div>
    
                <div class="information">
                    <a href="doc_treppar/Treppar_que_es_portal_operadores.pdf" target="_blank">Que es el Portal Tour Operadores</a> | 
                    <a href="doc_treppar/Treppar_politica_privacidad.pdf" target="_blank">Pol&iacute;ticas de Privacidad</a> | 
                    <a href="doc_treppar/Treppar_terminos_condiciones_uso.pdf" target="_blank">Terminos y Condiciones</a>
                </div>
            </div>    
        </div>    
    </footer>';
}





























public function inicio_movil(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    
    echo '     
    <form id="form_portal">
        <input type="button" id="bt_reload_pag" style="display:none;" onClick="document.location.reload(true);"/>    
    </form>';
    
    //////////////////////////////////////////////////////////////////
    echo '
    <div id="google_translate_element" class="traductor"></div>
    <table width="100%" height="500px" border="0" cellpadding="0" cellspacing="0" align="center" style="background-image:url(img/fondo.jpg);background-repeat:no-repeat;background-size: 100% 100%;">
    <tr>
        <td align="center" valign="top">';
        
            //Usuario
            echo '
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
            <tr>                
                <td width="40%" class="panel_2" style="cursor:pointer;" onclick="window.open('."'../admin/index.php','_blank'".');"/>Portal<br/>Operadores Tur&iacute;sticos</td>
                
                <td width="20%" class="panel_1"><img title="Treppar" src="img/logo_treppar.png" border="1"></td>';
                
                if ( isset($_SESSION['log_email']) AND isset($_SESSION['log_nombre']) ){                    
                    echo '
                    <td width="40%" class="panel_1">';
                        echo '<div style="float:left;width:70%;">'.$_SESSION['log_nombre'].'<br/><a href="../index.php" class="cerrar_sesion">Cerrar Sesi&oacute;n</a></div>';
                        echo '<div style="float:left;width:30%; cursor:pointer;"><img title="Mi Perfil" src="img/icono_usuario.png" width="40px" onclick="go_mi_perfil();"></div>';             
                    echo '
                    </td>';                    
                    
                }else{
                    echo '<td width="40%" class="panel_2" onclick="go_iniciar_sesion();">Iniciar Sesi&oacute;n</td>';                    
                } 
                echo '                
            </tr>
            </table><br/>';
            
            //Filtro
            echo ' 
            <label id="pesta1" class="pesta_in" onclick="javascript:activa_pesta('."'1'".');">Actividades</label>
            <label id="pesta2" class="pesta_out" onclick="javascript:activa_pesta('."'2'".');">Alojamientos</label>             
                
            <DIV id="div_filtro" class="contenido" style="display:block;">
                <table width="80%" border="0" cellpadding="0" cellspacing="0" align="center" class="etq1">                
                <tr><td><hr size="1" color="#fff" style="opacity: 0.5;"></td></tr>
                
                <tr valign="center">
                    <td align="center">Buscar Ciudad<br/>
                        <input type="text" id="ciudad" class="txt1" style="width:60%;" maxlength="30" autocomplete="off" onKeyUp="buscar_ciudad();"/>
                        <div id="ciudad_encontrada" class="div_ciudad_encontrada" style="display:none;"></div>
                    </td>                
                </tr>
                
                <tr><td><hr size="1" color="#fff" style="opacity: 0.5;"></td></tr>
                 
                <tr valign="center">
                    <td align="center">Tipo Actividad<br/>';
                        $sql="SELECT * FROM man_tipo_actividad ";
                        $sql.="ORDER BY nom_tipo_activ ASC";
                        $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());
                        
                        echo '
                        <select id="id_tipo_activ" class="txt1">
                        <option value="*.all">--Todas--</option>';
                        
                        if (mysql_num_rows($run_sql)){
                            while($row=mysql_fetch_array($run_sql)){
                                echo '<option value="'.$row['id_tipo_activ'].'">'.$row['nom_tipo_activ'].'</option>';
                            }
                        }
                        echo '
                        </select>
                    </td>
                </tr>
                
                <tr><td><hr size="1" color="#fff" style="opacity: 0.5;"></td></tr>
               
                <tr valign="center">
                    <td colspan="2" align="center"><br/>
                        <input type="button" title="Buscar" value="BUSCAR" style="width:60%;" class="bt_azul" onclick="javascript:buscar_actividad();">
                    </td>
                </tr>
                </table>                           
            </DIV>';
        
        echo '                        
        </td>
    </tr>
    </table>';
    //Fin filtro
    
    
    echo '    
    <div id="grilla_producto">';
        
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
        </table>
    </div>';
    
   echo '
    <br/>
    <footer>    
    <div class="container-footer-all">    
        <div class="container-body">    
            <div class="colum1">
                <h1>Quienes Somos?</h1>    
                <p>
                    Treppar es un portal chileno de internet, donde podr&aacute;s buscar, en forma f&aacute;cil y efectiva, todas las actividades de turismo aventura 
                    y alojamientos en Chile, as&iacute; como otros servicios derivados del turismo en el pa&iacute;s, y donde se desplegar&aacute; una gran variedad de actividades 
                    y alojamientos, en todas sus clases. Al elegir, podr&aacute;s reservar y pagar tu compra, asegurando de esta forma una grata estad&iacute;a 
                    y una emocionante aventura. 
                    Treppar es una opci&oacute;n efectiva y segura de buscar en la web, de forma f&aacute;cil y segura, la aventura que est&aacute;s buscando en Chile
                    ...Trepa a la aventura
                </p>
            </div>
    
            <div class="colum2">
                <h1>Redes Sociales</h1>
                <div class="row">
                    <a href="https://www.facebook.com/Treppar-510356309483115">
                    <img src="img/facebook.png"></a>
                    <label>Siguenos en Facebook</label>
                </div>
                <div class="row">
                 <a href="https://twitter.com/Treppar_oficial">
                    <img src="img/twitter.png"> </a>
                    <label>Siguenos en Twitter</label>
                </div>
                <div class="row">
                     <a href="https://www.instagram.com/treppar_oficial/">
                    <img src="img/instagram.png"></a>
                    <label>Siguenos en Instagram</label>
                </div>
                <div class="row">
                    <a href="https://plus.google.com/u/2/116317185348111651003">
                    <img src="img/google-plus.png"></a>
                    <label>Siguenos en Google Plus</label>
                </div>
                <div class="row">
                    <a href="https://www.youtube.com/channel/UC9L4fs23FX8O5yIItk9s4AQ">
                    <img src="img/youtube.png"></a>
                    <label>Siguenos en Youtube</label>
                </div>
            </div>
    
            <div class="colum3">    
                <h1>Informacion Contactos</h1>    
                <div class="row2">
                    <img src="img/house.png">
                    <label>
                        Luis Uribe Sur S/N, Lote 29, Quepe, Freire
                    </label>
                </div>    
                <div class="row2">
                    <img src="img/smartphone.png">
                    <label>+56954619495</label>
                </div>    
                <div class="row2">
                    <img src="img/contact.png">
                     <label>info@treppar.cl</label>
                </div>    
            </div>    
        </div>    
    </div>
    
    <div class="container-footer">
           <div class="footer">
                <div class="copyright">
                    © 2018 Todos los Derechos Reservados | <a href="">Treppar</a>
                </div>
    
                <div class="information">
                    <a href="doc_treppar/Treppar_que_es_portal_operadores.pdf" target="_blank">Que es el Portal Tour Operadores</a> | 
                    <a href="doc_treppar/Treppar_politica_privacidad.pdf" target="_blank">Pol&iacute;ticas de Privacidad</a> | 
                    <a href="doc_treppar/Treppar_terminos_condiciones_uso.pdf" target="_blank">Terminos y Condiciones</a>
                </div>
            </div>    
        </div>    
    </footer>';
}

public function filtro_pestana_actividad(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    
    echo '
    <table width="80%" border="0" cellpadding="0" cellspacing="0" align="center" class="etq1">
    <tr><td><hr size="1" color="#fff" style="opacity: 0.5;"></td></tr>
    
    <tr valign="center">
        <td align="center">Buscar Ciudad<br/>
            <input type="text" id="ciudad" class="txt1" style="width:60%;" maxlength="30" autocomplete="off" onKeyUp="buscar_ciudad();"/>
            <div id="ciudad_encontrada" class="div_ciudad_encontrada" style="display:none;"></div>
        </td>                
    </tr>
    
    <tr><td><hr size="1" color="#fff" style="opacity: 0.5;"></td></tr>
     
    <tr valign="center">
        <td align="center">Tipo Actividad<br/>';
            $sql="SELECT * FROM man_tipo_actividad ";
            $sql.="ORDER BY nom_tipo_activ ASC";
            $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());
            
            echo '
            <select id="id_tipo_activ" class="txt1">
            <option value="*.all">--Todas--</option>';
            
            if (mysql_num_rows($run_sql)){
                while($row=mysql_fetch_array($run_sql)){
                    echo '<option value="'.$row['id_tipo_activ'].'">'.$row['nom_tipo_activ'].'</option>';
                }
            }
            echo '
            </select>
        </td>
    </tr>
    
    <tr><td><hr size="1" color="#fff" style="opacity: 0.5;"></td></tr>
    
    <tr valign="center">
        <td align="center"><br/>
            <input type="button" title="Buscar" value="BUSCAR" style="width:60%;" class="bt_azul" onclick="javascript:buscar_actividad();">
        </td>
    </tr>
    </table>';
}

public function filtro_pestana_alojamiento(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    echo '
    <table width="80%" border="0" cellpadding="0" cellspacing="0" align="center" class="etq1">
    <tr><td><hr size="1" color="#fff" style="opacity: 0.5;"></td></tr>
    
    <tr valign="center">
        <td align="center">Buscar Ciudad<br/>
            <input type="text" id="ciudad" class="txt1" style="width:60%;" maxlength="30" autocomplete="off" onKeyUp="buscar_ciudad();"/>
            <div id="ciudad_encontrada" class="div_ciudad_encontrada" style="display:none;"></div>
        </td>                
    </tr>
    
    <tr><td><hr size="1" color="#fff" style="opacity: 0.5;"></td></tr>
     
    <tr valign="center">
        <td align="center">Tipo Alojamiento<br/>';
            $sql="SELECT * FROM man_tipo_alojam ";
            $sql.="ORDER BY orden ASC";
            $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());
            
            echo '
            <select id="id_tipo_alojam" class="txt1">
            <option value="@">--Todas--</option>';
            
            if (mysql_num_rows($run_sql)){
                while($row=mysql_fetch_array($run_sql)){
                    echo '<option value="'.$row['id_tipo_alojam'].'">'.$row['nom_tipo_alojam'].'</option>';
                }
            }
            echo '
            </select>
        </td>
    </tr>
    
    <tr><td><hr size="1" color="#fff" style="opacity: 0.5;"></td></tr>
    
    <tr valign="center">
        <td align="center"><br/>
            <input type="button" title="Buscar" value="BUSCAR" style="width:60%;" class="bt_azul" onclick="javascript:buscar_alojamiento();">
        </td>
    </tr>
    </table>';
    
}

public function buscar_ciudad(){
    $cnx=conexion();
    $ciudad = isset($_GET['ciudad'])?$_GET['ciudad']:null;
    
    $sql ="SELECT ";
    $sql.="man_comuna.id_comuna, ";
    $sql.="man_comuna.nom_comuna, ";
    $sql.="man_comuna.n_region, ";
    $sql.="man_comuna_region.nom_region ";
    $sql.="FROM man_comuna ";
    $sql.="INNER JOIN man_comuna_region ON man_comuna.n_region = man_comuna_region.n_region ";
    $sql.="WHERE nom_comuna LIKE '%".$ciudad."%'";
    $sql.="ORDER BY orden_geo ASC, nom_comuna ASC";
    $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());    
    if (mysql_num_rows($run_sql)){
        $region_old=""; 
        echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="tabla_ciudad">';
        while($row=mysql_fetch_array($run_sql)){
            if ($row['n_region']!=$region_old){
                echo '            
                <tr onclick="seleccion_ciudad('."'".$row['nom_comuna']."'".');"/>
                    <td onmouseover="background-color:#E0ECF8;" width="50%" style="border-top:1px dotted;">'.$row['nom_comuna'].'</td>
                    <td width="50%" style="border-top:1px dotted;">'.$row['n_region'].' Regi&oacute;n, Chile</td>
                </tr>';
            }else{
                echo '            
                <tr onclick="seleccion_ciudad('."'".$row['nom_comuna']."'".');"/>
                    <td width="50%">'.$row['nom_comuna'].'</td>
                    <td width="50%">'.$row['n_region'].' Regi&oacute;n, Chile</td>
                </tr>';                
            }
            $region_old=$row['n_region'];
        }
        echo '<table>';
    }
}
############################################################################################################
} // FIN CASE CLASS
?>
</body>
</html>