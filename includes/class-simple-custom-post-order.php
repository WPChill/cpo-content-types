<?php

class MT_Sort_Engine {

	public function __construct() {

		add_action( 'admin_init', array( $this, 'refresh' ) );
		add_action( 'admin_init', array( $this, 'update_options' ) );
		add_action( 'admin_init', array( $this, 'load_script_css' ) );

		add_action( 'wp_ajax_update-menu-order', array( $this, 'update_menu_order' ) );

		add_action( 'pre_get_posts', array( $this, 'mt_order_pre_get_posts' ) );

		add_filter( 'get_previous_post_where', array( $this, 'mt_order_previous_post_where' ) );
		add_filter( 'get_previous_post_sort', array( $this, 'mt_order_previous_post_sort' ) );
		add_filter( 'get_next_post_where', array( $this, 'mt_order_next_post_where' ) );
		add_filter( 'get_next_post_sort', array( $this, 'mt_order_next_post_sort' ) );
	}


	public function _check_load_script_css() {
		$active = false;

		$objects = $this->get_mt_order_options_objects();

		if ( empty( $objects ) ) {
			return false;
		}

		if ( isset( $_GET['orderby'] ) ||
			( isset( $_SERVER['REQUEST_URI'] ) &&
				(
					strstr( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ), 'action=edit' ) ||
					strstr( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ), 'wp-admin/post-new.php' )
				)
			)
		) {
			return false;
		}

		if ( ! empty( $objects ) ) {
			if ( isset( $_GET['post_type'] ) && ! isset( $_GET['taxonomy'] ) && in_array( $_GET['post_type'], $objects, true ) ) { // if page or custom post types
				$active = true;
			}
			if ( ! isset( $_GET['post_type'] ) &&
				isset( $_SERVER['REQUEST_URI'] ) &&
				strstr( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ), 'wp-admin/edit.php' ) &&
				in_array( 'post', $objects, true )
			) {
				$active = true;
			}
		}

		return $active;
	}

	public function load_script_css() {

		if ( $this->_check_load_script_css() ) {
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'mt_orderjs', CTCT_CONTENT_TYPES_URL . 'assets/js/scporder.js', array( 'jquery' ), CTCT_CONTENT_TYPES_VERSION, true );
			wp_localize_script( 'mt_orderjs', 'scporder', array( 'nonce' => wp_create_nonce( 'scp_order_nonce' ) ) );

			wp_enqueue_style( 'mt_order', CTCT_CONTENT_TYPES_URL . 'assets/css/scporder.css', array(), CTCT_CONTENT_TYPES_VERSION );
		}
	}

	public function refresh() {
		global $wpdb;
		$objects = $this->get_mt_order_options_objects();

		if ( ! empty( $objects ) ) {
			foreach ( $objects as $object ) {
				$result = $wpdb->get_results(
					$wpdb->prepare(
						"
						SELECT count(*) as cnt, max(menu_order) as max, min(menu_order) as min 
						FROM $wpdb->posts 
						WHERE post_type = %s 
						AND post_status IN ('publish', 'pending', 'draft', 'private', 'future')
						",
						$object
					)
				);
				if ( 0 === absint( $result[0]->cnt ) || absint( $result[0]->cnt ) === absint( $result[0]->max ) ) {
					continue;
				}

				$results = $wpdb->get_results(
					$wpdb->prepare(
						"
						SELECT ID 
						FROM $wpdb->posts 
						WHERE post_type = %s 
						AND post_status IN ('publish', 'pending', 'draft', 'private', 'future') 
						ORDER BY menu_order ASC
						",
						$object
					)
				);
				foreach ( $results as $key => $result ) {
					$wpdb->update( $wpdb->posts, array( 'menu_order' => $key + 1 ), array( 'ID' => $result->ID ) );
				}
			}
		}
	}

	public function update_menu_order() {

		check_ajax_referer( 'scp_order_nonce', 'nonce' );

		global $wpdb;

		$order = isset( $_POST['order'] ) ? sanitize_text_field( wp_unslash( $_POST['order'] ) ) : false;

		if ( ! $order ) {
			return false;
		}

		parse_str( $order, $data );

		if ( ! is_array( $data ) ) {
			return false;
		}

		$id_arr = array();
		foreach ( $data as $key => $values ) {
			foreach ( $values as $position => $id ) {
				$id_arr[] = $id;
			}
		}

		$menu_order_arr = array();
		foreach ( $id_arr as $key => $id ) {
			$results = $wpdb->get_results( "SELECT menu_order FROM $wpdb->posts WHERE ID = " . intval( $id ) );
			foreach ( $results as $result ) {
				$menu_order_arr[] = $result->menu_order;
			}
		}

		sort( $menu_order_arr );

		foreach ( $data as $key => $values ) {
			foreach ( $values as $position => $id ) {
				$wpdb->update( $wpdb->posts, array( 'menu_order' => $menu_order_arr[ $position ] ), array( 'ID' => intval( $id ) ) );
			}
		}
	}


	public function update_options() {
		global $wpdb;

		if ( ! isset( $_POST['mt_order_submit'] ) ) {
			return false;
		}

		check_admin_referer( 'nonce_mt_order' );

		$input_options            = array();
		$input_options['objects'] = isset( $_POST['objects'] ) && is_array( $_POST['objects'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['objects'] ) ) : array();

		update_option( 'mt_order_options', $input_options );

		$objects = $this->get_mt_order_options_objects();

		if ( ! empty( $objects ) ) {
			foreach ( $objects as $object ) {
				$result = $wpdb->get_results(
					$wpdb->prepare(
						"
						SELECT count(*) as cnt, max(menu_order) as max, min(menu_order) as min 
						FROM $wpdb->posts 
						WHERE post_type = %s 
						AND post_status IN ('publish', 'pending', 'draft', 'private', 'future')
						",
						$object
					)
				);
				if ( 0 === absint( $result[0]->cnt ) || absint( $result[0]->cnt ) === absint( $result[0]->max ) ) {
					continue;
				}

				if ( 'page' === $object ) {
					$results = $wpdb->get_results(
						$wpdb->prepare(
							"
							SELECT ID 
							FROM $wpdb->posts 
							WHERE post_type = %s 
							AND post_status IN ('publish', 'pending', 'draft', 'private', 'future') 
							ORDER BY post_title ASC
							",
							$object
						)
					);
				} else {
					$results = $wpdb->get_results(
						$wpdb->prepare(
							"
							SELECT ID 
							FROM $wpdb->posts 
							WHERE post_type = %s 
							AND post_status IN ('publish', 'pending', 'draft', 'private', 'future') 
							ORDER BY post_title ASC
							",
							$object
						)
					);
				}
				foreach ( $results as $key => $result ) {
					$wpdb->update( $wpdb->posts, array( 'menu_order' => $key + 1 ), array( 'ID' => $result->ID ) );
				}
			}
		}

		wp_safe_redirect( 'admin.php?page=mt_order-settings&msg=update' );
	}

	public function mt_order_previous_post_where( $where ) {
		global $post;

		$objects = $this->get_mt_order_options_objects();
		if ( empty( $objects ) ) {
			return $where;
		}

		if ( isset( $post->post_type ) && in_array( $post->post_type, $objects, true ) ) {
			$current_menu_order = $post->menu_order;
			$where              = "WHERE p.menu_order > '" . $current_menu_order . "' AND p.post_type = '" . $post->post_type . "' AND p.post_status = 'publish'";
		}

		return $where;
	}

	public function mt_order_previous_post_sort( $orderby ) {
		global $post;

		$objects = $this->get_mt_order_options_objects();
		if ( empty( $objects ) ) {
			return $orderby;
		}

		if ( isset( $post->post_type ) && in_array( $post->post_type, $objects, true ) ) {
			$orderby = 'ORDER BY p.menu_order ASC LIMIT 1';
		}

		return $orderby;
	}

	public function mt_order_next_post_where( $where ) {
		global $post;

		$objects = $this->get_mt_order_options_objects();
		if ( empty( $objects ) ) {
			return $where;
		}

		if ( isset( $post->post_type ) && in_array( $post->post_type, $objects, true ) ) {
			$current_menu_order = $post->menu_order;
			$where              = "WHERE p.menu_order < '" . $current_menu_order . "' AND p.post_type = '" . $post->post_type . "' AND p.post_status = 'publish'";
		}

		return $where;
	}

	public function mt_order_next_post_sort( $orderby ) {
		global $post;

		$objects = $this->get_mt_order_options_objects();
		if ( empty( $objects ) ) {
			return $orderby;
		}

		if ( isset( $post->post_type ) && in_array( $post->post_type, $objects, true ) ) {
			$orderby = 'ORDER BY p.menu_order DESC LIMIT 1';
		}

		return $orderby;
	}

	public function mt_order_pre_get_posts( $wp_query ) {
		$objects = $this->get_mt_order_options_objects();
		if ( empty( $objects ) ) {
			return false;
		}
		if ( is_admin() ) {
			if ( isset( $wp_query->query['post_type'] ) && ! isset( $_GET['orderby'] ) ) {
				if ( in_array( $wp_query->query['post_type'], $objects, true ) ) {
					$wp_query->set( 'orderby', 'menu_order' );
					$wp_query->set( 'order', 'ASC' );
				}
			}
		} else {
			$active = false;

			if ( isset( $wp_query->query['post_type'] ) ) {
				if ( ! is_array( $wp_query->query['post_type'] ) ) {
					if ( in_array( $wp_query->query['post_type'], $objects, true ) ) {
						$active = true;
					}
				}
			} elseif ( in_array( 'post', $objects, true ) ) {
					$active = true;
			}

			if ( ! $active ) {
				return false;
			}

			if ( isset( $wp_query->query['suppress_filters'] ) ) {
				if ( 'date' === $wp_query->get( 'orderby' ) ) {
					$wp_query->set( 'orderby', 'menu_order' );
				}
				if ( 'DESC' === $wp_query->get( 'order' ) ) {
					$wp_query->set( 'order', 'ASC' );
				}
			} else {
				if ( ! $wp_query->get( 'orderby' ) ) {
					$wp_query->set( 'orderby', 'menu_order' );
				}
				if ( ! $wp_query->get( 'order' ) ) {
					$wp_query->set( 'order', 'ASC' );
				}
			}
		}
	}


	public function get_mt_order_options_objects() {
		/**
		 * Custom Post Types this is supposed to be working for.
		 */
		$objects = array(
			'cpo_slide',
			'cpo_feature',
			'cpo_portfolio',
			'cpo_service',
			'cpo_team',
			'cpo_testimonial',
			'cpo_client',
		);

		return $objects;
	}
}

new MT_Sort_Engine();
