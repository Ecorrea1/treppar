function activa_pesta(n_pesta) {
    
    if (n_pesta=="1"){ //ACTUALIZAR MIS DATOS
        document.getElementById('pesta2').className="pesta_out";
        document.getElementById('pesta1').className="pesta_in";
        
        document.getElementById('contenido2').style.display="none";
        document.getElementById('contenido1').style.display="block";            
    }if (n_pesta=="2"){ //CAMBIAR CLAVE        
        document.getElementById('pesta2').className="pesta_in";        
        document.getElementById('pesta1').className="pesta_out";
        
        document.getElementById('contenido2').style.display="block";
        document.getElementById('contenido1').style.display="none";
    
    }
}

//##############################################################
//## 1) ACTUALIZAR MIS DATOS
//##############################################################
function limpia_actualizar_misdatos(){
    document.getElementById('div_datos_1').innerHTML="";    
}

function buscar_actualizar_misdatos(){
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
    ajax.open("GET","tour_usuario_miperfil.php?op=12"    
                        +"&email="+document.getElementById('email_1').value                        
                        +"&clave="+document.getElementById('clave_1').value,true);
                
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////
    ajax.onreadystatechange = function() {
	
	if (ajax.readyState == 4) {
		var respuesta=ajax.responseText;
		document.getElementById('div_datos_1').innerHTML=respuesta;
           
        if (document.getElementById('eco_buscar_misdatos_1').value=="err"){
            alert ("No se encontraron resultados.");
        } 
	}}
    ajax.send(null);
    /////////////////////////////////////////////////////////////////////////////    
}

function activar_ci_actualizar_misdatos(){
    ci = document.getElementsByName('ci_1');
    
    if(ci['0'].checked){ //Rut        
        document.getElementById('txtci_1').placeholder="Rut (Ej: 11111111-1)";
    
    }else if(ci['1'].checked){//Dni
        document.getElementById('txtci_1').placeholder="Dni / Extranjero";
        
    }else if(ci['2'].checked){//pasaporte
        document.getElementById('txtci_1').placeholder="Pasaporte";
    }
}

function grabar_actualizar_misdatos(){    
    document.getElementById('msn_email_1').innerHTML    = "";
    document.getElementById('msn_nombre_1').innerHTML   = "";
    document.getElementById('msn_apellido_1').innerHTML = "";
    document.getElementById('msn_nacim_1').innerHTML    = "";
    document.getElementById('msn_pais_1').innerHTML     = "";
    document.getElementById('msn_fono_1').innerHTML     = "";
    document.getElementById('msn_ciudad_1').innerHTML   = "";
    document.getElementById('msn_domicilio_1').innerHTML= ""; 
    document.getElementById('msn_ci_1').innerHTML       = "";
    document.getElementById('salida').innerHTML         = "";
    
    if (document.getElementById('email_1').value =="") {
		document.getElementById('msn_email_1').innerHTML = "Ingrese Email.";
		document.getElementById('email_1').focus();
		return false;
	} else {document.getElementById("msn_email_1").innerHTML = "";}
    
   	if (document.getElementById('nombre_1').value =="") {
		document.getElementById('msn_nombre_1').innerHTML = "Ingrese Nombre.";
		document.getElementById('nombre_1').focus();
		return false;
	} else {document.getElementById("msn_nombre_1").innerHTML = "";}
    
    if (document.getElementById('apellido_1').value =="") {
		document.getElementById('msn_apellido_1').innerHTML = "Ingrese Apellidos.";
		document.getElementById('apellido_1').focus();
		return false;
	} else {document.getElementById("msn_apellido_1").innerHTML = "";}
    
    /////////////////////////////////////////////////////////////////////////////     
    //FECHA NACIM
    var hoy = new Date();
    var hoy_ano = hoy.getFullYear();
    var hoy_mes = hoy.getMonth()+1;
    var hoy_dia = hoy.getDate();    
    hoy =hoy_ano +"-"+ hoy_mes +"-"+ hoy_dia;
    
    if (  (hoy<=document.getElementById('fecha_nacim_1').value) || (document.getElementById('fecha_nacim_1').value=="")  || (document.getElementById('fecha_nacim_1').value<"1900-12-31")){
        document.getElementById('msn_nacim_1').innerHTML = "Fecha Nacimiento No Es Valida.";
        document.getElementById('fecha_nacim_1').focus();
        return false;
   	} else {document.getElementById("msn_nacim_1").innerHTML = "";}
    //FIN FECHA NACIM
    /////////////////////////////////////////////////////////////////////////////   
    
    if (document.getElementById('pais_1').value =="") {
		document.getElementById('msn_pais_1').innerHTML = "Ingrese Pais.";
		document.getElementById('pais_1').focus();
		return false;
	} else {document.getElementById("msn_pais_1").innerHTML = "";}
    
    if (document.getElementById('fono_1').value =="") {
		document.getElementById('msn_fono_1').innerHTML = "Ingrese Fono.";
		document.getElementById('fono_1').focus();
		return false;
	} else {document.getElementById("msn_fono_1").innerHTML = "";}
    
    
    ci = document.getElementsByName('ci_1');
    
    if(ci['0'].checked){ //Rut
        if (document.getElementById('txtci_1').value =="") {
        	document.getElementById('msn_ci_1').innerHTML = "Ingrese Rut.";
        	document.getElementById('txtci_1').focus();
        	return false;
        } else {document.getElementById('msn_ci_1').innerHTML = "";}
        
        valida_rut(document.getElementById('txtci_1'), 'msn_ci_1');
        
        if (document.getElementById('msn_ci_1').innerHTML != "") {
            return false;    
        }
        
        tipo_ci="rut";
    
    }else if(ci['1'].checked){//Dni
        if (document.getElementById('txtci_1').value =="") {
        	document.getElementById('msn_ci_1').innerHTML = "Ingrese Dni.";
        	document.getElementById('txtci_1').focus();
        	return false;
        } else {document.getElementById('msn_ci_1').innerHTML = "";}
        
        tipo_ci="dni";
        
        
    }else if(ci['2'].checked){//pasaporte
        if (document.getElementById('txtci_1').value =="") {
        	document.getElementById('msn_ci_1').innerHTML = "Ingrese Pasaporte.";
        	document.getElementById('txtci_1').focus();
        	return false;
        } else {document.getElementById('msn_ci_1').innerHTML = "";}
        
        tipo_ci="pasaporte";
    }
    
    email       = document.getElementById('email_1').value;
    nombre      = document.getElementById('nombre_1').value;
    apellido    = document.getElementById('apellido_1').value;
    fecha_nacim = document.getElementById('fecha_nacim_1').value;
    cod_pais    = document.getElementById('pais_1').value;  
    fono        = document.getElementById('fono_1').value;
    ciudad      = document.getElementById('ciudad_1').value;
    domicilio   = document.getElementById('domicilio_1').value;
    txt_ci      = document.getElementById('txtci_1').value;
    
    var ajax=XMLHttp();
    ajax.open("GET","tour_usuario_miperfil.php?op=13"    
                        +"&email="+email
                        +"&nombre="+nombre
                        +"&apellido="+apellido
                        +"&fecha_nacim="+fecha_nacim
                        +"&cod_pais="+cod_pais                        
                        +"&fono="+fono
                        +"&ciudad="+ciudad
                        +"&domicilio="+domicilio
                        +"&txt_ci="+txt_ci
                        +"&tipo_ci="+tipo_ci,true);
                
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////
    ajax.onreadystatechange = function() {
	
	if (ajax.readyState == 4) {
		var respuesta=ajax.responseText;
		document.getElementById('salida').innerHTML=respuesta;
        
        if (document.getElementById('eco_grabar_misdatos').value=="ok"){
            alert ("Sus datos se han actualizado con exito.");
            opener.document.getElementById('form_portal').bt_reload_pag.onclick();
            window.close();
            
        }else if (document.getElementById('eco_grabar_misdatos').value=="err"){
            alert ("No existe la cuenta de email digitada.");
        }
	}}
    ajax.send(null);
    /////////////////////////////////////////////////////////////////////////////    
}

//##############################################################
//## 2) CAMBIAR CLAVE
//##############################################################

function grabar_cambioclave(){
    document.getElementById('msn_email_2').innerHTML    = "";
    document.getElementById('msn_clave1_2').innerHTML   = "";
    document.getElementById('msn_clave2_2').innerHTML   = "";
    document.getElementById('msn_clave3_2').innerHTML   = "";
    
    if (document.getElementById('email_2').value =="") {
		document.getElementById('msn_email_2').innerHTML = "Ingrese Email.";
		document.getElementById('email_2').focus();
		return false;
	} else {document.getElementById("msn_email_2").innerHTML = "";}    
    
    //CLAVE
    if (document.getElementById('clave_actual_2').value=="") {
        document.getElementById('msn_clave1_2').innerHTML = "Ingrese Clave Actual.";
        document.getElementById('clave_actual_2').focus();
        return false;
    } else {document.getElementById("msn_clave1_2").innerHTML = "";}
    
    if (document.getElementById('clave_nueva1_2').value=="") {
        document.getElementById('msn_clave2_2').innerHTML = "Ingrese Clave Nueva.";
        document.getElementById('clave_nueva1_2').focus();
        return false;
    } else {document.getElementById("msn_clave2_2").innerHTML = "";}
   
    if (document.getElementById('clave_nueva2_2').value=="") {
        document.getElementById('msn_clave3_2').innerHTML = "Ingrese Confirmacion Clave Nueva.";
        document.getElementById('clave_nueva2_2').focus();
        return false;
    } else {document.getElementById("msn_clave3_2").innerHTML = "";}
    
    if ((document.getElementById('clave_nueva1_2').value) != (document.getElementById('clave_nueva2_2').value)) {
		document.getElementById('msn_clave3_2').innerHTML = "Las Claves no coinciden.";
		document.getElementById('clave_nueva2_2').focus();
		return false;
	} else {document.getElementById("msn_clave3_2").innerHTML = "";}
    //FIN CLAVE
 
    var ajax=XMLHttp();
    ajax.open("GET","tour_usuario_miperfil.php?op=21"
                        +"&email="+document.getElementById('email_2').value                  
                        +"&clave_actual="+document.getElementById('clave_actual_2').value
                        +"&clave_nueva="+document.getElementById('clave_nueva1_2').value,true);
                
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////
    ajax.onreadystatechange = function() {
	
	if (ajax.readyState == 4) {
		var respuesta=ajax.responseText;
		document.getElementById('salida').innerHTML=respuesta;
        
        if (document.getElementById('eco_grabar_cambioclave_2').value=="ok"){
            alert("Se Cambio la Clave con Exito.");
            opener.document.getElementById('form_portal').bt_reload_pag.onclick();
            window.close();
            
        }else if (document.getElementById('eco_grabar_cambioclave_2').value=="err"){
            document.getElementById('msn_clave1_2').innerHTML = "Clave actual es incorrecta.";            
        }
        
	}}
    ajax.send(null);
    /////////////////////////////////////////////////////////////////////////////
}

/*
//##############################################################
//## 6) MIS DATOS COMPRA
//##############################################################

function grabar_misdatos_para_compra(){
    document.getElementById('msn_email_6').innerHTML    = "";
    document.getElementById('msn_nombre_6').innerHTML   = "";
    document.getElementById('msn_apellido_6').innerHTML = "";
    document.getElementById('msn_nacim_6').innerHTML    = "";
    document.getElementById('msn_pais_6').innerHTML     = "";
    document.getElementById('msn_fono_6').innerHTML     = "";
    document.getElementById('msn_ciudad_6').innerHTML   = "";
    document.getElementById('msn_domicilio_6').innerHTML= "";
    document.getElementById('salida').innerHTML         = "";
    
    if (document.getElementById('email_6').value =="") {
		document.getElementById('msn_email_6').innerHTML = "Email no valido.";		
		return false;
	} else {document.getElementById("msn_email_6").innerHTML = "";}
    
   	if (document.getElementById('nombre_6').value =="") {
		document.getElementById('msn_nombre_6').innerHTML = "Ingrese Nombre.";
		document.getElementById('nombre_6').focus();
		return false;
	} else {document.getElementById("msn_nombre_6").innerHTML = "";}
    
    if (document.getElementById('apellido_6').value =="") {
		document.getElementById('msn_apellido_6').innerHTML = "Ingrese Apellidos.";
		document.getElementById('apellido_6').focus();
		return false;
	} else {document.getElementById("msn_apellido_6").innerHTML = "";}
    
    /////////////////////////////////////////////////////////////////////////////     
    //FECHA NACIM
    var hoy = new Date();
    var hoy_ano = hoy.getFullYear();
    var hoy_mes = hoy.getMonth()+1;
    var hoy_dia = hoy.getDate();    
    hoy =hoy_ano +"-"+ hoy_mes +"-"+ hoy_dia;
    
    if (  (hoy<=document.getElementById('fecha_nacim_6').value) || (document.getElementById('fecha_nacim_6').value=="")  || (document.getElementById('fecha_nacim_6').value<"1900-12-31")){
        document.getElementById('msn_nacim_6').innerHTML = "Fecha Nacimiento No Es Valida.";
        document.getElementById('fecha_nacim_6').focus();
        return false;
   	} else {document.getElementById("msn_nacim_6").innerHTML = "";}
    //FIN FECHA NACIM
    /////////////////////////////////////////////////////////////////////////////   
    
    if (document.getElementById('pais_6').value =="") {
		document.getElementById('msn_pais_6').innerHTML = "Ingrese Pais.";
		document.getElementById('pais_6').focus();
		return false;
	} else {document.getElementById("msn_pais_6").innerHTML = "";}
    
    if (document.getElementById('fono_6').value =="") {
		document.getElementById('msn_fono_6').innerHTML = "Ingrese Fono.";
		document.getElementById('fono_6').focus();
		return false;
	} else {document.getElementById("msn_fono_6").innerHTML = "";}
    
    if (document.getElementById('clave_6').value =="") {
		document.getElementById('msn_clave_6').innerHTML = "Ingrese Clave.";
		document.getElementById('clave_6').focus();
		return false;
	} else {document.getElementById("msn_clave_6").innerHTML = "";}
    
    email       = document.getElementById('email_6').value;
    nombre      = document.getElementById('nombre_6').value;
    apellido    = document.getElementById('apellido_6').value;
    fecha_nacim = document.getElementById('fecha_nacim_6').value;
    cod_pais    = document.getElementById('pais_6').value;    
    fono        = document.getElementById('fono_6').value;
    ciudad      = document.getElementById('ciudad_6').value;
    domicilio   = document.getElementById('domicilio_6').value;
    clave       = document.getElementById('clave_6').value;
    
    var ajax=XMLHttp();
    ajax.open("GET","registro_cliente.php?op=62"
                        +"&email="+email
                        +"&nombre="+nombre
                        +"&apellido="+apellido
                        +"&fecha_nacim="+fecha_nacim
                        +"&cod_pais="+cod_pais              
                        +"&fono="+fono
                        +"&ciudad="+ciudad
                        +"&domicilio="+domicilio
                        +"&clave="+clave,true);
                
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////
    ajax.onreadystatechange = function() {
	
	if (ajax.readyState == 4) {
		var respuesta=ajax.responseText;
		document.getElementById('salida').innerHTML=respuesta;
        
        if (document.getElementById('eco_grabar_misdatos_comprar').value=="ok"){
            window.opener.document.form_portal.bt_reload_pag.onclick();
            window.location="tour_comprar_tbank.php?op=1";
            
        }else if (document.getElementById('eco_grabar_misdatos_comprar').value=="err"){
            alert ("Clave Incorrecta.");
            document.getElementById('msn_clave_6').innerHTML = "Clave Incorrecta.";
        }
	}}
    ajax.send(null);
    /////////////////////////////////////////////////////////////////////////////    
}
*/
