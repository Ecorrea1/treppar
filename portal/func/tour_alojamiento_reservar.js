function oculta_divpersonas_alojam(){
    document.getElementById('div_personas').style.display   = "none";
    document.getElementById('adultojoven').value            = "0";
    document.getElementById('adultomayor').value            = "0";
    document.getElementById('nino').value                   = "0";
    document.getElementById('grilla_valores').innerHTML     = "";
}

function validar_fecha_alojam(){
    document.getElementById('msn_fecha_in').innerHTML       = "";
    document.getElementById('msn_fecha_out').innerHTML      = "";
    document.getElementById('msn_valida_reservas').innerHTML= "";
    
    if (document.getElementById('fecha_in').value =="") {
        document.getElementById('msn_fecha_in').innerHTML = "Ingrese fecha de entrada.";
        document.getElementById('fecha_in').focus();
        return false;
    } else {document.getElementById("msn_fecha_in").innerHTML = "";}
    
    if (document.getElementById('fecha_out').value =="") {
        document.getElementById('msn_fecha_out').innerHTML = "Ingrese fecha de salida.";
        document.getElementById('fecha_out').focus();
        return false;
    } else {document.getElementById("msn_fecha_out").innerHTML = "";}
    
    if (document.getElementById('fecha_in').value==document.getElementById('fecha_out').value) {
        document.getElementById('msn_fecha_out').innerHTML = "Fecha de ingreso y salida deben ser distintas.";
        document.getElementById('fecha_out').focus();
        return false;
    } else {document.getElementById("msn_fecha_out").innerHTML = "";}
    
    if (document.getElementById('fecha_in').value>document.getElementById('fecha_out').value) {
        document.getElementById('msn_valida_reservas').innerHTML = "Rango de fechas no es valido.";
        document.getElementById('fecha_out').focus();
        return false;
    } else {document.getElementById("msn_valida_reservas").innerHTML = "";}
    
    id_unidad   = document.getElementById('id_unidad').value;
    fecha_in    = document.getElementById('fecha_in').value;
    fecha_out   = document.getElementById('fecha_out').value;
   
    var ajax=XMLHttp();
    ajax.open("GET","tour_alojamiento_reservar.php?op=2"
                            +"&id_unidad="+id_unidad
                            +"&fecha_in="+fecha_in
                            +"&fecha_out="+fecha_out,true);
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////
    ajax.onreadystatechange = function() {
	
		if (ajax.readyState == 4) {
			var respuesta=ajax.responseText;
			document.getElementById('msn_valida_reservas').innerHTML=respuesta;
            
            if (document.getElementById('eco_valida_fecha').value=="ok"){
                document.getElementById('div_personas').style.display="block";
                             
            }else if (document.getElementById('eco_valida_fecha').value=="err"){                
                document.getElementById('div_personas').style.display="none";
                
            }
		}}
    ajax.send(null);
}

function valida_cant_personas_alojam(){    
    adultojoven = document.getElementById('adultojoven').value;
    adultomayor = document.getElementById('adultomayor').value;
    nino        = document.getElementById('nino').value;
    
    cant_actual = parseInt(adultojoven) + parseInt(adultomayor) + parseInt(nino);
   
    if (cant_actual>=document.getElementById('cant_persona').innerHTML){
        alert("Ya se ha definido el numero maximo de personas.");
        return r= false;
    }else{
        return r= true;
    }
}

function cant_adultojoven_alojam(operacion){
    if(operacion=="-"){
        if(document.getElementById('adultojoven').value!=0){
            document.getElementById('adultojoven').value = parseInt(document.getElementById('adultojoven').value)-1;
        }
        grilla_valores_alojam();
        
    }else if(operacion=="+"){
        valida_cant_personas_alojam();
        if (r==true){
            if(document.getElementById('adultojoven').value<150){
                document.getElementById('adultojoven').value = parseInt(document.getElementById('adultojoven').value)+1;
                grilla_valores_alojam();
            }
        }
    }
}

function cant_adultomayor_alojam(operacion){    
    if(operacion=="-"){
        if(document.getElementById('adultomayor').value!=0){
            document.getElementById('adultomayor').value = parseInt(document.getElementById('adultomayor').value)-1;
            grilla_valores_alojam();
        }
        
    }else if(operacion=="+"){
        valida_cant_personas_alojam();
        if (r==true){
            if(document.getElementById('adultojoven').value<150){
                document.getElementById('adultomayor').value = parseInt(document.getElementById('adultomayor').value)+1;
                grilla_valores_alojam();
            }
        }
    }
}

function cant_nino_alojam(operacion){    
    if(operacion=="-"){
        if(document.getElementById('nino').value!=0){
            document.getElementById('nino').value = parseInt(document.getElementById('nino').value)-1;
            grilla_valores_alojam();
        }
        
    }else if(operacion=="+"){
        valida_cant_personas_alojam();
        if (r==true){
            if(document.getElementById('adultojoven').value<150){
                document.getElementById('nino').value = parseInt(document.getElementById('nino').value)+1;
                grilla_valores_alojam();
            }
        }
    }    
}

function grilla_valores_alojam(){
    id_unidad           = document.getElementById('id_unidad').value;
    nom_unidad          = document.getElementById('nom_unidad').value;
    nom_estab           = document.getElementById('nom_estab').value;
    id_comuna           = document.getElementById('id_comuna').value;
    nom_comuna          = document.getElementById('nom_comuna').value;    
    fecha_in            = document.getElementById('fecha_in').value;
    fecha_out           = document.getElementById('fecha_out').value;
    
    cant_adultojoven    = document.getElementById('adultojoven').value;
    cant_adultomayor    = document.getElementById('adultomayor').value;
    cant_nino           = document.getElementById('nino').value;
    
    precio              = document.getElementById('precio').value;
    dolar               = document.getElementById('dolar').value;
    
    var ajax=XMLHttp();
    ajax.open("GET","tour_alojamiento_reservar.php?op=3"
                                +"&id_unidad="+id_unidad
                                +"&nom_unidad="+nom_unidad
                                +"&nom_estab="+nom_estab
                                +"&id_comuna="+id_comuna
                                +"&nom_comuna="+nom_comuna
                                +"&fecha_in="+fecha_in
                                +"&fecha_out="+fecha_out
                                +"&cant_adultojoven="+cant_adultojoven
                                +"&cant_adultomayor="+cant_adultomayor
                                +"&cant_nino="+cant_nino
                                +"&precio="+precio
                                +"&dolar="+dolar,true);
                                
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////
    ajax.onreadystatechange = function() {
	
		if (ajax.readyState == 4) {
			var respuesta=ajax.responseText;
			document.getElementById('grilla_valores').innerHTML=respuesta;
		}}
    ajax.send(null);
}

function agregar_compra_alojam(){
    id_unidad = document.getElementById('id_unidad').value;
    var ajax=XMLHttp();
    ajax.open("GET","tour_alojamiento_reservar.php?op=4"
                                +"&id_unidad="+id_unidad
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
        ajax.open("GET","tour_alojamiento_reservar.php?op=4"
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