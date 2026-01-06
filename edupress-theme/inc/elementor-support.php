<?php
/**
 * Elementor Support for Header & Footer
 *
 * @package EduPress
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Check if Elementor is active
 */
function edupress_is_elementor_active() {
    return did_action('elementor/loaded');
}

/**
 * Render Elementor Header
 */
function edupress_elementor_header() {
    if (get_option('edupress_use_elementor_header') && edupress_is_elementor_active()) {
        $header_id = get_option('edupress_elementor_header_id');

        if ($header_id) {
            echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display($header_id);
            return true;
        }
    }
    return false;
}

/**
 * Render Elementor Footer
 */
function edupress_elementor_footer() {
    if (get_option('edupress_use_elementor_footer') && edupress_is_elementor_active()) {
        $footer_id = get_option('edupress_elementor_footer_id');

        if ($footer_id) {
            echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display($footer_id);
            return true;
        }
    }
    return false;
}

/**
 * Add Elementor Support
 */
function edupress_add_elementor_support() {
    add_theme_support('elementor');
}
add_action('after_setup_theme', 'edupress_add_elementor_support');

/**
 * Register Elementor Locations (if Elementor Pro is active)
 */
function edupress_register_elementor_locations($elementor_theme_manager) {
    $elementor_theme_manager->register_location('header');
    $elementor_theme_manager->register_location('footer');
}
if (class_exists('\ElementorPro\Plugin')) {
    add_action('elementor/theme/register_locations', 'edupress_register_elementor_locations');
}
