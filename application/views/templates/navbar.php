<nav class="bg-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <a href="<?php echo site_url(); ?>" class="text-xl font-bold text-indigo-600">
                        Excel2DB
                    </a>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <a href="<?php echo site_url('excel'); ?>" 
                       class="<?php echo $this->uri->segment(1) == 'excel' ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'; ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Upload Excel
                    </a>
                    <?php if($this->session->userdata('last_table')): ?>
                    <a href="<?php echo site_url('table/view/'.$this->session->userdata('last_table')); ?>"
                       class="<?php echo $this->uri->segment(1) == 'table' ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'; ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Tabel Terakhir
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                <div class="text-sm text-gray-500">
                    <?php echo date('d F Y'); ?>
                </div>
            </div>
        </div>
    </div>
</nav> 