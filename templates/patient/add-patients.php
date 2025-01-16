<?php
  echo \HMS\Templates\Tailwind::get_cdn_script();
?>

<?php
    $hospital = new \HMS\Includes\Models\Hospital();
    $hospitals = $hospital->getAllActiveHospitals();

    $doctor = new \HMS\Includes\Models\Doctor();
    $doctors = $doctor->getActiveDoctors();

    $patients = \HMS\Includes\Models\User::get_all_patients();

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data =[
            'hospital_id' => sanitize_text_field($_POST['hospital_id']),
            'user_id' => sanitize_text_field($_POST['patient_id']),
            'doctor_id' => sanitize_text_field($_POST['doctor_id']),
        ];

        $patientModel = new \HMS\Includes\Models\Patient();
        $patientModel->insertPatient($data);
    }

?>
  

  <div class="mx-auto p-6 bg-white shadow-md rounded-lg align-center items-center">
    <h2 class="text-2xl font-bold mb-6 text-center">Patient Registration</h2>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST" class="grid grid-cols-1 sm:grid-cols-2 gap-6 w-full">
        <!-- Hospital ID -->
        <div>
            <label for="hospital_id" class="block text-sm font-medium text-gray-700">Hospital ID</label>
            <select name="hospital_id" id="hospital_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <?php foreach ($hospitals as $hospital): ?>
                    <option value="<?php echo esc_html($hospital->id); ?>"><?php echo esc_html($hospital->name); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Patient User ID -->
        <div>
            <label for="patient_id" class="block text-sm font-medium text-gray-700">User Id</label>
            <select name="patient_id" id="patient_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <?php foreach ($patients as $patient): ?>
                    <option value="<?php echo esc_html($patient->ID); ?>"><?php echo esc_html($patient->display_name); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <!-- Doctor ID -->
        <div>
            <label for="doctor_id" class="block text-sm font-medium text-gray-700">Doctor ID</label>
            <select name="doctor_id" id="doctor_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <?php foreach ($doctors as $doctor): ?>
                    <option value="<?php echo esc_html($doctor['id']); ?>"><?php echo esc_html($doctor['display_name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <!-- Submit Button -->
        <div class="sm:col-span-2">
            <button type="submit" 
                class="w-full py-3 px-4 bg-indigo-600 text-white font-bold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Register Patient
            </button>
        </div>
    </form>
</div>
