<?php

//Define features post type
add_action( 'init', 'ctct_cpost_features' );
function ctct_cpost_features() {
	$show_ui = false;
	if ( defined( 'CPOTHEME_USE_FEATURES' ) || ctct_get_option( 'display_features' ) ) {
		$show_ui = true;
	}

	//Set up labels
	$labels = array(
		'name'               => __( 'Features', 'cpo-content-types' ),
		'singular_name'      => __( 'Feature', 'cpo-content-types' ),
		'add_new'            => __( 'Add Feature', 'cpo-content-types' ),
		'add_new_item'       => __( 'Add New Feature', 'cpo-content-types' ),
		'edit_item'          => __( 'Edit Feature', 'cpo-content-types' ),
		'new_item'           => __( 'New Feature', 'cpo-content-types' ),
		'view_item'          => __( 'View Features', 'cpo-content-types' ),
		'search_items'       => __( 'Search Features', 'cpo-content-types' ),
		'not_found'          => __( 'No features found.', 'cpo-content-types' ),
		'not_found_in_trash' => __( 'No features found in the trash.', 'cpo-content-types' ),
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
		'menu_icon'          => 'dashicons-star-filled',
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'thumbnail' ),
	);

	register_post_type( 'cpo_feature', $fields );
}


//Define admin columns in features post type
add_filter( 'manage_edit-cpo_feature_columns', 'ctct_cpost_features_columns' );
if ( ! function_exists( 'ctct_cpost_features_columns' ) ) {
	function ctct_cpost_features_columns( $columns ) {
		$columns = array(
			'cb'         => '<input type="checkbox" />',
			'ctct-image' => __( 'Image', 'cpo-content-types' ),
			'title'      => __( 'Title', 'cpo-content-types' ),
			'date'       => __( 'Date', 'cpo-content-types' ),
			'comments'   => '<span class="vers"><span title="' . __( 'Comments', 'cpo-content-types' ) . '" class="comment-grey-bubble"></span></span>',
			'author'     => __( 'Author', 'cpo-content-types' ),
		);
		return $columns;
	}
}
