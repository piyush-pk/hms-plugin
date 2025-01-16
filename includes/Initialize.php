<?php
namespace HMS\Includes;

class Initialize {
    /**
     * Initializes the plugin
     *
     * This method sets up hooks and loops through all defined classes,
     * calling their `register` methods to ensure they are properly initialized.
     */
    public static function init() {
        // Initialize activation and deactivation hooks
        self::initializeHooks();

        // add_action('admin_enqueue_scripts', [self::class, 'add_javascript']);

        // Loop through all defined classes and call their `register` method
        foreach (self::_getClasses() as $class) {
            // Check if the class exists to avoid errors
            if (class_exists($class)) {
                // Instantiate the class
                $instance = new $class();

                // Check if the class has a `register` method before calling it
                if (method_exists($instance, 'register')) {
                    $instance->register();
                }
            }
        }
    }

    public static function add_javascript() {
        // wp_enqueue_script('tailwind_css', HMS_PLUGIN_URL . 'assets/js/tailwind.js');
        wp_enqueue_script('tailwind_css', 'https://cdn.tailwindcss.com/');
        wp_enqueue_style('wp-admin'); // WordPress Admin Styles
        wp_enqueue_style('wp-pointer'); // Pointer UI for tooltips (optional)
        wp_enqueue_script('jquery'); // Ensure jQuery is loaded
    }

    /**
     * Returns a list of class names to be initialized
     *
     * This method provides a list of classes that need to be instantiated
     * and have their `register` methods called.
     *
     * @return array Array of fully qualified class names
     */
    public static function _getClasses() {
        return [
            Init\RegisterMenuPages::class, // Handles menu page registration
            Init\SettingsLinks::class,    // Adds settings links to the plugin
        ];
    }

    /**
     * Initializes activation and deactivation hooks
     *
     * This method directly registers hooks for activating and deactivating the plugin.
     * These hooks ensure proper setup and cleanup when the plugin is activated or deactivated.
     */
    public static function initializeHooks() {
        // Set the default timezone to Indian Kolkata timezone
        date_default_timezone_set('Asia/Kolkata');

        // Initialize pre activiation hooks
        self::pre_activation_hook_initialize();

        // Register the activation hook
        Init\Activate::class::register();

        // Register the deactivation hook
        Init\Deactivate::class::register();
    }

    private static function pre_activation_hook_initialize() {
        Init\UserExtended::init();
    }
}
