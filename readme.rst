Here's the GitHub-style description for Excel2DB:

###################
What is Excel2DB?
###################

Excel2DB is a powerful web application built with CodeIgniter that converts Excel files into database tables. It provides an intuitive interface for uploading Excel files, previewing data, and managing database tables with advanced features for data manipulation. The application aims to simplify the process of importing Excel data into databases while maintaining data integrity and providing powerful management tools.

*******************
Key Features
*******************

- Excel file upload with drag & drop support (.xlsx, .xls)
- Data preview before import
- Custom table and column naming
- Interactive data table management
- Inline cell editing
- SQL file export
- Responsive design with Tailwind CSS
- Real-time data validation
- Secure data handling

**************************
Server Requirements
**************************

- PHP version 7.4 or newer
- MySQL 5.7 or newer / MariaDB 10.3 or newer
- Composer for dependency management
- Modern web browser with JavaScript enabled

************
Installation
************

1. Clone the repository
   ```bash
   git clone https://github.com/yourusername/excel2db.git
   ```

2. Install dependencies
   ```bash
   composer install
   ```

3. Configure database in `application/config/database.php`
   ```php
   $db['default'] = array(
       'hostname' => 'your_hostname',
       'username' => 'your_username',
       'password' => 'your_password',
       'database' => 'your_database'
   );
   ```

4. Set base URL in `application/config/config.php`
   ```php
   $config['base_url'] = 'http://your-domain.com/';
   ```

5. Create uploads directory and ensure it's writable
   ```bash
   mkdir uploads
   chmod 777 uploads
   ```

*******
License
*******

This project is licensed under the MIT License - see the LICENSE file for details.

*********
Resources
*********

- Built with CodeIgniter 3
- Styled with Tailwind CSS
- Uses PHPSpreadsheet for Excel processing
- SweetAlert2 for notifications

***************
Project Structure
***************

```
excel2db/
├── application/
│   ├── controllers/
│   │   ├── Excel.php
│   │   └── Table.php
│   ├── models/
│   │   ├── Excel_model.php
│   │   └── Table_model.php
│   └── views/
│       ├── excel_upload.php
│       ├── excel_preview.php
│       └── table_view.php
├── uploads/
└── assets/
```

***************
Usage Examples
***************

1. Upload Excel File
   ```php
   // Controller: Excel.php
   public function upload() {
       // Handle file upload
       $config['upload_path'] = './uploads/';
       $config['allowed_types'] = 'xlsx|xls';
       $this->load->library('upload', $config);
   }
   ```

2. Export SQL
   ```php
   // Controller: Table.php
   public function download_sql($table_name) {
       // Generate SQL file
       $table_structure = $this->table_model->get_table_structure($table_name);
       $table_data = $this->table_model->get_data($table_name);
   }
   ```

***************
Acknowledgement
***************

Special thanks to:
- CodeIgniter Team
- PHPSpreadsheet Contributors
- Tailwind CSS Team
- All contributors to this project

***************
Contributing
***************

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request

Please read CONTRIBUTING.md for details on our code of conduct and the process for submitting pull requests.

***************
Support
***************

For support, please open an issue in the GitHub repository or contact the maintainers directly.

Report security issues to our Security Panel or via our page on HackerOne.
