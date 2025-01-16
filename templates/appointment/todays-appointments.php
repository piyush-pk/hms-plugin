<?php

use \HMS\Includes\Models\User;
use \HMS\Includes\Models\Appointment;

// Handle AJAX request to update appointment status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    $appointmentId = intval($_POST['appointment_id']);
    $status = sanitize_text_field($_POST['status']);

    // Update the appointment status
    $appointmentModel = new Appointment();
    $result = $appointmentModel->updateAppointmentStatus($appointmentId, $status);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Status updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update status.']);
    }
    exit; // Stop further execution for AJAX requests
}

// Fetch today's appointments (for regular page load)
$appointments = (new Appointment())->getTodaysAppointments();
?>
<?php echo \HMS\Templates\Tailwind::get_cdn_script(); ?>
<script>
    // AJAX function to update appointment status
    function updateAppointmentStatus(appointmentId, status) {
        const formData = new FormData();
        formData.append('action', 'update_status');
        formData.append('appointment_id', appointmentId);
        formData.append('status', status);

        fetch(window.location.href, {
                method: 'POST',
                body: formData,
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.status;
            })
            .then(status => {
                if (status === 200) {
                    window.location.reload(); // Reload the page to reflect changes
                } else {
                    alert('something went\'s wrong, please contact to developer !!!'); // Show error message
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the status.');
            });
    }
</script>
<div class="overflow-x-auto shadow-lg rounded-lg bg-white me-4 mt-4">
    <h1 class="text-2xl font-semibold text-gray-700 py-4 text-center">Today's Appointments</h1>

    <table class="min-w-full bg-white border border-gray-200 shadow-md rounded-lg">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">ID</th>
                <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Change Status</th>
                <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Patient Name</th>
                <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Appointment Date</th>
                <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Patient D.O.B</th>
                <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Patient Age</th>
                <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Gender</th>
                <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Patient Blood Group</th>
                <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Patient Mobile Number</th>
                <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Doctor</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($appointments as $appointment): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($appointment->id); ?></td>
                    <td class="px-6 py-4 border-b text-center">
                        <select onchange="updateAppointmentStatus(<?php echo esc_attr($appointment->id); ?>, this.value)">
                            <option value="Scheduled" <?php selected($appointment->status, 'Scheduled'); ?>>Scheduled</option>
                            <option value="Completed" <?php selected($appointment->status, 'Completed'); ?>>Completed</option>
                        </select>
                    </td>
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($appointment->patient_name); ?></td>
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($appointment->appointment_date); ?></td>
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($appointment->patient_dob); ?></td>
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html(User::calculate_age($appointment->patient_dob)); ?></td>
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($appointment->patient_gender); ?></td>
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($appointment->patient_blood_group); ?></td>
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($appointment->patient_mobile); ?></td>
                    <td class="px-6 py-4 border-b text-center"><?php echo esc_html($appointment->doctor_name); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>