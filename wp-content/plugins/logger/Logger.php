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

    private static function createDbSchema(): void
    {

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
