function activa_pesta(n_pesta) {
    if (n_pesta=="1"){ //INICIAR SESION
        document.getElementById('pesta1').className="pesta_in";
        document.getElementById('pesta2').className="pesta_out";        
        document.getElementById('pesta3').className="pesta_out";        
       
        document.getElementById('contenido1').style.display="block";
        document.getElementById('contenido2').style.display="none";        
        document.getElementById('contenido3').style.display="none";
        
    }else if (n_pesta=="2"){ //CREAR CUENTA
        document.getElementById('pesta1').className="pesta_out";
        document.getElementById('pesta2').className="pesta_in";        
        document.getElementById('pesta3').className="pesta_out";        
        
        document.getElementById('contenido1').style.display="none";
        document.getElementById('contenido2').style.display="block";        
        document.getElementById('contenido3').style.display="none";        
        
    }else if (n_pesta=="3"){ //OLVIDE MI CLAVE
        document.getElementById('pesta1').className="pesta_out";
        document.getElementById('pesta2').className="pesta_out";        
        document.getElementById('pesta3').className="pesta_in";        
        
        document.getElementById('contenido1').style.display="none";
        document.getElementById('contenido2').style.display="none";        
        document.getElementById('contenido3').style.display="block";
        
    }
}

//##############################################################
//## 1) INICIAR SESION
//##############################################################

function iniciar_sesion(){
    document.getElementById('msn_email_1').innerHTML  = "";
    document.getElementById('msn_clave_1').innerHTML  = "";
    
    if (document.getElementById('email_1').value =="") {
		document.getElementById('msn_email_1').innerHTML = "Ingrese Email.";
		document.getElementById('email_1').focus();
		return false;
	} else {document.getElementById("msn_email_1").innerHTML = "";}
    
    if (document.getElementById('clave_1').value=="") {
        document.getElementById('msn_clave_1').innerHTML = "Ingrese Clave.";
        document.getElementById('clave_1').focus();
        return false;
    } else {document.getElementById("msn_clave_1").innerHTML = "";}
    
    var ajax=XMLHttp();
    ajax.open("GET","tour_usuario_inicio.php?op=12"    
                        +"&email="+document.getElementById('email_1').value                        
                        +"&clave="+document.getElementById('clave_1').value,true);
                
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////
    ajax.onreadystatechange = function() {
	
	if (ajax.readyState == 4) {
		var respuesta=ajax.responseText;
		document.getElementById('salida').innerHTML=respuesta;
        
        if (document.getElementById('eco_validasesion_1').value=="ok"){
            opener.document.getElementById('form_portal').bt_reload_pag.onclick();
            window.close();
            
        }else if (document.getElementById('eco_validasesion_1').value=="err"){
            document.getElementById('clave_1').value = "";            
            document.getElementById('msn_email_1').innerHTML = "Email o Clave Incorrecta.";
        }        
	}}
    ajax.send(null);
    /////////////////////////////////////////////////////////////////////////////
}

//##############################################################
//## 2) CREAR CUENTA
//##############################################################

function limpia_datos_crearcuenta(){
    document.getElementById('email_2').value                = "";
    document.getElementById('nombre_2').value               = "";
    document.getElementById('apellido_2').value             = "";
    document.getElementById('fecha_nacim_2').value          = "";
    document.getElementById('pais_2').value                 = "";
    document.getElementById('fono_2').value                 = "";
    document.getElementById('ciudad_2').value               = "";
    document.getElementById('domicilio_2').value            = "";
    document.getElementById('txtci_2').value                = "";
    document.getElementById('clave1_2').value               = "";
    document.getElementById('clave2_2').value               = "";
    
    document.getElementById('msn_email_2').innerHTML        = "";
    document.getElementById('msn_nombre_2').innerHTML       = "";
    document.getElementById('msn_apellido_2').innerHTML     = "";
    document.getElementById('msn_nacim_2').innerHTML        = "";
    document.getElementById('msn_pais_2').innerHTML         = "";
    document.getElementById('msn_fono_2').innerHTML         = "";
    document.getElementById('msn_ciudad_2').innerHTML       = "";
    document.getElementById('msn_domicilio_2').innerHTML    = "";
    document.getElementById('msn_ci_2').value               = "";
    document.getElementById('msn_clave1_2').innerHTML       = "";
    document.getElementById('msn_clave2_2').innerHTML       = "";
    document.getElementById('div_datos_2').style.display    = "none";
    
    document.getElementById('salida').innerHTML             = "";
}

function activar_ci_crearcuenta(){
    ci = document.getElementsByName('ci_2');
    
    if(ci['0'].checked){ //Rut        
        document.getElementById('txtci_2').placeholder="Rut (Ej: 11111111-1)";
    
    }else if(ci['1'].checked){//Dni
        document.getElementById('txtci_2').placeholder="Dni / Extranjero";
        
    }else if(ci['2'].checked){//pasaporte
        document.getElementById('txtci_2').placeholder="Pasaporte";
    }
}

function buscar_email_crearcuenta(){    
    if (document.getElementById('email_2').value =="") {
		document.getElementById('msn_email_2').innerHTML = "Ingrese Email.";
		document.getElementById('email_2').focus();
		return false;
	} else {document.getElementById("msn_email_2").innerHTML = "";}
    
    var ajax=XMLHttp();
    ajax.open("GET","tour_usuario_inicio.php?op=21"    
                        +"&email="+document.getElementById('email_2').value,true);
                
   ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////
    ajax.onreadystatechange = function() {
	
	if (ajax.readyState == 4) {
		var respuesta=ajax.responseText;
		document.getElementById('salida').innerHTML=respuesta;
            
        if (document.getElementById('eco_validaemail_2').value=="ya_existe"){            
            document.getElementById('div_datos_2').style.display = "none";            
            alert("Ya existe usuario creado con este email.");
            document.getElementById('email_2').value = "";
            document.getElementById('email_2').focus();
           
        }else if (document.getElementById('eco_validaemail_2').value=="no_existe"){            
            document.getElementById('div_datos_2').style.display = "block";
            document.getElementById('nombre_2').focus();            
        }
	}}
    ajax.send(null);
    /////////////////////////////////////////////////////////////////////////////
}

function grabar_crearcuenta(){
    document.getElementById('msn_email_2').innerHTML    = "";
    document.getElementById('msn_nombre_2').innerHTML   = "";
    document.getElementById('msn_apellido_2').innerHTML = "";
    document.getElementById('msn_nacim_2').innerHTML    = "";
    document.getElementById('msn_pais_2').innerHTML     = "";
    document.getElementById('msn_fono_2').innerHTML     = "";
    document.getElementById('msn_ciudad_2').innerHTML   = "";
    document.getElementById('msn_domicilio_2').innerHTML= "";
    document.getElementById('msn_ci_2').value             = "";
    document.getElementById('msn_clave1_2').innerHTML   = "";
    document.getElementById('msn_clave2_2').innerHTML   = "";
    document.getElementById('salida').innerHTML         = "";  
    
    if (document.getElementById('email_2').value =="") {
		document.getElementById('msn_email_2').innerHTML = "Ingrese Email.";
		document.getElementById('email_2').focus();
		return false;
	} else {document.getElementById("msn_email_2").innerHTML = "";}
    
   	if (document.getElementById('nombre_2').value =="") {
		document.getElementById('msn_nombre_2').innerHTML = "Ingrese Nombre.";
		document.getElementById('nombre_2').focus();
		return false;
	} else {document.getElementById("msn_nombre_2").innerHTML = "";}
    
    if (document.getElementById('apellido_2').value =="") {
		document.getElementById('msn_apellido_2').innerHTML = "Ingrese Apellidos.";
		document.getElementById('apellido_2').focus();
		return false;
	} else {document.getElementById("msn_apellido_2").innerHTML = "";}
    
    /////////////////////////////////////////////////////////////////////////////     
    //FECHA NACIM
    var hoy = new Date();
    var hoy_ano = hoy.getFullYear();
    var hoy_mes = hoy.getMonth()+1;
    var hoy_dia = hoy.getDate();    
    hoy =hoy_ano +"-"+ hoy_mes +"-"+ hoy_dia;
    
    if (  (hoy<=document.getElementById('fecha_nacim_2').value) || (document.getElementById('fecha_nacim_2').value=="")  || (document.getElementById('fecha_nacim_2').value<"1900-12-31")){
        document.getElementById('msn_nacim_2').innerHTML = "Fecha Nacimiento No Es Valida.";
        document.getElementById('fecha_nacim_2').focus();
        return false;
   	} else {document.getElementById("msn_nacim_2").innerHTML = "";}
    //FIN FECHA NACIM
    /////////////////////////////////////////////////////////////////////////////   
    
    if (document.getElementById('pais_2').value =="") {
		document.getElementById('msn_pais_2').innerHTML = "Ingrese Pais.";
		document.getElementById('pais_2').focus();
		return false;
	} else {document.getElementById("msn_pais_2").innerHTML = "";}
    
    if (document.getElementById('fono_2').value =="") {
		document.getElementById('msn_fono_2').innerHTML = "Ingrese Fono.";
		document.getElementById('fono_2').focus();
		return false;
	} else {document.getElementById("msn_fono_2").innerHTML = "";}
    
    ci = document.getElementsByName('ci_2');
    
    if(ci['0'].checked){ //Rut
        if (document.getElementById('txtci_2').value =="") {
        	document.getElementById('msn_ci_2').innerHTML = "Ingrese Rut.";
        	document.getElementById('txtci_2').focus();
        	return false;
        } else {document.getElementById('msn_ci_2').innerHTML = "";}
        
        valida_rut(document.getElementById('txtci_2'), 'msn_ci_2');
        
        if (document.getElementById('msn_ci_2').innerHTML != "") {
            return false;    
        }
        
        tipo_ci="rut";
    
    }else if(ci['1'].checked){//Dni
        if (document.getElementById('txtci_2').value =="") {
        	document.getElementById('msn_ci_2').innerHTML = "Ingrese Dni.";
        	document.getElementById('txtci_2').focus();
        	return false;
        } else {document.getElementById('msn_ci_2').innerHTML = "";}
        
        tipo_ci="dni";
        
        
    }else if(ci['2'].checked){//pasaporte
        if (document.getElementById('txtci_2').value =="") {
        	document.getElementById('msn_ci_2').innerHTML = "Ingrese Pasaporte.";
        	document.getElementById('txtci_2').focus();
        	return false;
        } else {document.getElementById('msn_ci_2').innerHTML = "";}
        
        tipo_ci="pasaporte";
    }
    
    //CLAVE
    if (document.getElementById('clave1_2').value=="") {
        document.getElementById('msn_clave1_2').innerHTML = "Ingrese Clave.";
        document.getElementById('clave1_2').focus();
        return false;
    } else {document.getElementById("msn_clave1_2").innerHTML = "";}
    
    if (document.getElementById('clave2_2').value=="") {
        document.getElementById('msn_clave2_2').innerHTML = "Ingrese Confirmacion Clave.";
        document.getElementById('clave2_2').focus();
        return false;
    } else {document.getElementById("msn_clave2_2").innerHTML = "";}
    
    if ((document.getElementById('clave1_2').value) != (document.getElementById('clave2_2').value)) {
		document.getElementById('msn_clave2_2').innerHTML = "Las Claves no coinciden.";
		document.getElementById('clave2_2').focus();
		return false;
	} else {document.getElementById("msn_clave2_2").innerHTML = "";}
    //FIN CLAVE    
    
    email       = document.getElementById('email_2').value;
    nombre      = document.getElementById('nombre_2').value;
    apellido    = document.getElementById('apellido_2').value;
    fecha_nacim = document.getElementById('fecha_nacim_2').value;
    cod_pais    = document.getElementById('pais_2').value;
    nom_pais    = document.getElementById('pais_2').options [ document.getElementById('pais_2').selectedIndex ] .text;
    fono        = document.getElementById('fono_2').value;
    ciudad      = document.getElementById('ciudad_2').value;
    domicilio   = document.getElementById('domicilio_2').value;
    txt_ci      = document.getElementById('txtci_2').value;
    clave       = document.getElementById('clave1_2').value;
    
    var ajax=XMLHttp();
    ajax.open("GET","tour_usuario_inicio.php?op=22"    
                        +"&email="+email
                        +"&nombre="+nombre
                        +"&apellido="+apellido
                        +"&fecha_nacim="+fecha_nacim
                        +"&cod_pais="+cod_pais
                        +"&nom_pais="+nom_pais
                        +"&fono="+fono
                        +"&ciudad="+ciudad
                        +"&domicilio="+domicilio
                        +"&txt_ci="+txt_ci
                        +"&tipo_ci="+tipo_ci
                        +"&clave="+clave,true);
                
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////
    ajax.onreadystatechange = function() {
	
	if (ajax.readyState == 4) {
		var respuesta=ajax.responseText;
		document.getElementById('salida').innerHTML=respuesta;
        
        if (document.getElementById('eco_grabar_2').value=="insert_ok" || document.getElementById('eco_grabar_2').value=="update_ok"){            
            alert("Registro Grabado con Exito.");
            opener.document.getElementById('form_portal').bt_reload_pag.onclick();
            window.close();
        }
	}}
    ajax.send(null);
    /////////////////////////////////////////////////////////////////////////////
}

//##############################################################
//## 3) OLVIDE MI CLAVE
//##############################################################
function enviar_codigo_email(){
    document.getElementById('msn_email_3').innerHTML    = "";
    document.getElementById('msn_codigo_3').innerHTML   = "";
    document.getElementById('msn_clave_3').innerHTML    = "";
    
    if (document.getElementById('email_3').value =="") {
		document.getElementById('msn_email_3').innerHTML = "Ingrese Email.";
		document.getElementById('email_3').focus();
		return false;
	} else {document.getElementById("msn_email_3").innerHTML = "";}
    
    var ajax=XMLHttp();
    ajax.open("GET","tour_usuario_inicio.php?op=31"
                        +"&email="+document.getElementById('email_3').value,true);
                
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////
    ajax.onreadystatechange = function() {
	
	if (ajax.readyState == 4) {
		var respuesta=ajax.responseText;
		document.getElementById('salida').innerHTML=respuesta;
        
        if (document.getElementById('eco_enviarcodigo_3').value=="ok"){
            alert("Ingrese el Codigo Enviado a su Email.");
            document.getElementById('msn_codigo_3').innerHTML = "Ingrese el Codigo Enviado a su Email.";            
            
        }else if (document.getElementById('eco_enviarcodigo_3').value=="err"){
            alert("No Existe el Email Ingresado.");
            document.getElementById('msn_email_3').innerHTML = "No Existe el Email Ingresado.";
        }        
	}}
    ajax.send(null);
    /////////////////////////////////////////////////////////////////////////////
}

function oculta_cambioclave_olvidada(){
    document.getElementById('msn_email_3').innerHTML    = "";
    document.getElementById('msn_codigo_3').innerHTML   = "";
    document.getElementById('msn_clave_3').innerHTML    = "";
    
    document.getElementById('div_cambio_clave_3').style.display="none";
    document.getElementById('clave1_3').value = "";
    document.getElementById('clave2_3').value = "";
}

function validar_codigo(){
    document.getElementById('msn_email_3').innerHTML    = "";
    document.getElementById('msn_codigo_3').innerHTML   = "";
    document.getElementById('msn_clave_3').innerHTML    = "";
    
    if (document.getElementById('email_3').value =="") {
		document.getElementById('msn_email_3').innerHTML = "Ingrese Email.";
		document.getElementById('email_3').focus();
		return false;
	} else {document.getElementById("msn_email_3").innerHTML = "";}
    
    if (document.getElementById('codigo_3').value =="") {
		document.getElementById('msn_codigo_3').innerHTML = "Ingrese Codigo.";
		document.getElementById('codigo_3').focus();
		return false;
	} else {document.getElementById("msn_codigo_3").innerHTML = "";}
    
    var ajax=XMLHttp();
    ajax.open("GET","tour_usuario_inicio.php?op=32"
                        +"&email="+document.getElementById('email_3').value                  
                        +"&codigo="+document.getElementById('codigo_3').value,true);
                
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////
    ajax.onreadystatechange = function() {
	
	if (ajax.readyState == 4) {
		var respuesta=ajax.responseText;
		document.getElementById('salida').innerHTML=respuesta;
        
        if (document.getElementById('eco_validarcodigo_3').value=="ok"){
            document.getElementById('div_cambio_clave_3').style.display="block";   
            
        }else if (document.getElementById('eco_validarcodigo_3').value=="err"){
            document.getElementById('msn_codigo_3').innerHTML = "Codigo No Valido.";
            document.getElementById('div_cambio_clave_3').style.display="none";
        }
        
	}}
    ajax.send(null);
    /////////////////////////////////////////////////////////////////////////////
}

function grabar_clave_olvidada(){
    document.getElementById('msn_email_3').innerHTML    = "";
    document.getElementById('msn_codigo_3').innerHTML   = "";
    document.getElementById('msn_clave_3').innerHTML    = "";
    
    if (document.getElementById('email_3').value =="") {
		document.getElementById('msn_email_3').innerHTML = "Ingrese Email.";
		document.getElementById('email_3').focus();
		return false;
	} else {document.getElementById("msn_email_3").innerHTML = "";}
    
    if (document.getElementById('codigo_3').value =="") {
		document.getElementById('msn_codigo_3').innerHTML = "Ingrese Codigo.";
		document.getElementById('codigo_3').focus();
		return false;
	} else {document.getElementById("msn_codigo_3").innerHTML = "";}
    
    //CLAVE
    if (document.getElementById('clave1_3').value=="") {
        document.getElementById('msn_clave_3').innerHTML = "Ingrese Clave.";
        document.getElementById('clave1_3').focus();
        return false;
    } else {document.getElementById("msn_clave_3").innerHTML = "";}
    
    if (document.getElementById('clave2_3').value=="") {
        document.getElementById('msn_clave_3').innerHTML = "Ingrese Confirmacion Clave.";
        document.getElementById('clave2_3').focus();
        return false;
    } else {document.getElementById("msn_clave_3").innerHTML = "";}
    
    if ((document.getElementById('clave1_3').value) != (document.getElementById('clave2_3').value)) {
		document.getElementById('msn_clave_3').innerHTML = "Las Claves no coinciden.";
		document.getElementById('clave2_3').focus();
		return false;
	} else {document.getElementById("msn_clave_3").innerHTML = "";}
    //FIN CLAVE
    
    var ajax=XMLHttp();
    ajax.open("GET","tour_usuario_inicio.php?op=33"
                        +"&email="+document.getElementById('email_3').value                  
                        +"&clave="+document.getElementById('clave1_3').value,true);
                
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////
    ajax.onreadystatechange = function() {
	
	if (ajax.readyState == 4) {
		var respuesta=ajax.responseText;
		document.getElementById('salida').innerHTML=respuesta;
        
        if (document.getElementById('eco_cambiarclave_3').value=="ok"){
            alert("Se Cambio la Clave con Exito.");
            opener.document.getElementById('form_portal').bt_reload_pag.onclick();
            window.close();
            
        }else if (document.getElementById('eco_cambiarclave_3').value=="err"){
            document.getElementById('div_cambio_clave_3').style.display="none";
            document.getElementById('codigo_3').value="";
            document.getElementById('msn_clave_3').innerHTML = "Hubo un error a tratar de cambiar la clave.";            
        }
        
	}}
    ajax.send(null);
    /////////////////////////////////////////////////////////////////////////////    
}