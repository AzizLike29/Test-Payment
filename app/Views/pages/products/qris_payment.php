<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="container mx-auto px-4 py-8">
  <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Pembayaran QRIS</h2>
    <p class="text-gray-600 mb-4">Silakan pindai kode QR di bawah ini untuk melakukan pembayaran:</p>
    <div class="text-center">
      <img src="<?= esc($qris_url) ?>" alt="QRIS Code" class="w-64 h-64 mx-auto mb-4">
      <p><strong>Produk:</strong> <?= esc($product_name) ?></p>
      <p><strong>Harga:</strong> Rp <?= number_format($price, 0, ',', '.') ?></p>
      <p><strong>ID Transaksi:</strong> <?= esc($transaction_id) ?></p>
    </div>
    <a href="<?= base_url('product') ?>" class="block mt-6 text-center bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700">
      Kembali ke Produk
    </a>
  </div>
</div>
<?= $this->endSection() ?>