<?php 

/**
 * Returns array of metaboxes
 * @return Array
 * @since 1.0.0
 */
function testimonials_for_wp_metaboxes() {
		
	$metaboxes = array(
		array(
			'ID'			=> 'testimonials_for_wp_metabox',
			'title'			=> __( 'Testimonials Meta', 'testimonials-for-wp' ),
			'callback'		=> 'meta_box_callback',
			'screens'		=> array( 'testimonial' ),
			'context'		=> 'side',
			'priority'		=> 'default',
			'fields'		=> array(
				array (
					'ID'		=> 'testimonials_for_wp_featured',
					'name'		=> 'testimonials_for_wp_featured',
					'title'		=> __( 'Featured', 'testimonials-for-wp' ),
					'type'		=> 'checkbox',
					'class'		=> '',
					'description'	=> ''
				),
				array(
					'ID'		=> 'testimonials_for_wp_position',
					'name'		=> 'testimonials_for_wp_position',
					'title'		=> __( 'Position', 'testimonials-for-wp' ),
					'type'		=> 'text',
					'class'		=> ''
				),
				array(
					'ID'		=> 'testimonials_for_wp_company',
					'name'		=> 'testimonials_for_wp_company',
					'title'		=> __( 'Company', 'testimonials-for-wp' ),
					'type'		=> 'text',
					'class'		=> ''
				),
				array (
					'ID'		=> 'testimonials_for_wp_email',
					'name'		=> 'testimonials_for_wp_email',
					'title'		=> __( 'Email', 'testimonials-for-wp' ),
					'type'		=> 'text',
					'class'		=> '',
					'description'	=> __( 'Won\'t be displayed but used to generate gravatar', 'testimonials-for-wp' )
				),
				array (
					'ID'		=> 'testimonials_for_wp_gravatar',
					'name'		=> 'testimonials_for_wp_gravatar',
					'title'		=> __( 'Gravatar URL', 'testimonials-for-wp' ),
					'type'		=> 'text',
					'class'		=> '',
					'description'	=> __( 'A direct link to a user\'s gravatar image', 'testimonials-for-wp' )
				),
				array (
					'ID'		=> 'testimonials_for_wp_date',
					'name'		=> 'testimonials_for_wp_date',
					'title'		=> __( 'Date', 'testimonials-for-wp' ),
					'type'		=> 'text',
					'class'		=> '',
					'description'	=> ''
				),
				/*
				array (
					'ID'		=> 'testimonials_for_wp_stars',
					'name'		=> 'testimonials_for_wp_stars',
					'title'		=> __( 'Stars', 'testimonials-for-wp' ),
					'type'		=> 'select',
					'options'	=> array(
						''		=> '',
						1		=> '1',
						2		=> '2',
						3		=> '3',
						4		=> '4',
						5		=> '5',
					),
					'class'		=> '',
					'description'	=> ''
				), */
				
			),
		),
	);
	
	$metaboxes = apply_filters( 'testimonials_for_wp_filter_metaboxes', $metaboxes );
	
	return $metaboxes;
	
}
