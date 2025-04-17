<?php

//Define slides post type
add_action( 'init', 'ctct_cpost_slides' );
function ctct_cpost_slides() {
	$show_ui = false;
	if ( defined( 'CPOTHEME_USE_SLIDES' ) || ctct_get_option( 'display_slides' ) ) {
		$show_ui = true;
	}

	//Set up labels
	$labels = array(
		'name'               => __( 'Slides', 'cpo-content-types' ),
		'singular_name'      => __( 'Slide', 'cpo-content-types' ),
		'add_new'            => __( 'New Slide', 'cpo-content-types' ),
		'add_new_item'       => __( 'Add New Slide', 'cpo-content-types' ),
		'edit_item'          => __( 'Edit Slide', 'cpo-content-types' ),
		'new_item'           => __( 'New Slide', 'cpo-content-types' ),
		'view_item'          => __( 'View Slide', 'cpo-content-types' ),
		'search_items'       => __( 'Search Slides', 'cpo-content-types' ),
		'not_found'          => __( 'No slides were found.', 'cpo-content-types' ),
		'not_found_in_trash' => __( 'No slides were found in the trash.', 'cpo-content-types' ),
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
		'menu_icon'          => 'dashicons-images-alt2',
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
	);

	register_post_type( 'cpo_slide', $fields );
}

//Define admin columns in slides post type
add_filter( 'manage_edit-cpo_slide_columns', 'ctct_cpost_slides_columns' );
if ( ! function_exists( 'ctct_cpost_slides_columns' ) ) {
	function ctct_cpost_slides_columns( $columns ) {
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
