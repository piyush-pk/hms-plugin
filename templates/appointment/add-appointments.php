
<?php
  echo \HMS\Templates\Tailwind::get_cdn_script();
?>

<?php
    $patients = (new \HMS\Includes\Models\Patient())->getAllPatients();
    $doctors = (new \HMS\Includes\Models\Doctor())->getActiveDoctors();
    $hospitals = (new \HMS\Includes\Models\Hospital())->getAllActiveHospitals();

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'patient_id' => $_POST['patient_id'],
            'doctor_id' => $_POST['doctor_id'],
            'hospital_id' => $_POST['hospital_id'],
            'appointment_date' => $_POST['appointment_date'],
            'status' => $_POST['status'],
            'reason' => $_POST['reason'],
        ];

        $model = new \HMS\Includes\Models\Appointment();
        $model->insert($data);
    }
?>
 
 <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold mb-6 text-center">Book an Appointment</h2>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST" class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <!-- Patient ID -->
        <div>
            <label for="patient_id" class="block text-sm font-medium text-gray-700">Patient ID</label>
            <select name="patient_id" id="patient_id"
            required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="" selected>Select Patient</option>
                    <?php foreach ($patients as $patient): ?>
                        <option value="<?php echo esc_html($patient['id']); ?>"><?php echo esc_html($patient['display_name']); ?></option>
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
        <!-- Appointment Date -->
        <div>
            <label for="appointment_date" class="block text-sm font-medium text-gray-700">Appointment Date</label>
            <input type="date" id="appointment_date" name="appointment_date" 
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
        </div>
        <!-- Status -->
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select id="status" name="status" 
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="Scheduled" selected>Scheduled</option>
                <option value="Completed">Completed</option>
                <option value="Cancelled">Cancelled</option>
                <option value="No Show">No Show</option>
            </select>
        </div>
        <!-- Reason -->
        <div class="sm:col-span-2">
            <label for="reason" class="block text-sm font-medium text-gray-700">Reason for Appointment</label>
            <textarea id="reason" name="reason" rows="4" 
                class="p-4 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
        </div>
        <!-- Submit Button -->
        <div class="sm:col-span-2">
            <button type="submit" id="submit_btn"
                class="w-full py-3 px-4 bg-indigo-600 text-white font-bold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Book Appointment
            </button>
        </div>
    </form>
</div>

<script>
    const appointmentDateInput = document.getElementById('appointment_date');
    const submitBtn = document.getElementById('submit_btn');

    // Get the current date and time in Kolkata timezone
    const now = new Date();
    const options = { timeZone: 'Asia/Kolkata' };
    const istTime = now.toLocaleString('en-IN', options);

    // Extract the current hours in Kolkata time
    const currentHours = new Date(istTime).getHours();

    // Set the default date
    if (currentHours >= 18) {
        // After 6 PM IST, set tomorrow as the default
        now.setDate(now.getDate() + 1);
    }

    // Format the date as YYYY-MM-DD
    const defaultDate = now.toLocaleDateString('en-CA', { timeZone: 'Asia/Kolkata' });
    appointmentDateInput.value = defaultDate;
    appointmentDateInput.min = defaultDate; // Ensure past dates cannot be selected
</script>
