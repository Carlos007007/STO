/*
	Copyright: Carlos Alfaro

	++ Redes Sociales ++
	YouTube: https://www.youtube.com/c/CarlosAlfaro007
	Facebook: https://www.facebook.com/CarlosAlfaroES/
	Email: carlosalfaro.info@gmail.com
*/

const formularios_ajax = document.querySelectorAll(".FormularioAjax");

/*----------  Funcion enviar formularios ajax - Send ajax forms function ----------*/
function enviar_formulario_ajax(e){
	e.preventDefault();

	let data = new FormData(this);
	let method = this.getAttribute("method");
	let action = this.getAttribute("action");
	let tipo = this.getAttribute("data-form");
	let lang = this.getAttribute("data-lang");

	let encabezados = new Headers();

	let config = { 
		method: method,
       	headers: encabezados,
       	mode: 'cors',
       	cache: 'no-cache',
       	body: data
    };

	let texto_alerta;

    if(tipo==="save"){
		if(lang==="es"){
			texto_alerta="Los datos serán guardados en el sistema";
		}else{
			texto_alerta="The data will be saved in the system";
		}
    }else if(tipo==="delete"){
		if(lang==="es"){
			texto_alerta="Los datos serán eliminados completamente del sistema";
		}else{
			texto_alerta="The data will be completely removed from the system";
		}
    }else if(tipo==="update"){
		if(lang==="es"){
			texto_alerta="Los datos serán actualizados en el sistema";
		}else{
			texto_alerta="The data will be updated in the system";
		}
    }else if(tipo==="search"){
		if(lang==="es"){
			texto_alerta="Se eliminará el término de búsqueda y tendrás que escribir uno nuevamente";
		}else{
			texto_alerta="The search term will be removed and you will have to type one again";
		}
	}else{
		if(lang==="es"){
			texto_alerta="Quieres realizar la operación solicitada";
		}else{
			texto_alerta="You want to perform the requested operation";
		}
	}
	
	let titulo_alerta;
	let btn_confirm_alerta;
	let btn_cancel_alerta;

	if(lang==="es"){
		titulo_alerta="¿Estás seguro?";
		btn_confirm_alerta="Aceptar";
		btn_cancel_alerta="Cancelar";
	}else{
		titulo_alerta="Are you sure?";
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

			fetch(action,config)
	        .then(respuesta => respuesta.json())
	        .then(respuesta =>{
				return alertas_ajax(respuesta);
			});	
	
		}
	});



}


/*----------  Funcion listar formularios - List forms function ----------*/
formularios_ajax.forEach(formularios => {
	formularios.addEventListener("submit", enviar_formulario_ajax);
});


/*----------  Funcion mostrar alertas - Show alerts function ----------*/
function alertas_ajax(alerta){
	if(alerta.Alerta==="simple"){
		Swal.fire({
		  title: alerta.Titulo,
		  text: alerta.Texto,
		  icon: alerta.Icon,
		  confirmButtonText: alerta.TxtBtn
		});
	}else if(alerta.Alerta==="recargar"){
		Swal.fire({
		  title: alerta.Titulo,
		  text: alerta.Texto,
		  icon: alerta.Icon,
		  confirmButtonText: alerta.TxtBtn
		}).then((result)=>{
			if(result.value) {
				location.reload();
			}
		});
	}else if(alerta.Alerta==="limpiar"){
		Swal.fire({
		  title: alerta.Titulo,
		  text: alerta.Texto,
		  icon: alerta.Icon,
		  confirmButtonText: alerta.TxtBtn
		}).then((result)=>{
			if(result.value) {
				document.querySelector(".FormularioAjax").reset();
			}
		});
	}else if(alerta.Alerta==="venta"){
		Swal.fire({
			title: alerta.Titulo,
			text: alerta.Texto,
			icon: alerta.Icon,
			confirmButtonText: alerta.TxtBtn
		}).then((result)=>{
			if(result.value) {
				document.querySelector('#sale-barcode-input').value="";
			}
		});
	}else if(alerta.Alerta==="redireccionar"){
		window.location.href=alerta.URL;
	}
}