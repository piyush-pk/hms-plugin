<?php

namespace HMS\Includes\Init;

use function PHPSTORM_META\map;

/**
 * Class UserExtended
 */
class UserExtended
{

    /**
     * Initialize the user extension
     */
    public static function init()
    {
        // Hook into WordPress to register and handle user fields
        add_action('init', [self::class, 'register_user_meta']);
        add_action('show_user_profile', [self::class, 'add_custom_user_fields']);
        add_action('edit_user_profile', [self::class, 'add_custom_user_fields']);
        add_action('user_new_form', [self::class, 'add_custom_fields_to_new_user_form']);
        add_action('personal_options_update', [self::class, 'save_custom_user_fields']);
        add_action('edit_user_profile_update', [self::class, 'save_custom_user_fields']);
        add_action('user_register', [self::class, 'save_new_user_custom_fields']);

        // Filter user roles to only show Patient, Doctor, and Staff
        add_filter('editable_roles', [self::class, 'filter_user_roles']);

        // Hook the redirect function to the login redirect filter
        add_filter('login_redirect', [self::class, 'redirect_to_profile_after_login'], 10, 3);

        // Hook the admin access restriction function to the admin init action
        // add_action('admin_init', [self::class, 'redirect_non_administrators']);
    }

    /**
     * Redirects all users to their profile page after login.
     *
     * @param string $redirect_to   The URL to redirect to after login.
     * @param string $request       The requested redirect URL.
     * @param WP_User $user         The logged-in user object.
     * @return string               The modified redirect URL.
     */
    public static function redirect_to_profile_after_login($redirect_to, $request, $user)
    {
        // Check if the user is valid and not an error
        if (isset($user->roles) && is_array($user->roles)) {
            // Redirect all users to their profile page
            return admin_url('profile.php');
        }
        return $redirect_to; // Default redirect if no user is found
    }

    /**
     * Redirects non-administrator users to their profile page in the admin area.
     */
    public static function redirect_non_administrators()
    {
        // Check if the user is in the admin area and not an administrator
        if (is_admin() && !current_user_can('manage_options') && !defined('DOING_AJAX')) {
            // Get the current page being accessed
            global $pagenow;

            // Allow access to the profile.php page to avoid redirect loops
            if ($pagenow !== 'profile.php') {
                wp_redirect(admin_url('profile.php'));
                exit;
            }
        }
    }


    /**
     * Filter user roles to only show Patient, Doctor, and Staff
     */
    public static function filter_user_roles($roles)
    {
        // Only show custom roles (Patient, Doctor, Staff)
        $allowed_roles = array_map(function ($v) {
            return $v['role'];
        }, Constants::getRoles());

        // Filter out the default roles
        foreach ($roles as $role_key => $role) {
            if (!in_array($role_key, $allowed_roles)) {
                unset($roles[$role_key]);
            }
        }

        return $roles;
    }


    /**
     * Register custom user meta fields
     */
    public static function register_user_meta()
    {
        register_meta('user', 'dob', [
            'type'         => 'string',
            'description'  => 'Date of Birth',
            'single'       => true,
            'show_in_rest' => true,
        ]);

        register_meta('user', 'gender', [
            'type'         => 'string',
            'description'  => 'Gender',
            'single'       => true,
            'show_in_rest' => true,
        ]);

        register_meta('user', 'blood_group', [
            'type'         => 'string',
            'description'  => 'Blood Group',
            'single'       => true,
            'show_in_rest' => true,
        ]);

        register_meta('user', 'mobile', [
            'type'         => 'string',
            'description'  => 'Mobile Number',
            'single'       => true,
            'show_in_rest' => true,
        ]);

        register_meta('user', 'marital_status', [
            'type'         => 'string',
            'description'  => 'Marital Status',
            'single'       => true,
            'show_in_rest' => true,
        ]);

        register_meta('user', 'address', [
            'type'         => 'string',
            'description'  => 'Address',
            'single'       => true,
            'show_in_rest' => true,
        ]);

        register_meta('user', 'hospital_id', [
            'type'         => 'integer',
            'description'  => 'Hospital ID',
            'single'       => true,
            'show_in_rest' => true,
        ]);
    }

    /**
     * Add custom fields to the Edit User page
     */
    public static function add_custom_user_fields($user)
    {
        $dob = get_user_meta($user->ID, 'dob', true);
        $gender = get_user_meta($user->ID, 'gender', true);
        $blood_group = get_user_meta($user->ID, 'blood_group', true);
        $mobile = get_user_meta($user->ID, 'mobile', true);
        $marital_status = get_user_meta($user->ID, 'marital_status', true);
        $address = get_user_meta($user->ID, 'address', true);
        $hospital_id = get_user_meta($user->ID, 'hospital_id', true);

        $model = new \HMS\Includes\Models\Hospital();
        $hospitals = $model->getAllActiveHospitals();

?>
        <h3>Additional Information</h3>
        <table class="form-table">
            <tr>
                <th><label for="dob">Date of Birth</label></th>
                <td><input type="date" name="dob" id="dob" value="<?php echo esc_attr($dob); ?>" class="regular-text" /></td>
            </tr>
            <tr>
                <th><label for="gender">Gender</label></th>
                <td>
                    <select name="gender" id="gender" class="regular-text">
                        <option value="Male" <?php selected($gender, 'Male'); ?>>Male</option>
                        <option value="Female" <?php selected($gender, 'Female'); ?>>Female</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="blood_group">Blood Group</label></th>
                <td>
                    <select name="blood_group" id="blood_group" class="regular-text">
                        <option value="A+" <?php selected($blood_group, 'A+'); ?>>A+</option>
                        <option value="A-" <?php selected($blood_group, 'A-'); ?>>A-</option>
                        <option value="B+" <?php selected($blood_group, 'B+'); ?>>B+</option>
                        <option value="B-" <?php selected($blood_group, 'B-'); ?>>B-</option>
                        <option value="AB+" <?php selected($blood_group, 'AB+'); ?>>AB+</option>
                        <option value="AB-" <?php selected($blood_group, 'AB-'); ?>>AB-</option>
                        <option value="O+" <?php selected($blood_group, 'O+'); ?>>O+</option>
                        <option value="O-" <?php selected($blood_group, 'O-'); ?>>O-</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="mobile">Mobile Number</label></th>
                <td><input type="text" name="mobile" id="mobile" value="<?php echo esc_attr($mobile); ?>" class="regular-text" maxlength="10" /></td>
            </tr>
            <tr>
                <th><label for="marital_status">Marital Status</label></th>
                <td>
                    <select name="marital_status" id="marital_status" class="regular-text">
                        <option value="Single" <?php selected($marital_status, 'Single'); ?>>Single</option>
                        <option value="Married" <?php selected($marital_status, 'Married'); ?>>Married</option>
                        <option value="Divorced" <?php selected($marital_status, 'Divorced'); ?>>Divorced</option>
                        <option value="Widowed" <?php selected($marital_status, 'Widowed'); ?>>Widowed</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="address">Address</label></th>
                <td><textarea name="address" id="address" class="regular-text"><?php echo esc_textarea($address); ?></textarea></td>
            </tr>
            <tr>
                <th><label for="hospital_id">Hospital</label></th>
                <td>
                    <select name="hospital_id" id="hospital_id" class="regular-text">
                        <?php
                        foreach ($hospitals as $hospital) {
                            echo '<option value="' . esc_attr($hospital->id) . '" ' . selected($hospital_id, $hospital->id, false) . '>' . esc_html($hospital->name) . '</option>';
                        }
                        ?>
                    </select>
                </td>
            </tr>
        </table>
    <?php
    }

    /**
     * Add custom fields to the Add New User page
     */
    public static function add_custom_fields_to_new_user_form()
    {

        $model = new \HMS\Includes\Models\Hospital();
        $hospitals = $model->getAllActiveHospitals();
    ?>
        <h3>Additional Information</h3>
        <table class="form-table">
            <tr>
                <th><label for="dob">Date of Birth</label></th>
                <td><input type="date" name="dob" id="dob" value="" class="regular-text" /></td>
            </tr>
            <tr>
                <th><label for="gender">Gender</label></th>
                <td>
                    <select name="gender" id="gender" class="regular-text">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="blood_group">Blood Group</label></th>
                <td>
                    <select name="blood_group" id="blood_group" class="regular-text">
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="mobile">Mobile Number</label></th>
                <td><input type="text" name="mobile" id="mobile" value="" class="regular-text" maxlength="10" /></td>
            </tr>
            <tr>
                <th><label for="marital_status">Marital Status</label></th>
                <td>
                    <select name="marital_status" id="marital_status" class="regular-text">
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Divorced">Divorced</option>
                        <option value="Widowed">Widowed</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="address">Address</label></th>
                <td><textarea name="address" id="address" class="regular-text"></textarea></td>
            </tr>
            <tr>
                <th><label for="hospital_id">Hospital</label></th>
                <td>
                    <select name="hospital_id" id="hospital_id" class="regular-text">
                        <?php
                        foreach ($hospitals as $hospital) {
                            echo '<option value="' . esc_attr($hospital->id) . '">' . esc_html($hospital->name) . '</option>';
                        }
                        ?>
                    </select>
                </td>
            </tr>
        </table>
<?php
    }

    /**
     * Save custom fields for existing users
     */
    public static function save_custom_user_fields($user_id)
    {
        if (!current_user_can('edit_user', $user_id)) {
            return false;
        }

        if (isset($_POST['dob'])) {
            update_user_meta($user_id, 'dob', sanitize_text_field($_POST['dob']));
        }

        if (isset($_POST['gender'])) {
            update_user_meta($user_id, 'gender', sanitize_text_field($_POST['gender']));
        }

        if (isset($_POST['blood_group'])) {
            update_user_meta($user_id, 'blood_group', sanitize_text_field($_POST['blood_group']));
        }

        if (isset($_POST['mobile'])) {
            update_user_meta($user_id, 'mobile', sanitize_text_field($_POST['mobile']));
        }

        if (isset($_POST['marital_status'])) {
            update_user_meta($user_id, 'marital_status', sanitize_text_field($_POST['marital_status']));
        }

        if (isset($_POST['address'])) {
            update_user_meta($user_id, 'address', sanitize_textarea_field($_POST['address']));
        }

        if (isset($_POST['hospital_id'])) {
            update_user_meta($user_id, 'hospital_id', intval($_POST['hospital_id']));
        }
    }

    /**
     * Save custom fields for new users
     */
    public static function save_new_user_custom_fields($user_id)
    {
        if (!empty($_POST['dob'])) {
            update_user_meta($user_id, 'dob', sanitize_text_field($_POST['dob']));
        }

        if (!empty($_POST['gender'])) {
            update_user_meta($user_id, 'gender', sanitize_text_field($_POST['gender']));
        }

        if (!empty($_POST['blood_group'])) {
            update_user_meta($user_id, 'blood_group', sanitize_text_field($_POST['blood_group']));
        }

        if (!empty($_POST['mobile'])) {
            update_user_meta($user_id, 'mobile', sanitize_text_field($_POST['mobile']));
        }

        if (!empty($_POST['marital_status'])) {
            update_user_meta($user_id, 'marital_status', sanitize_text_field($_POST['marital_status']));
        }

        if (!empty($_POST['address'])) {
            update_user_meta($user_id, 'address', sanitize_textarea_field($_POST['address']));
        }

        if (!empty($_POST['hospital_id'])) {
            update_user_meta($user_id, 'hospital_id', intval($_POST['hospital_id']));
        }
    }
}
