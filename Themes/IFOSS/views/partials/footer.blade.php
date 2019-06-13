<section class="news-letter mt-0">
    <div class="container">
        <div class="wrapper row">
            <div class="col-md-6">
                <div class="news-letter-title">Subscribe for updates, new products & specials offers.</div>
            </div>
            <div class="col-md-6">
                <form>
                    <div class="row align-items-center">
                        <div class="col-sm-8">
                            <div class="form-group-fl mb-0">
                                <input type="text" class="form-control-fl" placeholder="Email address">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <a href="javascript:void(0);" class="btn-link text-custom"><i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<footer class="footer-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <ul class="footer-link mt-0">
                    <?php $footerLink = array('About iFoss','Careers','Investor Relations','Locations');
                    foreach ($footerLink as $key => $value) {
                    ?>
                    <li><a href="#"><?php echo $value; ?></a></li>
                    <?php } ?>
                </ul>
            </div>

            <div class="col-md-3 col-sm-6">
                <ul class="footer-link mt-0">
                    <?php $footerLink = array('My Orders','Return Policy','Help Center');
                    foreach ($footerLink as $key => $value) {
                    ?>
                    <li><a href="#"><?php echo $value; ?></a></li>
                    <?php } ?>
                </ul>
            </div>

            <div class="col-md-3 col-sm-6">
                <ul class="footer-link mt-0">
                    <li>
                        <button class="btn btn-custom"><i class="fas fa-phone-volume text-white"></i> Call us</button>
                    </li>
                    <li>
                        <button class="btn btn-outline-custom">Customer service </button>
                    </li>
                </ul>
            </div>

            <div class="col-md-3 col-sm-6">
                <ul class="footer-link-social justify-content-md-end">
                    <?php $footerLink = array('fab fa-facebook-f','fab fa-instagram','fab fa-youtube', 'fab fa-twitter', 'fab fa-google-plus-g');
                    foreach ($footerLink as $key => $value) {
                    ?>
                    <li><a href="#" class="<?php echo $value; ?>"></a></li>
                    <?php } ?>
                </ul>
                <div class="footer-copyright">© 2019. All Rights Reserved</div>
            </div>
        </div>
    </div>
</footer>
<script type="text/javascript">
    
</script>