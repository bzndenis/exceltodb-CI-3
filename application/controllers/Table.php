<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('table_model');
    }
    
    public function view($table_name) {
        // Sanitasi nama tabel
        $table_name = preg_replace('/[^a-zA-Z0-9_]/', '', $table_name);
        
        // Simpan nama tabel terakhir di session
        $this->session->set_userdata('last_table', $table_name);
        
        $data['table_name'] = $table_name;
        $data['columns'] = $this->table_model->get_columns($table_name);
        $data['data'] = $this->table_model->get_data($table_name);
        
        $this->load->view('table_view', $data);
    }
    
    public function edit() {
        header('Content-Type: application/json');
        
        $table_name = $this->input->post('table_name');
        $id = $this->input->post('id');
        $column = $this->input->post('column');
        $value = $this->input->post('value');
        
        // Sanitasi input
        $table_name = preg_replace('/[^a-zA-Z0-9_]/', '', $table_name);
        $column = preg_replace('/[^a-zA-Z0-9_]/', '', $column);
        
        if ($this->table_model->update_cell($table_name, $id, $column, $value)) {
            echo json_encode(['status' => 'success']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Gagal mengupdate data']);
        }
    }
    
    public function delete() {
        $table_name = $this->input->post('table_name');
        $id = $this->input->post('id');
        
        // Sanitasi input
        $table_name = preg_replace('/[^a-zA-Z0-9_]/', '', $table_name);
        
        if ($this->table_model->delete_row($table_name, $id)) {
            $this->session->set_flashdata('success', 'Data berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data');
        }
        
        redirect("table/view/$table_name");
    }
    
    public function download_sql($table_name) {
        // Sanitasi nama tabel
        $table_name = preg_replace('/[^a-zA-Z0-9_]/', '', $table_name);
        
        // Ambil struktur dan data tabel
        $table_structure = $this->table_model->get_table_structure($table_name);
        $table_data = $this->table_model->get_data($table_name);
        
        // Generate SQL content
        $sql_content = "-- Database dump for table `{$table_name}`\n";
        $sql_content .= "-- Generated on " . date('Y-m-d H:i:s') . "\n\n";
        
        // Drop table if exists
        $sql_content .= "DROP TABLE IF EXISTS `{$table_name}`;\n\n";
        
        // Create table structure
        $sql_content .= $table_structure . ";\n\n";
        
        // Insert data
        if (!empty($table_data)) {
            $sql_content .= "-- Dumping data for table `{$table_name}`\n";
            $sql_content .= "INSERT INTO `{$table_name}` VALUES\n";
            
            $rows = [];
            foreach ($table_data as $row) {
                $values = array_map(function($value) {
                    if ($value === null) {
                        return 'NULL';
                    }
                    return "'" . addslashes($value) . "'";
                }, $row);
                $rows[] = "(" . implode(", ", $values) . ")";
            }
            
            $sql_content .= implode(",\n", $rows) . ";\n";
        }
        
        // Set headers for download
        header('Content-Type: application/sql');
        header('Content-Disposition: attachment; filename="' . $table_name . '_' . date('Y-m-d') . '.sql"');
        header('Content-Length: ' . strlen($sql_content));
        
        // Output SQL content
        echo $sql_content;
        exit;
    }
} 