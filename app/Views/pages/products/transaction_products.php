<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="container mx-auto px-4 py-8">
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
    <!-- Samsung product -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden p-4">
      <img src="/assets/img/Samsung-3.png" alt="Samsung Galaxy S24 Ultra" class="w-full h-48 object-contain mb-4">
      <h3 class="text-xl font-bold text-gray-800">Samsung Galaxy S24 Ultra</h3>
      <p class="text-gray-600 mt-2">6.8" Dynamic AMOLED Display, 512GB Storage, 12GB RAM, 200MP Camera</p>
      <div class="mt-4 flex items-center justify-between">
        <span class="text-xl font-bold text-indigo-600">Rp 21.999.000</span>
        <form action="<?= base_url('product/createQrisWinpay') ?>" method="POST">
          <input type="hidden" name="product_name" value="Samsung Galaxy S24 Ultra">
          <input type="hidden" name="price" value="21999000">
          <button class="bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700">
            Bayar Sekarang
          </button>
        </form>
      </div>
    </div>
    <!-- Vivo product -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden p-4">
      <img src="/assets/img/Vivo-1.png" alt="Vivo X100 Pro" class="w-full h-48 object-contain mb-4">
      <h3 class="text-xl font-bold text-gray-800">Vivo X100 Pro</h3>
      <p class="text-gray-600 mt-2">6.78" AMOLED Display, 256GB Storage, 12GB RAM, Zeiss Optics</p>
      <div class="mt-4 flex items-center justify-between">
        <span class="text-xl font-bold text-indigo-600">Rp 14.999.000</span>
        <form action="<?= base_url('product/createQrisWinpay') ?>" method="POST">
          <input type="hidden" name="product_name" value="Vivo X100 Pro">
          <input type="hidden" name="price" value="14999000">
          <button class="bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700">
            Bayar Sekarang
          </button>
        </form>
      </div>
    </div>
    <!-- Xiaomi product -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden p-4">
      <img src="/assets/img/Xioami-2.png" alt="Xiaomi 13T Pro" class="w-full h-48 object-contain mb-4">
      <h3 class="text-xl font-bold text-gray-800">Xiaomi 13T Pro</h3>
      <p class="text-gray-600 mt-2">6.67" AMOLED Display, 256GB Storage, 8GB RAM, Leica Optics</p>
      <div class="mt-4 flex items-center justify-between">
        <span class="text-xl font-bold text-indigo-600">Rp 9.999.000</span>
        <form action="<?= base_url('product/createQrisWinpay') ?>" method="POST">
          <input type="hidden" name="product_name" value="Xiaomi 13T Pro">
          <input type="hidden" name="price" value="9999000">
          <button class="bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700">
            Bayar Sekarang
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>