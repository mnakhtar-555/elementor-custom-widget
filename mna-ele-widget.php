<?php
/*
Plugin Name: Custom Nav Menu Widget
Description: A custom Elementor widget to display a dynamically selected menu.
Version: 1.0
Author: Your Name
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register List Widget.
 *
 * Include widget file and register widget class.
 *
 * @since 1.0.0
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */
function register_list_widget( $widgets_manager ) {

	require_once( __DIR__ . '/widgets/mna-widget.php' );
	require_once( __DIR__ . '/widgets/mna-post-widget.php' );

	$widgets_manager->register( new \Custom_Nav_Menu_Widget() );
	$widgets_manager->register( new \Custom_Posts_Widget() );

}
add_action( 'elementor/widgets/register', 'register_list_widget' );