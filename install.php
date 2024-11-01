<?php
/*
 * Testimonials for WP installation functions
 * @since 1.0.0
 */

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * Flush the permalinks
 */
function testimonials_for_wp_flush_rewrites() {
	
	// Ensure post type is registered
	testimonials_for_wp_register_post_type();
	
	// Flush the permalinks
	flush_rewrite_rules();

}

/**
 * Register the testimonial post type
 * @since 1.0.0
 */
function testimonials_for_wp_register_post_type() {
	$labels = array(
		'name'               => _x( 'Testimonials', 'post type general name', 'testimonials-for-wp' ),
		'singular_name'      => _x( 'Testimonial', 'post type singular name', 'testimonials-for-wp' ),
		'menu_name'          => _x( 'Testimonials', 'admin menu', 'testimonials-for-wp' ),
		'name_admin_bar'     => _x( 'Testimonial', 'add new on admin bar', 'testimonials-for-wp' ),
		'add_new'            => _x( 'Add New', 'testimonial', 'testimonials-for-wp' ),
		'add_new_item'       => __( 'Add New Testimonial', 'testimonials-for-wp' ),
		'new_item'           => __( 'New Testimonial', 'testimonials-for-wp' ),
		'edit_item'          => __( 'Edit Testimonial', 'testimonials-for-wp' ),
		'view_item'          => __( 'View Testimonial', 'testimonials-for-wp' ),
		'all_items'          => __( 'All Testimonials', 'testimonials-for-wp' ),
		'search_items'       => __( 'Search Testimonials', 'testimonials-for-wp' ),
		'parent_item_colon'  => __( 'Parent Testimonial:', 'testimonials-for-wp' ),
		'not_found'          => __( 'No testimonials found.', 'testimonials-for-wp' ),
		'not_found_in_trash' => __( 'No testimonials found in Trash.', 'testimonials-for-wp' )
	);
	$args = array(
		'labels'            => $labels,
		'description'       => __( 'Description.', 'testimonials-for-wp' ),
		'public'            => false,
		'publicly_queryable'=> true,
		'show_ui'           => true,
		'show_in_menu'      => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'testimonial' ),
		'capability_type'   => 'post',
		'menu_icon'			=> 'dashicons-format-quote',
		'has_archive'       => true,
		'hierarchical'      => false,
		'menu_position'     => null,
		'supports'          => array( 'title', 'editor', 'thumbnail' )
	);
	register_post_type( 'testimonial', $args );
}