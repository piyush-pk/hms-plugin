<?php
/**
 * Hospital Model
 * Handles CRUD operations for the hospitals table.
 */

namespace HMS\Includes\Models;

// Correctly import the AdvancedORM class
use HMS\Includes\Init\AdvanceORM;

class Hospital extends AdvanceORM {
    protected $table = 'hospitals';
    protected $prefix = 'hms_';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'address', 'city', 'state', 'zip_code', 'phone', 'email', 'num_beds', 'specializations', 'status'];

    public function __construct() {
        parent::__construct($this->table, $this->prefix, $this->primaryKey, $this->fillable);
    }

    public function create() {
        $this->createTable([
            'name' => 'VARCHAR(255) NOT NULL',
            'address' => 'TEXT NOT NULL',
            'city' => 'VARCHAR(100) NOT NULL',
            'state' => 'VARCHAR(100) NOT NULL',
            'zip_code' => 'VARCHAR(10)',
            'phone' => 'VARCHAR(15) NOT NULL',
            'email' => 'VARCHAR(255)',
            'num_beds' => 'INT(11)',
            'specializations' => 'TEXT',
            'status' => "ENUM('Active', 'Inactive') DEFAULT 'Active'",
            'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);
    }

    public function insertData($data) {
        $response = $this->insert($data);
        return $response;
    }

    public function getAllActiveHospitals() {
        return $this->select('*', ['status' => 'Active']) ?? [];
    }

    public function getAllHospitals() {
        return $this->select();
    }

    public function getDataById($id) {
        return $this->select('*', ['id' => $id]);
    }

    public function updateHospital($id, $data) {
        return $this->update($id, $data);
    }
}
