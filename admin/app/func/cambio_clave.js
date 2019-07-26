function grabar_cambio_clave(){
    
     document.getElementById('msn_pass1').innerHTML = "";
     document.getElementById('msn_pass2').innerHTML = "";
     document.getElementById('msn_pass3').innerHTML = ""; 
     
   	if (document.getElementById('clave_actual').value =="") {
		document.getElementById('msn_pass1').innerHTML = "Ingrese Clave Actual.";
		document.getElementById('clave_actual').focus();
		return false;
	} else {document.getElementById("msn_pass1").innerHTML = "";}
    	
    
   	if (document.getElementById('clave_nueva1').value =="") {
		document.getElementById('msn_pass2').innerHTML = "Ingrese Clave Nueva.";
		document.getElementById('clave_nueva1').focus();
		return false;
	} else {document.getElementById("msn_pass2").innerHTML = "";}
    
   	if (document.getElementById('clave_nueva2').value =="") {
		document.getElementById('msn_pass3').innerHTML = "Ingrese Confirmacion.";
		document.getElementById('clave_nueva2').focus();
		return false;
	} else {document.getElementById("msn_pass3").innerHTML = "";}
    
   	if ((document.getElementById('clave_nueva1').value) != (document.getElementById('clave_nueva2').value)) {
		document.getElementById('msn_pass3').innerHTML = "Las Claves no coinciden.";
		document.getElementById('clave_nueva1').focus();
		return false;
	} else {document.getElementById("msn_pass3").innerHTML = "";}
     
    
    rut             = document.getElementById('rut').value;
    clave_actual    = document.getElementById('clave_actual').value; 
    clave_nueva1    = document.getElementById('clave_nueva1').value;

    var ajax=XMLHttp();    
    ajax.open("GET","cambio_clave.php?op=2"
                        +"&rut="+rut
                        +"&clave_actual="+clave_actual
                        +"&clave_nueva1="+clave_nueva1,true);                
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 			
	
    /////////////////////////////////////////////////////////////////////////////    
    ajax.onreadystatechange = function() {	
	if (ajax.readyState == 4) {		  
		var respuesta=ajax.responseText;            
		document.getElementById('salida').innerHTML=respuesta;
                
        if (document.getElementById('eco_grabar').value=="update_ok"){
            alert("Se ha cambiado clave con exito.");
            window.close() 
             
        }else if (document.getElementById('eco_grabar').value=="err_update"){  
            document.getElementById('msn_pass1').innerHTML = "Clave actual es incorrecta.";                  
        }  
	}}
    ajax.send(null);
    /////////////////////////////////////////////////////////////////////////////  
}