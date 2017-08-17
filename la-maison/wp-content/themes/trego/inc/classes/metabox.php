<?php

class Ef_meta_box {
 
    protected $_meta_box;
 
    // create meta box based on given data
    function __construct($meta_box) {
        $this->_meta_box = $meta_box;
        add_action('admin_menu', array(&$this, 'add'));
 
        add_action('save_post', array(&$this, 'save'));
    }
 
    /// Add meta box for multiple post types
    function add() {
        $post_types = $this->_meta_box['post_types'];
        if ( empty($post_types) )
            return;
        if ( is_string($post_types) )
            $post_types = array($post_types);
        foreach ($post_types as $post_type) {
            add_meta_box($this->_meta_box['id'], $this->_meta_box['title'], array(&$this, 'show'), $post_type, $this->_meta_box['context'], $this->_meta_box['priority']);
        }
    }
 
    // Callback function to show fields in meta box
    function show() {
        global $post;
 
        // Use nonce for verification
       
        echo '<input type="hidden" name="trego_meta_box_nonce" value="'. wp_create_nonce(basename(__FILE__)). '" />';
 
        foreach ($this->_meta_box['fields'] as $field) {
            // get current post meta data
            $meta = get_post_meta($post->ID, $field['id'], true);
			if($field['type'] != 'htmleditor') {
            	echo '<p id="'. $field['id'] .'_label"><strong>'. $field['name']. '</strong></p>';
			}

			if(empty($field['std'])) $field['std'] = "";
			if(empty($field['desc'])) $field['desc'] = "";

            switch ($field['type']) {
                case 'text':
                    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />',
                        '<br />', $field['desc'];
                    break;
                case 'textarea':
                    echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>',
                        '<br />', $field['desc'];
                    break;
                case 'select':
                    echo '<select name="', $field['id'], '" id="', $field['id'], '">';
                    foreach ($field['options'] as $option) {
                        echo '<option ', $meta == $option ? ' selected="selected"' : '',  '>', $option, '</option>';
                    }
                    echo '</select>';
                    break;
                case 'radio':
                    foreach ($field['options'] as $option) {
                        echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];
                    }
                    break;

                case 'checkbox':
                    echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
                    break;

                case 'htmleditor':
                	$settings = array(
                		'textarea_rows' => 10
                	);
                    wp_editor($meta ? $meta : $field['std'], $field['id'], $settings);
                    break;
            }
        }
    }
 
    function save($post_id) {
		if(empty($_POST['trego_meta_box_nonce'])){
			$_POST['trego_meta_box_nonce'] = '';
		}
        if (!wp_verify_nonce($_POST['trego_meta_box_nonce'], basename(__FILE__))) {
            return $post_id;
        }
 
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }
 
        if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }
 
        foreach ($this->_meta_box['fields'] as $field) {
            $old = get_post_meta($post_id, $field['id'], true);
            $new = $_POST[$field['id']];

			if($field['type'] == 'htmleditor'){
				$fix = array (
					'<br>' => '', 
					'<br/>' => '',
					'<br />' => '',
					'&nbsp;' => '',
					'<p>' => '',
					'</p>' => '',
					'<p></p>' => '',
					'<p>[' => '[',
					']</p>' => ']',
					']<br/>' => ']',
					']<br />' => ']'
				);

				$content = trim(strtr($new, $fix));
				if(empty($content)){
					$new = '';
				}
			}
 
            if ($new && $new != $old) {
                update_post_meta($post_id, $field['id'], $new);
            } elseif ('' == $new && $old) {
                delete_post_meta($post_id, $field['id'], $old);
            }
        }
    }
}