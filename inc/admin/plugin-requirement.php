<?php
// Load the TGM Plugin Activation class
require_once get_template_directory() . '/inc/admin/class-tgm-plugin-activation.php';

function bihani_register_required_plugins() {
    $plugins = array(
        array(
            'name'               => 'Nepali Date Converter', // Plugin name
            'slug'               => 'nepali-date-converter', // Plugin slug (the plugin directory name)
            'required'           => true, // Set as true to make it required
        ),
    );

    $config = array(
        'id'           => 'bihani', // Unique ID for the theme
        'default_path' => '', // Default path to plugin (if not from WordPress.org)
        'menu'         => 'tgmpa-install-plugins', // Menu slug
        'has_notices'  => true, // Show notices for plugins
        'dismissable'  => false, // Prevent dismissing the notice
        'is_automatic' => true, // Auto-activate plugins
        'message'      => '', // Message to display
    );

    tgmpa($plugins, $config);
}

add_action('tgmpa_register', 'bihani_register_required_plugins');