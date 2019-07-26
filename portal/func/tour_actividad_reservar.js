function valida_fecha_activ(){
    if (document.getElementById('fecha').value =="") {
        document.getElementById('msn_fecha').innerHTML = "Ingrese fecha.";
        document.getElementById('fecha').focus();
        return r= false;
    }else{
        document.getElementById("msn_fecha").innerHTML = "";
        return r= true;
    }    
}

function cant_adultojoven_activ(operacion){
    valida_fecha_activ();
    if (r==true){
    
        if(operacion=="-"){
            if(document.getElementById('adultojoven').value!=0){
                document.getElementById('adultojoven').value = parseInt(document.getElementById('adultojoven').value)-1;
            }
            
        }else if(operacion=="+"){
            if(document.getElementById('adultojoven').value<150){
                document.getElementById('adultojoven').value = parseInt(document.getElementById('adultojoven').value)+1;
            }     
        }
        grilla_valores_activ();
        
    }
}

function cant_adultomayor_activ(operacion){
    valida_fecha_activ();
    if (r==true){
    
        if(operacion=="-"){
            if(document.getElementById('adultomayor').value!=0){
                document.getElementById('adultomayor').value = parseInt(document.getElementById('adultomayor').value)-1;
            }
            
        }else if(operacion=="+"){
            if(document.getElementById('adultojoven').value<150){
                document.getElementById('adultomayor').value = parseInt(document.getElementById('adultomayor').value)+1;
            }
        }
        grilla_valores_activ();
    
    }
}

function cant_nino_activ(operacion){
    valida_fecha_activ();
    if (r==true){
    
        if(operacion=="-"){
            if(document.getElementById('nino').value!=0){
                document.getElementById('nino').value = parseInt(document.getElementById('nino').value)-1;
            }
            
        }else if(operacion=="+"){
            if(document.getElementById('adultojoven').value<150){
                document.getElementById('nino').value = parseInt(document.getElementById('nino').value)+1;
            }
        }
        grilla_valores_activ();
    
    }
}

function grilla_valores_activ(){
    id_activ            = document.getElementById('id_activ').value;
    nom_activ           = document.getElementById('nom_activ').value;
    id_comuna           = document.getElementById('id_comuna').value;
    nom_comuna          = document.getElementById('nom_comuna').value;    
    fecha_in            = document.getElementById('fecha').value;
    fecha_out           = document.getElementById('fecha').value;
    
    cant_adultojoven    = document.getElementById('adultojoven').value;
    cant_adultomayor    = document.getElementById('adultomayor').value;
    cant_nino           = document.getElementById('nino').value;
    
    precio_adultojoven  = document.getElementById('precio_adultojoven').value;
    precio_adultomayor  = document.getElementById('precio_adultomayor').value;
    precio_nino         = document.getElementById('precio_nino').value;
    
    var ajax=XMLHttp();
    ajax.open("GET","tour_actividad_reservar.php?op=2"
                                +"&id_activ="+id_activ
                                +"&nom_activ="+nom_activ
                                +"&id_comuna="+id_comuna
                                +"&nom_comuna="+nom_comuna
                                +"&fecha_in="+fecha_in
                                +"&fecha_out="+fecha_out
                                +"&cant_adultojoven="+cant_adultojoven
                                +"&cant_adultomayor="+cant_adultomayor
                                +"&cant_nino="+cant_nino
                                +"&precio_adultojoven="+precio_adultojoven
                                +"&precio_adultomayor="+precio_adultomayor
                                +"&precio_nino="+precio_nino,true);
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////
    ajax.onreadystatechange = function() {
	
		if (ajax.readyState == 4) {
			var respuesta=ajax.responseText;
			document.getElementById('grilla_valores').innerHTML=respuesta;
		}}
    ajax.send(null);
}

function agregar_compra_activ(){
    id_activ = document.getElementById('id_activ').value;
    var ajax=XMLHttp();
    ajax.open("GET","tour_actividad_reservar.php?op=3"
                                +"&id_activ="+id_activ
                                +"&accion=agregar",true);
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////
    ajax.onreadystatechange = function() {
	
		if (ajax.readyState == 4) {
			var respuesta=ajax.responseText;
			document.getElementById('div_compras').innerHTML=respuesta;
		}}
    ajax.send(null);
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
        ajax.open("GET","tour_actividad_reservar.php?op=3"
                                    +"&key_cab="+key_cab
                                    +"&accion=eliminar",true);
        ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        /////////////////////////////////////////////////////////////////////////////
        ajax.onreadystatechange = function() {
    	
    		if (ajax.readyState == 4) {
    			var respuesta=ajax.responseText;
    			document.getElementById('div_compras').innerHTML=respuesta;
    		}}
        ajax.send(null);

    //jconfirm
        } else {            
           return false;
        }
    });
    //jconfirm
}