function limpia_form_actividad_horario(){
    document.getElementById('form_actividad_horario').reset();
    document.getElementById('msn_detalle').innerHTML    = "";
    document.getElementById('msn_horario').innerHTML    = "";
    
    document.getElementById('msn_update').innerHTML     = "";
    document.getElementById('salida').innerHTML         = "";
}

function selecc_actividad_horario(id,detalle,hh_ini,mm_ini,hh_fin,mm_fin) {
    document.getElementById('id_hr').value      = id;
    document.getElementById('detalle').value    = detalle;
    document.getElementById('hh_ini').value     = hh_ini;
    document.getElementById('mm_ini').value     = mm_ini;
    document.getElementById('hh_fin').value     = hh_fin;
    document.getElementById('mm_fin').value     = mm_fin;
    
    document.getElementById('msn_update').innerHTML = "Esta Actualizando Este Registro.";
}

function grabar_actividad_horario(){
    document.getElementById('msn_detalle').innerHTML    = "";
    document.getElementById('msn_horario').innerHTML    = "";
    
    if (document.getElementById('detalle').value =="") {
		document.getElementById('msn_detalle').innerHTML = "Ingrese Detalle.";
		document.getElementById('detalle').focus();
		return false;
	} else {document.getElementById("msn_detalle").innerHTML = "";}
    
    id_hr       = document.getElementById('id_hr').value;
    id_activ    = document.getElementById('id_activ').innerHTML;
    detalle     = document.getElementById('detalle').value;
    hr_ini      = document.getElementById('hh_ini').value+":"+document.getElementById('mm_ini').value;
    hr_fin      = document.getElementById('hh_fin').value+":"+document.getElementById('mm_fin').value;    
    
    var ajax=XMLHttp();
    ajax.open("GET","actividad_horario.php?op=2"
                                    +"&id_hr="+id_hr
                                    +"&id_activ="+id_activ
                                    +"&detalle="+detalle                         
                                    +"&hr_ini="+hr_ini
                                    +"&hr_fin="+hr_fin,true);
                
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////
    ajax.onreadystatechange = function() {
	
		if (ajax.readyState == 4) {
			var respuesta=ajax.responseText;   
			document.getElementById('salida').innerHTML=respuesta;
            valida_sesion("popup");
          
            if (document.getElementById('eco_grabar').value=="insert_ok"){
                grilla_actividad_horario();
                document.getElementById('id_hr').value = document.getElementById('eco_newid').value;
                document.getElementById('msn_update').innerHTML = "Esta Actualizando Este Registro.";
                jAlert("Se ha agregado el nuevo registro con exito.","Informacion");                           
            
            }else if (document.getElementById('eco_grabar').value=="update_ok"){
                grilla_actividad_horario();
                document.getElementById('msn_update').innerHTML = "Esta Actualizando Este Registro.";
                jAlert("Registro existente se ha actualizado con exito.","Informacion");
            }
		}}
    ajax.send(null);
    /////////////////////////////////////////////////////////////////////////////
}

function eliminar_actividad_horario(){
    document.getElementById('msn_detalle').innerHTML    = "";
    document.getElementById('msn_horario').innerHTML    = "";
      
   	if (document.getElementById('id_hr').value =="") {
		document.getElementById('msn_detalle').innerHTML = "Seleccione Registro.";
		return false;
	} else {document.getElementById("msn_detalle").innerHTML = "";}
    
    id_hr       = document.getElementById('id_hr').value;
    id_activ    = document.getElementById('id_activ').innerHTML;
    detalle     = document.getElementById('detalle').value;
    horario     = document.getElementById('hh_ini').value+":"+document.getElementById('mm_ini').value+" -> "+document.getElementById('hh_fin').value+":"+document.getElementById('mm_fin').value;  

    //jconfirm
	jConfirm("<table style='font: 12px Arial;'>"
            +"<tr><td colspan='2'>Esta seguro(a) que desea Eliminar el siguiente registro?:<td></tr>"
            +"<tr><td>  &nbsp;&nbsp;&bull;&nbsp;&nbsp; ID</td>          <td>: "+id_hr+"</td></tr>"
            +"<tr><td>  &nbsp;&nbsp;&bull;&nbsp;&nbsp; Detalle</td>     <td>: "+detalle+"</td></tr>"
            +"<tr><td>  &nbsp;&nbsp;&bull;&nbsp;&nbsp; Horario</td>     <td>: "+horario+"</td></tr>"            
            +"</table>"
            , "Confirmacion", function(r) {
        if(r) {
    //jconfirm
    
    var ajax=XMLHttp();
    ajax.open("GET","actividad_horario.php?op=3"    
                                    +"&id_hr="+id_hr
                                    +"&id_activ="+id_activ
                                    +"&detalle="+detalle
                                    +"&horario="+horario,true);
                
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////
    ajax.onreadystatechange = function() {	
		if (ajax.readyState == 4) {		  
			var respuesta=ajax.responseText;
			document.getElementById('salida').innerHTML=respuesta;
            valida_sesion("popup");
            
            if (document.getElementById('eco_eliminar').value=="delete_ok"){
                grilla_actividad_horario();
                jAlert("Se ha eliminado el registro con exito.","Informacion");
                document.getElementById('id_hr').value  = "";
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

function grilla_actividad_horario(){
    document.getElementById('msn_detalle').innerHTML    = "";
    document.getElementById('msn_horario').innerHTML    = "";
    
    id_activ = document.getElementById('id_activ').innerHTML;
    
    var ajax=XMLHttp();
    ajax.open("GET","actividad_horario.php?op=4"
                                    +"&id_activ="+id_activ,true);
                                        
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////    
    ajax.onreadystatechange = function() {
	
		if (ajax.readyState == 4) {		  
			var respuesta=ajax.responseText; 
			document.getElementById('grilla_actividad_horario').innerHTML=respuesta;
            valida_sesion("popup");
            
            opener.document.getElementById('form_actividad').bt_reload.onclick();
      	}}
    ajax.send(null);
    /////////////////////////////////////////////////////////////////////////////
}

function copy_grilla_actividad_horario() {
    div_grilla=document.getElementById('grilla_actividad_horario');
    
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