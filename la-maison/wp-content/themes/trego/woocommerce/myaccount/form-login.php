<?php
/**
 * Login Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.6
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<?php wc_print_notices(); ?>

<?php do_action('woocommerce_before_customer_login_form'); ?>
<div class="row-container column">
<?php if (get_option('woocommerce_enable_myaccount_registration') === 'yes') : ?>

<div class="span-12" id="customer_login">
<div class="row">
	<div class="span-6 span-m-12 span-s-12 column">

<?php endif; ?>

		<h2 class="title-section"><?php _e( 'Login', 'woocommerce' ); ?></h2>
		<form method="post" class="login">
			<?php do_action( 'woocommerce_login_form_start' ); ?>
			<p class="form-row">
				<label for="username"><?php _e( 'Username or email', 'woocommerce' ); ?> <span class="required">*</span></label>
				<input type="text" class="input-text" name="username" id="username" placeholder="<?php _e( 'Enter UserName or Email', 'woocommerce' ); ?> *" />
			</p>
			<p class="form-row">
				<label for="password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
				<input class="input-text" type="password" name="password" id="password" placeholder="<?php _e( 'Enter Password', 'woocommerce' ); ?> *" />
			</p>
			<div class="clear"></div>
			<?php do_action( 'woocommerce_login_form' ); ?>
			<p class="form-row">
				<?php wp_nonce_field('woocommerce-login'); ?>
				<input type="submit" class="button" name="login" value="<?php _e( 'Login', 'woocommerce' ); ?>" />
				<a class="lost_password" href="<?php echo esc_url( wc_lostpassword_url() ); ?>"><?php _e( 'Lost Password?', 'woocommerce' ); ?></a>
			</p>
			<?php do_action( 'woocommerce_login_form_end' ); ?>
		</form>

<?php if (get_option('woocommerce_enable_myaccount_registration')=='yes') : ?>

	</div>

	<div class="span-6 span-m-12 span-s-12 column">

		<h2 class="title-section"><?php _e( 'Register', 'woocommerce' ); ?></h2>
		<form method="post" class="register">
			<?php do_action( 'woocommerce_register_form_start' ); ?>
			<?php if ( get_option( 'woocommerce_registration_email_for_username' ) == 'no' ) : ?>

				<p class="form-row">
					<label for="reg_username"><?php _e( 'Username', 'woocommerce' ); ?> <span class="required">*</span></label>
					<input type="text" class="input-text" name="username" id="reg_username" value="<?php if (isset($_POST['username'])) echo esc_attr($_POST['username']); ?>" placeholder="<?php _e( 'Enter UserName', 'woocommerce' ); ?> *" />
				</p>

				<p class="form-row">

			<?php else : ?>

				<p class="form-row">

			<?php endif; ?>

				<label for="reg_email"><?php _e( 'Email', 'woocommerce' ); ?> <span class="required">*</span></label>
				<input type="email" class="input-text" name="email" id="reg_email" value="<?php if (isset($_POST['email'])) echo esc_attr($_POST['email']); ?>" placeholder="<?php _e( 'Enter Email', 'woocommerce' ); ?> *" />
			</p>

			<p class="form-row form-row-first">
				<label for="reg_password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
				<input type="password" class="input-text" name="password" id="reg_password" value="<?php if (isset($_POST['password'])) echo esc_attr($_POST['password']); ?>" placeholder="<?php _e( 'Enter Password', 'woocommerce' ); ?> *" />
			</p>
			<p class="form-row form-row-last">
				<label for="reg_password2"><?php _e( 'Re-enter password', 'woocommerce' ); ?> <span class="required">*</span></label>
				<input type="password" class="input-text" name="password2" id="reg_password2" value="<?php if (isset($_POST['password2'])) echo esc_attr($_POST['password2']); ?>" placeholder="<?php _e( 'Re-enter password', 'woocommerce' ); ?> *" />
			</p>

			<!-- Spam Trap -->
			<div style="left:-999em; position:absolute;"><label for="trap"><?php _e( 'Anti-spam', 'woocommerce' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>
			<?php do_action('woocommerce_register_form'); ?>
			<?php do_action( 'register_form' ); ?>

			<p class="form-row">
				<?php wp_nonce_field('woocommerce-register'); ?>
				<input type="submit" class="button" name="register" value="<?php _e( 'Register', 'woocommerce' ); ?>" />
			</p>
			<?php do_action( 'woocommerce_register_form_end' ); ?>
		</form>

	</div>
</div>
</div>
<?php endif; ?>
</div>
<?php do_action('woocommerce_after_customer_login_form'); ?>