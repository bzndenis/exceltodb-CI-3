<?php $this->load->view('templates/header', ['title' => 'Preview Data Excel']); ?>
<?php $this->load->view('templates/navbar'); ?>

<div class="flex-grow py-6">
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

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Nama Kolom
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <?php 
                            // Ambil baris pertama sebagai header
                            $header_row = isset($excel_data[1]) ? $excel_data[1] : [];
                            
                            // Hitung jumlah kolom dari baris header
                            $column_count = count($header_row);
                            
                            // Loop untuk setiap kolom
                            for($i = 0; $i < $column_count; $i++): 
                                $column_letter = chr(65 + $i); // A, B, C, dst
                                $column_value = isset($header_row[$column_letter]) ? $header_row[$column_letter] : '';
                                // Sanitasi nilai kolom
                                $column_value = preg_replace('/[^a-zA-Z0-9_\s]/', '', $column_value);
                            ?>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">
                                        Kolom <?php echo $column_letter; ?>
                                    </label>
                                    <input type="text" 
                                           name="columns[]" 
                                           value="<?php echo $column_value; ?>" 
                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                           required>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <?php for($i = 0; $i < $column_count; $i++): ?>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Kolom <?php echo chr(65 + $i); ?>
                                        </th>
                                    <?php endfor; ?>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php 
                                // Tampilkan 25 baris preview teratas (sebelumnya 5)
                                $preview_rows = array_slice($excel_data, 1, 25, true);
                                foreach($preview_rows as $row): 
                                ?>
                                    <tr>
                                        <?php for($i = 0; $i < $column_count; $i++): 
                                            $column_letter = chr(65 + $i);
                                            $cell_value = isset($row[$column_letter]) ? $row[$column_letter] : '';
                                        ?>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <?php echo htmlspecialchars($cell_value); ?>
                                            </td>
                                        <?php endfor; ?>
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

<?php $this->load->view('templates/footer'); ?> 