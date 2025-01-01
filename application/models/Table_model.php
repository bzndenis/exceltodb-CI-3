<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_model extends CI_Model {
    
    public function get_columns($table_name) {
        return $this->db->list_fields($table_name);
    }
    
    public function get_data($table_name) {
        return $this->db->get($table_name)->result_array();
    }
    
    public function update_cell($table_name, $id, $column, $value) {
        return $this->db->update($table_name, [$column => $value], ['id' => $id]);
    }
    
    public function delete_row($table_name, $id) {
        return $this->db->delete($table_name, ['id' => $id]);
    }
    
    public function get_table_structure($table_name) {
        $query = $this->db->query("SHOW CREATE TABLE `$table_name`");
        $row = $query->row_array();
        return $row['Create Table'];
    }
} 