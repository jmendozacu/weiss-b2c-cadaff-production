<?php
/**
* @package Trego
* @version 1.0
*/
class Trego_Contact_Info_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct()
    {
        parent::__construct(
            'trego_contact_info',
            __('Contact Information', 'trego'),
            array( 'description' => __( 'Shows a contact information', 'trego' ), ) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     *  @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    function widget($args, $instance)
    {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);

        echo $before_widget;

        if($title) {
            echo $before_title.$title.$after_title;
        }
        ?>
        <div class="contact-info">
			<?php
				if($instance['newsletter'] == 'yes'){
					echo trego_newsletter_form();
				}
			?>
            <?php if($instance['address']): ?>
            <p class="address"><?php echo $instance['address']; ?></p>
            <?php endif; ?>

            <?php if($instance['address2']): ?>
            <p class="address"><?php echo $instance['address2']; ?></p>
            <?php endif; ?>

			<?php if($instance['phone'] || $instance['phone2']): ?>
			<dl>
				<dt><?php _e('Phone:', 'trego'); ?></dt>
				<dd>
			    <?php if($instance['phone']): ?>
				    <p><?php echo $instance['phone']; ?></p>
			    <?php endif; ?>
			    <?php if($instance['phone2']): ?>
				    <p><?php echo $instance['phone2']; ?></p>
			    <?php endif; ?>
				</dd>
			</dl>
			<?php endif; ?>

			<?php if($instance['mobile'] || $instance['mobile2']): ?>
			<dl>
				<dt><?php _e('Mobile:', 'trego'); ?></dt>
				<dd>
			    <?php if($instance['mobile']): ?>
				    <p><?php echo $instance['mobile']; ?></p>
			    <?php endif; ?>
			    <?php if($instance['mobile2']): ?>
				    <p><?php echo $instance['mobile2']; ?></p>
			    <?php endif; ?>
				</dd>
			</dl>
			<?php endif; ?>

			<?php if($instance['fax']): ?>
			<dl>
				<dt><?php _e('Fax:', 'trego'); ?></dt>
				<dd><p><?php echo $instance['fax']; ?></p></dd>
			</dl>
			<?php endif; ?>

			<?php if($instance['email'] || $instance['email2']): ?>
			<dl>
				<dt><?php _e('E-mail:', 'trego'); ?></dt>
				<dd>
			    <?php if($instance['email']): ?>
				    <p><?php echo $instance['email']; ?></p>
			    <?php endif; ?>
			    <?php if($instance['email2']): ?>
				    <p><?php echo $instance['email2']; ?></p>
			    <?php endif; ?>
				</dd>
			</dl>
			<?php endif; ?>

			<?php if($instance['skype'] || $instance['skype2']): ?>
			<dl>
				<dt><?php _e('Skype:', 'trego'); ?></dt>
				<dd>
			    <?php if($instance['skype']): ?>
				    <p><?php echo $instance['skype']; ?></p>
			    <?php endif; ?>
			    <?php if($instance['skype2']): ?>
				    <p><?php echo $instance['skype2']; ?></p>
			    <?php endif; ?>
				</dd>
			</dl>
			<?php endif; ?>

            <?php if($instance['other']): ?>
            <p class="other"><?php echo $instance['other']; ?></p>
            <?php endif; ?>
        </div>
        <?php
        echo $after_widget;
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        $instance['title'] = $new_instance['title'];
        $instance['newsletter'] = $new_instance['newsletter'];
		$instance['address'] = $new_instance['address'];
        $instance['address2'] = $new_instance['address2'];
        $instance['phone'] = $new_instance['phone'];
        $instance['phone2'] = $new_instance['phone2'];
        $instance['mobile'] = $new_instance['mobile'];
        $instance['mobile2'] = $new_instance['mobile2'];
        $instance['fax'] = $new_instance['fax'];
        $instance['email'] = $new_instance['email'];
        $instance['email2'] = $new_instance['email2'];
        $instance['skype'] = $new_instance['skype'];
        $instance['skype2'] = $new_instance['skype2'];
        $instance['other'] = $new_instance['other'];

        return $instance;
    }

    function form($instance)
    {
        $defaults = array('title' => 'Contact Information');
        $instance = wp_parse_args((array) $instance, $defaults);

		if(empty($instance['title'])) $instance['title'] = "";
		if(empty($instance['address'])) $instance['address'] = "";
		if(empty($instance['address2'])) $instance['address2'] = "";
		if(empty($instance['phone'])) $instance['phone'] = "";
		if(empty($instance['phone2'])) $instance['phone2'] = "";
		if(empty($instance['mobile'])) $instance['mobile'] = "";
		if(empty($instance['mobile2'])) $instance['mobile2'] = "";
		if(empty($instance['fax'])) $instance['fax'] = "";
		if(empty($instance['email'])) $instance['email'] = "";
		if(empty($instance['email2'])) $instance['email2'] = "";
		if(empty($instance['skype'])) $instance['skype'] = "";
		if(empty($instance['skype2'])) $instance['skype2'] = "";
		if(empty($instance['other'])) $instance['other'] = "";
		if(empty($instance['newsletter'])) $instance['newsletter'] = "no";
		?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('newsletter'); ?>">Newsletter: </label>
			<select id="<?php echo $this->get_field_id('newsletter'); ?>" name="<?php echo $this->get_field_name('newsletter'); ?>">
			<?php
				if($instance['newsletter'] == 'no'){
					echo '<option value="yes">Yes</option>';
					echo '<option value="no" selected>No</option>';
				} else {
					echo '<option value="yes" selected>Yes</option>';
					echo '<option value="no">No</option>';
				}
			?>
			</select>
        </p>
		<p>
            <label for="<?php echo $this->get_field_id('address'); ?>">Contact Address:</label>
            <textarea class="widefat" type="text" id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>"><?php echo $instance['address']; ?></textarea>
        </p>
		<p>
            <label for="<?php echo $this->get_field_id('address2'); ?>">Contact Address 2:</label>
            <textarea class="widefat" type="text" id="<?php echo $this->get_field_id('address2'); ?>" name="<?php echo $this->get_field_name('address2'); ?>"><?php echo $instance['address2']; ?></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('phone'); ?>">Phone:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('phone'); ?>" name="<?php echo $this->get_field_name('phone'); ?>" value="<?php echo $instance['phone']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('phone2'); ?>">Phone 2:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('phone2'); ?>" name="<?php echo $this->get_field_name('phone2'); ?>" value="<?php echo $instance['phone2']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('mobile'); ?>">Mobile:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('mobile'); ?>" name="<?php echo $this->get_field_name('mobile'); ?>" value="<?php echo $instance['mobile']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('mobile2'); ?>">Mobile 2:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('mobile2'); ?>" name="<?php echo $this->get_field_name('mobile2'); ?>" value="<?php echo $instance['mobile2']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('fax'); ?>">Fax:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('fax'); ?>" name="<?php echo $this->get_field_name('fax'); ?>" value="<?php echo $instance['fax']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('email'); ?>">E-mail:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" value="<?php echo $instance['email']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('email2'); ?>">E-mail 2:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('email2'); ?>" name="<?php echo $this->get_field_name('email2'); ?>" value="<?php echo $instance['email2']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('skype'); ?>">Skype:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('skype'); ?>" name="<?php echo $this->get_field_name('skype'); ?>" value="<?php echo $instance['skype']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('skype2'); ?>">Skype 2:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('skype2'); ?>" name="<?php echo $this->get_field_name('skype2'); ?>" value="<?php echo $instance['skype2']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('other'); ?>">Other:</label>
            <textarea class="widefat" type="text" id="<?php echo $this->get_field_id('other'); ?>" name="<?php echo $this->get_field_name('other'); ?>"><?php echo $instance['other']; ?></textarea>
        </p>
    <?php
    }
}


/**
 * Register Trego_Tweets_Widget.
 */
add_action('widgets_init',
     create_function('', 'return register_widget("Trego_Contact_Info_Widget");')
);