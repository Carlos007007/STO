<?php
    include "./vistas/inc/admin_security.php";
?>

<div class="full-box page-header">
    <h3 class="text-start roboto-condensed-regular text-uppercase">
        <i class="fas fa-hand-holding-usd fa-fw"></i> &nbsp; Reporte general de ventas
    </h3>
</div>

<!-- <div class="container-fluid">
    <ul class="nav nav-tabs nav-justified mb-4" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" href="<?php echo SERVERURL.DASHBOARD; ?>/report-sales/" ><i class="fas fa-hand-holding-usd fa-fw"></i> &nbsp; Reporte general de ventas</a>
        </li>
    </ul>
</div> -->

<div class="container-fluid">
    <div class="dashboard-container">
        <div class="container-fluid">
            <h4 class="text-center">Generar reporte personalizado</h4>
            <div class="form-neon">
                <div class="container-fluid">
                    <div class="row justify-content-md-center">
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="fecha_inicio" >Fecha inicial (día/mes/año)</label>
                                <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" maxlength="30">
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="fecha_final" >Fecha final (día/mes/año)</label>
                                <input type="date" class="form-control" name="fecha_final" id="fecha_final" maxlength="30">
                            </div>
                        </div>
                        <div class="col-12">
                            <p class="text-center" style="margin-top: 40px;">
                                <button type="button" class="btn btn-raised btn-info" onclick="generar_reporte()" ><i class="far fa-file-pdf"></i> &nbsp; GENERAR REPORTE</button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function generar_reporte(){
        Swal.fire({
            title: '¿Quieres generar el reporte?',
            text: "La generación del reporte PDF puede tardar unos minutos para completarse",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, generar',
            cancelButtonText: 'No, cancelar'
        }).then((result) => {
            if(result.value){
                let fecha_inicio=document.querySelector('#fecha_inicio').value;
                let fecha_final=document.querySelector('#fecha_final').value;

                fecha_inicio.trim();
                fecha_final.trim();

                if(fecha_inicio!="" && fecha_final!=""){
                    url="<?php echo SERVERURL; ?>pdf/report-sales.php?fi="+fecha_inicio+"&&ff="+fecha_final;
                    window.open(url,'Imprimir reporte de ventas','width=820,height=720,top=0,left=100,menubar=NO,toolbar=YES');
                }else{
                    Swal.fire({
                        title: 'Ocurrió un error inesperado',
                        text: 'Debe de ingresar la fecha de inicio y final para generar el reporte.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            }
        });
    }
</script>