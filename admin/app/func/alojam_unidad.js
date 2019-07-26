function limpia_form_alojam_unidad(){
    document.getElementById('form_alojam_unidad').reset();        
    document.getElementById('msn_nom_unidad').innerHTML = "";
    document.getElementById('msn_obs').innerHTML        = "";    
    document.getElementById('msn_precio').innerHTML     = "";
    document.getElementById('msn_dolar').innerHTML      = "";    
    document.getElementById('msn_update').innerHTML     = "";
    document.getElementById('salida').innerHTML         = "";
}

function cont_char1(txt){
    nchar1.value = 250-(document.getElementById('obs').value.length);
}

function selecc_alojam_unidad(
id_unidad,nom_unidad,id_estab,cant_persona,cant_habitacion,cant_bano_ind,cant_bano_com,cant_cama_litera,cant_cama_1plaza,cant_cama_1plazamedia,cant_cama_2plaza,
cant_cama_king,cocina,comedor,jacuzzi,wifi,estacionam,obs,precio,dolar) {
    
    document.getElementById('id_unidad').value              = id_unidad;
    document.getElementById('nom_unidad').value             = nom_unidad;
    document.getElementById('id_estab').innerHTML           = id_estab;
    document.getElementById('cant_persona').value           = cant_persona;
    document.getElementById('cant_habitacion').value        = cant_habitacion;
    document.getElementById('cant_bano_ind').value          = cant_bano_ind;
    document.getElementById('cant_bano_com').value          = cant_bano_com;
    document.getElementById('cant_cama_litera').value       = cant_cama_litera;
    document.getElementById('cant_cama_1plaza').value       = cant_cama_1plaza;
    document.getElementById('cant_cama_1plazamedia').value  = cant_cama_1plazamedia;
    document.getElementById('cant_cama_2plaza').value       = cant_cama_2plaza;
    document.getElementById('cant_cama_king').value         = cant_cama_king;
    
    if (cocina=="1"){ document.getElementById('chk_cocina').checked=true;}else{ document.getElementById('chk_cocina').checked=false; }
    if (comedor=="1"){ document.getElementById('chk_comedor').checked=true;}else{ document.getElementById('chk_comedor').checked=false; }
    if (jacuzzi=="1"){ document.getElementById('chk_jacuzzi').checked=true;}else{ document.getElementById('chk_jacuzzi').checked=false; }
    if (wifi=="1"){ document.getElementById('chk_wifi').checked=true;}else{ document.getElementById('chk_wifi').checked=false; }
    if (estacionam=="1"){ document.getElementById('chk_estacionam').checked=true;}else{ document.getElementById('chk_estacionam').checked=false; }
    
    document.getElementById('obs').value    = obs;    
    document.getElementById('precio').value = precio;    
    document.getElementById('dolar').value  = dolar;
   
    document.getElementById('msn_update').innerHTML = "Esta Actualizando Este Registro.";
}

function grabar_alojam_unidad(){
    document.getElementById('msn_nom_unidad').innerHTML = "";
    document.getElementById('msn_obs').innerHTML        = "";    
    document.getElementById('msn_precio').innerHTML     = "";
    document.getElementById('msn_dolar').innerHTML      = "";
    
    if (document.getElementById('nom_unidad').value =="") {
		document.getElementById('msn_nom_unidad').innerHTML = "Ingrese Nombre.";
		document.getElementById('nom_unidad').focus();
		return false;
	} else {document.getElementById("msn_nom_unidad").innerHTML = "";}
    
    if (document.getElementById('obs').value =="") {
		document.getElementById('msn_obs').innerHTML = "Ingrese Obs.";
		document.getElementById('obs').focus();
		return false;
	} else {document.getElementById("msn_obs").innerHTML = "";}
    
    if (document.getElementById('precio').value=="") {
        document.getElementById('msn_precio').innerHTML = "Ingrese Precio.";
		document.getElementById('precio').focus();
		return false;
	} else {document.getElementById("msn_precio").innerHTML = "";}
    
    if (document.getElementById('dolar').value=="") {
        document.getElementById('msn_dolar').innerHTML = "Ingrese Dolar.";
		document.getElementById('dolar').focus();
		return false;
	} else {document.getElementById("msn_dolar").innerHTML = "";}
    
    //////////////////////////////////////////////////////////////
    
    id_estab                = document.getElementById('id_estab').innerHTML;    
    id_unidad               = document.getElementById('id_unidad').value;
    nom_unidad              = document.getElementById('nom_unidad').value;
    cant_persona            = document.getElementById('cant_persona').value;
    cant_habitacion         = document.getElementById('cant_habitacion').value;
    cant_bano_ind           = document.getElementById('cant_bano_ind').value;
    cant_bano_com           = document.getElementById('cant_bano_com').value;
    
    cant_cama_litera        = document.getElementById('cant_cama_litera').value;
    cant_cama_1plaza        = document.getElementById('cant_cama_1plaza').value;
    cant_cama_1plazamedia   = document.getElementById('cant_cama_1plazamedia').value;
    cant_cama_2plaza        = document.getElementById('cant_cama_2plaza').value;
    cant_cama_king          = document.getElementById('cant_cama_king').value;
    
    if (document.getElementById('chk_cocina').checked==true){ cocina="1";}else{ cocina="0"; }
    if (document.getElementById('chk_comedor').checked==true){ comedor="1";}else{ comedor="0"; }
    if (document.getElementById('chk_jacuzzi').checked==true){ jacuzzi="1";}else{ jacuzzi="0"; }
    if (document.getElementById('chk_wifi').checked==true){ wifi="1";}else{ wifi="0"; }
    if (document.getElementById('chk_estacionam').checked==true){ estacionam="1";}else{ estacionam="0"; }
    
    obs     = document.getElementById('obs').value;
    precio  = document.getElementById('precio').value;
    dolar   = document.getElementById('dolar').value;
    
    var ajax=XMLHttp();
    ajax.open("GET","alojam_unidad.php?op=2"
                                    +"&id_estab="+id_estab
                                    
                                    +"&id_unidad="+id_unidad
                                    +"&nom_unidad="+nom_unidad
                                    +"&cant_persona="+cant_persona
                                    +"&cant_habitacion="+cant_habitacion
                                    +"&cant_bano_ind="+cant_bano_ind
                                    +"&cant_bano_com="+cant_bano_com
                                    
                                    +"&cant_cama_litera="+cant_cama_litera
                                    +"&cant_cama_1plaza="+cant_cama_1plaza
                                    +"&cant_cama_1plazamedia="+cant_cama_1plazamedia
                                    +"&cant_cama_2plaza="+cant_cama_2plaza
                                    +"&cant_cama_king="+cant_cama_king
                                    
                                    +"&cocina="+cocina
                                    +"&comedor="+comedor
                                    +"&jacuzzi="+jacuzzi
                                    +"&wifi="+wifi
                                    +"&estacionam="+estacionam
                                    
                                    +"&obs="+obs
                                    +"&precio="+precio                                    
                                    +"&dolar="+dolar,true);
                
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////
    ajax.onreadystatechange = function() {
	
		if (ajax.readyState == 4) {
			var respuesta=ajax.responseText;   
			document.getElementById('salida').innerHTML=respuesta;
            valida_sesion("popup");
          
            if (document.getElementById('eco_grabar').value=="insert_ok"){
                grilla_alojam_unidad();
                document.getElementById('id_unidad').value = document.getElementById('eco_newid').value;
                document.getElementById('msn_update').innerHTML = "Esta Actualizando Este Registro.";
                jAlert("Se ha agregado el nuevo registro con exito.","Informacion");                           
            
            }else if (document.getElementById('eco_grabar').value=="update_ok"){
                grilla_alojam_unidad();
                document.getElementById('msn_update').innerHTML = "Esta Actualizando Este Registro.";
                jAlert("Registro existente se ha actualizado con exito.","Informacion");
            }
		}}
    ajax.send(null);
    /////////////////////////////////////////////////////////////////////////////   
}

function eliminar_alojam_unidad(){
    document.getElementById('msn_nom_unidad').innerHTML = "";
    document.getElementById('msn_obs').innerHTML        = "";    
    document.getElementById('msn_precio').innerHTML     = "";
    document.getElementById('msn_dolar').innerHTML      = "";
    
   	if (document.getElementById('id_unidad').value =="") {
		document.getElementById('msn_nom_unidad').innerHTML = "Seleccione Registro.";
		return false;
	} else {document.getElementById("msn_nom_unidad").innerHTML = "";}
    
    id_estab    = document.getElementById('id_estab').innerHTML;
    id_unidad   = document.getElementById('id_unidad').value;
    nom_unidad  = document.getElementById('nom_unidad').value;
    
    //jconfirm
	jConfirm("<table style='font: 12px Arial;'>"
            +"<tr><td colspan='2'>Esta seguro(a) que desea Eliminar el siguiente registro?:<td></tr>"
            +"<tr><td>  &nbsp;&nbsp;&bull;&nbsp;&nbsp; ID</td>      <td>: "+id_unidad+"</td></tr>"
            +"<tr><td>  &nbsp;&nbsp;&bull;&nbsp;&nbsp; Nombre</td>  <td>: "+nom_unidad+"</td></tr>"         
            +"</table>"
            , "Confirmacion", function(r) {
        if(r) {
    //jconfirm
    
    var ajax=XMLHttp();
    ajax.open("GET","alojam_unidad.php?op=3"
                                    +"&id_estab="+id_estab  
                                    +"&id_unidad="+id_unidad
                                    +"&nom_unidad="+nom_unidad,true);
                
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////
    ajax.onreadystatechange = function() {	
		if (ajax.readyState == 4) {		  
			var respuesta=ajax.responseText;
			document.getElementById('salida').innerHTML=respuesta;
            valida_sesion("popup");
            
            if (document.getElementById('eco_eliminar').value=="delete_ok"){
                grilla_alojam_unidad();
                jAlert("Se ha eliminado el registro con exito.","Informacion");
                document.getElementById('id_unidad').value      = "";
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

function grilla_alojam_unidad(){
    document.getElementById('msn_nom_unidad').innerHTML = "";
    document.getElementById('msn_obs').innerHTML        = "";    
    document.getElementById('msn_precio').innerHTML     = "";
    document.getElementById('msn_dolar').innerHTML      = "";
    
    id_estab = document.getElementById('id_estab').innerHTML;
    
    var ajax=XMLHttp();
    ajax.open("GET","alojam_unidad.php?op=4"
                                    +"&id_estab="+id_estab,true);
                                        
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////    
    ajax.onreadystatechange = function() {
	
		if (ajax.readyState == 4) {		  
			var respuesta=ajax.responseText; 
			document.getElementById('grilla_alojam_unidad').innerHTML=respuesta;
            valida_sesion("popup");
            
            opener.document.getElementById('form_alojamiento').bt_reload.onclick();
      	}}
    ajax.send(null);
    /////////////////////////////////////////////////////////////////////////////
}

function go_arch_unidad(id_unidad){
    location.href = "alojam_unidad_archivo.php?op=1&id_unidad="+id_unidad;
}