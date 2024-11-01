<?php
/**
 * Functions and data for the admin
 * Includes our settings
 *
 * @since 1.0.0
 */

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns an array of settings
 *
 * @since 1.0.0
 * @returns Array
 */
if( ! function_exists( 'testimonials_for_wp_settings' ) ) {
	function testimonials_for_wp_settings() {
		
		$settings = array(
			'style' => array(
				'id'			=> 'style',
				'label'			=> __( 'Testimonial style', 'testimonials-for-wp' ),
				'callback'		=> 'testimonials_for_wp_select_callback',
				'choices'		=> array(
					'cards'		=> __( 'Cards', 'testimonials-for-wp' ),
					'quotes'	=> __( 'Quotes', 'testimonials-for-wp' ),
					'simple'	=> __( 'Simple', 'testimonials-for-wp' ),
				),
				'description'	=> '',
				'page'			=> 'testimonials_for_wp_options',
				'section'		=> 'testimonials_for_wp_options_settings',
			),
			'layout' => array(
				'id'			=> 'layout',
				'label'			=> __( 'Testimonials layout', 'testimonials-for-wp' ),
				'callback'		=> 'testimonials_for_wp_select_callback',
				'choices'		=> array(
					'grid'		=> __( 'Grid', 'testimonials-for-wp' ),
					'masonry'	=> __( 'Masonry', 'testimonials-for-wp' )
				),
				'description'	=> '',
				'page'			=> 'testimonials_for_wp_options',
				'section'		=> 'testimonials_for_wp_options_settings',
			),
			'columns' => array(
				'id'			=> 'columns',
				'label'			=> __( 'Columns', 'testimonials-for-wp' ),
				'callback'		=> 'testimonials_for_wp_select_callback',
				'choices'		=> array(
					'1'	=> '1',
					'2'	=> '2',
					'3'	=> '3',
					'4'	=> '4'
				),
				'description'	=> '',
				'page'			=> 'testimonials_for_wp_options',
				'section'		=> 'testimonials_for_wp_options_settings',
			),
		);
		
		
		$settings = apply_filters( 'testimonials_for_wp_settings', $settings );
		
		return $settings;
	}

}