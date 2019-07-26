function limpia_form_actividad(){
    document.getElementById('form_actividad').reset();
    
    document.getElementById('msn_id').innerHTML             = "";
    document.getElementById('msn_empresa').innerHTML        = "";
    document.getElementById('msn_nom_activ').innerHTML      = "";
    document.getElementById('msn_tipo_activ').innerHTML     = "";
    document.getElementById('msn_descripcion').innerHTML    = "";
    document.getElementById('msn_sugerencia').innerHTML     = "";
    document.getElementById('msn_requisito').innerHTML      = "";
    document.getElementById('msn_dificultad').innerHTML     = "";
    document.getElementById('msn_edad_min').innerHTML       = "";
    document.getElementById('msn_lugar_sal').innerHTML      = "";
    document.getElementById('msn_comuna').innerHTML         = "";
    document.getElementById('msn_dias').innerHTML           = "";    
    document.getElementById('msn_duracion_hr').innerHTML    = "";
    document.getElementById('msn_duracion_dia').innerHTML   = ""; 
    document.getElementById('msn_hr_inicio').innerHTML      = "";
    
    document.getElementById('msn_padultojoven').innerHTML   = "";
    document.getElementById('msn_pnino').innerHTML          = "";
    document.getElementById('msn_padultomayor').innerHTML   = "";
    document.getElementById('msn_pgrupo').innerHTML         = "";
    document.getElementById('msn_grupo').innerHTML          = "";
     
    document.getElementById('msn_update').innerHTML         = "";
    document.getElementById('salida').innerHTML             = "";
}

function contchar1(txt){
    nchar1.value    = 500-(document.getElementById('descripcion').value.length);
}

function contchar2(txt){
    nchar2.value    = 250-(document.getElementById('sugerencia').value.length);
}

function contchar3(txt){
    nchar3.value    = 250-(document.getElementById('requisito').value.length);
}

function ver_detalle_actividad(id_activ){
    if (document.getElementById('btver_'+id_activ).value==" + "){     
        document.getElementById('div_detalle_'+id_activ).style.display = "block";
        document.getElementById('btver_'+id_activ).value = " - ";
        
    }else{    
        
        document.getElementById('div_detalle_'+id_activ).style.display = "none";       
        document.getElementById('btver_'+id_activ).value = " + ";
    }    
}

function activar_duracion(){
    duracion = document.getElementsByName('duracion');
    
    if(duracion['0'].checked){//Horas
        document.getElementById('duracion_dia').value   = '0';
        
        document.getElementById('duracion_hh').style.visibility    = 'visible';
        document.getElementById('duracion_mm').style.visibility    = 'visible';
        document.getElementById('duracion_dia').style.visibility   = 'hidden';
        
    
    }else if(duracion['1'].checked){//Dias
        document.getElementById('duracion_hh').value                                                                                                                                                                  = '00';
        document.getElementById('duracion_mm').value    = '00';
        
        document.getElementById('duracion_hh').style.visibility    = 'hidden';
        document.getElementById('duracion_mm').style.visibility    = 'hidden';
        document.getElementById('duracion_dia').style.visibility   = 'visible';
    }
}

function selecc_actividad(id_activ,rut_empr,nom_activ,id_tipo_activ,descripcion,sugerencia,requisito,dificultad,
edad_minima,lugar_salida,id_comuna,lun,mar,mie,jue,vie,sab,dom,duracion_hh,duracion_mm,duracion_dia,
hh_ini,mm_ini,precio_adultojoven,precio_nino, precio_adultomayor,precio_grupo, dolar_adultojoven,dolar_nino,
dolar_adultomayor,dolar_grupo,dscto_adultojoven,dscto_nino,dscto_adultomayor,dscto_grupo,grupo) {
    
    document.getElementById('id_activ').value       = id_activ;
    document.getElementById('rut_empr').value       = rut_empr;
    document.getElementById('nom_activ').value      = nom_activ;
    document.getElementById('id_tipo_activ').value  = id_tipo_activ;
    document.getElementById('descripcion').value    = descripcion;
    document.getElementById('sugerencia').value     = sugerencia;
    document.getElementById('requisito').value      = requisito;
    document.getElementById('dificultad').value     = dificultad;
    document.getElementById('edad_minima').value    = edad_minima;
    document.getElementById('lugar_salida').value   = lugar_salida;
    document.getElementById('id_comuna').value      = id_comuna;
    
    if (lun=="1"){ document.getElementById('lun').checked=true;}else{ document.getElementById('lun').checked=false; }
    if (mar=="1"){ document.getElementById('mar').checked=true;}else{ document.getElementById('mar').checked=false; }
    if (mie=="1"){ document.getElementById('mie').checked=true;}else{ document.getElementById('mie').checked=false; }
    if (jue=="1"){ document.getElementById('jue').checked=true;}else{ document.getElementById('jue').checked=false; }
    if (vie=="1"){ document.getElementById('vie').checked=true;}else{ document.getElementById('vie').checked=false; }
    if (sab=="1"){ document.getElementById('sab').checked=true;}else{ document.getElementById('sab').checked=false; }
    if (dom=="1"){ document.getElementById('dom').checked=true;}else{ document.getElementById('dom').checked=false; }
    
    duracion = document.getElementsByName('duracion');
        
    if (duracion_hh!="00" || duracion_mm!="00"){
        duracion['0'].checked = true;//Horas
        duracion['1'].checked = false;//Dias 
        document.getElementById('duracion_hh').style.visibility = 'visible';
        document.getElementById('duracion_mm').style.visibility = 'visible';
        document.getElementById('duracion_dia').style.visibility= 'hidden';
        
    }else if (duracion_dia>0){
        duracion['0'].checked = false;//Horas
        duracion['1'].checked = true;//Dias 
        document.getElementById('duracion_hh').style.visibility = 'hidden';
        document.getElementById('duracion_mm').style.visibility = 'hidden';
        document.getElementById('duracion_dia').style.visibility= 'visible';
    }
    
    document.getElementById('duracion_hh').value        = duracion_hh;
    document.getElementById('duracion_mm').value        = duracion_mm;
    document.getElementById('duracion_dia').value       = duracion_dia;
    document.getElementById('hh_ini').value             = hh_ini;
    document.getElementById('mm_ini').value             = mm_ini;
    
    document.getElementById('precio_adultojoven').value = precio_adultojoven;
    document.getElementById('precio_nino').value        = precio_nino;
    document.getElementById('precio_adultomayor').value = precio_adultomayor;
    document.getElementById('precio_grupo').value       = precio_grupo;

    document.getElementById('dolar_adultojoven').value  = dolar_adultojoven;
    document.getElementById('dolar_nino').value         = dolar_nino;
    document.getElementById('dolar_adultomayor').value  = dolar_adultomayor;
    document.getElementById('dolar_grupo').value        = dolar_grupo;
    
    
    document.getElementById('dscto_adultojoven').value  = dscto_adultojoven;
    document.getElementById('dscto_nino').value         = dscto_nino;
    document.getElementById('dscto_adultomayor').value  = dscto_adultomayor;
    document.getElementById('dscto_grupo').value        = dscto_grupo;

     document.getElementById('grupo').value             = grupo;
        
    document.getElementById('msn_update').innerHTML = "Esta Actualizando Este Registro.";
}

function grabar_actividad(){    
    document.getElementById('msn_id').innerHTML             = "";
    document.getElementById('msn_empresa').innerHTML        = "";
    document.getElementById('msn_nom_activ').innerHTML      = "";
    document.getElementById('msn_tipo_activ').innerHTML     = "";
    document.getElementById('msn_descripcion').innerHTML    = "";
    document.getElementById('msn_sugerencia').innerHTML     = "";
    document.getElementById('msn_requisito').innerHTML      = "";
    document.getElementById('msn_dificultad').innerHTML     = "";
    document.getElementById('msn_edad_min').innerHTML       = "";
    document.getElementById('msn_lugar_sal').innerHTML      = "";
    document.getElementById('msn_comuna').innerHTML         = "";
    document.getElementById('msn_dias').innerHTML           = "";    
    document.getElementById('msn_duracion_hr').innerHTML    = "";
    document.getElementById('msn_duracion_dia').innerHTML   = ""; 
    document.getElementById('msn_hr_inicio').innerHTML      = "";
    document.getElementById('msn_padultojoven').innerHTML   = "";
    document.getElementById('msn_pnino').innerHTML          = "";
    document.getElementById('msn_padultomayor').innerHTML   = "";
    document.getElementById('msn_pgrupo').innerHTML         = "";
    document.getElementById('msn_grupo').innerHTML          = "";   
    
    if (document.getElementById('rut_empr').value =="@") {
		document.getElementById('msn_empresa').innerHTML = "Seleccione Empresa.";
		document.getElementById('rut_empr').focus();
		return false;
	} else {document.getElementById("msn_empresa").innerHTML = "";}
    
   	if (document.getElementById('nom_activ').value =="") {
		document.getElementById('msn_nom_activ').innerHTML = "Ingrese Nombre.";
		document.getElementById('nom_activ').focus();
		return false;
	} else {document.getElementById("msn_nom_activ").innerHTML = "";}
    
    if (document.getElementById('id_tipo_activ').value =="@") {
		document.getElementById('msn_tipo_activ').innerHTML = "Seleccione Tipo Actividad.";
		document.getElementById('id_tipo_activ').focus();
		return false;
	} else {document.getElementById("msn_tipo_activ").innerHTML = "";}
    
       	if (document.getElementById('descripcion').value =="") {
		document.getElementById('msn_descripcion').innerHTML = "Ingrese Descripcion.";
		document.getElementById('descripcion').focus();
		return false;
	} else {document.getElementById("msn_descripcion").innerHTML = "";}
    
   	if (document.getElementById('sugerencia').value =="") {
		document.getElementById('msn_sugerencia').innerHTML = "Ingrese Sugerencia.";
		document.getElementById('sugerencia').focus();
		return false;
	} else {document.getElementById("msn_sugerencia").innerHTML = "";}
    
    if (document.getElementById('requisito').value =="") {
		document.getElementById('msn_requisito').innerHTML = "Ingrese Requisito.";
		document.getElementById('requisito').focus();
		return false;
	} else {document.getElementById("msn_requisito").innerHTML = "";}
    
    if (document.getElementById('dificultad').value =="@") {
		document.getElementById('msn_dificultad').innerHTML = "Seleccione Dificultad.";
		document.getElementById('dificultad').focus();
		return false;
	} else {document.getElementById("msn_dificultad").innerHTML = "";}
    
    if (document.getElementById('edad_minima').value =="") {
		document.getElementById('msn_edad_min').innerHTML = "Ingrese Edad Minima.";
		document.getElementById('edad_minima').focus();
		return false;
	} else {document.getElementById("msn_edad_min").innerHTML = "";}
    
    if (document.getElementById('lugar_salida').value =="") {
		document.getElementById('msn_lugar_sal').innerHTML = "Ingrese Lugar Salida.";
		document.getElementById('lugar_salida').focus();
		return false;
	} else {document.getElementById("msn_lugar_sal").innerHTML = "";}
    
    if (document.getElementById('id_comuna').value =="@") {
		document.getElementById('msn_comuna').innerHTML = "Seleccione Comuna.";
		document.getElementById('id_comuna').focus();
		return false;
	} else {document.getElementById("msn_comuna").innerHTML = "";}
    
    if (document.getElementById("lun").checked==false &&
        document.getElementById("mar").checked==false &&
        document.getElementById("mie").checked==false &&
        document.getElementById("jue").checked==false &&
        document.getElementById("vie").checked==false &&
        document.getElementById("sab").checked==false &&
        document.getElementById("dom").checked==false){            
        document.getElementById('msn_dias').innerHTML = "Seleccione Dias.";
		return false;
	} else {document.getElementById("msn_dias").innerHTML = "";}
   	
    duracion = document.getElementsByName('duracion');
    
    if(duracion['0'].checked){//Horas
       	if (document.getElementById('duracion_hh').value =="00" && document.getElementById('duracion_mm').value =="00") {
    		document.getElementById('msn_duracion_hr').innerHTML = "Ingrese Duracion.";
    		document.getElementById('duracion_hh').focus();
    		return false;
    	} else {document.getElementById("msn_duracion_hr").innerHTML = "";}
        
    }else if(duracion['1'].checked){//Dias
        if (document.getElementById('duracion_dia').value =="0") {
    		document.getElementById('msn_duracion_dia').innerHTML = "Ingrese Duracion.";
    		document.getElementById('duracion_dia').focus();
    		return false;
    	} else {document.getElementById("msn_duracion_dia").innerHTML = "";}
    }
    
    if (document.getElementById('hh_ini').value =="00" && document.getElementById('mm_ini').value =="00") {
		document.getElementById('msn_hr_inicio').innerHTML = "Ingrese Hora Inicio.";
		document.getElementById('hh_ini').focus();
		return false;
	} else {document.getElementById("msn_hr_inicio").innerHTML = "";}
    
    
    /*##PRECIOS######################################################*/    
    if (document.getElementById('precio_adultojoven').value =="") {
		document.getElementById('msn_padultojoven').innerHTML = "Ingrese Precio Adulto.";
		document.getElementById('precio_adultojoven').focus();
		return false;
	} else {document.getElementById("msn_padultojoven").innerHTML = "";}

    if (document.getElementById('dolar_adultojoven').value =="") {
        document.getElementById('msn_padultojoven').innerHTML = "Ingrese Dolar Adulto.";
        document.getElementById('dolar_adultojoven').focus();
        return false;
    } else {document.getElementById("msn_padultojoven").innerHTML = "";}
    
    if (document.getElementById('dscto_adultojoven').value =="") {
		document.getElementById('msn_padultojoven').innerHTML = "Ingrese % Dscto. Adulto.";
		document.getElementById('dscto_adultojoven').focus();
		return false;
	} else {document.getElementById("msn_padultojoven").innerHTML = "";}
    
    if (document.getElementById('precio_nino').value =="") {
		document.getElementById('msn_pnino').innerHTML = "Ingrese Precio Nino.";
		document.getElementById('precio_nino').focus();
		return false;
	} else {document.getElementById("msn_pnino").innerHTML = "";}

    if (document.getElementById('dolar_nino').value =="") {
        document.getElementById('msn_pnino').innerHTML = "Ingrese Dolar Nino.";
        document.getElementById('dolar_nino').focus();
        return false;
    } else {document.getElementById("msn_pnino").innerHTML = "";}
    
    if (document.getElementById('dscto_nino').value =="") {
		document.getElementById('msn_pnino').innerHTML = "Ingrese % Dscto. Nino.";
		document.getElementById('dscto_nino').focus();
		return false;
	} else {document.getElementById("msn_pnino").innerHTML = "";};
    
    if (document.getElementById('precio_adultomayor').value =="") {
		document.getElementById('msn_padultomayor').innerHTML = "Ingrese Precio Adulto Mayor.";
		document.getElementById('precio_adultomayor').focus();
		return false;
	} else {document.getElementById("msn_padultomayor").innerHTML = "";}

    if (document.getElementById('dolar_adultomayor').value =="") {
        document.getElementById('msn_padultomayor').innerHTML = "Ingrese Dolar Adulto Mayor.";
        document.getElementById('dolar_adultomayor').focus();
        return false;
    } else {document.getElementById("msn_padultomayor").innerHTML = "";}
    
    if (document.getElementById('dscto_adultomayor').value =="") {
		document.getElementById('msn_padultomayor').innerHTML = "Ingrese % Dscto. Adulto Mayor.";
		document.getElementById('dscto_adultomayor').focus();
		return false;
	} else {document.getElementById("msn_padultomayor").innerHTML = "";}
    
    if (document.getElementById('precio_grupo').value =="") {
		document.getElementById('msn_pgrupo').innerHTML = "Ingrese Precio Grupo.";
		document.getElementById('precio_grupo').focus();
		return false;
	} else {document.getElementById("msn_pgrupo").innerHTML = "";}

    if (document.getElementById('dolar_grupo').value =="") {
        document.getElementById('msn_pgrupo').innerHTML = "Ingrese Dolar Grupo.";
        document.getElementById('dolar_grupo').focus();
        return false;
    } else {document.getElementById("msn_pgrupo").innerHTML = "";}
    
    if (document.getElementById('dscto_grupo').value =="") {
		document.getElementById('msn_pgrupo').innerHTML = "Ingrese % Dscto. Grupo.";
		document.getElementById('dscto_grupo').focus();
		return false;
	} else {document.getElementById("msn_pgrupo").innerHTML = "";}   

        if (document.getElementById('grupo').value =="") {
        document.getElementById('msn_grupo').innerHTML = "Ingrese Cantidad Grupo.";
        document.getElementById('grupo').focus();
        return false;
    } else {document.getElementById("msn_grupo").innerHTML = "";}  
    /*###############################################################*/
    
    id_activ        = document.getElementById('id_activ').value;
    rut_empr        = document.getElementById('rut_empr').value;
    nom_activ       = document.getElementById('nom_activ').value;
    id_tipo_activ   = document.getElementById('id_tipo_activ').value;
    descripcion     = document.getElementById('descripcion').value;
    sugerencia      = document.getElementById('sugerencia').value;
    requisito       = document.getElementById('requisito').value;
    dificultad      = document.getElementById('dificultad').value;
    edad_minima     = document.getElementById('edad_minima').value;
    lugar_salida    = document.getElementById('lugar_salida').value;
    id_comuna       = document.getElementById('id_comuna').value;
    
    if (document.getElementById('lun').checked==true){ lun="1";}else{ lun="0"; }
    if (document.getElementById('mar').checked==true){ mar="1";}else{ mar="0"; }
    if (document.getElementById('mie').checked==true){ mie="1";}else{ mie="0"; }
    if (document.getElementById('jue').checked==true){ jue="1";}else{ jue="0"; }
    if (document.getElementById('vie').checked==true){ vie="1";}else{ vie="0"; }
    if (document.getElementById('sab').checked==true){ sab="1";}else{ sab="0"; }
    if (document.getElementById('dom').checked==true){ dom="1";}else{ dom="0"; }
    
    duracion_hr         = document.getElementById('duracion_hh').value+":"+document.getElementById('duracion_mm').value+":"+"00";
    duracion_dia        = document.getElementById('duracion_dia').value;   
    hr_inicio           = document.getElementById('hh_ini').value+":"+document.getElementById('mm_ini').value+":"+"00";
    
    precio_adultojoven  = document.getElementById('precio_adultojoven').value;
    precio_nino         = document.getElementById('precio_nino').value;
    precio_adultomayor  = document.getElementById('precio_adultomayor').value;
    precio_grupo        = document.getElementById('precio_grupo').value;

    dolar_adultojoven   = document.getElementById('dolar_adultojoven').value;
    dolar_nino          = document.getElementById('dolar_nino').value;
    dolar_adultomayor   = document.getElementById('dolar_adultomayor').value;
    dolar_grupo         = document.getElementById('dolar_grupo').value;
    
    dscto_adultojoven   = document.getElementById('dscto_adultojoven').value;
    dscto_nino          = document.getElementById('dscto_nino').value;
    dscto_adultomayor   = document.getElementById('dscto_adultomayor').value;
    dscto_grupo         = document.getElementById('dscto_grupo').value;
    grupo               = document.getElementById('grupo').value;
     
    var ajax=XMLHttp();
    ajax.open("GET","actividad.php?op=2"                    
                                +"&id_activ="+id_activ
                                +"&rut_empr="+rut_empr
                                +"&nom_activ="+nom_activ
                                +"&id_tipo_activ="+id_tipo_activ
                                +"&descripcion="+descripcion
                                +"&sugerencia="+sugerencia
                                +"&requisito="+requisito
                                +"&dificultad="+dificultad
                                +"&edad_minima="+edad_minima
                                +"&lugar_salida="+lugar_salida
                                +"&id_comuna="+id_comuna         
                                +"&lun="+lun
                                +"&mar="+mar
                                +"&mie="+mie
                                +"&jue="+jue
                                +"&vie="+vie
                                +"&sab="+sab
                                +"&dom="+dom
                                +"&duracion_hr="+duracion_hr
                                +"&duracion_dia="+duracion_dia
                                +"&hr_inicio="+hr_inicio                                
                                +"&precio_adultojoven="+precio_adultojoven
                                +"&precio_nino="+precio_nino
                                +"&precio_adultomayor="+precio_adultomayor
                                +"&precio_grupo="+precio_grupo  
                                +"&dolar_adultojoven="+dolar_adultojoven
                                +"&dolar_nino="+dolar_nino
                                +"&dolar_adultomayor="+dolar_adultomayor
                                +"&dolar_grupo="+dolar_grupo                               
                                +"&dscto_adultojoven="+dscto_adultojoven
                                +"&dscto_nino="+dscto_nino
                                +"&dscto_adultomayor="+dscto_adultomayor
                                +"&dscto_grupo="+dscto_grupo
                                +"&grupo="+grupo,true);
                
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////
    ajax.onreadystatechange = function() {
	
		if (ajax.readyState == 4) {
			var respuesta=ajax.responseText;
			document.getElementById('salida').innerHTML=respuesta;
            
            valida_sesion();
            
            if (document.getElementById('eco_grabar').value=="insert_ok"){
                grilla_actividad('grabar');
                document.getElementById('id_activ').value = document.getElementById('eco_id').value;     
                document.getElementById('msn_update').innerHTML = "Esta Actualizando Este Registro.";
                jAlert("Se ha agregado el nuevo registro con exito.","Informacion");
            
            }else if (document.getElementById('eco_grabar').value=="update_ok"){
                grilla_actividad('grabar');
                document.getElementById('msn_update').innerHTML = "Esta Actualizando Este Registro.";
                jAlert("Registro existente se ha actualizado con exito.","Informacion");
            
            }
                
		}}
    ajax.send(null);
    /////////////////////////////////////////////////////////////////////////////
}

function eliminar_actividad(){    
    document.getElementById('msn_id').innerHTML             = "";
    document.getElementById('msn_empresa').innerHTML        = "";
    document.getElementById('msn_nom_activ').innerHTML      = "";
    document.getElementById('msn_tipo_activ').innerHTML     = "";
    document.getElementById('msn_descripcion').innerHTML    = "";
    document.getElementById('msn_sugerencia').innerHTML     = "";
    document.getElementById('msn_requisito').innerHTML      = "";
    document.getElementById('msn_dificultad').innerHTML     = "";
    document.getElementById('msn_edad_min').innerHTML       = "";
    document.getElementById('msn_lugar_sal').innerHTML      = "";
    document.getElementById('msn_comuna').innerHTML         = "";
    document.getElementById('msn_dias').innerHTML           = "";    
    document.getElementById('msn_duracion_hr').innerHTML    = "";
    document.getElementById('msn_duracion_dia').innerHTML   = ""; 
    document.getElementById('msn_hr_inicio').innerHTML      = "";
    document.getElementById('msn_padultojoven').innerHTML   = "";
    document.getElementById('msn_pnino').innerHTML          = "";
    document.getElementById('msn_padultomayor').innerHTML   = "";
    document.getElementById('msn_pgrupo').innerHTML         = "";
    document.getElementById('msn_padultojoven').innerHTML   = "";
    document.getElementById('msn_grupo').innerHTML          = "";

      
    if (document.getElementById('id_activ').value =="" || document.getElementById('nom_activ').value =="") {
        document.getElementById('msn_id').innerHTML = "Seleccione Registro.";
        return false;
    } else {document.getElementById("msn_id").innerHTML = "";}
    
    id_activ    = document.getElementById('id_activ').value;
    nom_activ   = document.getElementById('nom_activ').value;
    
    jConfirm("<table style='font: 12px Arial;'><tr><td colspan='2'>Esta seguro(a) que desea Eliminar el siguiente registro?:<td></tr>"
            +"<tr><td>  &nbsp;&nbsp;&bull;&nbsp;&nbsp; ID Actividad</td>    <td>: "+id_activ+"</td></tr>"
            +"<tr><td>  &nbsp;&nbsp;&bull;&nbsp;&nbsp; Nombre</td>          <td>: "+nom_activ+"</td></tr>"
            +"</table>"
            , "Confirmacion", function(r) {
        if(r) { 
    //jconfirm
    
    var ajax=XMLHttp();
    ajax.open("GET","actividad.php?op=3"
                                    +"&id_activ="+id_activ
                                    +"&nom_activ="+nom_activ,true);
                
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////    
    ajax.onreadystatechange = function() {  
    
        if (ajax.readyState == 4) { 
          
            var respuesta=ajax.responseText;            
            document.getElementById('salida').innerHTML=respuesta;            
            valida_sesion();
        
            if (document.getElementById('eco_eliminar').value=="delete_ok"){
                grilla_actividad('eliminar');                
                jAlert("Se ha eliminado el registro con exito.","Informacion");
                
                document.getElementById('id_activ').value       = ""; 
                document.getElementById('msn_update').innerHTML = "";
                
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

function grilla_actividad(accion){
    document.getElementById('msn_id').innerHTML             = "";
    document.getElementById('msn_empresa').innerHTML        = "";
    document.getElementById('msn_nom_activ').innerHTML      = "";
    document.getElementById('msn_tipo_activ').innerHTML     = "";
    document.getElementById('msn_descripcion').innerHTML    = "";
    document.getElementById('msn_sugerencia').innerHTML     = "";
    document.getElementById('msn_requisito').innerHTML      = "";
    document.getElementById('msn_dificultad').innerHTML     = "";
    document.getElementById('msn_edad_min').innerHTML       = "";
    document.getElementById('msn_lugar_sal').innerHTML      = "";
    document.getElementById('msn_comuna').innerHTML         = "";
    document.getElementById('msn_dias').innerHTML           = "";  
    document.getElementById('msn_duracion_hr').innerHTML    = "";
    document.getElementById('msn_duracion_dia').innerHTML   = ""; 
    document.getElementById('msn_hr_inicio').innerHTML      = "";
    document.getElementById('msn_padultojoven').innerHTML        = "";
    document.getElementById('msn_pnino').innerHTML          = "";
    document.getElementById('msn_padultomayor').innerHTML   = "";
    document.getElementById('msn_pgrupo').innerHTML         = "";
    document.getElementById('msn_grupo').innerHTML          = "";  
    
    var ajax=XMLHttp();
    
    if (accion=="buscar"){
        id_activ        = document.getElementById('id_activ').value;
        rut_empr        = document.getElementById('rut_empr').value;
        nom_activ       = document.getElementById('nom_activ').value;
        id_tipo_activ   = document.getElementById('id_tipo_activ').value;
        descripcion     = document.getElementById('descripcion').value;
        sugerencia      = document.getElementById('sugerencia').value;
        requisito       = document.getElementById('requisito').value;
        dificultad      = document.getElementById('dificultad').value;
        edad_minima     = document.getElementById('edad_minima').value;
        lugar_salida    = document.getElementById('lugar_salida').value;
        id_comuna       = document.getElementById('id_comuna').value;       
       
        ajax.open("GET","actividad.php?op=4"
                                    +"&id_activ="+id_activ
                                    +"&rut_empr="+rut_empr
                                    +"&nom_activ="+nom_activ
                                    +"&id_tipo_activ="+id_tipo_activ
                                    +"&descripcion="+descripcion
                                    +"&sugerencia="+sugerencia
                                    +"&requisito="+requisito
                                    +"&dificultad="+dificultad
                                    +"&edad_minima="+edad_minima
                                    +"&lugar_salida="+lugar_salida
                                    +"&id_comuna="+id_comuna
                                    +"&accion="+accion,true);
        
    }else{
        ajax.open("GET","actividad.php?op=4&accion="+accion,true);
    }
                
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    /////////////////////////////////////////////////////////////////////////////
    ajax.onreadystatechange = function() {
		if (ajax.readyState == 4) { 
			var respuesta=ajax.responseText;
			document.getElementById('grilla_actividad').innerHTML=respuesta;
            valida_sesion();
            
      	}}
    ajax.send(null);
    /////////////////////////////////////////////////////////////////////////////
}
/*###################################################*/
function go_hrs_activ(id_activ){
    parametros_popup();
    popup_hrs_activ = window.open("actividad_horario.php?op=1&id_activ="+id_activ,"popup_hrs_activ", param_popup);
    popup_hrs_activ.focus();
}

function go_arch_activ(id_activ){
    parametros_popup();
    popup_arch_activ = window.open("actividad_archivo.php?op=1&id_activ="+id_activ,"popup_arch_activ", param_popup);
    popup_arch_activ.focus();
}

/*###################################################*/

function copy_grilla_actividad() {    
    div_grilla=document.getElementById('grilla_actividad');
    
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