<?php 
        function guardian($cadena) {
            $cadena = utf8_decode($cadena);
            
            //str_replace -> distingue mayuscula y minuscula
            //str_replace -> NO distingue mayuscula y minuscula
            
            /*
            $cadena = str_replace(
                array("\\", "¨", "°", "ª", "~", "*", "#", "@", "|", "!", "\"","·", "$", "%", "&", "/", "?", "'",
                    "¡", "¿", "[", "^", "<code>", "]", "+", "}", "{", "¨", "´", ">", "< ", ";", ",", ":"),                 
                     ' ',
                $cadena
            );
            */
            
            $cadena = str_ireplace("n°","Nro",$cadena);
            $cadena = str_ireplace("nº","Nro",$cadena);
            $cadena = str_ireplace("n&deg;","Nro",$cadena);
            $cadena = str_ireplace("n&ordm;","Nro",$cadena);
            
            //Expresiones SQL
            $cadena = str_ireplace("insert"," ",$cadena);
            $cadena = str_ireplace("update"," ",$cadena);
            $cadena = str_ireplace("delete"," ",$cadena);
            $cadena = str_ireplace("select"," ",$cadena);
            $cadena = str_ireplace("join"," ",$cadena);
            $cadena = str_ireplace("where"," ",$cadena);
            $cadena = str_ireplace("from"," ",$cadena);
            
            
            $cadena = strip_tags($cadena); // Retira las etiquetas HTML y PHP de un string ej: <br> = vacio
            $cadena = mysql_real_escape_string($cadena);//Escapa caracteres especiales en una cadena para ser usado en una sentencia SQL
            
            ##Esta sentencia da problemas al grabar las Ñ ##################################
            ##$cadena   = htmlentities($cadena, ENT_QUOTES);//Todos los caracteres que tienen equivalente HTML son convertidos a esas entidades. ej:<br> = &lt;br&gt;             
            ################################################################################
            
            $cadena = trim($cadena);
            
            //$cadena = strtoupper($cadena);//pasar a mayuscula            
            //$cadena = strtolower($cadena);//pasar a minusculas                       
            //$cadena = ucwords(strtolower($cadena));//pasar a mayusculas solo la primera letra de cada palabra
            
            return $cadena;         
        }
        
        function guardian2($cadena){
            $cadena = utf8_decode($cadena);
            
            $cadena = str_replace(
                array("\\", "¨", "°", "ª", "~", "*", "#", "@", "|", "!", "\"","·", "$", "%", "&", "/", "?", "'", 
                    "¡", "¿", "[", "^", "<code>", "]", "+", "}", "{", "¨", "´", ">", "< ", ";", ",", ":"),                     
                     ' ',
                $cadena
            );  
            
            $cadena = str_replace(
                array("á", "à", "ä", "â", "ª", "Á", "À", "Â", "Ä"),
                array("a", "a", "a", "a", "a", "A", "A", "A", "A"),
                $cadena
            );
         
            $cadena = str_replace(
                array("é", "è", "ë", "ê", "É", "È", "Ê", "Ë"),
                array("e", "e", "e", "e", "E", "E", "E", "E"),
                $cadena
            );
         
            $cadena = str_replace(
                array("í", "ì", "ï", "î", "Í", "Ì", "Ï", "Î"),
                array("i", "i", "i", "i", "I", "I", "I", "I"),
                $cadena
            );
         
            $cadena = str_replace(
                array("ó", "ò", "ö", "ô", "Ó", "Ò", "Ö", "Ô"),
                array("o", "o", "o", "o", "O", "O", "O", "O"),
                $cadena
            );
         
            $cadena = str_replace(
                array("ú", "ù", "ü", "û", "Ú", "Ù", "Û", "Ü"),
                array("u", "u", "u", "u", "U", "U", "U", "U"),
                $cadena
            );
         
            $cadena = str_replace(
                array("ñ", "Ñ", "ç", "Ç"),
                array("n", "N", "c", "C",),
                $cadena
            );            
            
            //Expresiones SQL
            $cadena = str_ireplace("insert"," ",$cadena);
            $cadena = str_ireplace("update"," ",$cadena);
            $cadena = str_ireplace("delete"," ",$cadena);
            $cadena = str_ireplace("select"," ",$cadena);
            $cadena = str_ireplace("join"," ",$cadena);
            $cadena = str_ireplace("where"," ",$cadena);
            $cadena = str_ireplace("from"," ",$cadena);
            
            $cadena = strip_tags($cadena); // Retira las etiquetas HTML y PHP de un string ej: <br> = vacio
            $cadena = mysql_real_escape_string($cadena);//Escapa caracteres especiales en una cadena para ser usado en una sentencia SQL
            
            $cadena = trim($cadena);
            
            return $cadena;
        }
        
        function conexion(){
            
            $servidor   = "localhost";//***nombre del servidor
            $bd         = "turismo3_trepar2";//***nombre bd
            $usuario    = "turismo3_trepar2";//***usuario bd
            $clave      = "Yvb2U833ld";//***clave bd
            
            
        	if (!($cnx_bd=mysql_connect($servidor,$usuario,$clave))){
        		echo '<label style="color:red;"><center>No se pudo establecer conexion con el Servidor, comuniquese con soporte.</center><label>';
        		exit();
        	}        	
            
            if (!(mysql_select_db($bd,$cnx_bd))){ // consulta si existe la bd seleccionada	
        		echo '<label style="color:red;"><center>Base de Datos no encontrada, comuniquese con soporte.</center><label>';
        		exit();
        	}
            
            /*
                mysql_query ("SET character_set_client = 'UTF8'");
                mysql_query ("SET character_set_results = 'UTF8'");
                mysql_query ("SET character_set_connection = 'UTF8'");
            
                mysql_query (""SET NAMES 'UTF8'""); //Con este tenemos los 3 en uno
            */
                  
          
            mysql_query ("SET character_set_results = 'UTF8'"); //Para ver las ñ y acentos
           
            return $cnx_bd; 
       }
?>