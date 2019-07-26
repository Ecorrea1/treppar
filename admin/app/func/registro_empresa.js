function volver(){
    window.location="../index.php";
}

function activa_pesta(n_pesta) {
    if (n_pesta=="2"){ //CREAR CUENTA
        
        document.getElementById('pesta2').className="pesta_in";        
        document.getElementById('pesta4').className="pesta_out";       
        
        document.getElementById('contenido2').style.display="block";        
        document.getElementById('contenido4').style.display="none";       
        
    }else if (n_pesta=="4"){ //OLVIDE MI CLAVE
        
        document.getElementById('pesta2').className="pesta_out";        
        document.getElementById('pesta4').className="pesta_in";
        
        document.getElementById('contenido2').style.display="none";        
        document.getElementById('contenido4').style.display="block";        
    }
}

//## PESTAÑA 2 - CREAR CUENTA ###################################################################

function limpia_datos_crearcuenta(){
    document.getElementById('msn_rut_2').innerHTML          = "";
    document.getElementById('msn_nombre_2').innerHTML       = "";
    document.getElementById('msn_contacto_2').innerHTML     = "";
    document.getElementById('msn_email_2').innerHTML        = "";
    document.getElementById('msn_fono1_2').innerHTML        = "";
    document.getElementById('msn_domicilio_2').innerHTML    = "";
    document.getElementById('msn_comuna_2').innerHTML       = "";  
    document.getElementById('msn_clave1_2').innerHTML       = "";
    document.getElementById('msn_clave2_2').innerHTML       = "";
    
    /*
    document.getElementById('nombre_2').value               = "";
    document.getElementById('contacto_2').value             = "";
    document.getElementById('email_2').value                = "";
    document.getElementById('fono1_2').value                = "";
    document.getElementById('fono2_2').value                = "";
    document.getElementById('domicilio_2').value            = "";
    document.getElementById('id_comuna_2').value            = "";  
    document.getElementById('clave1_2').value               = "";
    document.getElementById('clave2_2').value               = "";
    */
        
    document.getElementById('div_datos_2').style.display    = "none";
    document.getElementById('salida').innerHTML             = "";    
}

function buscar_rut_crearcuenta(){    
    if (document.getElementById('rut_2').value =="") {
		document.getElementById('msn_rut_2').innerHTML = "Ingrese Rut.";
		document.getElementById('rut_2').focus();
		return false;
	} else {document.getElementById("msn_rut_2").innerHTML = "";}
    
    var ajax=XMLHttp();
    ajax.open("GET","registro_empresa.php?op=21"    
                        +"&rut="+document.getElementById('rut_2').value,true);
                
   ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////
    ajax.onreadystatechange = function() {
	
	if (ajax.readyState == 4) {
		var respuesta=ajax.responseText;
		document.getElementById('salida').innerHTML=respuesta;
        
        if (document.getElementById('eco_validarut_2').value=="ya_existe"){         
            document.getElementById('div_datos_2').style.display = "none";
                      
            alert("Ya existe usuario creado con este Rut.\nSi olvido su clave intente con la opcion 'Olvide Mi Clave'");
            document.getElementById("msn_rut_2").innerHTML = "Ya existe usuario creado con este Rut.\nSi olvido su clave intente con la opcion 'Olvide Mi Clave'";
            
            document.getElementById('rut_2').value = "";
            document.getElementById('rut_2').focus();
           
        }else if (document.getElementById('eco_validarut_2').value=="no_existe"){        
            document.getElementById('div_datos_2').style.display = "block";
            document.getElementById('nombre_2').focus();    
        }
	}}
    ajax.send(null);
    /////////////////////////////////////////////////////////////////////////////
}

function grabar_crearcuenta(){
    document.getElementById('msn_rut_2').innerHTML          = "";
    document.getElementById('msn_nombre_2').innerHTML       = "";
    document.getElementById('msn_contacto_2').innerHTML     = "";
    document.getElementById('msn_email_2').innerHTML        = "";
    document.getElementById('msn_fono1_2').innerHTML        = "";
    document.getElementById('msn_domicilio_2').innerHTML    = "";
    document.getElementById('msn_comuna_2').innerHTML       = "";  
    document.getElementById('msn_clave1_2').innerHTML       = "";
    document.getElementById('msn_clave2_2').innerHTML       = "";
    document.getElementById('salida').innerHTML         = "";  
    
   	if (document.getElementById('rut_2').value =="") {
		document.getElementById('msn_rut_2').innerHTML = "Ingrese Rut.";
		document.getElementById('rut_2').focus();
		return false;
	} else {document.getElementById("msn_rut_2").innerHTML = "";}
        

   	if (document.getElementById('nombre_2').value =="") {
		document.getElementById('msn_nombre_2').innerHTML = "Ingrese Nombre.";
		document.getElementById('nombre_2').focus();
		return false;
	} else {document.getElementById("msn_nombre_2").innerHTML = "";}
    

    if (document.getElementById('contacto_2').value =="") {
        document.getElementById('msn_contacto_2').innerHTML = "Ingrese Contacto.";
        document.getElementById('contacto_2').focus();
        return false;
    } else {document.getElementById("msn_contacto_2").innerHTML = "";}
    
    
    if (document.getElementById('email_2').value =="") {
        document.getElementById('msn_email_2').innerHTML = "Ingrese Email.";
        document.getElementById('email_2').focus();
        return false;
    } else {document.getElementById("msn_email_2").innerHTML = "";}
    

    if (document.getElementById('fono1_2').value =="") {
        document.getElementById('msn_fono1_2').innerHTML = "Ingrese Fono 1.";
        document.getElementById('fono1_2').focus();
        return false;
    } else {document.getElementById("msn_fono1_2").innerHTML = "";}
    

    if (document.getElementById('domicilio_2').value =="") {
        document.getElementById('msn_domicilio_2').innerHTML = "Ingrese Domicilio.";
        document.getElementById('domicilio_2').focus();
        return false;
    } else {document.getElementById("msn_domicilio_2").innerHTML = "";}


    if (document.getElementById('id_comuna_2').value =="") {
        document.getElementById('msn_comuna_2').innerHTML = "Seleccione Comuna.";
        document.getElementById('id_comuna_2').focus();
        return false;
    } else {document.getElementById("msn_comuna_2").innerHTML = "";}

    //Clave//////////////////////////////////////////////////////////////////
    if (document.getElementById('clave1_2').value =="") {
	  document.getElementById('msn_clave1_2').innerHTML = "Ingrese Clave.";
	  document.getElementById('clave1_2').focus();
	  return false;
    } else {document.getElementById("msn_clave1_2").innerHTML = "";}
    
    if (document.getElementById('clave2_2').value =="") {
	  document.getElementById('msn_clave2_2').innerHTML = "Ingrese Confirmacion Clave.";
	  document.getElementById('clave2_2').focus();
	  return false;
    } else {document.getElementById("msn_clave2_2").innerHTML = "";}

	if ((document.getElementById('clave1_2').value) != (document.getElementById('clave2_2').value)) {
		document.getElementById('msn_clave2_2').innerHTML = "Las Claves no coinciden.";
		document.getElementById('clave2_2').focus();
		return false;
	} else {document.getElementById("msn_clave2_2").innerHTML = "";}
    /////////////////////////////////////////////////////////////////////////

    rut         = document.getElementById('rut_2').value;
    nombre      = document.getElementById('nombre_2').value;
    contacto    = document.getElementById('contacto_2').value;
    email       = document.getElementById('email_2').value;
    fono1       = document.getElementById('fono1_2').value;
    fono2       = document.getElementById('fono2_2').value;    
    domicilio   = document.getElementById('domicilio_2').value;
    id_comuna   = document.getElementById('id_comuna_2').value;
    nom_comuna  = document.getElementById('id_comuna_2').options [ document.getElementById('id_comuna_2').selectedIndex ] .text;   
    clave1      = document.getElementById('clave1_2').value;

    var ajax=XMLHttp();
    ajax.open("GET","registro_empresa.php?op=22"
                                    +"&rut="+rut
                                    +"&nombre="+nombre
                                    +"&contacto="+contacto
                                    +"&email="+email
                                    +"&fono1="+fono1
                                    +"&fono2="+fono2
                                    +"&domicilio="+domicilio
                                    +"&id_comuna="+id_comuna
                                    +"&nom_comuna="+nom_comuna                                   
                                    +"&clave1="+clave1,true);

    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////
    ajax.onreadystatechange = function() {
	
		if (ajax.readyState == 4) {
			var respuesta=ajax.responseText;
			document.getElementById('salida').innerHTML=respuesta;

            if (document.getElementById('eco_grabar_2').value=="falta_clave"){
                alert("Debe ingresar clave.");
                document.getElementById('clave1_2').focus();
                
            }else if (document.getElementById('eco_grabar_2').value=="ya_existe"){
                
                alert("Ya existe usuario creado con este Rut.\nSi olvido su clave intente con la opcion 'Olvide Mi Clave'");
                document.getElementById("msn_rut_2").innerHTML = "Ya existe usuario creado con este Rut.\nSi olvido su clave intente con la opcion 'Olvide Mi Clave'";
                
                document.getElementById('div_datos_2').style.display = "none";
                document.getElementById('rut_2').value = "";
                document.getElementById('rut_2').focus();

            }else if (document.getElementById('eco_grabar_2').value=="insert_ok"){
                alert("Se ha agregado el nuevo registro con exito.");
                window.location="../index.php";                            
            }
		} 
    }
    ajax.send(null);
}


//## PESTAÑA4 - OLVIDE MI CLAVE ###################################################################

function enviar_codigo_email(){
    document.getElementById('msn_email_4').innerHTML    = "";
    document.getElementById('msn_codigo_4').innerHTML   = "";
    document.getElementById('msn_clave_4').innerHTML    = "";
    
    if (document.getElementById('email_4').value =="") {
		document.getElementById('msn_email_4').innerHTML = "Ingrese Email.";
		document.getElementById('email_4').focus();
		return false;
	} else {document.getElementById("msn_email_4").innerHTML = "";}
    
    var ajax=XMLHttp();
    ajax.open("GET","registro_empresa.php?op=41"
                        +"&email="+document.getElementById('email_4').value,true);
                
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////
    ajax.onreadystatechange = function() {
	
	if (ajax.readyState == 4) {
		var respuesta=ajax.responseText;
		document.getElementById('salida').innerHTML=respuesta;
        
        if (document.getElementById('eco_enviarcodigo_4').value=="ok"){
            alert("Ingrese el Codigo Enviado a su Email.");
            document.getElementById('msn_codigo_4').innerHTML = "Ingrese el Codigo Enviado a su Email.";            
            
        }else if (document.getElementById('eco_enviarcodigo_4').value=="err"){
            alert("No Existe el Email Ingresado.");
            document.getElementById('msn_email_4').innerHTML = "No Existe el Email Ingresado.";
        }
        
	}}
    ajax.send(null);
    /////////////////////////////////////////////////////////////////////////////
}

function oculta_cambioclave_olvidada(){
    document.getElementById('msn_email_4').innerHTML    = "";
    document.getElementById('msn_codigo_4').innerHTML   = "";
    document.getElementById('msn_clave_4').innerHTML    = "";
    
    document.getElementById('div_cambio_clave_4').style.display="none";
    document.getElementById('clave1_4').value = "";
    document.getElementById('clave2_4').value = "";
}

function validar_codigo(){
    document.getElementById('msn_email_4').innerHTML    = "";
    document.getElementById('msn_codigo_4').innerHTML   = "";
    document.getElementById('msn_clave_4').innerHTML    = "";
    
    if (document.getElementById('email_4').value =="") {
		document.getElementById('msn_email_4').innerHTML = "Ingrese Email.";
		document.getElementById('email_4').focus();
		return false;
	} else {document.getElementById("msn_email_4").innerHTML = "";}
    
    if (document.getElementById('codigo_4').value =="") {
		document.getElementById('msn_codigo_4').innerHTML = "Ingrese Codigo.";
		document.getElementById('codigo_4').focus();
		return false;
	} else {document.getElementById("msn_codigo_4").innerHTML = "";}
    
    var ajax=XMLHttp();
    ajax.open("GET","registro_empresa.php?op=42"
                        +"&email="+document.getElementById('email_4').value                  
                        +"&codigo="+document.getElementById('codigo_4').value,true);
                
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////
    ajax.onreadystatechange = function() {
	
	if (ajax.readyState == 4) {
		var respuesta=ajax.responseText;
		document.getElementById('salida').innerHTML=respuesta;
        
        if (document.getElementById('eco_validarcodigo_4').value=="ok"){
            document.getElementById('div_cambio_clave_4').style.display="block";   
            
        }else if (document.getElementById('eco_validarcodigo_4').value=="err"){
            document.getElementById('msn_codigo_4').innerHTML = "Codigo No Valido.";
            document.getElementById('div_cambio_clave_4').style.display="none";
        }
        
	}}
    ajax.send(null);
    /////////////////////////////////////////////////////////////////////////////
}

function grabar_clave_olvidada(){
    document.getElementById('msn_email_4').innerHTML    = "";
    document.getElementById('msn_codigo_4').innerHTML   = "";
    document.getElementById('msn_clave_4').innerHTML    = "";
    
    if (document.getElementById('email_4').value =="") {
		document.getElementById('msn_email_4').innerHTML = "Ingrese Email.";
		document.getElementById('email_4').focus();
		return false;
	} else {document.getElementById("msn_email_4").innerHTML = "";}
    
    if (document.getElementById('codigo_4').value =="") {
		document.getElementById('msn_codigo_4').innerHTML = "Ingrese Codigo.";
		document.getElementById('codigo_4').focus();
		return false;
	} else {document.getElementById("msn_codigo_4").innerHTML = "";}
    
    //CLAVE
    if (document.getElementById('clave1_4').value=="") {
        document.getElementById('msn_clave_4').innerHTML = "Ingrese Clave.";
        document.getElementById('clave1_4').focus();
        return false;
    } else {document.getElementById("msn_clave_4").innerHTML = "";}
    
    if (document.getElementById('clave2_4').value=="") {
        document.getElementById('msn_clave_4').innerHTML = "Ingrese Confirmacion Clave.";
        document.getElementById('clave2_4').focus();
        return false;
    } else {document.getElementById("msn_clave_4").innerHTML = "";}
    
    if ((document.getElementById('clave1_4').value) != (document.getElementById('clave2_4').value)) {
		document.getElementById('msn_clave_4').innerHTML = "Las Claves no coinciden.";
		document.getElementById('clave2_4').focus();
		return false;
	} else {document.getElementById("msn_clave_4").innerHTML = "";}
    //FIN CLAVE
    
    var ajax=XMLHttp();
    ajax.open("GET","registro_empresa.php?op=43"
                        +"&email="+document.getElementById('email_4').value                  
                        +"&clave="+document.getElementById('clave1_4').value,true);
                
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////
    ajax.onreadystatechange = function() {
	
	if (ajax.readyState == 4) {
		var respuesta=ajax.responseText;
		document.getElementById('salida').innerHTML=respuesta;
        
        if (document.getElementById('eco_cambiarclave_4').value=="ok"){            
            alert("Se Cambio la Clave con Exito.");
            window.location="../index.php";
            
        }else if (document.getElementById('eco_cambiarclave_4').value=="err"){
            document.getElementById('div_cambio_clave_4').style.display="none";
            document.getElementById('codigo_4').value="";
            alert("Hubo un error a tratar de cambiar la clave. Realice el proceso de nuevo.");
            document.getElementById('msn_clave_4').innerHTML = "Hubo un error a tratar de cambiar la clave. Realice el proceso de nuevo.";            
        }
        
	}}
    ajax.send(null);
    /////////////////////////////////////////////////////////////////////////////    
}