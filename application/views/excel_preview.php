<!DOCTYPE html>
<html>
<head>
    <title>Preview Data Excel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/@heroicons/react@1.0.5/outline.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                    <h3 class="text-2xl font-semibold text-gray-900">
                        Preview Data Excel
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Edit nama kolom dan preview data sebelum disimpan ke database
                    </p>
                </div>

                <?php echo form_open('excel/save', ['class' => 'px-4 py-5 sm:p-6']); ?>
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Nama Tabel
                            </label>
                            <input type="text" 
                                   name="table_name" 
                                   value="<?php echo $table_name; ?>" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                   required>
                        </div>

                        <div class="mb-4 flex justify-between items-center">
                            <div class="relative">
                                <input type="text" 
                                       id="searchInput"
                                       placeholder="Cari data..." 
                                       class="pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-500">Total Baris:</span>
                                <span id="rowCount" class="px-2 py-1 bg-gray-100 rounded-md text-sm font-medium text-gray-700"></span>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <?php
                                        $first_row = reset($excel_data);
                                        foreach($first_row as $key => $value): ?>
                                            <th class="px-3 py-3">
                                                <div class="relative rounded-md shadow-sm">
                                                    <input type="text" 
                                                           name="columns[]" 
                                                           value="<?php echo strtolower(str_replace(' ', '_', $value)); ?>"
                                                           class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                           required>
                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            </th>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php 
                                    $row_count = 0;
                                    foreach($excel_data as $row): 
                                        $row_count++;
                                        if($row_count === 1) continue; // Skip header row
                                    ?>
                                        <tr class="hover:bg-gray-50">
                                            <?php foreach($row as $cell): ?>
                                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <?php echo $cell; ?>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="<?php echo site_url('excel'); ?>" 
                               class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Simpan ke Database
                            </button>
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk mengatur lebar kolom secara dinamis
        function adjustColumnWidths() {
            const table = document.querySelector('table');
            const headers = table.querySelectorAll('th');
            
            headers.forEach((header, index) => {
                const cells = table.querySelectorAll(`td:nth-child(${index + 1})`);
                let maxWidth = header.offsetWidth;
                
                cells.forEach(cell => {
                    maxWidth = Math.max(maxWidth, cell.offsetWidth);
                });
                
                header.style.minWidth = `${maxWidth}px`;
                cells.forEach(cell => {
                    cell.style.minWidth = `${maxWidth}px`;
                });
            });
        }

        // Jalankan saat halaman dimuat
        window.addEventListener('load', adjustColumnWidths);
        // Jalankan saat ukuran window berubah
        window.addEventListener('resize', adjustColumnWidths);

        // Pencarian
        const searchInput = document.getElementById('searchInput');
        const tbody = document.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        const rowCount = document.getElementById('rowCount');

        function updateRowCount() {
            const visibleRows = rows.filter(row => !row.classList.contains('hidden'));
            rowCount.textContent = visibleRows.length;
        }

        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            
            rows.forEach(row => {
                const text = Array.from(row.querySelectorAll('td'))
                    .map(td => td.textContent.toLowerCase())
                    .join(' ');
                
                if (text.includes(searchTerm)) {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                }
            });
            
            updateRowCount();
        });

        // Update initial row count
        updateRowCount();
    </script>
</body>
</html> 