<?php
/**
 * Cata Featured Content
 *
 * @package   Cata/Featured_Content
 * @author    Thought & Expression Co. <devjobs@thought.is>
 * @copyright 2021 Thought & Expression Co.
 * @license   GNU GENERAL PUBLIC LICENSE
 *
 * @wordpress-plugin
 * Plugin Name: Cata Featured Content
 * Description: Provide a Featured Content taxonomy.
 * Author:      Thought & Expression Co. <devjobs@thought.is>
 * Author URI:  https://thought.is
 * Version:     0.1.0
 * License:     GPL v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 */

/**
 * Register Taxonomy
 */
function cata_feature_content_register_taxonomy(): void {
	$labels = array(
		'name'              => _x( 'Featured Content', 'taxonomy general name', 'cata' ),
		'singular_name'     => _x( 'Featured Content', 'taxonomy singular name', 'cata' ),
		'search_items'      => __( 'Search Featured Content', 'cata' ),
		'all_items'         => __( 'All Featured Content', 'cata' ),
		'parent_item'       => __( 'Parent Featured Content', 'cata' ),
		'parent_item_colon' => __( 'Parent Featured Content:', 'cata' ),
		'edit_item'         => __( 'Edit Featured Content', 'cata' ),
		'update_item'       => __( 'Update Featured Content', 'cata' ),
		'add_new_item'      => __( 'Add New Featured Content', 'cata' ),
		'new_item_name'     => __( 'New Featured Content Name', 'cata' ),
		'menu_name'         => __( 'Featured Content', 'cata' ),
	);
	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Featured content', 'cata' ),
		'hierarchical'       => true,
		'public'             => false,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => false,
		'show_in_nav_menus'  => false,
		'show_tagcloud'      => false,
		'show_in_quick_edit' => true,
		'show_admin_column'  => true,
		'show_in_rest'       => true,
		'capabilities' => array(
			'manage_terms' => 'manage_options',
			'edit_terms'   => 'manage_options',
			'delete_terms' => 'manage_options',
		)
	);
	register_taxonomy( 'cata_featured_content', ['post'], $args );
}
add_action( 'init', 'cata_feature_content_register_taxonomy' );

/**
 * Activation Hook
 */
function cata_featured_content_activate() : void {
	// Since this happens before the init action,
	// register the taxonomy before creating the term.
	cata_feature_content_register_taxonomy();
	wp_create_term( 'Featured', 'cata_featured_content' );
}
// register_activation_hook( __FILE__, 'cata_featured_content_activate' );

/**
 * Block Editor Assets
 * Hide the button that adds a new term since we aren't allowing that.
 */
function cata_featured_content_block_editor_assets(): void {
	wp_enqueue_style(
		'cata-featured-content-editor',
		plugin_dir_url( __FILE__ ) . 'assets/dist/css/block-editor.css',
		ver: get_plugin_data( __FILE__ )['Version']
	);
}
add_action( 'enqueue_block_editor_assets', 'cata_featured_content_block_editor_assets' );
