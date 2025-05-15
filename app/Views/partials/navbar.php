<nav class="bg-gray-800 shadow-lg">
  <div class="max-w-7xl mx-auto px-4">
    <div class="flex justify-between h-16">
      <div class="flex items-center">
        <a href="<?= base_url('/') ?>" class="text-white font-bold text-xl">E-Commerce</a>
      </div>

      <!-- Desktop -->
      <div class="flex items-center">
        <div class="flex items-baseline space-x-4">
          <a href="<?= base_url('/') ?>" class="<?= uri_string() == '' ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> px-3 py-2 rounded-md text-sm font-medium">Home</a>
          <a href="<?= base_url('/winpay/response') ?>" class="<?= uri_string() == 'winpay/response' ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> px-3 py-2 rounded-md text-sm font-medium">Payment Result</a>
          <a href="<?= base_url('products') ?>"
            class="<?= uri_string() == 'products' ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> px-3 py-2 rounded-md text-sm font-medium">
            Products
          </a>
          <a href="<?= base_url('products/results') ?>""
            class=" <?= uri_string() == 'products/results' ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> px-3 py-2 rounded-md text-sm font-medium">
            Lihat Data Products
          </a>
        </div>
      </div>
    </div>
  </div>
</nav>