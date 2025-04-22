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

