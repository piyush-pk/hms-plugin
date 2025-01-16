<?php

namespace HMS\Includes\Init;

class Constants {
    public static function getCapabilities() {
        return [
            // 'hms_view_dashboard' => ['hms_admin'], // admin
            'hms_manage_hospitals' => ['hms_admin'], // admin
            'hms_view_reports' => ['hms_admin'], // admin
            'hms_add_patients' => ['hms_staff', 'hms_admin'], // staff, admin
            'hms_edit_patients' => ['hms_staff', 'hms_doctor', 'hms_admin'], // staff, doctor, admin
            'hms_view_patients' => ['hms_staff', 'hms_doctor', 'hms_admin'], // staff, doctor, admin
            'hms_add_staffs' => ['hms_admin'], // admin
            'hms_edit_staffs' => ['hms_admin'], // admin
            'hms_view_staffs' => ['hms_staff', 'hms_doctor', 'hms_admin'], // staff, doctor, admin
            'hms_add_doctors' => ['hms_admin'], // admin
            'hms_edit_doctors' => ['hms_admin'], // admin
            'hms_view_doctors' => ['hms_patient', 'hms_staff', 'hms_doctor', 'hms_admin'], // patient, staff, doctor, admin
            'hms_add_appointments' => ['hms_patient', 'hms_staff', 'hms_doctor', 'hms_admin'], // patient, staff, doctor, admin
            'hms_view_appointments' => ['hms_patient', 'hms_staff', 'hms_doctor', 'hms_admin'], // patient, staff, doctor, admin
            'hms_my_appointments' => ['hms_patient'], // patient, staff, doctor, admin
            'hms_view_todays_appointments' => ['hms_patient', 'hms_staff', 'hms_doctor', 'hms_admin'], // patient, staff, doctor, admin
            'hms_view_users' => ['hms_staff', 'hms_doctor', 'hms_admin'], // patient, staff, doctor, admin
            'hms_add_users' => ['hms_staff', 'hms_doctor', 'hms_admin'], // patient, staff, doctor, admin
            'read' => ['hms_patient', 'hms_staff', 'hms_doctor', 'hms_admin'], // patient, staff, doctor, admin
        ];
    }

    public static function getRoles() {
        return [
            [
                'role' => 'hms_admin',
                'name' => 'HMS Admin'
            ], 
            [
                'role' => 'hms_doctor',
                'name' => 'HMS Doctor'
            ],
            [
                'role' => 'hms_staff',
                'name' => 'HMS Staff'
            ],
            [
                'role' => 'hms_patient',
                'name' => 'HMS Patient'
            ]
        ];
    }

    public static $roles = [
        'hms_admin' => [
            'name' => 'HMS Admin',
            'role' => 'hms_admin'
        ],
        'hms_patient' => [
            'name'=> 'HMS Patient',
            'role' => 'hms_patient'
        ],
        'hms_staff' => [
            'name' => 'HMS Staff',
            'role' => 'hms_staff'
        ],
        'hms_doctor' => [
            'name'=> 'HMS Doctor',
            'role' => 'hms_doctor'
        ]
    ];

    public static function get_allowed_roles($role) {
        $role = $role['role'];
        if ($role === 'hms_admin') {
            return self::$roles;
        }

        if ($role === 'hms_doctor' || $role === 'hms_staff') {
            return array_filter(self::$roles, function ($key) {
                return in_array($key, ['hms_patient']);
            }, ARRAY_FILTER_USE_KEY);
        }
        
        // Return an empty array if the role doesn't match any condition
        return [];
    }
}
