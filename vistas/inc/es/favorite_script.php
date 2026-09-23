<script type="text/javascript">

	function add_favorite(accion,prod_id,client_id,button_id){

		let titulo_alerta;
		let texto_alerta;
		let btn_confirm_alerta;

		if(accion=="Add"){
			titulo_alerta="¿Agregar a favoritos?";
			texto_alerta="Desea agregar este producto a favoritos";
			btn_confirm_alerta="Si, agregar";
		}else{
			titulo_alerta="¿Quitar de favoritos?";
			texto_alerta="Desea quitar este producto de favoritos";
			btn_confirm_alerta="Si, quitar";
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
			cancelButtonText: 'Cancelar'
		}).then((result) => {
			if(result.isConfirmed){

				let datos = new FormData();
		        datos.append("producto_id", prod_id);
		        datos.append("cliente_id", client_id);
		        datos.append("accion", accion);
		        datos.append("modulo_carrito", "favoritos");

		        fetch('<?php echo SERVERURL; ?>ajax/carritoAjax.php',{
		            method: 'POST',
		            body: datos
		        })
		        .then(respuesta => respuesta.json())
		        .then(respuesta =>{

		        	if(respuesta.Icon=="success"){

		        		const boton=document.querySelector('#'+button_id);

		        		if(accion=="Add"){
		        			boton.innerHTML='<i class="fas fa-heart fa-fw" ></i> &nbsp; Quitar';
		        			boton.setAttribute("onclick", "add_favorite('Delete',"+prod_id+","+client_id+",'"+button_id+"')");
						}else if(accion=="Delete"){
							boton.innerHTML='<i class="far fa-heart fa-fw" ></i> &nbsp; Agregar';
							boton.setAttribute("onclick", "add_favorite('Add',"+prod_id+","+client_id+",'"+button_id+"')");
						}

		        	}

		            return alertas_ajax(respuesta);
		        });	
		
			}
		});

	}

</script>