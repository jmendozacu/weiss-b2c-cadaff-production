<?php
// add custom menu fields to menu
add_filter( 'wp_setup_nav_menu_item', 'trego_add_custom_nav_fields' );

function trego_add_custom_nav_fields( $menu_item ) {
	$menu_item->nolink = (isset($menu_item->ID)) ? get_post_meta( $menu_item->ID, '_menu_item_nolink', true ) : '';
	$menu_item->hide = (isset($menu_item->ID)) ? get_post_meta( $menu_item->ID, '_menu_item_hide', true ) : '';
	$menu_item->type_menu = (isset($menu_item->ID)) ? get_post_meta( $menu_item->ID, '_menu_item_type_menu', true ) : '';
	$menu_item->pos = (isset($menu_item->ID)) ? get_post_meta( $menu_item->ID, '_menu_item_pos', true ) : '';
	$menu_item->column = (isset($menu_item->ID)) ? get_post_meta( $menu_item->ID, '_menu_item_column', true ) : '';

    return $menu_item;
}

// save menu custom fields
add_action( 'wp_update_nav_menu_item', 'trego_update_custom_nav_fields', 10, 3 );

function trego_update_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {
    $check = array('nolink', 'hide', 'type_menu', 'pos', 'column');

    foreach ( $check as $key )
    {
        if(!isset($_POST['menu-item-'.$key][$menu_item_db_id]))
        {
            $_POST['menu-item-'.$key][$menu_item_db_id] = "";
        }
        
        $value = $_POST['menu-item-'.$key][$menu_item_db_id];
        update_post_meta( $menu_item_db_id, '_menu_item_'.$key, $value );
    }
}

// edit menu walker
add_filter( 'wp_edit_nav_menu_walker', 'trego_edit_walker', 10, 2 );

function trego_edit_walker($walker,$menu_id) {
    return 'Walker_Nav_Menu_Edit_Custom';
}

// Create HTML list of nav menu input items.
// Extend from Walker_Nav_Menu class
class Walker_Nav_Menu_Edit_Custom extends Walker_Nav_Menu  {
    /**
     * @see Walker_Nav_Menu::start_lvl()
     * @since 3.0.0
     *
     * @param string $output Passed by reference.
     */
    function start_lvl( &$output, $depth = 0, $args = array() ) {    
    }
    
    /**
     * @see Walker_Nav_Menu::end_lvl()
     * @since 3.0.0
     *
     * @param string $output Passed by reference.
     */
    function end_lvl( &$output, $depth = 0, $args = array() ) {
    }
    
    /**
     * @see Walker::start_el()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item Menu item data object.
     * @param int $depth Depth of menu item. Used for padding.
     * @param object $args
     */
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        global $_wp_nav_menu_max_depth;

        $_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;
    
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
    
        $item_id = esc_attr( $item->ID );
        $removed_args = array(
            'action',
            'customlink-tab',
            'edit-menu-item',
            'menu-item',
            'page-tab',
            '_wpnonce',
        );
        ob_start();
        $original_title = '';
        if ( 'taxonomy' == $item->type ) {
            $original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
            if ( is_wp_error( $original_title ) )
                $original_title = false;
        } elseif ( 'post_type' == $item->type ) {
            $original_object = get_post( $item->object_id );
            if(is_object($original_object)){
            	$original_title = $original_object->post_title;
            } else {
				$original_title = '';
            }
        }
    
        $classes = array(
            'menu-item menu-item-depth-' . $depth,
            'menu-item-' . esc_attr( $item->object ),
            'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
        );
    
        $title = $item->title;
    
        if ( ! empty( $item->_invalid ) ) {
            $classes[] = 'menu-item-invalid';
            /* translators: %s: title of menu item which is invalid */
            $title = sprintf( __( '%s (Invalid)', 'trego' ), $item->title );
        } elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
            $classes[] = 'pending';
            /* translators: %s: title of menu item in draft status */
            $title = sprintf( __('%s (Pending)', 'trego'), $item->title );
        }

        $title = empty( $item->label ) ? $title : $item->label;
        
        ?>
        <li id="menu-item-<?php echo $item_id; ?>" class="<?php echo implode(' ', $classes ); ?>">
            <dl class="menu-item-bar">
                <dt class="menu-item-handle">
                    <span class="item-title"><?php echo esc_html( $title ); ?></span>
                    <span class="item-controls">
                        <span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
                        <span class="item-order hide-if-js">
                            <a href="<?php
                                echo wp_nonce_url(
                                    add_query_arg(
                                        array(
                                            'action' => 'move-up-menu-item',
                                            'menu-item' => $item_id,
                                        ),
                                        remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                    ),
                                    'move-menu_item'
                                );
                            ?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up', 'trego'); ?>">&#8593;</abbr></a>
                            |
                            <a href="<?php
                                echo wp_nonce_url(
                                    add_query_arg(
                                        array(
                                            'action' => 'move-down-menu-item',
                                            'menu-item' => $item_id,
                                        ),
                                        remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                    ),
                                    'move-menu_item'
                                );
                            ?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down', 'trego'); ?>">&#8595;</abbr></a>
                        </span>
                        <a class="item-edit" id="edit-<?php echo $item_id; ?>" title="<?php esc_attr_e('Edit Menu Item', 'trego'); ?>" href="<?php
                            echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
                        ?>"><?php _e( 'Edit Menu Item', 'trego' ); ?></a>
                    </span>
                </dt>
            </dl>
            
            <div class="menu-item-settings" id="menu-item-settings-<?php echo $item_id; ?>">
                <?php if( 'custom' == $item->type ) : ?>
                <p class="field-url description description-wide">
                    <label for="edit-menu-item-url-<?php echo $item_id; ?>">
                        <?php _e( 'URL', 'trego' ); ?><br />
                        <input type="text" id="edit-menu-item-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
                    </label>
                </p>
                <?php endif; ?>
                <p class="description description-thin">
                    <label for="edit-menu-item-title-<?php echo $item_id; ?>">
                        <?php _e( 'Navigation Label', 'trego' ); ?><br />
                        <input type="text" id="edit-menu-item-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
                    </label>
                </p>
                <p class="description description-thin">
                    <label for="edit-menu-item-attr-title-<?php echo $item_id; ?>">
                        <?php _e( 'Title Attribute', 'trego' ); ?><br />
                        <input type="text" id="edit-menu-item-attr-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
                    </label>
                </p>
                <p class="field-link-target description">
                    <label for="edit-menu-item-target-<?php echo $item_id; ?>">
                        <input type="checkbox" id="edit-menu-item-target-<?php echo $item_id; ?>" value="_blank" name="menu-item-target[<?php echo $item_id; ?>]"<?php checked( $item->target, '_blank' ); ?> />
                        <?php _e( 'Open link in a new window/tab', 'trego' ); ?>
                    </label>
                </p>
                <p class="field-css-classes description description-thin">
                    <label for="edit-menu-item-classes-<?php echo $item_id; ?>">
                        <?php _e( 'CSS Classes (optional)', 'trego' ); ?><br />
                        <input type="text" id="edit-menu-item-classes-<?php echo $item_id; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item_id; ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
                    </label>
                </p>
                <p class="field-xfn description description-thin">
                    <label for="edit-menu-item-xfn-<?php echo $item_id; ?>">
                        <?php _e( 'Link Relationship (XFN)', 'trego' ); ?><br />
                        <input type="text" id="edit-menu-item-xfn-<?php echo $item_id; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
                    </label>
                </p>
                <p class="field-description description description-wide">
                    <label for="edit-menu-item-description-<?php echo $item_id; ?>">
                        <?php _e( 'Description', 'trego' ); ?><br />
                        <textarea id="edit-menu-item-description-<?php echo $item_id; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item_id; ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
                        <span class="description"><?php _e('The description will be displayed in the menu if the current theme supports it.', 'trego'); ?></span>
                    </label>
                </p>
                <?php
                /* New fields insertion starts here */
                ?>
                <p class="field-custom description description-wide">
                <?php
                    $value = $item->nolink;
                    if($value != "") $value = "checked='checked'";
                ?>
                    <label for="edit-menu-item-nolink-<?php echo $item_id; ?>">
                        <input type="checkbox" id="edit-menu-item-nolink-<?php echo $item_id; ?>" class="code edit-menu-item-custom" name="menu-item-nolink[<?php echo $item_id; ?>]" value="nolink" <?php echo $value; ?> />
                        <?php _e( "Don't link", 'trego' ); ?>
                    </label>
                </p>
                <p class="field-custom description description-wide">
                <?php
                    $value = $item->hide;
                    if($value != "") $value = "checked='checked'";
                ?>
                    <label for="edit-menu-item-hide-<?php echo $item_id; ?>">
                        <input type="checkbox" id="edit-menu-item-hide-<?php echo $item_id; ?>" class="code edit-menu-item-custom" name="menu-item-hide[<?php echo $item_id; ?>]" value="hide" <?php echo $value; ?> />
                        <?php _e( "Don't show", 'trego' ); ?>
                    </label>
                </p>

				<?php if(!$depth) : ?>
                <p class="field-custom description description-thin description-thin-custom">
                    <label for="edit-menu-item-type-menu-<?php echo $item_id; ?>">
                        <?php _e( 'Type', 'trego' ); ?><br />
                        <select id="edit-menu-item-type-menu-<?php echo $item_id; ?>" name="menu-item-type_menu[<?php echo $item_id; ?>]">
                            <option value="" <?php if(esc_attr($item->type_menu) == ""){echo 'selected="selected"';} ?>><?php _e('narrow', 'trego') ?></option>
                            <option value="wide" <?php if(esc_attr($item->type_menu) == "wide"){echo 'selected="selected"';} ?>><?php _e('wide', 'trego') ?></option>
                        </select>           
                    </label>
                </p>
                <p class="field-custom description description-thin description-thin-custom">
                    <label for="edit-menu-item-pos-<?php echo $item_id; ?>">
                        <?php _e( 'Popup Position', 'trego' ); ?><br />
                        <select id="edit-menu-item-pos-<?php echo $item_id; ?>" name="menu-item-pos[<?php echo $item_id; ?>]">
                            <option value="" <?php if(esc_attr($item->pos) == ""){echo 'selected="selected"';} ?>><?php _e('Justify', 'trego') ?></option>
                            <option value="pos-left" <?php if(esc_attr($item->pos) == "pos-left"){echo 'selected="selected"';} ?>><?php _e('Left', 'trego') ?></option>
                            <option value="pos-center" <?php if(esc_attr($item->pos) == "pos-center"){echo 'selected="selected"';} ?>><?php _e('Center', 'trego') ?></option>
                            <option value="pos-right" <?php if(esc_attr($item->pos) == "pos-right"){echo 'selected="selected"';} ?>><?php _e('Right', 'trego') ?></option>
                        </select>           
                    </label>
                </p>
                <p class="field-custom description description-thin description-thin-custom">
                    <label for="edit-menu-item-column-<?php echo $item_id; ?>">
                        <?php _e( 'Column', 'trego' ); ?><br />
                        <select id="edit-menu-item-column-<?php echo $item_id; ?>" name="menu-item-column[<?php echo $item_id; ?>]">
                            <option value="col-4" <?php if(esc_attr($item->column) == "col-4"){echo 'selected="selected"';} ?>><?php _e('4 Columns', 'trego') ?></option>
                            <option value="col-3" <?php if(esc_attr($item->column) == "col-3"){echo 'selected="selected"';} ?>><?php _e('3 Columns', 'trego') ?></option>
                            <option value="col-2" <?php if(esc_attr($item->column) == "col-2"){echo 'selected="selected"';} ?>><?php _e('2 Columns', 'trego') ?></option>
                            <option value="col-1" <?php if(esc_attr($item->column) == "col-1"){echo 'selected="selected"';} ?>><?php _e('1 Columns', 'trego') ?></option>
                        </select>           
                    </label>
                </p>
				<?php endif; ?>

                <?php
                /* New fields insertion ends here */
                ?>
                <div class="menu-item-actions description-wide submitbox">
                <?php if( 'custom' != $item->type && $original_title !== false ) : ?>
                    <p class="link-to-original">
                        <?php printf( __('Original: %s', 'trego'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
                    </p>
                <?php endif; ?>
                    <a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id; ?>" href="<?php
                    echo wp_nonce_url(
                        add_query_arg(
                            array(
                                'action' => 'delete-menu-item',
                                'menu-item' => $item_id,
                            ),
                            remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                        ),
                        'delete-menu_item_' . $item_id
                    ); ?>"><?php _e('Remove', 'trego'); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo $item_id; ?>" href="<?php echo esc_url( add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ) );
                    ?>#menu-item-settings-<?php echo $item_id; ?>"><?php _e('Cancel', 'trego'); ?></a>
                </div>
    
                <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>" />
                <input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
                <input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
                <input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
                <input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
                <input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
            </div><!-- .menu-item-settings-->
            <ul class="menu-item-transport"></ul>
        </li>
        <?php
        $output .= ob_get_clean();        
    }
}

/* Top Navigation Menu */
if (!class_exists('trego_top_navwalker')) {
class trego_top_navwalker extends Walker_Nav_Menu {

    // add classes to ul sub menus
    function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
        $id_field = $this->db_fields['id'];
        if ( is_object( $args[0] ) ) {
            $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
        }
        return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }

    // add popup class to ul sub-menus
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        if ( $depth == 0 ) {
            $out_div = '<div class="popup"><div class="inner">';
        } else {
            $out_div = '';
        }
        $output .= "\n$indent$out_div<ul class=\"sub-menu\">\n";
    }
    
    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        if ( $depth == 0 ) {
            $out_div_close = '</div></div>';
        } else {
            $out_div_close = '';
        }
        $output .= "$indent</ul>$out_div_close\n";
    }

    // add main/sub classes to li's and links
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        global $wp_query;

        $sub = "";
        $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
        if ( $depth == 0 && $args->has_children ) 
            $sub = ' has-sub';
        
        if ( $depth == 1 && $args->has_children ) 
            $sub = ' sub';
        
        $active = "";
        
        // depth dependent classes
        if ( $item->current && $depth == 0 )
            $active = 'active';
        
        // passed classes
        $classes = empty( $item->classes ) ? array() : (array)$item->classes;
        
        $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );
        
        // menu type, type, column class
        $menu_type = "";
        $pos = "";
        $column = "";
        if ($depth == 0) {
            if ($item->type_menu == "wide") {
                $menu_type = " wide";
                $column = " ". $item->column;
            } else {
                $menu_type = " narrow";
            }
            $pos = " ". $item->pos;
        }
        
        // build html
        $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $class_names . ' ' . $active . $sub . $menu_type . $pos . $column .'">';
        
        $current_a = "";
        
        // link attributes
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        
        if ( ( $item->current && $depth == 0 ) ||  ( $item->current_item_ancestor && $depth == 0 ) )
            $current_a .= ' current ';
        
        $attributes .= ' class="'. $current_a . '"';
        $item_output = $args->before;
        if ( $item->hide == "" ) {
            if ( $item->nolink == "" ) {
                $item_output .= '<a'. $attributes .' title="'.apply_filters( 'the_title', $item->title, $item->ID ).'">';
            } else{
                $item_output .= '<h5 title="'.apply_filters( 'the_title', $item->title, $item->ID ).'">';
            }
            $item_output .= $args->link_before .apply_filters( 'the_title', $item->title, $item->ID );
            $item_output .= $args->link_after;
            if ( $item->nolink == "" ) {
                $item_output .= '</a>';
            } else {
                $item_output .= '</h5>';
            }
        }
        $item_output .= $args->after;
        
        // build html
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}
}

/* Accordion Menu */
if (!class_exists('trego_accordion_navwalker')) {
class trego_accordion_navwalker extends Walker_Nav_Menu {
    
    // add classes to ul sub menus
    function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
        $id_field = $this->db_fields['id'];
        if ( is_object( $args[0] ) ) {
            $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
        }
        return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }

    // add main/sub classes to li's and links
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu\">\n";
    }
    
    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    // add main/sub classes to li's and links
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        
        global $wp_query;

        $sub = "";
        $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
        if ( ( $depth >= 0 && $args->has_children ) || ( $depth >= 0 && $item->recentpost != "" ) )
            $sub = ' has-sub';
        
        $active = "";
        // depth dependent classes
        if ( ( ( $item->current && $depth == 0 ) || ( $item->current_item_ancestor && $depth == 0 ) ) )
            $active = 'active';
            
        // passed classes
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        
        $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );
        
        // build html
        $output .= $indent . '<li id="accordion-menu-item-'. $item->ID . '" class="' . $class_names . ' ' . $active . $sub .'">';
        
        $current_a = "";
        
        // link attributes
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        if ( ( $item->current && $depth == 0 ) || ( $item->current_item_ancestor && $depth == 0 ) )
            $current_a .= ' current ';
        
        $attributes .= ' class="'. $current_a . '"';
        $item_output = $args->before;
        if ( $item->hide == "" ) {
            if ( $item->nolink == "" ) {
                $item_output .= '<a'. $attributes .'>';
            } else {
                $item_output .= '<h5>';
            }
            $item_output .= $args->link_before .apply_filters( 'the_title', $item->title, $item->ID );
            $item_output .= $args->link_after;
            if ( $item->nolink == "" ) {
                $item_output .= '</a><span class="arrow"></span>';
            } else {
                $item_output .= '</h5><span class="arrow"></span>';
            }
        }
        $item_output .= $args->after;
        
        // build html
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}
}



