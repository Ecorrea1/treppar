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
      
    <!--formatos - validaciones -->
    <link href="css/formato_tour.css" type="text/css" rel="stylesheet"  media="screen"/>
    <link href="css/formato_traductor.css" type="text/css" rel="stylesheet"  media="screen"/>
    <script src="func/validaciones.js" type="text/javascript"></script>
    <script src="func/tour_comprar.js" type="text/javascript"></script>
  
    <!--Google translate --> 
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

</head>

<body class="body">     

<?php
require_once ("func/cnx.php");
require_once ("tour_carro_compra.php");

$op = isset($_GET['op'])?$_GET['op']:null;

if($op==""){
    $op="1";
}

$tour_comprar= new tour_comprar();
switch($op){
    case'1':
        $tour_comprar->inicio_comprar();
        break;
        
    case'2':
        $tour_comprar->eliminar_compra();
        break;
        
    case'3':
        $tour_comprar->grabar_formulario();
        break;
}

class tour_comprar{
###########################################################################################################
public function inicio_comprar(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");    
    
    echo '
    <input type="button" value="Volver" class="bt_amarillo" style="position:absolute;" onclick="window.history.back();"/>
    <div id="google_translate_element" class="traductor"></div>';
    
    $nombre     = "Anibal";
    $apellido   = "Merino";  
    $pais       = "CHL";
    $fono       = "6006386380";
    $email      = "";
    $rut        = "55555555-5";
    $dni        = "";
    $pasaporte  = "";
    
    //Limpia arreglos de compra
    if(isset($_SESSION['arr_compra_cabecera_ok'])){
        unset($_SESSION['arr_compra_cabecera_ok']);
    }    
    
    if(isset($_SESSION['arr_compra_detalle_ok'])){
        unset($_SESSION['arr_compra_detalle_ok']);
    }
    $key="alojamiento@1";
    //Sera crea arreglo compra cabecera
    $_SESSION['arr_compra_cabecera_ok'][$key]=array(
        'tipo_prod' => "actividad",
        'id_prod' => 1,
        'nom_prod' => "Cabalgata",
        'id_comuna' => 339,
        'nom_comuna' => "Punta Arena",
        'fecha_in' => date('Y-m-d'),
        'fecha_out' => date('Y-m-d')
    );
    
    //Detalle
    $_SESSION['arr_compra_detalle_ok'][$key][]=array(            
        'detalle' => "Adultos",
        'cant' => 2,        
        'punit' => 8000,
        'subtotal' => 16000
    );
    
    $_SESSION['arr_compra_detalle_ok'][$key][]=array(            
        'detalle' => "Niños",
        'cant' => 2,        
        'punit' => 5000,
        'subtotal' => 10000
    );

    
    //Formulario
    echo '
    <input type="hidden" id="total_compra" value="'.$_SESSION['total_compra'].'">
    
    <TABLE width="98%" border="0" cellpadding="0" cellspacing="0" align="center" class="tabla_fondo">
    <TR><TD>
        <br/>
        <table width="95%" border="0" cellspacing="0" cellpadding="0" class="etq1" align="center">
        <tr>
            <td align="center" colspan="2"><div class="titulo">Confirme sus datos</div></td>
        </tr>
        
        <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>
        
        <tr>
            <td align="center"><label class="msn_err">* </label>Identificaci&oacute;n:</td>
            <td align="center">';
                if ($rut!=""){
                    echo '
                    <input type="radio" name="tipo_ident" value="rut" onclick="activar_ident_compra();" checked/>Rut-Chi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="tipo_ident" value="dni" onclick="activar_ident_compra();"/>Dni-Extranjero&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="tipo_ident" value="pasaporte" onclick="activar_ident_compra();"/>Pasaporte&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    
                    <input type="text" id="nro_ident" style="width:90%;" maxlength="10" class="txt1" placeholder="Rut (Ej: 11111111-1)" value="'.$rut.'">';
                    
                }else if ($dni!=""){
                    echo '
                    <input type="radio" name="tipo_ident" value="rut" onclick="activar_ident_compra();"/>Rut-Chi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="tipo_ident" value="dni" onclick="activar_ident_compra();" checked/>Dni-Extranjero&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="tipo_ident" value="pasaporte" onclick="activar_ident_compra();"/>Pasaporte&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    
                    <input type="text" id="nro_ident" style="width:90%;" maxlength="10" class="txt1" placeholder="Dni / Extranjero" value="'.$dni.'">';                        
                    
                }else if ($pasaporte!=""){
                    echo '
                    <input type="radio" name="tipo_ident" value="rut" onclick="activar_ident_compra();"/>Rut-Chi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="tipo_ident" value="dni" onclick="activar_ident_compra();"/>Dni-Extranjero&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="tipo_ident" value="pasaporte" onclick="activar_ident_compra();" checked/>Pasaporte&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    
                    <input type="text" id="nro_ident" style="width:90%;" maxlength="10" class="txt1" placeholder="Pasaporte" value="'.$pasaporte.'">'; 
                                      
                }else{
                    echo '
                    <input type="radio" name="tipo_ident" value="rut" onclick="activar_ident_compra();" checked/>Rut-Chi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="tipo_ident" value="dni" onclick="activar_ident_compra();"/>Dni-Extranjero&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="tipo_ident" value="pasaporte" onclick="activar_ident_compra();"/>Pasaporte&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    
                    <input type="text" id="nro_ident" style="width:90%;" maxlength="10" class="txt1" placeholder="Rut (Ej: 11111111-1)">';                   
                }                
                
                 echo '
                <br><label id="msn_ident" class="msn_err"></label>
            </td>
        </tr>
        
        <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>
        
        <tr>
            <td align="center"><label class="msn_err">* </label>Nombres:</td>
            <td align="center">
                <input type="text" id="nombre" value="'.$nombre.'" style="width:90%" maxlength="50" class="txt1" placeholder="Nombres" onblur="valida_alfanum(this);"/>
                <br><label id="msn_nombre" class="msn_err"></label>
            </td>
        </tr>
        
        <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>
        
        <tr>
            <td align="center"><label class="msn_err">* </label>Apellidos:</td>
            <td align="center">
                <input type="text" id="apellido" value="'.$apellido.'" style="width:90%" maxlength="50" class="txt1" placeholder="Apellidos" onblur="valida_alfanum(this);"/>
                <br><label id="msn_apellido" class="msn_err"></label>
            </td>
        </tr>
        
        <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>
        
        <tr>
            <td align="center"><label class="msn_err">* </label>Pa&iacute;s:</td>
            <td align="center">';
                $sql2 ="SELECT ";
                $sql2.="man_pais.iso3, ";  
                $sql2.="man_pais.pais_es ";
                $sql2.="FROM man_pais ";
                $sql2.="ORDER BY pais_es";
                $run_sql2=mysql_query($sql2) or die ('ErrorSql > '.mysql_error ());
                if (mysql_num_rows($run_sql2)){
                    echo '
                    <select id="cod_pais" style="width:90%" class="txt1">
                    <option value="@"/>--Seleccione Pais--</option>';
                    
                    while($row2=mysql_fetch_array($run_sql2)){
                        if ($pais==$row2['iso3']){
                            echo '<option value="'.$row2['iso3'].'" selected/>'.$row2['pais_es'].'</option>';
                        }else{
                            echo '<option value="'.$row2['iso3'].'"/>'.$row2['pais_es'].'</option>';
                        }
                    }              
                    echo '
                    </select>';
                }
                echo '
                <br><label id="msn_pais" class="msn_err"></label>
            </td>
        </tr>
        
        <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>
        
        <tr>
            <td align="center"><label class="msn_err">* </label>Fono:</td>
            <td align="center">
                <input type="text" id="fono" value="'.$fono.'" style="width:90%" maxlength="50" class="txt1" placeholder="Ej: 56 9 1234 5678" onblur="valida_alfanum(this);"/>
                <br><label id="msn_fono" class="msn_err"></label>
            </td>
        </tr>
        
        <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>
        
        <tr>
            <td align="center"><label class="msn_err">* </label>Email:</td>
            <td align="center">
                <input type="text" id="email" value="'.$email.'" style="width:90%" maxlength="50" class="txt1" placeholder="Email" onblur="valida_mail(this);">
                <br><label id="msn_email" class="msn_err"></label>
            </td>
        </tr>
        
        <tr><td colspan="2"><hr size="1" color="#6E6E6E"></td></tr>
                        
        </table>
        <br/>
        
    </TD>
    </TR>
    </TABLE><br/>';
    
    //Grilla Compra
    echo '
    <div id="div_compras">';
        ver_carro_compras();
        
        if ($_SESSION['hay_compras']=="si"){
            echo '
            <br/>
            <center>            
            <input type="button" value="$'.number_format(($_SESSION['total_compra']), 0, ",", ".").'  Pagar Con Webpay &raquo;" class="bt_morado" onclick="grabar_formulario();">            
            </center>
            <br/><br/>';
        }
    echo '
    </div>';
            
    echo '<div id="salida"></div>';   
}

public function eliminar_compra(){
    $accion = isset($_GET['accion'])?$_GET['accion']:null;
    
    if ($accion=="eliminar"){
        $key_cab = isset($_GET['key_cab'])?$_GET['key_cab']:null;        
        eliminar_carro_compras($key_cab);
    }
    
    ver_carro_compras();
    
    if ($_SESSION['hay_compras']=="si"){
        echo '
        <br/>
        <center>            
        <input type="button" value="$'.number_format(($_SESSION['total_compra']), 0, ",", ".").'  Finalizar Comprar &raquo;" class="bt_morado" onclick="grabar_formulario();">            
        </center>
        <br/><br/>';
        
        echo '<input type="hidden" id="eco_eliminar" value="ok">';
    }else{
        echo '<input type="hidden" id="eco_eliminar" value="err">';
    }
}

public function grabar_formulario(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    
    $tipo_ident = isset($_GET['tipo_ident'])?$_GET['tipo_ident']:null;
    $nro_ident  = strtoupper(guardian($_GET['nro_ident']));// todo A MAYUSCULA
    $nombre     = ucwords(strtolower(guardian($_GET['nombre'])));//1era Letra De Cada Palabra Mayuscula
    $apellido   = ucwords(strtolower(guardian($_GET['apellido'])));//1era Letra De Cada Palabra Mayuscula
    $cod_pais   = isset($_GET['cod_pais'])?$_GET['cod_pais']:null;
    $fono       = ucwords(strtolower(guardian($_GET['fono'])));//1era Letra De Cada Palabra Mayuscula
    $email      = guardian(strtolower($_GET['email']));//todo a minusculas
    
    //Se chequean fechas de alojamiento
    $fechas_usadas="";
    
    FOREACH($_SESSION['arr_compra_cabecera_ok'] as $key_cab => $dato_cab){
        if ($dato_cab["tipo_prod"]=="alojamiento"){
            
            $sql ="SELECT ";
            $sql.="compra_alojam_reservacion.id_unidad, ";
            $sql.="compra_alojam_reservacion.fecha ";
            $sql.="FROM compra_alojam_reservacion ";    
            $sql.="WHERE id_unidad='".$dato_cab["id_prod"]."' AND fecha>='".$dato_cab["fecha_in"]."' AND fecha<='".$dato_cab["fecha_out"]."'";   
            $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());            
                
            if (mysql_num_rows($run_sql)){
                while($row=mysql_fetch_array($run_sql)){
                    if ($fechas_usadas==""){
                        $fechas_usadas.= date("d-m-Y",strtotime($row['fecha']))." / ".$dato_cab["nom_prod"];
                    }else{
                        $fechas_usadas.= "<br/>".date("d-m-Y",strtotime($row['fecha']))." / ".$dato_cab["nom_prod"];
                    }  
                } 
            }
        }
    }
    
    IF ($fechas_usadas!=""){
       echo '<input type="hidden" id="eco_grabar" value="err_fechas"/>';
       echo '<input type="hidden" id="fechas_usadas" value="'.$fechas_usadas.'"/>';
       
    }ELSE{
        
        //Compra
        $sql="SELECT MAX(id_compra) AS id_max FROM compra";
        $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
        if (mysql_num_rows($run_sql)){   
            while($row=mysql_fetch_array($run_sql)){
                if($row['id_max']==""){
                    $id_compra = 1;
                }else{
                    $id_compra = ($row['id_max']+1);                
                }          
            }
        }
        
        $sql = "INSERT INTO compra(";
            $sql.= "id_compra,";
            $sql.= "tipo_ident,";
            $sql.= "nro_ident,";
            $sql.= "nombre,";
            $sql.= "apellido,";
            $sql.= "cod_pais,";
            $sql.= "fono,";
            $sql.= "email,";
            $sql.= "ip,";
            $sql.= "total_compra,";
            $sql.= "estado,";
            $sql.= "reg_fecha";
        $sql.= ") VALUES (";
            $sql.="'".$id_compra."',";
            $sql.="'".$tipo_ident."',";
            $sql.="'".$nro_ident."',";
            $sql.="'".$nombre."',";
            $sql.="'".$apellido."',";
            $sql.="'".$cod_pais."',";
            $sql.="'".$fono."',";
            $sql.="'".$email."',";
            $sql.="'".$_SERVER['REMOTE_ADDR']."',";
            $sql.="'".$_SESSION['total_compra']."',";
            $sql.="'0',";
            $sql.="'".date('Y-m-d H:i:s')."')";
        $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
        
        #######################################################################
        
        //Compra Producto
        FOREACH($_SESSION['arr_compra_cabecera_ok'] as $key_cab => $dato_cab){
            
            foreach($_SESSION['arr_compra_detalle_ok'][$key_cab] as $key_det => $dato_det){
                   
                $sql = "INSERT INTO compra_producto(";                    
                    $sql.= "id_compra,";
                    $sql.= "tipo_prod,";
                    $sql.= "id_prod,";
                    $sql.= "nom_prod,";
                    $sql.= "id_comuna,";
                    $sql.= "fecha_in,";
                    $sql.= "fecha_out,";
                    $sql.= "detalle,";
                    $sql.= "cant,";
                    $sql.= "punit,";
                    $sql.= "subtotal,";
                    $sql.= "estado,";
                    $sql.= "reg_fecha";
            	$sql.= ") VALUES (";                    
                    $sql.="'".$id_compra."',";
                    $sql.="'".$dato_cab["tipo_prod"]."',";
                    $sql.="'".$dato_cab["id_prod"]."',";
                    $sql.="'".utf8_decode($dato_cab["nom_prod"])."',";
                    $sql.="'".$dato_cab["id_comuna"]."',";
                    $sql.="'".$dato_cab["fecha_in"]."',";
                    $sql.="'".$dato_cab["fecha_out"]."',";
                    $sql.="'".$dato_det["detalle"]."',";
                    $sql.="'".$dato_det["cant"]."',";
                    $sql.="'".$dato_det["punit"]."',";
                    $sql.="'".$dato_det["subtotal"]."',";
                    $sql.="'0',";
                    $sql.="'".date('Y-m-d H:i:s')."')";
                $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());
            }//EndForeach detalle
            
            
            ///////////////////////////////////////////////////////////////////////
                
            $fecha_ini  = strtotime($dato_cab["fecha_in"]);
            $fecha_fin  = strtotime($dato_cab["fecha_out"]);

            //Se graba fechas alojamiento
            if ($dato_cab["tipo_prod"]=="alojamiento"){
                $fecha_ini  = strtotime($dato_cab["fecha_in"]);
                $fecha_fin  = strtotime($dato_cab["fecha_out"]);

                for($i=$fecha_ini; $i<=$fecha_fin; $i+=86400){
                    $dia=date("Y-m-d",strtotime(date("d-m-Y", $i)));
                    
                    $sql = "INSERT INTO compra_alojam_reservacion(";
                        $sql.= "id_unidad,";
                        $sql.= "fecha,";
                        $sql.= "id_compra,";
                        $sql.= "reg_fecha";
                	$sql.= ") VALUES (";
                        $sql.="'".$dato_cab["id_prod"]."',";
                        $sql.="'".$dia."',";
                        $sql.="'".$id_compra."',";
                        echo $sql.="'".date('Y-m-d H:i:s')."')";
                    $run_sql=mysql_query($sql) or die ('ErrorSql > ' . mysql_error ());                        
                }
            }
            ///////////////////////////////////////////////////////////////////////
        }//EndForeach cabecera
        
        echo '<input type="hidden" id="eco_grabar" value="ok"/>';
        
        $_SESSION['id_compra']= $id_compra;
        $_SESSION['email_cliente']= $email;
        
    }//EndIf valida fechas alojamiento
}
############################################################################################################
} // FIN CASE CLASS
?>

</body>
</html>