<?php
session_start();

if(isset($_SESSION['log_email'])){
    unset($_SESSION['log_email']);
}

if(isset($_SESSION['log_nombre'])){
    unset($_SESSION['log_nombre']);
}

if(isset($_SESSION['arr_tmp_compra_detalle'])){
    unset($_SESSION['arr_tmp_compra_detalle']);
}

if(isset($_SESSION['arr_compra_cabecera_ok'])){
    unset($_SESSION['arr_compra_cabecera_ok']);
}    

if(isset($_SESSION['arr_compra_detalle_ok'])){
    unset($_SESSION['arr_compra_detalle_ok']);
}

?>

<script>  
    if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
        window.location="portal/index2.php?op=2"; 
    }else{
        window.location="portal/index2.php?op=1&w="+screen.width+"&h="+screen.height;
    }
</script>