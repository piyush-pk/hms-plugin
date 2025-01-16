<?php
  echo \HMS\Templates\Tailwind::get_cdn_script();
?>

<?php
// Check if this is an edit request
$isEdit = isset($_GET['id']);
$hospitalData = null;

if ($isEdit) {
    $hospitalId = $_GET['id'];
    $hospital = new \HMS\Includes\Models\Hospital();
    $hospitalData = $hospital->getDataById($hospitalId); // Fetch hospital data by ID
    if(!count($hospitalData)) {
        echo '<h1 class="text-xl bg-red-500 text-white py-2 px-4 text-center mt-5 rounded-3xl"> Record Not Found !!! </h1>';
        return; 
    }
    $hospitalData = json_decode(json_encode($hospitalData[0]), true);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and process form data
    $data = [
        'name' => sanitize_text_field($_POST['name']),
        'address' => sanitize_text_field($_POST['address']),
        'city' => sanitize_text_field($_POST['city']),
        'state' => sanitize_text_field($_POST['state']),
        'zip_code' => sanitize_text_field($_POST['zipCode']),
        'phone' => sanitize_text_field($_POST['phone']),
        'email' => sanitize_text_field($_POST['email']),
        'num_beds' => (int)$_POST['numBeds'],
        'specializations' => sanitize_text_field($_POST['specializations']),
        'status' => sanitize_text_field($_POST['status']),
    ];

    $hospital = new \HMS\Includes\Models\Hospital();

    if ($isEdit) {
        // Update hospital
        $hospital->updateHospital($hospitalId, $data);
        echo '<h1 class="text-xl bg-green-500 text-white py-2 px-4 text-center mt-5 rounded-3xl"> Record Updated Successfully! </h1>';

    } else {
        // Insert new hospital
        $hospital->insertData($data);
    }

    exit;
}
?>

    <div class="hero flex justify-center items-center">
        <div class="text-center text-white">
            <h1 class="text-4xl font-bold">Welcome to Hospital Registration</h1>
            <p class="text-xl mt-2 text-black">We are here to help you register your hospital quickly and securely</p>
        </div>
    </div>

    <div class="container mx-auto my-8 p-6 bg-white shadow-lg rounded-lg">
        <div class="flex justify-center mb-6">
            <div class="bg-green-500 rounded-full p-4">
                <i class="fas fa-hospital-alt text-white text-4xl"></i>
            </div>
        </div>
        <h1 class="text-3xl font-bold text-center text-green-600 mb-4">Register a New Hospital</h1>

        <form id="add-hospital" method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
        <?php wp_nonce_field('hospital_update'); ?>
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label for="name" class="block text-gray-700 font-bold mb-2">Hospital Name</label>
                    <input type="text" id="name" name="name" value="<?php echo $hospitalData['name'] ?? ''; ?>" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                </div>
                <div>
                    <label for="address" class="block text-gray-700 font-bold mb-2">Address</label>
                    <textarea id="address" name="address" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline h-24"><?php echo $hospitalData['address'] ?? ''; ?></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="city" class="block text-gray-700 font-bold mb-2">City</label>
                        <input type="text" id="city" name="city" value="<?php echo $hospitalData['city'] ?? ''; ?>" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                    </div>
                    <div>
                        <label for="state" class="block text-gray-700 font-bold mb-2">State</label>
                        <input type="text" id="state" name="state" value="<?php echo $hospitalData['state'] ?? ''; ?>" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="zipCode" class="block text-gray-700 font-bold mb-2">Zip Code</label>
                        <input type="text" id="zipCode" name="zipCode" value="<?php echo $hospitalData['zip_code'] ?? ''; ?>" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                    </div>
                    <div>
                        <label for="phone" class="block text-gray-700 font-bold mb-2">Phone</label>
                        <input type="text" id="phone" name="phone" value="<?php echo $hospitalData['phone'] ?? ''; ?>" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo $hospitalData['email'] ?? ''; ?>" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                    </div>
                    <div>
                        <label for="numBeds" class="block text-gray-700 font-bold mb-2">Number of Beds</label>
                        <input type="number" id="numBeds" name="numBeds" value="<?php echo $hospitalData['num_beds'] ?? ''; ?>" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                    </div>
                </div>
                <div>
                    <label for="specializations" class="block text-gray-700 font-bold mb-2">Specializations</label>
                    <textarea id="specializations" name="specializations" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline h-24"><?php echo $hospitalData['specializations'] ?? ''; ?></textarea>
                </div>
                <div>
                    <label for="status" class="block text-gray-700 font-bold mb-2">Status</label>
                    <select id="status" name="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mt-4">
                <i class="fas fa-hospital text-white mr-2"></i> <?php echo $isEdit ? 'Update Hospital' : 'Register Hospital'; ?>
            </button>

        </form>
    </div>

    <footer class="bg-green-600 text-white py-4 text-center">
        <p>&copy; 2024 Hospital Registration. All rights reserved.</p>
    </footer>



