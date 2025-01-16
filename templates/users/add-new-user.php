<?php
// Include Tailwind CSS CDN
echo \HMS\Templates\Tailwind::get_cdn_script();
use \HMS\Includes\Models\User;

function display_add_new_user_form()
{

    // Handle form submission
    if (isset($_POST['submit_new_user'])) {
        // Sanitize inputs
        $username = sanitize_text_field($_POST['mobile_number']);
        $email = strval(sanitize_text_field($_POST['mobile_number'])) . '@byom.de';
        $first_name = sanitize_text_field($_POST['first_name']);
        $last_name = sanitize_text_field($_POST['last_name']);
        $password = sanitize_text_field($_POST['password']) ?? '123456';
        $role = sanitize_text_field($_POST['role']);
        $dob = sanitize_text_field($_POST['dob']);
        $gender = sanitize_text_field($_POST['gender']);
        $blood_group = sanitize_text_field($_POST['blood_group']);
        $mobile_number = sanitize_text_field($_POST['mobile_number']);
        $marital_status = sanitize_text_field($_POST['marital_status']);
        $address = sanitize_text_field($_POST['address']);
        $hospital = sanitize_text_field($_POST['hospital']);
        $send_notification = isset($_POST['send_notification']) ? 1 : 0;

        // Create new user
        $user_id = wp_create_user($username, $password, $email);

        if (!is_wp_error($user_id)) {
            // Update user meta with additional information
            update_user_meta($user_id, 'first_name', $first_name);
            update_user_meta($user_id, 'last_name', $last_name);
            // update_user_meta($user_id, 'website', $website);
            update_user_meta($user_id, 'dob', $dob);
            update_user_meta($user_id, 'gender', $gender);
            update_user_meta($user_id, 'blood_group', $blood_group);
            update_user_meta($user_id, 'mobile', $mobile_number);
            update_user_meta($user_id, 'marital_status', $marital_status);
            update_user_meta($user_id, 'address', $address);
            update_user_meta($user_id, 'hospital', $hospital);

            // Set user role
            $user = new WP_User($user_id);
            $user->set_role($role);

            // Send notification if selected
            if ($send_notification) {
                $subject = 'Welcome to HMS';
                $message = 'Your account has been created.';
                wp_mail($email, $subject, $message);
            }

            // Success message
            echo '<div id="success-message" class="bg-green-500 text-white text-2xl text-center mt-4 p-4 rounded-2xl mx-5">User added successfully!</div>';
        } else {
            // Error message
            echo '<div class="text-red-500 text-center mt-4">Error adding user: ' . $user_id->get_error_message() . '</div>';
        }
    }


    $allowed_roles = HMS\Includes\Init\Constants::get_allowed_roles(User::get_role_name());
    $model = new \HMS\Includes\Models\Hospital();
    $hospitals = $model->getAllActiveHospitals();

    // Start output buffering
    ob_start();
?>
    <script>
        window.onload = (e) => {
            const successMessage = document.getElementById('success-message');
            if (successMessage) {
                setTimeout(() => {
                    // Add classes for fade-out and translate-up
                    successMessage.classList.add('opacity-0', '-translate-y-4', 'transition', 'duration-1000');

                    // Wait for the transition to complete before removing the element
                    successMessage.addEventListener('transitionend', () => {
                        successMessage.remove();
                    });
                }, 3000);
            }
        };
    </script>
    <div class="mx-auto p-8 bg-white rounded-lg shadow-xl mt-2">
        <h2 class="text-4xl font-bold mb-8 text-center text-emerald-600">Add New User</h2>
        <form method="post" action="" enctype="multipart/form-data" class="space-y-6 sm:space-y-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                <!-- First Name -->
                <div>
                    <label for="first_name" class="block text-lg font-medium text-gray-700">First Name</label>
                    <input type="text" name="first_name" id="first_name" required class="mt-2 p-4 w-full border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200">
                </div>

                <!-- Last Name -->
                <div>
                    <label for="last_name" class="block text-lg font-medium text-gray-700">Last Name</label>
                    <input type="text" name="last_name" id="last_name" class="mt-2 p-4 w-full border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-lg font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" value="" class="mt-2 p-4 w-full border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200">
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-lg font-medium text-gray-700">Role</label>
                    <select name="role" id="role" required class="mt-2 p-4 w-full border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200">
                        <?php foreach ($allowed_roles as $role): ?>
                            <option value="<?php echo esc_html($role['role']); ?>"><?php echo esc_html($role['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Additional Information Section -->
            <div class="mt-8 border-t border-gray-300 pt-8">
                <h3 class="text-2xl font-bold text-emerald-600 mb-6">Additional Information</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Date of Birth -->
                    <div>
                        <label for="dob" class="block text-lg font-medium text-gray-700">Date of Birth</label>
                        <input type="date" name="dob" id="dob" required class="mt-2 p-4 w-full border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200">
                    </div>

                    <!-- Gender -->
                    <div>
                        <label for="gender" class="block text-lg font-medium text-gray-700">Gender</label>
                        <select name="gender" id="gender" required class="mt-2 p-4 w-full border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <!-- Blood Group (Dropdown) -->
                    <div>
                        <label for="blood_group" class="block text-lg font-medium text-gray-700">Blood Group</label>
                        <select name="blood_group" id="blood_group" class="mt-2 p-4 w-full border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200">
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                        </select>
                    </div>

                    <!-- Mobile Number -->
                    <div>
                        <label for="mobile_number" class="block text-lg font-medium text-gray-700">Mobile Number</label>
                        <input type="tel" name="mobile_number" id="mobile_number" class="mt-2 p-4 w-full border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200">
                    </div>

                    <!-- Marital Status -->
                    <div>
                        <label for="marital_status" class="block text-lg font-medium text-gray-700">Marital Status</label>
                        <select name="marital_status" id="marital_status" class="mt-2 p-4 w-full border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200">
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Divorced">Divorced</option>
                            <option value="Widowed">Widowed</option>
                        </select>
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-lg font-medium text-gray-700">Address</label>
                        <input type="text" name="address" id="address" class="mt-2 p-4 w-full border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200">
                    </div>

                    <!-- Hospital (Dropdown) -->
                    <div>
                        <label for="hospital" class="block text-lg font-medium text-gray-700">Hospital</label>
                        <select name="hospital" id="hospital" class="mt-2 p-4 w-full border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200">
                            <?php foreach ($hospitals as $hospital): ?>
                                <option value="<?php echo esc_html($hospital->id); ?>"><?php echo esc_html($hospital->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-8">
                <button type="submit" id="submit_new_user" name="submit_new_user" class="w-full bg-emerald-500 text-white p-4 rounded-lg hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200">
                    Add New User
                </button>
            </div>
        </form>
    </div>

<?php
    // Return the form HTML
    return ob_get_clean();
}

// Display the form
echo display_add_new_user_form();
?>