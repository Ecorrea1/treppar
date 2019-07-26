function valida_sesion(popup){
    if (document.getElementById('sesion')){
        if (popup=="popup"){
            opener.document.getElementById('form_home').bt_logout.onclick();
            window.close();
        }else{
            if (document.getElementById('sesion').value=="err"){
                location.href="../index.php?eco=x";
            }
        }
    }
}

function parametros_popup(){
    XWidth      = (window.innerWidth-40);
    XLeft       = (window.screenX+20);
    YHeight     = (screen.height-300);
    YTop        = 150;
    param_popup = "width="+(XWidth)+",height="+YHeight+",left="+XLeft+",top="+YTop+",resizable=no,scrollbars=yes";
}

function valida_rut(objeto_rut, objeto_error){ 
    
    if (!/^[0-9]+-[0-9kK]{1}$/.test(objeto_rut.value)){ // valida formato 11111111-1
        document.getElementById(objeto_error).innerHTML ="Rut no valido.";
        objeto_rut.value="";
        objeto_rut.focus();
    
    }else{
    
        var tmpstr = "";
    	var intlargo = objeto_rut.value
        document.getElementById(objeto_error).innerHTML ="";
    	if (intlargo.length> 0)
    	{
    		crut = objeto_rut.value
    		largo = crut.length;
    		if ( largo <2 )
    		{
                document.getElementById(objeto_error).innerHTML ="Rut no es valido.";
    			//alert('Rut no es valido')
    			objeto_rut.value="";
    			objeto_rut.focus();
    			return false;
    		}
    		for ( i=0; i <crut.length ; i++ )
    		
    		//if ( crut.charAt(i) != ' ' && crut.charAt(i) != '.' && crut.charAt(i) != '-' )
    		if ( crut.charAt(i) != ' ' && crut.charAt(i) != '-' )
    		{
    			tmpstr = tmpstr + crut.charAt(i);
    		}
    		
    		rut = tmpstr;
    		crut=tmpstr;
    		largo = crut.length;
    	
    		if ( largo> 2 )
    			rut = crut.substring(0, largo - 1);
    		else
    			rut = crut.charAt(0);
    	
    		dv = crut.charAt(largo-1);
    	
    		if ( rut == null || dv == null )
    		return 0;
    	
    		var dvr = '0';
    		suma = 0;
    		mul  = 2;
    	
    		for (i= rut.length-1 ; i>= 0; i--)
    		{
    			suma = suma + rut.charAt(i) * mul;
    			if (mul == 7)
    				mul = 2;
    			else
    				mul++;
    		}
    	
    		res = suma % 11;
    		if (res==1)
    			dvr = 'k';
    		else if (res==0)
    			dvr = '0';
    		else
    		{
    			dvi = 11-res;
    			dvr = dvi + "";
    		}
    	
    		if ( dvr != dv.toLowerCase() )
    		{
    			document.getElementById(objeto_error).innerHTML ="Rut no es valido.";
                //alert('Rut no es valido')
    			objeto_rut.value="";
    			objeto_rut.focus();
    			return false;
    		}
    		//alert('El Rut Ingresado es Correcto!')
    		//objeto_rut.focus()
    		return true;        
    	} 
    }     
}

function valida_alfanum(objeto){
    txt_entra   = objeto.value;    
    //txt_sale = txt_entra.replace(/[^a-z0-9]/gi, '');
    txt_sale = txt_entra.replace(/#/gi," ");
    objeto.value= txt_sale;
    
    /*
    txt_entra   = objeto.value; 
        
    txt_sale    = txt_entra.replace(/[^abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890=+,.()]+/g,' ');
    
    if (txt_entra!=txt_sale){
       jAlert("Se quitaron caracteres no validos.<br/>"
                            +"<label style='color:red;'>"                            
                            +"&nbsp;-&nbsp; ! # $ % & / ? * [ ] { } _-;  ...<br/>"
                            +"&nbsp;-&nbsp; Caracteres con acento." 
                            +"</label>"
                            ,"Validacion"); 
    }
    
    objeto.value= txt_sale;
    */
}

function esNumero(e) {
	var charCode
	if (navigator.appName == "Netscape"){ // Veo si es Netscape o Explorer (mas adelante lo explicamos)
		charCode = e.which // leo la tecla que ingreso
	}else{
		charCode = e.keyCode // leo la tecla que ingreso
		status = charCode
    }
	if (charCode > 31 && (charCode < 48 || charCode > 57)) { 
		return false
	}
	
	return true;
    
    
     /*
        if (isNaN(objeto_numero.value)) {
            alert("No es numero");            
        }else{
            alert("Es numero");
        }
    */
}

function valida_mail (objeto_tx){   
    if (objeto_tx.value!=""){    
        txvalor=objeto_tx.value;
        var vmail =/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;        
        			
        if(!(vmail.test(txvalor))){
            alert("Email no es valido\n Ej: mimail@hotmail.com");            
            objeto_tx.value="";
            objeto_tx.focus();            
			return false;                
        }
    }      		
}