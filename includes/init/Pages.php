<?php

namespace HMS\Includes\Init;

class Pages {

    public static function pages() {
        return array_merge(
            self::admin_pages(),
            self::appointment_pages(),
            self::doctors_pages(),
            self::staff_pages(),
            self::patient_pages(),
            self::user_pages()
        );
    }

    // Generate a page with submenus
    private static function generate_page_with_submenus($page_title, $menu_title, $capability, $menu_slug, $icon, $position, $submenus = []) {
        return [
            'page_title' => $page_title,
            'menu_title' => $menu_title,
            'capability' => $capability,
            'menu_slug' => $menu_slug,
            'content_callback' => [__CLASS__, 'render' . str_replace(' ', '', $page_title) . 'Page'],
            'icon' => $icon,
            'position' => $position,
            'submenus' => $submenus
        ];
    }

    // Admin pages
    public static function admin_pages() {
        return [
            self::generate_page_with_submenus('HMS Dashboard', 'HMS Dashboard', 'hms_view_dashboard', 'hms-dashboard', 'dashicons-admin-multisite', 2),
            self::generate_page_with_submenus('Hospitals', 'Hospitals', 'hms_manage_hospitals', 'hms-hospital', 'dashicons-building', 3, [
                [
                    'parent_slug' => 'hms-hospital',
                    'page_title' => 'View Hospitals',
                    'menu_title' => 'View Hospitals',
                    'capability' => 'hms_manage_hospitals',
                    'menu_slug' => 'hms-view-hospitals',
                    'content_callback' => [__CLASS__, 'renderViewHospitalsPage'],
                    'position' => 1
                ]
            ]),
            self::generate_page_with_submenus('Reports', 'Reports', 'hms_view_reports', 'hms-reports', 'dashicons-chart-pie', 8, [
                [
                    'parent_slug' => 'hms-reports',
                    'page_title' => 'Reports Management',
                    'menu_title' => 'Reports Management',
                    'capability' => 'hms_view_reports',
                    'menu_slug' => 'hms-reports-management',
                    'content_callback' => [__CLASS__, 'renderReportsPage'],
                    'position' => 1
                ]
            ])
        ];
    }

    // Doctors pages
    public static function doctors_pages() {
        return [
            self::generate_page_with_submenus('Doctors', 'Doctors', 'hms_view_doctors', 'hms-doctors', 'dashicons-heart', 5, [
                [
                    'parent_slug' => 'hms-doctors',
                    'page_title' => 'View Doctors',
                    'menu_title' => 'All Doctors',
                    'capability' => 'hms_view_doctors',
                    'menu_slug' => 'hms-doctors',
                    'content_callback' => [__CLASS__, 'renderViewDoctorsPage'],
                    'position' => 1
                ],
                [
                    'parent_slug' => 'hms-doctors',
                    'page_title' => 'Add New Doctors',
                    'menu_title' => 'Add New Doctors',
                    'capability' => 'hms_add_doctors',
                    'menu_slug' => 'hms-add-doctors',
                    'content_callback' => [__CLASS__, 'renderAddDoctorsPage'],
                    'position' => 2
                ]
            ])
        ];
    }

    // Staff pages
    public static function staff_pages() {
        return [
            self::generate_page_with_submenus('Staff', 'Staff', 'hms_view_staffs', 'hms-staff', 'dashicons-admin-users', 4, [
                [
                    'parent_slug' => 'hms-staff',
                    'page_title' => 'View Staff',
                    'menu_title' => 'All Staff Members',
                    'capability' => 'hms_view_staffs',
                    'menu_slug' => 'hms-staff',
                    'content_callback' => [__CLASS__, 'renderStaffPage'],
                    'position' => 1
                ],
                [
                    'parent_slug' => 'hms-staff',
                    'page_title' => 'Add New Staff',
                    'menu_title' => 'Add New Staff',
                    'capability' => 'hms_add_staffs',
                    'menu_slug' => 'hms-add-staff-member',
                    'content_callback' => [__CLASS__, 'renderStaffAddPage'],
                    'position' => 2
                ]
            ])
        ];
    }

    // Patient pages
    public static function patient_pages() {
        return [
            self::generate_page_with_submenus('Patients', 'Patients', 'hms_view_patients', 'hms-patients', 'dashicons-buddicons-buddypress-logo', 6, [
                
                [
                    'parent_slug' => 'hms-patients',
                    'page_title' => 'View Patients',
                    'menu_title' => 'View Patients',
                    'capability' => 'hms_view_patients',
                    'menu_slug' => 'hms-patients',
                    'content_callback' => [__CLASS__, 'renderPatientsPage'],
                    'position' => 2
                ],
                [
                    'parent_slug' => 'hms-patients',
                    'page_title' => 'Add Patients',
                    'menu_title' => 'Add Patients',
                    'capability' => 'hms_add_patients',
                    'menu_slug' => 'hms-add-patient',
                    'content_callback' => [__CLASS__, 'renderAddPatientsPage'],
                    'position' => 3
                ]
            ])
        ];
    }

    // Appointment pages
    public static function appointment_pages() {
        return [
            self::generate_page_with_submenus('Appointments', 'Appointments', 'hms_view_appointments', 'hms-appointments', 'dashicons-calendar', 7, [
                [
                    'parent_slug' => 'hms-appointments',
                    'page_title' => 'All Appointments',
                    'menu_title' => 'All Appointments',
                    'capability' => 'hms_view_appointments',
                    'menu_slug' => 'hms-appointments',
                    'content_callback' => [__CLASS__, 'renderAllAppointmentsPage'],
                    'position' => 1
                ],
                [
                    'parent_slug' => 'hms-appointments',
                    'page_title' => 'Today\'s Appointments',
                    'menu_title' => 'Today\'s Appointments',
                    'capability' => 'hms_view_todays_appointments',
                    'menu_slug' => 'hms-today-appointments',
                    'content_callback' => [__CLASS__, 'renderAllTodaysAppointmentsPage'],
                    'position' => 2
                ],
                [
                    'parent_slug' => 'hms-appointments',
                    'page_title' => 'My Appointments',
                    'menu_title' => 'My Appointments',
                    'capability' => 'hms_my_appointments',
                    'menu_slug' => 'hms-my-appointments',
                    'content_callback' => [__CLASS__, 'renderAllMyAppointmentsPage'],
                    'position' => 3
                ],
                [
                    'parent_slug' => 'hms-appointments',
                    'page_title' => 'Add Appointments',
                    'menu_title' => 'Add Appointments',
                    'capability' => 'hms_edit_appointments',
                    'menu_slug' => 'hms-add-appointments',
                    'content_callback' => [__CLASS__, 'renderAddAppointmentsPage'],
                    'position' => 4
                ]
            ])
        ];
    }

    // User Pages
    public static function user_pages() {
        return [
            self::generate_page_with_submenus('Users', 'Users', 'hms_view_users', 'hms-users', 'dashicons-buddicons-buddypress-logo', 9, [
                [
                    'parent_slug' => 'hms-users',
                    'page_title' => 'All Users',
                    'menu_title' => 'All Users',
                    'capability' => 'hms_view_users',
                    'menu_slug' => 'hms-users',
                    'content_callback' => [__CLASS__, 'renderViewAllUsersPage'],
                    'position' => 1
                ],
                [
                    'parent_slug' => 'hms-users',
                    'page_title' => 'Add Users',
                    'menu_title' => 'Add Users',
                    'capability' => 'hms_add_users',
                    'menu_slug' => 'hms-add-users',
                    'content_callback' => [__CLASS__, 'renderAddNewUsersPage'],
                    'position' => 2
                ],
            ])
        ];
    }

    public static function renderPatientViewPage() {
        return require_once HMS_PLUGIN_PATH . 'templates/patient/view-patients.php';
    }

    // Render Methods
    public static function renderHospitalsPage() {
        return require_once HMS_PLUGIN_PATH . 'templates/hospital/add-hospital.php';
    }

    public static function renderViewHospitalsPage() {
        return require_once HMS_PLUGIN_PATH . 'templates/hospital/view-hospital.php';
    }

    public static function renderStaffPage() {
        return require_once HMS_PLUGIN_PATH . 'templates/staff/view-staff.php';
    }

    public static function renderStaffAddPage() {
        return require_once HMS_PLUGIN_PATH . 'templates/staff/add-staff.php';
    }

    public static function renderDoctorsPage() {
        return require_once HMS_PLUGIN_PATH . 'templates/doctors/view-doctors.php';
    }

    public static function renderPatientsPage() {
        return require_once HMS_PLUGIN_PATH . 'templates/patient/view-patients.php';
    }

    public static function renderAddPatientsPage() {
        return require_once HMS_PLUGIN_PATH . 'templates/patient/add-patients.php';
    }

    public static function renderViewDoctorsPage() {
        return require_once HMS_PLUGIN_PATH . 'templates/doctors/view-doctors.php';
    }

    public static function renderAddDoctorsPage() {
        return require_once HMS_PLUGIN_PATH . 'templates/doctors/add-doctor.php';
    }

    public static function renderEditPatientsPage() {
        return require_once HMS_PLUGIN_PATH . 'templates/patient/edit-patients.php';
    }

    public static function renderAppointmentsPage() {
        return require_once HMS_PLUGIN_PATH . 'templates/appointment/view-appointments.php';
    }

    public static function renderAllTodaysAppointmentsPage() {
        return require_once HMS_PLUGIN_PATH . 'templates/appointment/todays-appointments.php';
    }

    public static function renderAllAppointmentsPage() {
        return require_once HMS_PLUGIN_PATH . 'templates/appointment/view-appointments.php';
    }

    public static function renderAllMyAppointmentsPage() {
        return require_once HMS_PLUGIN_PATH . 'templates/appointment/my-appointments.php';
    }

    public static function renderAddAppointmentsPage() {
        return require_once HMS_PLUGIN_PATH . 'templates/appointment/add-appointments.php';
    }

    public static function renderUsersPage() {
        return require_once HMS_PLUGIN_PATH . 'templates/users/view-all-users.php';
    }

    public static function renderViewAllUsersPage() {
        return require_once HMS_PLUGIN_PATH . 'templates/users/view-all-users.php';
    }

    public static function renderAddNewUsersPage() {
        return require_once HMS_PLUGIN_PATH . 'templates/users/add-new-user.php';
    }

    public static function renderReportsPage() {
        echo '<h1>Reports Management</h1>';
    }

    public static function renderHMSDashboardPage() {
        echo '<h1>Dashboard Management</h1>';
    }
}
