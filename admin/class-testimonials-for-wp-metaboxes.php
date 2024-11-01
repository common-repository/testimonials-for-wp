<?php
/**
 * Metaboxes
*/

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin public class
 **/
if( ! class_exists( 'Testimonials_For_WP_Metaboxes' ) ) {

	class Testimonials_For_WP_Metaboxes {
	
		public $metaboxes;

		public function __construct( $metaboxes ) {
			$this->metaboxes = $metaboxes;
		}
		
		/**
		 * Initialize the class and start calling our hooks and filters
		 * @since 1.0.0
		 */
		public function init() {
			add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
			add_action( 'save_post', array( $this, 'save_metabox_data' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}
		
		/**
		 * Register the metabox
		 * @since 1.0.0
		 */
		public function add_meta_box() {
			
			$screens = array( 'testimonial' );
			$metaboxes = $this->metaboxes;
			
			foreach( $metaboxes as $metabox ) {
				
				add_meta_box (
					$metabox['ID'],
					$metabox['title'],
					array( $this, $metabox['callback'] ),
					$metabox['screens'],
					$metabox['context'],
					$metabox['priority'],
					$metabox['fields']
				);
				
			}
			
		}
	
		
		/**
		 * Metabox callback for slide order
		 * @since 1.0.0
		*/
		public function meta_box_callback( $post, $fields ) {

			wp_nonce_field( 'save_metabox_data', 'add_metabox_nonce' );
			
			if( $fields['args'] ) {
				
				foreach( $fields['args'] as $field ) {
						
					switch( $field['type'] ) {
						
						case 'text':
							$this->metabox_text_output( $post, $field );
							break;
						case 'checkbox':
							$this->metabox_checkbox_output( $post, $field );
							break;
						case 'select':
							$this->metabox_select_output( $post, $field );
							break;
						case 'divider':
							$this->metabox_divider_output( $post, $field );
							break;
						case 'description':
							$this->metabox_description_output( $post, $field );
							break;
					}
						
				}
				
			}

		}
		
		/**
		 * Metabox callback for text type
		 * @since 1.0.0
		 */
		public function metabox_text_output( $post, $field ) {
			
			$value = get_post_meta( $post->ID, $field['ID'], true );
			
			?>
			<div class="testimonials-for-wp-metafield <?php echo $field['class']; ?>">
				<label for="<?php echo $field['name']; ?>"><?php echo $field['title']; ?></label>
				<input class="widefat" type="text" id="<?php echo $field['name']; ?>" name="<?php echo $field['name']; ?>" value="<?php echo esc_attr( $value ); ?>" >
			</div>
			<?php
		}
		
		/**
		 * Metabox callback for checkbox
		 * @since 1.0.0
		 */
		public function metabox_checkbox_output( $post, $field ) {
			
			$field_value = 0;
			
			// First check if we're on the post-new screen
			global $pagenow;
			if( in_array( $pagenow, array( 'post-new.php' ) ) && isset( $field['default'] ) ) {
				// This is a new post screen so we can apply the default value
				$field_value = $field['default'];
			} else {		
				$custom = get_post_custom( $post->ID );
				if( isset( $custom[$field['ID']][0] ) ) {
					$field_value = $custom[$field['ID']][0];
				}
			}
			?>
			<div class="testimonials-for-wp-metafield testimonials-for-wp-metafield-checkbox <?php echo $field['class']; ?>">
				<input type="checkbox" id="<?php echo $field['name']; ?>" name="<?php echo $field['name']; ?>" value="1" <?php checked( 1, $field_value ); ?>>
				<?php if( ! empty( $field['label'] ) ) { ?>
					<?php echo $field['label']; ?>
				<?php } ?>
				<label for="<?php echo $field['name']; ?>"><?php echo $field['title']; ?></label>
			</div>
			<?php
		}
		
		/**
		 * Metabox callback for select
		 * @since 1.0.0
		 */
		public function metabox_select_output( $post, $field ) {
			
			$field_value = get_post_meta( $post -> ID, $field['ID'], true );
			
			// If there's no saved value and a default value exists, set the value to the default
			// This is to ensure certain settings are set automatically
			if( empty( $field_value ) && ! empty( $field['default'] ) ) {
				$field_value = $field['default'];
			}
			
			?>
			<div class="testimonials-for-wp-metafield <?php echo $field['class']; ?>">
				<label for="<?php echo $field['name']; ?>"><?php echo $field['title']; ?></label>
				<select id="<?php echo $field['name']; ?>" name="<?php echo $field['name']; ?>">
					<?php if( $field['options'] ) {
						foreach( $field['options'] as $key => $value ) { ?>
							<option value="<?php echo $key; ?>" <?php selected( $field_value, $key ); ?>><?php echo $value; ?></option>
						<?php }
					} ?>
				</select>
			</div>
			<?php
		}
		
		/**
		 * Metabox callback for the divider
		 * @since 1.0.0
		 */
		public function metabox_divider_output( $post, $field ) { ?>
			<div class="testimonials-for-wp-metafield <?php echo $field['class']; ?>">
				<hr>
			</div>
			<?php
		}
		
		
		/**
		 * Metabox callback for the description
		 * @since 1.0.0
		 */
		public function metabox_description_output( $post, $field ) { ?>
			<div class="testimonials-for-wp-metafield testimonials-for-wp-description <?php echo $field['class']; ?>">
				<p class="description"><?php echo $field['title']; ?></p>
			</div>
			<?php
		}
		
		/**
		 * Save the data
		 * @since 1.0.0
		 */
		public function save_metabox_data( $post_id ) {
			
			// Check the nonce is set
			if( ! isset( $_POST['add_metabox_nonce'] ) ) {
				return;
			}
			
			// Verify the nonce
			if( ! wp_verify_nonce( $_POST['add_metabox_nonce'], 'save_metabox_data' ) ) {
				return;
			}
			
			// If this is an autosave, our form has not been submitted, so we don't want to do anything.
			if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}
			
			// Check the user's permissions.
			if( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
			
			// Save all our metaboxes
			$metaboxes = $this->metaboxes;
			foreach( $metaboxes as $metabox ) {
				if( $metabox['fields'] ) {
					foreach( $metabox['fields'] as $field ) {
						if( isset( $_POST[$field['name']] ) ) {
							$data = sanitize_text_field( $_POST[$field['name']] );
							update_post_meta( $post_id, $field['ID'], $data );
						} else {
							delete_post_meta( $post_id, $field['ID'] );
						}	
					}
				}
			}

		}
		
		/**
		 * Enqueue scripts and styles
		 * @since 1.0.0
		 */
		public function enqueue_scripts() {
			wp_enqueue_style( 'testimonials-for-wp-style', TESTIMONIALS_FOR_WP_PLUGIN_URL . '/assets/css/admin-style.css' );
		}

	}
	
}