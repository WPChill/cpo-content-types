<?php

//Define services post type
add_action( 'init', 'ctct_cpost_services' );
function ctct_cpost_services() {
	$show_ui = false;
	if ( defined( 'CPOTHEME_USE_SERVICES' ) || ctct_get_option( 'display_services' ) ) {
		$show_ui = true;
	}

	//Set up labels
	$labels = array(
		'name'               => __( 'Services', 'cpo-content-types' ),
		'singular_name'      => __( 'Services', 'cpo-content-types' ),
		'add_new'            => __( 'Add Service', 'cpo-content-types' ),
		'add_new_item'       => __( 'Add New Service', 'cpo-content-types' ),
		'edit_item'          => __( 'Edit Service', 'cpo-content-types' ),
		'new_item'           => __( 'New Service', 'cpo-content-types' ),
		'view_item'          => __( 'View Service', 'cpo-content-types' ),
		'search_items'       => __( 'Search Services', 'cpo-content-types' ),
		'not_found'          => __( 'No services found.', 'cpo-content-types' ),
		'not_found_in_trash' => __( 'No services found in the trash.', 'cpo-content-types' ),
		'parent_item_colon'  => '',
	);

	$slug = ctct_get_option( 'slug_service' );
	if ( '' === $slug ) {
		$slug = 'service';
	}
	$fields = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => $show_ui,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => apply_filters( 'cpotheme_slug_service', $slug ) ),
		'capability_type'    => 'page',
		'hierarchical'       => false,
		'menu_icon'          => 'dashicons-archive',
		'menu_position'      => null,
		'show_in_nav_menus'  => true,
		'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
	);

	register_post_type( 'cpo_service', $fields );
}


//Define admin columns in services post type
add_filter( 'manage_edit-cpo_service_columns', 'ctct_cpost_services_columns' );
if ( ! function_exists( 'ctct_cpost_services_columns' ) ) {
	function ctct_cpost_services_columns( $columns ) {
		$columns = array(
			'cb'               => '<input type="checkbox" />',
			'cpo-image'        => __( 'Image', 'cpo-content-types' ),
			'title'            => __( 'Title', 'cpo-content-types' ),
			'cpo-service-cats' => __( 'Categories', 'cpo-content-types' ),
			'cpo-service-tags' => __( 'Tags', 'cpo-content-types' ),
			'date'             => __( 'Date', 'cpo-content-types' ),
			'comments'         => '<span class="vers"><span title="' . __( 'Comments', 'cpo-content-types' ) . '" class="comment-grey-bubble"></span></span>',
			'author'           => __( 'Author', 'cpo-content-types' ),
		);
		return $columns;
	}
}

//Define services category taxonomy
add_action( 'init', 'ctct_tax_servicescategory' );
if ( ! function_exists( 'ctct_tax_servicescategory' ) ) {
	function ctct_tax_servicescategory() {
		$labels = array(
			'name'               => __( 'Service Categories', 'cpo-content-types' ),
			'singular_name'      => __( 'Service Category', 'cpo-content-types' ),
			'add_new'            => __( 'New Service Category', 'cpo-content-types' ),
			'add_new_item'       => __( 'Add Service Category', 'cpo-content-types' ),
			'edit_item'          => __( 'Edit Service Category', 'cpo-content-types' ),
			'new_item'           => __( 'New Service Category', 'cpo-content-types' ),
			'view_item'          => __( 'View Service Category', 'cpo-content-types' ),
			'search_items'       => __( 'Search Service Categories', 'cpo-content-types' ),
			'not_found'          => __( 'No services categories were found.', 'cpo-content-types' ),
			'not_found_in_trash' => __( 'No services categories were found in the trash.', 'cpo-content-types' ),
			'parent_item_colon'  => '',
		);

		$slug = ctct_get_option( 'slug_service_category' );
		if ( '' === $slug ) {
			$slug = 'service-category';
		}
		$fields = array(
			'labels'            => $labels,
			'public'            => true,
			'show_ui'           => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
			'rewrite'           => array( 'slug' => apply_filters( 'cpotheme_slug_service_category', $slug ) ),
			'hierarchical'      => true,
		);

		register_taxonomy( 'cpo_service_category', 'cpo_service', $fields );
	}
}

//Define services tag taxonomy
add_action( 'init', 'ctct_tax_servicestag' );
if ( ! function_exists( 'ctct_tax_servicestag' ) ) {
	function ctct_tax_servicestag() {
		//Set up labels
		$labels = array(
			'name'               => __( 'Service Tags', 'cpo-content-types' ),
			'singular_name'      => __( 'Service Tag', 'cpo-content-types' ),
			'add_new'            => __( 'New Service Tag', 'cpo-content-types' ),
			'add_new_item'       => __( 'Add Service Tag', 'cpo-content-types' ),
			'edit_item'          => __( 'Edit Service Tag', 'cpo-content-types' ),
			'new_item'           => __( 'New Service Tag', 'cpo-content-types' ),
			'view_item'          => __( 'View Service Tag', 'cpo-content-types' ),
			'search_items'       => __( 'Search Service Tags', 'cpo-content-types' ),
			'not_found'          => __( 'No services tags were found.', 'cpo-content-types' ),
			'not_found_in_trash' => __( 'No services tags were found in the trash.', 'cpo-content-types' ),
			'parent_item_colon'  => '',
		);

		$slug = ctct_get_option( 'slug_service_tag' );
		if ( '' === $slug ) {
			$slug = 'service-tag';
		}
		$fields = array(
			'labels'            => $labels,
			'public'            => true,
			'show_ui'           => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
			'rewrite'           => array( 'slug' => apply_filters( 'cpotheme_slug_service_tag', $slug ) ),
			'hierarchical'      => false,
		);

		register_taxonomy( 'cpo_service_tag', 'cpo_service', $fields );
	}
}
