<?php
/**
 * Plugin Name: Custom Post Type Manager
 * Description: Gestionnaire des Custom Post Types du site.
 * Version: 1.0.0
 * Author: Drakx116
 * Author URI: https://github.com/Drakx116
 */



// MAIN COURSES

add_action('init', 'init_main_course_cpt', 0);

function init_main_course_cpt() {
    $labels = [
        'name'                  => 'Main Courses',
        'singular_name'         => 'Main Course',
        'menu_name'             => 'Main Courses',
        'name_admin_bar'        => 'Main Courses',
        'archives'              => 'Main Course Archives',
        'attributes'            => 'Main Course Attributes',
        'parent_item_colon'     => 'Parent Main Course :',
        'all_items'             => 'All Main Courses',
        'add_new_item'          => 'Add New Main Course',
        'add_new'               => 'Add New',
        'new_item'              => 'New Main Course',
        'edit_item'             => 'Edit Main Course',
        'update_item'           => 'Update Main Course',
        'view_item'             => 'View Main Course',
        'view_items'            => 'View Main Course',
        'search_items'          => 'Search Main Course',
        'not_found'             => 'Not found',
        'not_found_in_trash'    => 'Not found in Trash',
        'featured_image'        => 'Featured Image',
        'set_featured_image'    => 'Set featured image',
        'remove_featured_image' => 'Remove featured image',
        'use_featured_image'    => 'Use as featured image',
        'insert_into_item'      => 'Insert into Main Course',
        'uploaded_to_this_item' => 'Uploaded to this Main Course',
        'items_list'            => 'Main Courses list',
        'items_list_navigation' => 'Main Courses list navigation',
        'filter_items_list'     => 'Filter Main Courses list'
    ];

    $rewrite = [
        'slug'                  => 'main-course',
        'with_front'            => true,
        'pages'                 => true,
        'feeds'                 => true
    ];

    $args = [
        'label'                 => 'Main Course',
        'labels'                => $labels,
        'supports'              => ['title', 'editor'],
        'taxonomies'            => ['category'],
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 50,
        'menu_icon'             => 'dashicons-food',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'query_var'             => 'main_course',
        'rewrite'               => $rewrite,
        'capability_type'       => 'page'
    ];

    register_post_type( 'main-course', $args );
}

if (function_exists('acf_add_options_page')) {
    acf_add_options_page([
        'page_title' => 'Contact',
        'menu_title' => 'Contact',
        'menu_slug' => 'contact',
        'post_id' => 'acf-contact',
        'capability' => 'edit_posts',
        'redirect' => true,
        'update_button' => __('Update', 'acf'),
        'updated_message' => __('Options Updated', 'acf'),
        'icon_url' => 'dashicons-admin-generic',
        'position' => 10
    ]);
}



// RESERVATION

function init_reservation_cpt() {
    $labels = [
        'name'                  => 'Reservations',
        'singular_name'         => 'Reservation',
        'menu_name'             => 'Reservation',
        'name_admin_bar'        => 'Reservation',
        'archives'              => 'Reservation Archives',
        'attributes'            => 'Reservation Attributes',
        'parent_item_colon'     => 'Parent Reservation :',
        'all_items'             => 'All Reservations',
        'add_new_item'          => 'Add New Reservation',
        'add_new'               => 'Add New',
        'new_item'              => 'New Reservation',
        'edit_item'             => 'Edit Reservation',
        'update_item'           => 'Update Reservation',
        'view_item'             => 'View Reservation',
        'view_items'            => 'View Reservations',
        'search_items'          => 'Search Reservation',
        'not_found'             => 'Not found',
        'not_found_in_trash'    => 'Not found in Trash',
        'featured_image'        => 'Featured Image',
        'set_featured_image'    => 'Set featured image',
        'remove_featured_image' => 'Remove featured image',
        'use_featured_image'    => 'Use as featured image',
        'insert_into_item'      => 'Insert into Reservation',
        'uploaded_to_this_item' => 'Uploaded to this Reservation',
        'items_list'            => 'Reservations list',
        'items_list_navigation' => 'Reservations list navigation',
        'filter_items_list'     => 'Filter Reservation list'
    ];

    $args = [
        'label'                 => 'Reservation',
        'description'           => 'Event Reservation',
        'labels'                => $labels,
        'supports'              => ['title', 'editor'],
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 25,
        'menu_icon'             => 'dashicons-phone',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page'
    ];

    register_post_type( 'reservation', $args );

}

add_action( 'init', 'init_reservation_cpt', 0 );
