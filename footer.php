            	<div id="sidebar">
                	<?php get_sidebar( 'default' ); ?>
                </div><!--SIDEBAR-->
            </div><!--CONTENT-->
        </div><!--BODY-->
        <div id="footer">
            <div class="content">
                <p><a href="<?php bloginfo('url'); ?>" target="_self"><?php bloginfo('name'); ?></a> is designed &amp; developed by <a href="http://mononelo.es" target="_blank"><strong>mononelo</strong></a> @ Barcelona <?php echo date('Y'); ?></p>
            </div><!--CONTENT-->
        </div><!--FOOTER-->
    </div><!--WRAPPER-->
    
    <!--SCRIPTS-->
    <script src="<?php bloginfo('template_url'); ?>/js/jquery-3.2.1.min.js"></script>
	<script src="<?php bloginfo('template_url'); ?>/inc/fancybox/jquery.fancybox.min.js"></script>
	<script src="<?php bloginfo('template_url'); ?>/js/scripts.js"></script>
    <!--SCRIPTS-->
    
    <?php wp_footer(); ?>
    
    </body>
</html>