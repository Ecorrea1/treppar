<?php
function agregar_carro_compras($tipo_prod, $id_prod) {
    $cnx=conexion();   
        
    //Limpia arreglos antes de llenar
    if(isset($_SESSION['arr_compra_cabecera_ok'])){
        unset($_SESSION['arr_compra_cabecera_ok'][$tipo_prod."@".$id_prod]);
    }    
    
    if(isset($_SESSION['arr_compra_detalle_ok'])){
        unset($_SESSION['arr_compra_detalle_ok'][$tipo_prod."@".$id_prod]);
    }
    
    //Cabecera
    FOREACH ($_SESSION['arr_tmp_compra_cabecera'] as $key_cab => $dato_cab){  
        $key_cab2 = $key_cab;
        
        //Sera crea arreglo compra cabecera
        $_SESSION['arr_compra_cabecera_ok'][$key_cab]=array(
            'tipo_prod' => $dato_cab["tipo_prod"],
            'id_prod' => $dato_cab["id_prod"],
            'nom_prod' => $dato_cab["nom_prod"],
            'id_comuna' => $dato_cab["id_comuna"],
            'nom_comuna' => $dato_cab["nom_comuna"],
            'fecha_in' => $dato_cab["fecha_in"],
            'fecha_out' => $dato_cab["fecha_out"]
        );
    }
    
    //Detalle
    foreach ($_SESSION['arr_tmp_compra_detalle'][$key_cab2] as $key_det => $dato_det){
        //Sera crea arreglo compra detalle
        $_SESSION['arr_compra_detalle_ok'][$key_cab2][]=array(            
            'detalle' => $dato_det["detalle"],
            'cant' => $dato_det["cant"],        
            'punit' => $dato_det["punit"],
            'subtotal' => $dato_det["subtotal"]
        );
    }
}

function eliminar_carro_compras($key_cab) {
    //Limpia arreglos
    //Cabecera
    if(isset($_SESSION['arr_compra_cabecera_ok'])){
        unset($_SESSION['arr_compra_cabecera_ok'][$key_cab]);
    }    
    
    //Detalle
    if(isset($_SESSION['arr_compra_detalle_ok'])){
        unset($_SESSION['arr_compra_detalle_ok'][$key_cab]);
    }
}

function ver_carro_compras() {
    ###################################################################################################
    ###################################################################################################
    $_SESSION['hay_compras']="no";
    $_SESSION['total_compra']=0;
    
    // Muestra datos compra
    if(isset($_SESSION['arr_compra_detalle_ok'])){
        
        if (count($_SESSION['arr_compra_detalle_ok'])==0){
            
            unset($_SESSION['arr_compra_cabecera_ok']);
            unset($_SESSION['arr_compra_detalle_ok']);
            
        }else{
            echo '
            <TABLE width="98%" border="0" cellpadding="0" cellspacing="0" align="center" class="tabla_fondo">
            <TR><TD>
                <br/><center><img src="img/icono_carro_compras.png" width="40px"></center><br/>';
                                
                $n = 0;
                $total_compra = 0;
                
                //Datos Combra Cabecera OK
                FOREACH($_SESSION['arr_compra_cabecera_ok'] as $key_cab => $dato_cab){           
                    $n++;
                    
                    echo '
                    <table width="98%" border="0" cellpadding="0" cellspacing="0" align="center">
                    <tr class="tabla_head_compra">
                        <td align="center" valign="top">';
                            echo '<label style="float:left; border: 1px solid;">&nbsp;&nbsp;'.$n.'&nbsp;&nbsp;</label>';
                            echo '<img src="img/bt_eliminar.png" title="Eliminar" style="float:right;cursor:pointer;" onclick="eliminar_compra('."'".$key_cab."','".$dato_cab["nom_prod"]." - ".$dato_cab["nom_comuna"]."'".');">';
                            
                            echo $dato_cab["nom_prod"]." &#8212; ".$dato_cab["nom_comuna"]."<br/>Fecha Entrada:".date('d-m-Y',strtotime($dato_cab["fecha_in"]))." / Fecha Salida:".date('d-m-Y',strtotime($dato_cab["fecha_out"]));                            
                            
                            echo '<hr color="#fff">';
                        echo '
                        </td>
                    </tr>
                    </table>';
                    
                        //datos Compra Detalle ok
                        $total = 0;
                        
                        echo '
                        <table width="98%" border="0" cellpadding="0" cellspacing="0" align="center">
                        <tr class="tabla_head_compra">
                            <td width="64%">Detalle</td>
                            <td align="center" width="12%" align="center">Cant</td>
                            <td align="center" width="12%" align="center">P.Unit</td>
                            <td align="center" width="12%" align="center">SubTotal</td>
                        </tr>';
                        
                        foreach($_SESSION['arr_compra_detalle_ok'][$key_cab] as $key_det => $dato_det){
                            echo '
                            <tr class="tabla_detalle_compra">
                                <td>'.utf8_encode($dato_det["detalle"]).'</td>
                                <td align="center">'.$dato_det["cant"].'</td>
                                <td align="center">'."$".number_format(($dato_det["punit"]), 0, ",", ".").'</td>
                                <td align="center">'."$".number_format(($dato_det["subtotal"]), 0, ",", ".").'</td>
                            </tr>';
                            $total = (int)($total+$dato_det["subtotal"]);                            
                        }//End foreach detalle
                        echo '
                        <tr class="tabla_head_compra">
                            <td align="right" colspan="3">Total:</td>
                            <td align="center">'."$".number_format(($total), 0, ",", ".").'</td>
                        </tr>
                        </table><br/>';
                        $total_compra = $total_compra+$total;
                        
                }//End foreach cabecera
                
                echo '
                <table width="50%" border="0" cellpadding="0" cellspacing="0" align="center">
                
                <tr class="tabla_head_compra">
                    <td align="center">
                        Total Compra <br/>$'.number_format(($total_compra), 0, ",", ".").'
                    </td>
                </tr>
                </table><br/>
                
            </TD></TR>
            </TABLE>';
            $_SESSION['hay_compras']="si";
            $_SESSION['total_compra']=$total_compra;
                            
        }//Fin If arr_compra_detalle_ok == 0
            
    }//End If existe arreglo
    ###################################################################################################
    ###################################################################################################
}
?>