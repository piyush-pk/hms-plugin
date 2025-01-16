<?php
echo \HMS\Templates\Tailwind::get_cdn_script();
?>

<?php

use \HMS\Includes\Models\User;

$appointments = (new \HMS\Includes\Models\Appointment)->getAppointmentsWithJoins();
// print_r($appointments);
?>

<div class="overflow-x-auto shadow-lg rounded-lg bg-white">
    <h1 class="text-2xl font-semibold text-gray-700 py-4 text-center">All Appointments</h1>

    <form method="post">
        <table class="min-w-full bg-white border border-gray-200 shadow-md rounded-lg">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">ID</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 border-b">Status</th>
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
                        <td class="px-6 py-4 border-b text-center"><?php echo esc_html($appointment->status); ?></td>
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
    </form>
</div>