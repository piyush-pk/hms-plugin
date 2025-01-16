<?php

namespace HMS\Includes\Init;

/**
 * Class Deactivate
 *
 * Handles the deactivation logic for the plugin.
 */
class Deactivate {

    /**
     * Deactivation logic for the plugin.
     *
     * This method is called when the plugin is deactivated. 
     * Add any cleanup tasks here, such as removing scheduled hooks or resetting settings.
     */
    public static function deactivate() {
        // Add your deactivation logic here
        // Example: wp_clear_scheduled_hook('my_custom_cron_event');
        self::remove_capabilities();
    }

    private static function remove_capabilities() {
        $capabilities = Constants::class::getCapabilities();

        foreach ($capabilities as $capability => $roles) {
            foreach ($roles as $roleName) {
                $role = get_role($roleName);
                if ($role) {
                    $role->remove_cap($capability);
                }
            }
        }
    }

    /**
     * Registers the deactivation hook.
     *
     * The `register_deactivation_hook` is used to specify the method to be executed
     * when the plugin is deactivated.
     */
    public static function register() {
        // `HMS_PLUGIN_MAIN_FILE` should be defined in the main plugin file
        // Example: define('HMS_PLUGIN_MAIN_FILE', __FILE__);
        register_deactivation_hook(HMS_PLUGIN_MAIN_FILE, [self::class, 'deactivate']);
    }
}
