<?php

    require_once __DIR__."/../modelos/mainModel.php";

	class cajaControlador extends mainModel{

        /*--------- Controlador registrar caja - Controller register cash register ---------*/
        public function registrar_caja_controlador(){

            /*-- Comprobando privilegios - Checking privileges --*/
            if($_SESSION['cargo_sto']!="Administrador"){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Acceso no permitido",
                    "Texto"=>"No tienes los permisos necesarios para realizar esta operación en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-- Recibiendo datos del formulario - Receiving form data --*/
            $numero=mainModel::limpiar_cadena($_POST['caja_numero_reg']);
            $nombre=mainModel::limpiar_cadena($_POST['caja_nombre_reg']);
            $estado=mainModel::limpiar_cadena($_POST['caja_estado_reg']);
            $efectivo=mainModel::limpiar_cadena($_POST['caja_efectivo_reg']);

            /*-- Comprobando campos vacios - Checking empty fields --*/
            if($numero=="" || $nombre=="" || $estado=="" || $efectivo==""){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No has llenado todos los campos que son obligatorios",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-- Verificando integridad de los datos - Checking data integrity --*/
            if(mainModel::verificar_datos("[0-9]{1,5}",$numero)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Formato no valido",
                    "Texto"=>"El NUMERO no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ:# ]{3,70}",$nombre)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Formato no valido",
                    "Texto"=>"El NOMBRE no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[0-9.]{1,25}",$efectivo)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Formato no valido",
                    "Texto"=>"El EFECTIVO no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-- Comprobando estado - Checking status --*/
            if($estado!="Habilitada" && $estado!="Deshabilitada"){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Opción no valida",
                    "Texto"=>"Ha seleccionado un ESTADO no valido",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-- Comprobando numero de caja - Checking cash register number --*/
            $check_numero=mainModel::ejecutar_consulta_simple("SELECT caja_numero FROM caja WHERE caja_numero='$numero'");
            if($check_numero->rowCount()>0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El número de caja ingresado ya se encuentra registrado en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }
            $check_numero->closeCursor();
            $check_numero=mainModel::desconectar($check_numero);

            /*-- Comprobando nombre de caja - Checking cash register name --*/
            $check_nombre=mainModel::ejecutar_consulta_simple("SELECT caja_nombre FROM caja WHERE caja_nombre='$nombre'");
            if($check_nombre->rowCount()>0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El nombre o código de caja ingresado ya se encuentra registrado en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }
            $check_nombre->closeCursor();
            $check_nombre=mainModel::desconectar($check_nombre);

            /*-- Comprobando que el efectivo sea mayor o igual a 0 - Checking that cash is greater than or equal to 0 --*/
            $efectivo=number_format($efectivo,COIN_DECIMALS,'.','');
            if($efectivo<0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No puedes colocar una cantidad de efectivo menor a 0.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-- Preparando datos para enviarlos al modelo - Preparing data to send to the model --*/
            $datos_caja_reg=[
                "caja_numero"=>[
                    "campo_marcador"=>":Numero",
                    "campo_valor"=>$numero
                ],
                "caja_nombre"=>[
                    "campo_marcador"=>":Nombre",
                    "campo_valor"=>$nombre
                ],
                "caja_estado"=>[
                    "campo_marcador"=>":Estado",
                    "campo_valor"=>$estado
                ],
                "caja_efectivo"=>[
                    "campo_marcador"=>":Efectivo",
                    "campo_valor"=>$efectivo
                ]
            ];

            /*-- Guardando datos de la caja - Saving cash register data --*/
            $agregar_caja=mainModel::guardar_datos("caja",$datos_caja_reg);

            if($agregar_caja->rowCount()==1){
                $alerta=[
                    "Alerta"=>"limpiar",
                    "Titulo"=>"¡Caja registrada!",
                    "Texto"=>"Los datos de la caja se registraron con éxito",
                    "Icon"=>"success",
                    "TxtBtn"=>"Aceptar"
                ];
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No hemos podido registrar los datos, por favor intente nuevamente",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
            }

            $agregar_caja->closeCursor();
            $agregar_caja=mainModel::desconectar($agregar_caja);

            echo json_encode($alerta);
        } /*-- Fin controlador - End controller --*/


        /*--------- Controlador paginador caja - Cash register Pager Controller ---------*/
        public function paginador_caja_controlador($pagina,$registros,$url,$busqueda){
            $pagina=mainModel::limpiar_cadena($pagina);
            $registros=mainModel::limpiar_cadena($registros);

            $url=mainModel::limpiar_cadena($url);
            $url=SERVERURL.DASHBOARD."/".$url."/";

            $busqueda=mainModel::limpiar_cadena($busqueda);
            $id=1;
            $tabla="";

            $pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
            $inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
            
            if(isset($busqueda) && $busqueda!=""){

                $consulta_datos="SELECT * FROM caja WHERE (caja_id!=1) AND (caja_numero LIKE '%$busqueda%' OR caja_nombre LIKE '%$busqueda%') ORDER BY caja_numero ASC LIMIT $inicio,$registros";

                $consulta_total="SELECT COUNT(caja_id) FROM caja WHERE (caja_id!=1) AND (caja_numero LIKE '%$busqueda%' OR caja_nombre LIKE '%$busqueda%')";

            }else{

                $consulta_datos="SELECT * FROM caja WHERE caja_id!=1 ORDER BY caja_numero ASC LIMIT $inicio,$registros";

                $consulta_total="SELECT COUNT(caja_id) FROM caja WHERE caja_id!=1";

            }

            $conexion = mainModel::conectar();

            $datos = $conexion->query($consulta_datos);
            $datos = $datos->fetchAll();

            $total = $conexion->query($consulta_total);
            $total = (int) $total->fetchColumn();

            $Npaginas =ceil($total/$registros);
            
            /*-- Encabezado de la tabla - Table header --*/
            $tabla.='
            <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr class="text-center font-weight-bold">
                        <th>Numero</th>
                        <th>Nombre / Código</th>
                        <th>Efectivo</th>
                        <th>Estado</th>
                        <th>Actualizar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
            ';

            if($total>=1 && $pagina<=$Npaginas){
                $contador=$inicio+1;
                $pag_inicio=$inicio+1;
                foreach($datos as $rows){
                    $tabla.='
                        <tr class="text-center" >
                            <td>'.$rows['caja_numero'].'</td>
                            <td>'.$rows['caja_nombre'].'</td>
                            <td>'.$rows['caja_efectivo'].'</td>
                            <td>'.$rows['caja_estado'].'</td>
                            <td><a class="btn btn-link text-success" href="'.SERVERURL.DASHBOARD.'/cashRegister-update/'.mainModel::encryption($rows['caja_id']).'/"><i class="fas fa-sync-alt"></i></a></td>
                            <td>
                                <form class="FormularioAjax" action="'.SERVERURL.'ajax/cajaAjax.php" method="POST" data-form="delete" data-lang="'.LANG.'" >
                                    <input type="hidden" name="modulo_caja" value="eliminar">
                                    <input type="hidden" name="caja_id_del" value="'.mainModel::encryption($rows['caja_id']).'">
                                    <button type="submit" class="btn btn-link text-danger"><i class="far fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                    ';
                    $contador++;
                }
                $pag_final=$contador-1;
            }else{
                if($total>=1){
                    $tabla.='
                        <tr class="text-center" >
                            <td colspan="7">
                                <a href="'.$url.'" class="btn btn-primary btn-sm">
                                    Haga clic acá para recargar el listado
                                </a>
                            </td>
                        </tr>
                    ';
                }else{
                    $tabla.='
                        <tr class="text-center" >
                            <td colspan="7">
                                No hay registros en el sistema
                            </td>
                        </tr>
                    ';
                }
            }

            $tabla.='</tbody></table></div>';

            if($total>0 && $pagina<=$Npaginas){
                $tabla.='<p class="text-end">Mostrando cajas <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
            }

            /*--Paginacion - Pagination --*/
            if($total>=1 && $pagina<=$Npaginas){
                $tabla.=mainModel::paginador_tablas($pagina,$Npaginas,$url,7,LANG);
            }

            return $tabla;
        } /*-- Fin controlador - End controller --*/


        /*--------- Controlador eliminar caja - Controller delete cash register ---------*/
        public function eliminar_caja_controlador(){

            /*-- Comprobando privilegios - Checking privileges --*/
            if($_SESSION['cargo_sto']!="Administrador"){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Acceso no permitido",
                    "Texto"=>"No tienes los permisos necesarios para realizar esta operación en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-- Recuperando id del caja - Retrieving cash register id - --*/
            $id=mainModel::decryption($_POST['caja_id_del']);
            $id=mainModel::limpiar_cadena($id);

            /*-- Comprobando caja en la BD - Checking cash register in DB --*/
            $check_caja=mainModel::ejecutar_consulta_simple("SELECT caja_id FROM caja WHERE caja_id='$id'");
            if($check_caja->rowCount()<=0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Caja no encontrada",
                    "Texto"=>"La caja que intenta eliminar no existe en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }
            $check_caja->closeCursor();
            $check_caja=mainModel::desconectar($check_caja);

            /*-- Comprobando ventas - Checking sales --*/
            $check_ventas=mainModel::ejecutar_consulta_simple("SELECT caja_id FROM venta WHERE caja_id='$id' LIMIT 1");
            if($check_ventas->rowCount()>0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No podemos eliminar la caja debido a que tiene ventas asociadas, recomendamos deshabilitar esta caja si ya no será usada en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }
            $check_ventas->closeCursor();
            $check_ventas=mainModel::desconectar($check_ventas);

            /*-- Eliminando caja - Deleting cash register --*/
            $eliminar_caja=mainModel::eliminar_registro("caja","caja_id",$id);

            if($eliminar_caja->rowCount()==1){
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"¡Caja eliminada!",
                    "Texto"=>"La caja ha sido eliminada del sistema exitosamente",
                    "Icon"=>"success",
                    "TxtBtn"=>"Aceptar"
                ];
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No hemos podido eliminar la caja del sistema, por favor intente nuevamente",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
            }

            $eliminar_caja->closeCursor();
            $eliminar_caja=mainModel::desconectar($eliminar_caja);

            echo json_encode($alerta);
        } /*-- Fin controlador - End controller --*/


        /*--------- Controlador actualizar caja - Controller update cash register ---------*/
        public function actualizar_caja_controlador(){

            /*-- Comprobando privilegios - Checking privileges --*/
            if($_SESSION['cargo_sto']!="Administrador"){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Acceso no permitido",
                    "Texto"=>"No tienes los permisos necesarios para realizar esta operación en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-- Recibiendo id de la caja - Receiving cash register id --*/
            $id=mainModel::decryption($_POST['caja_id_up']);
            $id=mainModel::limpiar_cadena($id);

            /*-- Comprobando caja en la DB - Checking cash register in DB --*/
            $check_caja=mainModel::ejecutar_consulta_simple("SELECT * FROM caja WHERE caja_id='$id'");
            if($check_caja->rowCount()<=0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Caja no encontrada",
                    "Texto"=>"No hemos encontrado la caja en el sistema",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }else{
                $campos=$check_caja->fetch();
            }
            $check_caja->closeCursor();
            $check_caja=mainModel::desconectar($check_caja);

            /*-- Recibiendo datos del formulario - Receiving form data --*/
            $numero=mainModel::limpiar_cadena($_POST['caja_numero_up']);
            $nombre=mainModel::limpiar_cadena($_POST['caja_nombre_up']);
            $estado=mainModel::limpiar_cadena($_POST['caja_estado_up']);
            $efectivo=mainModel::limpiar_cadena($_POST['caja_efectivo_up']);

            /*-- Comprobando campos vacios - Checking empty fields --*/
            if($numero=="" || $nombre=="" || $estado=="" || $efectivo==""){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No has llenado todos los campos que son obligatorios",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-- Verificando integridad de los datos - Checking data integrity --*/
            if(mainModel::verificar_datos("[0-9]{1,5}",$numero)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Formato no valido",
                    "Texto"=>"El NUMERO no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ:# ]{3,70}",$nombre)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Formato no valido",
                    "Texto"=>"El NOMBRE no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[0-9.]{1,25}",$efectivo)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Formato no valido",
                    "Texto"=>"El EFECTIVO no coincide con el formato solicitado",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-- Comprobando estado - Checking status --*/
            if($estado!="Habilitada" && $estado!="Deshabilitada"){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Opción no valida",
                    "Texto"=>"Ha seleccionado un ESTADO no valido",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-- Comprobando numero de caja - Checking cash register number --*/
            if($numero!=$campos['caja_numero']){
                $check_numero=mainModel::ejecutar_consulta_simple("SELECT caja_numero FROM caja WHERE caja_numero='$numero'");
                if($check_numero->rowCount()>0){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"El número de caja ingresado ya se encuentra registrado en el sistema",
                        "Icon"=>"error",
                        "TxtBtn"=>"Aceptar"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
                $check_numero->closeCursor();
                $check_numero=mainModel::desconectar($check_numero);
            }

            /*-- Comprobando nombre de caja - Checking cash register name --*/
            if($nombre!=$campos['caja_nombre']){
                $check_nombre=mainModel::ejecutar_consulta_simple("SELECT caja_nombre FROM caja WHERE caja_nombre='$nombre'");
                if($check_nombre->rowCount()>0){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"El nombre o código de caja ingresado ya se encuentra registrado en el sistema",
                        "Icon"=>"error",
                        "TxtBtn"=>"Aceptar"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
                $check_nombre->closeCursor();
                $check_nombre=mainModel::desconectar($check_nombre);
            }

            /*-- Comprobando que el efectivo sea mayor o igual a 0 - Checking that cash is greater than or equal to 0 --*/
            $efectivo=number_format($efectivo,COIN_DECIMALS,'.','');
            if($efectivo<0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No puedes colocar una cantidad de efectivo menor a 0.",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-- Preparando datos para enviarlos al modelo - Preparing data to send to the model --*/
            $datos_caja_up=[
                "caja_numero"=>[
                    "campo_marcador"=>":Numero",
                    "campo_valor"=>$numero
                ],
                "caja_nombre"=>[
                    "campo_marcador"=>":Nombre",
                    "campo_valor"=>$nombre
                ],
                "caja_estado"=>[
                    "campo_marcador"=>":Estado",
                    "campo_valor"=>$estado
                ],
                "caja_efectivo"=>[
                    "campo_marcador"=>":Efectivo",
                    "campo_valor"=>$efectivo
                ]
            ];

            $condicion=[
                "condicion_campo"=>"caja_id",
                "condicion_marcador"=>":ID",
                "condicion_valor"=>$id
            ];

            if(mainModel::actualizar_datos("caja",$datos_caja_up,$condicion)){
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"¡Caja actualizada!",
                    "Texto"=>"Los datos de la caja se actualizaron con éxito en el sistema",
                    "Icon"=>"success",
                    "TxtBtn"=>"Aceptar"
                ];
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No hemos podido actualizar los datos de la caja, por favor intente nuevamente",
                    "Icon"=>"error",
                    "TxtBtn"=>"Aceptar"
                ];
            }
            echo json_encode($alerta);
        } /*-- Fin controlador - End controller --*/
    }