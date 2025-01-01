<?php $this->load->view('templates/header', ['title' => 'Upload Excel']); ?>
<?php $this->load->view('templates/navbar'); ?>

<div class="flex-grow py-6">
    <div id="loading" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white p-5 rounded-lg flex items-center space-x-3">
            <svg class="animate-spin h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-gray-700">Mengupload file...</span>
        </div>
    </div>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                <h3 class="text-2xl font-semibold text-gray-900">
                    Upload File Excel
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    Upload file Excel (.xlsx atau .xls) untuk dikonversi ke database
                </p>
            </div>

            <div class="px-4 py-5 sm:p-6">
                <?php if($this->session->flashdata('error')): ?>
                    <div class="rounded-md bg-red-50 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-red-800">
                                    <?php echo $this->session->flashdata('error'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

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

                <?php echo form_open_multipart('excel/upload', ['class' => 'space-y-4', 'id' => 'uploadForm']); ?>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Pilih File Excel
                        </label>
                        <div id="dropZone" 
                             class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md transition-colors duration-200 ease-in-out">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="excel_file" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span>Upload file</span>
                                        <input id="excel_file" name="excel_file" type="file" class="sr-only" accept=".xlsx,.xls" required>
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    XLSX, XLS hingga 5MB
                                </p>
                                <p id="selectedFileName" class="text-sm text-gray-600 mt-2"></p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Upload
                        </button>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('excel_file');
    const selectedFileName = document.getElementById('selectedFileName');
    const form = document.getElementById('uploadForm');
    const loadingOverlay = document.getElementById('loading');

    // Fungsi untuk menampilkan nama file
    function showFileName(file) {
        selectedFileName.textContent = file.name;
        dropZone.classList.add('border-indigo-500');
        dropZone.classList.add('border-2');
    }

    // Fungsi untuk validasi file
    function validateFile(file) {
        const allowedTypes = [
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];
        const maxSize = 5 * 1024 * 1024; // 5MB

        if (!allowedTypes.includes(file.type)) {
            Swal.fire({
                icon: 'error',
                title: 'File tidak valid',
                text: 'Mohon upload file Excel (.xlsx atau .xls)'
            });
            return false;
        }

        if (file.size > maxSize) {
            Swal.fire({
                icon: 'error',
                title: 'File terlalu besar',
                text: 'Ukuran file maksimal 5MB'
            });
            return false;
        }

        return true;
    }

    // Event listener untuk file input
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file && validateFile(file)) {
            showFileName(file);
        }
    });

    // Event listeners untuk drag and drop
    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        dropZone.classList.add('bg-gray-50');
    });

    dropZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        dropZone.classList.remove('bg-gray-50');
    });

    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        dropZone.classList.remove('bg-gray-50');
        
        const file = e.dataTransfer.files[0];
        if (file && validateFile(file)) {
            // Create a new FileList object
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            fileInput.files = dataTransfer.files;
            
            showFileName(file);
        }
    });

    // Event listener untuk form submit
    form.addEventListener('submit', function() {
        if (fileInput.files.length > 0) {
            loadingOverlay.classList.remove('hidden');
        }
    });
});
</script>

<?php $this->load->view('templates/footer'); ?> 