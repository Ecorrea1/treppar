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
    <script src="func/tour_actividad_reservar.js" type="text/javascript"></script>
  
    <!--Google translate --> 
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

</head>

<body class="body">     

<?php
require_once ("func/cnx.php");
require_once ("tour_carro_compra.php");

$op = isset($_GET['op'])?$_GET['op']:null;

$activ_reservar= new activ_reservar();
switch($op){
    case'1':
        $activ_reservar->inicio_reservar_activ();
        break;
    
    case'2':
        $activ_reservar->valores_reservar_activ();
        break;
        
    case'3':
        $activ_reservar->carrocompras_reservar_activ();
        break;
}

class activ_reservar{

###########################################################################################################
public function inicio_reservar_activ(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    $id_activ = isset($_GET['id_activ'])?$_GET['id_activ']:null;    
    
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
    $sql.="actividad.hr_inicio, ";
    
    $sql.="actividad.precio_adultojoven, ";
    $sql.="actividad.precio_nino, ";
    $sql.="actividad.precio_adultomayor, ";
    $sql.="actividad.precio_grupo, ";
    
    $sql.="actividad.dscto_adultojoven, ";
    $sql.="actividad.dscto_nino, ";
    $sql.="actividad.dscto_adultomayor, ";  
    $sql.="actividad.dscto_grupo ";
    
    $sql.="FROM actividad ";    
    $sql.="INNER JOIN man_tipo_actividad ON actividad.id_tipo_activ = man_tipo_actividad.id_tipo_activ ";
    $sql.="INNER JOIN man_comuna ON actividad.id_comuna = man_comuna.id_comuna ";
    $sql.="WHERE id_activ='".$id_activ."'";
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
                    $porc_cobro_gestion = $row2['porc_cobro_gestion'];
                }                        
                
            }else{
                $porc_cobro_gestion = 0;
            }
            
            $precio_adultojoven = ( $row['precio_adultojoven'] - (($row['precio_adultojoven'] * $row['dscto_adultojoven'])/100) );
            $precio_adultojoven = ( $precio_adultojoven + (( $precio_adultojoven * $porc_cobro_gestion)/100) );
            
            $precio_adultomayor = ( $row['precio_adultomayor'] - (($row['precio_adultomayor'] * $row['dscto_adultomayor'])/100) );
            $precio_adultomayor = ( $precio_adultomayor + (($precio_adultomayor * $porc_cobro_gestion)/100) );
            
            $precio_nino = ( $row['precio_nino'] - (($row['precio_nino'] * $row['dscto_nino'])/100) );
            $precio_nino = ( $precio_nino + (($precio_nino * $porc_cobro_gestion)/100) );
            #######################################################################################################
               
            //Titulo
            echo '
            <div id="google_translate_element" class="traductor"></div>            
            <div class="titulo">'.$row['nom_activ'].' - '.$row['nom_comuna'].'</div>';            
            
            echo '
            <input type="hidden" id="id_activ" value="'.$id_activ.'">
            <input type="hidden" id="nom_activ" value="'.$row['nom_activ'].'">            
            <input type="hidden" id="id_comuna" value="'.$row['id_comuna'].'">
            <input type="hidden" id="nom_comuna" value="'.$row['nom_comuna'].'">
            <input type="hidden" id="precio_adultojoven" value="'.$precio_adultojoven.'">
            <input type="hidden" id="precio_adultomayor" value="'.$precio_adultomayor.'">
            <input type="hidden" id="precio_nino" value="'.$precio_nino.'">';
            
            //Requisitos  
            echo '           
            <table width="98%" border="0" cellpadding="0" cellspacing="0" align="center" class="tabla_fondo">
            <tr><td>&nbsp;</td></tr>
            
            <tr valign="top" style="border-bottom:1px solid #fff;">
                <td align="center">
                    <label class="etq_head">Requisitos:</label><br/>
                    <label class="etq_dato">'.$row['requisito'].'</label>
                </td>
                
                <td align="center">
                    <label class="etq_head">Edad M&iacute;nima:</label><br/>
                    <label class="etq_dato">'.$row['edad_minima'].'</label>
                </td>
                
                <td align="center">
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
                    <br/><br/>
                </td>
            </tr>         
            </table><br/>';
                    
            //Formulario
            echo '
            <table width="98%" border="0" cellpadding="0" cellspacing="0" align="center" class="tabla_fondo">
                                 
            <tr>
                <td class="etq_head" align="center">Fecha Actividad:<br/>
                    <input type="date" id="fecha" style="font-size:30px;" min="'.date('Y-m-d').'" class="txt1">
                    <br><label id="msn_fecha" class="msn_err"></label>
                </td>
            </tr>
            
            <tr><td><hr size="1" color="#fff" width="30%"></td></tr>
            
            <tr>
                <td class="etq_head" align="center">Adultos:<br/>
                    <button type="button" class="bt_menos" onclick="cant_adultojoven_activ('."'-'".');">-</button>
                    <input type="text" id="adultojoven" style="font-size:30px;" size="5" value="0" class="txt1" readonly/>
                    <button type="button" class="bt_mas" onclick="cant_adultojoven_activ('."'+'".');">+</button>
                </td>
            </tr>
            
            <tr><td><hr size="1" color="#fff" width="30%"></td></tr>
           
            <tr>
                <td class="etq_head" align="center">Adultos Mayor:<br/>
                    <button type="button" class="bt_menos" onclick="cant_adultomayor_activ('."'-'".');">-</button>
                    <input type="text" id="adultomayor" style="font-size:30px;" size="5" value="0" class="txt1" readonly/>
                    <button type="button" class="bt_mas" onclick="cant_adultomayor_activ('."'+'".');">+</button>           
                </td>
            </tr>
            
            <tr><td><hr size="1" color="#fff" width="30%"></td></tr>
            
            <tr>
                <td class="etq_head" align="center">Ni&ntilde;os:<br/>
                    <button type="button" class="bt_menos" onclick="cant_nino_activ('."'-'".');">-</button>
                    <input type="text" id="nino" style="font-size:30px;" size="5" value="0" class="txt1" readonly/>
                    <button type="button" class="bt_mas" onclick="cant_nino_activ('."'+'".');">+</button>
                </td>
            </tr>
            <tr><td><hr size="1" color="#fff" width="30%"></td></tr>               
            </table><br/>';
            
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

public function valores_reservar_activ(){
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
    
    if(isset($_SESSION['arr_tmp_compra_cabecera'])){
        unset($_SESSION['arr_tmp_compra_cabecera']);
    }
    
    if(isset($_SESSION['arr_tmp_compra_detalle'])){
        unset($_SESSION['arr_tmp_compra_detalle']);
    }
        
    $id_activ           = isset($_GET['id_activ'])?$_GET['id_activ']:null;
    $nom_activ          = isset($_GET['nom_activ'])?$_GET['nom_activ']:null;
    $id_comuna          = isset($_GET['id_comuna'])?$_GET['id_comuna']:null;
    $nom_comuna         = isset($_GET['nom_comuna'])?$_GET['nom_comuna']:null;
    $fecha_in           = isset($_GET['fecha_in'])?$_GET['fecha_in']:null;
    $fecha_out          = isset($_GET['fecha_out'])?$_GET['fecha_out']:null;
    
    $cant_adultojoven   = isset($_GET['cant_adultojoven'])?$_GET['cant_adultojoven']:null;
    $cant_adultomayor   = isset($_GET['cant_adultomayor'])?$_GET['cant_adultomayor']:null;
    $cant_nino          = isset($_GET['cant_nino'])?$_GET['cant_nino']:null;
    
    $precio_adultojoven = isset($_GET['precio_adultojoven'])?$_GET['precio_adultojoven']:null;
    $precio_adultomayor = isset($_GET['precio_adultomayor'])?$_GET['precio_adultomayor']:null;
    $precio_nino        = isset($_GET['precio_nino'])?$_GET['precio_nino']:null;
    
    #################################################################################
    $index_cab="actividad@".$id_activ;
    
    //Arreglo
    $_SESSION['arr_tmp_compra_cabecera'][$index_cab]=array(
        'tipo_prod' => "actividad",
        'id_prod' => $id_activ,        
        'nom_prod' => $nom_activ,
        'id_comuna' => $id_comuna,
        'nom_comuna' => $nom_comuna,
        
        'fecha_in' => $fecha_in,
        'fecha_out' => $fecha_out
    );
    
    if ($cant_adultojoven>0){        
        $_SESSION['arr_tmp_compra_detalle'][$index_cab][]=array(
            'detalle' => "Adultos",
            'cant' => $cant_adultojoven,        
            'punit' => $precio_adultojoven,
            'subtotal' => ($cant_adultojoven*$precio_adultojoven),
        );
    }
    
    if ($cant_adultomayor>0){        
        $_SESSION['arr_tmp_compra_detalle'][$index_cab][]=array(
            'detalle' => "Adultos Mayor",
            'cant' => $cant_adultomayor,        
            'punit' => $precio_adultomayor,
            'subtotal' => ($cant_adultomayor*$precio_adultomayor),
        );
    }
    
    if ($cant_nino>0){        
        $_SESSION['arr_tmp_compra_detalle'][$index_cab][]=array(
            'detalle' => "Niños",
            'cant' => $cant_nino,        
            'punit' => $precio_nino,
            'subtotal' => ($cant_nino*$precio_nino),
        );
    }
    
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
                                <input type="button" value="Agregar a mi Compra +" class="bt_verde" onclick="agregar_compra_activ();">
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

public function carrocompras_reservar_activ(){
    $accion = isset($_GET['accion'])?$_GET['accion']:null;
    
    if ($accion=="agregar"){
        $id_activ = isset($_GET['id_activ'])?$_GET['id_activ']:null;
        agregar_carro_compras("actividad", $id_activ);
        
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