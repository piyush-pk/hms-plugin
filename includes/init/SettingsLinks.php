<?php

namespace HMS\Includes\Init;

class SettingsLinks {
    // Holds the plugin name
    private $plugin;

    /**
     * Constructor to initialize the class
     */
    public function __construct() {
        // Ensure PHMS_LUGIN_NAME constant is defined
        if (defined('HMS_PLUGIN_NAME')) {
            $this->plugin = HMS_PLUGIN_NAME; // Assign the plugin name to the property
        } else {
            wp_die('HMS_PLUGIN_NAME constant is not defined.'); // Stop execution if HMS_PLUGIN_NAME is not defined
        }
    }

    /**
     * Register the settings link filter
     *
     * This method adds the settings link to the plugin's action links
     */
    public function register() {
        // Adds a filter to the plugin's action links to add a custom link
        add_filter("plugin_action_links_$this->plugin", [$this, 'settings_link']);
    }

    /**
     * Add a custom settings link
     *
     * This method creates a custom settings link and appends it to the plugin action links
     *
     * @param array $links Array of plugin action links
     * @return array Modified array of plugin action links
     */
    public function settings_link($links) {
        // Create a custom link to the HMS Dashboard
        $settings_link = '<a href="admin.php?page=hms_dashboard">Dashboard</a>';
        
        // Append the custom link to the existing action links
        array_push($links, $settings_link);
        
        // Return the modified array of links
        return $links;
    }
}
