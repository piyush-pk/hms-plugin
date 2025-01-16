<?php
/**
 * Doctor Model
 * Handles CRUD operations for the doctors table.
 */

namespace HMS\Includes\Models;

use HMS\Includes\Init\AdvanceORM;

class Doctor extends AdvanceORM {
    protected $table = 'doctors';
    protected $prefix = 'hms_';
    protected $primaryKey = 'id';
    protected $fillable = ['hospital_id', 'user_id', 'specialty', 'qualification', 'experience_years', 'license_number', 'department', 'specialty', 'status'];

    public function __construct() {
        // Correctly access properties using $this->propertyName
        parent::__construct($this->table, $this->prefix, $this->primaryKey, $this->fillable);
    }

    public function create() {
        $this->createTable([
            'hospital_id' => 'INT(11) NOT NULL',
            'user_id' => 'BIGINT(20) UNSIGNED NOT NULL UNIQUE',
            'qualification' => 'VARCHAR(255)',
            'experience_years' => 'INT NOT NULL',
            'license_number' => 'VARCHAR(50)',
            'department' =>'VARCHAR(255)',
            'address' => 'VARCHAR(255) NOT NULL',
            'specialty' => 'VARCHAR(255) NOT NULL',
            'status' => "ENUM('Active', 'Inactive', 'On Leave') DEFAULT 'Active'",
            'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'FOREIGN KEY (hospital_id)' => 'REFERENCES hms_hospitals(id) ON DELETE CASCADE',
            'FOREIGN KEY (user_id)' => 'REFERENCES ' . $this->wpdb->prefix . 'users(ID) ON DELETE CASCADE',
        ]);
    }

    public function get_table_name() {
        return $this->table;
    }

    public function getActiveDoctors() {
        return $this->select_with_user();
    }

    public function createDoctor($data) {
        return $this->insert($data);
    }
}
