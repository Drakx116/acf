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
            self::$initialized = true;
        }

        self::log();
    }



    ###################
    ##### LOGGING #####
    ###################

    private static function log(): void
    {
    }



    ####################
    ##### DATABASE #####
    ####################

    private static function createDbSchema(): bool
    {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        global $wpdb;
        $tableName = $wpdb->prefix . 'logger';

        if ($wpdb->get_var("show tables like '$tableName'") === $tableName) {
            return false;
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

        return true;
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
