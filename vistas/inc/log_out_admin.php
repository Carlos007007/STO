<script>
	function cerrar_sesion_administrador(){
        let titulo_alerta;
        let btn_confirm_alerta;
        let btn_cancel_alerta;
        let texto_alerta;
        let lang="<?php echo LANG; ?>";
    
        if(lang==="es"){
            titulo_alerta="¿Quieres salir del sistema?";
            texto_alerta="Se cerrará la sesión y regresaras a la página principal";
            btn_confirm_alerta="Aceptar";
            btn_cancel_alerta="Cancelar";
        }else{
            titulo_alerta="Do you want to log out?";
            texto_alerta="The session will be closed and you will return to the main page";
            btn_confirm_alerta="Agree";
            btn_cancel_alerta="Cancel";
        }
        
        Swal.fire({
            title: titulo_alerta,
            text: texto_alerta,
            icon: 'question',
            showCancelButton: true,
            showDenyButton: false,
            showConfirmButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: btn_confirm_alerta,
            cancelButtonText: btn_cancel_alerta
        }).then((result) => {
            if(result.isConfirmed){
    
                let datos = new FormData();
                datos.append("token","<?php echo $ins_login->encryption($_SESSION['token_sto']); ?>");
                datos.append("usuario","<?php echo $ins_login->encryption($_SESSION['usuario_sto']); ?>");
                datos.append("modulo_login","logout_administrador");
    
                fetch("<?php echo SERVERURL; ?>ajax/loginAjax.php",{
                    method: 'POST',
                    body: datos
                })
                .then(respuesta => respuesta.json())
                .then(respuesta =>{
                     return alertas_ajax(respuesta);
                });
        
            }
        });
    }
</script>