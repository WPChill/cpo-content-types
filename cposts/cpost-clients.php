<?php

//Define clients post type
add_action( 'init', 'ctct_cpost_clients' );
function ctct_cpost_clients() {
	$show_ui = false;
	if ( defined( 'CPOTHEME_USE_CLIENTS' ) || ctct_get_option( 'display_clients' ) ) {
		$show_ui = true;
	}

	//Set up labels
	$labels = array(
		'name'               => __( 'Clients', 'cpo-content-types' ),
		'singular_name'      => __( 'Client', 'cpo-content-types' ),
		'add_new'            => __( 'Add Client', 'cpo-content-types' ),
		'add_new_item'       => __( 'Add New Client', 'cpo-content-types' ),
		'edit_item'          => __( 'Edit Client', 'cpo-content-types' ),
		'new_item'           => __( 'New Client', 'cpo-content-types' ),
		'view_item'          => __( 'View Client', 'cpo-content-types' ),
		'search_items'       => __( 'Search Clients', 'cpo-content-types' ),
		'not_found'          => __( 'No clients found.', 'cpo-content-types' ),
		'not_found_in_trash' => __( 'No clients found in the trash.', 'cpo-content-types' ),
		'parent_item_colon'  => '',
	);

	$fields = array(
		'labels'             => $labels,
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => $show_ui,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'page',
		'hierarchical'       => false,
		'menu_icon'          => 'dashicons-businessman',
		'menu_position'      => null,
		'supports'           => array( 'title', 'excerpt', 'thumbnail' ),
	);

	register_post_type( 'cpo_client', $fields );
}


//Define admin columns in clients post type
add_filter( 'manage_edit-cpo_client_columns', 'ctct_cpost_clients_columns' );
if ( ! function_exists( 'ctct_cpost_clients_columns' ) ) {
	function ctct_cpost_clients_columns( $columns ) {
		$columns = array(
			'cb'        => '<input type="checkbox" />',
			'cpo-image' => __( 'Image', 'cpo-content-types' ),
			'title'     => __( 'Title', 'cpo-content-types' ),
			'date'      => __( 'Date', 'cpo-content-types' ),
			'author'    => __( 'Author', 'cpo-content-types' ),
		);
		return $columns;
	}
}
