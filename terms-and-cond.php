<?php

/*
Plugin Name: Terms and Conditions (Terminos y condiciones)
Description: Custom post type terms and conditions
Version:     20160919
Author:      Daniel Arriola (@dannielarriola)
Author URI:  https://danielarriola.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: terms-and-cond
Domain Path: /languages
*/

defined('ABSPATH') or die('Prohibido');

register_deactivation_hook(__FILE__, 'flush_rewrite_rules');
register_activation_hook(__FILE__, 'terms_and_cond_flush_rewrites');
function terms_and_cond_flush_rewrites()
{
    create_terms_and_cond();
    flush_rewrite_rules();
}

add_action('init', 'create_terms_and_cond');
function create_terms_and_cond()
{
    register_post_type('terms_and_cond',
        array(
            'labels' => array(
                'name' => __('Terms and Conditions', 'terms-and-cond'),
                'singular_name' => __('Term and Condition', 'terms-and-cond')
            ),
            'public' => true,
            'rewrite' => array('slug' => 'terminos'),
            'show_ui' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'query_var' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'excerpt'),
            'exclude_from_search' => false
        )
    );

    wp_enqueue_style('maincss', plugin_dir_url(__FILE__) . 'css/main.css');

    if (!is_admin()) {
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script("jquery-ui-dialog");
        wp_enqueue_script('main', home_url('/wp-content/plugins/terms-and-cond/js/main.js'));
        wp_localize_script('main', 'mainjs', array('ajaxurl' => admin_url('/admin-ajax.php'), 'homeurl' => get_home_url()));
    }
}

add_action('plugins_loaded', 'terms_load_textdomain');
function terms_load_textdomain()
{
    load_plugin_textdomain('terms-and-cond', false, plugin_dir_path(__FILE__) . '/languages/');
}

add_action('wp_ajax_terms_accepted', 'terms_accepted', 10, 2);
add_action('toc_terms_accepted', 'terms_accepted', 10, 2);
function terms_accepted($postid = null, $userid = null)
{
    if (empty($postid)) {
        $postid = intval($_POST['postid']);
    }

    if (empty($userid)) {
        $userid = get_current_user_id();
    }

    $post = get_post_meta($postid, 'terms_and_cond', true);
    if (empty($post)) {
        $values = array();
        array_push($values, $userid);
        $values = serialize($values);

        add_post_meta($postid, 'terms_and_cond', $values, true);
    } else {
        $values = unserialize($post);
        if (!in_array($userid, $values)) {
            array_push($values, $userid);
        }
        $values = serialize($values);
        update_post_meta($postid, 'terms_and_cond', $values);
    }
}

add_action('admin_menu', 'terms_and_cond_register_submenu');

function terms_and_cond_register_submenu()
{
    add_submenu_page(
        'edit.php?post_type=terms_and_cond',
        __('View Users', 'terms-and-cond'),
        __('View Users', 'terms-and-cond'),
        'manage_options',
        'view-users',
        'view_users'
    );
}

function view_users()
{
    include plugin_dir_path(__FILE__) . '/users.php';
}

add_shortcode('toc', 'toc_shortcode');

function toc_shortcode($atts, $content = null)
{
    $a = shortcode_atts(array(
        'id' => 0
    ), $atts);
    include plugin_dir_path(__FILE__) . '/shortcode/toc.php';
}

add_action('edit_form_after_title', 'myprefix_edit_form_after_title');

function myprefix_edit_form_after_title()
{
    $id = get_the_ID();
    if (!empty($id) && get_post_type($id) == 'terms_and_cond') {
        echo 'Shortcode: <strong>[toc id=' . $id . ']</strong>';
    }
}
