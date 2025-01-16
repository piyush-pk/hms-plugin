<?php

/**
 * Advanced ORM Class
 * Handles dynamic table creation, insert, select, update, and delete operations.
 */

namespace HMS\Includes\Init;

class AdvanceORM
{
    protected $table;
    protected $fillable = [];
    protected $primaryKey = 'id';
    protected $wpdb;
    protected $prefix = 'wp_';

    public function __construct(string $table, string $prefix = 'wp_', string $primaryKey = 'id', array $fillable = [])
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->prefix = $prefix;
        $this->table = $prefix . $table;
        $this->primaryKey = $primaryKey;
        $this->fillable = $fillable;
    }

    // Create table dynamically based on attributes
    public function createTable($attributes = [])
    {
        $columns = [];
        $primary_key = "$this->primaryKey INT(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY ($this->primaryKey)";
        // Add columns from attributes
        $columns[] = "$primary_key";
        foreach ($attributes as $column => $type) {
            $columns[] = "{$column} {$type}";
        }

        // primary add to query

        $columns_sql = implode(", ", $columns);
        $sql = "CREATE TABLE IF NOT EXISTS {$this->table} ({$columns_sql}) {$this->wpdb->get_charset_collate()}";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }


    // Insert data into table
    public function insert($data)
    {
        $data = array_intersect_key($data, array_flip($this->fillable)); // Only allow fillable fields
        $is_inserted = $this->wpdb->insert($this->table, $data);
        if ($is_inserted === false) {
            // Error occurred, display the error message
            $error_message = $this->wpdb->last_error;  // Get the last error from wpdb
            wp_die("Error inserting data: " . $error_message);  // Show the error message and stop execution
        } else {
            echo <<< 'ALERT'
                <div class="relative items-center w-full px-5 py-12 mx-auto md:px-12 lg:px-24 max-w-7xl">
                 <div class="p-6 border-l-4 border-green-500 -6 rounded-r-xl bg-green-50">
                    <div class="flex">
                    <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    </div>
                    <div class="ml-3">
                    <div class="text-sm text-green-600">
                        <p>Record Added Successfully. 😍</p>
                    </div>
                    </div>
                </div>
                </div>
                </div>
                ALERT;
        }

        return $this->wpdb->insert_id;
    }

    /**
     * Selects data from the custom table along with associated user data and user meta fields.
     *
     * @param string|array $columns    The columns to select. Default is '*'.
     * @param array        $conditions The WHERE conditions as an associative array.
     * @param array        $order_by   The ORDER BY clause as an associative array.
     * @param int|null     $limit      The LIMIT clause.
     * @return array                  The fetched results.
     */
    public function select_with_user($columns = '*', $conditions = [], $order_by = [], $limit = null)
    {
        // Define table names with WordPress prefix
        $users_table_name = $this->wpdb->prefix . 'users';
        $usermeta_table_name = $this->wpdb->prefix . 'usermeta';
        $table_name = $this->table;

        // If columns are set to '*', include all columns from the custom table and users table
        if ($columns === '*') {
            $columns = "{$table_name}.*, users.*";
        }

        // Base query to fetch data from the custom table, users table, and usermeta table
        $query = "SELECT 
                {$columns},
                GROUP_CONCAT(usermeta.meta_key, ':', usermeta.meta_value SEPARATOR '|') AS user_meta 
              FROM {$table_name}
              INNER JOIN {$users_table_name} AS users 
                ON {$table_name}.user_id = users.ID
              LEFT JOIN {$usermeta_table_name} AS usermeta 
                ON users.ID = usermeta.user_id";

        // Add WHERE conditions if provided
        if (!empty($conditions)) {
            // Prepare the condition string with placeholders to prevent SQL injection
            $condition_str = implode(" AND ", array_map(function ($key, $value) {
                return is_string($value) ? "{$key} = %s" : "{$key} = %d";
            }, array_keys($conditions), $conditions));

            // Append the WHERE clause to the query
            $query .= " WHERE {$condition_str}";

            // Safely prepare the query with the condition values
            $query = $this->wpdb->prepare($query, ...array_values($conditions));
        }

        // Group by the custom table's primary key to combine meta fields
        $query .= " GROUP BY {$table_name}.id";

        // Add ORDER BY clause if provided
        if (!empty($order_by)) {
            $orderBy_str = implode(", ", array_map(function ($field, $direction) {
                return "{$field} {$direction}";
            }, array_keys($order_by), $order_by));
            $query .= " ORDER BY {$orderBy_str}";
        }

        // Add LIMIT clause if provided
        if ($limit !== null) {
            $query .= " LIMIT %d";
            $query = $this->wpdb->prepare($query, $limit);
        }

        // Execute the query and fetch results
        $results = $this->wpdb->get_results($query, ARRAY_A);

        // Process user meta data into individual top-level fields
        foreach ($results as &$result) {
            if (!empty($result['user_meta'])) {
                // Split the user_meta string into individual key-value pairs
                $meta_data = explode('|', $result['user_meta']);
                foreach ($meta_data as $meta) {
                    [$key, $value] = explode(':', $meta);
                    // Flatten the user meta fields into top-level keys
                    $result[$key] = $value;
                }
            }

            // Remove sensitive fields like password and activation key
            unset($result['user_pass']);          // Remove password field
            unset($result['user_activation_key']); // Remove activation key field

            // Clean up the 'user_meta' field if it exists
            unset($result['user_meta']);
        }

        return $results;
    }

    /**
     * Executes a SELECT query on the database table with optional conditions, joins, grouping, ordering, and limiting.
     *
     * @param string|array $columns   The columns to select. Default is '*' (all columns).
     * @param array $conditions       Associative array of WHERE conditions (e.g., ['column' => 'value']).
     * @param array $orderBy          Associative array for ORDER BY clause (e.g., ['column' => 'ASC']).
     * @param int|null $limit         Maximum number of rows to return. Null means no limit.
     * @param array $groupBy          Array of columns for GROUP BY clause.
     * @param array $having           Associative array for HAVING clause (e.g., ['aggregate_column' => 'value']).
     * @param array $join             Array of JOIN clauses (e.g., [['table' => 'other_table', 'on' => 'condition', 'type' => 'INNER']]).
     * @return array                  The query results as an array of objects.
     */
    public function select($columns = '*', $conditions = [], $orderBy = [], $limit = null, $groupBy = [], $having = [], $join = [])
    {
        // Start building the SQL query
        $sql = "SELECT {$columns} FROM {$this->table}";
        $values = []; // Array to hold values for prepared statements

        // Add JOIN clauses if provided
        if (!empty($join)) {
            foreach ($join as $j) {
                $joinType = isset($j['type']) ? strtoupper($j['type']) : 'INNER'; // Default to INNER JOIN if no type is specified
                $sql .= " {$joinType} JOIN {$j['table']} ON {$j['on']}";
            }
        }

        // Add WHERE conditions if provided
        if (!empty($conditions)) {
            // Use a foreach loop for better clarity and control
            $condition_str = implode(" AND ", array_map(function ($key, $value) {
                // Check if the value is a string or numeric to format the condition properly
                return is_string($value) ? "{$key} = %s" : "{$key} = %d";
            }, array_keys($conditions), $conditions)); // Pass both keys and values to array_map
        
            $sql .= " WHERE {$condition_str}";
            $values = array_merge($values, array_values($conditions)); // Add condition values to the values array
        }
        

        // Add GROUP BY clause if provided
        if (!empty($groupBy)) {
            $sql .= " GROUP BY " . implode(", ", $groupBy);
        }

        // Add HAVING clause if provided
        if (!empty($having)) {
            $having_str = implode(" AND ", array_map(function ($key) {
                return "{$key} = %s"; // Map each HAVING condition to a placeholder
            }, array_keys($having)));
            $sql .= " HAVING {$having_str}";
            $values = array_merge($values, array_values($having)); // Add HAVING values to the values array
        }

        // Add ORDER BY clause if provided
        if (!empty($orderBy)) {
            $orderBy_str = implode(", ", array_map(function ($field, $direction) {
                return "{$field} {$direction}"; // Map each field to its sorting direction
            }, array_keys($orderBy), $orderBy));
            $sql .= " ORDER BY {$orderBy_str}";
        }

        // Add LIMIT clause if provided
        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }

        // Prepare the SQL query if there are placeholders
        if (!empty($values)) {
            $sql = $this->wpdb->prepare($sql, $values); // Safely bind values to placeholders
        }

        // Debug: Print the final query (remove this in production)
        // print_r($sql);

        // Execute the query and return the results
        return $this->wpdb->get_results($sql);
    }



    // Update records in the table
    public function update($id, $data)
    {
        // print_r($data);
        $data = array_intersect_key($data, array_flip($this->fillable)); // Only allow fillable fields

        $result = $this->wpdb->update($this->table, $data, [$this->primaryKey => $id]);
        return $result;
    }

    // Delete records from the table
    public function delete($id)
    {
        $this->wpdb->delete($this->table, [$this->primaryKey => $id]);
    }
}
