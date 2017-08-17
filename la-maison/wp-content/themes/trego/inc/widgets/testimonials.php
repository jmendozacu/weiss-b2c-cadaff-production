<?php
/**
* @package Trego
* @version 1.0
*/
class Trego_Testimonial_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct()
    {
        parent::__construct(
            'trego_testimonial',
            __('Trego Testimonials', 'trego'),
            array( 'description' => __( 'Testimonial Widget Slider', 'trego' ), ) // Args
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
    function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);

		echo $before_widget;

        if($title) {
            echo $before_title.$title.$after_title;
        }
        ?>
        <div class="testimonial-info">
        <?php
			if($instance['limit']) {
				$limit = $instance['limit'];
			} else {
				$limit = 2;
			}

			$auto = ($limit == 1) ? 'false' : 'true';

			$testimonial = '[testimonial auto="'.$auto.'" infinite_loop="false" ctrls_size="small" max_slides="1" auto_height="true" limit="'.$limit.'"]';

			echo do_shortcode($testimonial);
        ?>
        </div>
        <?php
        echo $after_widget;
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        $instance['title'] = $new_instance['title'];
        $instance['limit'] = $new_instance['limit'];

        return $instance;
    }

    function form($instance)
    {
        $defaults = array('title' => 'Testimonials');
        $instance = wp_parse_args((array) $instance, $defaults);
		if(empty($instance['title'])) $instance['title'] = "";
		if(empty($instance['limit'])) $instance['limit'] = "";
		?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('limit'); ?>">Display Limit:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" value="<?php echo $instance['limit']; ?>" />
        </p>
    <?php
    }
}


/**
 * Register Trego_Tweets_Widget.
 */
add_action('widgets_init',
     create_function('', 'return register_widget("Trego_Testimonial_Widget");')
);