<footer class="footer bg-white">
    <div class="container">
        <div class="row">

            <div class="col-12">
                <p class="text-justify lead" style="padding-bottom: 50px;">
                    Recuerda que puedes apoyar este proyecto suscribiéndote a mis canales de YouTube <a href="https://www.youtube.com/channel/UCRMJ0vxtnHh_UAq1Yx9BYWQ?sub_confirmation=1" target="_blank">CARLOS ALFARO</a> & <a href="https://www.youtube.com/channel/UCSKQJ3n2_CNjgB3sb2fvTdQ?sub_confirmation=1" target="_blank">DESIGNLOPERS</a>, tu apoyo es muy importante para seguir desarrollando este software y para traer nuevos proyectos.
                </p>
            </div>

            <div class="col-12 col-md-4 mb-4">
                <ul class="list-unstyled" >
                    <li><h5 class="font-weight-bold" ><i class="far fa-copyright"></i> <?php echo COMPANY." ".date("Y"); ?></h5></li>
                    <li> Todos los derechos reservados </li>
                </ul>
            </div>
            <div class="col-12 col-md-4 mb-4">
                <ul class="list-unstyled" >
                    <li><h5 class="font-weight-bold" ><?php echo COUNTRY;?></h5></li>
                    <li><i class="fas fa-map-marker-alt fa-fw"></i> <?php echo ADDRESS; ?></li>
                </ul>
            </div>
            <div class="col-12 col-md-4 mb-4">
                <ul class="list-unstyled" >
                    <li><h5 class="font-weight-bold" >Sigueme en:</h5> </li>
                    <?php if(FACEBOOK!=""){ ?>
                    <li>
                        <a href="<?php echo FACEBOOK; ?>" class="footer-link" target="_blank" >
                            <i class="fab fa-facebook fa-fw"></i> Facebook
                        </a>
                    </li>
                    <?php 
                        }
                        if(INSTAGRAM!=""){ 
                    ?>
                    <li>
                        <a href="<?php echo INSTAGRAM; ?>" class="footer-link" target="_blank" >
                            <i class="fab fa-instagram fa-fw"></i>
                                Instagram
                        </a>
                    </li>
                    <?php 
                        }
                        if(YOUTUBE!=""){ 
                    ?>
                    <li>
                        <a href="<?php echo YOUTUBE; ?>" class="footer-link" target="_blank" >
                            <i class="fab fa-youtube fa-fw"></i>
                                Youtube
                        </a>
                    </li>
                    <?php 
                        }
                        if(TWITTER!=""){ 
                    ?>
                    <li>
                        <a href="<?php echo TWITTER; ?>" class="footer-link" target="_blank" >
                            <i class="fab fa-twitter fa-fw"></i>
                                Twitter
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</footer>