function limpia_form_empresa(){
    document.getElementById('form_empresa').reset();
        
    document.getElementById('msn_rut').innerHTML              = "";
    document.getElementById('msn_razon_social').innerHTML     = "";
    document.getElementById('msn_contacto').innerHTML         = "";
    document.getElementById('msn_fono1').innerHTML            = "";
    document.getElementById('msn_fono2').innerHTML            = "";
    document.getElementById('msn_email').innerHTML            = "";
    document.getElementById('msn_domicilio').innerHTML        = "";
    document.getElementById('msn_id_comuna').innerHTML        = "";
    document.getElementById('msn_estado').innerHTML           = "";
    document.getElementById('msn_update').innerHTML           = "";
    document.getElementById('salida').innerHTML               = "";
}

function selecc_empresa(rut,razon_social,contacto,fono1,fono2,email,domicilio,id_comuna,estado){
    document.getElementById('rut').value            = rut;
    document.getElementById('razon_social').value   = razon_social;
    document.getElementById('contacto').value       = contacto;
    document.getElementById('fono1').value          = fono1;
    document.getElementById('fono2').value       	= fono2;
    document.getElementById('email').value          = email;
    document.getElementById('domicilio').value      = domicilio;
    document.getElementById('id_comuna').value      = id_comuna;
    document.getElementById('estado').value         = estado;
    document.getElementById('msn_update').innerHTML = "Esta Actualizando Este Registro.";        
}

function grabar_empresa(){
    document.getElementById('msn_rut').innerHTML             = "";
    document.getElementById('msn_razon_social').innerHTML    = "";
    document.getElementById('msn_contacto').innerHTML        = "";
    document.getElementById('msn_fono1').innerHTML           = "";
    document.getElementById('msn_fono2').innerHTML           = "";
    document.getElementById('msn_email').innerHTML           = "";
    document.getElementById('msn_domicilio').innerHTML       = "";
    document.getElementById('msn_id_comuna').innerHTML       = "";
    document.getElementById('msn_estado').innerHTML          = "";
    document.getElementById('msn_update').innerHTML          = "";
    document.getElementById('salida').innerHTML              = "";
    
   	if (document.getElementById('rut').value =="") {
		document.getElementById('msn_rut').innerHTML = "Ingrese Rut.";
		document.getElementById('rut').focus();
		return false;
	} else {document.getElementById("msn_rut").innerHTML = "";}
    
   	if (document.getElementById('razon_social').value =="") {
		document.getElementById('msn_razon_social').innerHTML = "Ingrese Razon Social.";
		document.getElementById('razon_social').focus();
		return false;
	} else {document.getElementById("msn_razon_social").innerHTML = "";}

    if (document.getElementById('contacto').value =="") {
        document.getElementById('msn_contacto').innerHTML = "Ingrese contacto.";
        document.getElementById('contacto').focus();
        return false;
    } else {document.getElementById("msn_contacto").innerHTML = "";}

    if (document.getElementById('fono1').value =="") {
        document.getElementById('msn_fono1').innerHTML = "Ingrese fono1.";
        document.getElementById('fono1').focus();
        return false;
    } else {document.getElementById("msn_fono1").innerHTML = "";}    
    
    if (document.getElementById('email').value =="") {
        document.getElementById('msn_email').innerHTML = "Ingrese email.";
        document.getElementById('email').focus();
        return false;
    } else {document.getElementById("msn_email").innerHTML = "";}
    
    if (document.getElementById('domicilio').value =="") {
        document.getElementById('msn_domicilio').innerHTML = "Ingrese Domicilio.";
        document.getElementById('domicilio').focus();
        return false;
    } else {document.getElementById("msn_domicilio").innerHTML = "";}

    if (document.getElementById('id_comuna').value =="@") {
        document.getElementById('msn_id_comuna').innerHTML = "Seleccione Comuna.";
        document.getElementById('id_comuna').focus();
        return false;
    } else {document.getElementById("msn_id_comuna").innerHTML = "";}
    
   	if (document.getElementById('estado').value =="@") {
		document.getElementById('msn_estado').innerHTML = "Seleccione estado.";
		document.getElementById('estado').focus();
		return false;
	} else {document.getElementById("msn_estado").innerHTML = "";}

    rut               = document.getElementById('rut').value;
    razon_social      = document.getElementById('razon_social').value;
    contacto          = document.getElementById('contacto').value;
    fono1             = document.getElementById('fono1').value;
    fono2             = document.getElementById('fono2').value;
    email             = document.getElementById('email').value;
    domicilio         = document.getElementById('domicilio').value;
    id_comuna         = document.getElementById('id_comuna').value;
    estado            = document.getElementById('estado').value;
    
    var ajax=XMLHttp();    
    ajax.open("GET","man_empresa.php?op=2"
                                +"&rut="+rut
                                +"&razon_social="+razon_social
                                +"&contacto="+contacto
                                +"&fono1="+fono1
                                +"&fono2="+fono2
                                +"&email="+email
                                +"&domicilio="+domicilio
                                +"&id_comuna="+id_comuna                
                                +"&estado="+estado);
                
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
    /////////////////////////////////////////////////////////////////////////////    
    ajax.onreadystatechange = function() {	
		if (ajax.readyState == 4) {		  
			var respuesta=ajax.responseText;            
			document.getElementById('salida').innerHTML=respuesta; 
                      
            if (document.getElementById('eco_grabar').value=="insert_ok"){ 
                grilla_empresa('grabar');
                document.getElementById('msn_update').innerHTML = "Esta Actualizando Este Registro.";                                    
                jAlert("Se ha agregado el nuevo registro con exito.","Informacion");
                
                                                 
            
            }else if (document.getElementById('eco_grabar').value=="update_ok"){
                grilla_empresa('grabar');              
                document.getElementById('msn_update').innerHTML = "Esta Actualizando Este Registro.";      
                jAlert("Registro existente se ha actualizado con exito.","Informacion");               
         
			} 
		}
	}
    ajax.send(null);  
}

function eliminar_empresa(){
    document.getElementById('msn_rut').innerHTML             = "";
    document.getElementById('msn_razon_social').innerHTML    = "";
    document.getElementById('msn_contacto').innerHTML        = "";
    document.getElementById('msn_fono1').innerHTML           = "";
    document.getElementById('msn_fono2').innerHTML           = "";
    document.getElementById('msn_email').innerHTML           = "";
    document.getElementById('msn_domicilio').innerHTML       = "";
    document.getElementById('msn_id_comuna').innerHTML       = "";
    document.getElementById('msn_estado').innerHTML          = "";
    document.getElementById('msn_update').innerHTML          = "";
    document.getElementById('salida').innerHTML              = "";
      
   	if (document.getElementById('rut').value =="" && document.getElementById('razon_social').value =="") {
		document.getElementById('msn_rut').innerHTML = "Seleccione Registro.";
		return false;
	} else {document.getElementById("msn_rut").innerHTML = "";}
    
    rut     = document.getElementById('rut').value;
    razon_social  = document.getElementById('razon_social').value;
    
    //jconfirm
	jConfirm("<table style='font: 12px Arial;'><tr><td colspan='2'>Esta seguro(a) que desea Eliminar el siguiente registro?:<td></tr>"
            +"<tr><td>  &nbsp;&nbsp;&bull;&nbsp;&nbsp; Rut</td>     <td>: "+rut+"</td></tr>"
            +"<tr><td>  &nbsp;&nbsp;&bull;&nbsp;&nbsp; Razon Social</td>  <td>: "+razon_social+"</td></tr>"
            +"</table>"
            , "Confirmacion", function(r) {
            if(r) {
    //jconfirm
    
    var ajax=XMLHttp();
    ajax.open("GET","man_empresa.php?op=3"
                                +"&rut="+rut
                                +"&razon_social="+razon_social,true);
                
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////  
    ajax.onreadystatechange = function() {
	
		if (ajax.readyState == 4) {
			var respuesta=ajax.responseText;     
			document.getElementById('salida').innerHTML=respuesta;
            
            if (document.getElementById('eco_eliminar').value=="delete_ok"){
                grilla_empresa('eliminar'); 
                jAlert("Se ha eliminado el registro con exito.","Informacion");
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

function grilla_empresa(accion){
    document.getElementById('msn_rut').innerHTML             = "";
    document.getElementById('msn_razon_social').innerHTML    = "";
    document.getElementById('msn_contacto').innerHTML        = "";
    document.getElementById('msn_fono1').innerHTML           = "";
    document.getElementById('msn_fono2').innerHTML           = "";
    document.getElementById('msn_email').innerHTML           = "";
    document.getElementById('msn_domicilio').innerHTML       = "";
    document.getElementById('msn_id_comuna').innerHTML       = "";
    document.getElementById('msn_estado').innerHTML          = "";
    document.getElementById('msn_update').innerHTML          = "";
    document.getElementById('salida').innerHTML              = "";
 
    var ajax=XMLHttp();
    if (accion=="buscar"){    
        rut          = document.getElementById('rut').value;
        razon_social = document.getElementById('razon_social').value;
        contacto     = document.getElementById('contacto').value;
        fono1        = document.getElementById('fono1').value;
        fono2        = document.getElementById('fono2').value;
        email        = document.getElementById('email').value;
        domicilio    = document.getElementById('domicilio').value;
        id_comuna    = document.getElementById('id_comuna').value;
        estado       = document.getElementById('estado').value;
               
        ajax.open("GET","man_empresa.php?op=4"
                            +"&rut="+rut
                            +"&razon_social="+razon_social
                            +"&contacto="+contacto
                            +"&fono1="+fono1
                            +"&fono2="+fono2
                            +"&email="+email
                            +"&domicilio="+domicilio
                            +"&id_comuna="+id_comuna
                            +"&estado="+estado
                            +"&accion="+accion,true);
    }else{
        ajax.open("GET","man_empresa.php?op=4&accion="+accion,true);
    }
                
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
            var respuesta=ajax.responseText;
            document.getElementById('grilla_empresa').innerHTML=respuesta;
        }}
    ajax.send(null);
    /////////////////////////////////////////////////////////////////////////////
}

function copy_grilla_empresa() {   
    div_grilla=document.getElementById('grilla_empresa');
    
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

