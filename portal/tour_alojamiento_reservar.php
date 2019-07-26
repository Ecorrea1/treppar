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
    <script src="func/tour_alojamiento_reservar.js" type="text/javascript"></script>
  
    <!--Google translate --> 
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

</head>

<body class="body">     

<?php
require_once ("func/cnx.php");
require_once ("tour_carro_compra.php");

$op = isset($_GET['op'])?$_GET['op']:null;

$alojam_reservar= new alojam_reservar();
switch($op){
    case'1':
        $alojam_reservar->inicio_reservar_alojam();
        break;
        
    case'2':
        $alojam_reservar->validarfecha_reservar_alojam();
        break;        
   
    case'3':
        $alojam_reservar->valores_reservar_alojam();
        break;
        
    case'4':
        $alojam_reservar->carrocompras_reservar_alojam();
        break;
}

class alojam_reservar{

###########################################################################################################
public function inicio_reservar_alojam(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    $id_unidad = isset($_GET['id_unidad'])?$_GET['id_unidad']:null;
    
    $sql= "SELECT ";
    $sql.="alojam_unidad.id_unidad, ";
    $sql.="alojam_unidad.nom_unidad, ";
    $sql.="alojam_unidad.id_estab, ";
    $sql.="alojam_estab.nom_estab, ";
    $sql.="alojam_estab.id_comuna, ";
    $sql.="man_comuna.nom_comuna, ";
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
    $sql.="INNER JOIN alojam_estab ON alojam_unidad.id_estab = alojam_estab.id_estab ";
    $sql.="INNER JOIN man_comuna ON alojam_estab.id_comuna = man_comuna.id_comuna ";
    $sql.="WHERE id_unidad='".$id_unidad."' ";
    $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());               
                
    if (mysql_num_rows($run_sql)){
        while($row=mysql_fetch_array($run_sql)){
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
            
            //Titulo
            echo '
            <input type="button" value="Volver" class="bt_amarillo" style="position:absolute;" onclick="window.history.back();"/>            
            <div id="google_translate_element" class="traductor"></div>
            <div class="titulo" style="text-align:center;">'.$row['nom_unidad']."<br/>".$row['nom_estab'].' - '.$row['nom_comuna'].'</div>';
            
            //Datos Unidad
            echo '            
            <TABLE width="98%" border="0" cellpadding="0" cellspacing="0" align="center" class="tabla_fondo">
            <TR>
            <TD ALIGN="CENTER">';
                
                ################
                
                echo '
                <br/>                
                <table border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td width="4%"></td>
                    <td align="center">';
                    
                        $style_label="float:left; border:1px solid #fff; height:60px; padding:5px;";
                    
                        if ($row['cant_persona']>"0"){          echo '<label style="'.$style_label.'"><label class="etq_head">Personas</label>                    <br/><label id="cant_persona" class="etq_dato">'.$row['cant_persona'].'</label></label>'; }
                        if ($row['cant_habitacion']>"0"){       echo '<label style="'.$style_label.'"><label class="etq_head">Habitaciones</label>                <br/><label class="etq_dato">'.$row['cant_habitacion'].'</label></label>'; }
                        if ($row['cant_bano_ind']>"0"){         echo '<label style="'.$style_label.'"><label class="etq_head">Ba&ntilde;o Independiente</label>   <br/><label class="etq_dato">'.$row['cant_bano_ind'].'</label></label>'; }
                        if ($row['cant_bano_com']>"0"){         echo '<label style="'.$style_label.'"><label class="etq_head">Ba&ntilde;o Compartido</label>      <br/><label class="etq_dato">'.$row['cant_bano_com'].'</label></label>'; }
                        
                        if ($row['cant_cama_litera']>"0"){      echo '<label style="'.$style_label.'"><label class="etq_head">Cama Litera</label>                 <br/><label class="etq_dato">'.$row['cant_cama_litera'].'</label></label>'; }
                        if ($row['cant_cama_1plaza']>"0"){      echo '<label style="'.$style_label.'"><label class="etq_head">Cama 1 Plaza</label>                <br/><label class="etq_dato">'.$row['cant_cama_1plaza'].'</label></label>'; }
                        if ($row['cant_cama_1plazamedia']>"0"){ echo '<label style="'.$style_label.'"><label class="etq_head">Cama 1 Plaza y Media</label>        <br/><label class="etq_dato">'.$row['cant_cama_1plazamedia'].'</label></label>'; }
                        if ($row['cant_cama_2plaza']>"0"){      echo '<label style="'.$style_label.'"><label class="etq_head">Cama 2 Plazas</label>               <br/><label class="etq_dato">'.$row['cant_cama_2plaza'].'</label></label>'; }
                        if ($row['cant_cama_king']>"0"){        echo '<label style="'.$style_label.'"><label class="etq_head">Cama King</label>                   <br/><label class="etq_dato">'.$row['cant_cama_king'].'</label></label>'; }                   
                    
                        if ($row['cocina']=="1"){               echo '<label style="'.$style_label.'"><label class="etq_head">Cocina</label>                      <br/><label class="etq_dato">Si</label></label>'; }
                        if ($row['comedor']=="1"){              echo '<label style="'.$style_label.'"><label class="etq_head">Comedor</label>                     <br/><label class="etq_dato">Si</label></label>'; }
                        if ($row['jacuzzi']=="1"){              echo '<label style="'.$style_label.'"><label class="etq_head">Jacuzzi</label>                     <br/><label class="etq_dato">Si</label></label>'; }
                        if ($row['wifi']=="1"){                 echo '<label style="'.$style_label.'"><label class="etq_head">Wifi</label>                        <br/><label class="etq_dato">Si</label></label>'; }
                        if ($row['estacionam']=="1"){           echo '<label style="'.$style_label.'"><label class="etq_head">Estacionamiento</label>             <br/><label class="etq_dato">Si</label></label>'; }
                        
                        echo '
                        <label style="'.$style_label.'">
                            <label class="etq_head">Precio</label><br/>
                            <label class="etq_dato">$'.number_format($precio, 0, ",", ".").'</label>
                        </label>
                    </td>
                </tr>
                </table><br/>';
                
                echo '
                <input type="hidden" id="id_unidad" value="'.$id_unidad.'">
                <input type="hidden" id="nom_unidad" value="'.$row['nom_unidad'].'">
                <input type="hidden" id="nom_estab" value="'.$row['nom_estab'].'">
                <input type="hidden" id="id_comuna" value="'.$row['id_comuna'].'">
                <input type="hidden" id="nom_comuna" value="'.$row['nom_comuna'].'">
                <input type="hidden" id="precio" value="'.$precio.'">
                <input type="hidden" id="dolar" value="'.$dolar.'">
                </TD>
            </TR>
            </TABLE><br/>';
                    
            //Formulario
            echo '
            <table width="98%" border="0" cellpadding="0" cellspacing="0" align="center" class="tabla_fondo">
            
            <tr>
                <td class="etq_head" align="center">Fecha Entrada:<br/>
                    <input type="date" id="fecha_in" style="font-size:30px; width:25%;" min="'.date('Y-m-d').'" class="txt1" onclick="oculta_divpersonas_alojam();">
                    <br/><label id="msn_fecha_in" class="msn_err"></label>
                </td>
            </tr>
            
            <tr><td><hr size="1" color="#fff" width="30%"></td></tr>
                        
            <tr>
                <td class="etq_head" align="center">Fecha Salida:<br/>
                    <input type="date" id="fecha_out" style="font-size:30px; width:25%;" min="'.date('Y-m-d').'" class="txt1" onclick="oculta_divpersonas_alojam();">
                    <br/><label id="msn_fecha_out" class="msn_err"></label>
                </td>
            </tr>
            
            <tr>
                <td align="center">
                    <label id="msn_valida_reservas" class="msn_err"></label>
                </td>
            </tr>
            
            <tr><td><hr size="1" color="#fff" width="30%"></td></tr>
            
            <tr>
                 <td align="center">
                    <input type="button" value="Buscar" style="width:25%;" class="bt_azul" onclick="validar_fecha_alojam();">
                 </td>
            </tr>            
            
            <tr><td><hr size="1" color="#fff" width="30%"></td></tr>
            </table>
            
            <DIV id="div_personas" style="display:none;">
            
                <table width="98%" border="0" cellpadding="0" cellspacing="0" align="center" class="tabla_fondo">
                <tr>
                
                    <td class="etq_head" align="center">Adulto:<br/>
                        <button type="button" class="bt_menos" onclick="cant_adultojoven_alojam('."'-'".');">-</button>
                        <input type="text" id="adultojoven" style="font-size:30px; width:18%;" value="0" class="txt1" readonly/>
                        <button type="button" class="bt_mas" onclick="cant_adultojoven_alojam('."'+'".');">+</button>
                    </td>
                </tr>
                
                <tr><td><hr size="1" color="#fff" width="30%"></td></tr>
                
                <tr>
                    <td class="etq_head" align="center">Adulto Mayor:<br/>
                        <button type="button" class="bt_menos" onclick="cant_adultomayor_alojam('."'-'".');">-</button>
                        <input type="text" id="adultomayor" style="font-size:30px; width:18%;" value="0" class="txt1" readonly/>
                        <button type="button" class="bt_mas" onclick="cant_adultomayor_alojam('."'+'".');">+</button>           
                    </td>
                </tr>
                
                <tr><td><hr size="1" color="#fff" width="30%"></td></tr>
                
                <tr>
                    <td class="etq_head" align="center">Ni&ntilde;o:<br/>
                        <button type="button" class="bt_menos" onclick="cant_nino_alojam('."'-'".');">-</button>
                        <input type="text" id="nino" style="font-size:30px; width:18%;" value="0" class="txt1" readonly/>
                        <button type="button" class="bt_mas" onclick="cant_nino_alojam('."'+'".');">+</button>
                    </td>
                </tr>
                <tr><td><hr size="1" color="#fff"></td></tr>
                </table><br/>';
                
                //Grilla Valores
                echo '
                <TABLE width="98%" border="0" cellpadding="0" cellspacing="0" align="center" class="tabla_fondo">
                <TR><TD>            
                    <div id="grilla_valores" style="color:#fff;" class="tabla_fondo"> 
                        
                        <br/>                     
                        <table width="98%" border="0" cellpadding="0" cellspacing="0" align="center">
                        <tr class="tabla_head">
                            <td width="70%">Detalle</td>
                            <td width="15%" align="center">Cant Personas</td>
                            <td width="15%" align="center">SubTotal</td>
                        </tr>
                        
                        <tr class="tabla_head">
                            <td colspan="3" align="center">Sin Resultados</td>
                        </tr>
                        </table>
                        <br/>
                        
                    </div>                
                </TD></TR>
                </TABLE><br/>
                
            </DIV>';
            
            //Grilla Valores
            echo '
            <div id="grilla_valores"></div>';
            
            //Grilla Compra
            echo '
            <div id="div_compras">';
                ver_carro_compras();
                
                if ($_SESSION['hay_compras']=="si"){
                    echo '<br><center><input type="button" value="Comprar &raquo;" style="width:50%;" class="bt_morado" onclick="location.href='."'tour_comprar.php?op=1'".';"/></center><br><br>';
                }
    
            echo '
            </div>';
        }
    }
}

public function validarfecha_reservar_alojam(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    $id_unidad  = isset($_GET['id_unidad'])?$_GET['id_unidad']:null;
    $fecha_in   = isset($_GET['fecha_in'])?$_GET['fecha_in']:null;
    $fecha_out  = isset($_GET['fecha_out'])?$_GET['fecha_out']:null;
    
    $sql ="SELECT ";
    $sql.="compra_alojam_reservacion.id_unidad, ";
    $sql.="compra_alojam_reservacion.fecha ";
    $sql.="FROM compra_alojam_reservacion ";    
    $sql.="WHERE id_unidad='".$id_unidad."' AND fecha>='".$fecha_in."' AND fecha<='".$fecha_out."'";
    $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());               
    
    $fechas_usadas="";
                
    if (mysql_num_rows($run_sql)){
        while($row=mysql_fetch_array($run_sql)){
            if ($fechas_usadas==""){
                $fechas_usadas.= date("d-m-Y",strtotime($row['fecha']));    
            }else{
                $fechas_usadas.= ", ".date("d-m-Y",strtotime($row['fecha']));    
            }  
        }
        
        $eco_msn = "<center>Lo sentimos, pero las siguientes fechas fueron reservadas:<br/>";
        $eco_msn.= "<label style='color:#fff;'>".$fechas_usadas."</label><br/>";
        echo $eco_msn.= "Intente con otro rango de fechas.</center>";
        
        echo '<input type="hidden" id="eco_valida_fecha" value="err">';
               
    }else{
        echo '<input type="hidden"id="eco_valida_fecha" value="ok">';    
    }
}


public function valores_reservar_alojam(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    
    if(isset($_SESSION['arr_tmp_compra_cabecera'])){
        unset($_SESSION['arr_tmp_compra_cabecera']);
    }
    
    if(isset($_SESSION['arr_tmp_compra_detalle'])){
        unset($_SESSION['arr_tmp_compra_detalle']);
    }
    
    $id_unidad          = isset($_GET['id_unidad'])?$_GET['id_unidad']:null;    
    $nom_unidad         = isset($_GET['nom_unidad'])?$_GET['nom_unidad']:null;
    $nom_estab          = isset($_GET['nom_estab'])?$_GET['nom_estab']:null;
    $id_comuna          = isset($_GET['id_comuna'])?$_GET['id_comuna']:null;
    $nom_comuna         = isset($_GET['nom_comuna'])?$_GET['nom_comuna']:null;    
    $fecha_in           = isset($_GET['fecha_in'])?$_GET['fecha_in']:null;
    $fecha_out          = isset($_GET['fecha_out'])?$_GET['fecha_out']:null;
    
    $cant_adultojoven   = isset($_GET['cant_adultojoven'])?$_GET['cant_adultojoven']:null;
    $cant_adultomayor   = isset($_GET['cant_adultomayor'])?$_GET['cant_adultomayor']:null;
    $cant_nino          = isset($_GET['cant_nino'])?$_GET['cant_nino']:null;
    
    $precio             = isset($_GET['precio'])?$_GET['precio']:null;
    $dolar              = isset($_GET['dolar'])?$_GET['dolar']:null;
    
    #################################################################################
    $fecha_ini  = strtotime($fecha_in);
    $fecha_fin  = strtotime($fecha_out);
    
    $dias = -1;
    
    for($i=$fecha_ini; $i<=$fecha_fin; $i+=86400){     
        $dias = $dias+1;
    }
    #################################################################################
    $cant_personas = "" ;
    
    if ($cant_adultojoven>0){
        $cant_personas.="Adultos: ".$cant_adultojoven;
    }
    
    if ($cant_adultomayor>0){
        if ($cant_personas!=""){
            $cant_personas.=", ";
        }
        $cant_personas.="Adultos Mayor: ".$cant_adultomayor;
    }
    
    if ($cant_nino>0){
        if ($cant_personas!=""){
            $cant_personas.=", ";
        }
        $cant_personas.="Niños: ".$cant_nino;
    }
    
    #################################################################################
    $index_cab="alojamiento@".$id_unidad;
        
    //Arreglo
    $_SESSION['arr_tmp_compra_cabecera'][$index_cab]=array(
        'tipo_prod' => "alojamiento",
        'id_prod' => $id_unidad,        
        'nom_prod' => $nom_unidad." - ".$nom_estab,
        'id_comuna' => $id_comuna,
        'nom_comuna' => $nom_comuna,
        
        'fecha_in' => $fecha_in,
        'fecha_out' => $fecha_out
    );    
    
    $_SESSION['arr_tmp_compra_detalle'][$index_cab][]=array(
        'detalle' => $dias." Días * $".number_format(($precio), 0, ",", ".")." c/u (".$cant_personas.")",
        'cant' => (int)($dias),        
        'punit' => (int)$precio,
        'subtotal' => (int)($dias*$precio),
    );
    
    ##################################################################################################################
    //Muestra datos
    if(isset($_SESSION['arr_tmp_compra_detalle'])){
        
        if (count($_SESSION['arr_tmp_compra_detalle'])==0){
            
            unset($_SESSION['arr_tmp_compra_cabecera']);
            unset($_SESSION['arr_tmp_compra_detalle']);
            
        }else{
            
            //Muestro Datos cabecera tmp
            foreach($_SESSION['arr_tmp_compra_cabecera'] as $key_cab => $dato_cab){
                echo '
                <TABLE width="98%" border="0" cellpadding="0" cellspacing="0" align="center" class="tabla_fondo">
                <TR><TD>
                    <br/>
                    
                    <table width="98%" border="0" cellpadding="0" cellspacing="0" align="center">
                    <tr class="tabla_head">
                        <td align="center">'.$dato_cab["nom_prod"]." - ".$dato_cab["nom_comuna"]."<br/>Fecha Entrada:".date('d-m-Y',strtotime($dato_cab["fecha_in"]))." / Fecha Salida:".date('d-m-Y',strtotime($dato_cab["fecha_out"])).'</td>
                    </tr>
                    </table>';
                    
                        //Muestro Datos detalle tmp
                        
                        $total = 0;
                        
                        echo '
                        <table width="98%" border="0" cellpadding="0" cellspacing="0" align="center">
                        <tr class="tabla_head">
                            <td width="64%">Detalle</td>
                            <td align="center" width="12%" align="center">Cant</td>
                            <td align="center" width="12%" align="center">P.Unit</td>
                            <td align="center" width="12%" align="center">SubTotal</td>
                        </tr>';
                            foreach($_SESSION['arr_tmp_compra_detalle'][$key_cab] as $key_det => $dato_det){
                                echo '
                                <tr class="tabla_detalle">
                                    <td>'.utf8_encode($dato_det["detalle"]).'</td>
                                    <td align="center">'.$dato_det["cant"].'</td>
                                    <td align="center">'."$".number_format(($dato_det["punit"]), 0, ",", ".").'</td>
                                    <td align="center">'."$".number_format(($dato_det["subtotal"]), 0, ",", ".").'</td>
                                </tr>';
                                $total = (int)($total+$dato_det["subtotal"]);
                            }//ForEach arreglo detalle
                            echo '
                        <tr>
                            <tr class="tabla_head">
                            <td align="right" colspan="3">Total:</td>
                            <td align="center">'."$".number_format(($total), 0, ",", ".").'</td>
                        </tr>
                        
                        <tr>
                            <td align="center" colspan="4">
                                <br/>
                                <input type="button" value="Agregar a mi Compra +" class="bt_verde" onclick="agregar_compra_alojam();">
                                <br/>
                            </td>
                        </tr>
                        </table><br/>
                        
                </TD></TR>
                </TABLE><br/>';
                
            }//ForEach arreglo cabecera
        }//Si arreglo es mayor a cero
    }//EndIf Existe Arreglo
}

public function carrocompras_reservar_alojam(){
    $accion = isset($_GET['accion'])?$_GET['accion']:null;
    
    if ($accion=="agregar"){
        $id_unidad = isset($_GET['id_unidad'])?$_GET['id_unidad']:null;
        agregar_carro_compras("alojamiento", $id_unidad);
        
    }else if ($accion=="eliminar"){
        $key_cab = isset($_GET['key_cab'])?$_GET['key_cab']:null;        
        eliminar_carro_compras($key_cab);
    }
    
    ver_carro_compras();
    
    if ($_SESSION['hay_compras']=="si"){
        echo '<br><center><input type="button" value="Comprar &raquo;" style="width:50%;" class="bt_morado" onclick="location.href='."'tour_comprar.php?op=1'".';"/></center><br><br>';
    }
}
############################################################################################################
} // FIN CASE CLASS
?>
</body>
</html>