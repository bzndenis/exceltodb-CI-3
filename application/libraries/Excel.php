<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Jika menggunakan Composer
use PHPExcel;

class Excel extends PHPExcel {
    public function __construct() {
        parent::__construct();
    }
} 