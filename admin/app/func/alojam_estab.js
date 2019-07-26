function limpia_form_alojamiento(){
    document.getElementById('form_alojamiento').reset();

    document.getElementById('msn_id').innerHTML             = "";    
    document.getElementById('msn_empresa').innerHTML        = "";
    document.getElementById('msn_nom_estab').innerHTML      = "";
    document.getElementById('msn_tipo_alojam').innerHTML    = "";
    document.getElementById('msn_estrella').innerHTML       = "";
    document.getElementById('msn_id_desayuno').innerHTML    = "";
    document.getElementById('msn_restaurant').innerHTML     = "";
    document.getElementById('msn_bar').innerHTML            = "";
    document.getElementById('msn_quincho').innerHTML        = "";
    document.getElementById('msn_piscina').innerHTML        = "";
    document.getElementById('msn_id_comuna').innerHTML      = "";
    document.getElementById('msn_coordenadas').innerHTML    = "";
    document.getElementById('msn_update').innerHTML         = "";
    document.getElementById('salida').innerHTML             = "";
}

function selecc_alojamiento(id_estab,rut_empr,nom_estab,tipo_alojam,estrella,id_desayuno,restaurant,bar,quincho,piscina,id_comuna,coord_maps){
    
    document.getElementById('id_estab').value       = id_estab;
    document.getElementById('rut_empr').value       = rut_empr;
    document.getElementById('nom_estab').value      = nom_estab;
    document.getElementById('tipo_alojam').value    = tipo_alojam;
    document.getElementById('estrella').value       = estrella;
    document.getElementById('id_desayuno').value    = id_desayuno;
    document.getElementById('restaurant').value     = restaurant;
    document.getElementById('bar').value            = bar;
    document.getElementById('quincho').value        = quincho;
    document.getElementById('piscina').value        = piscina;
    document.getElementById('id_comuna').value      = id_comuna;
    document.getElementById('coord_maps').value     = coord_maps;

    document.getElementById('msn_update').innerHTML = "Esta Actualizando Este Registro.";        
}

function grabar_alojamiento() {
    document.getElementById('msn_id').innerHTML             = "";
    document.getElementById('msn_empresa').innerHTML        = "";
    document.getElementById('msn_nom_estab').innerHTML      = "";
    document.getElementById('msn_tipo_alojam').innerHTML    = "";
    document.getElementById('msn_estrella').innerHTML       = "";
    document.getElementById('msn_id_desayuno').innerHTML    = "";
    document.getElementById('msn_restaurant').innerHTML     = "";
    document.getElementById('msn_bar').innerHTML            = "";
    document.getElementById('msn_quincho').innerHTML        = "";
    document.getElementById('msn_id_comuna').innerHTML      = "";
    document.getElementById('msn_piscina').innerHTML        = "";
    document.getElementById('msn_coordenadas').innerHTML    = "";
    document.getElementById('msn_update').innerHTML         = "";
    document.getElementById('salida').innerHTML             = "";
    
    if (document.getElementById('rut_empr').value =="@") {
        document.getElementById('msn_empresa').innerHTML = "Seleccione Empresa.";
        document.getElementById('rut_empr').focus();
        return false;
    } else {document.getElementById("msn_empresa").innerHTML = "";}
    
    if (document.getElementById('nom_estab').value =="") {
        document.getElementById('msn_nom_estab').innerHTML = "Ingrese Nombre Establecim.";
        document.getElementById('nom_estab').focus();
        return false;
    } else {document.getElementById("msn_nom_estab").innerHTML = "";}

    if (document.getElementById('tipo_alojam').value =="@") {
        document.getElementById('msn_tipo_alojam').innerHTML = "Ingrese Tipo de Alojamiento.";
        document.getElementById('tipo_alojam').focus();
        return false;
    } else {document.getElementById("msn_tipo_alojam").innerHTML = "";}

    if (document.getElementById('estrella').value =="") {
        document.getElementById('msn_estrella').innerHTML = "Ingrese Estrellas.";
        document.getElementById('estrella').focus();
        return false;
    } else {document.getElementById("msn_estrella").innerHTML = "";}


    if (document.getElementById('id_desayuno').value =="@") {
        document.getElementById('msn_id_desayuno').innerHTML = "Ingrese Desayuno.";
        document.getElementById('id_desayuno').focus();
        return false;
    } else {document.getElementById("msn_id_desayuno").innerHTML = "";}
    
    if (document.getElementById('restaurant').value =="@") {
        document.getElementById('msn_restaurant').innerHTML = "Ingrese Restaurant.";
        document.getElementById('restaurant').focus();
        return false;
    } else {document.getElementById("msn_restaurant").innerHTML = "";}
    
    if (document.getElementById('bar').value =="@") {
        document.getElementById('msn_bar').innerHTML = "Ingrese Bar.";
        document.getElementById('bar').focus();
        return false;
    } else {document.getElementById("msn_bar").innerHTML = "";}

    if (document.getElementById('quincho').value =="@") {
        document.getElementById('msn_quincho').innerHTML = "Seleccione Quimcho.";
        document.getElementById('quincho').focus();
        return false;
    } else {document.getElementById("msn_quincho").innerHTML = "";}

    if (document.getElementById('piscina').value =="@") {
        document.getElementById('msn_piscina').innerHTML = "Seleccione piscina.";
        document.getElementById('piscina').focus();
        return false;
    } else {document.getElementById("msn_piscina").innerHTML = "";}

    if (document.getElementById('id_comuna').value =="@") {
        document.getElementById('msn_id_comuna').innerHTML = "Seleccione Comuna.";
        document.getElementById('id_comuna').focus();
        return false;
    } else {document.getElementById("msn_id_comuna").innerHTML = "";}


    if (document.getElementById('coord_maps').value =="") {
        document.getElementById('msn_coordenadas').innerHTML = "Ingrese Coordenadas.";
        document.getElementById('coord_maps').focus();
        return false;
    } else {document.getElementById("msn_coordenadas").innerHTML = "";}
    
        
    id_estab        = document.getElementById('id_estab').value;
    rut_empr        = document.getElementById('rut_empr').value;
    nom_estab       = document.getElementById('nom_estab').value;
    tipo_alojam     = document.getElementById('tipo_alojam').value;
    estrella        = document.getElementById('estrella').value;
    id_desayuno     = document.getElementById('id_desayuno').value;
    restaurant      = document.getElementById('restaurant').value;
    bar             = document.getElementById('bar').value;
    quincho         = document.getElementById('quincho').value;
    piscina         = document.getElementById('piscina').value;
    id_comuna       = document.getElementById('id_comuna').value;
    coord_maps      = document.getElementById('coord_maps').value;

    var ajax=XMLHttp();
    
    ajax.open("GET","alojam_estab.php?op=2"
                                    +"&id_estab="+id_estab
                                    +"&rut_empr="+rut_empr
                                    +"&nom_estab="+nom_estab
                                    +"&tipo_alojam="+tipo_alojam
                                    +"&estrella="+estrella
                                    +"&id_desayuno="+id_desayuno
                                    +"&restaurant="+restaurant
                                    +"&bar="+bar
                                    +"&quincho="+quincho
                                    +"&piscina="+piscina
                                    +"&id_comuna="+id_comuna                                           
                                    +"&coord_maps="+coord_maps,true);
                
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
    /////////////////////////////////////////////////////////////////////////////    
    ajax.onreadystatechange = function() {  
    
        if (ajax.readyState == 4) {       
            var respuesta=ajax.responseText;            
            document.getElementById('salida').innerHTML=respuesta;
            valida_sesion();
            
            if (document.getElementById('eco_grabar').value=="insert_ok"){ 
                grilla_alojamiento('grabar');
                document.getElementById('id_estab').value = document.getElementById('eco_id').value;
                document.getElementById('msn_update').innerHTML = "Esta Actualizando Este Registro.";                                    
                jAlert("Se ha agregado el nuevo registro con exito.","Informacion");
            
            }else if (document.getElementById('eco_grabar').value=="update_ok"){
                grilla_alojamiento('grabar');              
                document.getElementById('msn_update').innerHTML = "Esta Actualizando Este Registro.";      
                jAlert("Registro existente se ha actualizado con exito.","Informacion");
            }
        } 
    }
    ajax.send(null);    
}

function eliminar_alojamiento(){
    document.getElementById('msn_id').innerHTML             = "";
    document.getElementById('msn_empresa').innerHTML        = "";
    document.getElementById('msn_nom_estab').innerHTML      = "";
    document.getElementById('msn_tipo_alojam').innerHTML    = "";
    document.getElementById('msn_estrella').innerHTML       = "";
    document.getElementById('msn_id_desayuno').innerHTML    = "";
    document.getElementById('msn_restaurant').innerHTML     = "";
    document.getElementById('msn_bar').innerHTML            = "";
    document.getElementById('msn_quincho').innerHTML        = "";
    document.getElementById('msn_piscina').innerHTML        = "";
    document.getElementById('msn_id_comuna').innerHTML      = "";
    document.getElementById('msn_coordenadas').innerHTML    = "";
    document.getElementById('msn_update').innerHTML         = "";
    document.getElementById('salida').innerHTML             = "";
      
    if (document.getElementById('id_estab').value =="" || document.getElementById('nom_estab').value =="") {
        document.getElementById('msn_id').innerHTML = "Seleccione Registro.";
        return false;
    } else {document.getElementById("msn_id").innerHTML = "";}
    
    id_estab    = document.getElementById('id_estab').value;
    nom_estab   = document.getElementById('nom_estab').value;
    
    //jconfirm
    jConfirm("<table style='font: 12px Arial;'><tr><td colspan='2'>Esta seguro(a) que desea Eliminar el siguiente registro?:<td></tr>"
            +"<tr><td>  &nbsp;&nbsp;&bull;&nbsp;&nbsp; ID</td>                  <td>: "+id_estab+"</td></tr>"
            +"<tr><td>  &nbsp;&nbsp;&bull;&nbsp;&nbsp; Nombre Establecim</td>   <td>: "+nom_estab+"</td></tr>"
            +"</table>"
            , "Confirmacion", function(r) {
            if(r) {
    //jconfirm
    
    var ajax=XMLHttp();
    ajax.open("GET","alojam_estab.php?op=3"
                                +"&id_estab="+id_estab
                                +"&nom_estab="+nom_estab,true);
                
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////  
    ajax.onreadystatechange = function() {
    
        if (ajax.readyState == 4) {
            var respuesta=ajax.responseText;     
            document.getElementById('salida').innerHTML=respuesta;
            valida_sesion();
                
            if (document.getElementById('eco_eliminar').value=="delete_ok"){
                grilla_alojamiento('eliminar'); 
                jAlert("Se ha eliminado el registro con exito.","Informacion");
                
                document.getElementById('id_estab').value       = "";
                document.getElementById('msn_update').innerHTML = "";
            
            }else if (document.getElementById('eco_eliminar').value=="err_delete"){            
                jAlert("Se esta tratando de eliminar un registro que no existe,\nverifique informacion y vuelva a intentar.","Validacion");
            
            }
            
        }}
    ajax.send(null);
    /////////////////////////////////////////////////////////////////////////////
              
    //jconfirm
        } else {   
           return false;
        }
    });
    //jconfirm
}

function grilla_alojamiento(accion){
    document.getElementById('msn_id').innerHTML             = "";
    document.getElementById('msn_empresa').innerHTML        = "";
    document.getElementById('msn_nom_estab').innerHTML      = "";
    document.getElementById('msn_tipo_alojam').innerHTML    = "";
    document.getElementById('msn_estrella').innerHTML       = "";
    document.getElementById('msn_id_desayuno').innerHTML    = "";
    document.getElementById('msn_restaurant').innerHTML     = "";
    document.getElementById('msn_bar').innerHTML            = "";
    document.getElementById('msn_quincho').innerHTML        = "";
    document.getElementById('msn_piscina').innerHTML        = "";
    document.getElementById('msn_id_comuna').innerHTML      = "";
    document.getElementById('msn_coordenadas').innerHTML    = "";

    document.getElementById('msn_update').innerHTML         = "";
    document.getElementById('salida').innerHTML             = "";
 
    var ajax=XMLHttp();
    if (accion=="buscar"){    

        id_estab        = document.getElementById('id_estab').value;
        rut_empr        = document.getElementById('rut_empr').value;
        nom_estab       = document.getElementById('nom_estab').value;
        tipo_alojam     = document.getElementById('tipo_alojam').value;
        estrella        = document.getElementById('estrella').value;
        id_desayuno     = document.getElementById('id_desayuno').value;
        restaurant      = document.getElementById('restaurant').value;
        bar             = document.getElementById('bar').value;
        quincho         = document.getElementById('quincho').value;
        piscina         = document.getElementById('piscina').value;
        id_comuna       = document.getElementById('id_comuna').value;
        coord_maps      = document.getElementById('coord_maps').value;
               
        ajax.open("GET","alojam_estab.php?op=4"
                            +"&id_estab="+id_estab
                            +"&rut_empr="+rut_empr
                            +"&nom_estab="+nom_estab
                            +"&tipo_alojam="+tipo_alojam
                            +"&estrella="+estrella
                            +"&id_desayuno="+id_desayuno
                            +"&restaurant="+restaurant
                            +"&bar="+bar
                            +"&quincho="+quincho
                            +"&piscina="+piscina
                            +"&id_comuna="+id_comuna
                            +"&coord_maps="+coord_maps
                            +"&accion="+accion,true);
    }else{
        ajax.open("GET","alojam_estab.php?op=4&accion="+accion,true);
    }
                
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            var respuesta=ajax.responseText;
            document.getElementById('grilla_alojamiento').innerHTML=respuesta;
            valida_sesion();
        }}
    ajax.send(null);
    /////////////////////////////////////////////////////////////////////////////
}

function go_habit_unidad(id_estab){
    parametros_popup();
    popup_habit_unidad = window.open("alojam_unidad.php?op=1&id_estab="+id_estab,"popup_habit_unidad", param_popup);
    popup_habit_unidad.focus();
}

function go_arch_estab(id_estab){
    parametros_popup();
    popup_arch_estab = window.open("alojam_estab_archivo.php?op=1&id_estab="+id_estab,"popup_arch_estab", param_popup);
    popup_arch_estab.focus();
}

function copy_grilla_alojamiento() {   
    div_grilla=document.getElementById('grilla_alojamiento');
    
    var body = document.body, range, sel;
    if (document.createRange && window.getSelection) {
        range = document.createRange();
        sel = window.getSelection();
        sel.removeAllRanges();
        try {
            range.selectNodeContents(div_grilla);
            sel.addRange(range);
        } catch (e) {
            range.selectNode(div_grilla);
            sel.addRange(range);
        }
    } else if (body.createTextRange) {
        range = body.createTextRange();
        range.moveToElementText(div_grilla);
        range.select();
    }
    
    document.execCommand("copy");
}