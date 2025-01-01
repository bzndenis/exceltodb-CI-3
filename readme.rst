###################
Excel2DB
###################

Excel2DB is a web-based tool built with CodeIgniter 3 that simplifies the process of converting Excel files into database tables. It provides an intuitive interface for data management with features like inline editing, SQL export, and real-time validation.

*******************
Main Features
*******************

* Excel Processing
    - Support for .xlsx and .xls formats
    - Drag & drop file upload
    - Data preview before import
    - Automatic column mapping
    - File size validation (up to 5MB)

* Database Management
    - Interactive data tables
    - Inline cell editing
    - Real-time data validation
    - Row deletion with confirmation
    - SQL file export

* User Interface
    - Modern responsive design with Tailwind CSS
    - Interactive notifications using SweetAlert2
    - Progress indicators
    - Mobile-friendly layout

**************************
Server Requirements
**************************

* PHP >= 7.4
* MySQL 5.7+ or MariaDB 10.3+
* Apache/Nginx web server
* Composer
* PHP Extensions:
    - php-mysqli
    - php-zip
    - php-xml
    - php-gd

************
Installation
************

1. Clone the repository::

    git clone https://github.com/yourusername/excel2db.git
    cd excel2db

2. Install dependencies::

    composer install

3. Configure database in ``application/config/database.php``::

    $db['default'] = [
        'hostname' => 'localhost',
        'username' => 'your_username',
        'password' => 'your_password',
        'database' => 'your_database',
        'dbdriver' => 'mysqli',
        'dbprefix' => '',
        'pconnect' => FALSE,
        'db_debug' => TRUE,
        'char_set' => 'utf8',
        'dbcollat' => 'utf8_general_ci'
    ];

4. Set base URL in ``application/config/config.php``::

    $config['base_url'] = 'http://your-domain.com/';

5. Configure routes in ``application/config/routes.php``::

    $route['default_controller'] = 'excel';
    $route['404_override'] = '';
    $route['translate_uri_dashes'] = FALSE;

*******
Usage
*******

1. Upload Excel File
-------------------
Navigate to the home page and either:

* Drag and drop your Excel file into the upload area
* Click to select and upload your file

2. Preview & Configure
---------------------
* Review the data preview
* Customize table and column names
* Validate data types

3. Manage Data
-------------
* View and edit data directly in the table
* Delete unwanted rows
* Export table as SQL file

*******
License
*******

This project is licensed under the MIT License. See LICENSE file for details.

***********
File Structure
***********

::

    excel2db/
    ├── application/
    │   ├── config/
    │   │   ├── config.php
    │   │   ├── database.php
    │   │   └── routes.php
    │   ├── controllers/
    │   │   ├── Excel.php
    │   │   └── Table.php
    │   ├── models/
    │   │   ├── Excel_model.php
    │   │   └── Table_model.php
    │   └── views/
    │       ├── templates/
    │       │   ├── header.php
    │       │   ├── navbar.php
    │       │   └── footer.php
    │       ├── excel_upload.php
    │       ├── excel_preview.php
    │       └── table_view.php
    ├── uploads/
    └── assets/

*************
Contributing
*************

1. Fork the repository
2. Create your feature branch::

    git checkout -b feature/amazing-feature

3. Commit your changes::

    git commit -m 'Add some amazing feature'

4. Push to the branch::

    git push origin feature/amazing-feature

5. Open a Pull Request

***************
Security
***************

* Input sanitization implemented
* SQL injection prevention
* File type validation
* Error handling and logging

If you discover any security issues, please email security@yourdomain.com

***************
Credits
***************

Built with:

* `CodeIgniter 3 <https://codeigniter.com/>`_
* `PHPSpreadsheet <https://phpspreadsheet.readthedocs.io/>`_
* `Tailwind CSS <https://tailwindcss.com/>`_
* `SweetAlert2 <https://sweetalert2.github.io/>`_

***************
Support
***************

For support:

* Open an issue on GitHub
* Email: support@yourdomain.com
* Documentation: https://yourdomain.com/docs
