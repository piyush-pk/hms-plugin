<?php

namespace HMS\Includes\Models;

use DateTime;

class User {
    public static function get_users_with_condition(array $conditions = []) {
        return get_users($conditions);
    }

    public static function get_user_by_id(int $id) {
        return get_user($id);
    }

    public static function get_all_patients() {
        return get_users([
            'role__in' => ['hms_patient']
        ]);
    }

    public static function get_all_doctors() {
        return get_users([
            'role__in' => ['hms_doctor']
        ]);
    }

    public static function get_all_staffs() {
        return get_users([
            'role__in' => ['hms_staff']
        ]);
    }

    public static function get_all_admins() {
        return get_users([
            'role' => 'hms_admin'
        ]);
    }


    public static function get_all_users() {
        return get_users([
            'role__in' => ['hms_admin', 'hms_doctor', 'hms_staff', 'hms_patient']
        ]);
    }

    public static function get_user_as_per_role() {
        $roles = wp_get_current_user()->roles;
        switch ($roles[0]) {
            case 'hms_admin':
                return [
                    'patients'=> self::get_all_patients(),
                    'doctors' => self::get_all_doctors(),
                    'staff' => self::get_all_staffs(),
                    'admin' => self::get_all_admins(),
                ];
            case 'hms_staff':
                return [
                    'patients'=> self::get_all_patients(),
                    'doctors' => self::get_all_doctors(),
                    'staff' => self::get_all_staffs(),
                ];
            case 'hms_doctor':
                return [
                    'patients'=> self::get_all_patients(),
                    'doctors' => self::get_all_doctors(),
                    'staff' => self::get_all_staffs(),
                ];
            case 'hms_patient':
                return [
                    'patients'=> self::get_all_patients(),
                    'doctors' => self::get_all_doctors(),
                    'staff' => self::get_all_staffs(),
                ];
            default:
                return [];
        }
    }

    public static function get_role_name($user = null) {
        if($user === null) {
            $user = self::get_current_user();
        }
        $roles = \HMS\Includes\Init\Constants::$roles;
        if(count($user->roles) == 1) {
            return $roles[$user->roles[0]];
        }
        return 'Error !!!';
    }

    public static function get_current_user() {
        return wp_get_current_user();
    }

    public static function calculate_age($dob = null) {
        if($dob === null) {
            return;
        }
        $dob = new DateTime($dob); // Create a DateTime object from the DOB
        $now = new DateTime();    // Get the current date
        $age = $now->diff($dob);  // Calculate the difference
        return $age->y;           // Return the age in years
    }
}