<?php
/**
 * Medical History Model
 * Handles CRUD operations for the medical history table.
 */

namespace HMS\Includes\Models;

// Correctly import the AdvancedORM class
use HMS\Includes\Init\AdvanceORM;

class MedicalHistory extends AdvanceORM {
    protected $table = 'medical_history';
    protected $prefix = 'hms_';
    protected $primaryKey = 'id';

    public function __construct() {
        parent::__construct($this->table, $this->prefix, $this->primaryKey);
    }

    public function create() {
        $this->createTable([
            'patient_id' => 'INT(11) NOT NULL',
            'doctor_id' => 'INT(11) DEFAULT NULL',
            'hospital_id' => 'INT(11) DEFAULT NULL',
            'diagnosis' => 'TEXT',
            'symptoms' => 'TEXT',
            'treatment' => 'TEXT',
            'medications' => 'TEXT',
            'allergies' => 'TEXT',
            'visit_date' => 'DATE NOT NULL',
            'follow_up_date' => 'DATE DEFAULT NULL',
            'report_file' => 'VARCHAR(255)',
            'status' => "ENUM('Ongoing', 'Completed', 'Referred') DEFAULT 'Ongoing'",
            'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'FOREIGN KEY (patient_id)' => 'REFERENCES hms_patients(id) ON DELETE CASCADE',
            'FOREIGN KEY (doctor_id)' => 'REFERENCES hms_doctors(id) ON DELETE SET NULL',
            'FOREIGN KEY (hospital_id)' => 'REFERENCES hms_hospitals(id) ON DELETE SET NULL',
        ]);
    }
}
