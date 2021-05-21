<?php

class Logger
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
            self::logAdminActions();
            self::$initialized = true;
        }
    }

    ###################
    ##### LOGGING #####
    ###################



    private static function logAdminActions(): void
    {
        add_action('save_post', [ 'Logger', 'log' ], 10, 3);
        add_action('before_delete_post', [ 'Logger', 'log' ]);
    }

    public static function log($id, $post, $updated): void
    {
        self::saveLog($id, $post, $updated);
    }

    private static function saveLog($id, $post, $updated): void
    {
        global $wpdb;
        $table = $wpdb->prefix . 'logger';

        if (!$user = wp_get_current_user()) {
            return; // Should never be thrown
        }

        $admin = $user->to_array();
        $entity = $post->to_array();

        $type = $entity['post_type'];
        if ($type === 'revision') {
            return; // Do not log revisions
        }

        $data = [
            'action' => ($entity['post_title'] === 'Auto Draft') ? 'CREATION' : 'UPDATE',
            'entity' => $id,
            'type' => strtoupper($type),
            'user' => $admin['user_email'],
            'date' => (new DateTime())->format('Y-m-d H:i:s')
        ];

        $wpdb->insert($table, $data);
    }


    ####################
    ##### DATABASE #####
    ####################

    private static function createDbSchema(): void
    {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        global $wpdb;
        $tableName = $wpdb->prefix . 'logger';

        if ($wpdb->get_var("show tables like '$tableName'") === $tableName) {
            return;
        }

        $query = "
            CREATE TABLE IF NOT EXISTS ". $tableName ."
              (
                 `id` INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
                 `action` VARCHAR(16) NOT NULL,
                 `entity` INT(16) NOT NULL,
                 `type` VARCHAR(32) NOT NULL,
                 `user` VARCHAR(64) NOT NULL,
                 `date` DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL
              )
            engine=innodb
            DEFAULT charset=utf8;
        ";

        dbDelta($query);
    }



    ###########################
    ##### MENU RENDERING #####
    ###########################

    private static function createMenu(): void
    {
        add_action('admin_menu', [ 'Logger', 'generateMenu' ]);
    }

    public function generateMenu(): void
    {
        add_menu_page(
            'Logger - List',
            'Logger',
            'administrator',
            'logger',
            [ 'Logger', 'renderLogPage' ],
        );
    }

    public static function renderLogPage(): void
    {
        self::render('logger');
    }

    private static function render(string $file): void
    {
        require_once plugin_dir_path( __FILE__) . 'templates/' . $file . '.php';
    }
}
