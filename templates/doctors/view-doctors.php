<?php
  echo \HMS\Templates\Tailwind::get_cdn_script();
?>

<?php
$model = new \HMS\Includes\Models\Doctor();
$doctors = $model->getActiveDoctors();
?>

<div class="overflow-x-auto shadow-lg rounded-lg bg-white me-4 mt-4">
    <h1 class="text-2xl font-semibold text-gray-700 py-4 text-center">All Doctors</h1>

    <form method="post">
        <table class="min-w-full bg-white border border-gray-200 shadow-md rounded-lg">
            <thead>
                <tr class="bg-gray-100">
                    <!-- <th class="px-6 py-3 text-left text-sm font-medium text-gray-600 border-b">
                        <input type="checkbox" id="cb-select-all" class="checkbox">
                    </th> -->
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">ID</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Name</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Mobile</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">D.O.B</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Qualification</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Experience Years</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">License Number</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Department</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Address</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Specialty</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($doctors as $doctor): ?>
                <tr class="hover:bg-gray-50">
                    <!-- <td class="px-6 py-4 border-b">
                        <input type="checkbox" name="hospital_ids[]" value="<?php echo esc_attr($doctor->id); ?>" class="checkbox">
                    </td> -->
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($doctor['id']); ?></td>
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($doctor['display_name']); ?></td>
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($doctor['mobile']); ?></td>
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($doctor['dob']); ?></td>
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($doctor['qualification']); ?></td>
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($doctor['experience_years']); ?></td>
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($doctor['license_number']); ?></td>
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($doctor['department']); ?></td>
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($doctor['address']); ?></td>
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($doctor['specialty']); ?></td>
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($doctor['status']); ?></td>
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


