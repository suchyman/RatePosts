<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              suchyman.cloud
 * @since             1.0.0
 * @package           Rateposts
 *
 * @wordpress-plugin
 * Plugin Name:       RatePosts
 * Plugin URI:        localhost
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Suchyman
 * Author URI:        suchyman.cloud
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       rateposts
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'RATEPOSTS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-rateposts-activator.php
 */
function activate_rateposts() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rateposts-activator.php';
	Rateposts_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-rateposts-deactivator.php
 */
function deactivate_rateposts() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rateposts-deactivator.php';
	Rateposts_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_rateposts' );
register_deactivation_hook( __FILE__, 'deactivate_rateposts' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-rateposts.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_rateposts() {

	$plugin = new Rateposts();
	$plugin->run();

}
run_rateposts();

include_once('like-metabox.php');
include_once('like-post.php');
function enqueue_js_files() {

  wp_register_script( 'like-post', 'http://localhost/wp-content/plugins/rateposts/like-post.js', array('jquery') ,false,'1.0',true);
  wp_enqueue_script( 'like-post' );

}
add_action( 'wp_enqueue_scripts', 'enqueue_js_files' );


global $wpdb;
global $post;
add_filter('the_content', 'add_my_content');
function add_my_content($content) {
  global $post;
  $idek = $post->ID;
$my_custom_text = '


<a class="like" rel="' .$idek. '">' . likeCount($post->ID). ' likes</a> | <a class="unlike" rel="' .$idek. '">' . unlikeCount($post->ID). ' unlikes</a>
'; 

if(is_single() && !is_home()) {
$content .= $my_custom_text;
}
return $content;
}

add_action( 'wp_enqueue_scripts', 'wpse30583_enqueue' );
function wpse30583_enqueue()
{
 
    wp_enqueue_script( 'wpse30583_script' );

    $data = array( 
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'wpse30583_nonce' )
    );
    wp_localize_script( 'wpse30583_script', 'wpse3058_object', $data );
}
