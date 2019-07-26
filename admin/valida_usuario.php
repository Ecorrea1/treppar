<?php
session_start();

$rut    = isset($_POST['rut'])?$_POST['rut']:null;
$clave  = isset($_POST['clave'])?$_POST['clave']:null;

if ($rut!="" AND $clave!=""){
    require_once ("app/func/cnx.php"); //requiere_once (si ya se cargo funcion no la vuelve a cargar)    
    $cnx=conexion();
    date_default_timezone_set("Chile/Continental");
      
    $rut    = guardian($rut);    
    $clave  = guardian(sha1($clave)); //funcion sha1 permite encriptar la clave
    
    $sql="SELECT * FROM man_usuario WHERE rut='".$rut."' AND clave='".$clave."' AND estado='1'";                    
    $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());     
     
    IF (mysql_num_rows($run_sql)){                        
        while($row=mysql_fetch_array($run_sql)){  
            $_SESSION['log_rut']    = $row['rut'];
            $_SESSION['log_nom']    = $row['nombre'];
            $_SESSION['log_tipo']   = $row['tipo_usu'];
        }
        
        $sql2 = "INSERT INTO reg_login_usuario(";
            $sql2.= "rut,";    
            $sql2.= "nombre,";
            $sql2.= "ip,";
            $sql2.= "login,";
            $sql2.= "fecha_reg";
		$sql2.= ") VALUES (";
            $sql2.="'".utf8_decode($_SESSION['log_rut'])."',";
            $sql2.="'".utf8_decode($_SESSION['log_nom'])."',";       
            $sql2.="'".$_SERVER['REMOTE_ADDR']."',";
            $sql2.="'In',";
            $sql2.="'".date('Y-m-d H:i:s')."')";                
        $run_sql2=mysql_query($sql2) or die ('ErrorSql > ' . mysql_error ());
        
        //Sesion OK                
        header('Location: app/home.php',true);

    }ELSE{
        
        $_SESSION['log_rut']    = "";
        $_SESSION['log_nom']    = "";
        $_SESSION['log_tipo']   = "";
        
        $sql="SELECT * FROM man_usuario WHERE rut='".$rut."'";                    
        $run_sql=mysql_query($sql) or die ('ErrorSql > '.mysql_error ());
        
        if (mysql_num_rows($run_sql)){
            while($row=mysql_fetch_array($run_sql)){                
                $nombre = $row['nombre'];        
            }
        }else{
            $nombre = "";
        }
        
        $sql2 = "INSERT INTO reg_login_usuario(";
            $sql2.= "rut,";
            $sql2.= "nombre,";
            $sql2.= "ip,";
            $sql2.= "login,";
            $sql2.= "fecha_reg";
		$sql2.= ") VALUES (";
            $sql2.="'".utf8_decode($rut)."',";
            $sql2.="'".utf8_decode($nombre)."',";
            $sql2.="'".$_SERVER['REMOTE_ADDR']."',";
            $sql2.="'Out',";
            $sql2.="'".date('Y-m-d H:i:s')."')";    
        $run_sql2=mysql_query($sql2) or die ('ErrorSql > ' . mysql_error ());
    
        //Sesion no es valida retorna a portada
        header('Location: index.php?eco=err',true);
    }
    
///////////////////////////////////////////////////   
}else{
    //Sesion no es valida retorna a portada
   header('Location: index.php?eco=err',true); 
}
?>