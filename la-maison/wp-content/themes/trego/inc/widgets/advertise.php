<?php
/**
* @package Trego
* @version 1.0
*/
class Trego_Advertise_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct()
    {
        parent::__construct(
            'trego_advertise',
            __('Trego Advertising Info', 'trego'),
            array( 'description' => __( 'An Advertising Widget that displays image slider', 'trego' ), ) // Args
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

		if(!isset($instance['title'])) $instance['title'] = "";
		$title = apply_filters('widget_title', $instance['title']);

		echo $before_widget;

        ?>
        <div class="ad-info">
        <?php
        	$img = '';
        	if($instance['image1']){
				$img .= '[slide img="' . $instance['image1'] . '"][/slide]';
			}
        	if($instance['image2']){
				$img .= '[slide img="' . $instance['image2'] . '"][/slide]';
			}
        	if($instance['image3']){
				$img .= '[slide img="' . $instance['image3'] . '"][/slide]';
			}

			if($img != "") {
				$ad = '[bxslider speed="500" auto="true" pager="true" max_slides="1" move_slides="1" infinite_loop="true" slide_margin="0" auto_height="true"]';
				$ad .= $img;
				$ad .= '[/bxslider]';

				echo do_shortcode($ad);
			}
        ?>
        </div>
        <?php
        echo $after_widget;
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        $instance['image1'] = $new_instance['image1'];
        $instance['image2'] = $new_instance['image2'];
        $instance['image3'] = $new_instance['image3'];

        return $instance;
    }

    function form($instance)
    {
        $defaults = array('title' => 'Advertising');
        $instance = wp_parse_args((array) $instance, $defaults);
		
		if(empty($instance['image1'])) $instance['image1'] = "";
		if(empty($instance['image2'])) $instance['image2'] = "";
		if(empty($instance['image3'])) $instance['image3'] = "";
		?>
        <p>
            <label for="<?php echo $this->get_field_id('image1'); ?>">Image 1:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('image1'); ?>" name="<?php echo $this->get_field_name('image1'); ?>" value="<?php echo $instance['image1']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('image2'); ?>">Image 2:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('image2'); ?>" name="<?php echo $this->get_field_name('image2'); ?>" value="<?php echo $instance['image2']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('image3'); ?>">Image 3:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('image3'); ?>" name="<?php echo $this->get_field_name('image3'); ?>" value="<?php echo $instance['image3']; ?>" />
        </p>
    <?php
    }
}


/**
 * Register Trego_Tweets_Widget.
 */
add_action('widgets_init',
     create_function('', 'return register_widget("Trego_Advertise_Widget");')
);