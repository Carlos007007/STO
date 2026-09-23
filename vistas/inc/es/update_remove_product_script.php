<script>

	/* Remover producto - Remove product */
    function remover_producto(id){

        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Desea remover este producto del carrito',
            icon: 'question',
            showCancelButton: true,
            showDenyButton: false,
            showConfirmButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        }).then((result)=>{
            if(result.value){
                let datos = new FormData();
                datos.append("producto_id", id);
                datos.append("modulo_carrito", "remover");

                fetch('<?php echo SERVERURL; ?>ajax/carritoAjax.php',{
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

    /* Actualizar producto - Update product */
    function actualizar_cantidad(id,codigo,url){
        let cantidad=document.querySelector(id).value;

        cantidad=cantidad.trim();
        codigo.trim();

        if(cantidad>0){

            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Desea actualizar la cantidad de productos',
                icon: 'question',
                showCancelButton: true,
                showDenyButton: false,
                showConfirmButton: true,
                cancelButtonText: 'No, cancelar',
                confirmButtonText: 'Si, actualizar',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result)=>{
                if(result.value){

                    let datos = new FormData();
                    datos.append("producto_codigo", codigo);
                    datos.append("producto_id", id);
                    datos.append("producto_cantidad", cantidad);
                    datos.append("view_url", url);
                    datos.append("modulo_carrito", "actualizar");

                    fetch('<?php echo SERVERURL; ?>ajax/carritoAjax.php',{
                        method: 'POST',
                        body: datos
                    })
                    .then(respuesta => respuesta.json())
                    .then(respuesta =>{
                        return alertas_ajax(respuesta);
                    });
                }
            });
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Ocurrió un error inesperado',
                text: 'Debes de introducir una cantidad mayor a 0',
                confirmButtonText: 'Aceptar'
            });
        }
    }
</script>