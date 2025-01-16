<?php
/**
 * @package HMS
 */

namespace HMS\Includes\Init;

final class RegisterMenuPages {

    /**
     * Hooks into WordPress to register menu pages
     */
    public function register() {
        // Adds the initializeAllPages method to the WordPress 'admin_menu' action
        add_action('admin_menu', [__CLASS__, 'initializeAllPages']);
    }

    /**
     * Registers all menu pages
     *
     * This method organizes the registration of multiple menu pages,
     * each corresponding to a specific management section of the HMS plugin.
     */
    public static function initializeAllPages() {
        $current_user = wp_get_current_user();
        $user_role = $current_user->roles[0];
        $pages = Pages::class::pages();
        foreach ($pages as $page) {
            self::addPage($page);
            if (array_key_exists('submenus', $page)) {
                foreach ($page['submenus'] as $submenu) {
                    self::addSubmenuPage($submenu);
                }
            }
        }
    }

    /**
     * Adds a page to the WordPress admin menu
     */
    public static function addPage($page) {
        add_menu_page(
            $page['page_title'],
            $page['menu_title'],
            $page['capability'],
            $page['menu_slug'],
            $page['content_callback'],
            $page['icon'],
            $page['position']
        );
    }

    /**
     * Adds a submenu page to the WordPress admin menu
     */
    public static function addSubmenuPage($sub_page) {
        add_submenu_page(
            $sub_page['parent_slug'],
            $sub_page['page_title'],
            $sub_page['menu_title'],
            $sub_page['capability'],
            $sub_page['menu_slug'],
            $sub_page['content_callback'],
            $sub_page['position']
        );
    }
}
