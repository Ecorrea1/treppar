<?php
session_start();
?>

<html> 
<head>
    <title>Turismo</title>
    <link href="app/img/icon_web.png" type="image/x-icon" rel="shortcut icon"/>
    <script src="app/func/validaciones.js" type="text/javascript"></script>
    
    
    <script language="JavaScript" type="text/JavaScript">
       
         function valida_formulario( ){           
            document.getElementById("msn_rut").innerHTML = ""
            document.getElementById("msn_clave").innerHTML = ""
           
        	if (document.getElementById('rut').value == "") {
        		document.getElementById('msn_rut').innerHTML = "Rut no es valido.";
        		document.getElementById('rut').focus();            
        		return false;
    	   }else{document.getElementById("msn_rut").innerHTML = "";}
           
          	if (document.getElementById('clave').value == "") {
        		document.getElementById('msn_clave').innerHTML = "Ingrese Clave.";
        		document.getElementById('clave').focus();             
        		return false;
           }else{document.getElementById("msn_clave").innerHTML = "";}    
         }
    
    </script>
    
    <style>        
        
        .titulo1 {
            font: bold 20px Arial;
            color: #045FB4;            
            text-decoration:none;
            text-shadow: -1px 0 #fff, 0 1px #fff, 1px 0 #fff, 0 -1px #fff;
            /*text-shadow: 3px 3px #045FB4;*/            
        }
        
        .titulo2 {
            font: bold 16px Arial;
            color: #ffffff;
            background-color: #045FB4;
            border-width: 0px;
            height: 35px;
            
            /*para centrar vertical texto dentro del div*/
            display: flex;
            
            /*horizontal*/
            justify-content: center;
            
            /*vertical*/
            align-items: center;
        }
        
        .usuario {
            font: 17px Arial;
            color: #fff;            
            text-decoration:none;
            text-shadow: -2px 0 #045FB4, 0 2px #045FB4, 2px 0 #045FB4, 0 -2px #045FB4;
        }
        
        .usuario:hover {
            font: 17px Arial;
            color: #F7D358;            
            text-decoration: none;
            text-shadow: -2px 0 #045FB4, 0 2px #045FB4, 2px 0 #045FB4, 0 -2px #045FB4;
        }
        
        .login_err {
            font: 17px Arial;
            color: #FACC2E;
            background-color: #045FB4;
            border-width: 0px;
            height: 35px;
            
            /*para centrar vertical texto dentro del div*/
            display: flex;
            
            /*horizontal*/
            justify-content: center;
            
            /*vertical*/
            align-items: center;
        }

        .tabla {            
            border:5px solid #045FB4;
            border-radius:30px;
        }
        
        .etq {        
            font: 17px Arial;
            color:#045FB4; /*azul*/
        }
    
        .txt{
            font: 17px Arial;
            color:#000000;
            border:1px solid #a4a4a4;
            border-radius:10px;
            text-align: center;
            width: 80%;
            height: 40px;
        }
        
        .bt{
            font: bold 17px Arial;
            color:#ffffff;
            background-color:#045FB4;
            border:1px solid #ffffff;
            border-radius:10px;
            text-align: center;
            width: 80%;
            height: 40px;
        }
        
        .msn_err {
            font: 17px Arial;
            color: #DF0101;/*rojo*/
        }
        
    </style>
</head>
    
    
<?php
    
    echo '
    <body bgcolor="#fff">    
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-image:url(app/img/cabecera_degrade.png);background-repeat:repeat-x;">                  
    <tr height="125px">
        <td width="25%" align="center"> <img src="app/img/logo_sist1.png" border="0" align="center"/> </td>
        <td width="50%" align="center" class="titulo1">PORTAL<br/>OPERADORES TURISTICOS</td>
        <td width="25%" align="center">
            <img src="app/img/icono_usuario.png" width="50px"><br/>            
            <a href="app/registro_empresa.php?op=20" class="usuario">Crear Cuenta <br/> Olvide Mi Clave</a>
        </td>            
    </tr>
    </table>    
      
    <div class="titulo2">
            <center>';
            $eco_sesion=isset($_GET['eco'])?$_GET['eco']:null;
                                      	
            if ($eco_sesion=="err"){ 
                echo '<label id="titulo" class="login_err">Sesi&oacute;n no v&aacute;lida!</label>';
           	}else{
          		echo '<label id="titulo" class="titulo">Inicio de Sesi&oacute;n</label>';       
           	} echo '
            </center> 
    </div>
       
    <form name="form1" action="valida_usuario.php" method="POST" onsubmit="return valida_formulario()">
    
    <br/><br/>
    <table width="40%" border="0" cellspacing="0" cellpadding="0" class="tabla" align="center">
    
    <tr height="80px">
        <td valign="center" align="center" class="etq">Rut Usuario:<br/>
            <input type="text" id="rut" name="rut" maxlength="12" class="txt" placeholder="Ej: 11111111-1" onblur="javascript:valida_rut('."this,'msn_rut'".');"/>
            <br><label id="msn_rut" class="msn_err"></label>
        </td>
    </tr>
    
    <tr><td><hr size="2" color="#045FB4"></td></tr>
    
    <tr height="80px">
        <td valign="center" align="center" class="etq">Clave Usuario:<br/>
            <input type="password" id="clave" name="clave" maxlength="6" class="txt" onblur="javascript:valida_alfanum(this);"/>
            <br><label id="msn_clave" class="msn_err"></label>
        </td>
    </tr>
    
    <tr><td><hr size="2" color="#045FB4"></td></tr>
    
    <tr height="80px">
        <td valign="center" align="center"><input name="Submit" type="Submit" value="Entrar" class="bt"/></td>
    </tr>
    </table>
    </form>';
   ?>
   
   <?php   
       if ($eco_sesion=="x"){        
            if(isset($_SESSION['log_rut'])){
                unset($_SESSION['log_rut']);
            }
            
            if(isset($_SESSION['log_nom'])){
                unset($_SESSION['log_nom']);
            }
            
            if(isset($_SESSION['log_tipo'])){
                unset($_SESSION['log_tipo']);
            }
        
            echo '<script>javascript:alert ("Se ha cerrado su sesion.")</script>';
        }
   ?>

</body> 
</html> 
