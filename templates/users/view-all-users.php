<?php

use HMS\Includes\Models\User;

// Include Tailwind CSS CDN
echo \HMS\Templates\Tailwind::get_cdn_script();

function user_list_page() {
    // Get all users grouped by role
    $all_users = HMS\Includes\Models\User::get_user_as_per_role();
    ?>
    <div class="wrap p-6">
        <h1 class="text-3xl font-bold mb-6 text-center">User List by Role</h1>
        <div class="accordion space-y-4">
            <?php foreach ($all_users as $key => $users) : ?>
                <div class="accordion-item border border-gray-200 rounded-lg shadow-sm">
                    <h2 class="accordion-header">
                        <button
                            class="accordion-button flex justify-between items-center w-full text-left px-6 py-4 bg-gray-100 font-semibold text-lg hover:bg-gray-200 transition-colors"
                            type="button"
                            data-accordion-target="#collapse-<?php echo esc_attr($key); ?>"
                            aria-expanded="false"
                            aria-controls="collapse-<?php echo esc_attr($key); ?>">
                            <span><?php echo esc_html(ucfirst($key)); ?> List</span>
                            <span>Total Records <?php echo esc_html(count($users)); ?></span>
                            <svg
                                class="w-5 h-5 transform transition-transform duration-300"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </h2>
                    <div
                        id="collapse-<?php echo esc_attr($key); ?>"
                        class="accordion-collapse overflow-hidden max-h-0 transition-[max-height] duration-500 ease-in-out"
                        aria-labelledby="heading-<?php echo esc_attr($key); ?>">
                        <div class="accordion-body p-6">
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="text-center px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                            <th class="text-center px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                                            <th class="text-center px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                            <th class="text-center px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
                                            <th class="text-center px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Age</th>
                                            <th class="text-center px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Blood Group</th>
                                            <th class="text-center px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">D.O.B</th>
                                            <th class="text-center px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mobile</th>
                                            <th class="text-center px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <?php if (!empty($users)) : ?>
                                            <?php foreach ($users as $user) : ?>
                                                <tr class="hover:bg-gray-50 transition-colors">
                                                    <td class="text-center px-6 py-4 text-sm text-gray-900"><?php echo esc_html($user->ID); ?></td>
                                                    <td class="text-center px-6 py-4 text-sm text-gray-900"><?php echo esc_html($user->user_login); ?></td>
                                                    <td class="text-center px-6 py-4 text-sm text-gray-900"><?php echo esc_html($user->display_name); ?></td>
                                                    <td class="text-center px-6 py-4 text-sm text-gray-900"><?php echo esc_html($user->gender); ?></td>
                                                    <td class="text-center px-6 py-4 text-sm text-gray-900"><?php echo esc_html(User::calculate_age($user->dob)); ?></td>
                                                    <td class="text-center px-6 py-4 text-sm text-gray-900"><?php echo esc_html($user->blood_group); ?></td>
                                                    <td class="text-center px-6 py-4 text-sm text-gray-900"><?php echo esc_html($user->dob); ?></td>
                                                    <td class="text-center px-6 py-4 text-sm text-gray-900"><?php echo esc_html($user->mobile); ?></td>
                                                    <td class="text-center px-6 py-4 text-sm text-gray-900"><?php echo esc_html(User::get_role_name($user)['name']); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="4" class="px-6 py-4 text-sm text-center text-gray-500">No Users found.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script>
        // Accordion toggle logic with smooth animation
        document.querySelectorAll('[data-accordion-target]').forEach(button => {
            button.addEventListener('click', () => {
                const target = document.querySelector(button.getAttribute('data-accordion-target'));
                const expanded = button.getAttribute('aria-expanded') === 'true';

                if (!expanded) {
                    // Expand accordion
                    target.style.maxHeight = target.scrollHeight + 'px';
                    target.classList.remove('max-h-0');
                } else {
                    // Collapse accordion
                    target.style.maxHeight = 0;
                }

                // Toggle button expanded state
                button.setAttribute('aria-expanded', !expanded);

                // Rotate icon
                const icon = button.querySelector('svg');
                if (icon) {
                    icon.classList.toggle('rotate-180');
                }
            });

            // Ensure animation works on first click
            const target = document.querySelector(button.getAttribute('data-accordion-target'));
            if (target) {
                target.style.maxHeight = 0;
            }
        });
    </script>
    <?php
}

user_list_page();
?>
