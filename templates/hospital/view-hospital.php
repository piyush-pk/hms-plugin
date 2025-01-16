<?php
echo \HMS\Templates\Tailwind::get_cdn_script();
?>

<?php
$hospital = new \HMS\Includes\Models\Hospital();
$hospitals = $hospital->getAllActiveHospitals();
?>

<div class="overflow-x-auto shadow-lg rounded-lg bg-white me-4 mt-4">
    <h1 class="text-2xl font-semibold text-gray-700 py-4 text-center">All Hospitals</h1>

    <form method="post">
        <table class="min-w-full bg-white border border-gray-200 shadow-md rounded-lg">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">ID</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Name</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Address</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">City</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">State</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">ZipCode</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Phone</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Email</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">No.Of Beds</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Status</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">specializations</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hospitals as $hospital): ?>
                    <tr class="hover:bg-gray-50">
                        <!-- <td class="px-6 py-4 border-b">
                        <input type="checkbox" name="hospital_ids[]" value="<?php echo esc_attr($hospital->id); ?>" class="checkbox">
                    </td> -->
                        <td class="px-6 py-4 border-b text-center"><?php echo esc_html($hospital->id); ?></td>
                        <td class="px-6 py-4 border-b text-center"><?php echo esc_html($hospital->name); ?></td>
                        <td class="px-6 py-4 border-b text-center"><?php echo esc_html($hospital->address); ?></td>
                        <td class="px-6 py-4 border-b text-center"><?php echo esc_html($hospital->city); ?></td>
                        <td class="px-6 py-4 border-b text-center"><?php echo esc_html($hospital->state); ?></td>
                        <td class="px-6 py-4 border-b text-center"><?php echo esc_html($hospital->zip_code); ?></td>
                        <td class="px-6 py-4 border-b text-center"><?php echo esc_html($hospital->phone); ?></td>
                        <td class="px-6 py-4 border-b text-center"><?php echo esc_html($hospital->email); ?></td>
                        <td class="px-6 py-4 border-b text-center"><?php echo esc_html($hospital->num_beds); ?></td>
                        <td class="px-6 py-4 border-b text-center"><?php echo esc_html($hospital->status); ?></td>
                        <td class="px-6 py-4 border-b text-center"><?php echo esc_html($hospital->specializations); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </form>
</div>