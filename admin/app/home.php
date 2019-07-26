<?php
session_start();
?>

<?php
if ($_SESSION['log_rut']!="" AND $_SESSION['log_nom']!="" AND $_SESSION['log_tipo']!=""){
    
?>
    <html>
    <head>
        
        <title>Turismo</title>
        <!-- icono Web -->
        <link href="img/icono_web.png" type="image/x-icon" rel="shortcut icon"/>  
                
        <!-- ajax -->
        <script src="func/ajax.js" type="text/javascript"></script>
    
        <!-- func - jquery - alert - confirm-->
        <script src="func/jquery.min.js" type="text/javascript"></script>
        <script src="func/jquery.alerts.js" type="text/javascript"></script>
        <link href="func/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen"/>
        
        <!-- func - formularios-->
        <script src="func/validaciones.js" type="text/javascript"></script>
        <script src="func/home.js" type="text/javascript"></script>
        <script src="func/man_usuario.js" type="text/javascript"></script>
        <script src="func/man_empresa.js" type="text/javascript"></script>
        <script src="func/actividad.js" type="text/javascript"></script>
        
        <script src="func/alojam_estab.js" type="text/javascript"></script>
                
        <!--css -->
        <link href="css/menu.css" type="text/css" rel="stylesheet"  media="screen"/>
        <link href='css/formatos.css' type="text/css" rel="stylesheet"  media="screen"/>
        
        <!-- Calendario -->
        <script src="calendar/dhtmlgoodies_calendar.js?random=20060118" type="text/javascript"></script>
        <link href="calendar/dhtmlgoodies_calendar.css??random=20051112" type="text/css" rel="stylesheet"  media="screen"/> 
    
<?php
    
    
    echo '
    <body bgcolor="#fff">
    
    
    
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-image:url(img/cabecera_degrade.png);background-repeat:repeat-x;"><tr>                    
    <tr height="125px">
    
        <td width="25%" align="center"> <img src="img/logo_sist1.png" border="0" align="center"/> </td>
        
        <td width="50%" valign="bottom" align="center">
            <label class="bt_menu" onclick="open_pag('."'man_usuario','1'".');"/>Usuarios</a></label>
            <label class="bt_menu" onclick="open_pag('."'actividad','1'".');"/>Actividades</a></label>
            <label class="bt_menu" onclick="open_pag('."'alojam_estab','1'".');"/>Alojamientos</a></label>
        </td>
        
        <td width="25%" valign="bottom">        
            <div style="top:1%; left:94%; position:absolute;">
                <form id="form_home">
                <img src="img/logout.png" id="bt_logout" title="Cerrar Sesi&oacute;n" style="cursor:pointer;" onclick="location.href='."'../index.php?eco=x'".';"/>
                </form>
            </div>
            
            <center>
                <img src="img/icono_cambio_clave.png" title="Cambiar Clave" style="cursor:pointer;" onclick="javascript:cambio_clave();"/><br/>
                <label class="login_usu">'.$_SESSION['log_nom'].'</label>
            </center>
        </td> 
    </tr>
    </table>
    
    
    
    <div id="contenido">
        <div id="titulo" class="titulo1">Sistema Gesti&oacute;n Turismo</div>
    </div>
    
    </body>
    </html>';

}else{       
    //Si Sesion no es valida retorna a la portada
    header("Location: ../index.php?eco=err");
}
?>
