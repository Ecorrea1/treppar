function activar_ident_compra(){  
    tipo_ident = document.getElementsByName('tipo_ident');
    
    if(tipo_ident['0'].checked){ //Rut        
        document.getElementById('nro_ident').placeholder="Rut (Ej: 11111111-1)";
    
    }else if(tipo_ident['1'].checked){//Dni
        document.getElementById('nro_ident').placeholder="Dni / Extranjero";
        
    }else if(tipo_ident['2'].checked){//pasaporte
        document.getElementById('nro_ident').placeholder="Pasaporte";
    }
}

function eliminar_compra(key_cab, producto){
    
    jConfirm("<table style='font: 12px Arial;'>"
            +"<tr><td align='center'>Esta seguro(a) que desea Eliminar la siguiente compra?:<td></tr>"
            +"<tr><td align='center' style='color:blue;'>"+producto+"</td></tr>"
            +"</table>"
            , "Confirmacion", function(r) {
        if(r) {
    //jconfirm
    
        var ajax=XMLHttp();
        ajax.open("GET","tour_comprar.php?op=2"
                                    +"&key_cab="+key_cab
                                    +"&accion=eliminar",true);
        ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        /////////////////////////////////////////////////////////////////////////////
        ajax.onreadystatechange = function() {
    	
    		if (ajax.readyState == 4) {
    			var respuesta=ajax.responseText;
    			document.getElementById('div_compras').innerHTML=respuesta;                
                
                if (document.getElementById('eco_eliminar').value=="err"){
                    alert("Se han eliminado todas las compras.", "Validacion");
                    window.close();
                }
    		}}
            
        ajax.send(null);

    //jconfirm
        } else {            
           return false;
        }
    });
    //jconfirm
}

function grabar_formulario(){
    document.getElementById('msn_ident').innerHTML      = "";
    document.getElementById('msn_nombre').innerHTML     = "";
    document.getElementById('msn_apellido').innerHTML   = "";
    document.getElementById('msn_pais').innerHTML       = "";
    document.getElementById('msn_fono').innerHTML       = "";
    document.getElementById('msn_email').innerHTML      = "";
    
    if (document.getElementById('total_compra').value =="0") {
        jAlert("<label style='color: #DF0101;'>No Existen Compras</label>","Confirmacion");
		return false;
	}
    
    tipo_ident = document.getElementsByName('tipo_ident');
    
    if(tipo_ident['0'].checked){ //Rut
        if (document.getElementById('nro_ident').value =="") {
        	document.getElementById('msn_ident').innerHTML = "Ingrese Rut.";
        	document.getElementById('nro_ident').focus();
        	return false;
        } else {document.getElementById('msn_ident').innerHTML = "";}
        
        valida_rut(document.getElementById('nro_ident'), 'msn_ident');
        
        if (document.getElementById('msn_ident').innerHTML != "") {
            return false;
        }
        
        tipo_ident="rut";
    
    }else if(tipo_ident['1'].checked){//Dni
        if (document.getElementById('nro_ident').value =="") {
        	document.getElementById('msn_ident').innerHTML = "Ingrese Dni.";
        	document.getElementById('nro_ident').focus();
        	return false;
        } else {document.getElementById('msn_ident').innerHTML = "";}
        
        tipo_ident="dni";        
        
    }else if(tipo_ident['2'].checked){//pasaporte
        if (document.getElementById('nro_ident').value =="") {
        	document.getElementById('msn_ident').innerHTML = "Ingrese Pasaporte.";
        	document.getElementById('nro_ident').focus();
        	return false;
        } else {document.getElementById('msn_ident').innerHTML = "";}
        
        tipo_ident="pasaporte";        
    }
    
    if (document.getElementById('nombre').value =="") {
		document.getElementById('msn_nombre').innerHTML = "Ingrese Nombres.";
		document.getElementById('nombre').focus();
		return false;
	} else {document.getElementById('msn_nombre').innerHTML = "";}
    
    if (document.getElementById('apellido').value =="") {
		document.getElementById('msn_apellido').innerHTML = "Ingrese Apellidos.";
		document.getElementById('apellido').focus();
		return false;
	} else {document.getElementById('msn_apellido').innerHTML = "";}
    
    if (document.getElementById('cod_pais').value =="@") {
		document.getElementById('msn_pais').innerHTML = "Seleccione Pais.";
		document.getElementById('cod_pais').focus();
		return false;
	} else {document.getElementById('msn_pais').innerHTML = "";}
    
    if (document.getElementById('fono').value =="") {
		document.getElementById('msn_fono').innerHTML = "Ingrese Fono.";
		document.getElementById('fono').focus();
		return false;
	} else {document.getElementById('msn_fono').innerHTML = "";}
    
    if (document.getElementById('email').value =="") {
		document.getElementById('msn_email').innerHTML = "Ingrese Email.";
		document.getElementById('email').focus();
		return false;
	} else {document.getElementById('msn_email').innerHTML = "";}
    
    nro_ident   = document.getElementById('nro_ident').value;
    nombre      = document.getElementById('nombre').value;
    apellido    = document.getElementById('apellido').value;
    cod_pais    = document.getElementById('cod_pais').value;
    fono        = document.getElementById('fono').value;
    email       = document.getElementById('email').value;
    
    var ajax=XMLHttp();
    ajax.open("GET","tour_comprar.php?op=3"
                                +"&tipo_ident="+tipo_ident
                                +"&nro_ident="+nro_ident
                                +"&nombre="+nombre
                                +"&apellido="+apellido
                                +"&cod_pais="+cod_pais
                                +"&fono="+fono
                                +"&email="+email,true);
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////
    ajax.onreadystatechange = function() {
	
		if (ajax.readyState == 4) {
			var respuesta=ajax.responseText;
			document.getElementById('salida').innerHTML=respuesta;
            
            if (document.getElementById('eco_grabar').value=="err_fechas"){
                jAlert("<label style='color:#DF0101;'>Lo sentimos, pero las siguientes fechas fueron reservadas:</label><br/><br/>"+document.getElementById('fechas_usadas').value+"<br/><br/><label style='color:#DF0101;'>Intente con otro rango de fechas.</label>","Validacion");
            
            }else if (document.getElementById('eco_grabar').value=="ok"){
                location.href = "tbank/pagar.php";
            }
		}}
    ajax.send(null);
}