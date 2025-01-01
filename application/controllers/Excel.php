<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Exception as SpreadsheetException;

class Excel extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('excel_model');
        $this->load->library('session');
        
        // Buat folder uploads jika belum ada
        if (!is_dir('./uploads/')) {
            mkdir('./uploads/', 0777, true);
        }
    }

    public function index() {
        $this->load->view('excel_upload');
    }

    public function upload() {
        // Konfigurasi upload
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'xlsx|xls';
        $config['max_size'] = '5000';
        $config['overwrite'] = TRUE;
        
        $this->load->library('upload', $config);
        
        if (!$this->upload->do_upload('excel_file')) {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect('excel');
            return;
        }
        
        try {
            $data = $this->upload->data();
            $inputFileName = $data['full_path'];
            
            if (!file_exists($inputFileName)) {
                throw new Exception('File tidak ditemukan');
            }
            
            $spreadsheet = IOFactory::load($inputFileName);
            $sheetData = $spreadsheet->getActiveSheet()
                                   ->toArray(null, true, true, true);
            
            // Hapus file setelah dibaca
            @unlink($inputFileName);
            
            if (empty($sheetData)) {
                throw new Exception('File Excel kosong');
            }
            
            $this->session->set_userdata([
                'excel_data' => $sheetData,
                'table_name' => pathinfo($data['file_name'], PATHINFO_FILENAME)
            ]);
            
            redirect('excel/preview');
            
        } catch (Exception $e) {
            $this->session->set_flashdata('error', 'Error: ' . $e->getMessage());
            redirect('excel');
        }
    }

    public function preview() {
        $data = [
            'excel_data' => $this->session->userdata('excel_data'),
            'table_name' => $this->session->userdata('table_name')
        ];
        
        if (empty($data['excel_data'])) {
            $this->session->set_flashdata('error', 'Data Excel tidak ditemukan');
            redirect('excel');
            return;
        }
        
        $this->load->view('excel_preview', $data);
    }

    public function save() {
        $table_name = $this->input->post('table_name');
        $excel_data = $this->session->userdata('excel_data');
        $columns = $this->input->post('columns');
        
        if (empty($table_name) || empty($excel_data) || empty($columns)) {
            $this->session->set_flashdata('error', 'Data tidak lengkap');
            redirect('excel');
            return;
        }
        
        try {
            // Buat tabel baru
            if (!$this->excel_model->create_table($table_name, $columns)) {
                throw new Exception('Gagal membuat tabel');
            }
            
            // Masukkan data
            if (!$this->excel_model->insert_data($table_name, $excel_data, $columns)) {
                throw new Exception('Gagal memasukkan data');
            }
            
            $this->session->set_flashdata('success', 'Data berhasil disimpan ke database');
            
        } catch (Exception $e) {
            $this->session->set_flashdata('error', 'Error: ' . $e->getMessage());
        }
        
        redirect('excel');
    }
} 