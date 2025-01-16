<?php
  echo \HMS\Templates\Tailwind::get_cdn_script();
?>

<?php
$model = new \HMS\Includes\Models\Staff();
$staffs = $model->getAllActiveStaffMembers();
?>

<div class="overflow-x-auto shadow-lg rounded-lg bg-white me-4 mt-4">
    <h1 class="text-2xl font-semibold text-gray-700 py-4 text-center">All Staffs</h1>

    <form method="post">
        <table class="min-w-full bg-white border border-gray-200 shadow-md rounded-lg">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">ID</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Name</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Gender</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Blood Group</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Mobile</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">D.O.B</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Job Title</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Department</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Shift</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Salary</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Status</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Roles</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Work Location</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">MaritalStatus</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Bank Account Number</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Bank Name</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($staffs as $staff): ?>
                <tr class="hover:bg-gray-50">
                    <!-- <td class="px-6 py-4 border-b">
                        <input type="checkbox" name="hospital_ids[]" value="<?php echo esc_attr($staff['id']); ?>" class="checkbox">
                    </td> -->
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($staff['id']); ?></td>
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($staff['display_name']); ?></td>
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($staff['gender']); ?></td>
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($staff['blood_group']); ?></td>
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($staff['mobile']); ?></td>
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($staff['dob']); ?></td>
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($staff['job_title']); ?></td>
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($staff['department']); ?></td>
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($staff['shift']); ?></td>
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($staff['salary']); ?></td>
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($staff['status']); ?></td>
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($staff['roles']); ?></td>
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($staff['work_location']); ?></td>
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($staff['marital_status']); ?></td>
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($staff['bank_account_number']); ?></td>
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($staff['bank_name']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- <div class="flex justify-center gap-5 items-center mt-4">
            <div class="flex items-center">
                <select name="bulk_action" class="bg-gray-100 text-gray-700 py-2 px-4 rounded-lg mr-2 w-56">
                    <option value="-1">Bulk Actions</option>
                    <option value="delete">Move to Trash</option>
                </select>
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Apply</button>
            </div>

            <div class="text-sm text-gray-500">
                <?php echo count($hospitals); ?> Hospitals
            </div>
        </div> -->
    </form>
</div>

<!-- <script>
    // Select all checkboxes
    document.getElementById('cb-select-all').addEventListener('change', function(e) {
        const checkboxes = document.querySelectorAll('.checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = e.target.checked;
        });
    });
</script> -->


