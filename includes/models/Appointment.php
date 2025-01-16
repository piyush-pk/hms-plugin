<?php
/**
 * Appointment Model
 * Handles CRUD operations for the appointments table.
 */

namespace HMS\Includes\Models;

// Correctly import the AdvancedORM class
use HMS\Includes\Init\AdvanceORM;

class Appointment extends AdvanceORM {
    protected $table = 'appointments';
    protected $prefix = 'hms_';
    protected $primaryKey = 'id';

    protected $patient_table_name;
    protected $doctor_table_name;
    protected $users_table_name;
    protected $usermeta_table_name;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'hospital_id',
        'appointment_date',
        'status',
        'reason',
    ];

    public function __construct() {
        parent::__construct($this->table, $this->prefix, $this->primaryKey, $this->fillable);
        $this->patient_table_name = (new Patient())->get_table_name();
        $this->doctor_table_name = (new Doctor())->get_table_name();
        $this->users_table_name = $this->wpdb->prefix . 'users';
        $this->usermeta_table_name = $this->wpdb->prefix . 'usermeta';
    }

    public function create() {
        $this->createTable([
            'patient_id' => 'INT(11)',
            'doctor_id' => 'INT(11) NOT NULL',
            'hospital_id' => 'INT(11) NOT NULL',
            'appointment_date' => 'DATE NOT NULL',
            // 'appointment_time' => 'TIME NOT NULL',
            'status' => "ENUM('Scheduled', 'Completed', 'Cancelled', 'No Show') DEFAULT 'Scheduled'",
            'reason' => 'TEXT',
            'consultation_fee_paid' => 'BOOLEAN NOT NULL DEFAULT (FALSE)',
            'is_follow_up' => 'BOOLEAN DEFAULT FALSE',
            'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'FOREIGN KEY (patient_id)' => 'REFERENCES hms_patients(id) ON DELETE CASCADE',
            'FOREIGN KEY (doctor_id)' => 'REFERENCES hms_doctors(id) ON DELETE CASCADE',
            'FOREIGN KEY (hospital_id)' => 'REFERENCES hms_hospitals(id) ON DELETE CASCADE',
        ]);
    }

    public function getAppointments() {
        return $this->select('*', [], [
            'updated_at' => 'DESC'
        ]);
    }

    public function getTodaysAppointments() {
        $today = date('Y-m-d');

        return self::getAppointmentsWithJoins([
            'DATE(appointment_date)' =>  $today,
            "{$this->table}.status" => 'Scheduled'
        ]);
    }

    public function getAppointmentsWithJoins($conditions = [], $orderBy = [], $limit = null, $groupBy = [], $having = []) {
    
        // Define the fields to select
        $fields = [
            "{$this->table}.*", // All fields from the appointments table
            "patient_users.display_name AS patient_name",
            "patient_users.user_email AS patient_email",
            "MAX(CASE WHEN patient_usermeta.meta_key = 'dob' THEN patient_usermeta.meta_value END) AS patient_dob",
            "MAX(CASE WHEN patient_usermeta.meta_key = 'gender' THEN patient_usermeta.meta_value END) AS patient_gender",
            "MAX(CASE WHEN patient_usermeta.meta_key = 'mobile' THEN patient_usermeta.meta_value END) AS patient_mobile",
            "MAX(CASE WHEN patient_usermeta.meta_key = 'blood_group' THEN patient_usermeta.meta_value END) AS patient_blood_group",
            "doctor_users.display_name AS doctor_name",
            "doctor_users.user_email AS doctor_email",
            "MAX(CASE WHEN doctor_usermeta.meta_key = 'specialization' THEN doctor_usermeta.meta_value END) AS doctor_specialization",
        ];
    
        // Define the default group by fields
        $defaultGroupBy = [
            "{$this->table}.id", // Group by appointment ID
            "patient_users.ID",  // Group by patient ID
            "doctor_users.ID",   // Group by doctor ID
        ];
    
        // Merge the default group by fields with the provided group by fields
        $groupBy = array_merge($defaultGroupBy, $groupBy);
    
        // Join conditions with aliases
        $results = $this->select(
            implode(", ", $fields), // Use the fields array for specific columns
            $conditions,
            $orderBy,
            $limit,
            $groupBy,
            $having,
            [
                // Join with patients table
                ['table' => $this->patient_table_name, 'on' => "{$this->table}.patient_id = {$this->patient_table_name}.id", 'type' => 'INNER'],
                // Join with users table for patients
                ['table' => "{$this->users_table_name} AS patient_users", 'on' => "{$this->patient_table_name}.user_id = patient_users.ID", 'type' => 'INNER'],
                // Join with usermeta table for patients
                ['table' => "{$this->usermeta_table_name} AS patient_usermeta", 'on' => "patient_usermeta.user_id = patient_users.ID", 'type' => 'LEFT'],
                // Join with doctors table
                ['table' => $this->doctor_table_name, 'on' => "{$this->table}.doctor_id = {$this->doctor_table_name}.id", 'type' => 'INNER'],
                // Join with users table for doctors
                ['table' => "{$this->users_table_name} AS doctor_users", 'on' => "{$this->doctor_table_name}.user_id = doctor_users.ID", 'type' => 'INNER'],
                // Join with usermeta table for doctors
                ['table' => "{$this->usermeta_table_name} AS doctor_usermeta", 'on' => "doctor_usermeta.user_id = doctor_users.ID", 'type' => 'LEFT'],
            ],
        );
    
        return $results;
    }

    public function getAppointmentsById( $id = null ) {
        
        $id = get_current_user_id();

        if(!$id) {
            wp_die('Please login First !!!');
        }
        return $this->getAppointmentsWithJoins( [
            "{$this->patient_table_name}.user_id" => $id
        ]);
    }

    public function createAppointment(array $data) {
        $this->insert($data);
    }

    /**
     * Update the status of an appointment.
     *
     * @param int $appointmentId The ID of the appointment to update.
     * @param string $status The new status to set.
     * @return bool|int Returns the number of rows updated or false on failure.
     */
    public function updateAppointmentStatus($appointmentId, $status) {
        // Validate the status
        $allowedStatuses = ['Scheduled', 'Completed', 'Cancelled', 'No Show'];
        if (!in_array($status, $allowedStatuses)) {
            return false; // Invalid status
        }

        // Update the appointment status
        return $this->update(
            $appointmentId,
            ['status' => $status],
        );
    }
}
