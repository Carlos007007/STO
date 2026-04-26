<footer class="footer bg-white">
    <div class="container">
        <div class="row">

            <div class="col-12">
                <p class="text-justify lead" style="padding-bottom: 50px;">
                    Este sistema se seguirá desarrollando y el código fuente solo estará disponible para los <a href="https://www.youtube.com/channel/UCRMJ0vxtnHh_UAq1Yx9BYWQ/join" target="_blank">MIEMBROS del canal de YouTube</a>, puede hacerse miembro <a href="https://www.youtube.com/channel/UCRMJ0vxtnHh_UAq1Yx9BYWQ/join" target="_blank">haciendo clic acá</a>.
                </p>
                <p class="text-justify lead" style="padding-bottom: 50px;">
                    🔥 PROBAR SISTEMA TERMINADO 🔥<br>
                    El sistema ya se encuentra terminado y tiene 2 interfaces que son WEB y DASHBOARD. <a href="http://systems.designlopers.com/STO/" target="_blank">Haz clic aquí para probar la parte publica (WEB)</a>. Y para la otra interfaz... <a href="http://systems.designlopers.com/STO/admin/" target="_blank">Haz clic aquí para probar el panel administrativo (DASHBOARD)</a>.
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