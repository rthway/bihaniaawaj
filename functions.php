<?php
// Theme setup function
function bihani_theme_setup() {
    // Enable support for the document title tag
    add_theme_support('title-tag');

    // Enable support for featured images (post thumbnails)
    add_theme_support('post-thumbnails');

    // Enable support for custom logo upload
    add_theme_support('custom-logo');

    // Enable support for WordPress menus
    add_theme_support('menus');

    // Register navigation menus
    register_nav_menus([
        'primary' => __('Primary Menu', 'bihani'), // Primary navigation menu
        'footer'  => __('Footer Menu', 'bihani'),  // Footer navigation menu
    ]);
}
// Hook the setup function into the 'after_setup_theme' action
add_action('after_setup_theme', 'bihani_theme_setup');

// Enqueue styles and scripts
function bihani_enqueue_scripts() {
    // Enqueue Bootstrap CSS from CDN
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');

    // Enqueue main theme stylesheet
    wp_enqueue_style('bihani-style', get_stylesheet_uri());

    // Enqueue Bootstrap JS bundle (includes Popper) from CDN
    wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', [], null, true);

    // Enqueue Mukta font from Google Fonts
    wp_enqueue_style('mukta-font', 'https://fonts.googleapis.com/css2?family=Mukta:wght@400;500;600;700&display=swap', false);
}
// Hook the script and style enqueue function into 'wp_enqueue_scripts' action
add_action('wp_enqueue_scripts', 'bihani_enqueue_scripts');



// ==========================
// Header Ads and Social Links Customizer
// ==========================

// Customizer Settings for Header Ads and Social Links
function bihani_customize_register($wp_customize) {
    // Header Ad Section
    $wp_customize->add_section('header_ads', array(
        'title'    => __('Header Ads', 'bihani'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('header_ad_image', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'header_ad_image', array(
        'label'    => __('Header Ad Image (970x70)', 'bihani'),
        'section'  => 'header_ads',
        'settings' => 'header_ad_image',
    )));

    $wp_customize->add_setting('header_ad_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('header_ad_url', array(
        'label'    => __('Header Ad URL', 'bihani'),
        'section'  => 'header_ads',
        'type'     => 'url',
    ));

    // Social Links Section
    $wp_customize->add_section('social_links', array(
        'title'    => __('Social Links', 'bihani'),
        'priority' => 40,
    ));

    $social_networks = array('facebook', 'twitter', 'instagram', 'linkedin');

    foreach ($social_networks as $network) {
        $wp_customize->add_setting("{$network}_link", array(
            'default'           => '#',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control("{$network}_link", array(
            'label'   => ucfirst($network) . ' URL',
            'section' => 'social_links',
            'type'    => 'url',
        ));
    }
}
add_action('customize_register', 'bihani_customize_register');


// ==========================
// Custom bootstrap nav walker for dropdown menus
// ==========================
class Bootstrap_NavWalker extends Walker_Nav_Menu {
    function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
    }

    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'nav-item';

        if (in_array('menu-item-has-children', $classes)) {
            $classes[] = 'dropdown';
        }

        $class_names = join( ' ', array_filter( $classes ) );
        $class_names = ' class="' . esc_attr( $class_names ) . '"';

        $output .= "<li$class_names>";

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

        $atts['class'] = 'nav-link';
        if ($depth === 0 && in_array('menu-item-has-children', $classes)) {
            $atts['class'] .= ' dropdown-toggle';
            $atts['data-bs-toggle'] = 'dropdown';
        } elseif ($depth > 0) {
            $atts['class'] = 'dropdown-item';
        }

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= " $attr=\"$value\"";
            }
        }

        $title = apply_filters( 'the_title', $item->title, $item->ID );

        $output .= "<a$attributes>$title</a>";
    }

    function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= "</li>\n";
    }

    function end_lvl( &$output, $depth = 0, $args = null ) {
        $output .= "</ul>\n";
    }
}


// ==========================
// Count Post Views
// ==========================
function bihani_set_post_views($postID) {
    $count_key = 'bihani_post_views';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '1');
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

function bihani_get_post_views($postID) {
    $count_key = 'bihani_post_views';
    $count = get_post_meta($postID, $count_key, true);
    return $count ? $count . ' views' : '0 views';
}

remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

// ==========================
// Add View Count to Admin Column
// ==========================
function bihani_add_views_column($columns) {
    $columns['post_views'] = 'Views';
    return $columns;
}
add_filter('manage_posts_columns', 'bihani_add_views_column');

function bihani_display_views_column($column_name, $post_id) {
    if ($column_name === 'post_views') {
        $views = get_post_meta($post_id, 'bihani_post_views', true);
        echo $views ? $views : '0';
    }
}
add_action('manage_posts_custom_column', 'bihani_display_views_column', 10, 2);

// Sortable Views Column
function bihani_sortable_views_column($columns) {
    $columns['post_views'] = 'post_views';
    return $columns;
}
add_filter('manage_edit-post_sortable_columns', 'bihani_sortable_views_column');

function bihani_sort_views_column_query($query) {
    if (!is_admin()) return;

    if ($query->get('orderby') === 'post_views') {
        $query->set('meta_key', 'bihani_post_views');
        $query->set('orderby', 'meta_value_num');
    }
}
add_action('pre_get_posts', 'bihani_sort_views_column_query');

// ==========================
// Custom "Featured" Checkbox Field
// ==========================
function bihani_add_featured_meta_box() {
    add_meta_box(
        'bihani_featured_post',
        'Featured Post',
        'bihani_featured_meta_box_callback',
        'post',
        'side'
    );
}
add_action('add_meta_boxes', 'bihani_add_featured_meta_box');

function bihani_featured_meta_box_callback($post) {
    wp_nonce_field('bihani_save_featured_post', 'bihani_featured_post_nonce');
    $value = get_post_meta($post->ID, '_bihani_featured_post', true);
    ?>
    <label>
        <input type="checkbox" name="bihani_featured_post" <?php checked($value, 'yes'); ?> />
        Mark as Featured
    </label>
    <?php
}

function bihani_save_featured_post($post_id) {
    if (!isset($_POST['bihani_featured_post_nonce']) || !wp_verify_nonce($_POST['bihani_featured_post_nonce'], 'bihani_save_featured_post')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $is_featured = isset($_POST['bihani_featured_post']) ? 'yes' : 'no';
    update_post_meta($post_id, '_bihani_featured_post', $is_featured);
}
add_action('save_post', 'bihani_save_featured_post');

// ==========================
// Add Featured Column to Admin
// ==========================
function bihani_add_featured_column_custom($columns) {
    $columns['bihani_featured'] = __('Featured');
    return $columns;
}
add_filter('manage_posts_columns', 'bihani_add_featured_column_custom');

function bihani_display_featured_column_custom($column_name, $post_id) {
    if ($column_name === 'bihani_featured') {
        $value = get_post_meta($post_id, '_bihani_featured_post', true);
        echo $value === 'yes' ? 'Yes' : 'No';
    }
}
add_action('manage_posts_custom_column', 'bihani_display_featured_column_custom', 10, 2);

// Sortable Featured Column
function bihani_sortable_featured_column($columns) {
    $columns['bihani_featured'] = 'bihani_featured';
    return $columns;
}
add_filter('manage_edit-post_sortable_columns', 'bihani_sortable_featured_column');

function bihani_sort_featured_query($query) {
    if (!is_admin()) return;

    if ($query->get('orderby') === 'bihani_featured') {
        $query->set('meta_key', '_bihani_featured_post');
        $query->set('orderby', 'meta_value');
    }
}
add_action('pre_get_posts', 'bihani_sort_featured_query');


// ==========================
// compress uploaded image
// ==========================
function compress_uploaded_image($file) {
    $image_mime = $file['type'];
    $image_path = $file['tmp_name'];
    $image_ext  = pathinfo($file['name'], PATHINFO_EXTENSION);

    $quality = 75; // Set your desired compression quality (0-100)

    switch ($image_mime) {
        case 'image/jpeg':
        case 'image/jpg':
            $image = imagecreatefromjpeg($image_path);
            imagejpeg($image, $image_path, $quality);
            imagedestroy($image);
            break;

        case 'image/png':
            $image = imagecreatefrompng($image_path);
            // Convert to palette-based PNG (smaller)
            imagetruecolortopalette($image, true, 256);
            imagepng($image, $image_path, 9); // 0 (no compression) to 9
            imagedestroy($image);
            break;

        case 'image/webp':
            $image = imagecreatefromwebp($image_path);
            imagewebp($image, $image_path, $quality);
            imagedestroy($image);
            break;

        default:
            // Unsupported type (GIF, SVG, etc.) - do nothing
            break;
    }

    return $file;
}
add_filter('wp_handle_upload_prefilter', 'compress_uploaded_image');
