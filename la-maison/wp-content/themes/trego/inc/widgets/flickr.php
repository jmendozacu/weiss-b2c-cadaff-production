<?php
/**
* @package Trego
* @version 1.0
*/
class Trego_Flickr_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct()
    {
        parent::__construct(
            'trego_flickr',
            __('Trego Flickr', 'trego'),
            array( 'description' => __( 'Shows a list of the most recent flickr', 'trego' ), ) // Args
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
        <div class="flickr-info">
		<?php
			$api_key = $instance['flickr_api'];
			$photoset_id = $instance['flickr_photo_id'];
			$count = $instance['flickr_limit'];
			if($api_key && $photoset_id && $count){
				$photoset = file_get_contents("http://api.flickr.com/services/rest/?method=flickr.photosets.getPhotos&api_key=".$api_key."&photoset_id=".$photoset_id."&format=rest");
				$photoset_xml = new SimpleXMLElement($photoset);

				$i = 0;
				foreach($photoset_xml->photoset->photo as $photo){
					if($i >= $count){ continue; }
					$photo_size = file_get_contents("http://api.flickr.com/services/rest/?method=flickr.photos.getSizes&api_key=".$api_key."&photo_id=".$photo['id']."&format=rest");
					$photo_size_xml = new SimpleXMLElement($photo_size);
					if($photo_size_xml['stat'] == 'ok'){
						$sizes_xml = $photo_size_xml->sizes;
						$sizes_children = $sizes_xml->children();
						$photo_square = $sizes_children[0];
						$image_url = $photo_square['source'];
						$photo_info = file_get_contents("http://api.flickr.com/services/rest/?method=flickr.photos.getInfo&api_key=".$api_key."&photo_id=".$photo['id']."&format=rest");
						$photo_info_xml = new SimpleXMLElement($photo_info);
						$photo_url = $image_url;
						$photo_title = '';
						if ($photo_info_xml['stat'] == 'ok') {
							$photo_url = (string)$photo_info_xml->photo->urls->url;
							$photo_title = (string)$photo_info_xml->photo->title;
						}

						if ($i%3 == 2) {
							echo '<a class="last-img" href="'.$photo_url.'" target="_blank"><img src="'.$image_url.'" title="'.$photo_title.'" alt="'.$photo_title.'"/></a>';
						} else {
							echo '<a href="'.$photo_url.'" target="_blank"><img src="'.$image_url.'" title="'.$photo_title.'" alt="'.$photo_title.'"/></a>';
						}
						$i++;
					}
				}
			}
		?>
		</div>
        <?php
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['title'] = $new_instance['title'];
        $instance['flickr_api'] = $new_instance['flickr_api'];
        $instance['flickr_photo_id'] = $new_instance['flickr_photo_id'];
        $instance['flickr_limit'] = $new_instance['flickr_limit'];

        return $instance;
    }

    function form($instance) {
        $defaults = array('title' => 'Flickr');
        $instance = wp_parse_args((array) $instance, $defaults);
		if(empty($instance['title'])) $instance['title'] = "";
		if(empty($instance['flickr_api'])) $instance['flickr_api'] = "";
		if(empty($instance['flickr_photo_id'])) $instance['flickr_photo_id'] = "";
		if(empty($instance['flickr_limit'])) $instance['flickr_limit'] = "";
		?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('flickr_api'); ?>">API key:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('flickr_api'); ?>" name="<?php echo $this->get_field_name('flickr_api'); ?>" value="<?php echo $instance['flickr_api']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('flickr_photo_id'); ?>">Photo set ID:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('flickr_photo_id'); ?>" name="<?php echo $this->get_field_name('flickr_photo_id'); ?>" value="<?php echo $instance['flickr_photo_id']; ?>" />
        </p>
        <p>
        <p>
            <label for="<?php echo $this->get_field_id('flickr_limit'); ?>">Limit:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('flickr_limit'); ?>" name="<?php echo $this->get_field_name('flickr_limit'); ?>" value="<?php echo $instance['flickr_limit']; ?>" />
        </p>
    <?php
    }
}


/**
 * Register Trego_Tweets_Widget.
 */
add_action('widgets_init',
     create_function('', 'return register_widget("Trego_Flickr_Widget");')
);