<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wpalchemists.com
 * @since      1.0.0
 *
 * @package    Book_Sync
 * @subpackage Book_Sync/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Book_Sync
 * @subpackage Book_Sync/admin
 * @author     Morgan Kay <morgan@wpalchemists.com>
 */
class Book_Sync_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Book_Sync_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Book_Sync_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/book-sync-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Book_Sync_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Book_Sync_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/book-sync-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function register_cpt_book() {

		$labels = array(
			'name'                  => _x( 'Books', 'Post Type General Name', 'book-sync' ),
			'singular_name'         => _x( 'Book', 'Post Type Singular Name', 'book-sync' ),
			'menu_name'             => __( 'Books', 'book-sync' ),
			'name_admin_bar'        => __( 'Book', 'book-sync' ),
			'archives'              => __( 'Book Archives', 'book-sync' ),
			'attributes'            => __( 'Book Attributes', 'book-sync' ),
			'parent_item_colon'     => __( 'Parent Book:', 'book-sync' ),
			'all_items'             => __( 'All Books', 'book-sync' ),
			'add_new_item'          => __( 'Add New Book', 'book-sync' ),
			'add_new'               => __( 'Add New', 'book-sync' ),
			'new_item'              => __( 'New Book', 'book-sync' ),
			'edit_item'             => __( 'Edit Book', 'book-sync' ),
			'update_item'           => __( 'Update Book', 'book-sync' ),
			'view_item'             => __( 'View Book', 'book-sync' ),
			'view_items'            => __( 'View Books', 'book-sync' ),
			'search_items'          => __( 'Search Book', 'book-sync' ),
			'not_found'             => __( 'Not found', 'book-sync' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'book-sync' ),
			'featured_image'        => __( 'Featured Image', 'book-sync' ),
			'set_featured_image'    => __( 'Set featured image', 'book-sync' ),
			'remove_featured_image' => __( 'Remove featured image', 'book-sync' ),
			'use_featured_image'    => __( 'Use as featured image', 'book-sync' ),
			'insert_into_item'      => __( 'Insert into item', 'book-sync' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'book-sync' ),
			'items_list'            => __( 'Books list', 'book-sync' ),
			'items_list_navigation' => __( 'Books list navigation', 'book-sync' ),
			'filter_items_list'     => __( 'Filter Books list', 'book-sync' ),
		);
		$args = array(
			'label'                 => __( 'Book', 'book-sync' ),
			'description'           => __( 'Books in your collection', 'book-sync' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions' ),
			'taxonomies'            => array( 'author', 'collection', 'book-tag' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-book',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
			'show_in_rest'          => true,
		);
		register_post_type( 'book', $args );

	}

}
