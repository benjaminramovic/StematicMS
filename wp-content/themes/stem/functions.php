<?php 

function enqueue_jquery_bootstrap() {
    // Dodavanje Bootstrap CSS-a
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css');

    // Učitavanje jQuery-a (već dolazi sa WordPressom)
    wp_enqueue_script('jquery');

    // Dodavanje Bootstrap JS-a (zavisi od jQuery-a)
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_jquery_bootstrap');

error_reporting(E_ALL);
ini_set('display_errors', 1);


function load_stylesheets(){
    wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), 1, 'all');
    wp_enqueue_style('bootstrap');

    wp_register_style('pogoslider', get_template_directory_uri() . '/css/pogo-slider.min.css', array(), 1, 'all');
    wp_enqueue_style('pogoslider');

    wp_register_style('style', get_template_directory_uri() . '/css/style.css', array(), 1, 'all');
    wp_enqueue_style('style');

    wp_register_style('responsive', get_template_directory_uri() . '/css/responsive.css', array(), 1, 'all');
    wp_enqueue_style('responsive');

    wp_register_style('custom', get_template_directory_uri() . '/css/custom.css', array(), 1, 'all');
    wp_enqueue_style('custom');
}



add_action('wp_enqueue_scripts','load_stylesheets');

add_filter('show_admin_bar', '__return_false');


?>