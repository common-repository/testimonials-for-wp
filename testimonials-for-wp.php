<?php
/*
Plugin Name: Testimonials for WP
Plugin URI: https://testimonials.catapultthemes.com/
Description: Testimonials for WordPress
Version: 1.0.1
Author: Catapult Themes
Author URI: https://catapultthemes.com/
Text Domain: testimonials-for-wp
Domain Path: /languages
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function testimonials_for_wp_load_plugin_textdomain() {
    load_plugin_textdomain( 'testimonials-for-wp', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'testimonials_for_wp_load_plugin_textdomain' );

/**
 * Define constants
 **/
if ( ! defined( 'TESTIMONIALS_FOR_WP_PLUGIN_URL' ) ) {
	define( 'TESTIMONIALS_FOR_WP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}
if ( ! defined( 'TESTIMONIALS_FOR_WP_PLUGIN_VERSION' ) ) {
	define( 'TESTIMONIALS_FOR_WP_PLUGIN_VERSION', '1.0.1' );
}

/**
 * Load her up.
 **/
require_once dirname( __FILE__ ) . '/install.php';
register_activation_hook( __FILE__, 'testimonials_for_wp_flush_rewrites' );

add_action( 'init', 'testimonials_for_wp_register_post_type' );

function testimonials_for_wp_admin() {
	
	require_once dirname( __FILE__ ) . '/admin/metaboxes.php';
	require_once dirname( __FILE__ ) . '/admin/class-testimonials-for-wp-metaboxes.php';
	$metaboxes = testimonials_for_wp_metaboxes();
	$Testimonials_For_WP_Metaboxes = new Testimonials_For_WP_Metaboxes( $metaboxes );
	$Testimonials_For_WP_Metaboxes -> init();
}
// We call this after the init hook in order to ensure post types have been registered
if ( is_admin() ) {
	require_once dirname( __FILE__ ) . '/admin/admin-settings-callbacks.php';
	require_once dirname( __FILE__ ) . '/admin/admin-settings.php';
	require_once dirname( __FILE__ ) . '/admin/class-testimonials-for-wp-admin.php';
	add_action( 'admin_init', 'testimonials_for_wp_admin', 10 );
}

/**
 * Functions.
 **/
require_once dirname( __FILE__ ) . '/inc/functions-testimonials.php';