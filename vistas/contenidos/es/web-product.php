<?php
    if(empty($pagina[1]) || $pagina[1]==""){
        $pagina[1]="all";
    }

    if(empty($pagina[3]) || $pagina[3]==""){
        $pagina[3]=1;
    }

    if(empty($pagina[2]) || $pagina[2]==""){
        $pagina[2]="ASC";
    }
?>
<div class="bg-white full-box">
    <div class="container container-web-page">
        <?php
            $nombre_categoria=$ins_login->datos_tabla("Unico","categoria","categoria_id",$ins_login->encryption($pagina[1]));
            
            if($pagina[1]!="all" && $nombre_categoria->rowCount()==1){
                $nombre_categoria=$nombre_categoria->fetch();
        ?>
        <h3 class="font-weight-bold poppins-regular text-uppercase"><?php echo $nombre_categoria['categoria_nombre']; ?></h3>
        <p class="text-justify"><?php echo $nombre_categoria['categoria_descripcion']; ?></p>
        <?php }else{ ?>
        <h3 class="font-weight-bold poppins-regular text-uppercase">Productos en tienda</h3>
        <p class="text-justify">Bienvenido al menú de productos, acá encontrara todos los productos disponibles en nuestra tienda. Puede ordenar los productos por categoría en el botón "<i class="fas fa-tags fa-fw"></i> CATEGORÍAS" y también ordenarlos por orden alfabético o por precio en el botón "<i class="fas fa-sort-alpha-down fa-fw"></i> ORDENAR POR". Además, puede buscar productos por nombre haciendo clic en el botón "<i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR"</p>
        <?php } ?>
        
        <div class="container-fluid" style="border-top: 1px solid #E1E1E1; padding: 20px; 0">
            <div class="row align-items-center">
                <div class="col-12 col-sm-4 text-center text-sm-start">
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle" type="button" id="categorySubMenu" data-mdb-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-tags fa-fw"></i> &nbsp; CATEGORÍAS
                        </button>
                        <div class="dropdown-menu" aria-labelledby="categorySubMenu">
                            <?php
                                $datos_categoria=$ins_login->datos_tabla("Normal","categoria WHERE categoria_estado='Habilitada'","categoria_id,categoria_nombre,categoria_estado",0);
                                while($campos_categoria=$datos_categoria->fetch()){
                                    echo '<a class="dropdown-item" href="'.SERVERURL.$pagina[0].'/'.$campos_categoria['categoria_id'].'/ASC/1/'.'">'.$campos_categoria['categoria_nombre'].'</a>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-4 text-center">
                    <button type="button" class="btn btn-link" data-mdb-toggle="modal" data-mdb-target="#saucerModal">
                        <i class="fas fa-search fa-fw"></i> &nbsp; Buscar
                    </button>
                </div>
                <div class="col-12 col-sm-4 text-center text-sm-end">
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle" type="button" id="OrderSubMenu" data-mdb-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-sort-alpha-down fa-fw"></i> &nbsp; Ordenar por
                        </button>
                        <div class="dropdown-menu" aria-labelledby="OrderSubMenu">
                            <a class="dropdown-item" href="<?php echo SERVERURL.$pagina[0]."/".$pagina[1]."/ASC/1/"; ?>">Ascendente (A-Z)</a>
                            <a class="dropdown-item" href="<?php echo SERVERURL.$pagina[0]."/".$pagina[1]."/DESC/1/"; ?>">Descendente (Z-A)</a>
                            <a class="dropdown-item" href="<?php echo SERVERURL.$pagina[0]."/".$pagina[1]."/MIN/1/"; ?>">Precio (Menor a Mayor)</a>
                            <a class="dropdown-item" href="<?php echo SERVERURL.$pagina[0]."/".$pagina[1]."/MAX/1/"; ?>">Precio (Mayor a Menor)</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <?php
            if(isset($_SESSION['busqueda_tienda']) && !empty($_SESSION['busqueda_tienda'])){
        ?>
        <div class="container-fluid" style="padding: 20px 0;">
            <div class="row">
                <div class="col-12 col-md-8">
                    <p class="text-left lead"><i class="fas fa-search fa-fw"></i> &nbsp; Resultados de la búsqueda: <span class="font-weight-bold poppins-regular text-uppercase"><?php echo $_SESSION['busqueda_tienda']; ?></span></p>
                </div>
                <div class="col-12 col-md-4">
                    <form class="mb-4 FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" data-form="search" data-lang="<?php echo LANG; ?>" method="POST">
                        <input type="hidden" name="modulo" value="tienda">
                        <input type="hidden" name="eliminar_busqueda" value="eliminar">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-times fa-fw"></i> &nbsp; Eliminar busqueda
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php
            }else{
                $_SESSION['busqueda_tienda']="";
            }
         
        
            require_once "./controladores/productoControlador.php";
            $ins_producto = new productoControlador();

            echo $ins_producto->cliente_paginador_producto_controlador($pagina[3],10,$pagina[0],$pagina[2],$pagina[1],$_SESSION['busqueda_tienda']);
        ?>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="saucerModal" tabindex="-1" aria-hidden="true" aria-labelledby="saucerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" data-form="default" data-lang="<?php echo LANG; ?>" method="POST" autocomplete="off">
            <input type="hidden" name="modulo" value="tienda">
            <div class="modal-header">
                <h5 class="modal-title" id="saucerModalLabel">Buscar producto</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-outline mb-4">
                    <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" name="busqueda_inicial" id="buscar_producto" maxlength="30">
                    <label for="buscar_producto" class="form-label">¿Qué estás buscando?</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-mdb-dismiss="modal"><i class="fas fa-times fa-fw"></i> &nbsp; Cerrar</button>
                <button type="submit" class="btn btn-info"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar</button>
            </div>
        </form>
    </div>
</div>