function limpia_form_usuario(){
    document.getElementById('form_usuario').reset();
    document.getElementById('msn_rut').innerHTML        = "";
    document.getElementById('msn_nombre').innerHTML     = "";
    document.getElementById('msn_contacto').innerHTML   = ""; 
    document.getElementById('msn_email').innerHTML      = "";
    document.getElementById('msn_fono1').innerHTML      = "";
    document.getElementById('msn_domicilio').innerHTML  = "";
    document.getElementById('msn_comuna').innerHTML     = "";
    document.getElementById('msn_tipo_usu').innerHTML   = "";
    document.getElementById('msn_estado').innerHTML     = "";
    document.getElementById('msn_clave1').innerHTML     = "";
    document.getElementById('msn_clave2').innerHTML     = "";
    document.getElementById('msn_update').innerHTML     = "";
    document.getElementById('salida').innerHTML         = "";
    document.getElementById("clave1").className         = "txt1";
    document.getElementById("clave2").className         = "txt1";
}

function selecc_usuario(rut,nombre,contacto,email,fono1,fono2,domicilio,id_comuna,tipo_usu,estado){
    document.getElementById('rut').value            = rut;
    document.getElementById('nombre').value         = nombre;
    document.getElementById('contacto').value       = contacto;
    document.getElementById('email').value          = email;
    document.getElementById('fono1').value          = fono1;
    document.getElementById('fono2').value          = fono2;
    document.getElementById('domicilio').value      = domicilio;
    document.getElementById('id_comuna').value      = id_comuna;
    document.getElementById('tipo_usu').value       = tipo_usu;
    document.getElementById('estado').value         = estado;
    document.getElementById('msn_update').innerHTML = "Esta Actualizando Este Registro.";
    document.getElementById("clave1").className     = "txt2";
    document.getElementById("clave2").className     = "txt2";
}

function grabar_usuario(){
    valida_sesion();
    
    document.getElementById('msn_rut').innerHTML        = "";
    document.getElementById('msn_nombre').innerHTML     = "";
    document.getElementById('msn_contacto').innerHTML   = ""; 
    document.getElementById('msn_email').innerHTML      = "";
    document.getElementById('msn_fono1').innerHTML      = "";
    document.getElementById('msn_domicilio').innerHTML  = "";
    document.getElementById('msn_comuna').innerHTML     = "";
    document.getElementById('msn_tipo_usu').innerHTML   = "";
    document.getElementById('msn_estado').innerHTML     = "";
    document.getElementById('msn_clave1').innerHTML     = "";
    document.getElementById('msn_clave2').innerHTML     = "";

   	if (document.getElementById('rut').value =="") {
		document.getElementById('msn_rut').innerHTML = "Ingrese Rut.";
		document.getElementById('rut').focus();
		return false;
	} else {document.getElementById("msn_rut").innerHTML = "";}
        

   	if (document.getElementById('nombre').value =="") {
		document.getElementById('msn_nombre').innerHTML = "Ingrese Nombre.";
		document.getElementById('nombre').focus();
		return false;
	} else {document.getElementById("msn_nombre").innerHTML = "";}
    

    if (document.getElementById('contacto').value =="") {
        document.getElementById('msn_contacto').innerHTML = "Ingrese Contacto.";
        document.getElementById('contacto').focus();
        return false;
    } else {document.getElementById("msn_contacto").innerHTML = "";}
    
    
    if (document.getElementById('email').value =="") {
        document.getElementById('msn_email').innerHTML = "Ingrese Email.";
        document.getElementById('email').focus();
        return false;
    } else {document.getElementById("msn_email").innerHTML = "";}
    

    if (document.getElementById('fono1').value =="") {
        document.getElementById('msn_fono1').innerHTML = "Ingrese Fono 1.";
        document.getElementById('fono1').focus();
        return false;
    } else {document.getElementById("msn_fono1").innerHTML = "";}
    

    if (document.getElementById('domicilio').value =="") {
        document.getElementById('msn_domicilio').innerHTML = "Ingrese Domicilio.";
        document.getElementById('domicilio').focus();
        return false;
    } else {document.getElementById("msn_domicilio").innerHTML = "";}


    if (document.getElementById('id_comuna').value =="@") {
        document.getElementById('msn_comuna').innerHTML = "Seleccione Comuna.";
        document.getElementById('id_comuna').focus();
        return false;
    } else {document.getElementById("msn_comuna").innerHTML = "";}


   	if (document.getElementById('tipo_usu').value =="@") {
		document.getElementById('msn_tipo_usu').innerHTML = "Seleccione Tipo.";
		document.getElementById('tipo_usu').focus();
		return false;
	} else {document.getElementById("msn_tipo_usu").innerHTML = "";}
    
    
   	if (document.getElementById('estado').value =="@") {
		document.getElementById('msn_estado').innerHTML = "Seleccione Estado.";
		document.getElementById('estado').focus();
		return false;
	} else {document.getElementById("msn_estado").innerHTML = "";}
        

    //Clave
    if (document.getElementById('clave1').value !="") {
        if (document.getElementById('clave2').value =="") {
		  document.getElementById('msn_clave2').innerHTML = "Ingrese Confirmacion.";
		  document.getElementById('clave2').focus();
		  return false;
        } else {document.getElementById("msn_clave2").innerHTML = "";}

    	if ((document.getElementById('clave1').value) != (document.getElementById('clave2').value)) {
    		document.getElementById('msn_clave2').innerHTML = "Las Claves no coinciden.";
    		document.getElementById('clave2').focus();
    		return false;
    	} else {document.getElementById("msn_clave2").innerHTML = "";}
    }

    rut         = document.getElementById('rut').value;
    nombre      = document.getElementById('nombre').value;
    contacto    = document.getElementById('contacto').value;
    email       = document.getElementById('email').value;
    fono1       = document.getElementById('fono1').value;
    fono2       = document.getElementById('fono2').value;    
    domicilio   = document.getElementById('domicilio').value;
    id_comuna   = document.getElementById('id_comuna').value;
    tipo_usu    = document.getElementById('tipo_usu').value;
    estado      = document.getElementById('estado').value;
    clave1      = document.getElementById('clave1').value;

    var ajax=XMLHttp();
    ajax.open("GET","man_usuario.php?op=2"
                                    +"&rut="+rut
                                    +"&nombre="+nombre
                                    +"&contacto="+contacto
                                    +"&email="+email
                                    +"&fono1="+fono1
                                    +"&fono2="+fono2
                                    +"&domicilio="+domicilio
                                    +"&id_comuna="+id_comuna
                                    +"&tipo_usu="+tipo_usu
                                    +"&estado="+estado
                                    +"&clave1="+clave1,true);

    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    ///////////////////////////////////////////////////////////////////////////
    
    ajax.onreadystatechange = function() {
		if (ajax.readyState == 4) {
			var respuesta=ajax.responseText;           

			document.getElementById('salida').innerHTML=respuesta;
            valida_sesion();
            
            if (document.getElementById('eco_grabar').value=="insert_ok"){
                grilla_usuario('grabar');
                document.getElementById('msn_update').innerHTML = "Esta Actualizando Este Registro.";
                jAlert("Se ha agregado el nuevo registro con exito.","Informacion");
                document.getElementById("clave1").className = "txt2";
                document.getElementById("clave2").className = "txt2";

            }else if (document.getElementById('eco_grabar').value=="update_ok"){
                grilla_usuario('grabar');
                document.getElementById('msn_update').innerHTML = "Esta Actualizando Este Registro.";
                jAlert("Registro existente se ha actualizado con exito.","Informacion");
                document.getElementById("clave1").className = "txt2";
                document.getElementById("clave2").className = "txt2";               

            }else if (document.getElementById('eco_grabar').value=="falta_clave"){
                document.getElementById('msn_clave1').innerHTML = "Ingrese Clave.";
                document.getElementById('clave1').focus();
            }
		} 
    }
    ajax.send(null);
}

function eliminar_usuario(){    
    document.getElementById('msn_rut').innerHTML        = "";
    document.getElementById('msn_nombre').innerHTML     = "";
    document.getElementById('msn_contacto').innerHTML   = ""; 
    document.getElementById('msn_email').innerHTML      = "";
    document.getElementById('msn_fono1').innerHTML      = "";
    document.getElementById('msn_domicilio').innerHTML  = "";
    document.getElementById('msn_comuna').innerHTML     = "";
    document.getElementById('msn_tipo_usu').innerHTML   = "";
    document.getElementById('msn_estado').innerHTML     = "";
    document.getElementById('msn_clave1').innerHTML     = "";
    document.getElementById('msn_clave2').innerHTML     = "";

   	if (document.getElementById('rut').value =="" && document.getElementById('nombre').value =="") {
		document.getElementById('msn_rut').innerHTML = "Seleccione Registro.";
		return false;

	} else {document.getElementById("msn_rut").innerHTML = "";}

    rut     = document.getElementById('rut').value;
    nombre  = document.getElementById('nombre').value;

    //jconfirm
	jConfirm("<table style='font: 12px Arial;'><tr><td colspan='2'>Esta seguro(a) que desea Eliminar el siguiente registro?:<td></tr>"
            +"<tr><td>  &nbsp;&nbsp;&bull;&nbsp;&nbsp; Rut</td>     <td>: "+rut+"</td></tr>"
            +"<tr><td>  &nbsp;&nbsp;&bull;&nbsp;&nbsp; Nombre</td>  <td>: "+nombre+"</td></tr>"
            +"</table>"
            , "Confirmacion", function(r) {

        if(r) {
    //jconfirm    

    var ajax=XMLHttp();
    ajax.open("GET","man_usuario.php?op=3"
                                    +"&rut="+rut
                                    +"&nombre="+nombre,true);
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    /////////////////////////////////////////////////////////////////////////////
    ajax.onreadystatechange = function() {
		if (ajax.readyState == 4) {
			var respuesta=ajax.responseText;
			document.getElementById('salida').innerHTML=respuesta;
            valida_sesion();
                        
            if (document.getElementById('eco_eliminar').value=="delete_ok"){
                grilla_usuario('eliminar');
                jAlert("Se ha eliminado el registro con exito.","Informacion")
                document.getElementById('msn_update').innerHTML = "";
                document.getElementById("clave1").className     = "txt1";
                document.getElementById("clave2").className     = "txt1";

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

function grilla_usuario(accion){    
    document.getElementById('msn_rut').innerHTML        = "";
    document.getElementById('msn_nombre').innerHTML     = "";
    document.getElementById('msn_contacto').innerHTML   = ""; 
    document.getElementById('msn_email').innerHTML      = "";
    document.getElementById('msn_fono1').innerHTML      = "";
    document.getElementById('msn_domicilio').innerHTML  = "";
    document.getElementById('msn_comuna').innerHTML     = "";
    document.getElementById('msn_tipo_usu').innerHTML   = "";
    document.getElementById('msn_estado').innerHTML     = "";
    document.getElementById('msn_clave1').innerHTML     = "";
    document.getElementById('msn_clave2').innerHTML     = "";

    var ajax=XMLHttp();
    if (accion=="buscar"){
        rut         = document.getElementById('rut').value;
        nombre      = document.getElementById('nombre').value;
        contacto    = document.getElementById('contacto').value;
        email       = document.getElementById('email').value;
        fono1       = document.getElementById('fono1').value;
        fono2       = document.getElementById('fono2').value;        
        domicilio   = document.getElementById('domicilio').value;
        id_comuna   = document.getElementById('id_comuna').value;
        tipo_usu    = document.getElementById('tipo_usu').value;
        estado      = document.getElementById('estado').value;        

        ajax.open("GET","man_usuario.php?op=4"
                                    +"&rut="+rut
                                    +"&nombre="+nombre
                                    +"&contacto="+contacto
                                    +"&email="+email
                                    +"&fono1="+fono1
                                    +"&fono2="+fono2
                                    +"&domicilio="+domicilio
                                    +"&id_comuna="+id_comuna
                                    +"&tipo_usu="+tipo_usu
                                    +"&estado="+estado
                                    +"&accion="+accion,true);

    }else{
        ajax.open("GET","man_usuario.php?op=4&accion="+accion,true);
    }
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    /////////////////////////////////////////////////////////////////////////////
    ajax.onreadystatechange = function() {
		if (ajax.readyState == 4) {
			var respuesta=ajax.responseText;
			document.getElementById('grilla_usuario').innerHTML=respuesta;
            valida_sesion();
                        
      	}}
    ajax.send(null);
    /////////////////////////////////////////////////////////////////////////////
}

function copy_grilla_usuario() {
    div_grilla=document.getElementById('grilla_usuario');
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