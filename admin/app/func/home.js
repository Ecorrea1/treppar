function open_pag(pagina,op) {            
    var ajax=XMLHttp();            
    ajax.open("GET", pagina + ".php?op="+op, true);  
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 			
	ajax.onreadystatechange = function() {	
	if (ajax.readyState == 4) {			
		var respuesta=ajax.responseText;       
		document.getElementById('contenido').innerHTML=respuesta;
        
        valida_sesion();        
	}}
	ajax.send(null);
}

function cambio_clave(){
    Popup_clave = window.open("cambio_clave.php?op=1","Popup_clave","width=550,height=300,left=400,top=200,resizable=yes,scrollbars=yes");    
    Popup_clave.focus();
}