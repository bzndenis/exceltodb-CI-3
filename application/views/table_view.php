<?php $this->load->view('templates/header', ['title' => 'Tabel ' . $table_name]); ?>
<?php $this->load->view('templates/navbar'); ?>

<div class="flex-grow py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6 flex justify-between items-center">
                <div>
                    <h3 class="text-2xl font-semibold text-gray-900">
                        Tabel: <?php echo $table_name; ?>
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Klik pada data untuk mengedit
                    </p>
                </div>
                <div class="flex space-x-3">
                    <a href="<?php echo site_url("table/download_sql/$table_name"); ?>" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                        Download SQL
                    </a>
                    <a href="<?php echo site_url('excel'); ?>" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        Upload File Baru
                    </a>
                </div>
            </div>

            <div class="px-4 py-5 sm:p-6">
                <?php if($this->session->flashdata('success')): ?>
                    <div class="rounded-md bg-green-50 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">
                                    <?php echo $this->session->flashdata('success'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <?php foreach($columns as $column): ?>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <?php 
                                            $display_column = $column;
                                            if (strpos($column, 'col_') === 0) {
                                                $display_column = substr($column, 4); // Hapus 'col_'
                                            }
                                            echo $display_column; 
                                        ?>
                                    </th>
                                <?php endforeach; ?>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach($data as $row): ?>
                                <tr>
                                    <?php foreach($columns as $column): ?>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <?php if($column != 'id'): ?>
                                                <div class="editable" 
                                                     data-id="<?php echo $row['id']; ?>"
                                                     data-column="<?php echo $column; ?>"
                                                     data-table="<?php echo $table_name; ?>">
                                                    <?php echo $row[$column]; ?>
                                                </div>
                                            <?php else: ?>
                                                <?php echo $row[$column]; ?>
                                            <?php endif; ?>
                                        </td>
                                    <?php endforeach; ?>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button onclick="deleteRow(<?php echo $row['id']; ?>)"
                                                class="text-red-600 hover:text-red-900">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Fungsi untuk menghapus baris
function deleteRow(id) {
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?php echo site_url('table/delete'); ?>';
            
            const tableInput = document.createElement('input');
            tableInput.type = 'hidden';
            tableInput.name = 'table_name';
            tableInput.value = '<?php echo $table_name; ?>';
            
            const idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = 'id';
            idInput.value = id;
            
            form.appendChild(tableInput);
            form.appendChild(idInput);
            document.body.appendChild(form);
            form.submit();
        }
    });
}

// Fungsi untuk mengedit data
document.addEventListener('DOMContentLoaded', function() {
    const editables = document.querySelectorAll('.editable');
    
    editables.forEach(element => {
        element.addEventListener('click', function() {
            const currentValue = this.textContent.trim();
            const id = this.dataset.id;
            const column = this.dataset.column;
            const table = this.dataset.table;
            
            Swal.fire({
                title: 'Edit Data',
                input: 'text',
                inputValue: currentValue,
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                showLoaderOnConfirm: true,
                preConfirm: (value) => {
                    return fetch('<?php echo site_url('table/edit'); ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `table_name=${table}&id=${id}&column=${column}&value=${encodeURIComponent(value)}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            return value;
                        }
                        throw new Error('Gagal menyimpan data');
                    })
                    .catch(error => {
                        Swal.showValidationMessage(error.message);
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    this.textContent = result.value;
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Data telah diperbarui',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        });
    });
});
</script>

<?php $this->load->view('templates/footer'); ?> 