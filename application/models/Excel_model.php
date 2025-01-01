<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Excel_model extends CI_Model {

    public function create_table($table_name, $columns) {
        // Sanitasi nama tabel
        $table_name = preg_replace('/[^a-zA-Z0-9_]/', '', $table_name);
        
        // Hapus tabel jika sudah ada
        $this->db->query("DROP TABLE IF EXISTS `$table_name`");
        
        // Buat query CREATE TABLE
        $sql = "CREATE TABLE `$table_name` (
            `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,";
            
        foreach ($columns as $column) {
            // Sanitasi nama kolom dan tambahkan prefix 'col_' jika kolom berupa angka
            $column = preg_replace('/[^a-zA-Z0-9_]/', '', $column);
            if (is_numeric($column)) {
                $column = 'col_' . $column;
            }
            $sql .= "\n `$column` VARCHAR(255),";
        }
        
        $sql = rtrim($sql, ',');
        $sql .= "\n) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        
        return $this->db->query($sql);
    }

    public function insert_data($table_name, $excel_data, $columns) {
        // Sanitasi nama tabel
        $table_name = preg_replace('/[^a-zA-Z0-9_]/', '', $table_name);
        
        // Skip baris header
        unset($excel_data[1]);
        
        // Modifikasi nama kolom untuk angka
        $modified_columns = array_map(function($column) {
            $column = preg_replace('/[^a-zA-Z0-9_]/', '', $column);
            return is_numeric($column) ? 'col_' . $column : $column;
        }, $columns);
        
        $batch_data = array();
        foreach ($excel_data as $row) {
            $data = array();
            $i = 0;
            foreach ($modified_columns as $column) {
                $data[$column] = isset($row[chr(65 + $i)]) ? $row[chr(65 + $i)] : null; // A, B, C, dst
                $i++;
            }
            $batch_data[] = $data;
        }
        
        // Insert batch untuk performa lebih baik
        if (!empty($batch_data)) {
            return $this->db->insert_batch($table_name, $batch_data);
        }
        return false;
    }
} 