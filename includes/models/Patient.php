<?php
/**
 * Patient Model
 * Handles CRUD operations for the patients table.
 */

 namespace HMS\Includes\Models;

// Correctly import the AdvancedORM class
use HMS\Includes\Init\AdvanceORM;

class Patient extends AdvanceORM {
    protected $table = 'patients';
    protected $fillable = ['hospital_id', 'user_id', 'doctor_id'];
    protected $prefix = 'hms_';
    protected $primaryKey = 'id';

    public function __construct() {
        parent::__construct($this->table, $this->prefix, $this->primaryKey, $this->fillable);
    }

    public function create() {
        $this->createTable([
            'hospital_id' => 'INT(11) NOT NULL',
            'user_id' => 'BIGINT(20) UNSIGNED NOT NULL UNIQUE',
            'admission_date' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
            'doctor_id' => 'INT(11) NOT NULL',
            'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'FOREIGN KEY (doctor_id)' => 'REFERENCES hms_doctors(id) ON DELETE CASCADE',
            'FOREIGN KEY (hospital_id)' => 'REFERENCES hms_hospitals(id) ON DELETE CASCADE',
            'FOREIGN KEY (user_id)' => 'REFERENCES ' . $this->wpdb->prefix . 'users(ID) ON DELETE CASCADE',
        ]);
    }

    public function get_table_name() {
        return $this->table;
    }
    
    public function insertPatient($data) {
        return $this->insert($data);
    }

    public function getAllActivePatients() {
        return $this->select('*', ['status' => 'Active']);
    }

    public function getAllPatients() {
        return $this->select_with_user();
    }
}
