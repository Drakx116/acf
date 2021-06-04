<?php

class ReservationManager
{
    /**
     * @var bool
     */
    private static $initialized = false;

    public static function init(): void
    {
        if (!self::$initialized) {
            self::createDbSchema();
            self::createMenu();
            self::$initialized = true;
        }
    }



    ####################
    ##### DATABASE #####
    ####################

    private static function createDbSchema(): void
    {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        global $wpdb;
        $tableName = $wpdb->prefix . 'reservation';

        if ($wpdb->get_var("show tables like '$tableName'") === $tableName) {
            return;
        }

        $query = "
            CREATE TABLE IF NOT EXISTS `wp_reservation`
              (
                 `id` INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
                 `reservation` BIGINT(20) UNSIGNED,
                 `people` INT(16) NOT NULL,
                 `phone` VARCHAR(32) NOT NULL,
                 `email` VARCHAR(64) NOT NULL,
                 FOREIGN KEY(`reservation`) REFERENCES " . $wpdb->prefix . "posts(`ID`)
              )
            engine=innodb
            DEFAULT charset=UTF8;
        ";

        dbDelta($query);
    }



    ###########################
    ##### MENU RENDERING #####
    ###########################

    private static function createMenu(): void
    {
        add_action('admin_menu', [ 'ReservationManager', 'generateMenu' ]);
    }

    public function generateMenu(): void
    {
        add_menu_page(
            'Reservations - List',
            'Reservation Manager',
            'administrator',
            'reservation-manager',
            [ 'ReservationManager', 'renderReservationPage' ],
        );
    }

    public static function renderReservationPage(): void
    {
        self::render('reservations');
    }

    private static function render(string $file): void
    {
        require_once plugin_dir_path( __FILE__) . 'templates/' . $file . '.php';
    }

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

}
