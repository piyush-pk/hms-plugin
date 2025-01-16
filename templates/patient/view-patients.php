<?php
  echo \HMS\Templates\Tailwind::get_cdn_script();
?>

<?php
    $model = new \HMS\Includes\Models\Patient();
    $patients = $model->getAllPatients();

?>

<div class="overflow-x-auto shadow-lg rounded-lg bg-white me-4 mt-4">
    <h1 class="text-2xl font-semibold text-gray-700 py-4 text-center">All Patients</h1>

    <form method="post">
        <table class="min-w-full bg-white border border-gray-200 shadow-md rounded-lg">
            <thead>
                <tr class="bg-gray-100">
                    <!-- <th class="px-6 py-3 text-left text-sm font-medium text-gray-600 border-b">
                        <input type="checkbox" id="cb-select-all" class="checkbox">
                    </th> -->
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">ID</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Name</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">D.O.B</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Gender</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Blood Group</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Mobile Number</th>
                </tr>
            </thead>
            <tbody>
    <?php foreach ($patients as $patient): ?>
    <tr class="hover:bg-gray-50">
        <td class="px-6 py-4 border-b text-center"><?php echo esc_html($patient['user_id']); ?></td>
        <td class="px-6 py-4 border-b text-center"><?php echo esc_html($patient['display_name']); ?></td>
        <td class="px-6 py-4 border-b text-center"><?php echo esc_html($patient['dob']); ?></td>
        <td class="px-6 py-4 border-b text-center"><?php echo esc_html($patient['gender']); ?></td>
        <td class="px-6 py-4 border-b text-center"><?php echo esc_html($patient['blood_group']); ?></td>
        <td class="px-6 py-4 border-b text-center"><?php echo esc_html($patient['mobile']); ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>

        </table>
    </form>
</div>


