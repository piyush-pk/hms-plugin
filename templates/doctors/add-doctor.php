<?php
  echo \HMS\Templates\Tailwind::get_cdn_script();
?>

<?php
    $hospital = new \HMS\Includes\Models\Hospital();
    $hospitals = $hospital->getAllActiveHospitals();

    $doctors = \HMS\Includes\Models\User::get_all_doctors();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'hospital_id' => sanitize_text_field($_POST['hospital_id']),
            'user_id' => sanitize_text_field($_POST['doctor_id']),
            'qualification' => sanitize_text_field($_POST['qualification']),
            'experience_years' => sanitize_text_field($_POST['experience_years']),
            'license_number' => sanitize_text_field($_POST['license_number']),
            'specialty' => sanitize_text_field($_POST['specialty']),
            'status' => sanitize_text_field($_POST['status'])
        ];
        $doctor = new \HMS\Includes\Models\Doctor();
        $res = $doctor->createDoctor($data);
    }
?>
  

  <div class="mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold mb-6 text-center">Add Doctor</h2>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
        <div>
            <label for="hospital_id" class="block text-sm font-medium text-gray-700">Hospital ID</label>
            <select name="hospital_id" id="hospital_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <?php foreach ($hospitals as $hospital): ?>
                    <option class="w-full" value="<?php echo esc_html($hospital->id); ?>"><?php echo esc_html($hospital->name); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Doctor ID -->
        <div>
            <label for="doctor_id" class="block text-sm font-medium text-gray-700">User Id</label>
            <select name="doctor_id" id="doctor_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <?php foreach ($doctors as $doctor): ?>
                    <option value="<?php echo esc_html($doctor->ID); ?>"><?php echo esc_html($doctor->display_name); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
        </div>
        
        <div>
            <label for="qualification" class="block text-sm font-medium text-gray-700">Qualification</label>
            <input type="text" id="qualification" name="qualification" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div>
            <label for="experience_years" class="block text-sm font-medium text-gray-700">Experience (Years)</label>
            <input type="number" id="experience_years" name="experience_years" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div>
            <label for="license_number" class="block text-sm font-medium text-gray-700">License Number</label>
            <input type="text" id="license_number" name="license_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div>
            <label for="department" class="block text-sm font-medium text-gray-700">Department</label>
            <input type="text" id="department" name="department" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        
        <div>
            <label for="specialty" class="block text-sm font-medium text-gray-700">Specialty</label>
            <input type="text" id="specialty" name="specialty" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div class="col-span-full">
            <button type="submit" class="w-full py-2 px-4 bg-indigo-600 text-white font-bold rounded-md hover:bg-indigo-700">Add Doctor</button>
        </div>
    </form>
</div>
