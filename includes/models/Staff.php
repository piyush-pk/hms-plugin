<?php
/**
 * Staff Model
 * Handles CRUD operations for the staffs table.
 */

namespace HMS\Includes\Models;

// Correctly import the AdvancedORM class
use HMS\Includes\Init\AdvanceORM;

class Staff extends AdvanceORM {
    protected $table = 'staffs';
    protected $prefix = 'hms_';
    protected $primaryKey = 'id';

    protected $fillable = ['hospital_id', 'user_id', 'job_title', 'department', 'shift', 'salary', 'marital_status', 'bank_account_number', 'bank_name',
];

    public function __construct() {
        parent::__construct($this->table, $this->prefix, $this->primaryKey, $this->fillable);
    }

    public function create() {
        $this->createTable([
            'hospital_id' => 'INT(11) NOT NULL',
            'user_id' => 'BIGINT(20) UNSIGNED NOT NULL UNIQUE',
            'job_title' => 'VARCHAR(255) NOT NULL',
            'department' => 'VARCHAR(255) NOT NULL',
            'shift' => "ENUM('Morning', 'Evening', 'Night')",
            'salary' => 'DECIMAL(10, 2) NOT NULL',
            'status' => "ENUM('Active', 'Inactive', 'On Leave') DEFAULT 'Active'",
            'roles' => 'VARCHAR(255) NOT NULL',
            'work_location' => "ENUM('NAGAR', 'ALWAR') NOT NULL DEFAULT 'NAGAR'",
            'bank_account_number' => 'VARCHAR(16) NOT NULL',
            'bank_name' => 'VARCHAR(255) NOT NULL',
            'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'FOREIGN KEY (hospital_id)' => 'REFERENCES hms_hospitals(id) ON DELETE CASCADE',
            'FOREIGN KEY (user_id)' => 'REFERENCES ' . $this->wpdb->prefix . 'users(ID) ON DELETE CASCADE',
        ]);
    }

    public function getAllActiveStaffMembers() {
        return $this->select_with_user( );
    }

    public function insertStaff($data) {
        return $this->insert($data);
    }
}
