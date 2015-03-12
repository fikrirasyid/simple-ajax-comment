<?php
/**
 * Ajaxify your comment
 *  
 * @package Simple_Ajax_Comment
 * @author Fikri Rasyid
 * @version 1.0.0
 *
 * @wordpress
 * Plugin Name: Simple Ajax Comment
 * Plugin URI: 
 * Description: Ajaxify your comment submission
 * Author: <a href="http://fikrirasy.id">Fikri Rasyid</a>
 * Version: 1.0.0
 * Text Domain: simple-ajax-comment
 */

/**
 * Load the script
 * Most of the time, the script will be used at is_singular(). Make this pluggable tho, just in case the single page is displayed as overlay on other page
 */
function simple_ajax_comment_script(){
	if( apply_filters( 'simple_ajax_comment_is_used', is_singular() ) ){
		/**
		 * Load the js script
		 */
		wp_enqueue_script( 'simple-ajax-comment-script', plugin_dir_url( __FILE__ ) . 'js/simple-ajax-comment.js' , array( 'jquery', 'jquery-form' ), '1.0.0' );

		/**
		 * Error messages can be obtained from /wp-includes/comment.php. Look for a line which uses wp_die()
		 * Its error code can be used to identify proper error response. 
		 */
		wp_localize_script( 'simple-ajax-comment-script', 'simple_ajax_comment_params', apply_filters( 'simple_ajax_comment_params', array(
			'error_messages' => array(
				'409' => __( 'Duplicate comment detected; it looks as though you have already said that!' ),
				'429' => __( 'You are posting comments too quickly. Slow down.' )
			)
		)));
	}
}
add_action( 'wp_enqueue_scripts', 'simple_ajax_comment_script' );

/**
 * Adding processing message at comment form
 * Use inline style so we don't need to load more file
 */
function simple_ajax_comment_form_mod( $settings ){
	printf( '<div id="submitting-comment" style="padding: 15px 20px; text-align: center; display: none;">%s</div>', __( 'Submitting comment...' ) );
}
add_action( 'comment_form', 'simple_ajax_comment_form_mod' );