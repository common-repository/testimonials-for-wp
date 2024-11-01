<?php
/**
 * Testimonials functions
 */

function testimonials_for_wp_enqueue_scripts() {
	wp_enqueue_script( 'jquery-masonry', '', array( 'jquery' ) );
	wp_enqueue_style( 'testimonials-for-wp-style', TESTIMONIALS_FOR_WP_PLUGIN_URL . '/assets/css/style.css' );
}
add_action( 'wp_enqueue_scripts', 'testimonials_for_wp_enqueue_scripts' );

/**
 * Get the testimonials style
 * @since 1.0.0
 * @return String
 */
function testimonials_for_wp_get_style() {
	$options = get_option( 'testimonials_for_wp_options_settings' );
	if( isset( $options['style'] ) ) {
		return $options['style'];
	}
	return 'cards';
}

/**
 * Get the testimonials layout
 * @since 1.0.0
 * @return String
 */
function testimonials_for_wp_get_layout() {
	$options = get_option( 'testimonials_for_wp_options_settings' );
	if( isset( $options['layout'] ) ) {
		return $options['layout'];
	}
	return 'grid';
}

/**
 * Check if we're using masonry
 * @since 1.0.0
 * @param $layout
 * @return Boolean
 */
function testimonials_for_wp_is_masonry_layout( $layout='' ) {
	if( empty( $layout ) ) {
		$layout = testimonials_for_wp_get_layout();
	}
	if( $layout == 'masonry' ) {
		return true;
	}
	return false;
}

/**
 * Get the testimonials columns
 * @since 1.0.0
 * @return String
 */
function testimonials_for_wp_get_columns() {
	$options = get_option( 'testimonials_for_wp_options_settings' );
	if( isset( $options['columns'] ) ) {
		return $options['columns'];
	}
	return '2';
}

/**
 * Get the testimonial content
 * @since 1.0.0
 * @return HTML
 */
if( ! function_exists( 'testimonials_for_wp_get_testimonial' ) ) {
	function testimonials_for_wp_get_testimonial( $post_id, $style ) {

		$content = wpautop( testimonials_for_wp_get_content( $post_id ) );
		$thumbnail = testimonials_for_wp_get_image( $post_id );
		
		$date = get_post_meta( $post_id, 'testimonials_for_wp_date', true );
		if( ! empty( $date ) ) {
			$date = sprintf( '<span class="testimonial-date">%s</span>', esc_html( $date ) );
		}
		
		$position = get_post_meta( $post_id, 'testimonials_for_wp_position', true );
		$company = get_post_meta( $post_id, 'testimonials_for_wp_company', true );
		// Create a string for position and company
		$status = '';
		if( ! empty( $position ) ) {
			$status = $position;
		}
		if( ! empty( $position ) && ! empty( $company ) ) {
			$status .= ', ';
		}
		if( ! empty( $company ) ) {
			$status .= $company;
		}
		
		
		// Build the testimonial depending on its style
		$title = get_the_title();
		
		if( $style == 'quotes' ) {
			// Quotes style
			$testimonial = sprintf( 
				'<div class="testimonial-content">%s</div><div class="testimonial-meta"><div class="testimonial-avatar">%s</div><div class="testimonial-meta-inner"><span class="title">%s</span><span class="position">%s</span><span class="date">%s</span></div></div>',
				$content,
				$thumbnail,
				$title,
				$status,
				$date
			);
		} else if( $style == 'simple' ) {
			// Simple style
			$testimonial = sprintf( 
				'<div class="testimonial-content">%s</div><div class="testimonial-meta"><div class="testimonial-avatar">%s</div><div class="testimonial-meta-inner"><span class="title">%s</span><span class="position">%s</span><span class="date">%s</span></div></div>',
				$content,
				$thumbnail,
				$title,
				$status,
				$date
			);
		} else {
			// Cards is the default
			$testimonial = sprintf( 
				'<span class="testimonial-avatar">%s</span><div class="testimonial-content">%s</div><div class="testimonial-meta"><span class="title">%s</span><span class="position">%s</span><span class="date">%s</span></div>',
				$thumbnail,
				$content,
				$title,
				$status,
				$date
			);
		}
		
		$testimonial = apply_filters( 'testimonials_for_wp_filter_testimonial', $testimonial, $thumbnail, $content, $title, $position, $company, $date );
		
		return $testimonial;
	}
}

/**
 * Get the testimonial content
 * @since 1.0.0
 * @return String
 */
if( ! function_exists( 'testimonials_for_wp_get_content' ) ) {
	function testimonials_for_wp_get_content( $post_id=null ) {
		$post = get_post( $post_id );
		if( isset( $post->post_content ) ) {
			return $post->post_content;
		}
		return '';
	}
}

/**
 * Get the testimonial image
 * @since 1.0.0
 * @return HTML
 */
if( ! function_exists( 'testimonials_for_wp_get_image' ) ) {
	function testimonials_for_wp_get_image( $post_id=null ) {
		
		$email = get_post_meta( $post_id, 'testimonials_for_wp_email', true );
		$gravatar = get_post_meta( $post_id, 'testimonials_for_wp_gravatar', true );
		if( has_post_thumbnail() ) {
			// The featured image is first priority
			return get_the_post_thumbnail( $post_id, 'thumbnail' );
		} else if( ! empty( $gravatar ) ) {
			// Next in line is a direct link to the gravatar image
			$image = '<img src="' . esc_url( $gravatar ) . '">';
			return $image;
		} else if( ! empty( $email ) ) {
			// Next in line is to grab the gravatar using the email address
			$avatar = get_avatar( $email );
			return $avatar;
		} else {
			// Return blank avatar
			$avatar = get_avatar( 0 );
			return $avatar;
		}
		return '';
	}
}

/**
 * Print testimonials
 * @since 1.0.0
 * @param $number	Number of testimonials to display
 * @param $featured	Whether to show only featured testimonials
 * @param $ids		Comma separated list of testimonial IDs
 */
if( ! function_exists( 'testimonials_for_wp_get_testimonials' ) ) {
	function testimonials_for_wp_get_testimonials( $number=-1, $featured=false, $ids='', $style ) {
		global $post;
		
		$args = array(
			'post_type'			=> 'testimonial',
			'posts_per_page'	=> $number
		);
		if( $featured ) {
			$args['meta_key'] = 'testimonials_for_wp_featured';
			$args['meta_value'] = true;
		}
		if( ! empty( $ids ) ) {
			// $ids should comma separated list
			$ids = explode( ',', $ids );
			if( ! empty( $ids ) && is_array( $ids ) ) {
				$args['post__in'] = $ids;
			}
		}
			
		$return = '';
		$testimonials = new WP_Query( $args );
		if( $testimonials->have_posts() ) {
			while( $testimonials->have_posts() ):
				$testimonials->the_post();
				$return .= '<div class="wp-testimonial">';
					$return .= '<div class="wp-testimonial-inner">';
						$return .= testimonials_for_wp_get_testimonial( $post->ID, $style );
					$return .= '</div>';
				$return .= '</div>';
			endwhile;
			wp_reset_query();
		} else {
			$return = '<p>' . __( 'There are currently no testimonials to display', 'testimonials-for-wp ' ) . '</p>';
		}
		return $return;
	}
}

/**
 * Print testimonials
 */
if( ! function_exists( 'testimonials_for_wp_shortcode' ) ) {
	function testimonials_for_wp_shortcode( $atts ) {
		$atts = extract( shortcode_atts( array(
			'number'	=> -1,
			'layout'	=> '',
			'columns'	=> '',
			'style'		=> '',
			'featured'	=> '',
			'ids'		=> ''
		), $atts ) );
		
		// Set the styles for the testimonials wrapper
		$wrapper_classes = array();
		if( empty( $layout ) ) {
			$layout = testimonials_for_wp_get_layout();
		}
		if( empty( $style ) ) {
			$style = testimonials_for_wp_get_style();
		}
		if( empty( $columns ) ) {
			$columns = testimonials_for_wp_get_columns();
		}
		$wrapper_classes[] = 'testimonials-for-wp-' . esc_attr( $style );
		$wrapper_classes[] = 'testimonials-for-wp-' . esc_attr( $layout );
		$wrapper_classes[] = 'testimonials-for-wp-cols-' . esc_attr( $columns );
		
		$wrapper_classes = apply_filters( 'testimonials_for_wp_filter_wrapper_classes', $wrapper_classes );
		
		// Generate random ID in case we have multiple instances on a page
		$id = rand( 100000, 999999 );
		
		$return = '<div id="testimonials-for-wp-' . $id . '" class="testimonials-for-wp-wrapper ' . join( ' ', $wrapper_classes ) . '">';
		if( testimonials_for_wp_is_masonry_layout( $layout ) ) {
			$return .= '<div class="grid-sizer"></div>';
		}
		$return .= testimonials_for_wp_get_testimonials( $number, $featured, $ids, $style );
		$return .= '</div>';
		
		if( testimonials_for_wp_is_masonry_layout( $layout ) ) {
			$return .= "<script>
				jQuery(document).ready(function($){
					container = $('#testimonials-for-wp-" . $id . "');
					container.masonry({
						itemSelector: '.wp-testimonial',
						columnWidth: '.grid-sizer',
						percentPosition: true
					});
					container.imagesLoaded().progress(function(){
						container.masonry('layout');
					});
				});
				</script>";
		}
		
		return $return;
	}
}
add_shortcode( 'testimonials_for_wp', 'testimonials_for_wp_shortcode' );
