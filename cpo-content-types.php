<?php
/*
Plugin Name: CPO Content Types
Description: Adds support for a number of content types in your Wordpress installation.
Author: CPOThemes
Version: 1.1.0
Author URI: http://www.cpothemes.com
*/

//Plugin setup
if(!function_exists('ctct_setup')){
	add_action('plugins_loaded', 'ctct_setup');
	function ctct_setup(){
		//Load text domain
		$textdomain = 'ctct';
		$locale = apply_filters('plugin_locale', get_locale(), $textdomain);
		if(!load_textdomain($textdomain, trailingslashit(WP_LANG_DIR).$textdomain.'/'.$textdomain.'-'.$locale.'.mo')){
			load_plugin_textdomain($textdomain, false, dirname(dirname(plugin_basename(__FILE__))).'/languages/');
		}
	}
}


//Add admin stylesheets
add_action('admin_print_styles', 'ctct_add_styles_admin');
function ctct_add_styles_admin(){
	$stylesheets_path = plugins_url('css/' , __FILE__);
	wp_enqueue_style('ctct-admin', $stylesheets_path.'admin.css');
}


//Define custom columns for each custom post type page
add_action('manage_posts_custom_column', 'ctct_admin_columns', 2);
function ctct_admin_columns($column){
	global $post;
	switch($column){
		case 'ctct-image': echo get_the_post_thumbnail($post->ID, array(60,60)); break;
		case 'ctct-portfolio-cats': echo get_the_term_list($post->ID, 'cpo_portfolio_category', '', ', ', ''); break;
		case 'ctct-portfolio-tags': echo get_the_term_list($post->ID, 'cpo_portfolio_tag', '', ', ', ''); break;
		case 'ctct-service-cats': echo get_the_term_list($post->ID, 'cpo_service_category', '', ', ', ''); break;
		case 'ctct-service-tags': echo get_the_term_list($post->ID, 'cpo_service_tag', '', ', ', ''); break;
		default:break;
	}
}


//Add all components
$core_path = plugin_dir_path(__FILE__);
//General
require_once($core_path.'includes/settings.php');
require_once($core_path.'includes/metadata.php');
//Custom Post Types
require_once($core_path.'cposts/cpost_slides.php');
require_once($core_path.'cposts/cpost_features.php');
require_once($core_path.'cposts/cpost_portfolio.php');
require_once($core_path.'cposts/cpost_services.php');
require_once($core_path.'cposts/cpost_team.php');
require_once($core_path.'cposts/cpost_testimonials.php');
require_once($core_path.'cposts/cpost_clients.php');


//Plugin activation hook
function ctct_activation(){
    ctct_cpost_slides();
    ctct_cpost_features();
    ctct_cpost_portfolio();
    ctct_cpost_services();
    ctct_cpost_team();
    ctct_cpost_testimonials();
    ctct_cpost_clients();
	flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'ctct_activation');