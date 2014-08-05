<?php
/**
* @package Remove Html Button
* @author Carlos Rios
* @version 0.1.9
*/
/*
Plugin Name: Remove Html Button
Plugin URI: http://www.1kingdomcreative.com
Description: Adds a button to TinyMCE that removes all of the html in a selection.
Author: Carlos Rios
Version: 0.1.9
Author URI: http://www.1kingdomcreative.com
*/

/**
* Add actions
*/
add_action('admin_head', function(){
  global $typenow;
  
  if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') )
 		return;

	if ( get_user_option('rich_editing') == 'true') {
    add_filter('mce_external_plugins', 'remove_html_plugin');
    add_filter('mce_buttons', 'register_remove_html_button');
	}
});

add_action('admin_enqueue_scripts', function(){
  wp_enqueue_style('remove-html-button', plugins_url('/remove-html-button.css', __FILE__));
  
  wp_register_script( 'remove_html_button', plugins_url( '/remove-html-button.js', __FILE__ ), 'jquery' );
  wp_enqueue_script( 'remove_html_button' );
  wp_localize_script( 'remove_html_button', 'remove_html_button', ['ajaxurl' => admin_url( 'admin-ajax.php' )] );
});

add_action( 'wp_ajax_remove_html', 'removeHtmlButtonAjax' );
add_action( 'wp_ajax_nopriv_remove_html', 'removeHtmlButtonAjax' );

/**
* Register needed functions
*/
function remove_html_plugin($plugin_array)
{
    $plugin_array['remove_html_button'] = plugins_url( '/remove-html-button.js', __FILE__ ); // CHANGE THE BUTTON SCRIPT HERE
    return $plugin_array;
}

function register_remove_html_button($buttons)
{
    array_push($buttons, 'remove_html_button');
    return $buttons;
}

function removeHtmlButtonAjax()
{
  $content = $_POST['content'];
  $content = strip_tags($content);
  $content = htmlspecialchars($content, ENT_QUOTES);

  echo $content;
  die;
}