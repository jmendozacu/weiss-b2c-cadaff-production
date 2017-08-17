<?php
/**
 * @package Trego
 * @since Trego 1.0
 */

global $trego_vars;
?>
    <?php $site = "http://" . $_SERVER['HTTP_HOST']; ?>


<!---Modif Lr Voir footer_old--->
		</div>
		<footer id="colophon" class="site-footer" role="contentinfo">
        <!-- Start  Newsletter Block  -->
            <div class="section-block">
            <div class="section-content">
            <div class="site-content">
            <div class=" newsletter-wrapper">
                <div class="span-6  span-m-6 span-s-12 column newsletter">
                    <h2 class="newsletter-title"><?php echo __('Newsletter', 'trego'); ?></h2>
                    <div class="block block-subscribe">
                        <form action="<?php echo $site ?>/newsletter/subscriber/new/" method="post" id="newsletter-validate-detail">                                                                   
                            <div class="block-content">
                                <div class="form-subscribe-header">
                                    <label for="newsletter"><?php echo __('Sign up for our newsletter and earn 100 pepites!', 'trego'); ?></label>
                                </div>
                                <div>
                                <div class="input-box span-8">
                                    <input type="email" name="email" id="newsletter" title="<?php echo __('Subscribe to our newsletter', 'trego'); ?>" class="input-text required-entry validate-email" placeholder="<?php echo __('your email address', 'trego'); ?>">
                                </div>
                                <div class="actions span-2">
                                    <button type="submit" title="<?php echo __('Subscribe', 'trego'); ?>" class="button"><span><span><?php echo __('Ok', 'trego'); ?></span></span></button>
                                </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="nugget  span-6  span-m-6 span-s-12 column">
                    <img name=image src=<?php bloginfo('template_directory'); ?>/images/weiss_static_block.jpg>
                    <img name=image src=<?php bloginfo('template_directory'); ?>/images/nugget-mob-bg.jpg>
                    <div class="nugget-text">
                        <h2><?php echo __('Collect loyalty points  !', 'trego'); ?></h2>
                        <p><?php echo __('Earn 1 point', 'trego'); ?></p>
                        <p><span><?php echo __('for every €1 spent!', 'trego'); ?>&nbsp;</span></p>
                    </div>
                </div>
            </div>
            </div>
            </div>
            </div>

            <!-- End Newsletter Block  -->



			<div class="widget-bottom">
				<?php if(!is_page_template('page-gallery-template.php')): ?>
				<ul class="block-grid-4 block-grid-m-4 block-grid-s-1">
					<?php dynamic_sidebar( 'sidebar-3' ); ?>
				</ul>
                            <?php // do_action('wpml_add_language_selector'); ?>
		<div class="site-info">
					<?php if ( !is_page_template('page-gallery-template.php') && has_nav_menu( 'footer' ) ) : ?>
					<div class="footer-links">
					<?php
//					wp_nav_menu(array(
//						'theme_location' => 'footer',
//						'container'       => false,
//						'depth'           => 0,
//					));

					?>
					</div>
					<?php endif; ?>
					<div class="social-icons">
						<ul class="social-links">I will
						<?php if(!empty($trego_vars['facebook_link'])) :?>
							<li><a title="Facebook" href="<?php echo $trego_vars['facebook_link']; ?>" class="facebook"> </a></li>
						<?php endif; ?>
						<?php if(!empty($trego_vars['twitter_link'])) :?>
							<li><a title="Twitter" href="<?php echo $trego_vars['twitter_link']; ?>" class="twitter"> </a></li>
						<?php endif; ?>
						<?php if(!empty($trego_vars['linkedin_link'])) :?>
							<li><a title="Linkedin" href="<?php echo $trego_vars['linkedin_link']; ?>" class="linkedin"> </a></li>
						<?php endif; ?>
						<?php if(!empty($trego_vars['flickr_link'])) :?>
							<li><a title="Flickr" href="<?php echo $trego_vars['flickr_link']; ?>" class="flickr"> </a></li>
						<?php endif; ?>
						<?php if(!empty($trego_vars['googleplus_link'])) :?>
							<li><a title="Google Plus" href="<?php echo $trego_vars['googleplus_link']; ?>" class="googleplus"> </a></li>
						<?php endif; ?>
						<?php if(!empty($trego_vars['pinterest_link'])) :?>
							<li><a title="Pinterest" href="<?php echo $trego_vars['pinterest_link']; ?>" class="pinterest"> </a></li>
						<?php endif; ?>
						<?php if(!empty($trego_vars['youtube_link'])) :?>
							<li><a title="YouTube" href="<?php echo $trego_vars['youtube_link']; ?>" class="youtube"> </a></li>
						<?php endif; ?>
						<?php if(!empty($trego_vars['instagram_link'])) :?>
							<li><a title="Instagram" href="<?php echo $trego_vars['instagram_link']; ?>" class="instagram"> </a></li>
						<?php endif; ?>
						</ul>
					</div>
					<div class="copyrights"><?php if(isset($trego_vars['copyright'])) echo $trego_vars['copyright']; ?></div>
				</div>
			</div>
			<div class="footer-copy-right">
				&copy; <?php echo date("Y") ?><?php echo __('Chocolat Weiss. all rights reserved','trego') ?>
			</div>
		</footer>
		<?php endif; ?>
	</div><!-- #wrapper -->
	<?php wp_footer(); ?>
	<?php if(trego_get_background()) { ?>
	<div class="page-background"></div>
	<?php } ?>
</body>
</html>