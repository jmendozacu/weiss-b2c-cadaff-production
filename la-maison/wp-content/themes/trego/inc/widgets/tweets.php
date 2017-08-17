<?php
/**
* @package Trego
* @version 1.0
*/
class Trego_Tweets_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct()
    {
        parent::__construct(
            'trego_twitter_feed',
            __('Twitter Feed', 'trego'),
            array( 'description' => __( 'Shows a list of the most recent tweets', 'trego' ), ) // Args
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
		<div id="feed_container" class="feed_container"></div>
		<script type="text/javascript">
		<!--
			function handleTweets(tweets) {
				var x = tweets.length;
				var n = 0;
				var element = document.getElementById('feed_container');
				var html = '<ul>';
				while(n < x) {
					html += '<li>' + tweets[n] + '</li>';
					n++;
				}
				html += '</ul>';
				element.innerHTML = html;
			}

			var widgetid = '<?php echo $instance['twitter_widget_id'] ?>';
			var showcounts = '<?php echo $instance['tweets_counts'] ?>';
			twitterFetcher.fetch(widgetid, 'feed_container', showcounts, true, false, true, '', false);
		//-->
		</script>
        <?php
        echo $after_widget;
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        $instance['title'] = $new_instance['title'];
        $instance['twitter_widget_id'] = $new_instance['twitter_widget_id'];
        $instance['tweets_counts'] = $new_instance['tweets_counts'];

        return $instance;
    }

    function form($instance)
    {
        $defaults = array('title' => 'From Twitter');
        $instance = wp_parse_args((array) $instance, $defaults);
		if(empty($instance['twitter_widget_id'])) $instance['twitter_widget_id'] = "";
		if(empty($instance['tweets_counts'])) $instance['tweets_counts'] = "";
		?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('twitter_widget_id'); ?>">Twitter Widget ID:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('twitter_widget_id'); ?>" name="<?php echo $this->get_field_name('twitter_widget_id'); ?>" value="<?php echo $instance['twitter_widget_id']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('tweets_counts'); ?>">Tweets Counts:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('tweets_counts'); ?>" name="<?php echo $this->get_field_name('tweets_counts'); ?>" value="<?php echo $instance['tweets_counts']; ?>" />
        </p>
    <?php
    }
}


/**
 * Register Trego_Tweets_Widget.
 */
add_action('widgets_init',
     create_function('', 'return register_widget("Trego_Tweets_Widget");')
);