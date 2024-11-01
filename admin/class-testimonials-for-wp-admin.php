<?php
/**
 * Testimonials for WP admin class
*/

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin admin class
 **/
if( ! class_exists( 'Testimonials_For_WP_Admin' ) ) {
	
	class Testimonials_For_WP_Admin {
		
		public function __construct() {
			//
		}
		
		/**
		 * Initialize the class and start calling our hooks and filters
		 * @since 1.0.0
		 */
		public function init() {
			add_action( 'admin_menu', array( $this, 'add_settings_submenu' ) );
			add_action( 'admin_init', array( $this, 'register_options_init' ) );
			// add_filter( 'plugin_action_links_testimonials-for-wp-/testimonials-for-wp-.php', array( $this, 'filter_action_links' ), 10, 1 );
		}
		
		// Add the menu item
		public function add_settings_submenu() {
			add_options_page( __( 'Testimonials for WP', 'testimonials-for-wp' ), __( 'Testimonials for WP', 'testimonials-for-wp' ), 'manage_options', 'testimonials-for-wp', array( $this, 'options_page' ) );
		}
		
		public function register_options_init() {
			register_setting( 'testimonials_for_wp_options', 'testimonials_for_wp_options_settings' );
			
			add_settings_section( 'testimonials_for_wp_options_section', __( 'General settings', 'testimonials-for-wp' ), array( $this, 'options_section_callback' ), 'testimonials_for_wp_options' );
			
			// Set defaults
			$options = get_option( 'testimonials_for_wp_options_settings' );
			if( false === $options ) {
				$options = $this->get_defaults();
				update_option( 'testimonials_for_wp_options_settings', $options );
			}
			
			$settings = testimonials_for_wp_settings();
			if( ! empty( $settings ) ) {
				foreach( $settings as $setting ) {
					add_settings_field( 
						$setting['id'], 
						$setting['label'], 
						$setting['callback'],
						'testimonials_for_wp_options',
						'testimonials_for_wp_options_section',
						$setting
					);
				}
			}
			
		}
		
		public function get_defaults() { 
			$options = array(
				'style'		=> 'cards',
				'layout'	=> 'grid',
				'columns'	=> '2'
			);
			return $options;
		}
		
		
		public function options_section_callback() {
			printf( '<p>%s</p>', __( 'You can override many of these settings using shortcode parameters if you wish', 'testimonials-for-wp' ) );
		}
		
		public function options_page() {
			$current = isset( $_GET['tab'] ) ? $_GET['tab'] : 'options';
			$title =  __( 'Testimonials for WP', 'testimonials-for-wp' );
			$tabs = array(
				'options'	=>	__( 'General', 'testimonials-for-wp' )
			);
			$tabs = apply_filters( 'testimonials_for_wp_settings_tabs', $tabs );
			?>			
			<div class="wrap">
				<h1><?php echo $title; ?></h1>
				<div class="testimonials-for-wp-outer-wrap">
					<div class="testimonials-for-wp-inner-wrap">
						<h2 class="nav-tab-wrapper">
							<?php foreach( $tabs as $tab => $name ) {
								$class = ( $tab == $current ) ? ' nav-tab-active' : '';
								echo "<a class='nav-tab$class' href='?page=testimonials-for-wp&tab=$tab'>$name</a>";
							} ?>
						</h2>
						
						<form action='options.php' method='post'>
							<?php
							settings_fields( 'testimonials_for_wp_' . strtolower( $current ) );
							do_settings_sections( 'testimonials_for_wp_' . strtolower( $current ) );
							submit_button();
							?>
						</form>
					</div><!-- .testimonials-for-wp-inner-wrap -->
					<div class="testimonials-for-wp-banners">
						<div class="testimonials-for-wp-banner">
							<a target="_blank" href="https://catapultthemes.com/downloads/restrictly-pro/?utm_source=plugin_ad&utm_medium=wp_plugin&utm_content=testimonials-for-wp-&utm_campaign=testimonials-for-wp-pro"><img src="<?php echo TESTIMONIALS_FOR_WP_PLUGIN_URL . 'assets/images/restrictly-banner-ad.png'; ?>" alt="" ></a>
						</div>
						<div class="testimonials-for-wp-banner hide-dbpro">
							<a target="_blank" href="https://discussionboard.pro/?utm_source=plugin_ad&utm_medium=wp_plugin&utm_content=testimonials-for-wp-&utm_campaign=dbpro"><img src="<?php echo TESTIMONIALS_FOR_WP_PLUGIN_URL . 'assets/images/discussion-board-banner-ad.png'; ?>" alt="" ></a>
						</div>
						<div class="testimonials-for-wp-banner">
							<a target="_blank" href="https://gallery.catapultthemes.com/?utm_source=plugin_ad&utm_medium=wp_plugin&utm_content=testimonials-for-wp-&utm_campaign=gallery"><img src="<?php echo TESTIMONIALS_FOR_WP_PLUGIN_URL . 'assets/images/mgs-banner-ad.png'; ?>" alt="" ></a>
						</div>
						<div class="testimonials-for-wp-banner">
							<a target="_blank" href="http://superheroslider.catapultthemes.com/?utm_source=plugin_ad&utm_medium=wp_plugin&utm_content=testimonials-for-wp-&utm_campaign=superhero"><img src="<?php echo TESTIMONIALS_FOR_WP_PLUGIN_URL . 'assets/images/shs-banner-ad.png'; ?>" alt="" ></a>
						</div>
						<div class="testimonials-for-wp-banner">
							<a target="_blank" href="https://singularitytheme.com/?utm_source=plugin_ad&utm_medium=wp_plugin&utm_content=ctdb&utm_campaign=singularity"><img src="<?php echo TESTIMONIALS_FOR_WP_PLUGIN_URL . 'assets/images/singularity-banner-ad.png'; ?>" alt="" ></a>
						</div>		
					</div>
				</div><!-- .testimonials-for-wp-outer-wrap -->
			</div><!-- .wrap -->
			<?php
		}
	}
	
}

function testimonials_for_wp_admin_init() {
	$Testimonials_For_WP_Admin = new Testimonials_For_WP_Admin();
	$Testimonials_For_WP_Admin -> init();
	do_action( 'testimonials_for_wp_init' );
}
add_action( 'plugins_loaded', 'testimonials_for_wp_admin_init' );
