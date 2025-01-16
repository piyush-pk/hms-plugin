<?php
echo \HMS\Templates\Tailwind::get_cdn_script();
?>

<?php
$hospital = new \HMS\Includes\Models\Hospital();
$hospitals = $hospital->getAllActiveHospitals();

$staffs = \HMS\Includes\Models\User::get_all_staffs();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'hospital_id' => sanitize_text_field($_POST['hospital_id']),
        'user_id' => sanitize_text_field($_POST['staff_id']),
        'job_title' => sanitize_text_field($_POST['job_title']),
        'department' => sanitize_text_field($_POST['department']),
        'shift' => sanitize_text_field($_POST['shift']),
        'salary' => sanitize_text_field($_POST['salary']),
        'bank_account_number' => sanitize_text_field($_POST['bank_account_number']),
        'bank_name' => sanitize_text_field($_POST['bank_name']),
    ];

    $model = new \HMS\Includes\Models\Staff();
    $model->insertStaff($data);
}
?>


<div class="bg-white border border-4 rounded-lg shadow relative mr-4 mt-4">

    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST"
        class="bg-white p-8 rounded-lg shadow-lg w-full">
        <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Add Staff</h2>

        <!-- Grid Container -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Hospital ID -->
            <div>
                <label for="hospital_id" class="block text-sm font-medium text-gray-700">Hospital ID</label>
                <!-- <input type="number" name="hospital_id" id="hospital_id" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"> -->
                <select name="hospital_id" id="hospital_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <?php foreach ($hospitals as $hospital): ?>
                        <option value="<?php echo esc_html($hospital->id); ?>"><?php echo esc_html($hospital->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Doctor ID -->
            <div>
                <label for="staff_id" class="block text-sm font-medium text-gray-700">User Id</label>
                <select name="staff_id" id="staff_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <?php foreach ($staffs as $staff): ?>
                        <option value="<?php echo esc_html($staff->ID); ?>"><?php echo esc_html($staff->display_name); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Job Title -->
            <div>
                <label for="job_title" class="block text-sm font-medium text-gray-700">Job Title</label>
                <input type="text" name="job_title" id="job_title" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <!-- Department -->
            <div>
                <label for="department" class="block text-sm font-medium text-gray-700">Department</label>
                <input type="text" name="department" id="department" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <!-- Shift -->
            <div>
                <label for="shift" class="block text-sm font-medium text-gray-700">Shift</label>
                <select name="shift" id="shift"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">Select Shift</option>
                    <option value="Morning">Morning</option>
                    <option value="Evening">Evening</option>
                    <option value="Night">Night</option>
                </select>
            </div>

            <!-- Salary -->
            <div>
                <label for="salary" class="block text-sm font-medium text-gray-700">Salary</label>
                <input type="number" name="salary" id="salary" step="0.01" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <!-- Bank Name -->
            <div>
                <label for="bank_name" class="block text-sm font-medium text-gray-700">Bank Name</label>
                <input type="text" name="bank_name" id="bank_name" step="0.01" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <!-- Bank Number -->
            <div>
                <label for="bank_account_number" class="block text-sm font-medium text-gray-700">Bank Account
                    Number</label>
                <input type="number" name="bank_account_number" id="bank_account_number" step="0.01" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                    <option value="On Leave">On Leave</option>
                </select>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="mt-6">
            <button type="submit"
                class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Add Staff
            </button>
        </div>
    </form>
</div>