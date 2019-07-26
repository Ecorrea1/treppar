function activa_pesta(n_pesta) {
    if (n_pesta=="1"){ //ACTIVIDADES
        document.getElementById('pesta1').className="pesta_in";
        document.getElementById('pesta2').className="pesta_out";
        op_filtro="3";        
        
    }else if (n_pesta=="2"){ //ALOJAMIENTOS
        document.getElementById('pesta1').className="pesta_out";
        document.getElementById('pesta2').className="pesta_in";
        op_filtro="4";
    }
    
    
    //Cambia filtro Actividades o Alojamientos
    var ajax=XMLHttp();
    ajax.open("GET","index2.php?op="+op_filtro,true);
                
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");    
    ajax.onreadystatechange = function() {
	
	if (ajax.readyState == 4) {
		var respuesta=ajax.responseText;
		document.getElementById('div_filtro').innerHTML=respuesta;
        
        if (n_pesta=="1"){ //ACTIVIDADES
            buscar_actividad();
            
        }else if (n_pesta=="2"){ //ALOJAMIENTOS            
            buscar_alojamiento();
        }        
  	}}
    ajax.send(null);
    
    //################################################################################
}

function buscar_ciudad() {
    var ajax=XMLHttp();
    document.getElementById('ciudad_encontrada').style.display="block";
    
    ajax.open("GET","index2.php?op=5"                    
                            +"&ciudad="+document.getElementById('ciudad').value,true);                
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////
    ajax.onreadystatechange = function() {
	
		if (ajax.readyState == 4) {
			var respuesta=ajax.responseText;
			document.getElementById('ciudad_encontrada').innerHTML=respuesta;
		}}
    ajax.send(null);  
}

function seleccion_ciudad(ciudad) {
    document.getElementById('ciudad').value=ciudad;
    document.getElementById('ciudad_encontrada').style.display="none";
}

//ACTIVIDAD
function buscar_actividad(){
    ciudad          = document.getElementById('ciudad').value;
    id_tipo_activ   = document.getElementById('id_tipo_activ').value;
    
    var ajax=XMLHttp();
    
    if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){        
        ajax.open("GET","tour_actividad.php?op=2"                 
                            +"&ciudad="+ciudad
                            +"&id_tipo_activ="+id_tipo_activ,true);  
    }else{        
        var ajax=XMLHttp();
        ajax.open("GET","tour_actividad.php?op=1"  
                            +"&ciudad="+ciudad
                            +"&id_tipo_activ="+id_tipo_activ
                            +"&w="+screen.width
                            +"&h="+screen.height,true);
    }
                
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////
    ajax.onreadystatechange = function() {
	
		if (ajax.readyState == 4) {
			var respuesta=ajax.responseText;
			document.getElementById('grilla_producto').innerHTML=respuesta;
		}}
    ajax.send(null);
    
    document.getElementById('ciudad_encontrada').style.display="none";
    /////////////////////////////////////////////////////////////////////////////
}

function go_actividad_detalle(id_activ){
    parametros_popup();
    popup_activ_detalle = window.open("tour_actividad_detalle.php?op=1&id_activ="+id_activ,"popup_activ_detalle", param_popup);
    popup_activ_detalle.focus();
}

function go_actividad_reservar(id_activ){
    parametros_popup();
    popup_activ_reservar = window.open("tour_actividad_reservar.php?op=1&id_activ="+id_activ,"popup_activ_reservar", param_popup);
    popup_activ_reservar.focus();
}

//ALOJAMIENTO
function buscar_alojamiento(){
    ciudad          = document.getElementById('ciudad').value;
    id_tipo_alojam  = document.getElementById('id_tipo_alojam').value;
    
    var ajax=XMLHttp();
    
    if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){        
        ajax.open("GET","tour_alojamiento.php?op=2"                 
                            +"&ciudad="+ciudad
                            +"&id_tipo_alojam="+id_tipo_alojam,true);  
    }else{        
        var ajax=XMLHttp();
        ajax.open("GET","tour_alojamiento.php?op=1"  
                            +"&ciudad="+ciudad
                            +"&id_tipo_alojam="+id_tipo_alojam
                            +"&w="+screen.width
                            +"&h="+screen.height,true);
    }
                
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////
    ajax.onreadystatechange = function() {
	
		if (ajax.readyState == 4) {
			var respuesta=ajax.responseText;
			document.getElementById('grilla_producto').innerHTML=respuesta;
		}}
    ajax.send(null);
    
    document.getElementById('ciudad_encontrada').style.display="none";
    /////////////////////////////////////////////////////////////////////////////
}

function go_iniciar_sesion(){
    parametros_popup();
    popup_usuario = window.open("tour_usuario_inicio.php?op=11","popup_usuario", param_popup);
    popup_usuario.focus();
}

function go_mi_perfil(){
    parametros_popup();
    popup_usuario = window.open("tour_usuario_miperfil.php?op=11","popup_usuario", param_popup);
    popup_usuario.focus();
}

function go_alojamiento_detalle(id_estab){
    parametros_popup();
    popup_alojam_detalle = window.open("tour_alojamiento_detalle.php?op=1&id_estab="+id_estab,"popup_alojam_detalle", param_popup);
    popup_alojam_detalle.focus();
}

/*
function go_alojamiento_comprar(id_estab){
    parametros_popup();
    popup_tour_comprar = window.open("tour_alojamiento_detalle2.php?op=1&id_estab="+id_estab,"popup_tour_comprar", param_popup);
    popup_tour_comprar.focus();
    
    //parametros_popup();
    //popup_tour_comprar = window.open("tour_alojamiento_comprar.php?op=1&id_estab="+id_estab,"popup_tour_comprar", param_popup);
    //popup_tour_comprar.focus();
   
}*/
