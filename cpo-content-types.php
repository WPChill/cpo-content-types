<?php
/*
* Plugin Name: CPO Content Types
* Description: Adds support for a number of content types in your WordPress installation.
* Author: CPOThemes
* Version: 1.1.1
* Author URI: http://www.cpothemes.com
* Requires PHP: 5.6
* Text Domain: cpo-content-types
* License: GPLv2 or later
*/

/**
 * Define Constants
 *
 * @since    1.1.1
 */
define( 'CTCT_CONTENT_TYPES_VERSION', '1.1.1' );
define( 'CTCT_CONTENT_TYPES_PATH', plugin_dir_path( __FILE__ ) );
define( 'CTCT_CONTENT_TYPES_URL', plugin_dir_url( __FILE__ ) );

//Plugin setup
if ( ! function_exists( 'ctct_setup' ) ) {
	add_action( 'plugins_loaded', 'ctct_setup' );
	function ctct_setup() {
		//Load text domain
		$textdomain = 'cpo-content-types';
		$locale     = apply_filters( 'plugin_locale', get_locale(), $textdomain ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
		if ( ! load_textdomain( $textdomain, trailingslashit( WP_LANG_DIR ) . $textdomain . '/' . $textdomain . '-' . $locale . '.mo' ) ) {
			load_plugin_textdomain( $textdomain, false, dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/' );
		}
	}
}


//Add admin stylesheets
add_action( 'admin_print_styles', 'ctct_add_styles_admin' );
function ctct_add_styles_admin() {
	$stylesheets_path = plugins_url( 'assets/css/', __FILE__ );
	wp_enqueue_style( 'ctct-admin', $stylesheets_path . 'admin.css', null, CTCT_CONTENT_TYPES_VERSION );
}


//Define custom columns for each custom post type page
add_action( 'manage_posts_custom_column', 'ctct_admin_columns', 2 );
function ctct_admin_columns( $column ) {
	global $post;
	switch ( $column ) {
		case 'ctct-image':
			echo get_the_post_thumbnail( $post->ID, array( 60, 60 ) );
			break;
		case 'ctct-portfolio-cats':
			echo get_the_term_list( $post->ID, 'cpo_portfolio_category', '', ', ', '' );
			break;
		case 'ctct-portfolio-tags':
			echo get_the_term_list( $post->ID, 'cpo_portfolio_tag', '', ', ', '' );
			break;
		case 'ctct-service-cats':
			echo get_the_term_list( $post->ID, 'cpo_service_category', '', ', ', '' );
			break;
		case 'ctct-service-tags':
			echo get_the_term_list( $post->ID, 'cpo_service_tag', '', ', ', '' );
			break;
		default:
			break;
	}
}


//Add all components
//General
require_once CTCT_CONTENT_TYPES_PATH . 'includes/settings.php';
require_once CTCT_CONTENT_TYPES_PATH . 'includes/metadata.php';
//Custom Post Types
require_once CTCT_CONTENT_TYPES_PATH . 'cposts/cpost-slides.php';
require_once CTCT_CONTENT_TYPES_PATH . 'cposts/cpost-features.php';
require_once CTCT_CONTENT_TYPES_PATH . 'cposts/cpost-portfolio.php';
require_once CTCT_CONTENT_TYPES_PATH . 'cposts/cpost-services.php';
require_once CTCT_CONTENT_TYPES_PATH . 'cposts/cpost-team.php';
require_once CTCT_CONTENT_TYPES_PATH . 'cposts/cpost-testimonials.php';
require_once CTCT_CONTENT_TYPES_PATH . 'cposts/cpost-clients.php';
// Custom Post Type Order
require_once CTCT_CONTENT_TYPES_PATH . 'includes/class-simple-custom-post-order.php';


//Plugin activation hook
function ctct_activation() {
	ctct_cpost_slides();
	ctct_cpost_features();
	ctct_cpost_portfolio();
	ctct_cpost_services();
	ctct_cpost_team();
	ctct_cpost_testimonials();
	ctct_cpost_clients();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'ctct_activation' );
