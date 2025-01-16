<?php

namespace HMS\Includes\Init;

/**
 * Class Activate
 *
 * Handles the activation logic for the plugin.
 */
class Activate {

    /**
     * Activation logic for the plugin.
     *
     * This method is executed when the plugin is activated.
     * It performs tasks such as:
     * - Setting up custom rewrite rules.
     * - Creating default options or settings.
     * - Adding custom user roles and capabilities.
     * - Creating necessary database tables.
     * - Adding custom fields to user profiles.
     */
    public static function activate() {
        self::setup_user_roles();
        self::setup_user_capabilities();
        self::add_custom_rewrite_rules();
        self::create_database_tables();
    }

    /**
     * Adds custom rewrite rules and modifies the admin menu.
     */
    private static function add_custom_rewrite_rules() {
        // Add custom rewrite rule
        add_action('init', function () {
            add_rewrite_rule(
                '^wp-admin/hms-hospital\.php$',
                'wp-admin/admin.php?page=hms-hospitals',
                'top'
            );
        });

        // Modify admin menu to use custom slug
        add_action('admin_menu', function () {
            global $submenu;
            $custom_slug = 'hms-hospital.php';
            if (isset($submenu['hms-hospitals'][0])) {
                $submenu['hms-hospitals'][0][2] = $custom_slug;
            }
        });

        // Flush rewrite rules once
        add_action('init', function () {
            flush_rewrite_rules();
        }, 999);
    }

    /**
     * Sets up custom user roles for the plugin.
     */
    private static function setup_user_roles() {
        $roles = Constants::getRoles();

        foreach ($roles as $role) {
            add_role($role['role'], $role['name'], []);
        }
    }

    /**
     * Sets up capabilities for different user roles.
     */
    private static function setup_user_capabilities() {
        $capabilities = Constants::getCapabilities();

        foreach ($capabilities as $capability => $roles) {
            foreach ($roles as $roleName) {
                $role = get_role($roleName);
                if ($role) {
                    $role->add_cap($capability);
                }
            }
        }
    }

    /**
     * Creates necessary database tables for the plugin.
     */
    private static function create_database_tables() {
        self::create_hospital_table();
        self::create_staff_table();
        self::create_doctor_table();
        self::create_patient_table();
        self::create_appointments_table();
        self::create_medical_history_table();
    }

    /**
     * Creates the hospital table in the database.
     */
    private static function create_hospital_table() {
        $hospital = new \HMS\Includes\Models\Hospital();
        $hospital->create();
    }

    /**
     * Creates the staff table in the database.
     */
    private static function create_staff_table() {
        $staff = new \HMS\Includes\Models\Staff();
        $staff->create();
    }

    /**
     * Creates the doctor table in the database.
     */
    private static function create_doctor_table() {
        $doctor = new \HMS\Includes\Models\Doctor();
        $doctor->create();
    }

    /**
     * Creates the patient table in the database.
     */
    private static function create_patient_table() {
        $patient = new \HMS\Includes\Models\Patient();
        $patient->create();
    }

    /**
     * Creates the appointments table in the database.
     */
    private static function create_appointments_table() {
        $appointment = new \HMS\Includes\Models\Appointment();
        $appointment->create();
    }

    /**
     * Creates the medical history table in the database.
     */
    private static function create_medical_history_table() {
        $mh = new \HMS\Includes\Models\MedicalHistory();
        $mh->create();
    }

    /**
     * Registers the activation hook for the plugin.
     */
    public static function register() {
        register_activation_hook(HMS_PLUGIN_MAIN_FILE, [self::class, 'activate']);
    }
}